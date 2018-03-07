<?php

use Illuminate\Database\Seeder;
use Messerli90\IGDB\Facades\IGDB;
use App\Category;
use App\Publisher;
use App\Product;
use App\Platform;
use Illuminate\Support\Facades\Storage;

class ProductsSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $games = IGDB::getGame('');
        foreach ($games->games as $game) {
            $game_data = IGDB::getGame($game);
            $categories_array = [];
            $publisher_array = [];
            $platform_array = [];
            foreach ($game_data->genres as $genre) {

                $category_g = IGDB::getGenre($genre);
                if (count(Category::where('name', $category_g->name)->get()) < 1) {
                    $category_data_g = Category::create([
                        'name' => $category_g->name
                    ]);
                    $categories_array[] = $category_data_g->id;
                }

            }
            foreach ($game_data->themes as $theme) {
                $category_t = IGDB::getTheme($theme);
                if (count(Category::where('name', $category_t->name)->get()) < 1) {
                    $category_data_t = Category::create([
                        'name' => $category_t->name
                    ]);
                    $categories_array[] = $category_data_t->id;
                }

            }
            if (isset($game_data->publishers)) {
                foreach ($game_data->publishers as $publisher) {
                    $companies = IGDB::getCompany($publisher);
                    if (count(Publisher::where('name', $companies->name)->get()) < 1) {
                        $publisher_data = Publisher::create([
                            'name' => $companies->name
                        ]);
                        $publisher_array[] = $publisher_data->id;
                    }

                }
            }
            if (isset($game_data->platforms)) {
                foreach ($game_data->platforms as $platform) {
                    $platform_data = IGDB::getPlatform($platform);
                    if (count(Platform::where('name', $platform_data->name)->get()) < 1) {
                        $platform_data_a = Platform::create([
                            'name' => $platform_data->name
                        ]);
                        $platform_array[] = $platform_data_a->id;
                    }

                }
            }

            foreach ($platform_array as $platform_id) {
                if (!empty($publisher_array[0])){
                    $pub = $publisher_array[0];
                }else{
                    $pub = 1;
                }
                if (empty($game_data->release_dates[0])) {
                    $date = '';
                } else {
                    $date = $game_data->release_dates[0]->y . '-01-01';
                }
                if (empty($game_data->videos[0])){
                    $video_url = '';
                }else{
                    $video_url = 'https://www.youtube.com/embed/'.$game_data->videos[0]->video_id;
                }
                $product = Product::create([
                    'platform_id' => $platform_id,
                    'publisher_id' => $pub,
                    'ean' => rand(1000000000000, 9999999999999),
                    'name' => $game_data->name,
                    'description' => $game_data->summary,
                    'release_date' => $date,
                    'video' => $video_url,
                    'pegi' => rand(3, 18),

                ]);

                $product->category()->attach($categories_array);



                $url = $game_data->cover->url;

                $filename = basename($url);
                $file = file_get_contents('https://images.igdb.com/igdb/image/upload/t_original/'.$filename);
                Storage::put('public/image/' . $filename, $file);
                $product->image()->create([
                    'filename' => $filename,
                    'product_id' => $product->id,
                    'featured' => 1,
                ]);

                for ($i = 0 ; $i < 3; $i++)
                {
                    $url = $game_data->screenshots[$i]->url;

                    $filename = basename($url);
                    $file = file_get_contents('https://images.igdb.com/igdb/image/upload/t_original/'.$filename);
                    Storage::put('public/image/' . $filename, $file);
                    $product->image()->create([
                        'filename' => $filename,
                        'product_id' => $product->id,
                        'featured' => 0,
                    ]);
                }
            }

        }
    }
}
