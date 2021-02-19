<?php
    $this->load->library('phpexcel');
    $this->load->library("App_utilities");
	$PadillaApp = new App_utilities();
    
    $excel = new PHPExcel();

    $styleArrayHeader = array(
        'font'  => array(
            'bold'  => true,
            'color' => array('rgb' => '000000'),
            'size'  => 14
        )
    ); 
    
    $styleArraySubheader = array(
        'font'  => array(
            'bold'  => false,
            'color' => array('rgb' => '000000'),
            'size'  => 13
        )
    ); 
    
    $styleArrayBorders = array(
        'borders' => array(
            'allborders' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN
            )
        ),
        'font'  => array(
            'bold'  => true,
            'color' => array('rgb' => '000000'),
            'size'  => 13
        )
    );

    $styleArrayBordersBody = array(
        'borders' => array(
            'allborders' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN
            )
        ),
        'font'  => array(
            'bold'  => true,
            'color' => array('rgb' => '000000'),
            'size'  => 12
        )
    );
    
    $counterCell = 8;

    $excel->
        getProperties()
            ->setCreator('Xypnos - China In')
            ->setLastModifiedBy('Xypnos')
            ->setTitle('Reportes China In')
            ->setSubject('Consumos')
            ->setDescription('Documento generado con PHPExcel y China In')
            ->setKeywords('Reportes China In - Xypnos')
            ->setCategory('Reportes China In');

    $objDrawing = new PHPExcel_Worksheet_Drawing();
    $objDrawing->setName('Logo');
    $objDrawing->setDescription('Logo');
    $objDrawing->setPath('./assets/img/chinainlogowhiteblack.png');
    $objDrawing->setOffsetX(5);
    $objDrawing->setOffsetY(5);
    $objDrawing->setHeight(125);
    $objDrawing->setWidth(125);
    $objDrawing->setWorksheet($excel->getActiveSheet());

    $excel->setActiveSheetIndex(0)
                ->setCellValue('A1', $PadillaApp->fechaHoraElSalvador(gmdate('d-m-Y H:i:s', strtotime('- 6 hours')),0))
                ->setCellValue('A2', 'Consumos China In')
                ->setCellValue('A3', $configs->nombre_empresa->value)
                ->setCellValue('A4', $configs->direccion_empresa->value)
                ->setCellValue('A5', 'Del: '.$fecha_desde.' Al: '.$fecha_hasta)
                ->setCellValue('A7', 'Fecha / Empleado')
                ->setCellValue('C7', 'Monto');
            
    $sheet = $excel->getActiveSheet();
    $pageMargins = $sheet->getPageMargins();
    $margin = 0.5 / 2.54;
    $pageMargins->setTop($margin);
    $pageMargins->setBottom($margin);
    $pageMargins->setLeft($margin);
    $pageMargins->setRight($margin);

    /*Cuerpo del Documento*/
    if(isset($consumos)):
        foreach($consumos as $key => $value):
            //echo $value["dia"]." $".$value["total_dia"]."<br>";
            $excel->setActiveSheetIndex(0)
                ->setCellValue('A'.$counterCell, $value["dia"])
                ->setCellValue('C'.$counterCell, $value["total_dia"]);
            $excel->getActiveSheet()->mergeCells('A'.$counterCell.':B'.$counterCell);
            $excel->getActiveSheet()->getStyle('A'.$counterCell.':C'.$counterCell)->applyFromArray($styleArrayBordersBody);
            $counterCell++;
            foreach($value["empleados"] as $employ):
                //echo $employ["empleado"]." $".$employ["total_empleado"]."<br>";
                $excel->setActiveSheetIndex(0)
                    ->setCellValue('B'.$counterCell, $employ["empleado"])
                    ->setCellValue('C'.$counterCell, $employ["total_empleado"]);
                $counterCell++;
            endforeach;
        endforeach;
        $excel->setActiveSheetIndex(0)
            ->setCellValue('A'.$counterCell, "Total")
            ->setCellValue('C'.$counterCell, $total);
        $excel->getActiveSheet()->mergeCells('A'.$counterCell.':B'.$counterCell);
        $excel->getActiveSheet()->getStyle('A'.$counterCell.':C'.$counterCell)->applyFromArray($styleArrayBordersBody);
    endif;

    $excel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
    $excel->getActiveSheet()->getColumnDimension('B')->setWidth(80);
    $excel->getActiveSheet()->getColumnDimension('C')->setWidth(20);

    $excel->getActiveSheet()->mergeCells('A1:C1');
    $excel->getActiveSheet()->mergeCells('A2:C2');
    $excel->getActiveSheet()->mergeCells('A3:C3');
    $excel->getActiveSheet()->mergeCells('A4:C4');
    $excel->getActiveSheet()->mergeCells('A5:C5');
    $excel->getActiveSheet()->mergeCells('A7:B7');
    $excel->getActiveSheet()->getStyle('A1:C1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
    $excel->getActiveSheet()->getStyle('A2:C2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $excel->getActiveSheet()->getStyle('A3:C3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $excel->getActiveSheet()->getStyle('A4:C4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $excel->getActiveSheet()->getStyle('A7:C7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $excel->getActiveSheet()->getStyle('A2')->applyFromArray($styleArrayHeader);
    $excel->getActiveSheet()->getStyle('A3:C5')->applyFromArray($styleArraySubheader);
    $excel->getActiveSheet()->getStyle('A7:C7')->getAlignment()->setWrapText(true); 
    $excel->getActiveSheet()->getStyle('A7:C7')->applyFromArray($styleArrayBorders);
    $excel->getActiveSheet()->getStyle('C8:C'.$counterCell)->getNumberFormat()->setFormatCode("_(* #,##0.00_);_(* \(#,##0.00\);_(* \"-\"??_);_(@_)");

    $excel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LETTER);
    $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
    $excel->getActiveSheet()->getPageSetup()->setFitToPage(true);
    $excel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
    $excel->getActiveSheet()->getPageSetup()->setFitToHeight(0);
    $excel->setActiveSheetIndex(0);

    // Código nuevo que me solucionó el problema
    $objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel5');
    $uniqid = uniqid();
    $objWriter->save('./assets/files/Consumos_' . $uniqid . '.xls');
    redirect(base_url('/assets/files/Consumos_' . $uniqid . '.xls'));
?>