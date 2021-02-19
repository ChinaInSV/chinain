<div class="row" id="<?php $winid=date('YmdHis'); echo $winid;?>" style="background:#E9EAEE">
	<div class="pad-all">
		<div id="ordenes-contenido-wrapper" style="">
			<div class="row">
				<div class="col-md-8">
					<div class="panel">
						<div class="panel-body">
							<div class="row bord-btm pad-btm">
								<div class="col-sm-12 text-left bord-rgt">
									<div class="row ordenes-salones-wrapper">
										<?php if(count($salones)):foreach($salones as $salon):?>
										<div class="col-sm-2">
											<button data-toggle="button" class="ordenes-salones-btn bord-weight btn-block btn btn-lg <?php if(!$salon->precuenta):?>btn-gray-dark btn-active-success<?php else:?>btn-warning btn-active-success<?php endif;?>" type="button" data-id="<?php echo $salon->id;?>"><?php echo $salon->salon;?></button>	
										</div>
										<?php endforeach;endif;?>
									</div>
								</div>
								<div class="col-sm-12 text-right mar-top">
									<span class="label label-primary text-bold">Vacia</span>
									<span class="label label-info text-bold">En Proceso</span>
									<span class="label label-mint text-bold">Servida</span>
									<span class="label label-warning text-bold">Precuenta</span>
									<span class="label label-success text-bold">Facturada</span>
									<span class="label label-danger text-bold">No Disponible</span>
									<span class="label label-purple text-bold">Reservada</span>
								</div>
							</div>
							<div class="row" id="ordenes-mesas-wrapper" style="height:600px;overflow-y:auto;">
								<?php if(count($salones)):foreach($salones as $salon):if(is_array($salon->mesas)):?>
								<div class="mar-top ordenes-mesa-salon" style="display:none;" id="salon-<?php echo $salon->id;?>">
									<?php foreach($salon->mesas as $mesa):?>
										<div class="col-sm-2">
											<div class="mar-btm ordenes-mesa cursor-pointer" id="mesa-<?php echo $mesa->id;?>" style="width:100%;">
												<p class="text-bold text-lg text-center mar-top" style="margin-bottom:-20px;">
													<?php echo $mesa->mesa;?>
													<span class="text-bold text-muted" style="display:block;margin-top:5px;width:100%;text-align:center;"><?php echo ($mesa->cliente=="")?"&nbsp;":$mesa->cliente;?></span>
												</p>												
												<img src="<?php echo base_url();?>assets/img/tables/table-<?php echo $mesa->estado;?>.png" width="100%" height="100%;">
											</div>
										</div>
									<?php endforeach;?>
								</div>
								<?php endif;endforeach;endif;?>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="panel">
						<div class="panel-body">
							<div id="ordenes-detalles-wrapper" style="height:696px;overflow-y:auto;">
								<div class="well well-sm mar-all bg-gray-light">
									<div class="row">
										<div class="col-xs-3 text-right">
											<i class="fa fa-arrow-left fa-5x"></i>
										</div>
										<div class="col-xs-9">
											<h5>Seleccione una mesa</h5>
											<small>Haga clic sobre una mesa para ver los detalles</small>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>	
	$(document).ready(function () {
		var home_ordenes=new Home_ordenes();
		home_ordenes.initializeEnviroment("<?php echo base_url();?>","<?php echo $winid;?>");
    });
</script>