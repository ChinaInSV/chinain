<?php
	$this->load->library('printer');
	
	$phpPrinter = new Printer();
	
	$acum = 0;
	
	/*Init*/
	$printer = printer_open('POS-80C');

	printer_set_option($printer, PRINTER_MODE, 'RAW');

	printer_start_doc($printer, 'Orden Numero: '.$numero_orden);

	printer_start_page($printer);
	
	/*Body*/
	
	$font = printer_create_font('Arial', 20, 11, PRINTER_FW_THIN, false, false, false, 0);	
	printer_select_font($printer, $font);
	
	/*Comprobante*/
	$phpPrinter->printString($phpPrinter->cutString(strtoupper(utf8_decode('Orden:')),24),1,$printer,$acum,11,20);
	$phpPrinter->printString($phpPrinter->cutString(strtoupper(utf8_decode('Numero: '.$numero_orden)),24),1,$printer,$acum,9,20);
	$phpPrinter->printString($phpPrinter->cutString(strtoupper(utf8_decode('ID: '.$id_orden)),24),1,$printer,$acum,9,20);
	$phpPrinter->tabPrinter($acum,20);
	
	$phpPrinter->printString(strtoupper(utf8_decode('fecha: ')),2,$printer,$acum,11,20,15);
	$phpPrinter->printString(strtoupper(utf8_decode($fecha)),2,$printer,$acum,11,0,140);
	$phpPrinter->tabPrinter($acum,20);
	
	/*Descripcion de Servicios*/
	$phpPrinter->printString(strtoupper(utf8_decode('cant')),2,$printer,$acum,11,20,15);
	$phpPrinter->printString(strtoupper(utf8_decode('descripcion')),2,$printer,$acum,11,0,180);
	$phpPrinter->tabPrinter($acum,20);
	
	foreach($platos as $plato):
		$phpPrinter->printString($phpPrinter->cutString(strtoupper(utf8_decode($plato["cant"])),18),2,$printer,$acum,11,20);	
		if($plato["acompanamientos"]!=""):
		$phpPrinter->printString($phpPrinter->cutString(strtoupper(utf8_decode($plato["plato"]." con ".$plato["acompanamientos"])),18),2,$printer,$acum,11,0,100,20);
		else:
		$phpPrinter->printString($phpPrinter->cutString(strtoupper(utf8_decode($plato["plato"])),18),2,$printer,$acum,11,0,100,20);
		endif;
		if($plato["notas"]!=""):
		$phpPrinter->printString($phpPrinter->cutString(strtoupper(utf8_decode("Notas: ".$plato["notas"])),36),2,$printer,$acum,11,20,20);
		endif;
		if($plato["division"]):
		$phpPrinter->printString($phpPrinter->cutString(strtoupper(utf8_decode("______________________________")),36),2,$printer,$acum,11,20,20);
		endif;
		$phpPrinter->tabPrinter($acum,20);	
	endforeach;	
	
	/*Datos*/
	$phpPrinter->printString(strtoupper(utf8_decode('Servicio: ')),2,$printer,$acum,11,20,15);
	$phpPrinter->printString($phpPrinter->cutString(strtoupper(utf8_decode($servicio)),16),2,$printer,$acum,11,0,140);
	
	$phpPrinter->printString(strtoupper(utf8_decode('Cliente: ')),2,$printer,$acum,11,20,15);
	$phpPrinter->printString($phpPrinter->cutString(strtoupper(utf8_decode($cliente)),16),2,$printer,$acum,11,0,140);
	
	$phpPrinter->printString(strtoupper(utf8_decode('Mesero: ')),2,$printer,$acum,11,20,15);
	$phpPrinter->printString($phpPrinter->cutString(strtoupper(utf8_decode($mesero)),16),2,$printer,$acum,11,0,140);
	
	$phpPrinter->printString(strtoupper(utf8_decode('Destino: ')),2,$printer,$acum,11,20,15);
	$phpPrinter->printString($phpPrinter->cutString(strtoupper(utf8_decode($mesa)),16),2,$printer,$acum,11,0,140);
	
	printer_delete_font($font);
	/*End*/
	printer_end_page($printer);

	printer_end_doc($printer);

	printer_close($printer);
?>