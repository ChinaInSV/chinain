<div class="row" id="<?php $winid=date('YmdHis'); echo $winid;?>">
	<div class="panel">
		<div class="panel-body">
			<div class="row" id="reportes-wrapper" style="overflow:hidden;">
				<div class="col-lg-6 col-sm-6 col-xs-12">
					<!--Grafico de Pagos-->
					<div class="panel">
						<div class="panel-heading">
							<h3 class="panel-title" style="font-size:19px;">Grafico General de Pagos</h3>
						</div>
						<div class="panel-body">
							<div class="row">
								<div class="col-sm-3">
									<div class="form-group" style="margin-bottom:5px;">
										<label class="mar-btm control-label text-lg">Forma:</label>
										<select class="input-lg form-control" id="grafico-pagos-forma">
											<option value="0">Diario</option>
											<option value="1">Mensual</option>
										</select>
									</div>
								</div>
								<!--Fechas-->
								<div class="col-lg-6 col-sm-6 col-xs-6">
									<label class="mar-btm control-label text-lg">Fechas:</label>
									<div class="input-group date">
										<span class="input-group-addon">
											<i class="fa fa-calendar"></i>
										</span>
										<div>
											<div class="input-daterange input-daterange-days input-group" id="grafico-pagos-fechas-days">
												<input type="text" class="form-control input-lg" id="grafico-pagos-fechadesde-day" />
												<span class="input-group-addon text-lg">al</span>
												<input type="text" class="form-control input-lg" id="grafico-pagos-fechahasta-day" />
											</div>
											<div class="input-daterange input-daterange-months input-group" id="grafico-pagos-fechas-months" style="display:none;">
												<input type="text" class="form-control input-lg" id="grafico-pagos-fechadesde-month" />
												<span class="input-group-addon text-lg">al</span>
												<input type="text" class="form-control input-lg" id="grafico-pagos-fechahasta-month" />
											</div>
										</div>
									</div>
								</div>
								<div class="col-lg-3 col-sm-3 col-xs-3">
									<button class="btn btn-block btn-lg btn-primary btn-labeled fa fa-line-chart text-center" id="grafico-pagos-btn" style="margin-top:34px;">Generar</button>
								</div>
								<div class="col-lg-12 col-sm-12 col-xs-12">
									<div class="form-group">
										<input id="grafico-pagos-valores" class="magic-checkbox" type="checkbox">
										<label for="grafico-pagos-valores" class="control-label text-semibold">Mostrar valores en Grafico</label>
									</div>
								</div>
								<div class="col-lg-12 col-sm-12 col-xs-12">
									<div class="bord-all" style="height:450px;" id="grafico-pagos-div">
										
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-6 col-sm-6 col-xs-12">
					<!--Grafico de Pagos-->
					<div class="panel">
						<div class="panel-heading">
							<h3 class="panel-title" style="font-size:19px;">Grafico de Grupos de Servicios</h3>
						</div>
						<div class="panel-body">
							<div class="row">
								<div class="col-sm-3">
									<div class="form-group" style="margin-bottom:5px;">
										<label class="mar-btm control-label text-lg">Tipo:</label>
										<select class="input-lg form-control" id="grafico-grupos-tipo">
											<option value="0">Barras</option>
											<option value="1">Pastel</option>
										</select>
									</div>
								</div>
								<!--Fechas-->
								<div class="col-lg-6 col-sm-6 col-xs-6">
									<label class="mar-btm control-label text-lg">Fechas:</label>
									<div class="input-group date">
										<span class="input-group-addon">
											<i class="fa fa-calendar"></i>
										</span>
										<div>
											<div class="input-daterange input-daterange-days input-group" id="grafico-grupos-fechas-days">
												<input type="text" class="form-control input-lg" id="grafico-grupos-fechadesde-day" />
												<span class="input-group-addon text-lg">al</span>
												<input type="text" class="form-control input-lg" id="grafico-grupos-fechahasta-day" />
											</div>
										</div>
									</div>
								</div>
								<div class="col-lg-3 col-sm-3 col-xs-3">
									<button class="btn btn-lg btn-block btn-primary btn-labeled fa fa-line-chart" id="grafico-grupos-btn" style="margin-top:34px;">Generar</button>
								</div>
								<div class="col-lg-12 col-sm-12 col-xs-12">
									<div class="form-group">
										<input id="grafico-grupos-valores" class="magic-checkbox" type="checkbox">
										<label for="grafico-grupos-valores" class="control-label text-semibold">Mostrar valores en Grafico</label>
									</div>
								</div>
								<div class="col-lg-12 col-sm-12 col-xs-12">
									<div class="bord-all" style="height:450px;" id="grafico-grupos-div">
										
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