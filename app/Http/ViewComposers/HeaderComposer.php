<?php
namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;


class HeaderComposer {

    public function compose(View $view) {

        $user = Auth::user();
        $email = $user->country->email;
        $phone = $user->country->phone;
        $view->with(['email' => $email, 'phone' => $phone]);

    }

}