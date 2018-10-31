<!DOCTYPE HTML>
<html>

<head>
  <meta charset="utf-8">
  <meta name="renderer" content="webkit|ie-comp|ie-stand">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
  <meta http-equiv="Cache-Control" content="no-siteapp" />
  <link href="/assets/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="/css/style.css" />
  <link rel="stylesheet" href="/assets/css/ace.min.css" />
  <link rel="stylesheet" href="/assets/css/font-awesome.min.css" />
  <link href="/Widget/icheck/icheck.css" rel="stylesheet" type="text/css" />
  <!--[if IE 7]>
		  <link rel="stylesheet" href="assets/css/font-awesome-ie7.min.css" />
		<![endif]-->
  <!--[if lte IE 8]>
		  <link rel="stylesheet" href="assets/css/ace-ie.min.css" />
		<![endif]-->
  <script src="/js/jquery-1.9.1.min.js"></script>
  <script src="/assets/js/bootstrap.min.js"></script>
  <title>修改权限</title>
</head>

<body>
  <div class="type_style">
    <div class="type_title">修改权限</div>
    <div class="type_content">
      <form action="{{route('privilege_doedit',['id'=>$pri->id])}}" method="post" class="form form-horizontal" id="form-user-add">
        @csrf

        <div class="Operate_cont clearfix">
          <label class="form-label">
            <span class="c-red">*</span>权限名称:</label>
          <div class="formControls ">
            <input type="text" class="input-text" value="{{$pri->pri_name}}" placeholder="" name="pri_name">
          </div>
        </div>
        <div class="Operate_cont clearfix">
            <label class="form-label">
              <span class="c-red">*</span>权限路由:</label>
            <div class="formControls ">
              <textarea name="url_path" id="" cols="30" rows="10">{{$pri->url_path}}</textarea>
              <!-- <input type="text" class="input-text" value="" placeholder=""  name="url_path"> -->
            </div>
          </div>
        <div class="Operate_cont clearfix">
            <label class="form-label">
              <span class="c-red">*</span>权限说明:</label>
            <div class="formControls ">
              <input type="text" class="input-text" value="{{$pri->explain}}" placeholder=""  name="explain">
            </div>
          </div>
        <div class="">
          <div class="" style=" text-align:center">
            <input class="btn btn-primary radius" type="submit" value="提交">
          </div>
        </div>
      </form>
    </div>
  </div>
  </div>
  <script type="text/javascript" src="/Widget/icheck/jquery.icheck.min.js"></script>
  <script type="text/javascript" src="/Widget/Validform/5.3.2/Validform.min.js"></script>
  <script type="text/javascript" src="/assets/layer/layer.js"></script>
  <script type="text/javascript" src="/js/H-ui.js"></script>
  <script type="text/javascript" src="/js/H-ui.admin.js"></script>
  <script type="text/javascript">
    $(function () {
      $('.skin-minimal input').iCheck({
        checkboxClass: 'icheckbox-blue',
        radioClass: 'iradio-blue',
        increaseArea: '20%'
      });

      $("#form-user-add").Validform({
        tiptype: 2,
        callback: function (form) {
          form[0].submit();
          var index = parent.layer.getFrameIndex(window.name);
          parent.$('.btn-refresh').click();
          parent.layer.close(index);
        }
      });
    });
  </script>
</body>

</html>