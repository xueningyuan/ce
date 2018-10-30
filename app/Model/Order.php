<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    public $timestamps=false;    
    protected $fillable =['goods_id','type','created_at','sum','count','sn','user_id'];
}
