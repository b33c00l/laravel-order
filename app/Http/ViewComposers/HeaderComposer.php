<?php
namespace App\Http\ViewComposers;

use App\Country;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;


class HeaderComposer {

    public function compose(View $view) {

        $user = Auth::user();
        $default_country = Country::where('default', 1)->first();

        if(empty($user->country)){
            if($default_country == null) {
                $email = 'paulius@gamestar.lt';
                $phone = '869889141';
                $view->with(['email' => $email, 'phone' => $phone]);
           } else {
                $email = $default_country->email;
                $phone = $default_country->phone;
                $view->with(['email' => $email, 'phone' => $phone]);
            }
        }else {
            $email = $user->country->email;
            $phone = $user->country->phone;
            $view->with(['email' => $email, 'phone' => $phone]);
        }
    }
}