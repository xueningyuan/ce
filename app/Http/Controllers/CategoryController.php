<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Category;

class CategoryController extends Controller
{
    public function index(){
        $data = Category::get();
        return view('category.index',[
            'data'=>$data
        ]);
    }
    public function add(){
        $data = Category::get();
        foreach($data as $k => $v){
           if(substr_count($v['path'],'-')==3){
                unset($data[$k]);
           }else if(substr_count($v['path'],'-')==2){
                $v['cat_name'] = "--".$v['cat_name'];
           }
        }
        return view('category.add',[
            'data'=>$data
        ]);
    }
    public function doadd(Request $req){
        echo "<pre>";
        $data = $req->all();
        if($data['path']=='-'){
            $data['parent_id'] = 0;
        }else{
            if(substr_count($data['path'],'-')==3){
                $data['parent_id'] = trim($data['path'],'-');
                $data['parent_id'] = strstr($data['parent_id'],'-');
                $data['parent_id'] = trim($data['parent_id'],'-');
           }else if(substr_count($data['path'],'-')==2){
                $data['parent_id'] = trim($data['path'],'-');
           }
            
        }
        // var_dump($data);
        $Category = new Category;
        $Category->fill($data);
        $Category->save();
        return redirect()->route('category_add');
    }

    public function edit(){
        $data = Category::get();
        foreach($data as $k => $v){
           if(substr_count($v['path'],'-')==3){
                $v['cat_name'] = "---3---".$v['cat_name'];
           }else if(substr_count($v['path'],'-')==2){
                $v['cat_name'] = "-2-".$v['cat_name'];
           }
        }
        return view('category.edit',[
            'data'=>$data
        ]);
    }

    public function doedit(Request $req){
        echo "<pre>";
        $data = $req->all();
        // var_dump($data);
        $a = Category::where('id',$data['id'])
                ->update(['cat_name'=>$data['cat_name']]);
        return redirect()->route('category_edit');
    }


    public function del(){
        $data = Category::get();
        foreach($data as $k => $v){
           if(substr_count($v['path'],'-')==3){
                $v['cat_name'] = "---3---".$v['cat_name'];
           }else if(substr_count($v['path'],'-')==2){
                $v['cat_name'] = "-2-".$v['cat_name'];
           }
        }
        return view('category.del',[
            'data'=>$data
        ]);
    }

    public function dodel(Request $req){
        echo "<pre>";
        Category::where('id',$req->id)
                ->delete();
        Category::where('path','like',"%$req->id%")
                ->delete();        
        return redirect()->route('category_del');
    }
}
