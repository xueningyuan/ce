<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hash;
use App\Model\Admin_users;


class AdminController extends Controller
{
    public function index(){
        return view('admin.index');
    }
    public function home(){
        return view('admin.home');
    }
    public function istrator(){
        $admin_user = Admin_users::get();
        return view('admin.administrator',[
            'admin_user'=>$admin_user,
        ]);
    }

    public function info(){
        $id = session('id');
        $user = Admin_users::find($id);
        return view('admin.admin_info',[
            'user'=>$user
        ]);
    }
    public function doinfo(Request $reg){
        $id = session('id');
        // var_dump($reg->all());exit;
        Admin_users::where('id',$id)
            ->update(['name'=>$reg->name,'sex'=>$reg->sex,'old'=>$reg->old,'phone'=>$reg->phone,'email'=>$reg->email,'qq'=>$reg->qq]);
        return redirect()->route('admin_info');
    }

















}
