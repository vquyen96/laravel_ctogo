<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    //
    protected $table = 'discount';
    protected $primaryKey = 'discount_id';
    protected $guarded = [];

    public function bedroom(){
    	return $this->belongsTo('App\Models\BedRoom','discount_bedroom_id');
    }
}