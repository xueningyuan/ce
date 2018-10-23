<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Gregwar\Captcha\CaptchaBuilder;
use Hash;
use App\Model\Admin_users;

class loginController extends Controller
{   
    public function captcha(){
        $captcha = new CaptchaBuilder;
        $captcha->build();

        $code = $captcha->getPhrase();
        session([
            'captcha'=>$code,
        ]);
        return response($captcha->output() )->header('Content-Type','image/jpeg');
    }
    public function login(){
        return view('login.login');
    }
    public function dologin(Request $req){
        $captcha =  $req->session()->pull('captcha');
        if($captcha!=$req->captcha){
            return back()->withErrors('验证码错误');
        }
         //通过手机号，查询用户信息
         $user = Admin_users::where('admin_name',$req->admin_name)->first();
         // 判断账号是否存在
         if($user){
             // 判断密码：
             if(Hash::check($req->password,$user->password)){
                 session([
                     'id'=>$user->id,
                     'admin_name'=>$user->admin_name
                 ]);
                 echo "ok";
                 return redirect()->route('admin_index');
             }else{
                 
                return back()->withErrors('密码错误');                
             }
         }else{
             //账号不存在
             return back()->withErrors('账户不存在');
         }
 
     }
}
