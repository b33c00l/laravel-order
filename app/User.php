<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'password',
        'role',
        'client_id',
        'price_coefficient',
        'disabled',
        'country_id'
    ];

    public $timestamps = false;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function price()
    {
        return $this->hasMany(Price::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function specialOffers()
    {
        return $this->belongsToMany(SpecialOffer::class, 'special_offer_user');
    }


    public function country()
    {
        return $this->belongsTo(Country::class);
    }

	public function getUserOrderAttribute(  ) {
		if (!empty($this->orders->where('status',0)->first())){
			return $this->orders->where('status', 0)->first();
		}else{
			return false;
		}
    }
}
