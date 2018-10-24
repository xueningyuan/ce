<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Goods;

class GoodController extends Controller
{
    public function index(Request $req){
        $goods = Goods::where('id','!=',null);
        $num = Goods::count();
        $select=[];
        if($req->goods_name){
            $goods->where('goods_name','like',"%$req->goods_name%");
            $select['goods_name'] = $req->goods_name;
        }      
        if($req->created_at){
            $goods->where('created_at','like',"$req->created_at%");
            $select['created_at'] = $req->created_at;
        }
        $goods =$goods->paginate(10); 
        // echo "<pre>";
        // var_dump($goods);
        
        // echo $num;
        return view('goods.index',[
            'goods'=>$goods,
            'num'=>$num,
            'select'=>$select
        ]);
    }

    public function sale_y(Request $req){
        $id = $req->id;
        $a = Goods::where('id', $id)
            ->update(['is_on_sale' => 'n']);
        if($a)
            echo "ok";
        else
            echo "no";
    }
    public function sale_n(Request $req){
        $id = $req->id;
        $a = Goods::where('id', $id)
            ->update(['is_on_sale' => 'y']);
        if($a)
            echo "ok";
        else
            echo "no";
    }

    public function goods_sku(){
        $goods = Goods::leftJoin('goods_sku','goods_sku.goods_id','=','goods.id');
        $goods =$goods->paginate(10); 
        // echo "<pre>";
        // var_dump($goods);
        
        // echo $num;
        return view('goods.sku',[
            'goods'=>$goods,
        ]);
    }

    public function good_add(){
        return view('goods.picture-add');
    }











}
