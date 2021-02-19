<?php
	$this->load->library('Fpdf');
	$this->load->library("App_utilities");
	$PadillaApp = new App_utilities();
	
	switch($metodo):
		case "-":$metodo="Consolidado";break;
		case 0:$metodo="Efectivo";break;
		case 1:$metodo="POS";break;
		case 2:$metodo="ISBM";break;
		case 3:$metodo="Agepym";break;
		case 4:$metodo="ACACU";break;
	endswitch;
    
    $GLOBALS['dataArray'] = array(
        'Empresa' => $configs->nombre_empresa->value,
        'Direccion' => $configs->direccion_empresa->value,
		'Logo' => $configs->logo_empresa->value,
        'Telefono' => $configs->telefono_empresa->value,
        'FechaDesde' => $fecha_desde,
        'FechaHasta' => $fecha_hasta,
        'Metodo' => $metodo,
		'FechaFooter'=>$PadillaApp->fechaHoraElSalvador(gmdate('d-m-Y H:i:s', strtotime('- 6 hours')),0)
    );
    
	class PDF extends FPDF{
    
        function Header(){
            global $dataArray;
            $this->Image($dataArray['Logo'],10,12,40);
            $this->SetFont('Arial','B',10);
            $this->SetY(6);
            $this->Cell(0,6,strtoupper(utf8_decode('Reporte de Pagos Diarios - '.$dataArray['Metodo'])),0,1,'L');
            $this->SetFont('Arial','B',9);
            $this->SetY(6);
            $this->Cell(0,6,strtoupper(utf8_decode($dataArray['Empresa'])),0,1,'R');
			$this->SetFont('Arial','',9);
            $this->Cell(0,6,utf8_decode($dataArray['Direccion']),0,1,'R');
            $this->Cell(0,6,utf8_decode("Telefono: ".$dataArray['Telefono']),0,1,'R');
			$this->Cell(0,6,utf8_decode("Periodo: ".$dataArray['FechaDesde']." al ".$dataArray['FechaHasta']),0,1,'R');
            $this->Ln(5);
			
			$this->SetFont('Arial','B',9);
			/*Header Tabla*/
			$this->Cell(55,6,strtoupper(utf8_decode('Fecha')),1,0,'C');
			$this->Cell(45,6,strtoupper(utf8_decode('Cajero')),1,0,'C');
			$this->Cell(50,6,strtoupper(utf8_decode('Cliente')),1,0,'C');
			$this->Cell(60,6,strtoupper(utf8_decode('Documento')),1,0,'C');
			$this->Cell(25,6,strtoupper(utf8_decode('Forma')),1,0,'C');
			$this->Cell(25,6,strtoupper(utf8_decode('Monto')),1,1,'C');
			$this->SetFont('Arial','',8);
        }
        
        function Footer(){
			global $dataArray;
            $this->SetY(-15);
            $this->SetFont('Arial','I',7);
            $this->Cell(220,6,utf8_decode('Pagina '.$this->PageNo().'/{nb}'),0,0,'L');
            $this->Cell(40,6,utf8_decode($dataArray['FechaFooter']),0,1,'R');
            $this->Cell(40,6,utf8_decode($dataArray['Empresa'].' v1.0 - Todos los Derechos Reservados 2012 - '.date('Y').' - Xypnos Soluciones Tecnologicas'),0,1,'L');
        }
    }

    $pdf = new PDF();
    $pdf->AliasNbPages(); 
    $pdf->setTitle('Reporte de Pagos Diarios');
    $pdf->setAuthor($configs->nombre_empresa->value.' v1.0 - Xypnos');
    $pdf->AddPage('L','Letter');
	
	/*Cuerpo del Documento*/
	if(isset($transacciones)):
		$total=0;
		$propina=0;
		foreach($transacciones as $transaccion):		
			$pdf->Cell(55,5,utf8_decode($PadillaApp->fechaHoraElSalvador($transaccion->fecha_venta,1)),1,0,'L');
			$pdf->Cell(45,5,utf8_decode($transaccion->nombre_usuario),1,0,'L');
			$pdf->Cell(50,5,utf8_decode((($transaccion->nombre_cliente!="")?$transaccion->nombre_cliente:$transaccion->nombre_cliente)),1,0,'L');
			$pdf->Cell(60,5,utf8_decode("Comprobante de pago No ".$transaccion->num_doc_venta),1,0,'L');
			$pdf->Cell(25,5,utf8_decode("Efectivo"),1,0,'L');
			$pdf->Cell(5,5,utf8_decode('$'),"LTB",0,'C');
			$pdf->Cell(20,5,utf8_decode(number_format($transaccion->subtotal_venta,2)),"TRB",1,'R');
			$total+=$transaccion->subtotal_venta;
			$propina+=$transaccion->propina_venta;
			if($devoluciones && isset($transaccion->devolucion)):foreach($transaccion->devolucion as $devolucion):
				$pdf->Cell(55,5,utf8_decode($PadillaApp->fechaHoraElSalvador($devolucion->fecha_devolucion,1)),1,0,'L');
				$pdf->Cell(45,5,utf8_decode($devolucion->nombre_usuario),1,0,'L');
				$pdf->Cell(50,5,utf8_decode((($devolucion->cliente_devolucion!="")?$devolucion->cliente_devolucion:$devolucion->cliente_devolucion)),1,0,'L');
				$pdf->Cell(60,5,utf8_decode("Dev. con Comprobante No ".$devolucion->num_doc_devolucion),1,0,'L');
				$pdf->Cell(25,5,utf8_decode("Efectivo"),1,0,'L');
				$pdf->Cell(5,5,utf8_decode('($'),"LTB",0,'C');
				$pdf->Cell(20,5,utf8_decode(number_format($devolucion->subtotal_devolucion,2).")"),"TRB",1,'R');
				$total-=$devolucion->subtotal_devolucion;
				$propina-=$devolucion->propina_devolucion;
			endforeach;endif;
			if($valores):foreach($transaccion->platos as $plato):
				$pdf->SetFont('Arial','',7);
				$pdf->Cell(160,5,"",0,0,'C');
				$pdf->Cell(54,5,utf8_decode($plato->nombre_plato),0,0,'L');
				$pdf->Cell(10,5,strtoupper(utf8_decode($plato->cant_vproducto)),0,0,'L');
				$pdf->Cell(3,5,strtoupper(utf8_decode('$')),0,0,'C');
				$pdf->Cell(15,5,strtoupper(utf8_decode(number_format($plato->costo_vproducto,2))),0,0,'R');
				$pdf->Cell(3,5,strtoupper(utf8_decode('$')),0,0,'C');
				$pdf->Cell(15,5,strtoupper(utf8_decode(number_format($plato->cant_vproducto*$plato->costo_vproducto,2))),0,1,'R');
				$pdf->Ln(2);
				$pdf->SetFont('Arial','',8);
			endforeach;endif;
		endforeach;
		$pdf->SetFont('Arial','B',8);
		$pdf->SetX(220);
		$pdf->Cell(25,5,utf8_decode('Subtotal'),"LTB",0,'R');
		$pdf->Cell(5,5,utf8_decode('$'),"TB",0,'C');
		$pdf->Cell(20,5,utf8_decode(number_format($total,2)),"TRB",1,'R');
		$pdf->SetX(220);
		$pdf->Cell(25,5,utf8_decode('Propina'),"LTB",0,'R');
		$pdf->Cell(5,5,utf8_decode('$'),"TB",0,'C');
		$pdf->Cell(20,5,utf8_decode(number_format($propina,2)),"TRB",1,'R');
		$pdf->SetX(220);
		$pdf->Cell(25,5,utf8_decode('Total'),"LTB",0,'R');
		$pdf->Cell(5,5,utf8_decode('$'),"TB",0,'C');
		$pdf->Cell(20,5,utf8_decode(number_format($total+$propina,2)),"TRB",1,'R');
	endif;
	
	$pdf->Output('Reporte de Pagos Diarios.pdf','I');
?>