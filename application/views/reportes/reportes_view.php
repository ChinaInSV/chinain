<div class="row" id="<?php $winid=date('YmdHis'); echo $winid;?>">
	<div class="panel">
		<div class="panel-body">
			<div id="reportes-wrapper" style="overflow:hidden;">
				<div class="row">
					<div class="col-lg-12 col-sm-12 col-xs-12">
						<!--Reporte de Pagos-->
						<div class="panel">
							<div class="panel-heading">
								<h3 class="panel-title" style="font-size:19px;">Reporte General de Pagos</h3>
							</div>
							<div class="panel-body">
								<div class="row">
									<div class="col-sm-1">
										<div class="form-group" style="margin-bottom:5px;">
											<label class="mar-btm control-label text-lg">Forma:</label>
											<select class="input-lg form-control" id="reporte-pagos-forma">
												<option value="0">Diario</option>
												<option value="1">Mensual</option>
											</select>
										</div>
									</div>
									<!--Fechas-->
									<div class="col-lg-3 col-sm-3 col-xs-3">
										<label class="mar-btm control-label text-lg">Fechas:</label>
										<div class="input-group date">
											<span class="input-group-addon">
												<i class="fa fa-calendar"></i>
											</span>
											<div>
												<div class="input-daterange input-daterange-days input-group" id="reporte-pagos-fechas-days">
													<input type="text" class="form-control input-lg" id="reporte-pagos-fechadesde-day" />
													<span class="input-group-addon text-lg">al</span>
													<input type="text" class="form-control input-lg" id="reporte-pagos-fechahasta-day" />
												</div>
												<div class="input-daterange input-daterange-months input-group" id="reporte-pagos-fechas-months" style="display:none;">
													<input type="text" class="form-control input-lg" id="reporte-pagos-fechadesde-month" />
													<span class="input-group-addon text-lg">al</span>
													<input type="text" class="form-control input-lg" id="reporte-pagos-fechahasta-month" />
												</div>
											</div>
										</div>
									</div>
									<div class="col-sm-2">
										<div class="form-group">
											<label class="mar-btm control-label text-lg">Cliente</label>
											<div class="padilla-custom-chosen-lg">
												<select class="form-control input-lg" id="reporte-pagos-clientes" name="">
													<option selected value="-">Todos los Clientes</option>
													<?php if(count($clientes)):foreach($clientes as $cliente):?>
													<option value="<?php echo $cliente->id;?>"><?php echo $cliente->nombre;?></option>
													<?php endforeach;endif;?>
												</select>
											</div>
										</div>
									</div>
									<div class="col-sm-2">
										<div class="form-group">
											<label class="mar-btm control-label text-lg">Usuario</label>
											<div class="padilla-custom-chosen-lg">
												<select class="form-control input-lg" id="reporte-pagos-usuarios" name="">
													<option selected value="-">Todos los Usuarios</option>
													<?php if(count($usuarios)):foreach($usuarios as $usuario):?>
													<option value="<?php echo $usuario->id;?>"><?php echo $usuario->nombre;?></option>
													<?php endforeach;endif;?>
												</select>
											</div>
										</div>
									</div>
									<div class="col-sm-2">
										<div class="form-group" style="margin-bottom:5px;">
											<label class="mar-btm control-label text-lg">Metodo de Pago:</label>
											<select class="input-lg form-control" id="reporte-pagos-metodo">
												<option value="-">Consolidado</option>
												<option value="0">Efectivo</option>
											</select>
										</div>
									</div>
									<div class="col-lg-2 col-sm-2 col-xs-2">
										<button class="btn btn-lg btn-block btn-danger btn-labeled fa fa-file-pdf-o" id="reporte-pagos-btn" style="margin-top:34px;">Generar</button>
									</div>
									<div class="col-lg-12 col-sm-12 col-xs-12">
										<div class="form-group" style="margin-bottom:5px;">
											<input id="reporte-pagos-valores" class="magic-checkbox" type="checkbox">
											<label for="reporte-pagos-valores" class="control-label text-semibold">Incluir Platos por Transaccion</label>
										</div>
									</div>
									<div class="col-lg-12 col-sm-12 col-xs-12">
										<div class="form-group" style="margin-bottom:5px;">
											<input id="reporte-pagos-devoluciones" class="magic-checkbox" type="checkbox">
											<label for="reporte-pagos-devoluciones" class="control-label text-semibold">Incluir Devoluciones</label>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-6 col-sm-6 col-xs-12">
						<!--Reporte de Pagos-->
						<div class="panel">
							<div class="panel-heading">
								<h3 class="panel-title" style="font-size:19px;">Reporte de Platos</h3>
							</div>
							<div class="panel-body">
								<div class="row">
									<!--Fechas-->
									<div class="col-lg-9 col-sm-9 col-xs-9">
										<label class="mar-btm control-label text-lg">Fechas:</label>
										<div class="input-group date">
											<span class="input-group-addon">
												<i class="fa fa-calendar"></i>
											</span>
											<div>
												<div class="input-daterange input-daterange-days input-group" id="reporte-platos-fechas-days">
													<input type="text" class="form-control input-lg" id="reporte-platos-fechadesde-day" />
													<span class="input-group-addon text-lg">al</span>
													<input type="text" class="form-control input-lg" id="reporte-platos-fechahasta-day" />
												</div>
											</div>
										</div>
									</div>
									<div class="col-lg-3 col-sm-3 col-xs-3">
										<button class="btn btn-lg btn-block btn-danger btn-labeled fa fa-file-pdf-o" id="reporte-platos-btn" style="margin-top:34px;">Generar</button>
									</div>
									<div class="col-lg-12 col-sm-12 col-xs-12">
										<div class="form-group" style="margin-bottom:5px;">
											<input id="reporte-platos-grupos" class="magic-checkbox" type="checkbox">
											<label for="reporte-platos-grupos" class="control-label text-semibold">Incluir Categoria de Platos</label>
										</div>
									</div>
									<div class="col-lg-12 col-sm-12 col-xs-12">
										<div class="form-group" style="margin-bottom:5px;">
											<input id="reporte-platos-cero" class="magic-checkbox" type="checkbox">
											<label for="reporte-platos-cero" class="control-label text-semibold">Incluir Platos sin Transacciones</label>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-6 col-sm-6 col-xs-12">
						<!--Reporte de Consumos-->
						<div class="panel">
							<div class="panel-heading">
								<h3 class="panel-title" style="font-size:19px;">Reporte de Consumos</h3>
							</div>
							<div class="panel-body">
								<div class="row">
									<!--Fechas-->
									<div class="col-lg-8 col-sm-8 col-xs-8">
										<label class="mar-btm control-label text-lg">Fechas:</label>
										<div class="input-group date">
											<span class="input-group-addon">
												<i class="fa fa-calendar"></i>
											</span>
											<div>
												<div class="input-daterange input-daterange-days input-group" id="reporte-consumos-fechas-days">
													<input type="text" class="form-control input-lg" id="reporte-consumos-fechadesde-day" />
													<span class="input-group-addon text-lg">al</span>
													<input type="text" class="form-control input-lg" id="reporte-consumos-fechahasta-day" />
												</div>
											</div>
										</div>
									</div>
									<div class="col-lg-2 col-sm-2 col-xs-2">
										<button class="btn btn-lg btn-block btn-dark btn-labeled fa fa-file-text-o" id="reporte-consumos-btn" data-mode="text" style="margin-top:34px;">Generar</button>
									</div>
									<div class="col-lg-2 col-sm-2 col-xs-2">
										<button class="btn btn-lg btn-block btn-success btn-labeled fa fa-file-excel-o" id="reporte-consumos-excel-btn" data-mode="excel" style="margin-top:34px;">Generar</button>
									</div>
									<div class="col-lg-12 col-sm-12 col-xs-12">
										<div class="form-group" style="margin-bottom:5px;">
											<input id="reporte-consumos-empleados" class="magic-checkbox" type="checkbox" checked>
											<label for="reporte-consumos-empleados" class="control-label text-semibold">Incluir Empleados en Consumos</label>
										</div>
									</div>
									<div class="col-lg-12 col-sm-12 col-xs-12">
										<div class="form-group" style="margin-bottom:5px;">
											<input id="reporte-consumos-cero" class="magic-checkbox" type="checkbox">
											<label for="reporte-consumos-cero" class="control-label text-semibold">Incluir Dias sin Consumos</label>
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
		var reportes=new Reportes();
		reportes.initializeEnviroment("<?php echo base_url();?>","<?php echo $winid;?>");
    });
</script>