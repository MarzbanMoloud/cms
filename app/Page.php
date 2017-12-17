<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Page extends Model
{
    use Sortable;

    public $sortable = [ 'title', 'created_at', 'updated_at'];

    const MAINPAGE = 1 ;
    const ABOUTUS = 2 ;

    protected $fillable = [
        'title', 'body' , 'type_id' ,'published' , 'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function getTypes(){
        return[
          self::MAINPAGE => 'صفحه اصلی',
          self::ABOUTUS => 'درباره ما'
        ];
    }
}
