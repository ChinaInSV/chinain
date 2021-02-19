<?php
	$this->load->library('printer');
	$this->load->library('enletras');
	
	$phpPrinter = new Printer();
	$phpInletters = new EnLetras();
	
	$phpPrinter->resetAcum();
	$acum = 0;
	
	$width_letter=28;
	$height_letter=16;
	
	/*Init*/
	switch($copias):
		case "0":
			$printer = printer_open("POS-80C");
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
	
	$font = printer_create_font('Arial', 32, 18, PRINTER_FW_BOLD, false, false, false, 0);	
	printer_select_font($printer, $font);
	
	$phpPrinter->printString($phpPrinter->cutString(strtoupper(utf8_decode($nombre_empresa)),21),1,$printer,$acum,18,32);
	
	printer_delete_font($font);
	
	$font = printer_create_font('Arial', $width_letter, $height_letter, PRINTER_FW_MEDIUM, false, false, false, 0);	
	printer_select_font($printer, $font);
	
	$phpPrinter->tabPrinter($acum,$width_letter);
	
	$phpPrinter->printString($phpPrinter->cutString(utf8_decode('COMPROBANTE '.$doc_numero),21),1,$printer,$acum,$height_letter,$width_letter);
	$phpPrinter->printString($phpPrinter->cutString(strtoupper(utf8_decode('Caja: '.$caja)),21),1,$printer,$acum,$height_letter,$width_letter);
	$phpPrinter->printString($phpPrinter->cutString(strtoupper(utf8_decode('Vendedor: '.$vendedor)),21),1,$printer,$acum,$height_letter,$width_letter);
	
	$phpPrinter->tabPrinter($acum,$width_letter);
	
	$phpPrinter->printString(strtoupper(utf8_decode('fecha: ')),2,$printer,$acum,$height_letter,$width_letter,0);
	$phpPrinter->printString(strtoupper(utf8_decode($fecha)),2,$printer,$acum,$height_letter,0,100);
	
	$phpPrinter->tabPrinter($acum,$width_letter);
	
	$phpPrinter->printString(strtoupper(utf8_decode('Cant')),2,$printer,$acum,$height_letter,$width_letter,0);
	$phpPrinter->printString(strtoupper(utf8_decode('Desc')),2,$printer,$acum,$height_letter,0,130);
	$phpPrinter->tabPrinter($acum,$width_letter);
	$phpPrinter->printString("- - - - - - - - - - - - - - - - - - - - - - - - - - -",2,$printer,$acum,$height_letter,$width_letter,0);
	$phpPrinter->tabPrinter($acum,$width_letter);
	
	foreach($productos_normal as $producto){
		$phpPrinter->printString($producto->cant,2,$printer,$acum,$height_letter,$width_letter,0);
		$phpPrinter->printString($phpPrinter->cutString(strtoupper(utf8_decode(addslashes($producto->desc))),20),2,$printer,$acum,$height_letter,0,50,$width_letter);
		$phpPrinter->tabPrinter($acum,3);
	}
	$phpPrinter->printString("______________________________",2,$printer,$acum,$height_letter,$width_letter,0);
	//$phpPrinter->printString("G=Gravado E=Exento NS=No Sujeto",2,$printer,$acum,$height_letter,$width_letter,0);
	$phpPrinter->tabPrinter($acum,$width_letter);
	
	$phpPrinter->printString($phpPrinter->cutString(strtoupper(utf8_decode('F:__________________________')),28),1,$printer,$acum,$height_letter,$width_letter);
	$phpPrinter->printString($phpPrinter->cutString(strtoupper(utf8_decode($cliente)),28),1,$printer,$acum,$height_letter,$width_letter);
	
	$phpPrinter->tabPrinter($acum,$width_letter);
	
	$phpPrinter->printString(strtoupper(utf8_decode($servicio)),2,$printer,$acum,$height_letter,0,100);
	
	$phpPrinter->tabPrinter($acum,$width_letter);
	
	$phpPrinter->printString($phpPrinter->cutString(strtoupper(utf8_decode($notas)),28),1,$printer,$acum,$height_letter,$width_letter);
	
	$phpPrinter->tabPrinter($acum,$width_letter);
	
	$phpPrinter->printString($phpPrinter->cutString(strtoupper(utf8_decode("Ref:".$referencia)),21),1,$printer,$acum,$height_letter,$width_letter);
	
	printer_delete_font($font);
	
	printer_end_page($printer);

	printer_end_doc($printer);

	printer_close($printer);
?>