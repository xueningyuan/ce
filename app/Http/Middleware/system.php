<?php

namespace App\Http\Middleware;

use Closure;
use App\Model\Privilege;
use App\Model\Admin_users;

class system
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {   
        if(!$request->session()->has("id")){
            return back();
        }
        if( session('type') == '超级管理员'){
            return $next($request);
        }

        session('id');
        $privilege =Admin_users::select('privilege.*')->where('admin_users.id',session('id'))
        ->leftjoin('admin_role','admin_role.admin_id','=','admin_users.id')
        ->leftjoin('role_privlege','admin_role.role_id','=','role_privlege.role_id')
        ->leftjoin('privilege','role_privlege.role_id','=','privilege.id')
        ->get();

        $pa = \Request::route()->getName();
        // 获取将要访问的路径 
        $path = isset($pa)?  $pa : 'admin_index';
        // 设置一个白名单
        $whiteList = ['admin_index','admin_home'];
        // 判断是否有权访问
        $privilege = explode(',',$privilege);
        if(!in_array($path, array_merge($whiteList, $privilege)))
        {
            die('无权访问！');
        }
        
        return $next($request);
    }
}
