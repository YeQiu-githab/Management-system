<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:80:"D:\phpEnv\www\localhost\user\public/../application/admin\view\user\user_add.html";i:1573617649;}*/ ?>
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
    <div class="x-body layui-anim layui-anim-up" style="padding-top: 75px;margin:0;box-sizing: border-box">
        <form class="layui-form" enctype="multipart/form-data" method="post" >
          <div class="layui-form-item">
              <label for="L_email" class="layui-form-label"  style="width: 120px">
                  <span class="x-red">*</span>请导入excel 表
              </label>

              <div class="layui-upload">
                  <button type="button" class="layui-btn layui-btn-normal" id="test8" name="file">选择文件</button>
                  <button type="button" class="layui-btn" id="test9" name="upload">开始上传</button>
              </div>
<!--              <label for="L_email" class="layui-form-label" style="width: 120px">-->
<!--                  <span class="x-red">*</span>请导入excel 表 -->
<!--              </label>-->
          </div>
<!--          <div class="layui-form-item">-->
<!--              <label for="L_repass" class="layui-form-label">-->
<!--              </label>-->
<!--              <button  class="layui-btn" lay-filter="add" lay-submit="">-->
<!--                  增加-->
<!--              </button>-->
<!--          </div>-->
      </form>
    </div>
    <script>
        layui.use('upload', function(){
            var $ = layui.jquery
                ,upload = layui.upload;
            //选完文件后不自动上传
            upload.render({
                elem: '#test8'
                ,url: '<?php echo url("user/excelIn"); ?>'
                ,auto: false
                ,accept: 'file' //普通文件

                //,multiple: true
                ,bindAction: '#test9'
                ,before: function(obj){
                    layer.msg('数据上传中...', {
                        icon: 16,
                        shade: 0.01,
                        time: 0
                    })
                    //预读本地文件示例，不支持ie8
                    obj.preview(function(index, file, result){
                        $('#demo1').attr('src', result); //图片链接（base64）
                    });
                }
                ,done: function(res){

                    //关闭上传等待动画
                    layer.close(layer.msg());
                    console.log(res);
                   if(res.code == 1){
                       layer.msg(res.msg, {icon: 6,time:1000},function () {
                           // 获得frame索引
                           var index = parent.layer.getFrameIndex(window.name);
                           parent.layer.close(index);
                           parent.location.reload();
                       });
                   } else{
                       console.log(res);
                       layer.msg(res.msg, {icon: 5,time:2000},function () {
                           // 获得frame索引
                           var index = parent.layer.getFrameIndex(window.name);
                           parent.layer.close(index);
                       });
                   }
                },
            });
        });



        layui.use(['form','layer'], function(){
            $ = layui.jquery;
          var form = layui.form
          ,layer = layui.layer;



          //监听提交
          form.on('submit(add)', function(data){
              $.ajax({
                  url: "<?php echo url('user/excelIn'); ?>"

                  , data: data.field
                  , type: "post"
                  , success: function (data) {
                      console.log(data);
                      console.log(data.code);
                      if(data.code == 1){

                          layer.msg("修改成功", {icon: 6,time:1000},function () {
                              // 获得frame索引
                              var index = parent.layer.getFrameIndex(window.name);
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