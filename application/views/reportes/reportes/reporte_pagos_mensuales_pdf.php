<?php
	$this->load->library('Fpdf');
	$this->load->library("App_utilities");
	$PadillaApp = new App_utilities();
    
    $GLOBALS['dataArray'] = array(
        'Empresa' => $configs->nombre_empresa->value,
        'Direccion' => $configs->direccion_empresa->value,
		'Logo' => $configs->logo_empresa->value,
        'Telefono' => $configs->telefono_empresa->value,
        'FechaDesde' => $fecha_desde,
        'FechaHasta' => $fecha_hasta,
        'Transacciones' => count($transacciones),
		'FechaFooter'=>$PadillaApp->fechaHoraElSalvador(gmdate('d-m-Y H:i:s', strtotime('- 6 hours')),0)
    );
    
	class PDF extends FPDF{
    
        function Header(){
            global $dataArray;
            $this->Image($dataArray['Logo'],10,12,20);
            $this->SetFont('Arial','B',10);
            $this->SetY(6);
            $this->Cell(0,6,strtoupper(utf8_decode('Reporte de Pagos Mensuales')),0,1,'L');
            $this->SetFont('Arial','B',9);
            $this->SetY(6);
            $this->Cell(0,6,strtoupper(utf8_decode($dataArray['Empresa'])),0,1,'R');
			$this->SetFont('Arial','',9);
            $this->Cell(0,6,utf8_decode($dataArray['Direccion']),0,1,'R');
            $this->Cell(0,6,utf8_decode("Telefono: ".$dataArray['Telefono']),0,1,'R');
			$this->Cell(0,6,utf8_decode("Periodo: ".$dataArray['FechaDesde']." a ".$dataArray['FechaHasta']),0,1,'R');
            $this->Ln(5);
			
			$this->SetFont('Arial','B',9);
			if($dataArray['Transacciones'] > 1){
				$this->Cell(60,6,strtoupper(utf8_decode('Mes')),1,0,'C');
				$this->Cell(38,6,strtoupper(utf8_decode('Monto')),1,0,'C');
				$this->Cell(60,6,strtoupper(utf8_decode('Mes')),1,0,'C');
				$this->Cell(38,6,strtoupper(utf8_decode('Monto')),1,1,'C');				
			}else{
				$this->Cell(60,6,strtoupper(utf8_decode('Mes')),1,0,'C');
				$this->Cell(38,6,strtoupper(utf8_decode('Monto')),1,1,'C');
			}
			$this->SetFont('Arial','',9);
        }
        
        function Footer(){
			global $dataArray;
            $this->SetY(-15);
            $this->SetFont('Arial','I',7);
            $this->Cell(155,6,utf8_decode('Pagina '.$this->PageNo().'/{nb}'),0,0,'L');
            $this->Cell(40,6,utf8_decode($dataArray['FechaFooter']),0,1,'R');
            $this->Cell(40,6,utf8_decode('ClinicaPadillaApp v1.0 - Todos los Derechos Reservados 2512 - '.date('Y').' - Xypnos Soluciones Tecnologicas'),0,1,'L');
        }
    }

    $pdf = new PDF();
    $pdf->AliasNbPages(); 
    $pdf->setTitle('Reporte de Pagos Diarios');
    $pdf->setAuthor('ClinicaPadillaApp v1.0 - Xypnos');
    $pdf->AddPage('P','Letter');
	
	/*Cuerpo del Documento*/
	if(isset($transacciones)):
		$total=0;
		$par=0;
		foreach($transacciones as $transaccion):
			$fecha = explode("-",$transaccion->Fecha);
			if($par==0){
				$pdf->Cell(60,5,utf8_decode($PadillaApp->TraducirMes($fecha[0])." del ".$fecha[1]),1,0,'L');
				$pdf->Cell(8,5,utf8_decode('$'),"LTB",0,'C');
				$pdf->Cell(30,5,utf8_decode($transaccion->Monto),"TRB",1,'R');
				$par=1;
				$Y=$pdf->GetY();
			}else{
				$pdf->SetXY(108,$Y-5);
				$pdf->Cell(60,5,utf8_decode($PadillaApp->TraducirMes($fecha[0])." del ".$fecha[1]),1,0,'L');
				$pdf->Cell(8,5,utf8_decode('$'),"LTB",0,'C');
				$pdf->Cell(30,5,utf8_decode($transaccion->Monto),"TRB",1,'R');
				$par=0;
			}
			$total+=$transaccion->Monto;
		endforeach;
		$pdf->SetFont('Arial','B',8);
		$pdf->Cell(20,5,utf8_decode('Total'),0,0,'L');
		$pdf->Cell(8,5,utf8_decode('$'),0,0,'C');
		$pdf->Cell(20,5,utf8_decode($total),0,1,'L');
	endif;
	
	$pdf->Output('Reporte de Pagos Diarios.pdf','I');
?>