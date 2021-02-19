<?php
	$this->load->library('printer');
	$this->load->library('enletras');
	
	$phpPrinter = new Printer();
	$phpInletters = new EnLetras();
	
	$phpPrinter->resetAcum();
	$acum = 0;
	
	foreach($trans_cinta as $transaccion):
		switch($transaccion->tipo):
			case "Corte":
				$printer = printer_open("POS-80Cuts");
	
				printer_set_option($printer, PRINTER_MODE, 'RAW');
			
				printer_start_doc($printer, 'Corte Numero: '.$transaccion->corte->correlativo_corte);

				printer_start_page($printer);
				
				/*Body*/
				
				$font = printer_create_font("Arial", 14, 12, PRINTER_FW_BOLD, false, false, false, 0);
				printer_select_font($printer, $font);
				
				$phpPrinter->printString($phpPrinter->cutString(strtoupper(utf8_decode($nombre_empresa)),23),1,$printer,$acum,12,14,15,10,1);
				
				printer_delete_font($font);
				
				$font = printer_create_font("Arial", 13, 9, PRINTER_FW_MEDIUM, false, false, false, 0);
				printer_select_font($printer, $font);
				
				$phpPrinter->tabPrinter($acum,10);
				
				$phpPrinter->printString($phpPrinter->cutString(utf8_decode($rsocial_empresa),23),1,$printer,$acum,9,13,15,10,1);
				$phpPrinter->printString($phpPrinter->cutString(utf8_decode($direcion_empresa),23),1,$printer,$acum,9,13,15,10,1);
				$phpPrinter->printString($phpPrinter->cutString(utf8_decode('NRC: '.$nrc_empresa),23),1,$printer,$acum,9,13,15,10,1);
				$phpPrinter->printString($phpPrinter->cutString(utf8_decode('NIT: '.$nit_empresa),23),1,$printer,$acum,9,13,15,10,1);
				$phpPrinter->printString($phpPrinter->cutString(utf8_decode('Resolucion'),23),1,$printer,$acum,9,13,15,10,1);
				$phpPrinter->printString($phpPrinter->cutString(utf8_decode($doc_resolucion),23),1,$printer,$acum,9,13,15,10,1);
				$phpPrinter->printString($phpPrinter->cutString(utf8_decode('Del '.$doc_desde.' Al: '.$doc_hasta),23),1,$printer,$acum,9,13,15,10,1);
				$phpPrinter->printString($phpPrinter->cutString(utf8_decode($transaccion->corte->nombre_caja),23),1,$printer,$acum,9,13,15,10,1);
				
				$phpPrinter->tabPrinter($acum,10);
				
				printer_delete_font($font); 
				
				$font = printer_create_font("Arial", 14, 12, PRINTER_FW_BOLD, false, false, false, 0);
				printer_select_font($printer, $font);
				
				$phpPrinter->printString($phpPrinter->cutString(strtoupper(utf8_decode("TOTAL ").($transaccion->corte->tipo_corte==0?"X":($transaccion->corte->tipo_corte==1?"X PARCIAL":($transaccion->corte->tipo_corte==2?"Z":($transaccion->corte->tipo_corte==3?"Z MENSUAL":""))))),23),1,$printer,$acum,12,14,15,10,1);
				
				printer_delete_font($font);
				
				$font = printer_create_font("Arial", 13, 9, PRINTER_FW_MEDIUM, false, false, false, 0);
				printer_select_font($printer, $font);
				
				$phpPrinter->printString($phpPrinter->cutString(utf8_decode('Reporte No: '.$transaccion->corte->correlativo_corte),23),1,$printer,$acum,9,13,15,10,1);
				$phpPrinter->tabPrinter($acum,10);
				$phpPrinter->printString("- - - - - - - - - - - - - - - - - - - - - - - - - - -",2,$printer,$acum,10,10,0);
				$phpPrinter->tabPrinter($acum,10);
				
				/*Tickets*/
				$phpPrinter->printString(utf8_decode('Total Gravadas:'),2,$printer,$acum,10,13,0);
				$phpPrinter->printString(utf8_decode('$'),2,$printer,$acum,10,0,250);
				$phpPrinter->printString($transaccion->dataCorteFiscal['total_ticket_grabado'],2,$printer,$acum,10,0,270);
				$phpPrinter->printString(utf8_decode('Total Exentas:'),2,$printer,$acum,10,13,0);
				$phpPrinter->printString(utf8_decode('$'),2,$printer,$acum,10,0,250);
				$phpPrinter->printString($transaccion->dataCorteFiscal['total_ticket_exento'],2,$printer,$acum,10,0,270);
				$phpPrinter->printString(utf8_decode('Total Ventas No Sujetas:'),2,$printer,$acum,10,13,0);
				$phpPrinter->printString(utf8_decode('$'),2,$printer,$acum,10,0,250);
				$phpPrinter->printString($transaccion->dataCorteFiscal['total_ticket_nosujeto'],2,$printer,$acum,10,0,270);
				printer_delete_font($font);
				$font = printer_create_font("Arial", 14, 12, PRINTER_FW_BOLD, false, false, false, 0);
				printer_select_font($printer, $font);
				$phpPrinter->printString(utf8_decode('Total Tickets:'),2,$printer,$acum,10,13,0);
				$phpPrinter->printString(utf8_decode('$'),2,$printer,$acum,10,0,250);
				$phpPrinter->printString(($transaccion->dataCorteFiscal['total_ticket_grabado']+$transaccion->dataCorteFiscal['total_ticket_exento']+$transaccion->dataCorteFiscal['total_ticket_nosujeto']),2,$printer,$acum,10,0,270);
				printer_delete_font($font);
				$font = printer_create_font("Arial", 13, 9, PRINTER_FW_MEDIUM, false, false, false, 0);
				printer_select_font($printer, $font);
				printer_draw_line($printer, 0, $phpPrinter->getAcum()+12, 340, $phpPrinter->getAcum()+12);
				
				/*Factura*/
				$phpPrinter->printString(utf8_decode('Total Gravadas:'),2,$printer,$acum,10,13,0);
				$phpPrinter->printString(utf8_decode('$'),2,$printer,$acum,10,0,250);
				$phpPrinter->printString($transaccion->dataCorteFiscal['total_factura_grabado'],2,$printer,$acum,10,0,270);
				$phpPrinter->printString(utf8_decode('Total Exentas:'),2,$printer,$acum,10,13,0);
				$phpPrinter->printString(utf8_decode('$'),2,$printer,$acum,10,0,250);
				$phpPrinter->printString($transaccion->dataCorteFiscal['total_factura_exento'],2,$printer,$acum,10,0,270);
				$phpPrinter->printString(utf8_decode('Total Ventas No Sujetas:'),2,$printer,$acum,10,13,0);
				$phpPrinter->printString(utf8_decode('$'),2,$printer,$acum,10,0,250);
				$phpPrinter->printString($transaccion->dataCorteFiscal['total_factura_nosujeto'],2,$printer,$acum,10,0,270);
				printer_delete_font($font);
				$font = printer_create_font("Arial", 14, 12, PRINTER_FW_BOLD, false, false, false, 0);
				printer_select_font($printer, $font);
				$phpPrinter->printString(utf8_decode('Total Factura:'),2,$printer,$acum,10,13,0);
				$phpPrinter->printString(utf8_decode('$'),2,$printer,$acum,10,0,250);
				$phpPrinter->printString(($transaccion->dataCorteFiscal['total_factura_grabado']+$transaccion->dataCorteFiscal['total_factura_exento']+$transaccion->dataCorteFiscal['total_factura_nosujeto']),2,$printer,$acum,10,0,270);
				printer_delete_font($font);
				$font = printer_create_font("Arial", 13, 9, PRINTER_FW_MEDIUM, false, false, false, 0);
				printer_select_font($printer, $font);
				printer_draw_line($printer, 0, $phpPrinter->getAcum()+12, 340, $phpPrinter->getAcum()+12);
				
				/*CCF*/
				$phpPrinter->printString(utf8_decode('Total Gravadas:'),2,$printer,$acum,10,13,0);
				$phpPrinter->printString(utf8_decode('$'),2,$printer,$acum,10,0,250);
				$phpPrinter->printString($transaccion->dataCorteFiscal['total_ccf_grabado'],2,$printer,$acum,10,0,270);
				$phpPrinter->printString(utf8_decode('Total Exentas:'),2,$printer,$acum,10,13,0);
				$phpPrinter->printString(utf8_decode('$'),2,$printer,$acum,10,0,250);
				$phpPrinter->printString($transaccion->dataCorteFiscal['total_ccf_exento'],2,$printer,$acum,10,0,270);
				$phpPrinter->printString(utf8_decode('Total Ventas No Sujetas:'),2,$printer,$acum,10,13,0);
				$phpPrinter->printString(utf8_decode('$'),2,$printer,$acum,10,0,250);
				$phpPrinter->printString($transaccion->dataCorteFiscal['total_ccf_nosujeto'],2,$printer,$acum,10,0,270);
				printer_delete_font($font);
				$font = printer_create_font("Arial", 14, 12, PRINTER_FW_BOLD, false, false, false, 0);
				printer_select_font($printer, $font);
				$phpPrinter->printString(utf8_decode('Total CCF:'),2,$printer,$acum,10,13,0);
				$phpPrinter->printString(utf8_decode('$'),2,$printer,$acum,10,0,250);
				$phpPrinter->printString(($transaccion->dataCorteFiscal['total_ccf_grabado']+$transaccion->dataCorteFiscal['total_ccf_exento']+$transaccion->dataCorteFiscal['total_ccf_nosujeto']),2,$printer,$acum,10,0,270);
				printer_delete_font($font);
				$font = printer_create_font("Arial", 13, 9, PRINTER_FW_MEDIUM, false, false, false, 0);
				printer_select_font($printer, $font);
				printer_draw_line($printer, 0, $phpPrinter->getAcum()+12, 340, $phpPrinter->getAcum()+12);
				$total_ventas = $transaccion->dataCorteFiscal['total_ticket_grabado']+$transaccion->dataCorteFiscal['total_ticket_exento']+$transaccion->dataCorteFiscal['total_ticket_nosujeto']+$transaccion->dataCorteFiscal['total_factura_grabado']+$transaccion->dataCorteFiscal['total_factura_exento']+$transaccion->dataCorteFiscal['total_factura_nosujeto']+$transaccion->dataCorteFiscal['total_ccf_grabado']+$transaccion->dataCorteFiscal['total_ccf_exento']+$transaccion->dataCorteFiscal['total_ccf_nosujeto'];
				
				/*Devoluciones*/
				$phpPrinter->printString(utf8_decode('Devolucion Tickets:'),2,$printer,$acum,10,13,0);
				$phpPrinter->printString(utf8_decode('$'),2,$printer,$acum,10,0,250);
				$phpPrinter->printString($transaccion->dataCorteFiscal['total_devolucion_ticket'],2,$printer,$acum,10,0,270);
				$phpPrinter->printString(utf8_decode('Anulacion Facturas:'),2,$printer,$acum,10,13,0);
				$phpPrinter->printString(utf8_decode('$'),2,$printer,$acum,10,0,250);
				$phpPrinter->printString($transaccion->dataCorteFiscal['total_devolucion_factura'],2,$printer,$acum,10,0,270);
				$phpPrinter->printString(utf8_decode('Anulacion CCF:'),2,$printer,$acum,10,13,0);
				$phpPrinter->printString(utf8_decode('$'),2,$printer,$acum,10,0,250);
				$phpPrinter->printString($transaccion->dataCorteFiscal['total_devolucion_ccf'],2,$printer,$acum,10,0,270);
				$phpPrinter->printString(utf8_decode('Anulacion Nota de Credito:'),2,$printer,$acum,10,13,0);
				$phpPrinter->printString(utf8_decode('$'),2,$printer,$acum,10,0,250);
				$phpPrinter->printString($transaccion->dataCorteFiscal['total_devolucion_ncredito'],2,$printer,$acum,10,0,270);
				printer_delete_font($font);
				$font = printer_create_font("Arial", 14, 12, PRINTER_FW_BOLD, false, false, false, 0);
				printer_select_font($printer, $font);
				$phpPrinter->printString(utf8_decode('Total Devoluciones:'),2,$printer,$acum,10,13,0);
				$phpPrinter->printString(utf8_decode('$'),2,$printer,$acum,10,0,250);
				$total_devs = $transaccion->dataCorteFiscal['total_devolucion_ticket']+$transaccion->dataCorteFiscal['total_devolucion_factura']+$transaccion->dataCorteFiscal['total_devolucion_ccf']+$transaccion->dataCorteFiscal['total_devolucion_ncredito'];
				$phpPrinter->printString(("(".$total_devs.")"),2,$printer,$acum,10,0,270);
				printer_draw_line($printer, 0, $phpPrinter->getAcum()+12, 340, $phpPrinter->getAcum()+12);
				
				/*Total*/
				$phpPrinter->printString(utf8_decode('Total Ventas:'),2,$printer,$acum,10,13,0);
				$phpPrinter->printString(utf8_decode('$'),2,$printer,$acum,10,0,250);
				$phpPrinter->printString(($total_ventas - $total_devs),2,$printer,$acum,10,0,270);
				printer_draw_line($printer, 0, $phpPrinter->getAcum()+12, 340, $phpPrinter->getAcum()+12);
				printer_delete_font($font);
				$font = printer_create_font("Arial", 13, 9, PRINTER_FW_MEDIUM, false, false, false, 0);
				printer_select_font($printer, $font);
				$phpPrinter->tabPrinter($acum,5);
				
				/*Contadores*/
				$phpPrinter->printString(utf8_decode('No Trans. Realizadas:'),2,$printer,$acum,10,13,0);
				$trans = $transaccion->dataCorteFiscal['total_trans_ticket']+$transaccion->dataCorteFiscal['total_trans_ticket_dev']+$transaccion->dataCorteFiscal['total_trans_factura']+$transaccion->dataCorteFiscal['total_trans_ccf'];
				$phpPrinter->printString($trans,2,$printer,$acum,10,0,270);
				$phpPrinter->printString(utf8_decode('Tickets Emitidos:'),2,$printer,$acum,10,13,0);
				$phpPrinter->printString(($transaccion->dataCorteFiscal['total_trans_ticket']+$transaccion->dataCorteFiscal['total_trans_ticket_dev']),2,$printer,$acum,10,0,270);
				$phpPrinter->printString(utf8_decode('Devoluciones(Tickets):'),2,$printer,$acum,10,13,0);
				$phpPrinter->printString($transaccion->dataCorteFiscal['total_trans_ticket_dev'],2,$printer,$acum,10,0,270);
				$phpPrinter->printString(utf8_decode('Inicio:'),2,$printer,$acum,10,13,0);
				$phpPrinter->printString($transaccion->dataCorteFiscal['ticketInicio'],2,$printer,$acum,10,0,270);
				$phpPrinter->printString(utf8_decode('Final:'),2,$printer,$acum,10,13,0);
				$phpPrinter->printString($transaccion->dataCorteFiscal['ticketFin'],2,$printer,$acum,10,0,270);
				$phpPrinter->printString(utf8_decode('Facturas Emitidas:'),2,$printer,$acum,10,13,0);
				$phpPrinter->printString($transaccion->dataCorteFiscal['total_trans_factura'],2,$printer,$acum,10,0,270);
				$phpPrinter->printString(utf8_decode('CCF Emitidos:'),2,$printer,$acum,10,13,0);
				$phpPrinter->printString($transaccion->dataCorteFiscal['total_trans_ccf'],2,$printer,$acum,10,0,270);
				$phpPrinter->tabPrinter($acum,5);
				
				/*Cajero y Fecha*/
				$phpPrinter->printString("Cajero: ".$transaccion->corte->nombre_usuario,2,$printer,$acum,10,13,0);
				$phpPrinter->printString($transaccion->corte->fecha_corte,2,$printer,$acum,10,13,0);
				$phpPrinter->tabPrinter($acum,5);
				$phpPrinter->printString($phpPrinter->cutString(utf8_decode('***Operacion Finalizada***'),25),1,$printer,$acum,9,13,15,10,1);
				
				printer_delete_font($font);
				
				printer_end_page($printer);

				printer_end_doc($printer);	

				printer_close($printer);
			break;
			case "Venta":
				$printer = printer_open("POS-80Cuts");
	
				printer_set_option($printer, PRINTER_MODE, 'RAW');
				
				printer_start_doc($printer, 'Ticket Numero: '.$transaccion->venta->num_doc_venta);

				printer_start_page($printer);
				
				/*Body*/
				
				$font = printer_create_font('Arial', 20, 11, PRINTER_FW_THIN, false, false, false, 0);	
				printer_select_font($printer, $font);
				
				$phpPrinter->printString($phpPrinter->cutString(strtoupper(utf8_decode($nombre_empresa)),24),1,$printer,$acum,11,20);
				
				printer_delete_font($font);
				
				$font = printer_create_font('Arial', 20, 11, PRINTER_FW_THIN, false, false, false, 0);	
				printer_select_font($printer, $font);
				
				$phpPrinter->tabPrinter($acum,20);
				
				$phpPrinter->printString($phpPrinter->cutString(strtoupper(utf8_decode($rsocial_empresa)),24),1,$printer,$acum,11,20);
				$phpPrinter->printString($phpPrinter->cutString(strtoupper(utf8_decode($direcion_empresa)),24),1,$printer,$acum,11,20);
				$phpPrinter->printString($phpPrinter->cutString(strtoupper(utf8_decode('NRC: '.$nrc_empresa)),24),1,$printer,$acum,11,20);
				$phpPrinter->printString($phpPrinter->cutString(strtoupper(utf8_decode('NIT: '.$nit_empresa)),24),1,$printer,$acum,11,20);
				$phpPrinter->printString($phpPrinter->cutString(strtoupper(utf8_decode('Autorizacion segun Resolucion')),24),1,$printer,$acum,11,20);
				$phpPrinter->printString($phpPrinter->cutString(strtoupper(utf8_decode('No '.$doc_resolucion)),24),1,$printer,$acum,11,20);
				$phpPrinter->printString($phpPrinter->cutString(strtoupper(utf8_decode('Del '.$doc_desde)),24),1,$printer,$acum,11,20);
				$phpPrinter->printString($phpPrinter->cutString(strtoupper(utf8_decode('Al '.$doc_hasta)),24),1,$printer,$acum,11,20);
				$phpPrinter->printString($phpPrinter->cutString(utf8_decode('TICKET '.$transaccion->venta->num_doc_venta),24),1,$printer,$acum,11,20);
				$phpPrinter->printString($phpPrinter->cutString(strtoupper(utf8_decode('Caja: '.$transaccion->venta->nombre_caja)),24),1,$printer,$acum,11,20);
				$phpPrinter->printString($phpPrinter->cutString(strtoupper(utf8_decode('Vendedor: '.$transaccion->venta->nombre_usuario)),24),1,$printer,$acum,11,20);
				
				$phpPrinter->tabPrinter($acum,20);
				
				$phpPrinter->printString(strtoupper(utf8_decode('fecha: ')),2,$printer,$acum,11,20,0);
				$phpPrinter->printString(strtoupper(utf8_decode($transaccion->venta->fecha_venta)),2,$printer,$acum,11,0,100);
				
				$phpPrinter->tabPrinter($acum,20);
				
				$phpPrinter->printString(strtoupper(utf8_decode('Cant')),2,$printer,$acum,11,20,0);
				$phpPrinter->printString(strtoupper(utf8_decode('Desc')),2,$printer,$acum,11,0,70);
				$phpPrinter->printString(strtoupper(utf8_decode('P/U')),2,$printer,$acum,11,0,200);
				$phpPrinter->printString(strtoupper(utf8_decode('Total')),2,$printer,$acum,11,0,270);
				
				$phpPrinter->tabPrinter($acum,5);
				
				foreach($transaccion->productos as $producto){
					$phpPrinter->printString($producto->cant_vproducto,2,$printer,$acum,11,20,0);
					$phpPrinter->printString($phpPrinter->cutString(strtoupper(utf8_decode(addslashes($producto->nombre_plato))),12),2,$printer,$acum,11,0,50,20);
					$phpPrinter->printString(number_format($producto->costo_vproducto,2),2,$printer,$acum,11,0,240);
					$phpPrinter->printString(number_format($producto->cant_vproducto * $producto->costo_vproducto,2),2,$printer,$acum,11,0,310);
					$phpPrinter->printString("G",2,$printer,$acum,11,0,380);
					$phpPrinter->tabPrinter($acum,3);
				}
				$phpPrinter->printString("______________________________",2,$printer,$acum,11,20,0);
				$phpPrinter->printString("G=Gravado E=Exento NS=No Sujeto",2,$printer,$acum,11,20,0);
				$phpPrinter->tabPrinter($acum,20);
				
				$phpPrinter->printString(strtoupper(utf8_decode('TOTAL GRAVADO')),2,$printer,$acum,11,20,10);
				$phpPrinter->printString("$",2,$printer,$acum,11,0,260);
				$phpPrinter->printString(($transaccion->venta->subtotal_venta-$transaccion->venta->descuento_venta),2,$printer,$acum,11,0,280);
				
				$phpPrinter->printString(strtoupper(utf8_decode('TOTAL EXENTO')),2,$printer,$acum,11,20,10);
				$phpPrinter->printString("$",2,$printer,$acum,11,0,260);
				$phpPrinter->printString($transaccion->venta->total_exento_venta,2,$printer,$acum,11,0,280);
				
				$phpPrinter->printString(strtoupper(utf8_decode('TOTAL NO SUJETO')),2,$printer,$acum,11,20,10);
				$phpPrinter->printString("$",2,$printer,$acum,11,0,260);
				$phpPrinter->printString($transaccion->venta->total_nosujeto_venta,2,$printer,$acum,11,0,280);
				
				$phpPrinter->printString(strtoupper(utf8_decode('TOTAL')),2,$printer,$acum,11,20,10);
				$phpPrinter->printString("$",2,$printer,$acum,11,0,260);
				$phpPrinter->printString(($transaccion->venta->subtotal_venta-$transaccion->venta->descuento_venta),2,$printer,$acum,11,0,280);
				
				$phpPrinter->printString(strtoupper(utf8_decode('EFECTIVO')),2,$printer,$acum,11,20,10);
				$phpPrinter->printString("$",2,$printer,$acum,11,0,260);
				$phpPrinter->printString(($transaccion->venta->subtotal_venta-$transaccion->venta->descuento_venta),2,$printer,$acum,11,0,280);
				
				$phpPrinter->printString(strtoupper(utf8_decode('CAMBIO')),2,$printer,$acum,11,20,10);
				$phpPrinter->printString("$",2,$printer,$acum,11,0,260);
				$phpPrinter->printString(("0.00"),2,$printer,$acum,11,0,280);
				
				$phpPrinter->tabPrinter($acum,20);
				
				$phpPrinter->printString($phpPrinter->cutString(strtoupper(utf8_decode('F:__________________________')),24),1,$printer,$acum,11,20);
				$phpPrinter->printString($phpPrinter->cutString(strtoupper(utf8_decode($transaccion->venta->nombre_cliente)),24),1,$printer,$acum,11,20);

				if($transaccion->venta->dui_cliente!=""):
				$phpPrinter->printString($phpPrinter->cutString(strtoupper(utf8_decode('DUI: '.$transaccion->venta->dui_cliente)),24),1,$printer,$acum,11,20);
				endif;
				if($transaccion->venta->nit_cliente!=""):
				$phpPrinter->printString($phpPrinter->cutString(strtoupper(utf8_decode('NIT: '.$transaccion->venta->nit_cliente)),24),1,$printer,$acum,11,20);
				endif;
				if($transaccion->venta->nrc_cliente!=""):
				$phpPrinter->printString($phpPrinter->cutString(strtoupper(utf8_decode('NRC: '.$transaccion->venta->nrc_cliente)),24),1,$printer,$acum,11,20);
				endif;
				$phpPrinter->tabPrinter($acum,20);
				
				$phpPrinter->printString($phpPrinter->cutString(strtoupper(utf8_decode($mensaje_ticket)),24),1,$printer,$acum,11,20);
				$phpPrinter->printString($phpPrinter->cutString(strtoupper(utf8_decode("Ref:".$transaccion->venta->id_venta)),24),1,$printer,$acum,11,20);
				
				printer_delete_font($font);
				
				printer_end_page($printer);

				printer_end_doc($printer);	

				printer_close($printer);
			break;
			case "Devolucion":
				
			break;
		endswitch;
		$phpPrinter->resetAcum();
		$acum = 0;
	endforeach;
	
?>