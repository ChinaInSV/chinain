<div class="panel pad-no mar-no">
	<div class="panel-heading">
		<div class="panel-control">
			<div class="dropdown">
				<button class="dropdown-toggle btn btn-default btn-active-primary" data-toggle="dropdown" aria-expanded="false"><i class="pli-dot-vertical"></i></button>
				<ul class="dropdown-menu dropdown-menu-right" style="">
					<?php switch($mesaData->estado_mesa):case "4":case "5":case "6":?>
					<li><a href="javascript:void(0);" data-id="<?php echo $mesa;?>" class="detalles-mesa-estado-btn" data-estado="0">Cambiar estado a vacia</a></li>
					<?php break;case "0":?>
					<li><a href="javascript:void(0);" data-id="<?php echo $mesa;?>" class="detalles-mesa-estado-btn" data-estado="5">Cambiar estado a No disponible</a></li>
					<li><a href="javascript:void(0);" data-id="<?php echo $mesa;?>" class="detalles-mesa-estado-btn" data-estado="6">Cambiar estado a Reservada</a></li>
					<?php break;case "1":?>
					<li><a href="javascript:void(0);" data-id="<?php echo $mesa;?>" class="detalles-mesa-estado-btn" data-estado="2">Cambiar estado a Servida</a></li>
					<?php break;case "2":?>
					<li><a href="javascript:void(0);" data-id="<?php echo $mesa;?>" class="detalles-mesa-estado-btn" data-estado="1">Cambiar estado a en Proceso</a></li>
					<?php break;endswitch;?>
				</ul>
			</div>
		</div>
		<h3 class="panel-title">Ordenes</h3>
	</div>
	<div class="panel-body">
		<ul id="tab-list" class="nav nav-tabs" role="tablist">
		<input type="hidden" id="detalles-mesa-id" value="<?php echo $mesa;?>">
		<?php if(isset($ordenes)):$order_num=1;foreach($ordenes as $orden):?>
			<li class="<?php echo ($order_num==1)?"active":"";?>"><a href="#tab<?php echo $order_num;?>" role="tab" data-toggle="tab">Orden <?php echo $orden->num_orden;?> <button class="close mar-lft" type="button" title="Cerrar Orden">×</button></a></li>
		<?php $order_num++;endforeach;?>
		</ul>
		<div id="tab-content" class="tab-content">
			<?php $order_num=1;foreach($ordenes as $orden):?>
			<div class="tab-pane <?php echo ($order_num==1)?"in active":"";?>" id="tab<?php echo $order_num;?>">
				<!--Informacion general-->
				<div class="row mar-top">
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
						<h5 class="text-main text-bold" style="margin:5px auto;">Destino: <span class="text-normal"><?php echo $orden->salon." - ".$orden->mesa;?></span></h5>								
					</div>
					<div class="col-md-6">
						<h5 class="text-main text-bold" style="margin:5px auto;">Mesero: <span class="text-normal"><?php echo $orden->mesero;?></span></h5>
					</div>
					<div class="col-md-6">
						<h5 class="text-main text-bold" style="margin:5px auto;">Servicio: <span class="text-normal"><?php echo $orden->servicio;?></span></h5>
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
			<?php $order_num++;endforeach;?>
		</div>
		<?php else:?>
		<div class="well well-sm mar-all bg-gray-light">
			<div class="row">
				<div class="col-xs-3 text-right">
					<i class="fa fa-arrow-left fa-5x"></i>
				</div>
				<div class="col-xs-9">
					<h5>No hay Ordenes que mostrar</h5>
					<small>Haga clic sobre otra mesa para ver los detalles</small>
				</div>
			</div>
		</div>
		<?php endif;?>
	</div>
</div>