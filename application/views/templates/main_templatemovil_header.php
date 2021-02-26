<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width">
    <meta name="mobile-web-app-capable" content="yes">
	<link rel="icon" type="image/png" href="logo.png">
	
    <title><?php echo "China In | ".$section_title;?></title>
	
    <link href="<?php echo base_url();?>assets/css/opensans.css" rel='stylesheet' type='text/css'> 
    <link href="<?php echo base_url();?>assets/css/bootstrap.min.css" rel="stylesheet">
    <!--Nifty-->
    <link href="<?php echo base_url();?>assets/css/nifty.css" rel="stylesheet">
    <link href="<?php echo base_url();?>assets/css/styles.css" rel="stylesheet">
    <!--<link href="<?php echo base_url();?>assets/css/themes/type-d/theme-well-red.min.css" rel="stylesheet">-->
    <link href="<?php echo base_url();?>assets/css/themes/type-d/theme-dark.min.css" rel="stylesheet">
	<link href="<?php echo base_url();?>assets/css/chinain_app.css" rel='stylesheet' type='text/css'>
	<!--Icons-->
    <!--<link href="<?php echo base_url();?>assets/css/demo/nifty-demo-icons.min.css" rel="stylesheet">-->
    <link href="<?php echo base_url();?>assets/font-awesome/css/font-awesome.css" rel="stylesheet">
	<link href="<?php echo base_url();?>assets/premium/icon-sets/icons/line-icons/premium-line-icons.min.css" rel="stylesheet">
	<link href="<?php echo base_url();?>assets/premium/icon-sets/icons/solid-icons/premium-solid-icons.css" rel="stylesheet">
	<!--Plugins-->
	<link href="<?php echo base_url();?>assets/plugins/custombox/css/custombox.min.css" rel="stylesheet">
	<link href="<?php echo base_url();?>assets/plugins/toastr/toastr.min.css" rel="stylesheet">
	<link href="<?php echo base_url();?>assets/plugins/zebra/css/flat/zebra_dialog.css" rel="stylesheet">
    <link href="<?php echo base_url();?>assets/plugins/sweetalert/css/sweetalert.css" rel="stylesheet">
	<link href="<?php echo base_url();?>assets/plugins/pace/css/pace.min.css" rel="stylesheet">
       
    <script src="<?php echo base_url();?>assets/plugins/pace/js/pace.min.js"></script>
    <script src="<?php echo base_url();?>assets/js/jquery.min.js"></script>
    <script src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url();?>assets/js/nifty.min.js"></script>	
	
	<!--Teclado-->
    <link href="<?php echo base_url();?>assets/plugins/keyboard/keyboard.css" rel="stylesheet">
    <script src="<?php echo base_url();?>assets/plugins/keyboard/keyboard.js"></script>
	
	<!--JQuery UI-->
    <link href="<?php echo base_url();?>assets/plugins/jquery_ui/jquery-ui.min.css" rel="stylesheet">
    <script src="<?php echo base_url();?>assets/plugins/jquery_ui/jquery-ui.min.js"></script>
	
	<!--DataTables [ OPTIONAL ]-->
    <link href="<?php echo base_url();?>assets/plugins/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
	<link href="<?php echo base_url();?>assets/plugins/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
	<!--DataTables [ OPTIONAL ]-->
    <script src="<?php echo base_url();?>assets/plugins/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
	
	<!--Tools-->
	<script src="<?php echo base_url();?>assets/js/tools/chinain.tools.js"></script>
	
	<!--<script src="<?php echo base_url();?>assets/plugins/slimscroll/slimscroll.min.js"></script>-->
	
    <!--=================================================-->
	<!-- JS Loader-->		
	<?php if(isset($js_files["header"]) && count($js_files["header"])>0):foreach($js_files["header"] as $js_header_file):?><script src="<?php echo base_url("assets/js/")."/".$js_header_file.".js";?>"></script><?php endforeach;endif;?>
	<!--Plugis Loader-->
	<?php if(isset($plugins_files) && count($plugins_files)>0):foreach($plugins_files as $plugin_file):foreach($plugin_file["files"] as $file):if($file["place"]==="header"):switch($file["type"]):case "css":?><link href="<?php echo base_url("assets/plugins/")."/".$plugin_file["name"]."/".$file["file"].".css";?>" rel="stylesheet" media="<?php echo (isset($file["media"]))?$file["media"]:"";?>">
	<?php break;case "js": ?><script src="<?php echo base_url("assets/plugins/")."/".$plugin_file["name"]."/".$file["file"].".js";?>"></script>
	<?php break;endswitch;endif;endforeach;endforeach;endif;?>
</head>
<body>
    <div id="container" class="effect aside-float aside-bright mainnav-out">
        <!--NAVBAR-->
        <header id="navbar">
            <div id="navbar-container" class="boxed">
				<!--Logo-->
                <div class="navbar-header">
                    <a href="<?php echo base_url();?>home/moviltemp" class="navbar-brand">
                        <img src="<?php echo base_url();?>assets/img/chinainlogowhite.png" alt="" class="brand-icon">
                    </a>
                </div>	
				<!--Menu-->
                <div class="navbar-content">
					<ul class="nav navbar-top-links">
                        <!--Navigation toogle button-->
                        <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
						<li>
                            <a href="javascript:void(0);" id="home-add-order-btn">
                                <i class="pli-add-window" style="font-size: 55px;"></i>
                            </a>
                        </li>

                    </ul>
					<ul class="nav navbar-top-links">
						<!--User dropdown-->
                        <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                        <li id="dropdown-user" class="dropdown">
                            <a href="javascript:void(0);" data-toggle="dropdown" class="dropdown-toggle text-right">
                                <span class="ic-user pull-right">
                                    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                                    <!--You can use an image instead of an icon.-->
                                    <!--<img class="img-circle img-user media-object" src="img/profile-photos/1.png" alt="Profile Picture">-->
                                    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                                    <i class="psi-user" style="font-size: 55px;"></i>
                                </span>
                                <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                                <!--You can also display a user name in the navbar.-->
                                <!--<div class="username hidden-xs">Aaron Chavez</div>-->
                                <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                            </a>


                            <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right panel-default">
                                <ul class="head-list">
                                    <li>
                                        <a href="<?php echo base_url();?>login/lock" style="font-size: 25px;"><i class="psi-key-lock" style="font-size: 45px;"></i> Bloquear</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url();?>login/logout" style="font-size: 25px;"><i class="psi-lock-2" style="font-size: 45px;"></i> Cerrar Sesion</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                        <!--End user dropdown-->
                    </ul>
                </div>
            </div>
        </header>
			<div class="boxed">
				<!--CONTENT CONTAINER-->
				<div id="content-container">					
					<div id="page-content">