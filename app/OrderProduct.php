<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    public $timestamps = false;
    protected $fillable = ['quantity','product_id','price'];

    public function product()
    {
        return $this->belongsTo(Product::class)->withTrashed();
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function scopeInOrders($query, $orders_id)
    {
        return $query->whereIn('order_id', $orders_id);
    }

    public function scopeInProduct($query, $product_id)
    {
        return $query->where('product_id', $product_id);
    }
}
