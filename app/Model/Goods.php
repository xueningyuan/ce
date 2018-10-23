<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Goods extends Model
{   
    protected $table = 'goods_sku';
    public $timestamps=false;    
    protected $fillable =['goods_name','logo','is_on_sale','description','cat1_id','cat2_id','cat3_id','brand_id'];
}
