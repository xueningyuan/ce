<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Goods;
use App\Model\Category;
use App\Model\Goods_attribute;
use App\Model\Goods_sku;
use App\Model\Goods_image;
use Storage;

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

    public function goods_sku($id){
        $Goods_sku = Goods_sku::where('goods_id',$id);
        $goods =$Goods_sku->paginate(10); 
        // echo "<pre>";
        // var_dump($goods);
        
        // echo $num;
        return view('goods.sku',[
            'goods'=>$goods,
            'id'=>$id
        ]);
    }

    public function sku_add($id){
        echo "<pre>";
        $goods = Goods::find($id);
        $attr = Goods_attribute::where('goods_id',$id)->get();
        $attrs = Goods_attribute::select('attr_name')->where('goods_id','=',$id)->groupBy('attr_name')->get();
        $count = count($attrs);
        // echo $attr[2]['attr_name'];
        // var_dump($attr);
        return view('goods.sku_add',[
            'goods'=>$goods,
            'attr'=>$attr,
            'count'=>$count
        ]);
    }

    public function sku_doadd(Request $req,$id){
        echo "<pre>";
        $sku = new Goods_sku;
        for($i=0;$i<count($req->sku);$i++){
            $a[$i] =  explode('-',$req->sku[$i]);
            // var_dump($a[$i]); 
        }
        for($i=0;$i<count($a)-1;$i++){
            $a[$i][$i] = $a[$i][$i]."-".$a[$i+1][$i];
            $a[$i][$i+1] = $a[$i][$i+1]."-".$a[$i+1][$i+1];
        }
        $attr_value =$a[0][1];
        $sku_name   =$a[0][0];

        $skuid = Goods_sku::insertGetId([
            'goods_id' => $id,
            'attr_value' => $attr_value,
            'sku_name' => $sku_name,
            'stock' => $req->stock[0],
            'price' => $req->price[0],
        ]);
            
        $image = new Goods_image;
        if(isset($req->image)){
            $image->upimage($req,$skuid);
        }
        
        return redirect()->route('goods_sku',['id'=>$id]);
    }

    public function good_add(){
        $data = Category::where('parent_id',0)
                    ->get();
        return view('goods.picture-add',[
            'data'=>$data
        ]);
    }
    public function goods_edit($id){
        $data = Category::where('parent_id',0)
                    ->get();
        $goods = Goods::find($id);
        $attr = Goods_attribute::where('goods_id',$id)
                    ->get();
        return view('goods.picture-edit',[
            'data'=>$data,
            'goods'=>$goods,
            'attr'=>$attr
        ]);
    }
    public function good_doadd(Request $req){
        $goods = new Goods;
        $good = $goods->fill($req->all());
        if($req->has('logo')&& $req->logo->isValid()){
            //当前图片上传的位置
           $oldimage = $req->logo->path();
           //保存原图片
           $date = date('Ymd');
           $oriImg =$req->logo->store('logo/'.$date);
           $goods->logo = $oriImg;
        }
        $goods->save();
        if(isset($req->attr_name)){
            foreach($req->attr_name as $k=>$v){
                Goods_attribute::insert(
                    [
                        'goods_id'=>$goods->id,
                        'attr_name'=>$v,
                        'attr_value'=>$req->attr_value[$k]
                    ]
                );
            }
        }
        return redirect()->route('goods');
    }
    public function goods_doedit(Request $req,$id){
        $goods = Goods::find($id);
        $goods->fill($req->all());
        if($req->has('logo')&& $req->logo->isValid()){
            //当前图片上传的位置
           $oldimage = $req->logo->path();
           //保存原图片
           $date = date('Ymd');
           $oriImg =$req->logo->store('logo/'.$date);
           Storage::delete($goods->logo);
           $goods->logo = $oriImg;
           
        }
        $goods->save();
        Goods_attribute::where('goods_id',$id)->delete();
        if(isset($req->attr_name)){
            foreach($req->attr_name as $k=>$v){
                Goods_attribute::insert(
                    [
                        'goods_id'=>$goods->id,
                        'attr_name'=>$v,
                        'attr_value'=>$req->attr_value[$k]
                    ]
                );
            }
        }
        echo "<script>parent.location.reload();</script>";
	    
    }

    public function goods_del(Request $req){
        $id = $req->id;
        Goods_attribute::where('goods_id',$id)->delete();
        $goods = Goods::find($id);
        Storage::delete($goods->logo);
        Goods::where('id',$id)->delete();
        
    }

    public function ajax_get_cat(Request $req)
    {
        $id = $req->id;
        // 根据这个ID查询子分类
        $data = Category::where('parent_id',$id)
                    ->get();
        // 转成 JSON
        echo json_encode($data);
    }











}
