<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BedroomImage extends Model
{
    //
    protected $table = 'bedroom_images';
    protected $primaryKey = 'bedroom_image_id';
    protected $guarded = [];

    public function bedroom(){
    	return $this->belongsTo('App\Models\BedRoom','bedroom_image_bedroom_id');
    }
}
