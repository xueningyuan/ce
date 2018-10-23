<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Goods;

class GoodController extends Controller
{
    public function index(){
        $goods = Goods::leftJoin('goods_sku','goods_sku.goods_id','=','goods.id');
        $goods =$goods->paginate(2); 
        // echo "<pre>";
        // var_dump($goods);
        $num = Goods::count();
        // echo $num;
        return view('goods.index',[
            'goods'=>$goods,
            'num'=>$num
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

    public function good_add(){
        return view('goods.picture-add');
    }











}
