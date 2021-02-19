<div class="row" id="<?php echo $winID;?>">
	<!--Hiddens-->
	<input type="hidden" id="facturacion-cobrar-pago-total" value="<?php echo $total;?>">
	<div class="panel">
		<!--Panel body-->
		<div class="panel-body">
			<div class="col-sm-6 bord-rgt">
				<div class="row mar-btm">
					<div class="col-sm-3">
						<p class="text-2x mar-top">Total:</p>
					</div>
					<div class="col-sm-9 bord-all bg-gray-light ">
						<p class="text-4x mar-no text-center text-info">$ <?php echo $total;?></p>
					</div>
				</div>
				<!--Forma de pago-->
				<div class="row text-center">
					<label class="control-label">Forma de pago</label>
				</div>
				<div class="row">
					<!--Efectivo-->
					<div class="col-sm-4">
						<button data-toggle="button" class="btn btn-block btn-lg btn-grey btn-active-info active" type="button">Efectivo</button>		
					</div>
					<!--POS
					<div class="col-sm-4">
						<button data-toggle="button" class="btn btn-block btn-lg btn-grey btn-active-info" type="button">POS</button>		
					</div-->
					<!--Mixto
					<div class="col-sm-4">
						<button data-toggle="button" class="btn btn-block btn-lg btn-grey btn-active-info" type="button">Mixto</button>		
					</div>-->
				</div>
				<div class="mar-all" id="facturacion-cobrar-pago-datos-wrapper">
					<!--Efectivo-->
					<div class="row mar-btm">
						<label class="control-label col-sm-3 text-right">Efectivo:</label>
						<div class="col-sm-9">
							<input type="text" id="facturacion-cobrar-pago-efectivo" class="form-control text-3x" style="height:48px;"data-required="required">
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
			</div>
			<div class="col-sm-6">
				<div class="row text-center">
					<label class="control-label">Documento de facturaci&oacute;n</label>
				</div>
				<!--Documento-->
				<div class="row pad-lft pad-rgt">
					<button data-toggle="button" class="pad-all mar-btm btn btn-block btn-lg btn-grey btn-active-info active" type="button">Ticket</button>	
				</div>
				<div class="row">
					<label class="col-sm-3 control-label" for="demo-hor-inputemail">Numero de Comprobante</label>
					<div class="col-sm-9">
						<input type="text" placeholder="Automatico" id="demo-hor-inputemail" class="form-control">
					</div>
				</div>
				<!--Cliente-->
				<div class="row bord-top pad-top">
					<label class="col-sm-3 control-label">Cliente</label>
					<div class="col-sm-9">
						<div class="input-group">
							<input type="text" id="facturacion-cobrar-pago-cliente" class="form-control" value="<?php echo $cliente;?>">
							<!--<span class="input-group-btn">
								<button class="btn btn-success" id="facturacion-buscar-orden-btn"><i class="fa fa-search"></i></button>
							</span>-->
						</div>
					</div>
				</div>
				<!--Documento cliente-->
				<div class="row pad-top">
					<label class="col-sm-3 control-label" for="demo-hor-inputemail">Documento</label>
					<div class="col-sm-3">
						<select id="" class="form-control">
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
			</div>
			</div>
	</div>
	<div class="row text-center">
		<button type="button" id="facturacion-cobrar-pago-cobrar-btn" class="btn btn-lg btn-success btn-labeled fa fa-save">Cobrar</button>
		<button type="button" id="" onclick="Custombox.close();" class="btn btn-lg btn-danger btn-labeled fa fa-window-close">Salir</button>
	</div>
</div>