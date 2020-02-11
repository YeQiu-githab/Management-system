<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:78:"D:\phpEnv\www\localhost\user\public/../application/admin\view\login\index.html";i:1573537686;}*/ ?>

<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>会员系统</title>
<link rel="stylesheet" type="text/css" href="/static/css/login.css">
    <script src="/static/js/jquery.min.js"></script>
</head>
<body>
<div id="wrapper" class="login-page">
<div id="login_form" class="form">
<form class="register-form" method="post">
<input type="text" placeholder="用户名" value="admin" id="r_user_name" />
<input type="password" placeholder="密码" id="r_password" />
<input type="text" placeholder="电子邮件" id="r_emial" />
<button id="create">创建账户</button>
<p class="message">已经有了一个账户? <a href="#">立刻登录</a></p>
</form>
<form class="login-form" >
     <h2>管理登录</h2>
    <input type="text" placeholder="用户名" value="admin" id="user_name" />
    <input type="password" placeholder="密码" id="password" />
    <button id="login">登　录</button>
    <p class="message">还没有账户? <a href="#">立刻创建</a></p>
</form>
</div>
</div>


<script type="text/javascript">


        function check_login() {
            var name = $("#user_name").val();
            var pass = $("#password").val();
            $.ajax({
                url: "<?php echo url('login/checklogin'); ?>",
                type: "post",
                data: {
                    'username': name,
                    'pwd': pass,
                },
                success: function (data) {

                    console.log(data.code);

                    if (data.code == 1) {
                        alert('登陆成功');
                        window.location.href = "<?php echo url('index/index'); ?>"
                    }else if(data.code == -1) {
                        alert('账号密码错误');
                    }else{
                        alert('登陆失败!');
                    };

                }
            });

    }
	function check_register(){
		var name = $("#r_user_name").val();
		var pass = $("#r_password").val();
		var email = $("r_email").val();
		if(name!="" && pass=="" && email != "")
		 {
		  alert("注册成功！");
		  $("#user_name").val("");
		  $("#password").val("");
		 }
		 else
		 {
		  $("#login_form").removeClass('shake_effect');  
		  setTimeout(function()
		  {
		   $("#login_form").addClass('shake_effect')
		  },1);  
		 }
	}
	$(function(){
		$("#create").click(function(){
			check_register();
			return false;
		})
		$("#login").click(function(){
			check_login();
			return false;
		})
		$('.message a').click(function () {
		    $('form').animate({
		        height: 'toggle',
		        opacity: 'toggle'
		    }, 'slow');
		});
	})
	</script>
</body>
</html>