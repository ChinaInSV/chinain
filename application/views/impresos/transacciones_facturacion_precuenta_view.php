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
	
	$printer = printer_open("EPSON TM-U950 Receipt Single");

	printer_set_option($printer, PRINTER_MODE, 'RAW');

	printer_start_doc($printer, 'Precuenta');

	printer_start_page($printer);
	
	/*Body*/
	
	$font = printer_create_font('Arial', 10, 8, PRINTER_FW_BOLD, false, false, false, 0);	
	printer_select_font($printer, $font);
	
	printer_draw_bmp($printer, "C:\\logo.bmp", 20, 1,300,80);
	$phpPrinter->tabPrinter($acum,80);
	
	$phpPrinter->printString($phpPrinter->cutString(strtoupper(utf8_decode($nombre_empresa)),25),1,$printer,$acum,8,10);
	
	printer_delete_font($font);
	
	$font = printer_create_font('Arial', $width_letter, $height_letter, PRINTER_FW_MEDIUM, false, false, false, 0);	
	printer_select_font($printer, $font);
	
	$phpPrinter->tabPrinter($acum,$tabwidth_letter);
	
	/*********/
	
	$phpPrinter->printString($phpPrinter->cutString(utf8_decode("Estado de Cuentas"),28),1,$printer,$acum,$tabheight_letter,$tabwidth_letter);
	
	$phpPrinter->tabPrinter($acum,$tabwidth_letter);
	
	$phpPrinter->printString(strtoupper(utf8_decode('fecha: ')),2,$printer,$acum,$tabheight_letter,$tabwidth_letter,0);
	$phpPrinter->printString(strtoupper(utf8_decode(date("d-m-Y h:i a",strtotime($orden->fecha)))),2,$printer,$acum,$tabheight_letter,0,100);
	
	$phpPrinter->tabPrinter($acum,$tabwidth_letter);
	
	$phpPrinter->printString(strtoupper(utf8_decode('Cant')),2,$printer,$acum,$tabheight_letter,$tabwidth_letter,0);
	$phpPrinter->printString(strtoupper(utf8_decode('Desc')),2,$printer,$acum,$tabheight_letter,0,70);
	$phpPrinter->printString(strtoupper(utf8_decode('P/U')),2,$printer,$acum,$tabheight_letter,0,200);
	$phpPrinter->printString(strtoupper(utf8_decode('Total')),2,$printer,$acum,$tabheight_letter,0,270);
	$phpPrinter->tabPrinter($acum,$tabwidth_letter);
	$phpPrinter->printString("- - - - - - - - - - - - - - - - - - - - - - - - - - -",2,$printer,$acum,$tabheight_letter,$tabwidth_letter,0);
	$phpPrinter->tabPrinter($acum,$tabwidth_letter);
	
	foreach($platos as $plato):
		$phpPrinter->printString(number_format($plato->cant,$config->cant_decimal_precision->value),2,$printer,$acum,$tabheight_letter,$tabwidth_letter,0);
		$phpPrinter->printString($phpPrinter->cutString(strtoupper(utf8_decode(addslashes($plato->nombre))),10),2,$printer,$acum,$tabheight_letter,0,45,$tabwidth_letter);
		$phpPrinter->printString(number_format($plato->precio,2),2,$printer,$acum,$tabheight_letter,0,200);
		$phpPrinter->printString(number_format($plato->cant * $plato->precio,2),2,$printer,$acum,$tabheight_letter,0,270);
		$phpPrinter->tabPrinter($acum,3);
	endforeach;
	
	$phpPrinter->tabPrinter($acum,$tabwidth_letter);
	
	$phpPrinter->printString(strtoupper(utf8_decode('SUBTOTAL')),2,$printer,$acum,$tabheight_letter,$tabwidth_letter,10);
	$phpPrinter->printString("$",2,$printer,$acum,$tabheight_letter,0,250);
	$phpPrinter->printString(number_format($orden->subtotal,2),2,$printer,$acum,$tabheight_letter,0,270);
	
	$phpPrinter->printString(strtoupper(utf8_decode('PROPINA 10%')),2,$printer,$acum,$tabheight_letter,$tabwidth_letter,10);
	$phpPrinter->printString("$",2,$printer,$acum,$tabheight_letter,0,250);
	$phpPrinter->printString(number_format($orden->propina,2),2,$printer,$acum,$tabheight_letter,0,270);
	
	$phpPrinter->printString(strtoupper(utf8_decode('TOTAL')),2,$printer,$acum,$tabheight_letter,$tabwidth_letter,10);
	$phpPrinter->printString("$",2,$printer,$acum,$tabheight_letter,0,250);
	$phpPrinter->printString(number_format($orden->subtotal+$orden->propina,2),2,$printer,$acum,$tabheight_letter,0,270);
	
	$phpPrinter->tabPrinter($acum,$tabwidth_letter);
	
	$phpPrinter->printString($phpPrinter->cutString(strtoupper(utf8_decode('Cliente: '.$orden->cliente)),28),1,$printer,$acum,$tabheight_letter,$tabwidth_letter);
	$phpPrinter->printString($phpPrinter->cutString(strtoupper(utf8_decode('Destino: '.$orden->salon." - ".$orden->mesa)),28),1,$printer,$acum,$tabheight_letter,$tabwidth_letter);
	$phpPrinter->printString($phpPrinter->cutString(strtoupper(utf8_decode('Mesero: '.$orden->mesero)),28),1,$printer,$acum,$tabheight_letter,$tabwidth_letter);
	
	/*********/
	printer_delete_font($font);
	
	printer_end_page($printer);

	printer_end_doc($printer);

	printer_close($printer);	
?>