<div class="row" id="<?php echo $winID;?>">
	<!--Hiddens-->
	<input type="hidden" id="facturacion-cobrar-pago-total" value="<?php echo $total;?>">
	<input type="hidden" id="facturacion-cobrar-consumo" value="<?php echo $config->maximo_consumo_empleado->value;?>">
	<div class="panel">
		<!--Panel body-->
		<div class="panel-body">
			<div class="col-sm-6 bord-rgt">
				<div class="row mar-btm">
					<div class="col-sm-3">
						<p class="text-2x mar-top">Total:</p>
					</div>
					<div class="col-sm-9 bord-all bg-gray-light ">
						<p class="text-4x mar-no text-center" id="facturacion-cobrar-pago-total-text">$ <?php echo number_format($total,$config->totales_decimal_precision->value);?></p>
					</div>
				</div>
				<!--Forma de pago-->
				<div class="row text-center">
					<h3>Formas de pago</h3>
				</div>
				<div id="facturacion-forma-pago-wrapper" class="row bord-btm pad-btm mar-top">
					<div class="col-sm-6" style="height:100px;">
						<!--Efectivo-->
						<div class="col-sm-6 mar-btm">
							<button data-toggle="button" class="bord-weight facturacion-forma-pago-btn btn btn-block btn-lg btn-gray-dark btn-active-info active" type="button" data-tipo="0">Efectivo</button>		
						</div>
						<!--POS-->
						<div class="col-sm-6 mar-btm">
							<button data-toggle="button" id="facturacion-forma-pago-pos-btn" class="bord-weight facturacion-forma-pago-btn btn btn-block btn-lg btn-gray-dark btn-active-info" type="button" data-tipo="1">POS</button>		
						</div>
						<!--Mixto-->
						<div class="col-sm-6">
							<button data-toggle="button" class="bord-weight facturacion-forma-pago-btn btn btn-block btn-lg btn-gray-dark btn-active-info" type="button" data-tipo="2">Mixto</button>		
						</div>
						<!-- Agregado Oswaldo -->
						<!--Descuento-->
						<div class="col-sm-6">
							<button data-toggle="button" class="bord-weight facturacion-forma-pago-btn btn btn-block btn-lg btn-gray-dark btn-active-info" type="button" data-tipo="10">Descuento</button>		
						</div>
						<!--/oswaldo-->
					</div>
					<div class="col-sm-6">
						<!--Empleado-->
						<div class="col-sm-6 mar-btm">
							<button data-toggle="button" class="bord-weight facturacion-forma-pago-btn btn btn-block btn-lg btn-gray-dark btn-active-info" type="button" data-tipo="9">Consumo</button>		
						</div>
						<!--Gift Card-->
						<div class="col-sm-6 mar-btm">
							<button data-toggle="button" class="bord-weight facturacion-forma-pago-btn btn btn-block btn-lg btn-gray-dark btn-active-info" type="button" data-tipo="8" disabled>Gift Card</button>		
						</div>
						<!--Tarjetas-->
						<div class="col-sm-6">
							<button data-toggle="button" class="bord-weight facturacion-forma-pago-btn btn btn-block btn-lg btn-gray-dark btn-active-info" type="button" data-tipo="7" disabled>Tarjeta</button>		
						</div>
					</div>
					
				</div>
				<div class="mar-all" id="facturacion-cobrar-pago-datos-wrapper" style="height:230px;">
					<div id="facturacion-cobrar-pago-efectivo-wrapper">
						<!--Efectivo-->
						<div class="row mar-btm">
							<label class="control-label col-sm-3 text-right">Efectivo:</label>
							<div class="col-sm-9">
								<input type="text" id="facturacion-cobrar-pago-efectivo" class="form-control text-3x key-num" data-keyup="keyup" style="height:48px;"data-required="required">
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
					<div id="facturacion-cobrar-pago-mixto-wrapper" style="display:none">
						<!--POS-->
						<div class="row mar-btm">
							<label class="control-label col-sm-3 text-right">POS:</label>
							<div class="col-sm-9">
								<input type="text" id="facturacion-cobrar-pago-pos-mixto" class="form-control text-3x key-num" data-keyup="keyup" style="height:48px;"data-required="required">
							</div>
						</div>
						<!--Efectivo-->
						<div class="row mar-btm">
							<label class="control-label col-sm-3 text-right">Efectivo:</label>
							<div class="col-sm-9">
								<input type="text" id="facturacion-cobrar-pago-efectivo-mixto" class="form-control text-3x key-num" data-keyup="keyup" style="height:48px;"data-required="required">
							</div>
						</div>
						<!--Cambio-->
						<div class="row mar-btm">
							<label class="control-label col-sm-3 text-right">Cambio:</label>
							<div class="col-sm-9">
								<input type="text" id="facturacion-cobrar-pago-cambio-mixto" class="form-control text-3x" style="height:48px;" value="0.00"readonly="true">
							</div>
						</div>
					</div>
					<!--oswaldo-->
					<div id="facturacion-cobrar-descuento-wrapper" style="display:none">
						<!--POS-->
						<div class="row mar-btm">
							<label class="control-label col-sm-3 text-right">Valor Descuento:</label>
							<div class="col-sm-9">
								<input type="text" id="facturacion-cobrar-valor-descuento" class="form-control text-3x key-num" data-keyup="keyup" style="height:48px;"data-required="required">
							</div>
						</div>
					</div>
					<!--/oswaldo-->
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
				</div>
			</div>
			<div class="col-sm-6">
				<div class="row text-center">
					<h4>Documento de Facturaci&oacute;n</h4>
				</div>
				<!--Documento-->
				<div id="facturacion-documento-wrapper" class="row bord-btm pad-btm">
					<!--Ticket-->
					<div class="col-sm-3 facturacion-documento-ticket-wrapper">
						<button data-toggle="button" class="bord-weight facturacion-documento-btn btn btn-block btn-lg btn-grey btn-active-info active facturacion-documento-btn-default" type="button" data-tipo="0">Ticket</button>		
					</div>
					<div class="col-sm-3 facturacion-documento-ninguno-wrapper">
						<button data-toggle="button" class="bord-weight facturacion-documento-btn btn btn-block btn-lg btn-grey btn-active-info" type="button" data-tipo="9">Ninguno</button>		
					</div>
					<div class="col-sm-3 facturacion-documento-recibo-wrapper" style="display:none;">
						<button data-toggle="button" class="bord-weight facturacion-documento-btn btn btn-block btn-lg btn-grey btn-active-info active" type="button" data-tipo="3">Recibo</button>
					</div>
					<div class="col-sm-3 facturacion-documento-ccf-wrapper">
						<button data-toggle="button" class="bord-weight facturacion-documento-btn btn btn-block btn-lg btn-grey btn-active-info" type="button" data-tipo="2">CCF</button>		
					</div>
					<div class="col-sm-3 facturacion-documento-factura-wrapper">
						<button data-toggle="button" class="bord-weight facturacion-documento-btn btn btn-block btn-lg btn-grey btn-active-info" type="button" data-tipo="1">Factura</button>		
					</div>
				</div>
				<div class="row">
					<label class="col-sm-2 control-label" for="facturacion-documento-numero">Numero</label>
					<div class="col-sm-10">
						<input type="text" placeholder="Automatico" id="facturacion-documento-numero" class="form-control" disabled>
					</div>
				</div>
				<!--Cliente-->
				<div class="row bord-top pad-top">
					<div id="facturacion-cliente-wrapper">
						<label class="col-sm-2 control-label">Cliente</label>
						<div class="col-sm-10">
							<div class="input-group">
								<input type="text" id="facturacion-cobrar-pago-cliente" class="form-control" value="<?php echo $cliente;?>">
								<input type="hidden" id="facturacion-cobrar-pago-cliente-id" class="form-control" value="">
								<span class="input-group-btn">
									<button class="btn btn-success btn-lg" id="facturacion-cobrar-cliente-buscar-btn" data-function="set"><i class="fa fa-search"></i></button>
								</span>
							</div>
						</div>
					</div>
					<div id="facturacion-empleado-wrapper" style="display:none;">
						<label class="col-sm-2 control-label">Empleado</label>
						<div class="col-sm-10">
							<select id="facturacion-cobrar-pago-empleado" class="form-control input-lg">
							<option disabled selected value="">Seleccione un empleado</option>
							<?php if(count($empleados)):foreach($empleados as $empleado):if($empleado->consumo==false):?><option value="<?php echo $empleado->id_empleado;?>"><?php echo $empleado->nombre_empleado;?></option><?php endif;endforeach;endif;?>
							</select>
						</div>
					</div>
				</div>
				<!--Documento cliente-->
				<div class="row pad-top">
					<label class="col-sm-2 control-label" for="">Direccion</label>
					<div class="col-sm-10">
						<input type="text" id="facturacion-documento-direccion" class="form-control" placeholder="Direccion" value="<?php echo $direccion;?>">
					</div>
				</div>
				<div class="row pad-top">
					<label class="col-sm-2 control-label" for="">Docs</label>
					<div class="col-sm-4">
						<input type="text" id="facturacion-documento-nit" class="form-control" placeholder="NIT">
					</div>
					<div class="col-sm-3">
						<input type="text" id="facturacion-documento-dui" class="form-control" placeholder="DUI">
					</div>
					<div class="col-sm-3">
						<input type="text" id="facturacion-documento-nrc" class="form-control" placeholder="NRC">
					</div>
				</div>
				<!--Servicio-->
				<div class="row text-center mar-top">
					<h4>Para</h4>
				</div>
				<div id="facturacion-servicio-wrapper" class="row bord-btm pad-btm">
					<!--Comer aca-->
					<div class="col-sm-3">
						<button data-toggle="button" class="bord-weight facturacion-servicio-btn btn btn-block btn-lg btn-grey btn-active-info active" type="button" data-tipo="Para comer aca">Comer aca</button>
					</div>
					<!--Llevar-->
					<div class="col-sm-3">
						<button data-toggle="button" id="facturacion-servicio-llevar-btn" class="bord-weight facturacion-servicio-btn btn btn-block btn-lg btn-grey btn-active-info" type="button" data-tipo="Para llevar">Llevar</button>
					</div>
					<!--Comer aca-->
					<div class="col-sm-3">
						<button data-toggle="button" id="facturacion-servicio-domicilio-btn" class="bord-weight facturacion-servicio-btn btn btn-block btn-lg btn-grey btn-active-info" type="button" data-tipo="Domicilio">Domicilio</button>
					</div>
					<!--Llevar-->
					<div class="col-sm-3">
						<button data-toggle="button" class="bord-weight facturacion-servicio-btn btn btn-block btn-lg btn-grey btn-active-info" type="button" data-tipo="Domicilio a pie">Domicilio a pie</button>
					</div>
				</div>
				<!--Promotor-->
				<div class="row text-center mar-top">
					<h4>Promotor</h4>
				</div>
				<div id="facturacion-promotor-wrapper" class="row bord-btm pad-btm">
					<label class="col-sm-2 control-label">Nombre</label>
					<div class="col-sm-10">
						<select id="facturacion-cobrar-promotor" class="form-control input-lg">
							<option disabled selected value="">Seleccione un promotor (No obligatorio)</option>
							<option value="Jorge2130">Jorge Alberto Alvarado Molina (Jorge2130)</option>
							<option value="Karen2131">Karen Eunice Galan Segura (Karen2131)</option>
							<option value="Roberto2132">Francisco Roberto Chamagua Vasquez (Roberto2132)</option>
							<option value="Gaby2133">Gabriela Romano Paz (Gaby2133)</option>
							<option value="Memo2134">Guillermo Enrique Villalta Lopez (Memo2134)</option>
							<option value="Alex2135">Humberto Alexander Gomez Calderon (Alex2135)</option>
						</select>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row text-center mar-top">
		<button type="button" id="facturacion-cobrar-pago-cobrar-btn" class="btn btn-lg btn-success btn-labeled fa fa-save">Cobrar</button>
		<button type="button" id="facturacion-cobrar-pago-salir-btn" class="btn btn-lg btn-danger btn-labeled fa fa-window-close">Salir</button>
	</div>
</div>
<script>
	ChinaInTools.initializeKeyboard("<?php echo $winID;?>");
</script>