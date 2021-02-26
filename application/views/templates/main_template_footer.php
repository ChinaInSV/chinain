				</div>
			</div>
        </div>
		<!-- FOOTER -->
        <footer id="footer">
			<div class="hide-fixed pull-right pad-rgt">
				<a href="#" target="_blank">Desarrollado por Xypnos.</a>
			</div>
            <p class="pad-lft">&#0169; 2016 - <?php echo date("Y");?> LONG TERM EVOLUTION MOBILE GROUP - CHINA INN EXPRESS</p>
        </footer>
        <!-- SCROLL PAGE BUTTON -->
        <button class="scroll-top btn">
            <i class="pci-chevron chevron-up"></i>
        </button>
    </div>
	<script src="<?php echo base_url();?>assets/plugins/custombox/js/custombox.min.js"></script>
	<script src="<?php echo base_url();?>assets/plugins/toastr/toastr.min.js"></script>
	<script src="<?php echo base_url();?>assets/plugins/zebra/js/zebra_dialog.src.js"></script>
	<script src="<?php echo base_url();?>assets/plugins/sweetalert/js/sweetalert.min.js"></script>
	<script src="<?php echo base_url();?>assets/plugins/jquery_hotkeys/jquery.hotkeys.js"></script>
	<script src="<?php echo base_url();?>assets/js/idle-timer.js"></script>
	<script>
		ChinaInTools.initializeEnviroment("<?php echo base_url();?>");
	</script>
	<!-- JS Loader-->		
	<?php if(isset($js_files["footer"]) && count($js_files["footer"]) > 0):foreach($js_files["footer"] as $js_footer_file):?><script src="<?php echo base_url("assets/js")."/".$js_footer_file.".js";?>"></script>
	<?php endforeach;endif;?>
	<!--Plugis Loader-->
	<?php if(isset($plugins_files) && count($plugins_files)>0):foreach($plugins_files as $plugin_file):foreach($plugin_file["files"] as $file):if($file["place"]==="footer"):switch($file["type"]):case "css":?><link href="<?php echo base_url("assets/plugins/")."/".$plugin_file["name"]."/".$file["file"].".css";?>" rel="stylesheet">
	<?php break;case "js": ?><script src="<?php echo base_url("assets/plugins/")."/".$plugin_file["name"]."/".$file["file"].".js";?>"></script>
	<?php break;endswitch;endif;endforeach;endforeach;endif;?>
</body>
</html>