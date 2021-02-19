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
		'FechaFooter'=>$PadillaApp->fechaHoraElSalvador(gmdate('d-m-Y H:i:s', strtotime('- 6 hours')),0)
    );
    
	class PDF extends FPDF{
    
        function Header(){
            global $dataArray;
            $this->Image($dataArray['Logo'],10,12,20);
            $this->SetFont('Arial','B',10);
            $this->SetY(6);
            $this->Cell(0,6,strtoupper(utf8_decode('Reporte de Platos')),0,1,'L');
            $this->SetFont('Arial','B',9);
            $this->SetY(6);
            $this->Cell(0,6,strtoupper(utf8_decode($dataArray['Empresa'])),0,1,'R');
			$this->SetFont('Arial','',9);
            $this->Cell(0,6,utf8_decode($dataArray['Direccion']),0,1,'R');
            $this->Cell(0,6,utf8_decode("Telefono: ".$dataArray['Telefono']),0,1,'R');
			$this->Cell(0,6,utf8_decode("Periodo: ".$dataArray['FechaDesde']." a ".$dataArray['FechaHasta']),0,1,'R');
            $this->Ln(5);
			
			$this->SetFont('Arial','B',9);
			$this->Cell(140,6,strtoupper(utf8_decode('Servicio')),"TLB",0,'C');
			$this->Cell(25,6,strtoupper(utf8_decode('Platos')),"TB",0,'C');
			$this->Cell(31,6,strtoupper(utf8_decode('Totales')),"TRB",1,'C');
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
    $pdf->setTitle('Reporte de Platos');
    $pdf->setAuthor('ClinicaPadillaApp v1.0 - Xypnos');
    $pdf->AddPage('P','Letter');
	
	/*Cuerpo del Documento*/
	if(isset($servicios)):
		$total=0;
		$platos=0;
		foreach($servicios as $servicio):
			if($servicio->pagos>0):
				$pdf->Cell(140,7,utf8_decode($servicio->nombre_plato),"L",0,'L');
				$pdf->Cell(25,7,utf8_decode(number_format($servicio->platos,0)),0,0,'C');
				$pdf->Cell(6,7,utf8_decode('$'),0,0,'C');
				$pdf->Cell(25,7,utf8_decode(number_format($servicio->pagos,2)),"R",1,'R');
				$total+=$servicio->pagos;
				$platos+=$servicio->platos;
			else:
				if($cero==true):
					$pdf->Cell(140,7,utf8_decode($servicio->nombre_plato),"L",0,'L');
					$pdf->Cell(25,7,utf8_decode(number_format($servicio->platos,0)),0,0,'C');
					$pdf->Cell(6,7,utf8_decode('$'),0,0,'C');
					$pdf->Cell(25,7,utf8_decode(number_format($servicio->pagos,2)),"R",1,'R');
				endif;
			endif;
		endforeach;
		$pdf->SetFont('Arial','B',9);
		$pdf->Cell(140,7,utf8_decode('Total'),"T",0,'L');
		$pdf->Cell(25,7,utf8_decode(number_format($platos,0)),"T",0,'C');
		$pdf->Cell(6,7,utf8_decode('$'),"T",0,'C');
		$pdf->Cell(25,7,utf8_decode(number_format($total,2)),"T",1,'R');
	endif;
	
	$pdf->Output('Reporte de Platos.pdf','I');
?>