<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = [
        'role',
        'edit_other_posts',
        'del_other_posts',
        'edit_posts',
        'del_posts',
        'edit_publish_posts',
        'del_publish_posts',
        'edit_other_pages',
        'del_other_pages',
        'edit_pages',
        'del_pages',
        'edit_publish_pages',
        'del_publish_pages',
        'publish_posts',
        'publish_pages',
        'manage_category',
        'create_user',
        'edit_user',
        'del_user',
        'promote_user',
        'list_user'
    ];
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
