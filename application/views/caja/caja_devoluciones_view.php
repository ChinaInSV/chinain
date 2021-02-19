<div class="row" id="<?php $winid=date('YmdHis'); echo $winid;?>">
	<div class="panel">
		<!--Panel body-->
		<div class="panel-body">
			<div class="row">
				<div class="col-sm-10 bord-rgt">
					<div class="row">
						<div class="col-sm-4">
							<label>Producto</label>
							<select class="form-control">
								<option>S&aacute;ndwich de pollo</option>
								<option>S&aacute;ndwich de queso y jamón</option>
							</select>
						</div>
						<div class="col-sm-2">
							<label>Cantidad</label>
							<input type="number" class="form-control" value="1">
						</div>
						<div class="col-sm-2">
							<label>Precio</label>
							<input type="number" class="form-control" value="2.50">
						</div>
						<div class="col-sm-2">
							<label>Total</label>
							<input type="text" class="form-control" value="2.50" readonly>
						</div>
						<div class="col-sm-2">
							<button class="btn btn-info" style="margin-top:24px;">Agregar</button>
						</div>
					</div>
				</div>
				<div class="col-sm-2 text-center">
					<div class="input-group">
						<input type="text" class="form-control">
						<span class="input-group-btn">
							<button class="btn btn-success" id="facturacion-buscar-orden-btn"><i class="fa fa-search"></i></button>
						</span>
					</div>
					<button class="btn btn-info" style="margin:5px;">Cargar orden</button>
				</div>
			</div>
			<div class="row">
				<table class="table table-hover table-vcenter bg-gray" style="margin-bottom:0px;">
					<thead>
						<tr>
							<th width="50%" style="text-align:center;">Producto</th>
							<th width="12%" style="text-align:center;">Cantidad</th>
							<th width="12%" style="text-align:center;">Precio</th>
							<th width="16%" style="text-align:center;">Total</th>
							<th width="10%" style="text-align:center;"></th>
						</tr>
					</thead>
				</table>
				<div style="overflow-y:scroll;height:200px;">
					<table class="table table-hover table-vcenter table-striped">
						<tbody>
							<tr>
								<td>Alitas de pollo a la gordo bleu</td>
								<td>5.00</td>
								<td>5.00</td>
								<td>25.00</td>
								<td><button class="btn btn-icon btn-danger btn-xs btn-round"><i class="fa fa-times"></i></button></td>
							</tr>
							<tr>
								<td>Alitas de pollo a la gordo bleu</td>
								<td>5.00</td>
								<td>5.00</td>
								<td>25.00</td>
								<td><button class="btn btn-icon btn-danger btn-xs btn-round"><i class="fa fa-times"></i></button></td>
							</tr>
							<tr>
								<td>Alitas de pollo a la gordo bleu</td>
								<td>5.00</td>
								<td>5.00</td>
								<td>25.00</td>
								<td><button class="btn btn-icon btn-danger btn-xs btn-round"><i class="fa fa-times"></i></button></td>
							</tr>
							<tr>
								<td>Alitas de pollo a la gordo bleu</td>
								<td>5.00</td>
								<td>5.00</td>
								<td>25.00</td>
								<td><button class="btn btn-icon btn-danger btn-xs btn-round"><i class="fa fa-times"></i></button></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="col-md-7 mar-top">
			</div>
			<div class="col-md-5 mar-top">
				<h4 class="text-normal col-xs-4 mar-no" style="line-height:20px;">Sumas</h4>
				<h4 class="text-normal col-xs-1 mar-no" style="line-height:20px;">$</h4>
				<h4 class="text-normal text-right col-xs-6 mar-no" style="line-height:20px;">9999.99</h4>
				<h4 class="text-normal col-xs-4 mar-no" style="line-height:20px;">Propina</h4>
				<h4 class="text-normal col-xs-1 mar-no" style="line-height:20px;">$</h4>
				<h4 class="text-normal text-right col-xs-6 mar-no" style="line-height:20px;">9999.99</h4>
				<h4 class="text-normal col-xs-4 mar-no" style="line-height:20px;">Descuento</h4>
				<h4 class="text-normal col-xs-1 mar-no" style="line-height:20px;">$</h4>
				<h4 class="text-normal text-right col-xs-6 mar-no" style="line-height:20px;">9999.99</h4>
				<h4 class="text-bold col-xs-4 mar-no" style="line-height:20px;">Total</h4>
				<h4 class="text-bold col-xs-1 mar-no" style="line-height:20px;">$</h4>
				<h4 class="text-bold text-right col-xs-6 mar-no" style="line-height:20px;">9999.99</h4>
			</div>
		</div>
	</div>
</div>
<div class="row text-center">
	<button type="button" id="" onclick="" class="btn btn-lg btn-success btn-labeled fa fa-save">Guardar</button>
	<button type="button" id="" onclick="Custombox.close();" class="btn btn-lg btn-danger btn-labeled fa fa-window-close">Salir</button>
</div>
<script>
	$(document).ready(function () {
		var caja_devoluciones=new Caja_devoluciones();
		caja_devoluciones.initializeEnviroment("<?php echo base_url();?>","<?php echo $winid;?>");
    });
</script>