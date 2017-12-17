<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Category extends Model
{
    use Sortable;

    protected $fillable = [
        'catName'
    ];
    public $sortable = [ 'catName', 'created_at', 'updated_at'];
    public function posts(){
        return $this->hasMany(Post::class);
    }

}
