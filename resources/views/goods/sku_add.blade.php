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
        <form action="{{route('sku_doadd',['id'=>$goods->id])}}" method="post" enctype="multipart/form-data">
            @csrf
            <h3>基本信息</h3>
            <table width="100%">
                <tr>
                    <td class="label">商品名称:</td>
                    <td>
                        <span>{{$goods->goods_name}}</span>
                        <!-- <input type='text' size="80" name='goods_name'> -->
                        <!-- <font color="red">*</font> -->
                    </td>
                </tr>
                <tr>
                    <td class="label">LOGO:</td>
                    <td>
                        <img src="{{Storage::url($goods->logo)}}" width="120" alt="">
                        <!-- <input type='file' class="preview" name='logo'> -->
                        <!-- <font color="red">*</font> -->
                    </td>
                </tr>
                <tr>
                    <td class="label">商品描述:</td>
                    <td>
                        <span>{{$goods->description}}</span>
                        <!-- <textarea name="description" id="" cols="80" rows="10"></textarea> -->
                        <!-- <font color="red">*</font> -->
                    </td>
                </tr>
            </table>

            <h3>商品图片 <input id="btn-image" type="button" value="添加一个图片"></h3>
            <div id="image-container">
                <table width="100%">
                    <tr>
                        <td class="label"></td>
                        <td>
                            <input class="preview" type='file' name='image[]'>
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
            </div>

            <h3>SKU <input id="btn-sku" type="button" value="添加一个sku"></h3>
            <div id="sku-container">
                <table width="100%">
                    <tr>
                        <td class="label">SKU名称:</td>
                        <td>
                            @for($i=0;$i<$count;$i++)
                            <select name="sku[]" id="" style="vertical-align:bottom;">
                                @foreach($attr as $k=>$v)
                                @if($v->attr_name == $attr[$i]->attr_name)
                                <option value="{{$v->id}}-{{$v->attr_value}}">{{$v->attr_value}}</option>
                                @endif
                                @endforeach
                            </select>
                            @endfor
                        </td>
                    </tr>
                    <tr>
                        <td class="label">库存量:</td>
                        <td>
                            <input type='text' size="80" name='stock[]'>
                            <font color="red">*</font>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">价格:</td>
                        <td>
                            ￥ <input type='text' size="10" name='price[]'> 元
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
function del_attr(o)
{
    if(confirm("确定要删除吗？"))
    {
        var table = $(o).parent().parent().parent().parent()
        table.prev('hr').remove()
        table.remove()
    }
    
}

var imageStr = `<hr><table width="100%"><tbody>
                    <tr>
                        <td class="label"></td>
                        <td>
                            <input class="preview" type='file' name='image[]'>
                            <font color="red">*</font>
                        </td>
                    </tr>
                    <tr>
                        <td class="label"></td>
                        <td>
                            <input onclick="del_attr(this)" type="button" value="删除">
                        </td>
                    </tr>
                </tbody></table>`

// 为添加按钮绑定事件
$("#btn-image").click(function(){

    // 添加一个图片
    $("#image-container").append(imageStr)


    // 绑定预览事件
    $(".preview").change(function(){
        // 获取选择的图片
        var file = this.files[0];
        // 转成字符串
        var str = getObjectUrl(file);
        // 先删除上一个
        $(this).prev('.img_preview').remove();
        // 在框的前面放一个图片
        $(this).before("<div class='img_preview'><img src='"+str+"' width='120' height='120'></div>");
    });
});

var skuStr = `<hr><table width="100%"><tbody>
                    <tr>
                        <td class="label">SKU名称:</td>
                        <td>
                            <input type='text' size="80" name='sku_name[]'>
                            <font color="red">*</font>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">库存量:</td>
                        <td>
                            <input type='text' size="80" name='stock[]'>
                            <font color="red">*</font>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">价格:</td>
                        <td>
                            ￥ <input type='text' size="10" name='price[]'> 元
                            <font color="red">*</font>
                        </td>
                    </tr>
                    <tr>
                        <td class="label"></td>
                        <td>
                            <input onclick="del_attr(this)" type="button" value="删除">
                        </td>
                    </tr>
                </tbody></table>`

// 为添加按钮绑定事件
$("#btn-sku").click(function(){

    // 添加一个图片
    $("#sku-container").append(skuStr)
});




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
                    str += '<option value="'+data[i].id+'">'+data[i].cat_name+'</option>';
                }
                // 把拼好的 option 放到第三个下拉框中
                $("select[name=cat3_id]").html(str)
            }
        });
    }
});

</script>