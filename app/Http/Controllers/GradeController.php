<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\User_grade;

class GradeController extends Controller
{
    public function grade(){
        $grade = User_grade::paginate(10);
        return view('grade.grade',[
            'grade'=>$grade
        ]);
    }
    public function grade_add(Request $req){
        return view('grade.add');
    }
    public function grade_doadd(Request $req){
        $grade =User_grade::insert([
            'grade_name'=>$req->grade_name,
            'integral'=>$req->integral
        ]);
        return redirect()->route('grade');
    }

    public function grade_edit($id){
        $grade = User_grade::find($id);
        return view('grade.edit',[
            'grade'=>$grade
        ]);
    }
    public function grade_doedit(Request $req,$id){
        $grade =User_grade::where('id',$id)->update([
            'grade_name'=>$req->grade_name,
            'integral'=>$req->integral
        ]);

        return redirect()->route('grade');
    }

    public function grade_typr(Request $req){
        // echo "<pre>";
        $user = User_grade::find($req->id);
        // echo $user['type'];
        if($user['type']=='启用'){
            $user->where('id',$req->id)->update([
                'type'=>'弃用'
            ]);
        }else{
            $user->where('id',$req->id)->update([
                'type'=>'启用'
            ]);
        }
    }

    public function grade_del(Request $req){
        User_grade::where('id',$req->id)->delete();
        echo "ok";
    }





}
