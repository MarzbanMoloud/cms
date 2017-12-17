<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Post extends Model
{
    use Sortable;
    public $sortable = [ 'title', 'created_at', 'updated_at'];
    protected $fillable = [
        'category_id', 'discount_id', 'group_id', 'title','detail','quantity','price','photo','published','user_id'
    ];
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function discount()
    {
        return $this->belongsTo(Discount::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
