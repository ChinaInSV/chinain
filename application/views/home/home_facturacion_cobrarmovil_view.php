<div class="row" id="<?php echo $winID;?>">
	<!--Hiddens-->
	<input type="hidden" id="facturacion-cobrar-pago-total" value="<?php echo $total;?>">
	<input type="hidden" id="facturacion-cobrar-consumo" value="<?php echo $config->maximo_consumo_empleado->value;?>">
	<div class="panel">
		<!--Panel body-->
		<div class="panel-body">
			<div class="col-sm-12 bord-rgt">
				<div class="row mar-btm">
					<div class="col-sm-3">
						<p class="text-2x mar-top">Total:</p>
					</div>
					<div class="col-sm-9 bord-all bg-gray-light ">
						<p class="text-4x mar-no text-center ">$ <?php echo number_format($total,$config->totales_decimal_precision->value);?></p>
					</div>
				</div>
				<!--Forma de pago-->
				<div class="row text-center">
					<h3>Formas de pago</h3>
				</div>
				<div id="facturacion-forma-pago-wrapper" class="row bord-btm pad-btm mar-top">
					<div class="col-sm-12" style="height:50px;">
						<!--Efectivo-->
						<div class="col-sm-6 mar-btm">
							<button data-toggle="button" class="bord-weight facturacion-forma-pago-btn btn btn-block btn-lg btn-grey btn-active-info active" type="button" data-tipo="0">Efectivo</button>		
						</div>
						<!--POS-->
						<div class="col-sm-6 mar-btm">
							<button data-toggle="button" class="bord-weight facturacion-forma-pago-btn btn btn-block btn-lg btn-grey btn-active-info" type="button" data-tipo="1">POS</button>		
						</div>
					</div>
					
				</div>
				<div class="mar-all" id="facturacion-cobrar-pago-datos-wrapper" style="height:230px;">
					<div id="facturacion-cobrar-pago-efectivo-wrapper">
						<!--Efectivo-->
						<div class="row mar-btm">
							<label class="control-label col-sm-3 text-right">Efectivo:</label>
							<div class="col-sm-9">
								<input type="text" readonly id="facturacion-cobrar-pago-efectivo" class="form-control text-3x key-num" data-keyup="keyup" style="height:48px;"data-required="required" value="<?php echo number_format($total,$config->totales_decimal_precision->value);?>">
							</div>
						</div>
						<!--Cambio-->
						<div class="row mar-btm">
							<label class="control-label col-sm-3 text-right">Cambio:</label>
							<div class="col-sm-9">
								<input type="text" id="facturacion-cobrar-pago-cambio" class="form-control text-3x" style="height:48px;" value="0.00"readonly="true">
							</div>
						</div>
					</div>
					<div id="facturacion-cobrar-pago-pos-wrapper" class="text-center" style="display:none">
						<span class="text-mutted">Total POS</span>
						<h4 class="text-3x">$ <?php echo number_format($total,$config->totales_decimal_precision->value);?></h4>
					</div>
					<div id="facturacion-cobrar-pago-consumo-wrapper" class="text-center" style="display:none">
						<div class="row">
							<div class="col-sm-6">
								<span class="text-mutted">Consumo</span>
								<h4 class="text-3x">$ <?php echo number_format($total,$config->totales_decimal_precision->value);?></h4>
								<span class="text-mutted">Descuento Empleado</span>
								<h4 class="text-3x">$ <?php echo number_format($config->maximo_consumo_empleado->value,$config->totales_decimal_precision->value);?></h4>
								<span class="text-mutted">Total a Pagar</span>
								<h4 class="text-3x">$ <?php echo (number_format($total,$config->totales_decimal_precision->value) > $config->maximo_consumo_empleado->value)?(number_format($total - $config->maximo_consumo_empleado->value,$config->totales_decimal_precision->value)):"0.00";?></h4>
							</div>
							<div class="col-sm-6" id="facturacion-cobrar-pago-consumo-forma-wrapper" style="display:<?php echo (number_format($total,$config->totales_decimal_precision->value) > $config->maximo_consumo_empleado->value)?"block":"none";?>">
								<!--Efectivo-->
								<div class="row mar-btm">
									<label class="control-label col-sm-3 text-right">Efectivo:</label>
									<div class="col-sm-9">
										<input type="text" id="facturacion-cobrar-pago-efectivo-consumo" class="form-control text-3x key-num" data-keyup="keyup" style="height:48px;"data-required="required">
									</div>
								</div>
								<!--Cambio-->
								<div class="row mar-btm">
									<label class="control-label col-sm-3 text-right">Cambio:</label>
									<div class="col-sm-9">
										<input type="text" id="facturacion-cobrar-pago-cambio-consumo" class="form-control text-3x" style="height:48px;" value="0.00"readonly="true">
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row bord-top pad-top">
						<div id="facturacion-notas-wrapper">
							<label class="col-sm-3 control-label">Notas</label>
							<div class="col-sm-9">
								<input type="text" id="facturacion-cobrar-pago-notas" class="form-control" value="">
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-sm-12" style="visibility:hidden;position:absolute;">
				<div class="row text-center" style="visibility:hidden;position:absolute;">
					<h4>Documento de Facturaci&oacute;n</h4>
				</div>
				<!--Documento-->
				<div id="facturacion-documento-wrapper" class="row bord-btm pad-btm" style="visibility:hidden;position:absolute;">
					<!--Ticket-->
					<div class="col-sm-4 facturacion-documento-ticket-wrapper">
						<button data-toggle="button" class="bord-weight facturacion-documento-btn btn btn-block btn-lg btn-grey btn-active-info active facturacion-documento-btn-default" type="button" data-tipo="Ticket">Ticket</button>		
					</div>
					<div class="col-sm-4 facturacion-documento-recibo-wrapper" style="display:none;">
						<button data-toggle="button" class="bord-weight facturacion-documento-btn btn btn-block btn-lg btn-grey btn-active-info active" type="button" data-tipo="Recibo">Recibo</button>
					</div>
					<div class="col-sm-4 facturacion-documento-ccf-wrapper">
						<button data-toggle="button" class="bord-weight facturacion-documento-btn btn btn-block btn-lg btn-grey btn-active-info" type="button" data-tipo="CCF" disabled>CCF</button>		
					</div>
					<div class="col-sm-4 facturacion-documento-factura-wrapper">
						<button data-toggle="button" class="bord-weight facturacion-documento-btn btn btn-block btn-lg btn-grey btn-active-info" type="button" data-tipo="Factura" disabled>Factura</button>		
					</div>
				</div>
				<div class="row" style="visibility:hidden;position:absolute;">
					<label class="col-sm-3 control-label" for="demo-hor-inputemail">Numero de Comprobante</label>
					<div class="col-sm-9">
						<input type="text" placeholder="Automatico" id="" class="form-control" disabled>
					</div>
				</div>
				<!--Cliente-->
				<div class="row bord-top pad-top" style="visibility:hidden;position:absolute;">
					<div id="facturacion-cliente-wrapper">
						<label class="col-sm-3 control-label">Cliente</label>
						<div class="col-sm-9">
							<div class="input-group">
								<input type="text" id="facturacion-cobrar-pago-cliente" class="form-control" value="<?php echo $cliente;?>">
								<span class="input-group-btn">
									<button class="btn btn-success btn-lg" disabled id="facturacion-buscar-orden-btn"><i class="fa fa-search"></i></button>
								</span>
							</div>
						</div>
					</div>
					<div id="facturacion-empleado-wrapper" style="display:none;">
						<label class="col-sm-3 control-label">Empleado</label>
						<div class="col-sm-9">
							<select id="facturacion-cobrar-pago-empleado" class="form-control input-lg">
							<option disabled selected value="">Seleccione un empleado</option>
							<?php if(count($empleados)):foreach($empleados as $empleado):if($empleado->consumo==false):?><option value="<?php echo $empleado->id_empleado;?>"><?php echo $empleado->nombre_empleado;?></option><?php endif;endforeach;endif;?>
							</select>
						</div>
					</div>
				</div>
				<!--Documento cliente-->
				<div class="row pad-top" style="visibility:hidden;position:absolute;">
					<label class="col-sm-3 control-label" for="demo-hor-inputemail">Documento</label>
					<div class="col-sm-3">
						<select id="" class="form-control input-lg">
							<option>DUI</option>
							<option>NIT</option>
							<option>Pasaporte</option>
							<option>Licencia</option>
						</select>
					</div>
					<div class="col-sm-6">
						<input type="text" placeholder="" id="demo-hor-inputemail" class="form-control">
					</div>
				</div>
				<!--Servicio-->
				<div class="row text-center mar-top"  style="visibility:hidden;position:absolute;">
					<h4>Para</h4>
				</div>
				<div id="facturacion-servicio-wrapper" class="row bord-btm pad-btm" style="visibility:hidden;position:absolute;">
					<!--Comer aca-->
					<div class="col-sm-6">
						<button data-toggle="button" class="bord-weight facturacion-servicio-btn btn btn-block btn-lg btn-grey btn-active-info active" type="button" data-tipo="Para comer aca">Comer aca</button>
					</div>
					<!--Llevar-->
					<div class="col-sm-6">
						<button data-toggle="button" class="bord-weight facturacion-servicio-btn btn btn-block btn-lg btn-grey btn-active-info" type="button" data-tipo="Para llevar" disabled>Llevar</button>
					</div>
					<div class="col-sm-12 pad-ver">
					</div>
					<!--Comer aca-->
					<div class="col-sm-6">
						<button data-toggle="button" class="bord-weight facturacion-servicio-btn btn btn-block btn-lg btn-grey btn-active-info" type="button" data-tipo="Domicilio" disabled>Domicilio</button>
					</div>
					<!--Llevar-->
					<div class="col-sm-6">
						<button data-toggle="button" class="bord-weight facturacion-servicio-btn btn btn-block btn-lg btn-grey btn-active-info" type="button" data-tipo="Domicilio a pie" disabled>Domicilio a pie</button>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row text-center mar-top">
		<button type="button" id="facturacion-cobrar-pago-cobrar-btn" class="btn btn-lg btn-success btn-labeled fa fa-save">Cobrar</button>
		<button type="button" id="" onclick="Custombox.close();" class="btn btn-lg btn-danger btn-labeled fa fa-window-close">Salir</button>
	</div>
</div>
<script>
	ChinaInTools.initializeKeyboard("<?php echo $winID;?>");
</script>