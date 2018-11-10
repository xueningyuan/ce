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
  <script src="assets/layer/layer.js" type="text/javascript"></script>
  <script src="assets/laydate/laydate.js" type="text/javascript"></script>
  <script src="assets/js/bootstrap.min.js"></script>
  <script src="assets/js/typeahead-bs2.min.js"></script>
  <script src="assets/js/jquery.dataTables.min.js"></script>
  <script src="assets/js/jquery.dataTables.bootstrap.js"></script>

  <title>个人信息管理</title>
</head>

<body>
  <div class="clearfix">
    <div class="admin_info_style">
      <div class="admin_modify_style" id="Personal">
        <div class="type_title">管理员信息 </div>
        <form action="{{ route('admin_user') }}" method="POST">
          {{csrf_field()}}
          <div class="xinxi">
            <div class="form-group">
              <label class="col-sm-3 control-label no-padding-right" for="form-field-1">用户名： </label>
              <div class="col-sm-9">
                <input type="text" name="name" id="website-title" value="{{$user->name}}" class="col-xs-7 text_info" disabled="disabled"> &nbsp;&nbsp;&nbsp;
              </div>

            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label no-padding-right" for="form-field-1">性别： </label>
              <div class="col-sm-9">
                <span class="sex">{{$user->sex}}</span>
                <div class="add_sex">
                  <label>
                    @if($user->sex == '保密')
                    <input name="sex" type="radio" value="保密" class="ace" checked="checked">
                    <span class="lbl">保密</span>
                    @else
                    <input name="sex" type="radio" value="保密" class="ace">
                    <span class="lbl">保密</span>
                    @endif
                  </label>&nbsp;&nbsp;
                  <label>
                    @if($user->sex == '男')
                    <input name="sex" type="radio" value="男" class="ace" checked="checked">
                    <span class="lbl">男</span>
                    @else
                    <input name="sex" type="radio" value="男" class="ace">
                    <span class="lbl">男</span>
                    @endif
                  </label>&nbsp;&nbsp;
                  <label>
                    @if($user->sex == '女')
                    <input name="sex" type="radio" value="女" class="ace" checked="checked">
                    <span class="lbl">女</span>
                    @else
                    <input name="sex" type="radio" value="女" class="ace">
                    <span class="lbl">女</span>
                    @endif
                  </label>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label no-padding-right" for="form-field-1">年龄： </label>
              <div class="col-sm-9">
                <input type="text" name="old" id="website-title" value="{{$user->old}}" class="col-xs-7 text_info" disabled="disabled">
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label no-padding-right" for="form-field-1">移动电话： </label>
              <div class="col-sm-9">
                <input type="text" name="phone" id="website-title" value="{{$user->phone}}" class="col-xs-7 text_info" disabled="disabled">
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label no-padding-right" for="form-field-1">电子邮箱： </label>
              <div class="col-sm-9">
                <input type="text" name="email" id="website-title" value="{{$user->email}}" class="col-xs-7 text_info" disabled="disabled">
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label no-padding-right" for="form-field-1">QQ： </label>
              <div class="col-sm-9">
                <input type="text" name="qq" id="website-title" value="{{$user->qq}}" class="col-xs-7 text_info" disabled="disabled"> </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label no-padding-right" for="form-field-1">权限： </label>
              <div class="col-sm-9">
                <span>{{$user->type}}</span>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label no-padding-right" for="form-field-1">注册时间： </label>
              <div class="col-sm-9">
                <span>{{$user->created_at}}</span>
              </div>
            </div>
            <div class="Button_operation clearfix">
              <button onclick="modify();" class="btn btn-danger radius" type="button">修改信息</button>
              <button class="btn btn-success radius" type="submit">保存修改</button>
            </div>
          </div>
        </form>
      </div>
      <div class="recording_style">
        <div class="type_title">管理员登陆记录 </div>
        <div class="recording_list">
          <table class="table table-border table-bordered table-bg table-hover table-sort" id="sample-table">
            <thead>
              <tr class="text-c">
                <th width="80">ID</th>
                <th width="100">url</th>
                <th width="120">客户端IP</th>
                <th width="150">时间</th>
              </tr>
            </thead>
            <tbody>
              @foreach($pv as $v)
              <tr>
                <td>{{$v->id}}</td>
                <td>{{$v->url}}</td>
                <td>{{$v->ip}}</td>
                <td>{{$v->created_at}}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>

    </div>
  </div>
</body>

</html>
<script>

  //按钮点击事件
  function modify() {
    $('.text_info').attr("disabled", false);
    $('.text_info').addClass("add");
    $('#Personal').find('.xinxi').addClass("hover");
    $('#Personal').find('.btn-success').css({ 'display': 'block' });
  };

  //初始化宽度、高度    
  $(".admin_modify_style").height($(window).height());
  $(".recording_style").width($(window).width() - 400);
  //当文档窗口发生改变时 触发  
  $(window).resize(function () {
    $(".admin_modify_style").height($(window).height());
    $(".recording_style").width($(window).width() - 400);
  });

</script>
<script>
  jQuery(function ($) {
    var oTable1 = $('#sample-table').dataTable({
      "aaSorting": [[1, "desc"]],//默认第几个排序
      "bStateSave": true,//状态保存
      "aoColumnDefs": [
        //{"bVisible": false, "aTargets": [ 3 ]} //控制列的隐藏显示
        { "orderable": false, "aTargets": [0, 2, 3, 4, 5, 6] }// 制定列不参与排序
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
  });</script>