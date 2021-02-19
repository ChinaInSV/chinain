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
					<div class="ibox-content" >
						<div id="venta-detalles-wrapper" style="height:80px;overflow:hidden;">
							<div class="col-sm-4">
								<!--Fecha-->
								<p style="margin:0px;">
									<label class="control-label">Fecha:</label> <span class="info-venta-item" id="detalles-venta-fecha" data-value="<?php echo (isset($venta->fecha_venta)?date("d-m-Y H:i:s",strtotime($venta->fecha_venta)):"-");?>"> <?php echo (isset($venta->fecha_venta)?date("d-m-Y H:i:s",strtotime($venta->fecha_venta)):"-");?></span>
								</p>
								<!--Documento-->
								<p style="margin:0px;">
									<label class="control-label">Documento:</label> <span class="info-venta-item" id="detalles-venta-info-doc"> <?php echo (isset($venta->documento_venta)?$venta->documento_venta:"-");?></span>
								</p>
								<!--Serie y numero-->
								<p style="margin:0px;">
									<label class="control-label">N&uacute;mero:</label> <span class="info-venta-item" id="detalles-venta-info-numdoc" data-value="<?php echo (isset($venta->num_documento_venta)?$venta->num_documento_venta:"-");?>"> <?php echo (isset($venta->serie_autorizada)?$venta->serie_autorizada." ":"- "); echo (isset($venta->num_documento_venta)?$venta->num_documento_venta:"-");?></i></span>
								</p>
								<!--Referencia-->
								<p style="margin:0px;">
									<label class="control-label">ID Transacci&oacute;n:</label> <span class="info-venta-item" id="detalles-venta-info-id" data-value="<?php echo (isset($venta->id_venta)?"V-".$venta->id_venta:"-");?>"> <?php echo (isset($venta->id_venta)?"V-".$venta->id_venta:"-");?></span>
								</p>
								<!--Estado-->
								<p style="margin:0px;">
									<label class="control-label">Estado:</label> <span class="info-venta-item" id="detalles-venta-info-estado"> <?php echo (isset($venta->estado_venta)?$venta->estado_venta:"-");?></span>
								</p>
								<!--Facturacion-->
								<p style="margin:0px;">
									<label class="control-label">Estado Facturaci&oacute;n:</label> <span class="info-venta-item" id="detalles-venta-info-tipo">  <?php echo (isset($venta->tipo_venta)?$venta->tipo_venta:"-");?></span>
								</p>
								<!--Origen-->
								<p style="margin:0px;">
									<label class="control-label">Origen trans.:</label> <span class="info-venta-item" id="detalles-venta-info-origen"> <?php echo (isset($venta->origen_venta)?$venta->origen_venta:"-");?></span>
								</p>
							</div>
							
							<div class="col-sm-4">
								<!--Caja-->
								<p style="margin:0px;">
									<label class="control-label">Caja:</label> <span class="info-venta-item" id="detalles-venta-info-caja" data-value="<?php echo (isset($venta->nombre_caja)?$venta->nombre_caja:"-");?>"> <?php echo (isset($venta->nombre_caja)?$venta->nombre_caja:"-");?></span>
								</p>
								<!--Cajero-->
								<p style="margin:0px;">
									<label class="control-label">Cajero:</label> <span class="info-venta-item" id="detalles-venta-info-cajero" data-value="<?php echo (isset($venta->cajero)?$venta->cajero:"-");?>"> <?php echo (isset($venta->cajero)?$venta->cajero:"-");?></span>
								</p>
								<!--Vendedor-->
								<p style="margin:0px;">
									<label class="control-label">Vendedor:</label> <span class="info-venta-item" id="detalles-venta-info-vendedor" data-value="<?php echo (isset($venta->vendedor)?$venta->vendedor:"-");?>"> <?php echo (isset($venta->vendedor)?$venta->vendedor:"-");?></span>
								</p>
								<!--Condicion-->
								<p style="margin:0px;">
									<label class="control-label">Condici&oacute;n:</label> <span class="info-venta-item" id="detalles-venta-info-cobro"  data-value="<?php echo (isset($venta->cobro_venta)?$venta->cobro_venta:"-");?>">  <?php echo (isset($venta->cobro_venta)?$venta->cobro_venta:"-");?></span>
								</p>
								<!--Condicion-->
								<p style="margin:0px;">
									<label class="control-label">Forma de pago:</label> <span class="info-venta-item" id="detalles-venta-info-forma"> <?php echo (isset($venta->forma_pago_venta)?$venta->forma_pago_venta:"-");?></span>
								</p>
								<!--Estado del pago-->
								<p style="margin:0px;">
									<label class="control-label">Estado del pago:</label> <span class="info-venta-item" id="detalles-venta-info-estadocobro"> <?php echo (isset($venta->estado_cobro)?$venta->estado_cobro:"-");?></span>
								</p>
								<!--Credito-->
								<p style="margin:0px;">
									<label class="control-label">ID cr&eacute;dito:</label> <span class="info-venta-item" id="detalles-venta-info-fecha"> <?php echo (isset($venta->id_credito)?$venta->id_credito:"-");?></span>
								</p>
							</div>
	
							<div class="col-sm-4">
								<!--Descargo-->
								<p style="margin:0px;">
									<label class="control-label">Descargo de inventario:</label> <span class="info-venta-venta" id="detalles-venta-info-descargo"> <?php echo (isset($venta->descargo_venta)?$venta->descargo_venta:"-");?></span>
								</p>
								<!--Nombre-->
								<p style="margin:0px;">
									<label class="control-label">Cliente:</label> <span class="info-venta-venta" id="detalles-venta-info-cliente" data-value="<?php echo (isset($venta->nombre_cliente)?$venta->nombre_cliente:"-");?>"> <?php echo (isset($venta->nombre_cliente)?$venta->nombre_cliente:"-");?></span>
								</p>
								<!--ID cliente-->
								<p style="margin:0px;">
									<label class="control-label">ID Cliente:</label> <span class="info-venta-venta" id="detalles-venta-info-idcliente" data-value="<?php echo (isset($venta->id_cliente)?$venta->id_cliente:"");?>"> <?php echo (isset($venta->id_cliente)?$venta->id_cliente:"-");?></span>
								</p>
								<!--DUI-->
								<p style="margin:0px;">
									<label class="control-label">DUI:</label> <span class="info-venta-venta" id="detalles-venta-info-dui" data-value="<?php echo (isset($venta->dui_cliente)?$venta->dui_cliente:"-");?>"> <?php echo (isset($venta->dui_cliente)?$venta->dui_cliente:"-");?></span>
								</p>
								<!--NIT-->
								<p style="margin:0px;">
									<label class="control-label">NIT:</label> <span class="info-venta-venta" id="detalles-venta-info-nit" data-value="<?php echo (isset($venta->nit_cliente)?$venta->nit_cliente:"-");?>"> <?php echo (isset($venta->nit_cliente)?$venta->nit_cliente:"-");?></span>
								</p>
								<!--NRC-->
								<p style="margin:0px;">
									<label class="control-label">NRC:</label> <span class="info-venta-venta" id="detalles-venta-info-nrc" data-value="<?php echo (isset($venta->nrc_cliente)?$venta->nrc_cliente:"-");?>"> <?php echo (isset($venta->nrc_cliente)?$venta->nrc_cliente:"-");?></span>
								</p>
							</div>
							<div class="clearfix"></div>
						</div>
					</div>
				</div>
			</div>
			<!--Encabezado de la tabla de productoa-->
			<div class="row">
				<table class="table table-hover" style="margin:0px;">
					<thead>
						<tr>
							<th style="width:15%">SKU</th>
							<th style="width:40%">Nombre</th>
							<th style="width:10%">Cant.</th>
							<th style="width:10%">Costo.</th>
							<th style="width:10%">Total.</th>
							<th style="width:5%"></th>
							<th style="width:10%">Quitar</th>
						</tr>
					</thead>
				</table>
			</div>
			<!--Tabla de productos-->
			<div class="row">
				<div id="nueva-venta-productos-wrapper">
					<table class="table table-hover table-striped">
						<tbody>
							<?php if(count($productos)>0):foreach($productos as $producto):?>
								<tr data-interno="<?php echo $producto->interno;?>">
									<td class='table-sku' data-value='<?php echo $producto->sku;?>'><?php echo $producto->sku;?></td>
									<td class='table-desc' data-value='<?php echo $producto->desc;?>'><?php echo $producto->desc;?></td>
									<td class='table-cant' data-value='<?php echo $producto->cant;?>'><?php echo $producto->cant;?></td>
									<td class='table-precio' data-value='<?php echo $producto->costo;?>'><?php echo $producto->costo;?></td>
									<td class='table-total' data-value='<?php echo $producto->cant*$producto->costo;?>'><?php echo $producto->cant*$producto->costo;?></td>
									<td class='table-tipoventa' data-value='<?php echo $producto->tipo;?>'><?php switch($producto->tipo){case 0: echo 'G';break;case 1:echo 'E';break;case 2:echo 'NS';break;case 3:echo 'E';break;}?></td>
									<td class='table-del'></td>
								</tr>
							<?php endforeach;endif;?>
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