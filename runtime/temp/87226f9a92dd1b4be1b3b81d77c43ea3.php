<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:81:"D:\phpEnv\www\localhost\user\public/../application/admin\view\user\user_edit.html";i:1573290922;}*/ ?>
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
  
  <body>
    <div class="x-body">
        <form class="layui-form" meth="post" action="<?php echo url('user/userUpdate'); ?>">
          <div class="layui-form-item">
              <label for="L_email" class="layui-form-label">
                  <span class="x-red">*</span>备注
              </label>
              <div class="layui-input-inline">
                  <input type="text" id="" name="note" required
                  autocomplete="off" class="layui-input" value="<?php echo $note; ?>">
              </div>
              <input type="hidden" name="id" value="<?php echo $id; ?>">
              <div class="layui-form-mid layui-word-aux">
                  <span class="x-red">*</span>备注提示信息
              </div>
          </div>
          <div class="layui-form-item">
              <label for="L_repass" class="layui-form-label">
              </label>
              <button  class="layui-btn" lay-filter="add" lay-submit>
                  修改
              </button>
          </div>
      </form>
    </div>
    <script>
      layui.use(['form','layer'], function(){
          $ = layui.jquery;
        var form = layui.form
        ,layer = layui.layer;



        //监听提交
        form.on('submit(add)', function(data){
            $.ajax({
                url: "<?php echo url('user/userUpdate'); ?>"
                , data: data.field
                , type: "post"
                , success: function (data) {
                    if(data.code == 1){

                        layer.msg("修改成功", {icon: 6,time:1000},function () {
                            // 获得frame索引
                            var index = parent.layer.getFrameIndex(window.name);
                            parent.location.reload()
                            parent.layer.close(index);

                        });
                    }else{
                        layer.msg('修改失败!',{icon:1,time:1000});
                    }
                }
            });
            return false;
        });

      });
  </script>
  </body>

</html>