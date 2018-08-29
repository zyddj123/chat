<html>

<head>
	<meta charset="utf-8">
	<title>chat登录</title>
	<link rel="shortcut icon" href="<?php echo HTTP_ROOT_PATH;?>/favicon.ico" />
	<link href="<?php echo APP_HTTP_ROOT.$this->GetThemes();?>/assets/css/style.css" rel="stylesheet" type="text/css">
</head>
<script>
	var _REQUEST_HOST = '<?php echo APP_URL_ROOT;?>';
</script>
<body>
	<div class="win-bg"><img src="<?php echo APP_HTTP_ROOT.$this->GetThemes();?>/assets/images/win-bg.png"></div>
	<div class="qq-login">
		<div class="login-menu">
			<span></span><span></span><span class="login-close"></span>
		</div>
		<div class="login-ner">
			<div class="login-left">
				<div class="login-head"><img src="<?php echo APP_HTTP_ROOT.$this->GetThemes();?>/assets/images/login/head.jpg"></div>
			</div>
			<div class="login-on">
				<div class="login-txt">
					<input type="text" id="username" placeholder="帐号">
					<input type="password" id="password" placeholder="密码">
				</div>
				<div class="login-but" id="login-but">安全登录</div>
			</div>
			<div class="login-right">
				<a href="#" target="_blank">注册账号</a><a href="#" target="_blank">找回密码</a>
			</div>
		</div>
	</div>
	<script src="<?php echo APP_HTTP_ROOT.$this->GetThemes();?>/assets/js/jquery-3.3.1.js"></script>
	<script>
		$(document).ready(function() {
			
			$('#login-but').click(function() {
				if ($('#username').val() == '' || $('#password').val() == '') {
					alert('请输入账号或者密码');
				} else {
					login($('#username').val(), $('#password').val());
				}
			})
			$('.login-txt input').keydown(function(e) {
				if (e.keyCode == 13) {
					if ($('#username').val() == '' || $('#password').val() == '') {
						alert('请输入账号或者密码');
					} else {
						login($('#username').val(), $('#password').val());
					}
				}
			})
			$('.close').click(function() {
				$(this).parent().parent().parent().css('display', 'none');
			})
			// $('.min').click(function() {
			// 	$(this).parent().parent().parent().addClass('mins');
			// })
			
			
			function login(username, password) {
				$.post(_REQUEST_HOST + "/Login/do_login", { "username": username, "password": password }, function(e) {
					if (e) {
						window.location.href = _REQUEST_HOST+'/Index/index';
					}else{
						alert("账号或者密码错误");
					}
				});
			}
		});
	</script>
</body>

</html>