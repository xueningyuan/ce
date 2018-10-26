<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <title>管理中心 - 添加新记录</title>
    <meta name="robots" content="noindex, nofollow">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="/Styles/general.css" rel="stylesheet" type="text/css" />
    <link href="/Styles/main.css" rel="stylesheet" type="text/css" />
</head>
<body>
    <div class="main-div">
        <form action="{{route('goods_doedit',['id'=>$goods->id])}}" method="post" enctype="multipart/form-data">
            @csrf
            <h3>基本信息</h3>
            <table width="100%">
                <tr>
                    <td class="label">商品名称:</td>
                    <td>
                        <input type='text' size="80" name='goods_name' value="{{$goods->goods_name}}">
                        <font color="red">*</font>
                    </td>
                </tr>
                <tr>
                    <td class="label">LOGO:</td>
                    <td>
                        <div class="img_preview">
                            <img src="{{Storage::url($goods->logo)}}" width="120" height="120">
                        </div>
                        <input type='file' class="preview" name='logo'>
                        <font color="red">*</font>
                    </td>
                </tr>
                <tr>
                    <td class="label">是否上架:</td>
                    <td>
                        @if($goods->is_on_sale == 'y')
                        <input type="radio" name="is_on_sale" value="y" checked > 是
                        <input type="radio" name="is_on_sale" value="n"> 否
                        @else
                        <input type="radio" name="is_on_sale" value="y" > 是
                        <input type="radio" name="is_on_sale" value="n" checked> 否
                        @endif
                        <font color="red">*</font>
                    </td>
                </tr>
                <tr>
                    <td class="label">商品描述:</td>
                    <td>
                        <textarea name="description" id="" cols="80" rows="10">{{$goods->description}}</textarea>
                        <font color="red">*</font>
                    </td>
                </tr>
                <tr>
                    <td class="label">一级分类ID:</td>
                    <td>
                        <select name="cat1_id">
                            <option value="">选择一级分类</option>
                            @foreach($data as $v)
                                @if($v->id == $goods->cat1_id)
                                <option selected="selected" value="{{$v->id}}">{{$v->cat_name}}</option>
                                @else
                                <option value="{{$v->id}}">{{$v->cat_name}}</option>
                                @endif
                            @endforeach
                        </select>
                        <font color="red">*</font>
                    </td>
                </tr>
                <tr>
                    <td class="label">二级分类ID:</td>
                    <td>
                        <select name="cat2_id"></select>
                        <font color="red">*</font>
                    </td>
                </tr>
                <tr>
                    <td class="label">三级分类ID:</td>
                    <td>
                        <select name="cat3_id"></select>
                        <font color="red">*</font>
                    </td>
                </tr>
            </table>

            <h3>商品属性 <input id="btn-attr" type="button" value="添加一个属性"></h3>
            <div id="attr-container">
                @foreach($attr as $v)
                <table width="100%">
                    <tr>
                        <td class="label">属性名称:</td>
                        <td>
                            <input type='text' size="80" name='attr_name[]' value="{{$v->attr_name}}">
                            <font color="red">*</font>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">属性值:</td>
                        <td>
                            <input type='text' size="80" name='attr_value[]' value="{{$v->attr_value}}">
                            <font color="red">*</font>
                        </td>
                    </tr>
                    <tr>
                        <td class="label"></td>
                        <td>
                            <input onclick="del_attr(this)" type="button" value="删除">
                        </td>
                    </tr>
                </table>
                @endforeach
            </div>


            <div class="button-div">
                <input type="submit" value=" 确定 " />
                <input type="reset" value=" 重置 " />
            </div>
        </form>
    </div>
</body>
</html>
<script src="/js/jquery.min.js"></script>
<script src="/js/img_preview.js"></script>
<script>
var attrStr = `<hr><table width="100%"><tbody>
                <tr>
                    <td class="label">属性名称:</td>
                    <td>
                        <input type='text' size="80" name='attr_name[]'>
                        <font color="red">*</font>
                    </td>
                </tr>
                <tr>
                    <td class="label">属性值:</td>
                    <td>
                        <input type='text' size="80" name='attr_value[]'>
                        <font color="red">*</font>
                    </td>
                </tr>
                <tr>
                    <td class="label"></td>
                    <td>
                        <input onclick="del_attr(this)" type="button" value="删除">
                    </td>
                </tr>
            </tbody></table>`;

$("#btn-attr").click(function(){
    $("#attr-container").append(attrStr)
});

function del_attr(o)
{
    if(confirm("确定要删除吗？"))
    {
        var table = $(o).parent().parent().parent().parent()
        table.prev('hr').remove()
        table.remove()
    }
    
}


var cat2_id = "{{$goods->cat2_id}}";
var cat3_id = "{{$goods->cat3_id}}";

// 三级联动
$("select[name=cat1_id]").change(function(){
    // 取出这个分类的id
    var id = $(this).val();
    var url = "{{route('ajax_get_cat')}}";
    // 如果不为空就执行AJAX
    if(id!="")
    {
        $.ajax({
            type:"GET",
            url:url,
            data:{id:id},
            dataType:"json",
            success:function(data)
            {   
                var str = "";
                for(var i=0;i<data.length;i++)
                {
                    if(data[i].id == cat2_id)
                        str += '<option selected="selected" value="'+data[i].id+'">'+data[i].cat_name+'</option>';
                    else
                        str += '<option value="'+data[i].id+'">'+data[i].cat_name+'</option>';
                }
                // 把拼好的 option 放到第二个下拉框中
                $("select[name=cat2_id]").html(str)
                // 触发第二个框的 change 事件
                $("select[name=cat2_id]").trigger('change');
            }
        });
    }
});


$("select[name=cat2_id]").change(function(){
    // 取出这个分类的id
    var id = $(this).val()
    var url = "{{route('ajax_get_cat')}}";
    // 如果不为空就执行AJAX
    if(id!="")
    {
        $.ajax({
            type:"GET",
            url:url,
            data:{id:id},
            dataType:"json",
            success:function(data)
            {
                var str = "";
                for(var i=0;i<data.length;i++)
                {
                    if(data[i].id == cat2_id)
                        str += '<option selected="selected" value="'+data[i].id+'">'+data[i].cat_name+'</option>';
                    else
                        str += '<option value="'+data[i].id+'">'+data[i].cat_name+'</option>';
                }
                // 把拼好的 option 放到第三个下拉框中
                $("select[name=cat3_id]").html(str)
            }
        });
    }
});
// 触发一级分类的change事件，让它直接取出二级分类
$("select[name=cat1_id]").trigger("change");
</script>