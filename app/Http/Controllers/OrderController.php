<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Order;

class OrderController extends Controller
{
    public function order_transaction(){
        $data = ['1月', '2月', '3月', '4月', '5月', '6月', '7月', '8月', '9月', '10月', '11月', '12月'];
        $month = ['-01-', '-02-', '-03-', '-04-', '-05-', '-06-', '-07-', '-08-', '-09-', '-10-', '-11-', '-12-'];

        $order = Order::count();
        $order_0 = Order::where('type',0)->count();
        $order_1 = Order::where('type',1)->count();
        $order_2 = Order::where('type',2)->count();
        // var_dump($order_0);
        return view('order.transaction',[
            'order'=>$order,
            'order_0'=>$order_0,
            'order_1'=>$order_1,
            'order_2'=>$order_2,

        ]);
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
