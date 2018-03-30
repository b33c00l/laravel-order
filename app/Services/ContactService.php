<?php

namespace App\Services;

use App\Country;
use Illuminate\Support\Facades\Auth;

class ContactService {

    public function getEmailForCountry($country = null) {
        if ($country == null) {
            $default_country = Country::where('default', 1)->first();
            if($default_country !== null) {
                $email = $default_country->email;
            } else {
                $email = config('mail.from.address');
            }
        } else {
            $email = $country->email;
        }
        return $email;
    }
}