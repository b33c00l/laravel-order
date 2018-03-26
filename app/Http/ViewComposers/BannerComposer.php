<?php

namespace App\Http\ViewComposers;



use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class BannerComposer
{
    /**
     * @param View $view
     */
    public function compose(View $view)
    {
        $user = Auth::user();
        $offers = $user->specialOffers;

        $view->with(['offers'=> $offers]);
    }
}