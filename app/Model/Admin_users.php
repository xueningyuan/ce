<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Admin_users extends Model
{
    protected $table = 'admin_users';
    public $timestamps=false;    
    protected $fillable =['admin_name','type','qq','email','phone','name','old','sex','password'];
}
