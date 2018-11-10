<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Storage;
use Image;

class Goods_image extends Model
{
    protected $table = 'goods_image';
    public $timestamps=false;    
    protected $fillable =['goods_id','path','s','l','m'];

    public function upimage($req,$id,$good_id){
        echo "<pre>";
        $user = new Goods_image;        
        // exit;
        // dd($req->all());
        foreach($req->image as $k => $v){
            // dd($k,$v);
            // $user = new User;
            if($req->has('image')&& $req->image[$k]->isValid()){
                //当前图片上传的位置
               $oldimage = $req->image[$k]->path();
               //保存原图片
               $date = date('Ymd');
               $oriImg =$req->image[$k]->store('good_image/'.$date);
               
                //打开要处理的图片    
               $img = Image::make($oldimage);

                // 定义缩略图并保存
               $bgname = str_replace('good_image/'.$date.'/','good_image/'.$date.'/bg_',$oriImg); 
               $img->resize(400,400);
               $img->save('./uploads/'.$bgname);

               $mdname = str_replace('good_image/'.$date.'/','good_image/'.$date.'/md_',$oriImg);
               $img->resize(400,400);
               $img->save('./uploads/'.$mdname);

               $smname = str_replace('good_image/'.$date.'/','good_image/'.$date.'/sm_',$oriImg);
               $img->resize(56,56);
               $img->save('./uploads/'.$smname);
            

            }else{
                return back()->withErrors([
                    'face'=>'上传失败'
                ]);
            }
            Goods_image::insert([
                'path'=>$oriImg,
                's'=>$bgname,
                'l'=>$mdname,
                'm'=>$smname,
                'sku_id'=>$id,
                'goods_id'=>$good_id,
            ]);
        }

    }













}
