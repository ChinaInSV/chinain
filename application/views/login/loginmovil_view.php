<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>China In | Login</title>

    <!--STYLESHEET-->
    <!--=================================================-->

    <!--Bootstrap Stylesheet [ REQUIRED ]-->
    <link href="<?php echo base_url();?>assets/css/bootstrap.min.css" rel="stylesheet">
	<meta name="viewport" content="width=device-width">
    <meta name="mobile-web-app-capable" content="yes">
	<link rel="manifest" href="manifest.json">


    <!--Nifty Stylesheet [ REQUIRED ]-->
    <link href="<?php echo base_url();?>assets/css/nifty.css" rel="stylesheet">
        
    <!--Demo [ DEMONSTRATION ]-->
    <link href="<?php echo base_url();?>assets/css/demo/nifty-demo.min.css" rel="stylesheet">
	<link href="<?php echo base_url();?>assets/css/styles.css" rel="stylesheet">

    <!--Magic Checkbox [ OPTIONAL ]-->
    <link href="<?php echo base_url();?>assets/plugins/magic-check/css/magic-check.min.css" rel="stylesheet">

    
    <!--JAVASCRIPT-->
    <!--=================================================-->

	<!--Pace - Page Load Progress Par [OPTIONAL]-->
    <link href="<?php echo base_url();?>assets/plugins/pace/css/pace.min.css" rel="stylesheet">
    <script src="<?php echo base_url();?>assets/plugins/pace/js/pace.min.js"></script>


    <!--jQuery [ REQUIRED ]-->
    <script src="<?php echo base_url();?>assets/js/jquery.min.js"></script>


    <!--BootstrapJS [ RECOMMENDED ]-->
    <script src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>


    <!--NiftyJS [ RECOMMENDED ]-->
    <script src="<?php echo base_url();?>assets/js/nifty.js"></script>
	
	<!--Teclado-->
    <link href="<?php echo base_url();?>assets/plugins/keyboard/keyboard.css" rel="stylesheet">
    <script src="<?php echo base_url();?>assets/plugins/keyboard/keyboard.js"></script>
	
	<!--JQuery UI-->
    <link href="<?php echo base_url();?>assets/plugins/jquery_ui/jquery-ui.min.css" rel="stylesheet">
    <script src="<?php echo base_url();?>assets/plugins/jquery_ui/jquery-ui.min.js"></script>
	
	<!--Tools-->
	<script src="<?php echo base_url();?>assets/js/tools/chinain.tools.js"></script>
	
	<!-- Login -->
    <script src="<?php echo base_url();?>assets/js/chinain/chinain.login_view.js"></script>
	
	<link href="<?php echo base_url();?>assets/plugins/zebra/css/flat/zebra_dialog.css" rel="stylesheet">
	<script src="<?php echo base_url();?>assets/plugins/zebra/js/zebra_dialog.src.js"></script>


    <!--=================================================-->
    
    <!--Background Image [ DEMONSTRATION ]-->
    <script src="<?php echo base_url();?>assets/js/demo/bg-images.js"></script>
	<link href="<?php echo base_url();?>assets/plugins/toastr/toastr.min.css" rel="stylesheet">
	<script src="<?php echo base_url();?>assets/plugins/toastr/toastr.min.js"></script>
	
	</head>

<!--TIPS-->
<!--You may remove all ID or Class names which contain "demo-", they are only used for demonstration. -->

<body>
	<div id="logo-login"></div>
	<div id="container" class="cls-container">
		
		<!-- BACKGROUND IMAGE -->
		<!--===================================================-->
		<div id="bg-overlay"></div>
		
		
		<!-- LOGIN FORM -->
		<!--===================================================-->
		<div class="cls-content">
		    <div class="cls-content-sm panel">
		        <div class="panel-body">
		            <div class="mar-ver pad-btm">
		                <h3 class="h4 mar-no">Login</h3>
		                <p class="text-muted">Ingrese sus credenciales</p>
		            </div>
		            <form id="login-form" class="m-t-md" role="form"method="POST" action="<?php echo base_url("loginmovil/logon");?>" autocomplete="off">
		                <div class="form-group">
		                    <input type="text" class="form-control input-lg" id="login-username" name="username" placeholder="Nombre de Usuario" autofocus>
		                </div>
		                <div class="form-group">
		                    <input type="password" class="form-control input-lg" id="login-password" name="password" placeholder="Contrase&ntilde;a">
		                </div>
						<a class="btn btn-dark btn-lg btn-block submit" style="color:white;" id="login-btn" href="javascript:void(0);">Entrar</a>
		            </form>
		        </div>
		    </div>
		</div>
		<!--===================================================-->
		
		
		<!-- DEMO PURPOSE ONLY -->
		<!--===================================================-->
		<div class="demo-bg">
		    <div id="demo-bg-list">
		        <div class="demo-loading"><i class="psi-repeat-2"></i></div>
		        <img class="demo-chg-bg" id="demo-bg-active" src="<?php echo base_url();?>assets/img/bg-img/bgchina.png" alt="Background Image">
		    </div>
		</div>
		<!--===================================================-->
		
		
		
	</div>
	<!--===================================================-->
	<!-- END OF CONTAINER -->


	</body>
</html>
<script>
ChinaInTools.initializeKeyboard("container");
$(document).ready(function(){
	$("#login-username").focus();
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