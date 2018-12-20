<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    const TIME_ORDER = 120;
    const STATUS_1 = 1; // trong thời gian thanh toán
    const STATUS_2 = 2; // hết thời gian thanh toán
    const STATUS_3 = 3; // hoàn thành
    const STATUS_4 = 4; // hủy


    const THE_TIN_DUNG = 1;
    const TRUC_TUYEN = 2;
    const CHUYEN_KHOAN = 3;

    protected $table = 'books';
    protected $primaryKey = 'book_id';
    protected $guarded = [];

    public function bedroom(){
    	return $this->belongsTo('App\Models\BedRoom','book_bedroom_id')->get();
    }
    public function user(){
    	return $this->belongsTo('App\Models\User','book_user_id');
    }
}