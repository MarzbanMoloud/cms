<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    protected $fillable = [
        'discountPercent',
    ];
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
