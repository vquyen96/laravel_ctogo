<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Host extends Model
{
    //
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $guarded = [];

    public function homestay(){
        return $this->hasMany(HomeStay::class,'homestay_user_id');
    }
}
