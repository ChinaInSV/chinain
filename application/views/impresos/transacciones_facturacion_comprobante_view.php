<?php
	$this->load->library('printer');
	$this->load->library('enletras');
	
	$phpPrinter = new Printer();
	$phpInletters = new EnLetras();
	
	$phpPrinter->resetAcum();
	$acum = 0;
	
	$width_letter=9;
	$height_letter=7;
	
	$tabwidth_letter=10;
	$tabheight_letter=10;
	
	/*Init*/
	switch($copias):
		case "0":
			$printer = printer_open("EPSON TM-U950 Receipt Single");
		break;
		case "1":
			$printer = printer_open("EPSON21B62E (L555 Series)");
		break;
		case "2":
			$printer = printer_open("EPSON21B62E (L555 Series)");
		break;
	endswitch;

	printer_set_option($printer, PRINTER_MODE, 'RAW');

	printer_start_doc($printer, 'Ticket Numero: '.$doc_numero);

	printer_start_page($printer);
	
	/*Body*/
	
	$font = printer_create_font('Arial', 10, 8, PRINTER_FW_BOLD, false, false, false, 0);	
	printer_select_font($printer, $font);
	
	printer_draw_bmp($printer, "C:\\logo.bmp", 20, 1,300,180);
	$phpPrinter->tabPrinter($acum,160);
	
	$phpPrinter->printString($phpPrinter->cutString(strtoupper(utf8_decode($nombre_empresa)),25),1,$printer,$acum,8,10);
	
	printer_delete_font($font);
	
	$font = printer_create_font('Arial', $width_letter, $height_letter, PRINTER_FW_MEDIUM, false, false, false, 0);	
	printer_select_font($printer, $font);
	
	$phpPrinter->tabPrinter($acum,$tabwidth_letter);
	
	$phpPrinter->printString($phpPrinter->cutString(strtoupper(utf8_decode($rsocial_empresa)),28),1,$printer,$acum,$tabheight_letter,$tabwidth_letter);
	$phpPrinter->printString($phpPrinter->cutString(strtoupper(utf8_decode($direcion_empresa)),28),1,$printer,$acum,$tabheight_letter,$tabwidth_letter);
	//$phpPrinter->printString($phpPrinter->cutString(strtoupper(utf8_decode('NRC: '.$nrc_empresa)),28),1,$printer,$acum,$tabheight_letter,$tabwidth_letter);
	//$phpPrinter->printString($phpPrinter->cutString(strtoupper(utf8_decode('NIT: '.$nit_empresa)),28),1,$printer,$acum,$tabheight_letter,$tabwidth_letter);
	//$phpPrinter->printString($phpPrinter->cutString(strtoupper(utf8_decode('Autorizacion segun Resolucion')),28),1,$printer,$acum,$tabheight_letter,$tabwidth_letter);
	//$phpPrinter->printString($phpPrinter->cutString(strtoupper(utf8_decode('No '.$doc_resolucion)),28),1,$printer,$acum,$tabheight_letter,$tabwidth_letter);
	//$phpPrinter->printString($phpPrinter->cutString(strtoupper(utf8_decode('Del '.$doc_desde)),28),1,$printer,$acum,$tabheight_letter,$tabwidth_letter);
	//$phpPrinter->printString($phpPrinter->cutString(strtoupper(utf8_decode('Al '.$doc_hasta)),28),1,$printer,$acum,$tabheight_letter,$tabwidth_letter);
	$phpPrinter->printString($phpPrinter->cutString(utf8_decode('Comprobante de Pago '.$doc_numero),28),1,$printer,$acum,$tabheight_letter,$tabwidth_letter);
	$phpPrinter->printString($phpPrinter->cutString(strtoupper(utf8_decode('Caja: '.$caja)),28),1,$printer,$acum,$tabheight_letter,$tabwidth_letter);
	$phpPrinter->printString($phpPrinter->cutString(strtoupper(utf8_decode('Vendedor: '.$vendedor)),28),1,$printer,$acum,$tabheight_letter,$tabwidth_letter);
	
	$phpPrinter->tabPrinter($acum,$tabwidth_letter);
	
	$phpPrinter->printString(strtoupper(utf8_decode('fecha: ')),2,$printer,$acum,$tabheight_letter,$tabwidth_letter,0);
	$phpPrinter->printString(strtoupper(utf8_decode($fecha)),2,$printer,$acum,$tabheight_letter,0,100);
	
	$phpPrinter->tabPrinter($acum,$tabwidth_letter);
	
	$phpPrinter->printString(strtoupper(utf8_decode('Cant')),2,$printer,$acum,$tabheight_letter,$tabwidth_letter,0);
	$phpPrinter->printString(strtoupper(utf8_decode('Desc')),2,$printer,$acum,$tabheight_letter,0,70);
	$phpPrinter->printString(strtoupper(utf8_decode('P/U')),2,$printer,$acum,$tabheight_letter,0,200);
	$phpPrinter->printString(strtoupper(utf8_decode('Total')),2,$printer,$acum,$tabheight_letter,0,270);
	$phpPrinter->tabPrinter($acum,$tabwidth_letter);
	$phpPrinter->printString("- - - - - - - - - - - - - - - - - - - - - - - - - - -",2,$printer,$acum,$tabheight_letter,$tabwidth_letter,0);
	$phpPrinter->tabPrinter($acum,$tabwidth_letter);
	
	foreach($productos_normal as $producto){
		$phpPrinter->printString($producto->cant,2,$printer,$acum,$tabheight_letter,$tabwidth_letter,0);
		$phpPrinter->printString($phpPrinter->cutString(strtoupper(utf8_decode(addslashes($producto->desc))),10),2,$printer,$acum,$tabheight_letter,0,45,$tabwidth_letter);
		$phpPrinter->printString(number_format($producto->costo,2),2,$printer,$acum,$tabheight_letter,0,200);
		$phpPrinter->printString(number_format($producto->cant * $producto->costo,2),2,$printer,$acum,$tabheight_letter,0,270);
		$phpPrinter->printString("G",2,$printer,$acum,$tabheight_letter,0,520);
		$phpPrinter->tabPrinter($acum,3);
	}
	$phpPrinter->printString("______________________________",2,$printer,$acum,$tabheight_letter,$tabwidth_letter,0);
	$phpPrinter->printString("G=Gravado E=Exento NS=No Sujeto",2,$printer,$acum,$tabheight_letter,$tabwidth_letter,0);
	$phpPrinter->tabPrinter($acum,$tabwidth_letter);
	
	$phpPrinter->printString(strtoupper(utf8_decode('TOTAL GRAVADO')),2,$printer,$acum,$tabheight_letter,$tabwidth_letter,10);
	$phpPrinter->printString("$",2,$printer,$acum,$tabheight_letter,0,250);
	$phpPrinter->printString(number_format($totales['totalGrabadas'],2),2,$printer,$acum,$tabheight_letter,0,270);
	
	$phpPrinter->printString(strtoupper(utf8_decode('TOTAL EXENTO')),2,$printer,$acum,$tabheight_letter,$tabwidth_letter,10);
	$phpPrinter->printString("$",2,$printer,$acum,$tabheight_letter,0,250);
	$phpPrinter->printString(number_format($totales['totalExento'],2),2,$printer,$acum,$tabheight_letter,0,270);
	
	$phpPrinter->printString(strtoupper(utf8_decode('TOTAL NO SUJETO')),2,$printer,$acum,$tabheight_letter,$tabwidth_letter,10);
	$phpPrinter->printString("$",2,$printer,$acum,$tabheight_letter,0,250);
	$phpPrinter->printString(number_format($totales['totalNS'],2),2,$printer,$acum,$tabheight_letter,0,270);
	
	$phpPrinter->printString(strtoupper(utf8_decode('PROPINA 10%')),2,$printer,$acum,$tabheight_letter,$tabwidth_letter,10);
	$phpPrinter->printString("$",2,$printer,$acum,$tabheight_letter,0,250);
	$phpPrinter->printString(number_format($totales['propina'],2),2,$printer,$acum,$tabheight_letter,0,270);
	
	$phpPrinter->printString(strtoupper(utf8_decode('DESCUENTO')),2,$printer,$acum,$tabheight_letter,$tabwidth_letter,10);
	$phpPrinter->printString("$",2,$printer,$acum,$tabheight_letter,0,250);
	$phpPrinter->printString(number_format($totales['descuento'],2),2,$printer,$acum,$tabheight_letter,0,270);
	
	$phpPrinter->printString(strtoupper(utf8_decode('TOTAL')),2,$printer,$acum,$tabheight_letter,$tabwidth_letter,10);
	$phpPrinter->printString("$",2,$printer,$acum,$tabheight_letter,0,250);
	$phpPrinter->printString(number_format($totales['totalTotal'] - $totales['descuento'],2),2,$printer,$acum,$tabheight_letter,0,270);
	
	$phpPrinter->printString(strtoupper(utf8_decode('POS')),2,$printer,$acum,$tabheight_letter,$tabwidth_letter,10);
	$phpPrinter->printString("$",2,$printer,$acum,$tabheight_letter,0,250);
	$phpPrinter->printString(number_format($pos,2),2,$printer,$acum,$tabheight_letter,0,270);
	
	$phpPrinter->printString(strtoupper(utf8_decode('EFECTIVO')),2,$printer,$acum,$tabheight_letter,$tabwidth_letter,10);
	$phpPrinter->printString("$",2,$printer,$acum,$tabheight_letter,0,250);
	$phpPrinter->printString(number_format($efectivo,2),2,$printer,$acum,$tabheight_letter,0,270);
	
	$phpPrinter->printString(strtoupper(utf8_decode('CAMBIO')),2,$printer,$acum,$tabheight_letter,$tabwidth_letter,10);
	$phpPrinter->printString("$",2,$printer,$acum,$tabheight_letter,0,250);
	$phpPrinter->printString(number_format($cambio,2),2,$printer,$acum,$tabheight_letter,0,270);
	
	$phpPrinter->tabPrinter($acum,$tabwidth_letter);
	
	$phpPrinter->printString($phpPrinter->cutString(strtoupper(utf8_decode('F:__________________________')),28),1,$printer,$acum,$tabheight_letter,$tabwidth_letter);
	$phpPrinter->printString($phpPrinter->cutString(strtoupper(utf8_decode($cliente)),28),1,$printer,$acum,$tabheight_letter,$tabwidth_letter);

	if($dui_cliente!=""):
	$phpPrinter->printString($phpPrinter->cutString(strtoupper(utf8_decode('DUI: '.$dui_cliente)),28),1,$printer,$acum,$tabheight_letter,$tabwidth_letter);
	endif;
	if($nit_cliente!=""):
	$phpPrinter->printString($phpPrinter->cutString(strtoupper(utf8_decode('NIT: '.$nit_cliente)),28),1,$printer,$acum,$tabheight_letter,$tabwidth_letter);
	endif;
	if($nrc_cliente!=""):
	$phpPrinter->printString($phpPrinter->cutString(strtoupper(utf8_decode('NRC: '.$nrc_cliente)),28),1,$printer,$acum,$tabheight_letter,$tabwidth_letter);
	endif;
	$phpPrinter->tabPrinter($acum,$tabwidth_letter);
	
	$phpPrinter->printString(strtoupper(utf8_decode($servicio)),2,$printer,$acum,$height_letter,0,100);
	
	$phpPrinter->tabPrinter($acum,$width_letter);
	
	$phpPrinter->printString($phpPrinter->cutString(strtoupper(utf8_decode($mensaje_ticket)),28),1,$printer,$acum,$tabheight_letter,$tabwidth_letter);
	$phpPrinter->printString($phpPrinter->cutString(strtoupper(utf8_decode("Ref:".$referencia)),28),1,$printer,$acum,$tabheight_letter,$tabwidth_letter);
	
	printer_delete_font($font);
	
	printer_end_page($printer);

	printer_end_doc($printer);

	printer_close($printer);
	
	
?>