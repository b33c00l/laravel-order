<?php

namespace App\Http\ViewComposers;


use App\SpecialOffer;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class BannerComposer
{
    public function compose(View $view)
    {
        $user = Auth::user();
        $offers = SpecialOffer::all();
        if ($user->role != 'admin') {
            $offers = $user->specialOffers()->where('expiration_date', '>', Carbon::now('Europe/Vilnius'))->get();
        }
        $view->with(['offers' => $offers]);
    }
}