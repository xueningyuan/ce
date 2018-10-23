<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'category';
    public $timestamps=false;    
    protected $fillable =['cat_name','parent_id','path'];
}
