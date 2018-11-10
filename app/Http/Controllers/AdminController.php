<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hash;
use App\Model\Admin_users;
use App\Model\Role;
use App\Model\Privilege;

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
        $role = Role::get();
        return view('admin.administrator',[
            'admin_user'=>$admin_user,
            'role'=>$role
        ]);
    }

    public function admin_type(Request $req){
        $user = Admin_users::find($req->id);
        if($user['admin_type']=='0'){
            $user->where('id',$req->id)->update([
                'admin_type'=>'1'
            ]);
        }else{
            $user->where('id',$req->id)->update([
                'admin_type'=>'0'
            ]);
        }
    }
    public function admin_doadd(Request $req){
        $role = Role::find($req->admin_role);
        $admin_id = Admin_users::insertGetId([
            'admin_name'=>$req->admin_name,
            'type'=>$role['role_name'],
            'password'=>Hash::make($req->password)
        ]);
        \DB::table('admin_role')->insert([
            'role_id'=>$role['id'],
            'admin_id'=>$admin_id
        ]);
        // dd($req->all());
        // exit;
        return redirect()->route('administrator');
    }

    public function admin_edit($id){
        $admin = Admin_users::find($id);
        $role = Role::get();
        return view('admin.admin_edit',[
            'role'=>$role,
            'admin'=>$admin
        ]);
    }

    public function admin_doedit(Request $req,$id){
        $role = Role::find($req->admin_role);
        $admin = Admin_users::where('id',$id)->update([
            'admin_name'=>$req->admin_name,
            'type'=>$role['role_name'],
        ]);
        \DB::table('admin_role')->where('admin_id',$id)->update([
            'role_id'=>$role['id'],
        ]);
        return redirect()->route('administrator');
    }
    public function admin_del(Request $req){
        Admin_users::where('id',$req->id)->delete();
        \DB::table('admin_role')->where('admin_id',$req->id)->delete();
    }
    public function info(){
        $id = session('id');
        $user = Admin_users::find($id);
        $pv = \DB::table('pv')->where('user_id',$id)->get();
        return view('admin.admin_info',[
            'user'=>$user,
            'pv'=>$pv
        ]);
    }
    public function doinfo(Request $reg){
        $id = session('id');
        // var_dump($reg->all());exit;
        Admin_users::where('id',$id)
            ->update(['name'=>$reg->name,'sex'=>$reg->sex,'old'=>$reg->old,'phone'=>$reg->phone,'email'=>$reg->email,'qq'=>$reg->qq]);
        return redirect()->route('admin_info');
    }

    public function role(){
        $role = Role::paginate(2);
        return view('admin.role',[
            'role'=>$role,
        ]);
    }

    public function privilege(){
        $Privilege = Privilege::paginate(2);
        return view('admin.privilege',[
            'Privilege'=>$Privilege,
        ]);
    }

    public function privilege_add(){
        return view('admin.privilege_add');
    }
    public function privilege_doadd(Request $reg){
        Privilege::insert([
            'pri_name'=>$reg->pri_name,
            'url_path'=>$reg->url_path,
            'explain'=>$reg->explain,
        ]);
        return redirect()->route('admin_privilege');
    }

    public function privilege_edit($id){
        $pri = Privilege::find($id);
        return view('admin.privilege_edit',[
            'pri'=>$pri
        ]);
    }
    public function privilege_doedit(Request $reg,$id){
        Privilege::where('id',$id)->update([
            'pri_name'=>$reg->pri_name,
            'url_path'=>$reg->url_path,
            'explain'=>$reg->explain,
        ]);
        return redirect()->route('admin_privilege');
    }
    public function privilege_del(Request $req){
        Privilege::where('id',$req->id)->delete();
    }


    public function role_add(){
        $pri = Privilege::get();
        return view('admin.role_add',[
            'pri'=>$pri
        ]);
    }
    public function role_doadd(Request $reg){
        $role_id = Role::insertGetId([
            'role_name'=>$reg->role_name
        ]);
        foreach($reg->pri_name as $v){
            \DB::table('role_privlege')->insert([
                'role_id'=>$role_id,
                'pri_id'=>$v
            ]);
        }

        return redirect()->route('admin_role');
    }

    public function role_edit($id){
        $role = Role::find($id);
        $pri = Privilege::select('privilege.*','role_privlege.pri_id','role_privlege.role_id')->leftjoin('role_privlege','role_privlege.pri_id','=','privilege.id')->get();
        return view('admin.role_edit',[
            'pri'=>$pri,
            'role'=>$role
        ]);
    }
    public function role_doedit(Request $reg,$id){
        \DB::table('role_privlege')->where('role_id',$id)->delete();
        foreach($reg->pri_name as $v){
            \DB::table('role_privlege')->insert([
                'role_id'=>$id,
                'pri_id'=>$v
            ]);
        }
        return redirect()->route('admin_role');
    }
    public function role_del(Request $req){
        Role::where('id',$req->id)->delete();
        \DB::table('role_privlege')->where('role_id',$req->id)->delete();
    }









}
