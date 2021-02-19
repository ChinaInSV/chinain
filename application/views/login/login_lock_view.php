<!DOCTYPE html>
<html lang="en">

	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="icon" type="image/png" href="logo.png">
		<title>China In | Login</title>
		
		<link href="<?php echo base_url();?>assets/css/bootstrap.min.css" rel="stylesheet">
		<link href="<?php echo base_url();?>assets/css/nifty.css" rel="stylesheet">
		<link href="<?php echo base_url();?>assets/css/styles.css" rel="stylesheet">
		<link href="<?php echo base_url();?>assets/css/demo/nifty-demo.min.css" rel="stylesheet">
		<link href="<?php echo base_url();?>assets/plugins/magic-check/css/magic-check.min.css" rel="stylesheet">
		<link href="<?php echo base_url();?>assets/plugins/pace/css/pace.min.css" rel="stylesheet">
		<link href="<?php echo base_url();?>assets/plugins/toastr/toastr.min.css" rel="stylesheet">
		
		<script src="<?php echo base_url();?>assets/plugins/pace/js/pace.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/jquery.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/nifty.js"></script>
		<script src="<?php echo base_url();?>assets/js/chinain/chinain.login_view.js"></script>
		<script src="<?php echo base_url();?>assets/js/demo/bg-images.js"></script>
		<script src="<?php echo base_url();?>assets/plugins/toastr/toastr.min.js"></script>	
		
		<!--Teclado-->
		<link href="<?php echo base_url();?>assets/plugins/keyboard/keyboard.css" rel="stylesheet">
		<script src="<?php echo base_url();?>assets/plugins/keyboard/keyboard.js"></script>
		
		<!--JQuery UI-->
		<link href="<?php echo base_url();?>assets/plugins/jquery_ui/jquery-ui.min.css" rel="stylesheet">
		<script src="<?php echo base_url();?>assets/plugins/jquery_ui/jquery-ui.min.js"></script>
		
		<link href="<?php echo base_url();?>assets/plugins/zebra/css/flat/zebra_dialog.css" rel="stylesheet">
		<script src="<?php echo base_url();?>assets/plugins/zebra/js/zebra_dialog.src.js"></script>
		
		<!--Tools-->
		<script src="<?php echo base_url();?>assets/js/tools/chinain.tools.js"></script>
	</head>
<body>
	<div id="logo-login"></div>
	<div id="container" class="cls-container">
		<div id="bg-overlay"></div>
			<div class="cls-content">
				<div class="cls-content-sm panel">
					<div class="panel-body">
						<div class="mar-ver pad-btm">
							<h3 class="h4 mar-no"><?php echo $user->nombre_usuario;?></h3>
						</div>
						<div class="pad-btm mar-btm">
							<img alt="Profile Picture" class="img-lg img-circle img-border-light" src="<?php echo base_url($user->img_perfil_usuario);?>">
						</div>
						<p>Ingrese su contrase&ntilde;a</p>
						<form id="login-form" class="m-t-md" role="form"method="POST" action="<?php echo base_url("login/logon");?>" autocomplete="off">
							<div class="form-group">
								<input type="hidden" class="form-control input-lg" id="login-username" value="<?php echo $user->username_usuario;?>" name="username" placeholder="Username" autofocus>
								<input type="password" class="form-control input-lg" id="login-password" name="password" placeholder="">
							</div>
							<div class="form-group text-right">
								<a class="btn btn-dark btn-lg btn-block submit" style="color:white;" id="login-btn" href="javascript:void(0);">Entrar</a>
							</div>
						</form>
						<div class="pad-ver">
							<a href="<?php echo base_url("login/logout");?>" class="btn-link mar-rgt">Iniciar sesi&oacute;n con otra cuenta</a>
						</div>
					</div>
				</div>
			</div>
			<div class="demo-bg">
				<div id="demo-bg-list">
					<div class="demo-loading"><i class="psi-repeat-2"></i></div>
					<img class="demo-chg-bg" id="demo-bg-active" src="<?php echo base_url();?>assets/img/bg-img/bgchina.png" alt="Background Image">
				</div>
			</div>
		</div>
	</body>
</html>
<script>
$(document).ready(function(){
	ChinaInTools.initializeKeyboard("container");
	$("#login-password").focus();
	$("#demo-bg-active").trigger("click");
	var login = new Login('<?php echo base_url();?>');
	login.msg1 = "Especifique un usuario y una contrase&ntilde;a para poder ingresar";
	login.msg2 = "Usuario o contrase&ntilde;a incorrectos";
	login.msg3 = "Este usuario se encuentra inactivo";
	$("#login-username, #login-password").keypress(function(e){
		var code = e.keyCode || e.which;
		 if(code == 13) {
			login.go();
			e.preventDefault();
		 }
	});
	$("#login-btn").click(function(){
		login.go();
	});
});
</script>