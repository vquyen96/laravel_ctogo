<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    protected $table = "configs";
    protected $guarded = [];
    public $timestamps = false;

    public function getBanner()
    {
        return $this->where('name','banner')->firstOrFail();
    }

    public function getInfo()
    {
        return $this->where('name','info')->firstOrFail();
    }

    public function getTerm()
    {
        return $this->where('name','term')->firstOrFail();
    }

    public function getPolicy()
    {
        return $this->where('name','policy')->firstOrFail();
    }

}
