<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = [
        'title', 'body' , 'type_id'
    ];

    public function type()
    {
        return $this->belongsTo(Type::class);
    }
}
