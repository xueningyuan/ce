<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Order;

class OrderController extends Controller
{
    public function order_transaction(){
        return view('order.transaction');
    }
    public function Order_handling(Request $req){
        // echo $_GET['type'];
        $order = Order::select('orders.*','goods.goods_name');
        if(isset($_GET['type'])){
            
            $order->where('orders.type',$_GET['type']);
           
        }else{
            $order->whereIn('orders.type',['0','1','2','3']);
        }
        if(isset($req->sn)){
            $order->where('orders.sn',$req->sn);
        }
        if(isset($req->created_at)){
            $order->where('orders.created_at','like',"{$req->created_at}%");
        }
        $order = $order->join('goods','orders.goods_id','=','goods.id')
        ->paginate(10);
        $select['sn'] = $req->sn;
        $select['created_at'] = $req->created_at;
        // echo "<pre>";
        // var_dump($order);
        return view('order.handling',[
            'order'=>$order,
            'select'=>$select
        ]);
    }
    public function Order_type(Request $req){
        Order::where('id',$req->id)->update([
            'express'=>$req->express,
            'number'=>$req->number,
            'type'=>2
        ]);
        echo "ok";
    }
    public function Order_detailed(){
        return view('order.detailed');
    }
    public function Order_refund(Request $req){
        $order = Order::select('orders.*','goods.goods_name');
        if(isset($_GET['type'])){
            
            $order->where('orders.type',$_GET['type']);
           
        }else{
            $order->whereIn('orders.type',['4','5',]);
        }
        if(isset($req->sn)){
            $order->where('orders.sn',$req->sn);
        }
        if(isset($req->created_at)){
            $order->where('orders.created_at','like',"{$req->created_at}%");
        }
        $order = $order->join('goods','orders.goods_id','=','goods.id')
        ->paginate(10);
        $select['sn'] = $req->sn;
        $select['created_at'] = $req->created_at;
        return view('order.refund',[
            'order'=>$order,
            'select'=>$select
        ]);
    }
}
