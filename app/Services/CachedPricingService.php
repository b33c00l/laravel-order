<?php

namespace App\Services;

use Cache;

class CachedPricingService extends PricingService
{
    public function getPrice($user, $product)
    {
        $key = 'price-'. $user->id .'-'. $product->id;
        $tags = ['product-' . $product->id, 'user-' . $user->id];
        $value = Cache::tags($tags)->get($key);

        if ($value != null) {
            return $value;
        }

        $price = parent::getPrice($user, $product);

        Cache::tags($tags)->put($key, $price, 10080);

        return $price;
    }

}