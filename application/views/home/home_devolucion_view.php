<div id="<?php $winid=date('YmdHis'); echo $winid;?>">
	<div class="row pad-btm bord-btm">
		<label class="col-sm-3 text-2x mar-top">No.referencia: </label>
		<div class="col-sm-4">
			<input type="text" id="devolucion-cargar-txt" class="form-control input-lg key-num">
		</div>
		<div class="col-sm-4 text-lft">
			<button id="devolucion-cargar-btn" class="btn btn-lg btn-mint">Cargar</button>
		</div>	
	</div>
	<div id="devolucion-info-wrapper" style="height:435px;">
		<div id="devolucion-msg-inf-wrapper" class="alert alert-info m-t-sm">
			<i class="fa fa-info-circle fa-2x"></i>
			<span class="p-sm">Ingrese el ID de la venta para poder cargar la información </span>
		</div>
	</div>
</div>
<script>
	var devolucion_view= new Devolucion_view();
	devolucion_view.initializeEnviroment("<?php echo base_url();?>","<?php echo $winid;?>",{
		cant_decimal_precision:<?php echo $config->cant_decimal_precision->value;?>,
		precios_decimal_precision: <?php echo $config->precios_decimal_precision->value;?>,
		totales_decimal_precision: <?php echo $config->totales_decimal_precision->value;?>
	},'<?php echo (!isset($id_orden)?"create":"update");?>');
	
	ChinaInTools.initializeKeyboard("<?php echo $winid;?>");
</script>