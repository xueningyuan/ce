<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Goods_image extends Model
{
    protected $table = 'goods_image';
    public $timestamps=false;    
    protected $fillable =['goods_id','path'];
}
