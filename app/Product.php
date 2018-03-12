<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public $timestamps = false;
    protected $fillable = ['name', 'platform_id', 'publisher_id', 'ean', 'description', 'release_date', 'video', 'pegi'];

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function images()
    {
        return $this->hasMany(Image::class);
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
        return $this->stock->last()->amount;
    }

    public function getPriceAmountAttribute()
    {
        return $this->prices->last()->amount;
    }

    public function getFeaturedImageAttribute()
    {
        if ($this->images()->where('featured', 1)->exists()) {
            return $this->images()->where('featured', 1)->first();
        } else {
            return null;
        }
    }

    public function getFeaturedImageUrlAttribute()
    {
        if($this->getFeaturedImageAttribute() != null ) {
            $path = 'storage/image/';
            $path .= $this->getFeaturedImageAttribute()->filename;
        } else {
            $path = 'image/default_featured.png';
        }
        return asset($path);
    }


}
