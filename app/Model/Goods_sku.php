<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Goods_sku extends Model
{
    protected $table = 'goods_sku';
    public $timestamps=false;    
    protected $fillable =['goods_id','sku_name','stock','price','attr_value'];
}
