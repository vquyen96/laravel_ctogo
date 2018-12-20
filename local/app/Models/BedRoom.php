<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BedRoom extends Model
{
    //
    protected $table = 'bedrooms';
    protected $primaryKey = 'bedroom_id';
    protected $guarded = [];

    public function homestay(){
    	return $this->belongsTo('App\Models\HomeStay','bedroom_homestay_id');
    }

    public function discount(){
    	return $this->hasMany('App\Models\Discount','discount_bedroom_id');
    }

    public function bedroomimage(){
    	return $this->hasMany('App\Models\BedroomImage','bedroom_image_bedroom_id');
    }

    public function book(){
    	return $this->hasMany('App\Models\Book','book_bedroom_id');
    }
}
