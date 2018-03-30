<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'name',
        'email',
        'phone',
        'default'
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
