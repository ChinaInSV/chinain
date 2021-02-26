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
	$printer = printer_open("EPSON TM-U950 Receipt");

	printer_set_option($printer, PRINTER_MODE, 'RAW');

	printer_start_doc($printer, 'Recibo');

	printer_start_page($printer);
	
	/*Body*/
	
	$font = printer_create_font('Arial', 10, 8, PRINTER_FW_BOLD, false, false, false, 0);	
	printer_select_font($printer, $font);
	
	$phpPrinter->printString($phpPrinter->cutString(strtoupper(utf8_decode($nombre_empresa)),28),1,$printer,$acum,18,32);
	
	printer_delete_font($font);
	
	$font = printer_create_font('Arial', $width_letter, $height_letter, PRINTER_FW_MEDIUM, false, false, false, 0);	
	printer_select_font($printer, $font);
	
	$phpPrinter->tabPrinter($acum,$tabwidth_letter);
	
	$phpPrinter->printString($phpPrinter->cutString(utf8_decode('PRESTACION ALIMENTICIA'),28),1,$printer,$acum,$tabheight_letter,$tabwidth_letter);
	$phpPrinter->printString($phpPrinter->cutString(strtoupper(utf8_decode('Caja: '.$caja)),28),1,$printer,$acum,$tabheight_letter,$tabwidth_letter);
	$phpPrinter->printString($phpPrinter->cutString(strtoupper(utf8_decode('Vendedor: '.$vendedor)),28),1,$printer,$acum,$tabheight_letter,$tabwidth_letter);
	
	$phpPrinter->tabPrinter($acum,$tabwidth_letter);
	
	$phpPrinter->printString(strtoupper(utf8_decode('fecha: ')),2,$printer,$acum,$tabheight_letter,$tabwidth_letter,0);
	$phpPrinter->printString(strtoupper(utf8_decode($fecha)),2,$printer,$acum,$tabheight_letter,0,100);
	
	$phpPrinter->tabPrinter($acum,$tabwidth_letter);
	
	$phpPrinter->printString(strtoupper(utf8_decode('Cant')),2,$printer,$acum,$tabheight_letter,$tabwidth_letter,0);
	$phpPrinter->printString(strtoupper(utf8_decode('Desc')),2,$printer,$acum,$tabheight_letter,0,130);
	$phpPrinter->tabPrinter($acum,$tabwidth_letter);
	$phpPrinter->printString("- - - - - - - - - - - - - - - - - - - - - - - - - - -",2,$printer,$acum,$tabheight_letter,$tabwidth_letter,0);
	$phpPrinter->tabPrinter($acum,$tabwidth_letter);
	
	foreach($productos_normal as $producto){
		$phpPrinter->printString($producto->cant,2,$printer,$acum,$tabheight_letter,$tabwidth_letter,0);
		$phpPrinter->printString($phpPrinter->cutString(strtoupper(utf8_decode(addslashes($producto->desc))),20),2,$printer,$acum,$tabheight_letter,0,50,$tabwidth_letter);
		$phpPrinter->tabPrinter($acum,3);
	}
	$phpPrinter->printString("______________________________",2,$printer,$acum,$tabheight_letter,$tabwidth_letter,0);
	$phpPrinter->tabPrinter($acum,$tabwidth_letter);
	
	$phpPrinter->printString(strtoupper(utf8_decode('CONSUMO')),2,$printer,$acum,$tabheight_letter,$tabwidth_letter,10);
	$phpPrinter->printString("$",2,$printer,$acum,$tabheight_letter,0,435);
	$phpPrinter->printString(number_format($totales['totalTotal'],2),2,$printer,$acum,$tabheight_letter,0,460);
	
	$phpPrinter->tabPrinter($acum,$tabwidth_letter);
	
	$phpPrinter->printString($phpPrinter->cutString(strtoupper(utf8_decode('F:__________________________')),28),1,$printer,$acum,$tabheight_letter,$tabwidth_letter);
	$phpPrinter->printString($phpPrinter->cutString(strtoupper(utf8_decode($empleado)),28),1,$printer,$acum,$tabheight_letter,$tabwidth_letter);
	
	$phpPrinter->tabPrinter($acum,$tabwidth_letter);
	
	$phpPrinter->printString($phpPrinter->cutString(strtoupper(utf8_decode("Ref:".$referencia)),28),1,$printer,$acum,$tabheight_letter,$tabwidth_letter);
	
	printer_delete_font($font);
	
	printer_end_page($printer);

	printer_end_doc($printer);

	printer_close($printer);
?>