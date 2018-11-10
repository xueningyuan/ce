<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="assets/css/font-awesome.min.css" />
    <link href="assets/css/codemirror.css" rel="stylesheet">
    <link rel="stylesheet" href="font/css/font-awesome.min.css" />
    <!--[if lte IE 8]>
		  <link rel="stylesheet" href="assets/css/ace-ie.min.css" />
		<![endif]-->
    <!--[if IE 7]>
		  <link rel="stylesheet" href="assets/css/font-awesome-ie7.min.css" />
		<![endif]-->
    <!--[if lte IE 8]>
		  <link rel="stylesheet" href="assets/css/ace-ie.min.css" />
		<![endif]-->
    <script src="assets/js/ace-extra.min.js"></script>
    <!--[if lt IE 9]>
		<script src="assets/js/html5shiv.js"></script>
		<script src="assets/js/respond.min.js"></script>
		<![endif]-->
    <!--[if !IE]> -->
    <script src="js/jquery-1.9.1.min.js" type="text/javascript"></script>
    <!-- <![endif]-->
    <script src="assets/dist/echarts.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <title>交易</title>
</head>

<body>
    <div class=" page-content clearfix">
        <div class="transaction_style">

        </div>
        <div class="t_Record">
            <div id="main" style="height:400px; overflow:hidden; width:100%; overflow:auto"></div>
        </div>
    </div>
</body>

</html>
<script type="text/javascript">
    $(document).ready(function () {

        $(".t_Record").width($(window).width() - 60);
        //当文档窗口发生改变时 触发  
        $(window).resize(function () {
            $(".t_Record").width($(window).width() - 60);
        });
    });


    require.config({
        paths: {
            echarts: './assets/dist'
        }
    });
    require(
        [
            'echarts',
            'echarts/theme/macarons',
            'echarts/chart/line',   // 按需加载所需图表，如需动态类型切换功能，别忘了同时加载相应图表
            'echarts/chart/bar'
        ],
        function (ec, theme) {
            var myChart = ec.init(document.getElementById('main'), theme);
            option = {
                title: {
                    text: '月购买订单交易记录',
                    subtext: '实时获取用户订单购买记录'
                },
                tooltip: {
                    trigger: 'axis'
                },
                legend: {
                    data: ['所有订单', '待付款', '已付款', '代发货']
                },
                toolbox: {
                    show: true,
                    feature: {
                        mark: { show: true },
                        dataView: { show: true, readOnly: false },
                        magicType: { show: true, type: ['line', 'bar'] },
                        restore: { show: true },
                        saveAsImage: { show: true }
                    }
                },
                calculable: true,
                xAxis: [
                    {
                        type: 'category',
                        data: ['当前所有']
                    }
                ],
                yAxis: [
                    {
                        type: 'value'
                    }
                ],
                series: [
                    {
                        name: '所有订单',
                        type: 'bar',
                        data: ["{{$order}}"],
                        markPoint: {
                            data: [
                                { type: 'max', name: '最大值' },
                                { type: 'min', name: '最小值' }
                            ]
                        }
                    },
                    {
                        name: '待付款',
                        type: 'bar',
                        data: ["{{$order_0}}"],
                        markPoint: {
                            data: [
                                { name: '年最高', value: "{{$order}}", xAxis: 7, yAxis: 1182, symbolSize: 18 },
                                { name: '年最低', value: 23, xAxis: 11, yAxis: 3 }
                            ]
                        },


                    }
                    , {
                        name: '已付款',
                        type: 'bar',
                        data: ["{{$order_1}}"],
                        markPoint: {
                            data: [
                                { name: '年最高', value: 172, xAxis: 7, yAxis: 172, symbolSize: 18 },
                                { name: '年最低', value: 23, xAxis: 11, yAxis: 3 }
                            ]
                        },

                    }
                    , {
                        name: '代发货',
                        type: 'bar',
                        data: ["{{$order_2}}"],
                        markPoint: {
                            data: [
                                { name: '年最高', value: "{{$order}}", xAxis: 7, yAxis: 1072, symbolSize: 18 },
                                { name: '年最低', value: 0, xAxis: 11, yAxis: 0 }
                            ]
                        },

                    }
                ]
            };

            myChart.setOption(option);
        }
    );
</script>