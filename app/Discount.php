<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    protected $fillable = [
        'discountPercent',
    ];
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
