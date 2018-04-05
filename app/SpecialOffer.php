<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SpecialOffer extends Model
{
    protected $fillable = [
        'expiration_date',
        'description',
        'filename',
        'name'
    ];
    public $timestamps = false;

    public function prices()
    {
        return $this->hasMany(Price::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'special_offer_user');
    }
}
