<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    const ACTIVE = 1;
    const INACTIVE = 0;

    protected $fillable = [
        'topic',
        'user_id',
        'admin_id',
        'status',
        'order_id'
    ];

    public function messages()
    {
        return $this->hasMany(ChatMessage::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
