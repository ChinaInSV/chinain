<?php
	$this->load->library('printer');
	$this->load->library('enletras');
	
	$phpPrinter = new Printer();
	$phpInletters = new EnLetras();
	
	$phpPrinter->resetAcum();
	$acum = 0;
	
	if($printCorteFiscal):
		/*Corte*/
		$printer = printer_open("EPSON TM-U950 Receipt");

		printer_set_option($printer, PRINTER_MODE, 'RAW');
		
		printer_start_doc($printer, 'Corte Numero: '.$numero_corte);

		printer_start_page($printer);
		
		/*Body*/
		$width_letter=9;
		$height_letter=7;
		
		$tabwidth_letter=10;
		$tabheight_letter=10;
		
		$font = printer_create_font("Arial", 10, 8, PRINTER_FW_BOLD, false, false, false, 0);
		printer_select_font($printer, $font);
		
		printer_draw_bmp($printer, "C:\\logo.bmp", 20, 1,300,80);
		$phpPrinter->tabPrinter($acum,80);
		
		$phpPrinter->printString($phpPrinter->cutString(strtoupper(utf8_decode($nombre_empresa)),25),1,$printer,$acum,8,10);
		
		printer_delete_font($font);
		
		$font = printer_create_font("Arial", $width_letter, $height_letter, PRINTER_FW_MEDIUM, false, false, false, 0);
		printer_select_font($printer, $font);
		
		$phpPrinter->tabPrinter($acum,$tabwidth_letter);
		
		$phpPrinter->printString($phpPrinter->cutString(strtoupper(utf8_decode($rsocial_empresa)),28),1,$printer,$acum,$tabheight_letter,$tabwidth_letter);
		$phpPrinter->printString($phpPrinter->cutString(strtoupper(utf8_decode($direcion_empresa)),28),1,$printer,$acum,$tabheight_letter,$tabwidth_letter);
		$phpPrinter->printString($phpPrinter->cutString(strtoupper(utf8_decode('NRC: '.$nrc_empresa)),28),1,$printer,$acum,$tabheight_letter,$tabwidth_letter);
		$phpPrinter->printString($phpPrinter->cutString(strtoupper(utf8_decode('NIT: '.$nit_empresa)),28),1,$printer,$acum,$tabheight_letter,$tabwidth_letter);
		//$phpPrinter->printString($phpPrinter->cutString(strtoupper(utf8_decode('Autorizacion segun Resolucion')),28),1,$printer,$acum,$tabheight_letter,$tabwidth_letter);
		//$phpPrinter->printString($phpPrinter->cutString(strtoupper(utf8_decode('No '.$doc_resolucion)),28),1,$printer,$acum,$tabheight_letter,$tabwidth_letter);
		//$phpPrinter->printString($phpPrinter->cutString(strtoupper(utf8_decode('Del '.$doc_desde)),28),1,$printer,$acum,$tabheight_letter,$tabwidth_letter);
		//$phpPrinter->printString($phpPrinter->cutString(strtoupper(utf8_decode('Al '.$doc_hasta)),28),1,$printer,$acum,$tabheight_letter,$tabwidth_letter);
		$phpPrinter->printString($phpPrinter->cutString(strtoupper(utf8_decode('Caja: 1')),28),1,$printer,$acum,$tabheight_letter,$tabwidth_letter);
		$phpPrinter->printString($phpPrinter->cutString(strtoupper(utf8_decode('Vendedor: '.$cajero)),28),1,$printer,$acum,$tabheight_letter,$tabwidth_letter);
		
		$phpPrinter->tabPrinter($acum,$tabwidth_letter);		
		$phpPrinter->printString($phpPrinter->cutString(strtoupper(utf8_decode("TOTAL ").$tipo_corte),23),1,$printer,$acum,$tabheight_letter,$tabwidth_letter);
		$phpPrinter->tabPrinter($acum,$tabwidth_letter);
		
		$phpPrinter->printString($phpPrinter->cutString(utf8_decode('Reporte No: '.$numero_corte),23),1,$printer,$acum,$tabheight_letter,$tabwidth_letter);
		$phpPrinter->tabPrinter($acum,$tabwidth_letter);
		$phpPrinter->printString("- - - - - - - - - - - - - - - - - - - - - - - - - - -",2,$printer,$acum,$tabheight_letter,$tabwidth_letter,0);
		$phpPrinter->tabPrinter($acum,$tabwidth_letter);
		
		/*Tickets*/
		$phpPrinter->printString(utf8_decode('Total Gravadas:'),2,$printer,$acum,$tabheight_letter,$tabwidth_letter,0);
		$phpPrinter->printString(utf8_decode('$'),2,$printer,$acum,$tabheight_letter,0,250);
		$phpPrinter->printString(number_format($dataCorteFiscal['total_ticket_grabado'],2),2,$printer,$acum,$tabheight_letter,0,270);
		$phpPrinter->printString(utf8_decode('Total Exentas:'),2,$printer,$acum,$tabheight_letter,$tabwidth_letter,0);
		$phpPrinter->printString(utf8_decode('$'),2,$printer,$acum,$tabheight_letter,0,250);
		$phpPrinter->printString(number_format($dataCorteFiscal['total_ticket_exento'],2),2,$printer,$acum,$tabheight_letter,0,270);
		$phpPrinter->printString(utf8_decode('Total No Sujeto:'),2,$printer,$acum,$tabheight_letter,$tabwidth_letter,0);
		$phpPrinter->printString(utf8_decode('$'),2,$printer,$acum,$tabheight_letter,0,250);
		$phpPrinter->printString(number_format($dataCorteFiscal['total_ticket_nosujeto'],2),2,$printer,$acum,$tabheight_letter,0,270);
		
		$phpPrinter->printString(utf8_decode('Total Tickets:'),2,$printer,$acum,$tabheight_letter,$tabwidth_letter,0);
		$phpPrinter->printString(utf8_decode('$'),2,$printer,$acum,$tabheight_letter,0,250);
		$phpPrinter->printString(number_format(($dataCorteFiscal['total_ticket_grabado']+$dataCorteFiscal['total_ticket_exento']+$dataCorteFiscal['total_ticket_nosujeto']),2),2,$printer,$acum,$tabheight_letter,0,270);
		
		printer_draw_line($printer, 0, $phpPrinter->getAcum()+$tabwidth_letter, 550, $phpPrinter->getAcum()+$tabwidth_letter);
		$phpPrinter->tabPrinter($acum,5);
		
		/*Propina*/
		$phpPrinter->printString(utf8_decode('Total Propina:'),2,$printer,$acum,$tabheight_letter,$tabwidth_letter,0);
		$phpPrinter->printString(utf8_decode('$'),2,$printer,$acum,$tabheight_letter,0,250);
		$phpPrinter->printString(number_format(($dataCorteFiscal['total_propina']+$dataCorteFiscal['total_propina_pos']),2),2,$printer,$acum,$tabheight_letter,0,270);
		
		printer_draw_line($printer, 0, $phpPrinter->getAcum()+$tabwidth_letter, 550, $phpPrinter->getAcum()+$tabwidth_letter);
		$phpPrinter->tabPrinter($acum,5);
		
		/*Factura*/
		$phpPrinter->printString(utf8_decode('Total Gravadas:'),2,$printer,$acum,$tabheight_letter,$tabwidth_letter,0);
		$phpPrinter->printString(utf8_decode('$'),2,$printer,$acum,$tabheight_letter,0,250);
		$phpPrinter->printString(number_format($dataCorteFiscal['total_factura_grabado'],2),2,$printer,$acum,$tabheight_letter,0,270);
		$phpPrinter->printString(utf8_decode('Total Exentas:'),2,$printer,$acum,$tabheight_letter,$tabwidth_letter,0);
		$phpPrinter->printString(utf8_decode('$'),2,$printer,$acum,$tabheight_letter,0,250);
		$phpPrinter->printString(number_format($dataCorteFiscal['total_factura_exento'],2),2,$printer,$acum,$tabheight_letter,0,270);
		$phpPrinter->printString(utf8_decode('Total No Sujeto:'),2,$printer,$acum,$tabheight_letter,$tabwidth_letter,0);
		$phpPrinter->printString(utf8_decode('$'),2,$printer,$acum,$tabheight_letter,0,250);
		$phpPrinter->printString(number_format($dataCorteFiscal['total_factura_nosujeto'],2),2,$printer,$acum,$tabheight_letter,0,270);
		
		$phpPrinter->printString(utf8_decode('Total Factura:'),2,$printer,$acum,$tabheight_letter,$tabwidth_letter,0);
		$phpPrinter->printString(utf8_decode('$'),2,$printer,$acum,$tabheight_letter,0,250);
		$phpPrinter->printString(number_format(($dataCorteFiscal['total_factura_grabado']+$dataCorteFiscal['total_factura_exento']+$dataCorteFiscal['total_factura_nosujeto']),2),2,$printer,$acum,$tabheight_letter,0,270);
		
		printer_draw_line($printer, 0, $phpPrinter->getAcum()+$tabwidth_letter, 550, $phpPrinter->getAcum()+$tabwidth_letter);
		$phpPrinter->tabPrinter($acum,5);
		
		/*CCF*/
		$phpPrinter->printString(utf8_decode('Total Gravadas:'),2,$printer,$acum,$tabheight_letter,$tabwidth_letter,0);
		$phpPrinter->printString(utf8_decode('$'),2,$printer,$acum,$tabheight_letter,0,250);
		$phpPrinter->printString(number_format($dataCorteFiscal['total_ccf_grabado'],2),2,$printer,$acum,$tabheight_letter,0,270);
		$phpPrinter->printString(utf8_decode('Total Exentas:'),2,$printer,$acum,$tabheight_letter,$tabwidth_letter,0);
		$phpPrinter->printString(utf8_decode('$'),2,$printer,$acum,$tabheight_letter,0,250);
		$phpPrinter->printString(number_format($dataCorteFiscal['total_ccf_exento'],2),2,$printer,$acum,$tabheight_letter,0,270);
		$phpPrinter->printString(utf8_decode('Total No Sujeto:'),2,$printer,$acum,$tabheight_letter,$tabwidth_letter,0);
		$phpPrinter->printString(utf8_decode('$'),2,$printer,$acum,$tabheight_letter,0,250);
		$phpPrinter->printString(number_format($dataCorteFiscal['total_ccf_nosujeto'],2),2,$printer,$acum,$tabheight_letter,0,270);
		
		$phpPrinter->printString(utf8_decode('Total CCF:'),2,$printer,$acum,$tabheight_letter,$tabwidth_letter,0);
		$phpPrinter->printString(utf8_decode('$'),2,$printer,$acum,$tabheight_letter,0,250);
		$phpPrinter->printString(number_format(($dataCorteFiscal['total_ccf_grabado']+$dataCorteFiscal['total_ccf_exento']+$dataCorteFiscal['total_ccf_nosujeto']),2),2,$printer,$acum,$tabheight_letter,0,270);
		
		printer_draw_line($printer, 0, $phpPrinter->getAcum()+$tabwidth_letter, 550, $phpPrinter->getAcum()+$tabwidth_letter);
		$phpPrinter->tabPrinter($acum,5);
		$total_ventas = $dataCorteFiscal['total_propina']+$dataCorteFiscal['total_propina_pos']+$dataCorteFiscal['total_ticket_grabado']+$dataCorteFiscal['total_ticket_exento']+$dataCorteFiscal['total_ticket_nosujeto']+$dataCorteFiscal['total_factura_grabado']+$dataCorteFiscal['total_factura_exento']+$dataCorteFiscal['total_factura_nosujeto']+$dataCorteFiscal['total_ccf_grabado']+$dataCorteFiscal['total_ccf_exento']+$dataCorteFiscal['total_ccf_nosujeto'];
		
		/*Devoluciones*/
		$phpPrinter->printString(utf8_decode('Dev. Tickets:'),2,$printer,$acum,$tabheight_letter,$tabwidth_letter,0);
		$phpPrinter->printString(utf8_decode('$'),2,$printer,$acum,$tabheight_letter,0,250);
		$phpPrinter->printString(number_format($dataCorteFiscal['total_devolucion_ticket'],2),2,$printer,$acum,$tabheight_letter,0,270);
		$phpPrinter->printString(utf8_decode('Anulacion Fac.:'),2,$printer,$acum,$tabheight_letter,$tabwidth_letter,0);
		$phpPrinter->printString(utf8_decode('$'),2,$printer,$acum,$tabheight_letter,0,250);
		$phpPrinter->printString(number_format($dataCorteFiscal['total_devolucion_factura'],2),2,$printer,$acum,$tabheight_letter,0,270);
		$phpPrinter->printString(utf8_decode('Anulacion CCF:'),2,$printer,$acum,$tabheight_letter,$tabwidth_letter,0);
		$phpPrinter->printString(utf8_decode('$'),2,$printer,$acum,$tabheight_letter,0,250);
		$phpPrinter->printString(number_format($dataCorteFiscal['total_devolucion_ccf'],2),2,$printer,$acum,$tabheight_letter,0,270);
		$phpPrinter->printString(utf8_decode('Anulacion N de Cred:'),2,$printer,$acum,$tabheight_letter,$tabwidth_letter,0);
		$phpPrinter->printString(utf8_decode('$'),2,$printer,$acum,$tabheight_letter,0,250);
		$phpPrinter->printString(number_format($dataCorteFiscal['total_devolucion_ncredito'],2),2,$printer,$acum,$tabheight_letter,0,270);
		
		$phpPrinter->printString(utf8_decode('Total Devoluciones:'),2,$printer,$acum,$tabheight_letter,$tabwidth_letter,0);
		$phpPrinter->printString(utf8_decode('$'),2,$printer,$acum,$tabheight_letter,0,250);
		$total_devs = $dataCorteFiscal['total_devolucion_ticket']+$dataCorteFiscal['total_devolucion_factura']+$dataCorteFiscal['total_devolucion_ccf']+$dataCorteFiscal['total_devolucion_ncredito'];
		$phpPrinter->printString("(".number_format($total_devs,2).")",2,$printer,$acum,$tabheight_letter,0,270);
		printer_draw_line($printer, 0, $phpPrinter->getAcum()+$tabwidth_letter, 550, $phpPrinter->getAcum()+$tabwidth_letter);
		$phpPrinter->tabPrinter($acum,5);
		
		/*Total*/
		$phpPrinter->printString(utf8_decode('Total Ventas:'),2,$printer,$acum,$tabheight_letter,$tabwidth_letter,0);
		$phpPrinter->printString(utf8_decode('$'),2,$printer,$acum,$tabheight_letter,0,250);
		$phpPrinter->printString(number_format(($total_ventas - $total_devs),2),2,$printer,$acum,$tabheight_letter,0,270);
		printer_draw_line($printer, 0, $phpPrinter->getAcum()+$tabwidth_letter, 550, $phpPrinter->getAcum()+$tabwidth_letter);
		$phpPrinter->tabPrinter($acum,5);
		
		$phpPrinter->tabPrinter($acum,$tabwidth_letter);
		
		/*Contadores*/
		$phpPrinter->printString(utf8_decode('Trans. Realizadas:'),2,$printer,$acum,$tabheight_letter,$tabwidth_letter,0);
		$trans = $dataCorteFiscal['total_trans_ticket']+$dataCorteFiscal['total_trans_ticket_dev']+$dataCorteFiscal['total_trans_factura']+$dataCorteFiscal['total_trans_ccf'];
		$phpPrinter->printString($trans,2,$printer,$acum,$tabheight_letter,0,270);
		$phpPrinter->printString(utf8_decode('Tickets Emitidos:'),2,$printer,$acum,$tabheight_letter,$tabwidth_letter,0);
		$phpPrinter->printString(($dataCorteFiscal['total_trans_ticket']+$dataCorteFiscal['total_trans_ticket_dev']),2,$printer,$acum,$tabheight_letter,0,270);
		$phpPrinter->printString(utf8_decode('Dev.(Tickets):'),2,$printer,$acum,$tabheight_letter,$tabwidth_letter,0);
		$phpPrinter->printString($dataCorteFiscal['total_trans_ticket_dev'],2,$printer,$acum,$tabheight_letter,0,270);
		$phpPrinter->printString(utf8_decode('Inicio:'),2,$printer,$acum,$tabheight_letter,$tabwidth_letter,0);
		$phpPrinter->printString($dataCorteFiscal['ticketInicio'],2,$printer,$acum,$tabheight_letter,0,270);
		$phpPrinter->printString(utf8_decode('Final:'),2,$printer,$acum,$tabheight_letter,$tabwidth_letter,0);
		$phpPrinter->printString($dataCorteFiscal['ticketFin'],2,$printer,$acum,$tabheight_letter,0,270);
		$phpPrinter->printString(utf8_decode('Facturas Emitidas:'),2,$printer,$acum,$tabheight_letter,$tabwidth_letter,0);
		$phpPrinter->printString($dataCorteFiscal['total_trans_factura'],2,$printer,$acum,$tabheight_letter,0,270);
		$phpPrinter->printString(utf8_decode('CCF Emitidos:'),2,$printer,$acum,$tabheight_letter,$tabwidth_letter,0);
		$phpPrinter->printString($dataCorteFiscal['total_trans_ccf'],2,$printer,$acum,$tabheight_letter,0,270);
		$phpPrinter->tabPrinter($acum,$tabwidth_letter);
		
		/*Cajero y Fecha*/
		$phpPrinter->printString("Cajero: ".$cajero,2,$printer,$acum,$tabheight_letter,$tabwidth_letter,0);
		$phpPrinter->printString($fecha,2,$printer,$acum,$tabheight_letter,$tabwidth_letter,0);
		$phpPrinter->tabPrinter($acum,$tabwidth_letter);
		$phpPrinter->printString($phpPrinter->cutString(utf8_decode('***Operacion Finalizada***'),28),1,$printer,$acum,9,$tabwidth_letter);
		
		printer_delete_font($font);
		
		$font = printer_create_font("Arial", 10, 8, PRINTER_FW_BOLD, false, false, false, 0);
		printer_select_font($printer, $font);
		
		$phpPrinter->printString($phpPrinter->cutString(strtoupper(utf8_decode($nombre_empresa)),28),1,$printer,$acum,8,10);
		
		printer_delete_font($font);
		
		/* $font = printer_create_font("Arial", $tabwidth_letter, $tabheight_letter, PRINTER_FW_MEDIUM, false, false, false, 0);
		printer_select_font($printer, $font);
		
		$phpPrinter->tabPrinter($acum,$tabwidth_letter);
		
		$phpPrinter->printString(utf8_decode('Total Ventas Efectivo:'),2,$printer,$acum,$tabheight_letter,$tabwidth_letter,0);
		$phpPrinter->printString(utf8_decode('$'),2,$printer,$acum,$tabheight_letter,0,250);
		$phpPrinter->printString(number_format($dataCorteFiscal['total_ventas_efectivo']-$dataCorteFiscal['total_propina'],2),2,$printer,$acum,$tabheight_letter,0,270);
		printer_draw_line($printer, 0, $phpPrinter->getAcum()+$tabwidth_letter, 550, $phpPrinter->getAcum()+$tabwidth_letter);
		$phpPrinter->tabPrinter($acum,5);
		
		$phpPrinter->printString(utf8_decode('Total Propina:'),2,$printer,$acum,$tabheight_letter,$tabwidth_letter,0);
		$phpPrinter->printString(utf8_decode('$'),2,$printer,$acum,$tabheight_letter,0,250);
		$phpPrinter->printString(number_format($dataCorteFiscal['total_propina'],2),2,$printer,$acum,$tabheight_letter,0,270);
		printer_draw_line($printer, 0, $phpPrinter->getAcum()+$tabwidth_letter, 550, $phpPrinter->getAcum()+$tabwidth_letter);
		$phpPrinter->tabPrinter($acum,5);
		
		$phpPrinter->printString(utf8_decode('Total Ventas POS:'),2,$printer,$acum,$tabheight_letter,$tabwidth_letter,0);
		$phpPrinter->printString(utf8_decode('$'),2,$printer,$acum,$tabheight_letter,0,250);
		$phpPrinter->printString(number_format($dataCorteFiscal['total_ventas_pos']-$dataCorteFiscal['total_propina_pos'],2),2,$printer,$acum,$tabheight_letter,0,270);
		printer_draw_line($printer, 0, $phpPrinter->getAcum()+$tabwidth_letter, 550, $phpPrinter->getAcum()+$tabwidth_letter);
		$phpPrinter->tabPrinter($acum,5);
		
		$phpPrinter->printString(utf8_decode('Total Propina POS:'),2,$printer,$acum,$tabheight_letter,$tabwidth_letter,0);
		$phpPrinter->printString(utf8_decode('$'),2,$printer,$acum,$tabheight_letter,0,250);
		$phpPrinter->printString(number_format($dataCorteFiscal['total_propina_pos'],2),2,$printer,$acum,$tabheight_letter,0,270);
		printer_draw_line($printer, 0, $phpPrinter->getAcum()+$tabwidth_letter, 550, $phpPrinter->getAcum()+$tabwidth_letter);
		$phpPrinter->tabPrinter($acum,5);
		
		$total_ventas=$dataCorteFiscal['total_ventas_pos']+$dataCorteFiscal['total_ventas_efectivo'];
		
		$phpPrinter->printString(utf8_decode('Total Devoluciones:'),2,$printer,$acum,$tabheight_letter,$tabwidth_letter,0);
		$phpPrinter->printString(utf8_decode('$'),2,$printer,$acum,$tabheight_letter,0,250);
		$total_devs = $dataCorteFiscal['total_devolucion_ticket']+$dataCorteFiscal['total_devolucion_factura']+$dataCorteFiscal['total_devolucion_ccf']+$dataCorteFiscal['total_devolucion_ncredito'];
		$phpPrinter->printString("(".number_format($total_devs,2).")",2,$printer,$acum,$tabheight_letter,0,270);
		printer_draw_line($printer, 0, $phpPrinter->getAcum()+$tabwidth_letter, 550, $phpPrinter->getAcum()+$tabwidth_letter);
		$phpPrinter->tabPrinter($acum,5);
		
		$phpPrinter->printString(utf8_decode('Total Ventas:'),2,$printer,$acum,$tabheight_letter,$tabwidth_letter,0);
		$phpPrinter->printString(utf8_decode('$'),2,$printer,$acum,$tabheight_letter,0,250);
		$phpPrinter->printString(number_format(($total_ventas - $total_devs),2),2,$printer,$acum,$tabheight_letter,0,270);
		printer_draw_line($printer, 0, $phpPrinter->getAcum()+$tabwidth_letter, 550, $phpPrinter->getAcum()+$tabwidth_letter);
		$phpPrinter->tabPrinter($acum,5);
		
		$phpPrinter->printString(utf8_decode('Dotacion:'),2,$printer,$acum,$tabheight_letter,$tabwidth_letter,0);
		$phpPrinter->printString(utf8_decode('$'),2,$printer,$acum,$tabheight_letter,0,250);
		$phpPrinter->printString(number_format($dotacion,2),2,$printer,$acum,$tabheight_letter,0,270);
		printer_draw_line($printer, 0, $phpPrinter->getAcum()+$tabwidth_letter, 550, $phpPrinter->getAcum()+$tabwidth_letter);
		$phpPrinter->tabPrinter($acum,5);
		
		$phpPrinter->printString(utf8_decode('Total Efectivo:'),2,$printer,$acum,$tabheight_letter,$tabwidth_letter,0);
		$phpPrinter->printString(utf8_decode('$'),2,$printer,$acum,$tabheight_letter,0,250);
		$phpPrinter->printString(number_format((($dataCorteFiscal['total_ventas_efectivo'] + $dataCorteFiscal['total_propina'] + $dotacion) - $total_devs),2),2,$printer,$acum,$tabheight_letter,0,270);
		printer_draw_line($printer, 0, $phpPrinter->getAcum()+$tabwidth_letter, 550, $phpPrinter->getAcum()+$tabwidth_letter);
		$phpPrinter->tabPrinter($acum,5);
		
		printer_delete_font($font); */
		
		printer_end_page($printer);

		printer_end_doc($printer);	

		printer_close($printer);
		
		if($tipo==1 || $tipo==2):
		//if($tipo==66):
			/*Anexo*/
			$phpPrinter->resetAcum();
			
			$printer = printer_open("EPSON TM-U950 Receipt");

			printer_set_option($printer, PRINTER_MODE, 'RAW');
			
			printer_start_doc($printer, 'Corte Numero: '.$numero_corte);

			printer_start_page($printer);
			
			/*Body*/
			$width_letter=9;
			$height_letter=7;
			
			$tabwidth_letter=10;
			$tabheight_letter=10;
			
			$font = printer_create_font("Arial", 10, 8, PRINTER_FW_BOLD, false, false, false, 0);
			printer_select_font($printer, $font);
			
			$phpPrinter->printString($phpPrinter->cutString(strtoupper(utf8_decode($nombre_empresa)),28),1,$printer,$acum,8,10);
			
			printer_delete_font($font);
			
			$font = printer_create_font("Arial", $tabwidth_letter, $tabheight_letter, PRINTER_FW_MEDIUM, false, false, false, 0);
			printer_select_font($printer, $font);
			
			$phpPrinter->tabPrinter($acum,$tabwidth_letter);
			
			/***/
			$phpPrinter->printString(utf8_decode('Total V Efectivo:'),2,$printer,$acum,$tabheight_letter,$tabwidth_letter,0);
			$phpPrinter->printString(utf8_decode('$'),2,$printer,$acum,$tabheight_letter,0,250);
			$phpPrinter->printString(number_format($dataCorteFiscal['total_ventas_efectivo']-($dataCorteFiscal['total_propina']+$dataCorteFiscal['total_hugo']),2),2,$printer,$acum,$tabheight_letter,0,270);
			printer_draw_line($printer, 0, $phpPrinter->getAcum()+$tabwidth_letter, 550, $phpPrinter->getAcum()+$tabwidth_letter);
			$phpPrinter->tabPrinter($acum,5);

			$phpPrinter->printString(utf8_decode('Total V Efectivo CC:'),2,$printer,$acum,$tabheight_letter,$tabwidth_letter,0);
			$phpPrinter->printString(utf8_decode('$'),2,$printer,$acum,$tabheight_letter,0,250);
			$phpPrinter->printString(number_format($dataCorteFiscal['total_ventas_efectivo_cc'],2),2,$printer,$acum,$tabheight_letter,0,270);
			printer_draw_line($printer, 0, $phpPrinter->getAcum()+$tabwidth_letter, 550, $phpPrinter->getAcum()+$tabwidth_letter);
			$phpPrinter->tabPrinter($acum,5);
			
			$phpPrinter->printString(utf8_decode('Total Ventas Hugo:'),2,$printer,$acum,$tabheight_letter,$tabwidth_letter,0);
			$phpPrinter->printString(utf8_decode('$'),2,$printer,$acum,$tabheight_letter,0,250);
			$phpPrinter->printString(number_format($dataCorteFiscal['total_hugo'],2),2,$printer,$acum,$tabheight_letter,0,270);
			printer_draw_line($printer, 0, $phpPrinter->getAcum()+$tabwidth_letter, 550, $phpPrinter->getAcum()+$tabwidth_letter);
			$phpPrinter->tabPrinter($acum,5);
			
			$phpPrinter->printString(utf8_decode('Total Propina:'),2,$printer,$acum,$tabheight_letter,$tabwidth_letter,0);
			$phpPrinter->printString(utf8_decode('$'),2,$printer,$acum,$tabheight_letter,0,250);
			$phpPrinter->printString(number_format($dataCorteFiscal['total_propina'],2),2,$printer,$acum,$tabheight_letter,0,270);
			printer_draw_line($printer, 0, $phpPrinter->getAcum()+$tabwidth_letter, 550, $phpPrinter->getAcum()+$tabwidth_letter);
			$phpPrinter->tabPrinter($acum,5);
			
			$phpPrinter->printString(utf8_decode('Total Ventas POS:'),2,$printer,$acum,$tabheight_letter,$tabwidth_letter,0);
			$phpPrinter->printString(utf8_decode('$'),2,$printer,$acum,$tabheight_letter,0,250);
			$phpPrinter->printString(number_format($dataCorteFiscal['total_ventas_pos']-$dataCorteFiscal['total_propina_pos'],2),2,$printer,$acum,$tabheight_letter,0,270);
			printer_draw_line($printer, 0, $phpPrinter->getAcum()+$tabwidth_letter, 550, $phpPrinter->getAcum()+$tabwidth_letter);
			$phpPrinter->tabPrinter($acum,5);

			$phpPrinter->printString(utf8_decode('Total Ventas POS CC:'),2,$printer,$acum,$tabheight_letter,$tabwidth_letter,0);
			$phpPrinter->printString(utf8_decode('$'),2,$printer,$acum,$tabheight_letter,0,250);
			$phpPrinter->printString(number_format($dataCorteFiscal['total_ventas_pos_cc'],2),2,$printer,$acum,$tabheight_letter,0,270);
			printer_draw_line($printer, 0, $phpPrinter->getAcum()+$tabwidth_letter, 550, $phpPrinter->getAcum()+$tabwidth_letter);
			$phpPrinter->tabPrinter($acum,5);
			
			$phpPrinter->printString(utf8_decode('Total Propina POS:'),2,$printer,$acum,$tabheight_letter,$tabwidth_letter,0);
			$phpPrinter->printString(utf8_decode('$'),2,$printer,$acum,$tabheight_letter,0,250);
			$phpPrinter->printString(number_format($dataCorteFiscal['total_propina_pos'],2),2,$printer,$acum,$tabheight_letter,0,270);
			printer_draw_line($printer, 0, $phpPrinter->getAcum()+$tabwidth_letter, 550, $phpPrinter->getAcum()+$tabwidth_letter);
			$phpPrinter->tabPrinter($acum,5);
			
			$total_ventas=$dataCorteFiscal['total_ventas_pos']+$dataCorteFiscal['total_ventas_efectivo']+$dataCorteFiscal['total_ventas_efectivo_cc'];
			
			$phpPrinter->printString(utf8_decode('Total Devoluciones:'),2,$printer,$acum,$tabheight_letter,$tabwidth_letter,0);
			$phpPrinter->printString(utf8_decode('$'),2,$printer,$acum,$tabheight_letter,0,250);
			$total_devs = $dataCorteFiscal['total_devolucion_ticket']+$dataCorteFiscal['total_devolucion_factura']+$dataCorteFiscal['total_devolucion_ccf']+$dataCorteFiscal['total_devolucion_ncredito'];
			$phpPrinter->printString("(".number_format($total_devs,2).")",2,$printer,$acum,$tabheight_letter,0,270);
			printer_draw_line($printer, 0, $phpPrinter->getAcum()+$tabwidth_letter, 550, $phpPrinter->getAcum()+$tabwidth_letter);
			$phpPrinter->tabPrinter($acum,5);
			
			/*Total*/
			$phpPrinter->printString(utf8_decode('Total Ventas:'),2,$printer,$acum,$tabheight_letter,$tabwidth_letter,0);
			$phpPrinter->printString(utf8_decode('$'),2,$printer,$acum,$tabheight_letter,0,250);
			$phpPrinter->printString(number_format(($total_ventas - $total_devs),2),2,$printer,$acum,$tabheight_letter,0,270);
			printer_draw_line($printer, 0, $phpPrinter->getAcum()+$tabwidth_letter, 550, $phpPrinter->getAcum()+$tabwidth_letter);
			$phpPrinter->tabPrinter($acum,5);
			
			$phpPrinter->printString(utf8_decode('Dotacion:'),2,$printer,$acum,$tabheight_letter,$tabwidth_letter,0);
			$phpPrinter->printString(utf8_decode('$'),2,$printer,$acum,$tabheight_letter,0,250);
			$phpPrinter->printString(number_format($dotacion,2),2,$printer,$acum,$tabheight_letter,0,270);
			printer_draw_line($printer, 0, $phpPrinter->getAcum()+$tabwidth_letter, 550, $phpPrinter->getAcum()+$tabwidth_letter);
			$phpPrinter->tabPrinter($acum,5);
			
			$phpPrinter->printString(utf8_decode('Total Efectivo:'),2,$printer,$acum,$tabheight_letter,$tabwidth_letter,0);
			$phpPrinter->printString(utf8_decode('$'),2,$printer,$acum,$tabheight_letter,0,250);
			$phpPrinter->printString(number_format((($dataCorteFiscal['total_ventas_efectivo'] + $dotacion + $dataCorteFiscal['total_ventas_efectivo_cc']) - ($total_devs- $dataCorteFiscal['total_hugo'])),2),2,$printer,$acum,$tabheight_letter,0,270);
			printer_draw_line($printer, 0, $phpPrinter->getAcum()+$tabwidth_letter, 550, $phpPrinter->getAcum()+$tabwidth_letter);
			$phpPrinter->tabPrinter($acum,5);
			
			printer_delete_font($font);
			
			printer_end_page($printer);

			printer_end_doc($printer);	

			printer_close($printer);
		
			/*Consumo*/
			$phpPrinter->resetAcum();
			
			$printer = printer_open("EPSON TM-U950 Receipt");

			printer_set_option($printer, PRINTER_MODE, 'RAW');
			
			printer_start_doc($printer, 'Consumo');

			printer_start_page($printer);
			
			/*Body*/
			$width_letter=9;
			$height_letter=7;
			
			$font = printer_create_font("Arial", 10, 8, PRINTER_FW_BOLD, false, false, false, 0);
			printer_select_font($printer, $font);
			
			$phpPrinter->printString($phpPrinter->cutString(strtoupper(utf8_decode("Prestacion Alimenticia China In")),28),1,$printer,$acum,8,10);
			
			printer_delete_font($font);
			
			$font = printer_create_font("Arial", $width_letter, $height_letter, PRINTER_FW_MEDIUM, false, false, false, 0);
			printer_select_font($printer, $font);
			
			$phpPrinter->tabPrinter($acum,$width_letter);
			
			/***/
			$consumos = explode('|',$dataCorteConsumo);

			foreach($consumos as $consumo) {    
				if($consumo!=""){
					$phpPrinter->printString(utf8_decode($consumo),2,$printer,$acum,$height_letter,$width_letter,0);
				}
			}
			
			$phpPrinter->tabPrinter($acum,$width_letter);
			
			$phpPrinter->printString($fecha,2,$printer,$acum,$height_letter,$width_letter,0);
			
			printer_delete_font($font);
			
			printer_end_page($printer);

			printer_end_doc($printer);	

			printer_close($printer);
		endif;
	endif;
?>