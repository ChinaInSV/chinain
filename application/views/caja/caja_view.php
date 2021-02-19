<div class="row" id="<?php echo $winID;?>">
	<!--Aplicaciones-->
	<div class="col-lg-7">
		<div class="panel">
			<div class="panel-heading">
				<h3 class="panel-title">Aplicaciones</h3>
			</div>
			<div class="panel-body">
				<!--Facuracion-->
				<div class="col-sm-4">
					<a href="javascript:void(0);" id="caja-facturacion-btn">
						<div class="panel panel-info panel-colorful">
							<div class="pad-all text-center">
								<i class="fa fa-money fa-3x"></i>
								<p class="text-2x mar-no text-semibold">Facuraci&oacute;n</p>
							</div>
						</div>
					</a>
				</div>
				<!--Devolucion-->
				<div class="col-sm-4">
					<a href="javascript:void(0);" id="caja-devolucion-btn">
						<div class="panel panel-warning panel-colorful">
							<div class="pad-all text-center">
								<i class="fa fa-minus-square-o fa-3x"></i>
								<p class="text-2x mar-no text-semibold">Devoluci&oacute;n</p>
							</div>
						</div>
					</a>
				</div>
				<!--Caja chica-->
				<div class="col-sm-4">
					<a href="javascript:void(0);" id="caja-caja-chica-btn">
						<div class="panel panel-success panel-colorful">
							<div class="pad-all text-center">
								<i class="fa fa-exchange fa-3x"></i>
								<p class="text-2x mar-no text-semibold">Caja chica</p>
							</div>
						</div>
					</a>
				</div>
				<!--Cortes-->
				<div class="col-sm-4">
					<a href="javascript:void(0);"  id="caja-cortes-btn">
						<div class="panel panel-purple panel-colorful">
							<div class="pad-all text-center">
								<i class="fa fa-align-justify fa-3x"></i>
								<p class="text-2x mar-no text-semibold">Cortes</p>
							</div>
						</div>
					</a>
				</div>
			</div>
		</div>
	</div>
	<!--Detalles de caja-->
	<div class="col-lg-5">
		<div class="panel">
			<div class="panel-heading">
				<h3 class="panel-title">Detalles</h3>
			</div>
			<div class="panel-body">
				<?php if(isset($caja)):?>
				<!--Nombre caja-->
				<div class="row">
					<div class="col-md-12">
						<h1 class="text-2x bord-btm pad-btm"><?php echo $caja->nombre_caja;?></h1>
					</div>
				</div>
				<!--Estado-->
				<div class="row">
					<div class="col-md-4">
						<p class="text-semibold">Estado:</p>								
					</div>
					<div class="col-md-8">
						<p class="text-normal"><span class="badge badge-<?php if($caja->estado_caja==0) echo "warning"; else echo "success";?>"><?php if($caja->estado_caja==0) echo "Inactiva"; else echo "Activa";?></span></p>								
					</div>
				</div>
				<!--Direccion IP-->
				<div class="row">
					<div class="col-md-4">
						<p class="text-semibold">Direcci&oacute;n IP:</p>								
					</div>
					<div class="col-md-8">
						<p class="text-normal"><?php echo $caja->dir_ip_caja;?></p>								
					</div>
				</div>
				<!--Ultimo corte X-->
				<div class="row">
					<div class="col-md-4">
						<p class="text-semibold">Ultimo corte X:</p>								
					</div>
					<div class="col-md-8">
						<p class="text-normal"><?php echo date("d-m-Y H:i:s", strtotime($lastCorteXI));?> <button class="btn btn-info btn-xs">Ver</button></p>								
					</div>
				</div>
				<!--Ultimo corte Z-->
				<div class="row">
					<div class="col-md-4">
						<p class="text-semibold">Ultimo corte X Parcial:</p>								
					</div>
					<div class="col-md-8">
						<p class="text-normal"><?php echo date("d-m-Y H:i:s", strtotime($lastCorteXP));?> <button class="btn btn-info btn-xs">Ver</button></p>								
					</div>
				</div>
				<!--Ultimo corte Z mensual-->
				<div class="row">
					<div class="col-md-4">
						<p class="text-semibold">Ultimo corte Z:</p>								
					</div>
					<div class="col-md-8">
						<p class="text-normal"><?php echo date("d-m-Y H:i:s", strtotime($lastCorteZ));?> <button class="btn btn-info btn-xs">Ver</button></p>								
					</div>
				</div>
				<?php else:?>
					<div class="alert alert-warning">
						<h3 class="text-light"><i class="fa fa-exclamation-circle fa-2x"></i> Este equipo no es una caja</h3>
						<p> Las aplicaciones relacionadas con facturaci&oacute;n de productos unicamente estan disponibles en equipos que han sido registrados como cajas.</p>
						<p>Para agregar una nueva caja vaya al menu Administraci&oacute;n -> Facturaci&oacute;n -> Nueva caja.</p>
					</div>
				<?php endif;?>
			</div>
		</div>
	</div>
</div>
<script>
$(document).ready(function(){
	var cajas=new Caja();
	cajas.initializeEnviroment("<?php echo base_url();?>","<?php echo $winID;?>");
});
</script>