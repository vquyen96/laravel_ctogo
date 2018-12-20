<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    //
    protected $table = 'guest_users';
    protected $primaryKey = 'id';
    protected $guarded = [];

    public function book()
    {
    	return $this->hasMany('App\Models\Book','book_user_id');
    }

    public function comment()
    {
    	return $this->hasMany('App\Models\Comment','comment_user_id');
    }
}
