<?php
	class Printer{
		function cutString($texto,$maxLetter){
			$array = explode(' ',$texto);
			$newArray = array();
			$newArrayOffset = 0;
			$maxCha = 0;
			$value = '';
			$chaRest = $maxLetter;

			for($i=0;$i<count($array);$i++)
			{	
				if($chaRest < strlen($array[$i])){
					$newArrayOffset++;        
					$maxCha = 0;
					$chaRest = $maxLetter;
				}
				
				if($i > 0){
					if(isset($newArray[$newArrayOffset])):
						$value = $newArray[$newArrayOffset].' ';
					else:
						$value='';
					endif;
				}

				$newArray[$newArrayOffset] = trim($value.$array[$i]);
				$maxCha+= strlen($array[$i]);
				$chaRest-= strlen($array[$i]);
				
				if($maxCha > $maxLetter) {
					$newArrayOffset++;        
					$maxCha = 0;
					$chaRest = $maxLetter;
				}    
			}
			
			return $newArray;
		}
		
		function printString($texto,$forma,$printer,$acum,$widthLetter,$heighLetter = 0,$xPos = 15,$tabDefault = 10,$widthPagePaper = 0){
			global $acum;
			$count = 0;
			switch($forma){
				/*Texto Centrado*/
				case 1:
						foreach($texto as $text):
							if($text != ''):
								printer_draw_text($printer, utf8_decode($text), $this->centerString(strlen($text),$widthLetter,$widthPagePaper), $acum+=$heighLetter);
							endif;
						endforeach;
					break;
				/*Texto en linea*/
				case 2:
						if(is_array($texto)):
						foreach($texto as $text):
							if($text != ''):
								if($count > 0):
									printer_draw_text($printer, utf8_decode($text), $xPos, $acum+=$tabDefault);
								else:
									printer_draw_text($printer, utf8_decode($text), $xPos, $acum+=$heighLetter);
								endif;
								$count++;
							endif;
						endforeach;
						else:
							printer_draw_text($printer, utf8_decode($texto), $xPos, $acum+=$heighLetter);
						endif;
					break;
			}
		}
		
		function centerString($textlength,$widthLetter,$widthPagePaper){
			if($widthPagePaper == 0){
				$widthPage = 295;
			}else{
				$widthPage = 270;
			}
			$space = (($widthPage - ($textlength * $widthLetter)) / 2);
			if($space <= 0){
				return $space = 0;
			}else{
				return $space + 15;
			}
		}
		
		function resetAcum(){
			global $acum;
			$acum = 0;
		}
		
		function tabPrinter($acum,$value){
			global $acum;
			$acum+= $value;
		}
		
		function getAcum(){
			global $acum;
			return $acum;
		}
	}
?>