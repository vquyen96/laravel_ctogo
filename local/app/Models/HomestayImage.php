<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomestayImage extends Model
{
    //
    protected $table = 'homestay_images';
    protected $primaryKey = 'homestay_image_id';
    protected $guarded = [];

    public function homestay(){
    	return $this->belongsTo('App\Models\HomeStay','homestay_image_homestay_id');
    }

}
