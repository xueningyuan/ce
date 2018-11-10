<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\userrequest;
use App\Http\Requests\LoginRequest;
use App\Model\User;
use Hash;
use Illuminate\Support\Facades\Cache;
use Flc\Dysms\Client;
use Flc\Dysms\Request\SendSms;
use Illuminate\Support\Facades\Redis;

class UserController extends Controller
{
    public function user(Request $req){
        $user = User::select('users.*','user_grade.grade_name');
        if(isset($req->name)){
            $user->where(function($q) use ($req) {
                $q->where('users.name','like',"%$req->name%")
                    ->orWhere('users.phone','like',"%$req->name%")
                    ->orWhere('users.email','like',"%$req->name%");
            });
        }
        if(isset($req->time)){
            $user->where('users.created_at','like',"$req->time%");
        }
        $user = $user->join('user_grade','users.grade','=','user_grade.id')->paginate();
        // echo $user;exit;
        $select['name']=$req->name;
        $select['time']=$req->time;
        return view('user.list',[
            'user'=>$user,
            'select'=>$select
        ]);
    }

    public function user_typr(Request $req){
        echo "<pre>";
        $user = User::find($req->id);
        echo $user['type'];
        if($user['type']=='启用'){
            $user->where('id',$req->id)->update([
                'type'=>'弃用'
            ]);
        }else{
            $user->where('id',$req->id)->update([
                'type'=>'启用'
            ]);
        }
    }
    public function user_del(Request $req){
        User::where('id',$req->id)->delete();
        echo "ok";
    }

    public function register(){
        return view('user.register');
    }
    public function sns(Request $req){
        $code = rand(100000,999999);

        $name = 'code-'.$req->phone;
        Cache::put($name,$code,1);

       Redis::lpush('sms_list',$req->phone.'-'.$code);
    }
    public function doregister(userrequest $req){
        $name = 'code-'.$req->phone;
        $code = Cache::get($name);
        echo $code;
        // exit;
        if(!$code && $code != $req->mobile_code){
            return back()->withErrors(['mobile_code'=>'验证码错误']);
        }

        $password = Hash::make($req->password);
        $user = new User;
        $user->name = $req->name;
        $user->phone = $req->phone;
        $user->password = $password;
        $user->save();
        return redirect()->route('user_login');

    }
    public function login(){
        return view('user.login');
    }
    public function dologin(LoginRequest $req){
        $req->phone;
        $login = User::where('phone',$req->phone)->first();
        // echo $req->password."<br>";
        // echo Hash::make($req->password)."<br>";
        // echo $login->password."<br>";
        // exit;
        if($login){
            if(Hash::check($req->password,$login->password)){
                session([
                    'user_id'=>$login->id,
                    'name'=>$login->name,
                ]);
                return redirect()->route('index');
            }else{
            return back()->withErrors('密码错误');                
            }
        }else{
             //账号不存在
             return back()->withErrors('账户不存在');
        }
    }
    
}
