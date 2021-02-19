<div class="row" id="<?php $winid=date('YmdHis'); echo $winid;?>">
	<div class="panel">
		<div class="panel-body">
			<div class="col-sm-12 col-xs-12 col-md-12">
				<div class="tab-base">					
					<!--Nav Tabs-->
					<ul class="nav nav-tabs">
						<li class="active">
							<a data-toggle="tab" href="#demo-lft-tab-1" aria-expanded="true">Ventas</a>
						</li>
						<li class="">
							<a data-toggle="tab" href="#demo-lft-tab-2">Devoluciones</a>
						</li>
						<li>
							<a data-toggle="tab" href="#demo-lft-tab-3">Cortes</a>
						</li>
						<li>
							<a data-toggle="tab" href="#demo-lft-tab-4">Cintas</a>
						</li>
					</ul>
		
					<!--Tabs Content-->
					<div class="tab-content" style="height:565px;">
						<div id="demo-lft-tab-1" class="tab-pane fade active in">
							<table id="salidas-ventas-tabla" class="table table-striped">
								<thead>
									<tr>
										<th>Referencia</th>
										<th>Fecha</th>
										<th>Cajero</th>
										<th>Cliente</th>
										<th>Documento</th>
										<th>Numero</th>
										<th>Total</th>
										<th>Estado</th>
										<th>Acciones</th>
									</tr>
								</thead>
								<tbody></tbody>
							</table>
						</div>
						<div id="demo-lft-tab-2" class="tab-pane fade">
							<table id="salidas-devoluciones-tabla" class="table">
								<thead>
									<tr>
										<th>Referencia</th>
										<th>Fecha</th>
										<th>Cajero</th>
										<th>Cliente</th>
										<th>Documento</th>
										<th>Numero</th>
										<th>Total</th>
										<th>Estado</th>
										<th>Acciones</th>
									</tr>
								</thead>
								<tbody>
									
								</tbody>
							</table>
						</div>
						<div id="demo-lft-tab-3" class="tab-pane fade">
							<table id="salidas-cortes-tabla" class="table">
								<thead>
									<tr>
										<th>ID</th>
										<th>Fecha</th>
										<th>Cajero</th>
										<th>Tipo</th>
										<th>Acciones</th>
									</tr>
								</thead>
								<tbody>
									
								</tbody>
							</table>
						</div>
						<div id="demo-lft-tab-4" class="tab-pane fade">
							<table id="salidas-cintas-tabla" class="table">
								<thead>
									<tr>
										<th>ID</th>
										<th>Fecha</th>
										<th>Acciones</th>
									</tr>
								</thead>
								<tbody>
									
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function () {
		var userString = "<?php if(isset($vendedores)):foreach($vendedores as $vendedor):?><option value='<?php echo $vendedor->id_usuario;?>'><?php echo $vendedor->nombre_usuario;?></option><?php endforeach;endif;?>";
		var caja_transacciones=new Caja_transacciones();
		caja_transacciones.initializeEnviroment("<?php echo base_url();?>","<?php echo $winid;?>",userString);
    });
</script>