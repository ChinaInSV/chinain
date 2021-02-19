<?php
	$this->load->library('printer');
	
	$phpPrinter = new Printer();
	
	if(count($impresos) > 0):
		foreach($impresos as $impresor=>$data):
	
			$acum = 0;
			
			/*Init*/
			$printer = printer_open($impresor);

			printer_set_option($printer, PRINTER_MODE, 'RAW');

			printer_start_doc($printer, 'Orden CC Numero: '.$data["id_orden"]);

			printer_start_page($printer);
			
			/*Body*/
			
			$font = printer_create_font('Arial', 28, 16, PRINTER_FW_THIN, false, false, false, 0);
			printer_select_font($printer, $font);
			
			/*Comprobante*/
			$phpPrinter->printString($phpPrinter->cutString(strtoupper(utf8_decode('Orden Call Center')),24),1,$printer,$acum,16,28);
			$phpPrinter->printString($phpPrinter->cutString(strtoupper(utf8_decode('Numero: '.$data["id_orden"])),24),1,$printer,$acum,9,28);
			$phpPrinter->printString($phpPrinter->cutString(strtoupper(utf8_decode($data["cocina"])),24),1,$printer,$acum,9,28);
			$phpPrinter->tabPrinter($acum,28);
			
			$phpPrinter->printString(strtoupper(utf8_decode('fecha: ')),2,$printer,$acum,16,28,15);
			$phpPrinter->printString(strtoupper(utf8_decode($data["fecha"])),2,$printer,$acum,16,0,140);
			$phpPrinter->tabPrinter($acum,28);
			
			/*Descripcion de Servicios*/
			$phpPrinter->printString(strtoupper(utf8_decode('cant')),2,$printer,$acum,16,28,15);
			$phpPrinter->printString(strtoupper(utf8_decode('descripcion')),2,$printer,$acum,16,0,180);
			$phpPrinter->tabPrinter($acum,28);
			
			foreach($data["platos"] as $plato):
				$phpPrinter->printString($phpPrinter->cutString(strtoupper(utf8_decode($plato[0])),18),2,$printer,$acum,16,28);	
				if($plato[2]!=""):
				$phpPrinter->printString($phpPrinter->cutString(strtoupper(utf8_decode($plato[1]." con ".$plato[2])),18),2,$printer,$acum,16,0,100,28);
				else:
				$phpPrinter->printString($phpPrinter->cutString(strtoupper(utf8_decode($plato[1])),18),2,$printer,$acum,16,0,100,28);
				endif;
				if($plato[3]!=""):
				$phpPrinter->printString($phpPrinter->cutString(strtoupper(utf8_decode("Notas: ".$plato[3])),36),2,$printer,$acum,16,28,28);
				endif;
				$phpPrinter->tabPrinter($acum,28);	
			endforeach;	
			$phpPrinter->tabPrinter($acum,10);
			$phpPrinter->printString("________________________________",2,$printer,$acum,16,28);
			$phpPrinter->tabPrinter($acum,28);
			
			/*Datos*/
			$phpPrinter->printString(strtoupper(utf8_decode('Pago: ')),2,$printer,$acum,16,28,15);
			$phpPrinter->printString($phpPrinter->cutString(strtoupper(utf8_decode($data["formapago"])),13),2,$printer,$acum,16,0,195,28);

			$phpPrinter->printString(strtoupper(utf8_decode('Servicio: ')),2,$printer,$acum,16,28,15);
			$phpPrinter->printString($phpPrinter->cutString(strtoupper(utf8_decode($data["servicio"])),13),2,$printer,$acum,16,0,195,28);
			
			$phpPrinter->printString(strtoupper(utf8_decode('Notas: ')),2,$printer,$acum,16,28,15);
			$phpPrinter->printString($phpPrinter->cutString(strtoupper(utf8_decode($data["notas"])),13),2,$printer,$acum,16,0,195,28);
			
			$phpPrinter->printString(strtoupper(utf8_decode('Cliente: ')),2,$printer,$acum,16,28,15);
			$phpPrinter->printString($phpPrinter->cutString(strtoupper(utf8_decode($data["cliente"])),13),2,$printer,$acum,16,0,195,28);
			
			$phpPrinter->printString(strtoupper(utf8_decode('Dir: ')),2,$printer,$acum,16,28,15);
			$phpPrinter->printString($phpPrinter->cutString(strtoupper(utf8_decode($data["direccion"])),13),2,$printer,$acum,16,0,195,28);
			
			$phpPrinter->printString(strtoupper(utf8_decode('Tel: ')),2,$printer,$acum,16,28,15);
			$phpPrinter->printString($phpPrinter->cutString(strtoupper(utf8_decode($data["telefono"])),13),2,$printer,$acum,16,0,195,28);
			
			$phpPrinter->printString(strtoupper(utf8_decode('Cambio: ')),2,$printer,$acum,16,28,15);
			$phpPrinter->printString($phpPrinter->cutString(strtoupper(utf8_decode($data["cambio"])),13),2,$printer,$acum,16,0,195,28);
			
			printer_delete_font($font);
			/*End*/
			printer_end_page($printer);

			printer_end_doc($printer);

			printer_close($printer);
		endforeach;
	endif;
?>