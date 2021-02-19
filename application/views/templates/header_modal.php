<style>
	.modal-xxl {
		width: 1800px;
	}
	.modal-xl {
		width: 1400px;
	}
	.modal-mxl {
		width: 1200px;
	}
	.modal-full {
		width: 100%!important;
		height: 100%!important;
	}
	.modal-custom{
		width:<?php echo (isset($width))?$width."px":"100%";?>!important;
	}
	.custombox-modal-wrapper{
		overflow:hidden!important;
	}
</style>
<div class="modal-dialog <?php if(isset($classes)) echo $classes;?>" <?php if(isset($id)) echo "id='".$id."'";?>>
	<div class="modal-content">
		<div class="modal-header bg-dark" style="height:65px;padding:8px 15px;">
			<?php if(!isset($close_button) || $close_button):?>
			<button type="button" class="close text-light" style="top:19px;" onclick="javascript:Custombox.close()"><i class="fa fa-times-circle-o fa-3x text-light"></i></button>
			<?php endif;?>
			<img src="<?php echo base_url();?>assets/img/chinainlogowhite.png" alt="" class="" style="height:50px;display:inline-block;float:left;"><h4 style="margin-left:20px;display:inline-block;margin-top:8px;" class="modal-title text-light text-2x text-light" ><?php if(isset($title))echo $title; else echo "Nueva ventana";?></h4>
		</div>
		<div class="modal-body">