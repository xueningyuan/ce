<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Goods_attribute extends Model
{
    protected $table = 'goods_attribute';
    public $timestamps=false;    
    protected $fillable =['attr_name','attr_value','goods_id'];
}
