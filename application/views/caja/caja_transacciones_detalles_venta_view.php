<div class="row" id="<?php $windowid= date('YmdHis'); echo $windowid;?>">
	<div class="panel blank-panel">
		<div class="panel-body">
			<!--Informacion-->
			<div class="row">
				<!--Venta-->
				<div class="ibox">
					<div class="ibox-title">
						<h5>Informacion de la venta</h5>
					</div>
					<div style="height:80px;">
						<div class="row pad-top">
							<div class="col-sm-4">
								<span><strong>Documento:</strong> Ticket.</span>
							</div>
							<div class="col-sm-4">
								<span><strong>Numero:</strong> <?php echo  str_pad($info_venta->num_doc_venta, 6, "0", STR_PAD_LEFT);?>.</span>
							</div>
							<div class="col-sm-4">
								<span><strong>Fecha:</strong> <?php echo date("d-m-Y H:i:s",strtotime($info_venta->fecha_venta));?></span>
							</div>
						</div>
						<div class="row pad-top">
							<div class="col-sm-4">
								<span><strong>Forma de pago:</strong>
									<?php 
										$pago_array=unserialize($info_venta->forma_pago_venta);
										foreach($pago_array as $forma_pago=>$monto_pago){
											switch($forma_pago){
												case 0:echo "Efectivo ($".$monto_pago.") "; break;
												case 1:echo "POS  ($".$monto_pago.") "; break;
											}
										}
									?>
								</span>
							</div>
						</div>	
					</div>	
				</div>
			</div>
			<!--Encabezado de la tabla de productoa-->
			<div class="row">
			<table class="table mar-no">
				<thead>
					<tr>
						<th width="50%">Producto</th>
						<th width="15%">Cantidad</th>
						<th width="15%">Precio</th>
						<th width="20%">Total</th>
					</tr>
				</thead>
			</table>
			</div>
			<!--Tabla de productos-->
			<div class="row">
				<div id="nueva-venta-productos-wrapper">
					<table class="table table-hover table-striped">
						<tbody>
						<?php $total=0.00; if(count($productos)):foreach($productos as $producto):?>
							<tr data-id="<?php echo $producto->id;?>" data-nombre="<?php echo $producto->nombre;?>" data-cant="<?php echo number_format($producto->cant,0);?>" data-precio="<?php echo number_format($producto->precio,2);?>" data-total="<?php echo number_format(($producto->cant*$producto->precio),2);?>">
								<td><?php echo $producto->nombre;?></td>
								<td><?php echo number_format($producto->cant,0);?></td>
								<td><?php echo number_format($producto->precio,2);?></td>
								<td><?php echo number_format(($producto->cant*$producto->precio),2);?></td>
							</tr>
							<?php $total+=($producto->cant*$producto->precio); endforeach;endif;?>
						</tbody>
					</table>
				</div>
			</div>
			<!--Totales-->
			<div class="row">
				<div class="col-sm-8"></div>
				<div class="col-sm-4">
					<table class="table" id="nueva-venta-totales-wrapper">
						<tbody>
							<?php if(isset($venta->totales)):if(count($venta->totales)>0):foreach($venta->totales as $total):?>
							<tr class="<?php echo $total["className"];?>">
								<td><?php echo $total["title"];?></td>
								<td>$</td>
								<td class="totalval" data-value="<?php echo $total["value"];?>"><?php echo$total["value"];?></td>
							</tr>
							<?php endforeach;endif;endif;?>
						</tbody>
					</table>
				</div>
			</div>
			<!--Ocultos-->
			<div>
				<input type="hidden" id="venta-detalles-doc-code" value="<?php echo (isset($venta->doc_code)?$venta->doc_code:"1");?>">
				<input type="hidden" id="venta-detalles-doc-serie" value="<?php echo (isset($venta->serie_autorizada)?$venta->serie_autorizada:"");?>">
				<input type="hidden" id="venta-detalles-doc-serieid" value="<?php echo (isset($venta->id_resolucion)?$venta->id_resolucion:"");?>">
				<input type="hidden" id="venta-detalles-caja-id" value="<?php echo (isset($venta->id_caja)?$venta->id_caja:"");?>">
				<input type="hidden" id="venta-detalles-vendedor" value="<?php echo (isset($venta->id_vendedor)?$venta->id_vendedor:"");?>">
				<input type="hidden" id="venta-detalles-cajero" value="<?php echo (isset($venta->id_cajero)?$venta->id_cajero:"");?>">
			</div>
			<!--Botones-->
			<div class="row text-center">
				<button type="button" class="btn btn-danger btn-rounded" onclick="Custombox.close();">Salir</button>
				<button type="button" id="venta-detalles-reimprimir-btn" class="btn btn-primary btn-rounded">Reimprimir documento</button>
			</div>
			<!--Modales-->
			<div>
				<!--Refacturacion-->
				<div class="modal inmodal fade" id="venta-detalles-reimpresion" tabindex="-1" role="dialog"  aria-hidden="true">
					<div class="modal-dialog modal-md">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
								<h4 class="">Reimprimir venta</h4>
							</div>
							<div class="modal-body">
								<!--Alerta-->
								<div class="alert alert-warning alert-dismissable">
									Esta acción solo volverá a imprimir el contenido de la venta seleccionada en el documento correspondiente, pero no alterará la información guardada en la base de datos. <br>
									Asegurese que se respeten los correlativos y que la cinta de auditoria mantendrá su orden.
								</div>
								<!--opciones-->
								<div class="form-group">
									<div id="venta-detalles-reimpresion-copias-wrapper">
										<label>Seleccione una opci&oacute;n de impresi&oacute;n</label>
										<select class="form-control" id="venta-detalles-reimpresion-copias">
											<option value="0" selected>Imprimir ticket de cliente y cinta de auditoria</option>
											<option value="1">Imprimir solo ticket de cliente </option>
											<option value="2">Imprimir solo cinta de auditoria</option>
										</select>
									</div>
								</div>
							</div>
							<div class="modal-footer">
								<button type="button" id="venta-detalles-reimpresion-cancel-btn" class="btn btn-white" data-dismiss="modal">Cancelar</button>
								<button type="button" id="venta-detalles-reimpresion-guardar-btn" class="btn btn-primary">Imprimir</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	var productos_salidas_detalles_venta=new Productos_salidas_detalles_venta();
	productos_salidas_detalles_venta.initializeEnviroment("<?php echo base_url();?>","<?php echo $windowid;?>");
</script>