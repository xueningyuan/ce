<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Goods;
use App\Model\Category;
use App\Model\Goods_attribute;
use App\Model\Goods_sku;
use App\Model\Goods_image;

class ContentController extends Controller
{
    public function goods_content($id,$skuid){
        $goods = Goods::find($id);
        $goods['sku'] = Goods_sku::where('goods_id',$id)->get();
        $goods['img'] = Goods_image::where('sku_id',$skuid)->get();
        $gat = Category::where('id',$goods->cat1_id)
                    ->orwhere('id',$goods->cat2_id)
                    ->orwhere('id',$goods->cat3_id)->get();
        // dd($goods['img'][0]['path']);
        return view('content.content',[
            'good'=>$goods,
            'gat'=>$gat,
            'skuid'=>$skuid
        ]);
    }
    public function cart(){
        return view('content.cart');
    }
    public function incart(){
        
    }
}
