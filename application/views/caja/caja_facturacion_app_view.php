<div class="row" id="<?php echo $winID;?>">
	<div id="facturacion-app-form" data-urlSaveForm="<?php echo base_url();?>caja/guardar_transaccion" class="form-tools">
		<div class="panel">
			<div class="panel-body">
				<!--Agregar producto/orden/cuenta-->
				<div class="row">
					<!--Informacion de producto-->
					<div class="col-sm-10">
						<div id="facturacion-app-platos-info" class="row">
							<!--Producto-->
							<div class="col-sm-4">
								<label>Producto</label>
								<select data-type="select2" data-placeholder="Seleccione un producto..." data-allow-clear="true" id="facturacion-app-platos-select" class="form-control form-table" data-fieldName="Plato" data-required="required">
									<option></option>									
									<?php if(count($platos)):foreach($platos as $plato):?><option value="<?php echo $plato->id_plato;?>" data-precio="<?php echo $plato->precio_plato;?>" data-id="<?php echo $plato->id_plato;?>"><?php echo $plato->nombre_plato;?></option><?php endforeach;endif;?>
								</select>
								<input type="hidden" id="facturacion-app-plato-id" value="">
							</div>
							<!--Cantidad-->
							<div class="col-sm-2">
								<label>Cantidad</label>
								<input type="number" class="form-control form-table" value="" id="facturacion-app-plato-cantidad" data-fieldName="Cantidad" data-required="required">
							</div>
							<!--Precio-->
							<div class="col-sm-2">
								<label>Precio</label>
								<input type="text" class="form-control form-table" value="" id="facturacion-app-plato-precio" data-fieldName="Precio" data-required="required">
							</div>
							<!--Total-->
							<div class="col-sm-2">
								<label>Total</label>
								<input type="text" class="form-control" value="" readonly id="facturacion-app-plato-total">
							</div>
							<!--Agregar btn-->
							<div class="col-sm-2">
								<button class="btn btn-info" style="margin-top:24px;" id="facturacion-app-plato-agregar">Agregar</button>
							</div>
						</div>
					</div>
					<!--Cargar orden/cuenta-->
					<div class="col-sm-2 text-center bord-all">
						<div style="padding:5px;">
							<div class="input-group">
								<input type="text" class="form-control" id="facturacion-app-cargar-orden-text">
								<span class="input-group-btn">
									<button class="btn btn-success" id="facturacion-buscar-orden-btn"><i class="fa fa-search"></i></button>
								</span>
							</div>
							<button class="btn btn-info" style="margin:5px;" id="facturacion-app-cargar-orden-btn" data-function="set">Cargar orden</button>
							<!--Informacion de la orden cargada-->
							<!--Ordenn-->
							<input type="hidden" id="facturacion-app-orden-id" value="">
							<!--Cliente-->
							<input type="hidden" id="facturacion-app-orden-cliente-id" value="">
							<input type="hidden" id="facturacion-app-orden-cliente-nombre" value="">
							<!--Mesero-->
							<input type="hidden" id="facturacion-app-orden-mesero-id" value="">
							
						</div>
					</div>
				</div>
				<div class="mar-top mar-btm bord-top"></div>
				<!--Tabla productos-->
				<div class="row">
					<!--Encabezado-->
					<table class="table table-hover table-vcenter bg-gray" style="margin-bottom:0px;">
						<thead>
							<tr>
								<th width="50%" style="text-align:center;">Producto</th>
								<th width="12%" style="text-align:left;">Cantidad</th>
								<th width="12%" style="text-align:left;">Precio</th>
								<th width="16%" style="text-align:left;">Total</th>
								<th width="10%" style="text-align:center;"></th>
							</tr>
						</thead>
					</table>
					<!--Cuerpo de tabla-->
					<div class="bord-all" style="overflow-y:scroll;height:200px;">
						<div id="facturacion-app-platos-wrapper">
							<table class="table table-hover table-vcenter table-striped">
								<tbody>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<!--Totales y operaciones-->
				<div class="row">
					<!--Operaciones-->
					<div class="col-md-8 ">
						<!--<div class="row">
							<div class="col-lg-12">
								<div class="checkbox">
									<input id="facturacion-app-resumircontenido-checkbox" class="magic-checkbox" type="checkbox">
									<label for="facturacion-app-resumircontenido-checkbox"><span class="text-semibold">Resumir detalle de productos a "Consumo"</span></label>
								</div>
							</div>
						</div>-->
						<!--Descuentos, propina y vip-->
						<div class="row mar-top bord-all pad-top pad-btm">
							<!--VIP-->
							<div class="col-md-4">
								<!--<button class="btn btn-block btn-purple" type="button">Usar tarjeta VIP</button>-->		
							</div>
							<!--Propina-->
							<div class="col-md-4">
								<?php if(isset($config->propina_aplicar) && $config->propina_aplicar->value):?>
								<button type="button" data-toggle="button" class="btn btn-block btn-grey btn-active-info active" id="facturacion-app-propina-btn" data-function="unset">Quitar Propina</button>
								<?php endif;?>
							</div>
							<!--Descuento-->
							<div class="col-md-4">
								<button type="button" class="btn btn-block btn-grey" id="facturacion-app-descuento-btn" data-function="set">Aplicar Descuento</button>		
							</div>
						</div>
					</div>
					<!--Totales-->
					<div class="col-md-4 mar-top">
						<div class="row pad-lft pad-rgt">
							<table class="ufood-transactions-table">
								<tr id="facturacion-totales-sumas">
									<td class="total-name">Sumas</td>
									<td class="total-symbol">$</td>
									<td class="total-value" data-value="">0.00</td>
								</tr>
								<tr id="facturacion-totales-propina">
									<td class="total-name">+ Propina</td>
									<td class="total-symbol">$</td>
									<td class="total-value" data-value="">0.00</td>
								</tr>
								<tr id="facturacion-totales-descuento">
									<td class="total-name">- Descuento</td>
									<td class="total-symbol">$</td>
									<td class="total-value" data-value="">0.00</td>
								</tr>
								<tr class="bord-all bg-gray-light" id="facturacion-totales-total">
									<td class="total-name"><span class="text-semibold text-2x">TOTAL</span></td>
									<td class="total-symbol"><span class="text-semibold text-2x">$</span></td>
									<td class="total-value" data-value=""><span class="text-semibold text-2x">0.00</span></td>
								</tr>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!--Modales-->
		<div id="facturacion-app-modals-wrapper">
			<!--Descuentos-->
			<div class="modal fade" id="facturacion-app-descuento-<?php echo $winID;?>" data-parent="#<?php echo $winID;?>" role="dialog" tabindex="-1" aria-hidden="true">
				<div class="modal-dialog modal-sm">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal"><i class="fa fa-times"></i></button>
							<h4 class="modal-title">Descuento</h4>
						</div>
						<div class="modal-body bg-gray">
							<div class="row">
								<div class="col-sm-4">
									<select class="form-control" id="facturacion-app-descuento-tipo">
										<option value="0" selected>%</option>
										<option value="1">$</option>
									</select>
								</div>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="facturacion-app-descuento-valor">
								</div>
							</div>
							<div class="row text-center mar-top">
								<button type="button" class="btn btn-lg btn-success" id="facturacion-app-descuento-aplicar-btn">Aplicar</button>
								<button type="button" class="btn btn-lg btn-danger" id="facturacion-app-descuento-cancelar-btn">Canelar</button>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!--Multiples resultados de busqueda de ordenes-->
			<div class="modal fade" id="facturacion-app-multiples-ordenes-<?php echo $winID;?>" data-parent="#<?php echo $winID;?>" data-keyboard="false" role="dialog" tabindex="-1" aria-hidden="true">
				<div class="modal-dialog modal-md">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" id="facturacion-app-multiples-ordenes-cerrar"><i class="fa fa-times"></i></button>
							<h4 class="modal-title">Seleccione una orden para cargar.</h4>
						</div>
						<div class="modal-body bg-gray">
							<div class="row">
								<div id="facturacion-app-mutiples-ordenes-wrapper">
									<table class="table">
										<tbody>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!--Procesar pago-->
			<div class="modal fade" id="facturacion-app-procesar-venta-<?php echo $winID;?>" data-parent="#<?php echo $winID;?>" role="dialog" tabindex="-1" aria-hidden="true">
				<div class="modal-dialog modal-sm">
					<div class="modal-content">
						<div class="modal-header">
							<h4 class="modal-title">Venta</h4>
						</div>
						<div class="modal-body bg-gray">
							<div class="text-center mar-btm">
								<i id="facturacion-app-procesar-venta-icon" class="fa fa-spinner fa-5x"></i></br>
								<span id="facturacion-app-procesar-venta-text">Procesando venta...</span>
							</div>
							<!--Total-->
							<div class="row bord-btm">
								<span class="col-sm-5 text-right text-main text-2x">Total</span>
								<div class="col-sm-1 text-right">
									<p class="text-main text-2x">$</p>
								</div>
								<div class="col-sm-4 text-right">
									<p id="facturacion-app-venta-cobro-total" class="text-main text-2x">15.00</p>
								</div>
							</div>
							<!--Efectivo-->
							<div class="row">
								<span class="col-sm-5 text-right text-main text-2x">Efectivo</span>
								<div class="col-sm-1 text-right">
									<p class="text-main text-2x">$</p>
								</div>
								<div class="col-sm-4 text-right">
									<p id="facturacion-app-venta-cobro-efectivo"  class="text-main text-2x">15.00</p>
								</div>
							</div>
							<!--Cambio-->
							<div class="row text-center bord-all bg-gray-light ">
								<span class="text-main">Cambio</span>
								<p id="facturacion-app-venta-cobro-cambio" class=" text-semibold text-3x text-info">$ 0.75</p>
							</div>
							<div class="text-center bord-top mar-top pad-all">
								<button id="facturacion-app-venta-cobro-salir-btn" class="btn btn-danger btn-lg" disabled>Salir</button>
							</div>
						</div>
					</div>
				</div>
			</div>
	</div>
		
		
		<!--Botones-->
		<div class="row text-center">
			<button type="button" id="facturacion-app-cobrar-btn" onclick="" class="btn btn-lg btn-success btn-labeled fa fa-save">Cobrar</button>
			<!--<button type="button" id="" onclick="" class="btn btn-lg btn-warning btn-labeled fa fa-save">Precuenta</button>-->
			<button type="button" id="" onclick="Custombox.close();" class="btn btn-lg btn-danger btn-labeled fa fa-window-close">Salir</button>
		</div>
	</div>
</div>
<script>
	$(document).ready(function () {
		var caja_facturacion=new Caja_facturacion();
		caja_facturacion.initializeEnviroment("<?php echo base_url();?>","<?php echo $winID;?>",<?php echo json_encode($config);?>);
    });
</script>