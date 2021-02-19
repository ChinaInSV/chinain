<div class="panel pad-no mar-no">
	<div class="panel-body">
		<?php foreach($ordenes as $orden):?>
		<input type="hidden" id="detalles-orden-id" value="<?php echo $orden->id;?>">
		<!--Informacion general-->
		<div class="row">
			<div class="col-md-6">
				<h5 class="text-main text-bold" style="margin:5px auto;">No. Orden: <span class="text-normal"><?php echo $orden->num_orden;?></span> <small>(ID: <?php echo $orden->id;?>)</small></h5>								
			</div>
			<div class="col-md-6">
				<h5 class="text-main text-bold" style="margin:5px auto;">Fecha: <span class="text-normal"><?php echo date("d-m-Y h:i a",strtotime($orden->fecha));?></span></h5>								
			</div>
			<div class="col-md-6">
				<h5 class="text-main text-bold" style="margin:5px auto;">Cliente: <span class="text-normal"><?php echo $orden->cliente;?></span></h5>								
			</div>
			<div class="col-md-6">
				<h5 class="text-main text-bold" style="margin:5px auto;">Destino: <span class="text-normal"></span></h5>								
			</div>
			<div class="col-md-6">
				<h5 class="text-main text-bold" style="margin:5px auto;">Mesero: <span class="text-normal"></span></h5>
			</div>
			<div class="col-md-6">
				<h5 class="text-main text-bold" style="margin:5px auto;">Servicio: <span class="text-normal">A domicilio</span></h5>
			</div>
			<div class="col-md-6">
				<h5 class="text-main text-bold" style="margin:5px auto;">Forma de Pago: <span class="text-normal"><?php echo ($orden->formapago==0)?"Efectivo":"POS";?></span></h5>
			</div>
		</div>
		<!--Tabla wrapper-->
		<div class="row bord-all">
			<!--Encabezado de tabla-->
			<table class="table table-hover table-vcenter" style="margin-bottom:0px;">
				<thead>
					<tr>
						<th></th>
						<th class="text-center">Cantidad</th>
						<th class="text-center">Descripcion</th>
						<th class="text-center">Precio</th>
						<th class="text-center">Total</th>
						<th></th>
					</tr>
				</thead>
			</table>
			<!--Tabla de productos-->
			<div style="overflow-y:scroll;height:200px;">
				<table class="table table-hover table-vcenter">
					<tbody>
						<?php if(count($orden->platos)):foreach($orden->platos as $plato):?>
						<tr style="<?php echo ($plato->eliminado)?"text-decoration:line-through;":"";?>">
							<td class="text-center"><i class="fa fa-circle fa-1x text-<?php echo ($plato->eliminado)?"danger":"success";?>"></i></td>
							<td class="text-center"><span class="text-main text-semibold"><?php echo number_format($plato->cant,$config->cant_decimal_precision->value)?></span></td>
							<td>
								<span class="text-main text-semibold"><?php echo $plato->nombre?></span>
								<?php $length=count($plato->acompanamientos);if($length):$i=0;?>
									<span class="text-main"> -
									<?php foreach($plato->acompanamientos as $acompanamiento):
									$i+=1;
									echo $acompanamiento->categoria.": ".$acompanamiento->acompanamiento;
									if($i<$length){
										echo ", ";
									}
									endforeach;?>
									</span>
								<?php endif;?>
								<br>
								<small class="text-muted"><?php echo $plato->notas?></small>
							</td>
							<td class="text-right"><span class="text-main"><?php echo number_format($plato->precio,$config->precios_decimal_precision->value);?></span></td>
							<td class="text-right"><span class="text-main"><?php echo number_format($plato->cant*$plato->precio,$config->precios_decimal_precision->value);?></span></td>
							<td class="text-center">
								<button class="btn btn-info btn-icon btn-circle orden-plato-detail-btn" data-id="<?php echo $plato->platoxorden;?>"><i class="fa fa-info"></i></button>
								<button class="btn btn-danger btn-icon btn-circle orden-plato-delete-btn <?php echo ($plato->eliminado)?"not-active":"";?>" data-id="<?php echo $plato->platoxorden;?>"><i class="fa fa-trash"></i></button>
							</td>
						</tr>
						<?php endforeach;endif;?>
					</tbody>
				</table>
			</div>
			<!---->
		</div>
		<div class="row">
			<div class="col-md-6 mar-top">
				<div class="row">
					<div class="col-md-6">
						<button class="btn btn-lg btn-danger orden-detalles-eliminar-btn" data-id="<?php echo $orden->id;?>">Eliminar Orden</button>						
					</div>
					<div class="col-md-6">
						<!--<button id="" class="btn btn-lg btn-warning btn-block orden-detalles-modificar-btn" data-id="<?php echo $orden->id;?>">Modificar</button>-->						
					</div>

					<div class="col-md-6">
						<!--<button class="btn btn-lg btn-purple mar-top btn-block">Cerrar</button>-->							
					</div>
				</div>
			</div>
			<!--Totales-->
			<div class="col-md-6 mar-top bg-gray-light">
				<!--Sumas-->
				<h5 class="text-normal col-xs-5 mar-no" style="line-height:20px;">Sumas</h5>
				<h5 class="text-normal col-xs-1 mar-no" style="line-height:20px;">$</h5>
				<h5 class="text-normal text-right col-xs-5 mar-no" style="line-height:20px;"><?php echo ($orden->subtotal?number_format($orden->subtotal,$config->totales_decimal_precision->value):'N/A');?></h5>
				<!--Propina-->
				<h5 class="text-normal col-xs-5 mar-no" style="line-height:20px;">Propina</h5>
				<h5 class="text-normal col-xs-1 mar-no" style="line-height:20px;">$</h5>
				<h5 class="text-normal text-right col-xs-5 mar-no" style="line-height:20px;"><?php echo ($orden->propina?number_format($orden->propina,$config->totales_decimal_precision->value):'N/A');?></h5>
				<!--Descuento-->
				<h5 class="text-normal col-xs-5 mar-no" style="line-height:20px;">Descuento</h5>
				<h5 class="text-normal col-xs-1 mar-no" style="line-height:20px;">$</h5>
				<h5 class="text-normal text-right col-xs-5 mar-no" style="line-height:20px;"><?php echo ($orden->descuento?number_format($orden->descuento,$config->totales_decimal_precision->value):'N/A');?></h5>
				
				<h4 class="text-bold col-xs-5 mar-no" style="line-height:20px;">Total</h4>
				<h4 class="text-bold col-xs-1 mar-no" style="line-height:20px;">$</h4>
				<h4 class="text-bold text-right col-xs-5 mar-no" style="line-height:20px;"><?php echo ($orden->subtotal?number_format($orden->subtotal+$orden->propina-$orden->descuento,$config->totales_decimal_precision->value):'N/A');?></h4>
			</div>
			<div class="col-md-12 mar-top bord-top pad-top text-center">
				<!--<button class="btn btn-lg btn-danger mar-top orden-detalles-eliminar-btn" data-id="<?php echo $orden->id;?>">Eliminar Orden</button>-->
				<button class="btn btn-lg btn-mint mar-top orden-detalles-precuenta-btn" data-id="<?php echo $orden->id;?>">Pre Cuenta</button>
				<button class="btn btn-lg btn-success mar-top orden-detalles-cobrar-btn" data-id="<?php echo $orden->id;?>">Cobrar</button>
			</div>
		</div>
	</div>
	<?php endforeach;?>
</div>