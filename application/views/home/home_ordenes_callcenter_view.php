<div class="row" id="<?php $winid=date('YmdHis'); echo $winid;?>" style="background:#E9EAEE">
	<div class="pad-all">
		<div id="ordenes-callcenter-contenido-wrapper" style="">
			<div class="row">
				<div class="col-md-8">
					<div class="panel">
						<div class="panel-heading">
							<h3 class="panel-title">Ordenes Call Center</h3>
						</div>
						<div class="panel-body">
							<div id="ordenes-table-wrapper">
								<div class="row">
									<div class="col-sm-12 col-lg-12 col-xs-12">
										<label class="text-lg">Busqueda:</label> <span class="required-mark">*</span>
									</div>
									<div class="col-sm-6 col-lg-6 col-xs-12 mar-top">
										<input type="text" placeholder="Escriba el nombre del Cliente" class="form-control input-lg text-lg" id="ordenes-buscar-text">
									</div>
								</div>
								<table id="table-ordenes" class="table table-hover table-vcenter table-bordered mar-top" data-show-toggle="false" data-filtering="false" data-sorting="true" data-empty="No hay Ordenes registradas" data-filter-delay="-1" data-filter-dropdown-title="Buscar ordenes segun:" data-filter-focus="true" data-filter-placeholder="Buscar">
									<thead>
										<tr>
											<th class="text-center" data-visible="false" data-filterable="false">ID</th>
											<th class="text-center">Usuario</th>
											<th class="text-center">Cliente</th>
											<th class="text-center" data-filterable="false">Total</th>
											<th class="text-center" data-filterable="false">Acciones</th>
										</tr>
									</thead>
									<tbody>
										<?php if(count($ordenes)):foreach($ordenes as $orden):?>
											<tr>
												<td><?php echo $orden->id_orden;?></td>
												<td><?php echo $orden->usuario_callcenter_orden;?></td>
												<td><?php echo $orden->cliente_orden;?></td>
												<td>$<?php echo number_format($orden->sub_total_orden,2);?></td>
												<td class="text-center">
													<button class="btn btn-success ordenes-table-detalles-btn" data-id="<?php echo $orden->id_orden;?>">Detalle</button>
												</td>
											</tr>
										<?php endforeach;endif;?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="panel">
						<div class="panel-heading">
							<h3 class="panel-title">Detalles Orden</h3>
						</div>
						<div class="panel-body">
							<div id="ordenes-callcenter-detalles-wrapper" style="height:696px;overflow-y:auto;">
								<div class="well well-sm mar-all bg-gray-light">
									<div class="row">
										<div class="col-xs-3 text-right">
											<i class="fa fa-arrow-left fa-5x"></i>
										</div>
										<div class="col-xs-9">
											<h5>Seleccione una orden</h5>
											<small>Haga clic sobre el boton detalles de la orden para ver su contenido</small>
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
		var home_ordenes_callcenter=new Home_ordenes_callcenter();
		home_ordenes_callcenter.initializeEnviroment("<?php echo base_url();?>","<?php echo $winid;?>");
    });
</script>