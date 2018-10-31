<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="css/style.css" />
    <link href="assets/css/codemirror.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/ace.min.css" />
    <link rel="stylesheet" href="font/css/font-awesome.min.css" />
    <!--[if lte IE 8]>
		  <link rel="stylesheet" href="assets/css/ace-ie.min.css" />
		<![endif]-->
    <script src="js/jquery-1.9.1.min.js"></script>
    <script src="js/H-ui.js" type="text/javascript"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/typeahead-bs2.min.js"></script>
    <script src="assets/js/jquery.dataTables.min.js"></script>
    <script src="assets/js/jquery.dataTables.bootstrap.js"></script>
    <script src="assets/layer/layer.js" type="text/javascript"></script>
    <script src="assets/laydate/laydate.js" type="text/javascript"></script>

    <script src="js/lrtk.js" type="text/javascript"></script>
    <title>角色管理</title>
</head>

<body>
    <div class="margin clearfix">
        <div id="refund_style">
            <div class="border clearfix">
                    <span class="l_f">
                      <a href="{{route('privilege_add')}}" id="member_add" class="btn btn-warning">
                        <i class="icon-plus"></i>添加用户</a>
                    </span>
                  </div>
            <!--退款列表-->
            <div class="refund_list">
                <table class="table table-striped table-bordered table-hover" id="sample-table">
                    <thead>
                        <tr>
                            <th width="120px">id</th>
                            <th width="250px">权限名称</th>
                            <th width="200px">说明</th>
                            <th width="200px">操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($Privilege as $v)
                        <tr>
                            <td>{{$v->id}}</td>
                            <td class="order_product_name">
                                {{$v->pri_name}}
                            </td>
                            <td>{{$v->explain}}</td>
                            <td>
                                <a title="编辑" href="{{route('privilege_edit',['id'=>$v->id])}}" class="btn btn-xs btn-info">
                                    <i class="fa fa-edit bigger-120"></i>
                                </a>
                                <a title="删除" href="javascript:;" onclick="member_del(this,'{{$v->id}}')" class="btn btn-xs btn-warning">
                                    <i class="fa fa-trash  bigger-120"></i>
                                </a>
                            </td>
                        </tr>

                        @endforeach
                    </tbody>
                </table>
                {{ $Privilege->links() }}
            </div>
        </div>
    </div>
</body>

</html>
<script>
function member_del(obj, id) {
    layer.confirm('确认要删除吗？', function (index) {
        var url = "{{route('privilege_del')}}";
      $.ajax({
            url:url,
            method: "GET",
            data:{id:id},
            dataType: "json",
            success: function success(data) {

            }
        });
      $(obj).parents("tr").remove();
      layer.msg('已删除!', { icon: 1, time: 1000 });
    });
  }
  laydate({
    elem: '#start',
    event: 'focus'
  });
</script>