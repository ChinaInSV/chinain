<div class="row" id="<?php $winid=date('YmdHis'); echo $winid;?>">
	<div class="panel">
		<!--Panel body-->
		<div class="panel-body">
			<div class="col-md-8 bord-rgt text-center">
				<div class="col-md-1"></div><div class="col-md-4">
					<button type="button" class="btn btn-block btn-success btn-labeled fa fa-plus">Registrar Ingreso</button>	
				</div><div class="col-md-1"></div>
				<div class="col-md-1"></div><div class="col-md-4">
					<button type="button" class="btn btn-block btn-danger btn-labeled fa fa-minus">Registrar Egreso</button>	
				</div><div class="col-md-1"></div>
			</div>
			<div class="col-md-4">
				<div class="col-md-2"></div><div class="col-md-8">
					<button type="button" class="btn btn-block btn-warning btn-labeled fa fa-close">Cerrar Caja</button>	
				</div><div class="col-md-2"></div>
			</div>
			<div class="col-md-12 mar-top">
				<table id="cajachica-table" class="table table-striped table-bordered text-uppercase" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th class="text-center">Fecha</th>
							<th class="text-center">Usuario</th>
							<th class="text-center">Detalle</th>
							<th class="text-center">Documento</th>
							<th class="text-center">Ingresos</th>
							<th class="text-center">Egresos</th>
							<th class="text-center">Saldo</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<th>2017-09-02 14:00:00</th>
							<th>Root</th>
							<th>Detalle</th>
							<th>Documento</th>
							<th>100</th>
							<th></th>
							<th>100</th>
						</tr>
						<tr>
							<th>2017-09-02 14:00:00</th>
							<th>Root</th>
							<th>Detalle</th>
							<th>Documento</th>
							<th></th>
							<th>50</th>
							<th>50</th>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<div class="row text-center">
	<button type="button" id="" onclick="Custombox.close();" class="btn btn-lg btn-danger btn-labeled fa fa-window-close">Salir</button>
</div>
<script>
	$(document).ready(function () {
		var caja_caja_chica=new Caja_caja_chica();
		caja_caja_chica.initializeEnviroment("<?php echo base_url();?>","<?php echo $winid;?>");
    });
</script>