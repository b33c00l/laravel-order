<?php

namespace App\Services;

use App\Price;
use App\SpecialOffer;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PricingService
{
    private function countPriceWithCoef($user, $product)
    {
        $new_product = $product->prices()->where('special_offer_id', null)->where('user_id', null)->orderBy('date', 'DESC')->first();
        if ($new_product === null) {
            return PHP_INT_MAX;
        }
        $new_price = $new_product->amount;
        $coef = $user->price_coefficient;
        $price = $new_price * $coef;
        return $price;
    }

    private function countPriceWithSpecialOffer($user, $product)
    {
        $special_offers = $user->specialOffers()->where('expiration_date', '>', Carbon::now('Europe/Vilnius'))->get();

        $ids = $special_offers->pluck('id');

        $price = $product->prices()->whereIn('special_offer_id', $ids)->pluck('amount')->min();
        if ($price === null) {
            return PHP_INT_MAX;
        }
        return $price;
    }

    private function countIndividualPrice($user, $product)
    {
        $individual_price = $user->price()->where('product_id', $product->id)->orderBy('date', 'DESC')->first();
        if ($individual_price === null) {
            return PHP_INT_MAX;
        }

        $price = $individual_price->amount;

        return $price;
    }

    public function getPrice($user, $product)
    {
        $price1 = $this->countPriceWithCoef($user, $product);
        $price2 = $this->countPriceWithSpecialOffer($user, $product);
        $price3 = $this->countIndividualPrice($user, $product);
        $price = collect([$price1, $price2, $price3])->min();
        return $price;
    }
}
