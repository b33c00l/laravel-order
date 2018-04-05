<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cache;

class Price extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'amount',
        'date',
        'product_id',
        'user_id'
    ];

    public function products()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    protected static function boot()
    {
        parent::boot();

        $clearCache = function (self $item) {
            Cache::tags('product:'. $item->products->id)->flush();
        };

        static::created($clearCache);
        static::updated($clearCache);
        static::deleting($clearCache);
    }

}
