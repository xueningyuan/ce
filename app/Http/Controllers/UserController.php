<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\User;

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
    
    
}
