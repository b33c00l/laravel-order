<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'vat_number',
        'registration_number',
        'registration_address',
        'shipping_address',
        'email',
        'contact_person',
        'phone',
        'payment_terms'
    ];

    public $timestamps = false;

    public function user()
    {
        return $this->hasOne(User::class);
    }
}
