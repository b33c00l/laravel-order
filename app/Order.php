<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    const PENDING = 0;
    const UNCONFIRMED = 1;
    const CONFIRMED = 2;
    const REJECTED = 3;
    const ORDER = 0;
    const PREORDER = 1;
    const BACKORDER = 2;

    public $timestamps = false;

    protected $fillable = ['status','type'];

    public function orderProducts()
    {
        return $this->hasMany(OrderProduct::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function scopeAsCart($query)
    {
        return $query->where('status', Order::PENDING)->where('type', Order::ORDER);
    }

    public function getOrderTypeAttribute()
    {
        if ($this->type === Order::ORDER) {
            return "Order";
        }  elseif ($this->type === Order::PREORDER) {
            return "Pre-order";
        }  else {
            return "Back-order";
        }
    }

    public function getOrderStatusAttribute()
    {
        if ($this->status === Order::PENDING) {
            return "Pending";
        }  elseif ($this->status === Order::UNCONFIRMED) {
            return "Unconfirmed";
        }  elseif($this->status == Order::CONFIRMED) {
            return "Confirmed";
        } else {
            return "Rejected";
        }
    }
	
	public function scopeInCart($query)
	{
		return $query->where('status', Order::PENDING);
	}

    public function chat()
    {
        return $this->hasOne(Chat::class);
    }

    public function scopeAsCartBackOrder($query)
    {
        return $query->where('type', Order::BACKORDER)->where('status', Order::PENDING);
    }

    public function scopeAsCartPreorder($query){
        return $query->where('type', Order::PREORDER)->where('status', Order::PENDING);
    }

}
