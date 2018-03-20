<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable=['filename', 'order_id'];

    public $timestamps=false;
}
