<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Category;
use App\Model\Goods;
use App\Model\Goods_sku;

class IndexController extends Controller
{
    public function index(){
        $cat = Category::where('parent_id','0')->get();
        foreach($cat as $k=>$v){
            $cat[$k]['cat2'] = Category::where('parent_id',$v->id)->get();

            foreach($cat[$k]['cat2'] as $y=>$l){
                $cat[$k]['cat2'][$y]['cat3'] = Category::where('parent_id',$l->id)->get();
            }
        }
        
        $goods = Goods::take(6)->get();
        foreach($goods as $k=>$v){
            $goods[$k]['sku'] = Goods_sku::where('goods_id',$v->id)->first();
        }
        // echo $goods[0]->sku->id;
        // dd($goods);
        return view('index.index',[
            'cat'=>$cat,
            'goods'=>$goods
        ]);
    }
}
