<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="css/style.css" />
  <link href="assets/css/codemirror.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/ace.min.css" />
  <link rel="stylesheet" href="assets/css/font-awesome.min.css" />
  <!--[if IE 7]>
		  <link rel="stylesheet" href="assets/css/font-awesome-ie7.min.css" />
		<![endif]-->
  <!--[if lte IE 8]>
		  <link rel="stylesheet" href="assets/css/ace-ie.min.css" />
		<![endif]-->
  <script src="assets/js/jquery.min.js"></script>

  <!-- <![endif]-->

  <!--[if IE]>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<![endif]-->

  <!--[if !IE]> -->

  <script type="text/javascript">
    window.jQuery || document.write("<script src='assets/js/jquery-2.0.3.min.js'>" + "<" + "/script>");
  </script>

  <!-- <![endif]-->

  <!--[if IE]>
<script type="text/javascript">
 window.jQuery || document.write("<script src='assets/js/jquery-1.10.2.min.js'>"+"<"+"/script>");
</script>
<![endif]-->

  <script type="text/javascript">
    if ("ontouchend" in document) document.write("<script src='assets/js/jquery.mobile.custom.min.js'>" + "<" + "/script>");
  </script>
  <script src="assets/js/bootstrap.min.js"></script>
  <script src="assets/js/typeahead-bs2.min.js"></script>
  <!-- page specific plugin scripts -->
  <script src="assets/js/jquery.dataTables.min.js"></script>
  <script src="assets/js/jquery.dataTables.bootstrap.js"></script>
  <script type="text/javascript" src="js/H-ui.js"></script>
  <script type="text/javascript" src="js/H-ui.admin.js"></script>
  <script src="assets/layer/layer.js" type="text/javascript"></script>
  <script src="assets/laydate/laydate.js" type="text/javascript"></script>
  <title>用户列表</title>
</head>

<body>
  <div class="page-content clearfix">
    <div id="Member_Ratings">
      <div class="d_Confirm_Order_style">
        <div class="search_style">
          <form action="{{route('user')}}">
          <ul class="search_content clearfix">
            <li>
              <label class="l_f">会员名称</label>
              <input name="name" type="text" value="{{$select['name']}}" class="text_add" placeholder="输入会员名称、电话、邮箱" style=" width:400px" />
            </li>
            <li>
              <label class="l_f">添加时间</label>
              <input name="time" class="inline laydate-icon" value="{{$select['time']}}" id="start" style=" margin-left:10px;">
            </li>
            <li style="width:90px;">
              <button type="submit" class="btn_search">
                <i class="icon-search"></i>查询</button>
            </li>
          </ul>
        </form>
        </div>
        <!---->
        <!---->
        <div class="table_menu_list">
          <table class="table table-striped table-bordered table-hover" id="sample-table">
            <thead>
              <tr>
                <th width="80">ID</th>
                <th width="100">用户名</th>
                <th width="80">性别</th>
                <th width="80">积分</th>
                <th width="120">手机</th>
                <th width="150">邮箱</th>
                <th width="180">加入时间</th>
                <th width="100">等级</th>
                <th width="70">状态</th>
                <th width="250">操作</th>
              </tr>
            </thead>
            <tbody>
              @foreach($user as $v)
              <tr>
                <td>{{$v->id}}</td>
                <td>
                  {{$v->name}}
                </td>
                <td>{{$v->sex}}</td>
                <td>{{$v->integral}}</td>
                <td>{{$v->phone}}</td>
                <td>{{$v->email}}</td>
                <td>{{$v->created_at}}</td>
                <td>{{$v->grade_name}}</td>
                <td class="td-status">
                  @if($v->type == "启用")
                  <span class="label label-success radius">已启用</span>
                  @else
                  <span class="label label-defaunt radius">已停用</span>
                  @endif
                </td>
                <td class="td-manage">
                  @if($v->type == "启用")
                  <a onClick="member_stop(this,'{{$v->id}}')" href="javascript:;" title="停用" class="btn btn-xs btn-success">
                    <i class="icon-ok bigger-120"></i>
                  </a>
                  @else
                  <a style="text-decoration:none" class="btn btn-xs " onClick="member_start(this,'{{$v->id}}')" href="javascript:;" title="启用"><i class="icon-ok bigger-120"></i></a>
                  @endif
                  <a title="删除" href="javascript:;" onclick="member_del(this,'{{$v->id}}')" class="btn btn-xs btn-warning">
                    <i class="icon-trash  bigger-120"></i>
                  </a>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
          {{$user->links()}}
        </div>
      </div>
    </div>
  </div>

</body>

</html>
<script>
  jQuery(function ($) {
    var oTable1 = $('#sample-table').dataTable({
      "aaSorting": [[1, "desc"]],//默认第几个排序
      "bStateSave": true,//状态保存
      "aoColumnDefs": [
        //{"bVisible": false, "aTargets": [ 3 ]} //控制列的隐藏显示
        { "orderable": false, "aTargets": [0, 8, 9] }// 制定列不参与排序
      ]
    });


    $('table th input:checkbox').on('click', function () {
      var that = this;
      $(this).closest('table').find('tr > td:first-child input:checkbox')
        .each(function () {
          this.checked = that.checked;
          $(this).closest('tr').toggleClass('selected');
        });

    });


    $('[data-rel="tooltip"]').tooltip({ placement: tooltip_placement });
    function tooltip_placement(context, source) {
      var $source = $(source);
      var $parent = $source.closest('table')
      var off1 = $parent.offset();
      var w1 = $parent.width();

      var off2 = $source.offset();
      var w2 = $source.width();

      if (parseInt(off2.left) < parseInt(off1.left) + parseInt(w1 / 2)) return 'right';
      return 'left';
    }
  })
  /*用户-停用*/
  function member_stop(obj, id) {
    var url = "{{route('user_typr')}}";
    layer.confirm('确认要停用吗？', function (index) {
      $.ajax({
            url:url,
            method: "GET",
            data:{id:id},
            dataType: "json",
            success: function success(data) {

            }
        });
      $(obj).parents("tr").find(".td-manage").prepend('<a style="text-decoration:none" class="btn btn-xs " onClick="member_start(this,'+id+')" href="javascript:;" title="启用"><i class="icon-ok bigger-120"></i></a>');
      $(obj).parents("tr").find(".td-status").html('<span class="label label-defaunt radius">已停用</span>');
      $(obj).remove();
      layer.msg('已停用!', { icon: 5, time: 1000 });
    });
  }

  /*用户-启用*/
  function member_start(obj, id) {
    var url = "{{route('user_typr')}}";
    layer.confirm('确认要启用吗？', function (index) {
      $.ajax({
            url:url,
            method: "GET",
            data:{id:id},
            dataType: "json",
            success: function success(data) {

            }
        });
      $(obj).parents("tr").find(".td-manage").prepend('<a style="text-decoration:none" class="btn btn-xs btn-success" onClick="member_stop(this,'+id+')" href="javascript:;" title="停用"><i class="icon-ok bigger-120"></i></a>');
      $(obj).parents("tr").find(".td-status").html('<span class="label label-success radius">已启用</span>');
      $(obj).remove();
      layer.msg('已启用!', { icon: 6, time: 1000 });
    });
  }
  
  /*用户-删除*/
  function member_del(obj, id) {
    layer.confirm('确认要删除吗？', function (index) {
      var url = "{{route('user_del')}}";
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