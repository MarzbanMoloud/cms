<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = [
        'role',

        'dashboard',

        'edit_posts',
        'del_posts',
        'create_posts',

        'edit_pages',
        'del_pages',
        'create_pages',

        'manage_category',

        'create_user',
        'manage_user',

        'promote_user',
    ];
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
