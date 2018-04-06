<?php

namespace App\Services;

use App\Category;
use App\OrderProduct;
use App\Order;
use App\Platform;
use App\Product;
use App\Publisher;
use Carbon\Carbon;
use DOMDocument;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Messerli90\IGDB\Facades\IGDB;

class UploadToDatabase
{
    protected $publisher;

    public function getFile($filename)
    {
        return Excel::load($filename)->noHeading()->skipRows(6)->all();
    }

    public function parseItem($game)
    {
        $this->importPlatforms($game);
        return $this->importProductsStockPrices($game);
    }

    public function importPlatforms($game)
    {
        $names=[];

        $name = explode('_', $game[1]);
        $names[] = $name[0];

        $platform_names = array_unique($names);

        $platform_collection = collect($platform_names);

        $existing_names = Platform::all();
        $platforms = $existing_names->pluck('name');
        $diff = $platform_collection->diff($platforms);

        $new_platforms = $diff->all();

        // platforms
        foreach ($new_platforms as $new_platform) {
            Platform::create(['name' => $new_platform]);
        }
    }

    public function importProductsStockPrices($game)
    {
        $name = explode('_', $game[1]);
        $platform = Platform::where('name', $name)->first();
        $products = Product::all('ean');
        $products_eans= $products->pluck('ean');

        if ($products_eans->contains($game[0]) !== true) {
            $name = explode(' ', $game[2], 2);
            $data = $this->importFromApi($game);

            $publisher = $this->getPublishers();
            if ($publisher === null) {
                $publisher_id = null;
            } else {
                $publisher_id = $publisher->id;
            }
            $product = $platform->products()->create(['ean' => $game[0], 'name' => $name[1], 'publisher_id' => $publisher_id] + $data); //Name
            $this->importCovers($game, $product);
            $this->importScreenshots($game, $product);
        } else {
            $product = Product::where('ean', $game[0])->first();
        }
        if ($product->preorder === Product::DISABLED)
        {
            $product->update(['preorder' => 0]);
            $this->preOrderToOrder($product);
        }
        $product->stock()->create(['amount' => $game[4], 'date' => Carbon::now()]); // Stock
        $product->prices()->create(['amount' => $game[3], 'date' => Carbon::now()]); //Price
        return $product;
    }

    public function importFromApi($game)
    {
        $game = $this->allGames($game);

        if (isset($game->summary)) {
            $summary = $game->summary;
        } else {
            $summary = null;
        }

        if (isset($game->first_release_date)) {
            $release_date = $game->first_release_date;
            $date = Carbon::createFromTimestamp(($release_date / 1000))->toDateTimeString();
        } else {
            $date = null;
        }

        if (isset($game->pegi->rating)) {
            $pegi = $game->pegi->rating;
        } else {
            $pegi = null;
        }

        if (isset($game->videos[0]->video_id)) {
            $video = 'https://www.youtube.com/watch?v=' . $game->videos[0]->video_id;
        } else {
            $video = null;
        }
        if (!isset($game->publishers)) {
            $publisher_id = null;
        } else {
            $publisher_id = $game->publishers[0];
        }

        if ($publisher_id === null) {
            $this->publisher = null;
        }
        $publisher = IGDB::getCompany($publisher_id);
        $this->publisher = $publisher->name;

        return $data = [
            'description' => $summary,
            'release_date' => $date,
            'video' =>  $video,
            'pegi' => $pegi
        ];
    }

    public function validate($game)
    {
            $validator = Validator::make(
                $game,
                [
                    0 => 'required|numeric',
                    1 => 'required',
                    2 => 'required',
                    3 => 'required|numeric',
                    4 => 'required|integer|min:1',
                ],
                [
                    0 . '.required' => 'EAN code is required.',
                    0 . '.numeric' => 'EAN must be numeric.',
                    1 . '.required' => 'Platform is required.',
                    2 . '.required' => 'Title is required.',
                    3 . '.required' => 'Price is required.',
                    3 . '.numeric' => 'Check your price fields.',
                    4 . '.required' => 'Stock is required.',
                    4 . '.integer' => 'Stock must be whole number.',
                    4 . '.min' => 'Stock can not be 0 or negative number.',
                ]
            );

        if ($validator->fails()) {
            return $validator->errors()->first();
        }
    }

    public function getPublishers()
    {
        $pub = Publisher::where('name', $this->publisher)->first();
        if ($this->publisher === null) {
            return;
        }

        if ($pub === null) {
            $publisher =  Publisher::create(['name' => $this->publisher]);
        } else {
            $publisher = Publisher::where('name', $this->publisher)->first();
        }

        return $publisher;
    }

    public function importGenres($game, $id)
    {
        $game = $this->allGames($game);

        if (isset($game->genres)) {
            foreach ($game->genres as $genre) {
                $cat = IGDB::getGenre($genre);
                $category_name = Category::where('name', $cat->name)->first();

                if ($category_name === null) {
                    $category = Category::create(['name' => $cat->name]);
                    $category->products()->attach($id);
                } else {
                    $category_name->products()->attach($id);
                }
            }
        }
    }

    public function allGames($game)
    {
        $game_name = explode(' ', $game[2], 2);
        $name = $game_name[1];

        $all_games = IGDB::searchGames($name);

        if ($all_games === null) {
            return 'Api not working.';
        }

        $games = collect($all_games);
        return $games->first();
    }

    public function getCover($game)
    {
        $game = $this->allGames($game);
        if (!isset($game->cover)) {
            return;
        }
        $url = $game->cover;
        $filename = basename($url->url);
        $file = file_get_contents('https://images.igdb.com/igdb/image/upload/t_original/'.$filename);
        Storage::put('public/image/' . $filename, $file);
        return $filename;
    }

    public function getScreenshots($game)
    {
        $game = $this->allGames($game);
        if (isset($game->screenshots)) {
            $count = 1;
            $fnames = [];
            foreach ($game->screenshots as $screenshot) {
                if ($count == 4) {
                    break;
                }
                $url = $screenshot->url;
                $count++;
                $filename = basename($url);
                $fnames[] = $filename;
                $file = file_get_contents('https://images.igdb.com/igdb/image/upload/t_original/'.$filename);
                Storage::put('public/image/' . $filename, $file);
            }
            return $fnames;
        }
    }

    public function importScreenshots($game, $product)
    {
        $screenshots=$this->getScreenshots($game);

        if ($screenshots !== null) {
            foreach ($screenshots as $screenshot) {
                $product->images()->create([
                    'filename' => $screenshot,
                    'product_id' => $product->id,
                    'featured' => 0
                ]);
            }
        }
    }

    public function importCovers($game, $product)
    {
        $this->importGenres($game, $product->id);

        $filename = $this->getCover($game);
        if ($filename !== null) {
            $product->images()->create([
                'filename' => $filename,
                'product_id' => $product->id,
                'featured' => 1
            ]);
        }
    }

    public function preOrderToOrder($product)
    {
        $orderProducts = OrderProduct::where('product_id', $product->id)->get();
        if ($orderProducts->count() > 0)
        {
            foreach ($orderProducts as $orderProduct)
            {
                $preorder = $orderProduct->order()->UnconfirmedOrder()->preorder()->first();
                if (isset($preorder))
                {
                    $user = $orderProduct->order->user;
                    $order = $user->orders()->InCart()->Order()->first();
                    if (isset($order))
                    {
                        $orderProduct->update(['order_id' => $order->id]);
                    }else{
                        $order = $this->createOrder($user);
                        $orderProduct->update(['order_id' => $order->id]);
                    }
                    if ($preorder->orderProducts->isEmpty())
                    {
                        $preorder->delete();
                    }
                }
            }
        }
    }

    public function createOrder($user)
    {
        $order = $user->orders()->create([
            'status' => Order::PENDING,
            'date' => Carbon::now(),
            'type' => Order::ORDER
        ]);
        return $order;
    }
}
