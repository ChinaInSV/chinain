<!--Info-->
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
<!--Encabezado de tabla-->
<div>
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
<!--tabla-->
<div  class="bord-all" style="height:200px;overflow-y:scroll;" id="devolucion-productos-table-wrapper">
	<table class="table table-striped">
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
<!--totales-->
<div class="row">
	<div class="col-sm-5"></div>
	<div class="col-sm-7">
		<table class="ufood-transaccion-table">
			<tbody>
				<tr class="bord-all bg-gray-light" data-value="0.00">
					<td ><span class="text-semibold text-2x">TOTAL A DEVOLVER</span></td>
					<td class="text-right"><span class="text-semibold text-2x">$</span></td>
					<td class="text-right total-value"><span class="text-semibold text-2x">( <?php echo number_format($total,2);?> )</span></td>
					<td></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
<!--hidden-->
<div>
	<input type="hidden" id="devolucion-info-total-dev" value="<?php echo number_format($total,2);?>">
	<input type="hidden" id="devolucion-info-venta-dev" value="<?php echo $info_venta->id_venta;?>">
</div>
<!--Modal-->
<div id="devolucion-modals-wrapper">
	<div class="modal fade" id="devolucion-info-cliente-<?php echo $winid;?>" data-parent="#<?php echo $winid;?>" role="dialog" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-md">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><i class="fa fa-times"></i></button>
					<h4 class="modal-title">Informaci&oacute;n de devoluci&oacute;n<b></b></h4>
				</div>
				<div class="modal-body bg-gray">
					<div class="row">
						<div class="col-sm-7">
							<label>Cliente</label>
							<input type="text" id="devolucion-info-cliente-nombre" class="form-control input-lg">
						</div>
						<div class="col-sm-5">
							<label>DUI</label>
							<input type="text" id="devolucion-info-cliente-dui" class="form-control input-lg">
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<label>Motivo</label>
							<input type="text" id="devolucion-info-cliente-motivo" class="form-control input-lg">
						</div>
					</div>
					<div class="row text-center pad-top">
						<button id="devolucion-info-cliente-continuar-btn" class="btn btn-success btn-lg">Continuar</button>
						<button id="devolucion-info-cliente-salir-btn" class="btn btn-danger btn-lg">Salir</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!--Botones-->
<div class="row text-center pad-top">
	<button id="devolucion-guardar-btn" class="btn btn-success btn-lg">Hacer devoluci&oacute;n</button>
	<button class="btn btn-danger btn-lg" onclick="Custombox.close();">Salir</button>
</div>