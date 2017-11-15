<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    protected $fillable = [
        'name'
    ];
    public function pages()
    {
        return $this->hasMany(Page::class);
    }
}
