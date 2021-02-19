<?php 
	if(isset($corteFiscal) && $corteFiscal)extract($corteFiscal);
	if(isset($anexoMedios) && $anexoMedios)extract($anexoMedios);
	if(isset($anexoDocumento) && $anexoDocumento)extract($anexoDocumento);
	if(isset($anexoTipo) && $anexoTipo)extract($anexoTipo);
	if(isset($modal) && $modal):
?>
<div style="height:475px;overflow:scroll">
<?php endif;?>
<div class="tabs-container">
	<div class="tabs-left">
		<ul class="nav nav-tabs">
			<?php if(isset($corteFiscal) && $corteFiscal):?>
			<li class="active">
				<a data-toggle="tab" href="#cortes-app-fiscal-tab">Corte fiscal</a>
			</li>
			<?php endif; if(isset($mensajeCorreo) && $mensajeCorreo):?>
			<li>
				<a data-toggle="tab" href="#cortes-app-correo-tab">Correo</a>
			</li>
			<?php endif;?>
		</ul>
		<div class="tab-content m-md" id="cortes-app-tab-content">
			<!--Corte Fiscal-->
			<?php if(isset($corteFiscal) && $corteFiscal):?>
			<div id="cortes-app-fiscal-tab" class="tab-pane active">
				<table class="table table-hover">
					<!--Factura-->
					<tr>
						<td colspan="2"><b>Total facturas</b></td>
						<td></td>
						<td></td>
						<td>$</td>
						<td class="money"><b><?php $totalFiscalFacturas=$total_factura_grabado+$total_factura_exento+$total_factura_nosujeto;echo number_format($totalFiscalFacturas,2,".",",");?></b></td>
					</tr>
					<tr>
						<td></td>
						<td> Total Gravadas</td>
						<td>$</td>
						<td class="money"><?php echo number_format($total_factura_grabado,2,".",",");?></td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td></td>
						<td>Total Exentas</td>
						<td>$</td>
						<td class="money"><?php echo number_format($total_factura_exento,2,".",",");?></td>
						<td></td>
						<td></td>
					</tr>
					<tr class="border-div">
						<td></td>
						<td>Total No Sujetas</td>
						<td>$</td>
						<td class="money"><?php echo number_format($total_factura_nosujeto,2,".",",");?></td>
						<td></td>
						<td></td>
					</tr>
					<!--CCF-->
					<tr>
						<td colspan="2"><b>Total CCF</b></td>
						<td></td>
						<td></td>
						<td>$</td>
						<td class="money"><b><?php $totalFiscalCCF=$total_ccf_grabado+$total_ccf_exento+$total_ccf_nosujeto;echo number_format($totalFiscalCCF,2,".",",");?></b></td>
					</tr>
					<tr>
						<td></td>
						<td> Total Gravadas</td>
						<td>$</td>
						<td class="money"><?php echo number_format($total_ccf_grabado,2,".",",");?></td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td></td>
						<td>Total Exentas</td>
						<td>$</td>
						<td class="money"><?php echo number_format($total_ccf_exento,2,".",",");?></td>
						<td></td>
						<td></td>
					</tr>
					<tr class="border-div">
						<td></td>
						<td>Total No Sujetas</td>
						<td>$</td>
						<td class="money"><?php echo number_format($total_ccf_nosujeto,2,".",",");?></td>
						<td></td>
						<td></td>
					</tr>
					<!--Tickets-->
					<tr>
						<td colspan="2"><b>Total tickets</b></td>
						<td></td>
						<td></td>
						<td>$</td>
						<td class="money"><b><?php $totalFiscalTicket=$total_ticket_grabado+$total_ticket_exento+$total_ticket_nosujeto;echo number_format($totalFiscalTicket,2,".",",");?></b></td>
					</tr>
					<tr>
						<td></td>
						<td> Total Gravadas</td>
						<td>$</td>
						<td class="money"><?php echo number_format($total_ticket_grabado,2,".",",");?></td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td></td>
						<td> Total Interno</td>
						<td>$</td>
						<td class="money"><?php echo number_format($total_ticket_interno,2,".",",");?></td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td></td>
						<td> Total Exentas</td>
						<td>$</td>
						<td class="money"><?php echo number_format($total_ticket_exento,2,".",",");?></td>
						<td></td>
						<td></td>
					</tr>
					<tr class="border-div">
						<td></td>
						<td> Total No Sujetas</td>
						<td>$</td>
						<td class="money"><?php echo number_format($total_ticket_nosujeto,2,".",",");?></td>
						<td></td>
						<td></td>
					</tr>
					<!--Propina-->
					<tr  class="border-div">
						<td colspan="2"><b>TOTAL PROPINA</b></td>
						<td></td>
						<td></td>
						<td>$</td>
						<td class="money"><b><?php echo number_format($total_propina+$total_propina_pos,2,".",",");?></b></td>
					</tr>
					<!--Anulaciones-->
					<tr>
						<td colspan="2"><b>Devoluciones</b></td>
						<td></td>
						<td></td>
						<td>$</td>
						<td class="money"><b>(<?php $totalFiscalDev=$total_devolucion_factura+$total_devolucion_ccf+$total_devolucion_ticket+$total_devolucion_ncredito;echo number_format($totalFiscalDev,2,".",",");?>)</b></td>
					</tr>
					<tr>
						<td></td>
						<td>Devoluci&oacute;n Facturas</td>
						<td>$</td>
						<td class="money"><?php echo number_format($total_devolucion_factura,2,".",",");?></td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td></td>
						<td>Devoluci&oacute;n CCF</td>
						<td>$</td>
						<td class="money"><?php echo number_format($total_devolucion_ccf,2,".",",");?></td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td></td>
						<td>Devoluci&oacute;n Nota Cr&eacute;dito</td>
						<td>$</td>
						<td class="money"><?php echo number_format($total_devolucion_ncredito,2,".",",");?></td>
						<td></td>
						<td></td>
					</tr>
					<tr class="border-div">
						<td></td>
						<td>Devoluci&oacute;n Tickets</td>
						<td>$</td>
						<td class="money"><?php echo number_format($total_devolucion_ticket,2,".",",");?></td>
						<td></td>
						<td></td>
					</tr>
					<!--Totales-->
					<tr  class="border-div">
						<td colspan="2"><b>TOTAL EN VENTAS</b></td>
						<td></td>
						<td></td>
						<td>$</td>
						<td class="money"><b><?php echo number_format($total_propina+$total_propina_pos+$totalFiscalFacturas+$totalFiscalCCF+$totalFiscalTicket-$totalFiscalDev,2,".",",");?></b></td>
					</tr>
					<tr>
						<td colspan="2">Facturas Emitidas</td>
						<td></td>
						<td></td>
						<td></td>
						<td><?php echo $total_trans_factura;?></td>
					</tr>
					<tr>
						<td colspan="2">CCF Emitidos</td>
						<td></td>
						<td></td>
						<td></td>
						<td><?php echo $total_trans_ccf;?></td>
					</tr>
					<tr>
						<td colspan="2">Nota Cr&eacute;dito Emitidas</td>
						<td></td>
						<td></td>
						<td></td>
						<td><?php echo $total_trans_ncredito;?></td>
					</tr>
					<tr>
						<td colspan="2">Tickets Emitidos</td>
						<td></td>
						<td></td>
						<td></td>
						<td><?php echo $total_trans_ticket;?></td>
					</tr>
					<tr>
						<td colspan="2">Tickets devoluci&oacute;n</td>
						<td></td>
						<td></td>
						<td></td>
						<td><?php echo $total_trans_ticket_dev;?></td>
					</tr>
					<tr>
						<td></td>
						<td>Tickets inicio</td>
						<td></td>
						<td><?php echo str_pad($ticketInicio,7, "0", STR_PAD_LEFT);?></td>
						<td></td>
						<td></td>
					</tr>
					<tr class="border-div">
						<td></td>
						<td>Tickets final</td>
						<td></td>
						<td><?php echo (($ticketFin!="-")?str_pad($ticketFin,7, "0", STR_PAD_LEFT):"-");?></td>
						<td></td>
						<td></td>
					</tr>
					<tr class="border-div">
						<td colspan="2">Transacciones realizadas</td>
						<td></td>
						<td></td>
						<td></td>
						<td><?php echo $total_trans_factura+ $total_trans_ccf+$total_trans_ncredito+$total_trans_ticket+$total_trans_ticket_dev;?></td>
					</tr>
					<tr  class="border-div">
						<td colspan="2"><b>TOTAL EN EFECTIVO</b></td>
						<td></td>
						<td></td>
						<td>$</td>
						<td class="money"><b><?php echo number_format($total_ventas_efectivo,2,".",",");?></b></td>
					</tr>
					<tr  class="border-div">
						<td colspan="2"><b>TOTAL EN EFECTIVO CC</b></td>
						<td></td>
						<td></td>
						<td>$</td>
						<td class="money"><b><?php echo number_format($total_ventas_efectivo_cc,2,".",",");?></b></td>
					</tr>
					<tr  class="border-div">
						<td colspan="2"><b>TOTAL PROPINA EN EFECTIVO</b></td>
						<td></td>
						<td></td>
						<td>$</td>
						<td class="money"><b><?php echo number_format($total_propina,2,".",",");?></b></td>
					</tr>
					<tr  class="border-div">
						<td colspan="2"><b>TOTAL EN POS</b></td>
						<td></td>
						<td></td>
						<td>$</td>
						<td class="money"><b><?php echo number_format($total_ventas_pos,2,".",",");?></b></td>
					</tr>
					<tr  class="border-div">
						<td colspan="2"><b>TOTAL EN POS CC</b></td>
						<td></td>
						<td></td>
						<td>$</td>
						<td class="money"><b><?php echo number_format($total_ventas_pos_cc,2,".",",");?></b></td>
					</tr>
					<tr  class="border-div">
						<td colspan="2"><b>TOTAL PROPINA POS</b></td>
						<td></td>
						<td></td>
						<td>$</td>
						<td class="money"><b><?php echo number_format($total_propina_pos,2,".",",");?></b></td>
					</tr>
					<tr  class="border-div">
						<td colspan="2"><b>DOTACION</b></td>
						<td></td>
						<td></td>
						<td>$</td>
						<td class="money"><b><?php echo number_format($dotacion,2,".",",");?></b></td>
					</tr>
					<tr  class="border-div">
						<td colspan="2"><b>TOTAL EFECTIVO</b></td>
						<td></td>
						<td></td>
						<td>$</td>
						<td class="money"><b><?php echo number_format($dotacion+$total_ventas_efectivo+$total_ventas_efectivo_cc+$total_propina,2,".",",");?></b></td>
					</tr>
				</table>
			</div>
			<?php endif;?>
			<!--Corte Fiscal-->
			<?php if(isset($mensajeCorreo) && $mensajeCorreo):?>
			<div id="cortes-app-correo-tab" class="tab-pane">
				<?php echo $mensajeCorreo;?>
			<?php endif;?>
			<input type="hidden" id="id_corte" value="<?php echo $id_corte;?>">
		</div>
	</div>
</div>
<?php if(isset($modal) && $modal):?>
</div>
<?php endif;?>