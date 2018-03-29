<?php

namespace App;

use App\Services\PricingService;
use Illuminate\Database\Eloquent\Model;
use ScoutElastic\Searchable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use Searchable;

    use SoftDeletes;

    protected $with = ['platform', 'categories', 'publisher', 'prices', 'stock'];
    protected $searchRules = [MySearchRule::class];
    public $timestamps = false;
    protected $fillable = ['name', 'platform_id', 'publisher_id', 'ean', 'description', 'release_date', 'video', 'pegi', 'preorder', 'deadline'];
    protected $indexConfigurator = MyIndexConfigurator::class;

    protected $mapping = [
        'properties' => [
            "suggest" => [
                "type" => "completion"
            ],
            'name' => [
                'type' => 'text',
                "analyzer" => "simple",
            ],
            'ean' => ['type' => 'text'],
        ]
    ];

    public function searchableAs()
    {
        return 'products_index';
    }

    public function toSearchableArray()
    {
        $suggestArray[] = $this->name;
        $suggestArray[] = $this->platform->name;
        if (isset($this->publisher->name)){
            $suggestArray[] = $this->publisher->name;
        }
        $splittingName = $this->name;
        while (strpos($splittingName, ' ') !== false) {
            $suggestionSplit = explode(' ', $splittingName, 2);
            $splittingName = $suggestionSplit[1];
            $suggestArray[] = $splittingName;
        }
        $array = [
            'id'        => $this->id,
            'name'      => $this->name,
            'ean'       => $this->ean,
            'platform'  => $this->platform->name,
            'suggest' => [
                'input' => $suggestArray,
            ]
        ];

        if(isset($this->publisher->name)) {
            $array['publisher'] = $this->publisher->name;
        }

        return $array;
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function importItems()
    {
        return $this->hasMany(ImportItem::class);
    }

    public function platform()
    {
        return $this->belongsTo(Platform::class);
    }

    public function publisher()
    {
        return $this->belongsTo(Publisher::class);
    }

    public function stock()
    {
        return $this->hasMany(Stock::class);
    }

    public function prices()
    {
        return $this->hasMany(Price::class);
    }

    public function getYoutubeEmbedAttribute()
    {
        if(!empty($this->video)) {
            if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i',
                $this->video, $match)) {
                $video_id = $match[1];
                $result = '<iframe width="560" height="315" src="https://www.youtube.com/embed/' . $video_id . '"
                frameborder="0" allow="autoplay; encrypted-media" allowfullscreen>
                </iframe>';
            } else {
                $result = "Link is corrupted";
            }
        }
        else {
            $result = "-";
        }
        return $result;
    }

    public function getStockAmountAttribute()
    {
        if (isset($this->stock->last()->amount)) {
            return $this->stock->last()->amount;
        } else {
            return 0;
        }
    }

    public function getPriceAmountAttribute()
    {
        return app(PricingService::class)->getPrice(auth()->user(),$this);
    }

    public function getFeaturedImageAttribute()
    {
        if ($this->images->where('featured', 1)->first()) {
            return $this->images->where('featured', 1)->first();
        } else {
            return null;
        }
    }

    public function getFeaturedImageUrlAttribute()
    {
        if($this->featured_image != null ) {
            return $this->featured_image->url;
        }
        $path = 'image/default_featured.png';
        return asset($path);
    }


}
