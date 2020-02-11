<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:81:"D:\phpEnv\www\localhost\user\public/../application/admin\view\user\user_list.html";i:1574421686;}*/ ?>
<!DOCTYPE html>
<html>
  
  <head>
    <meta charset="UTF-8">
    <title>欢迎页面-L-admin1.0</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi" />
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="/static/css/font.css">
    <link rel="stylesheet" href="/static/css/xadmin.css">
    <script src="/static/js/jquery.min.js"></script>
    <script type="text/javascript" src="/static/lib/layui/layui.js" charset="utf-8"></script>
    <script type="text/javascript" src="/static/js/xadmin.js"></script>
    <!-- 让IE8/9支持媒体查询，从而兼容栅格 -->
    <!--[if lt IE 9]>
      <script src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
      <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  
  <body class="layui-anim layui-anim-upbit">
    <div class="x-nav">
      <span class="layui-breadcrumb">
      </span>
      <a class="layui-btn layui-btn-primary layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" href="javascript:location.replace(location.href);" title="刷新">
        <i class="layui-icon" style="line-height:38px">ဂ</i></a>
    </div>
    <div class="x-body">
      <div class="layui-row" >
        <form class="layui-form layui-col-md12 x-so" action="<?php echo url('user/userlist'); ?>" method="post">
          <input class="layui-input" placeholder="开始日" name="start" id="start" autocomplete="off">
          <input class="layui-input" placeholder="截止日" name="end" id="end" autocomplete="off">

          <input type="text" name="username"  placeholder="请输入会员ID" autocomplete="off" class="layui-input">
          <button class="layui-btn"  lay-submit="" lay-filter="sreach"><i class="layui-icon">&#xe615;</i></button>

        </form>
      </div>
      <xblock>

        <button class="layui-btn" onclick="x_admin_show('添加用户','<?php echo url("user/userAdd"); ?>',600,300)"><i class="layui-icon"></i>导入数据</button>
       <?php if($post ==1): ?>
        <span class="x-right" style="line-height:40px">共有数据：<em><?php echo $count; ?></em> 条</span>
        <?php else: ?>
        <span class="x-right" style="line-height:40px">共有数据：<em><?php echo $fcount; ?></em> 条</span>
        <?php endif; ?>
      </xblock>
      <table class="layui-table">
        <thead>
          <tr>


            <?php if(\think\Session::get('u_id') == 1): ?>
            <th>上级账号</th>
            <?php endif; ?>
            <th>会员ID</th>
            <th>用户名</th>
            <th>手机号</th>
            <th>金额</th>
            <th>距离上次时间</th>
            <th>最近登录时间</th>
<!--            <?php if(\think\Session::get('u_id') == 1): ?>-->
<!--            <th>隶属</th>-->
<!--            <?php endif; ?>-->
            <th>备注</th>
            <th>操作</th></tr>
        </thead>
        <tbody>
 <?php if($post == 1): if(is_array($userinfo) || $userinfo instanceof \think\Collection || $userinfo instanceof \think\Paginator): $i = 0; $__LIST__ = $userinfo;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>

          <tr>

<!--            <td><?php echo $vo['grade']; ?></td>-->
            <?php if(\think\Session::get('u_id') == 1): ?>
            <td><?php echo $vo['own']; ?></td>
            <?php endif; ?>
            <td><?php echo $vo['user_id']; ?></td>
            <td><?php echo $vo['username']; ?></td>
            <td><?php echo $vo['phone']; ?></td>
            <td><?php echo $vo['money']; ?> 元</td>
            <td><?php echo $vo['day']; ?> 天</td>
            <td><?php echo $vo['create_time']; ?></td>
<!--            <?php if(\think\Session::get('u_id') == 1): ?>-->
<!--            <td><?php echo $vo['own']; ?></td>-->
<!--            <?php endif; ?>-->

            <td><?php echo $vo['note']; ?></td>

            <td class="td-manage">
              <a title="编辑" class="layui-btn layui-btn-sm layui-btn-normal"  onclick="x_admin_show('编辑','<?php echo url("user/useredit",array("id"=>$vo['id'])); ?>',600,200)" href="javascript:;">
                编辑
              </a>
            </td>
          </tr>
        <?php endforeach; endif; else: echo "" ;endif; else: if(is_array($datas) || $datas instanceof \think\Collection || $datas instanceof \think\Paginator): $i = 0; $__LIST__ = $datas;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
   <tr>

     <td><?php echo $vo['grade']; ?></td>
     <td><?php echo $vo['user_id']; ?></td>
     <td><?php echo $vo['username']; ?></td>
     <td><?php echo $vo['phone']; ?></td>
     <td><?php echo $vo['money']; ?></td>
     <td><?php echo $vo['day']; ?> 天</td>
     <td><?php echo $vo['create_time']; ?></td>
     <?php if(\think\Session::get('u_id') == 1): ?>
     <td><?php echo $vo['own']; ?></td>
     <?php endif; ?>
     <td><?php echo $vo['note']; ?></td>

     <td class="td-manage">
       <a title="编辑" class="layui-btn layui-btn-sm layui-btn-normal"  onclick="x_admin_show('编辑','<?php echo url("user/useredit",array("id"=>$vo['id'])); ?>',600,200)" href="javascript:;">
       编辑
       </a>
     </td>
   </tr>
   <?php endforeach; endif; else: echo "" ;endif; endif; ?>

        </tbody>
      </table>
      <div class="page">
        <?php if($post == 1): ?>
        <?php echo $list->render(); endif; ?>
    </div>
    </div>
    <script>
      layui.use('laydate', function(){
        var laydate = layui.laydate;

        //执行一个laydate实例
        laydate.render({
          elem: '#start' //指定元素
        });

        //执行一个laydate实例
        laydate.render({
          elem: '#end' //指定元素
        });

      });

      // layui.use(['form','layer'], function() {
      //   $ = layui.jquery;
      //   var form = layui.form ,
      //   layer = layui.layer;
      //
      //   //监听提交
      //   form.on('submit(sreach)', function (data) {
      //
      //     $.ajax({
      //       url: "<?php echo url('user/userlist'); ?>"
      //
      //       , data: data.field
      //       , type: "post"
      //       , success: function (data) {
      //         console.log(data);
      //         console.log(data.code);
      //         if(data.code == -1){
      //           layer.msg(data.msg, {icon: 5,time:1000},function () {
      //             // 获得frame索引
      //
      //           });
      //         }
      //       }
      //     });
      //     return false;
      //   });
      // });

    </script>
  </body>

</html>