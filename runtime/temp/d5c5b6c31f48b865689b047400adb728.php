<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:83:"D:\phpEnv\www\localhost\user\public/../application/admin\view\admin\admin_edit.html";i:1573291601;}*/ ?>
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
        <form class="layui-form" method="post" action="<?php echo url('admin/adminSave'); ?>">
          <div class="layui-form-item">
              <label for="username" class="layui-form-label">
                  <span class="x-red">*</span>登录名
              </label>
              <div class="layui-input-inline">
                  <input type="text" id="username" name="username" required lay-verify="required"
                  autocomplete="off" class="layui-input" value="<?php echo $admininfo['username']; ?>" disabled>
              </div>
              <div class="layui-form-mid layui-word-aux">
                  <span class="x-red">*</span>将会成为您唯一的登入名
              </div>
          </div>
            <div class="layui-form-item">
                <label for="L_pass" class="layui-form-label">
                    <span class="x-red">*</span>密码
                </label>
                <div class="layui-input-inline" id="pwd">
                    <input type="password" id="L_pass" name="pass" required lay-verify="pass"
                           autocomplete="off" class="layui-input"  value="" >
                </div>
                <div class="layui-form-mid layui-word-aux">
                    6到16个字符
                </div>
            </div>
            <div class="layui-form-item">
                <label for="L_repass" class="layui-form-label">
                    <span class="x-red">*</span>确认密码
                </label>
                <div class="layui-input-inline">
                    <input type="password" id="L_repass" name="repass" required lay-verify="repass"
                           autocomplete="off" class="layui-input">
                    <input type="hidden" name="adminid" value="<?php echo $admininfo['id']; ?>" id="hidden">
                </div>
            </div>
<!--            <div class="layui-form-item">-->
<!--                <div class="layui-card-body layui-row layui-col-space10">-->
<!--                    <div class="layui-col-md12"  id="IsPurchased ">-->
<!--                        <label class="layui-form-label">身份管理</label>-->
<!--                        <?php if($admininfo['grade'] == 1): ?>-->
<!--                            <input type="radio" name="permissions" class="admin" value="admin" title="超级管理员"  checked lay-filter="ChoiceRadio">-->
<!--                            <input type="radio" name="permissions" class="number" value="number" title="普通管理员"  lay-filter="ChoiceRadio">-->
<!--                        <?php else: ?>-->
<!--                            <input type="radio" name="permissions" class="admin"  value="admin" title="超级管理员" >-->
<!--                            <input type="radio" name="permissions" class="number"  value="number" title="普通管理员" checked>-->
<!--                        <?php endif; ?>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->


          <div class="layui-form-item">
              <label for="L_repass" class="layui-form-label">
              </label>
              <button  class="layui-btn" lay-filter="add" lay-submit="">修改</button>
          </div>
      </form>
    </div>
    <script>
        layui.use(['form','layer'], function(){
            $ = layui.jquery;
            var form = layui.form,
                layer = layui.layer;



            var id=$("#hidden").val();
            var pwd=$("#pwd").val();
            var L_pass=$("#L_pass").attr('value');


           var ra= $('input[name="pass"]').val();
            console.log(pwd,ra,L_pass);

            $ = layui.jquery;
             var form = layui.form,
                 layer = layui.layer;
        
          //自定义验证规则
          form.verify({
            nikename: function(value){
              if(value.length < 5){
                return '昵称至少得5个字符啊';
              }
            }
            ,pass: [/(.+){6,12}$/, '密码必须6到12位']
            ,repass: function(value){
                if($('#L_pass').val()!=$('#L_repass').val()){
                    return '两次密码不一致';
                }
            }
          });

            //监听提交
            form.on('submit(add)', function(data){
                $.ajax({
                    url: "<?php echo url('admin/adminSave'); ?>",
                     data: data.field,
                    type: "post",
                    success: function (data) {
                        console.log(data.field);
                        if(data.code == 1){
                            layer.msg("修改成功", {icon: 6,time:1000},function () {
                                // 获得frame索引
                                var index = parent.layer.getFrameIndex(window.name);
                                //关闭当前frame
                                parent.layer.close(index);
                            });
                        }else{
                            layer.msg("修改失败", {icon: 6 ,time:1000},function () {
                                // 获得frame索引
                                var index = parent.layer.getFrameIndex(window.name);
                                //关闭当前frame
                                parent.layer.close(index);
                            });
                        }
                    }
                });
                return false;
            });

        });
    </script>
  </body>

</html>