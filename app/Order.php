<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable=['user_id','product_id','totalPrice','qty','trackingCode'];
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function user()
    {
       return $this->belongsTo(User::class);
    }
}
