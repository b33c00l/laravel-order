<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public $timestamps = false;
    protected $fillable = ['name', 'platform_id', 'publisher_id', 'ean', 'description', 'release_date', 'video', 'pegi'];

    public function category()
    {
        return $this->belongsToMany(Category::class);
    }
    public function image()
    {
        return $this->hasMany(Image::class);
    }
}
