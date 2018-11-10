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
        // echo "<pre>";
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
    public function sku_edit($id,$skuid){
        // echo "<pre>";
        $goods = Goods::find($id);
        $attr = Goods_attribute::where('goods_id',$id)->get();
        $attrs = Goods_attribute::select('attr_name')->where('goods_id','=',$id)->groupBy('attr_name')->get();
        $count = count($attrs);
        // echo $attr[2]['attr_name'];
        // var_dump($attr);
        $sku = Goods_sku::find($skuid);
        $data = explode('-',$sku->sku_name);
        $image = Goods_image::where('sku_id',$skuid)->get();
        // var_dump($image);
        return view('goods.sku_edit',[
            'goods'=>$goods,
            'attr'=>$attr,
            'count'=>$count,
            'data'=>$data,
            'sku'=>$sku,
            'image'=>$image,
        ]);
    }

    public function sku_doadd(Request $req,$id){
        echo "<pre>";
        $sku = new Goods_sku;
        // var_dump($req->sku);
        for($i=0;$i<count($req->sku[0]);$i++){
            // dd(count($req->sku[0]));
            $a[$i] =  explode('-',$req->sku[0][$i]);
            // var_dump($a[$i]); 
        }
        $tem = [];
        for($i=0;$i<count($a);$i++){
            $tem[0][] = $a[$i][0];
            $tem[1][] = $a[$i][1];
        }
        $sku_name = implode('-',$tem[0]);
        $attr_value = implode('-',$tem[1]);
        
        $skuid = Goods_sku::insertGetId([
            'goods_id' => $id,
            'attr_value' => $attr_value,
            'sku_name' => $sku_name,
            'stock' => $req->stock[0],
            'price' => $req->price[0],
        ]);
            
        $image = new Goods_image;
        if(isset($req->image)){
            $image->upimage($req,$skuid,$id);
        }
        
        return redirect()->route('goods_sku',['id'=>$id]);
    }
    public function sku_doedit(Request $req,$id,$skuid){
        echo "<pre>";
        $sku = new Goods_sku;
        for($i=0;$i<count($req->sku);$i++){
            $a[$i] =  explode('-',$req->sku[$i]);
            // var_dump($a[$i]); 
        }
        $tem = [];
        for($i=0;$i<count($a);$i++){
            $tem[0][] = $a[$i][0];
            $tem[1][] = $a[$i][1];
        }
        $sku_name = implode('-',$tem[0]);
        $attr_value = implode('-',$tem[1]);

        Goods_sku::where('id',$skuid)->update([
            'attr_value' => $attr_value,
            'sku_name' => $sku_name,
            'stock' => $req->stock[0],
            'price' => $req->price[0],
        ]);
            
        $image = new Goods_image;
        if(isset($req->del_image)){
            $del = explode(',',$req->del_image);
            $img = $image->whereIn('id',$del)->get();
            foreach($img as $v){
                Storage::delete($v['path']);
                Storage::delete($v['s']);
                Storage::delete($v['l']);
                Storage::delete($v['m']);
            }
            $image->whereIn('id',$del)->delete();
            

        }
                // exit;
        if(isset($req->image)){
            $image->upimage($req,$skuid,$id);
        }
        
        return ;
    }

    public function sku_del(Request $req){
        $id = $req->id;
        $sku = new Goods_sku;
        $sku->where('id',$id)->delete();
        $image = new Goods_image;
        $img = $image->where('sku_id',$id)->get();
        foreach($img as $v){
            Storage::delete($v['path']);
            Storage::delete($v['s']);
            Storage::delete($v['l']);
            Storage::delete($v['m']);
        }
        $image->where('sku_id',$id)->delete();
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

        $sku = new Goods_sku;
        $sku->where('goods_id',$id)->delete();
        $image = new Goods_image;
        $img = $image->where('goods_id',$id)->get();
        foreach($img as $v){
            Storage::delete($v['path']);
            Storage::delete($v['s']);
            Storage::delete($v['l']);
            Storage::delete($v['m']);
        }
        $image->where('goods_id',$id)->delete();
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
