<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:83:"D:\phpEnv\www\localhost\user\public/../application/admin\view\admin\admin_list.html";i:1573612016;}*/ ?>
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

      <a class="layui-btn layui-btn-primary layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" href="javascript:location.replace(location.href);" title="刷新">
        <i class="layui-icon" style="line-height:38px">ဂ</i></a>
    </div>
    <div class="x-body">
   <!--   <div class="layui-row">
        <form class="layui-form layui-col-md12 x-so">
          <input class="layui-input" placeholder="开始日" name="start" id="start">
          <input class="layui-input" placeholder="截止日" name="end" id="end">
          <input type="text" name="username"  placeholder="请输入用户名" autocomplete="off" class="layui-input">
          <button class="layui-btn"  lay-submit="" lay-filter="sreach"><i class="layui-icon">&#xe615;</i></button>
        </form>
      </div>-->
      <xblock>
        <button class="layui-btn" onclick="x_admin_show('添加用户','<?php echo url("admin/adminAdd"); ?>',800,400)"><i class="layui-icon"></i>添加管理员</button>
        <span class="x-right" style="line-height:40px">共有数据：<?php echo $num; ?> 条</span>
      </xblock>
      <table class="layui-table">
        <thead>
          <tr>

            <th>ID</th>
            <th>名称</th>
            <th>角色</th>
            <th>金钱</th>
            <th>加入时间</th>
            <th>操作</th>
        </thead>
        <tbody>
        <?php if(is_array($admininfo) || $admininfo instanceof \think\Collection || $admininfo instanceof \think\Paginator): $i = 0; $__LIST__ = $admininfo;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
          <tr>

            <td><?php echo $vo['id']; ?></td>
            <td><?php echo $vo['username']; ?></td>
            <?php if($vo['grade'] == 1): ?>
               <td>超级管理员</td>
            <?php else: ?>
              <td>管理员</td>
            <?php endif; ?>

            <td><?php echo $vo['money']; ?> 元</td>
            <td><?php echo $vo['create_time']; ?></td>

            <td class="td-manage">
              <a title="编辑"  onclick="x_admin_show('编辑','<?php echo url("admin/adminEdit",array('id'=>$vo['id'])); ?>',800,400)" href="javascript:;">
                <i class="layui-icon">&#xe642;</i>
              </a>
              <a title="删除" onclick="member_del(this,<?php echo $vo['id']; ?>)" href="javascript:;">
                <i class="layui-icon">&#xe640;</i>
              </a>
            </td>
          </tr>
        <?php endforeach; endif; else: echo "" ;endif; ?>
        </tbody>
      </table>
      <div class="page">
        <div>
          <?php echo $list->render(); ?>
        </div>
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

       /*用户-停用*/
      function member_stop(obj,id){
          layer.confirm('确认要停用吗？',function(index){

              if($(obj).attr('title')=='启用'){

                //发异步把用户状态进行更改
                $(obj).attr('title','停用')
                $(obj).find('i').html('&#xe62f;');

                $(obj).parents("tr").find(".td-status").find('span').addClass('layui-btn-disabled').html('已停用');
                layer.msg('已停用!',{icon: 5,time:1000});

              }else{
                $(obj).attr('title','启用')
                $(obj).find('i').html('&#xe601;');

                $(obj).parents("tr").find(".td-status").find('span').removeClass('layui-btn-disabled').html('已启用');
                layer.msg('已启用!',{icon: 5,time:1000});
              }
              
          });
      }

      /*用户-删除*/
      function member_del(obj,id){
          layer.confirm('确认要删除吗？',function(index){
              //发异步删除数据
              $(obj).parents("tr").remove();
            $.ajax({
              url: "<?php echo url('admin/adminDel'); ?>",
              data: {'id':id},
               type: "post",
              // , dataType: "josn"
               success: function (data) {

                if(data.code == 1){
                  layer.msg('已删除!',{icon:1,time:1000});
                }else{
                  layer.msg('删除失败!',{icon:1,time:1000});
                }
              }
            });

          });
      }



      function delAll (argument) {

        var data = tableCheck.getData();
  
        layer.confirm('确认要删除吗？'+data,function(index){
            //捉到所有被选中的，发异步进行删除
            layer.msg('删除成功', {icon: 1});
            $(".layui-form-checked").not('.header').parents('tr').remove();
        });
      }
    </script>
  </body>

</html>