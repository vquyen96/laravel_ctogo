<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $table = 'articel';
    protected $primaryKey = 'id';
    protected $guarded = [];
}