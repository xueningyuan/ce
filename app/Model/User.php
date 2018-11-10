<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    public $timestamps=false;    
    protected $fillable =['name','password','phone','email','address'];
}
