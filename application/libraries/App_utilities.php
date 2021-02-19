<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class App_utilities{
	function __construct(){
		$this->CI =& get_instance();
		$this->CI->load->model('Generic_model');		
	}
	
	function send($mensaje,$tipo,$empresa){	
		$config = Array(
			'protocol' => 'smtp',
			'smtp_host' => 'mail.smtp2go.com',
			'smtp_port' => 2525,
			'mailtype' => 'html',
			'smtp_user' => 'omar_arper@hotmail.com',
			'smtp_pass' => 'arperADI1987!'
		);

		$this->CI->load->library('email',$config);
		$this->CI->email->set_newline("\r\n");

		$this->CI->email->from("omar_arper@hotmail.com");
		$this->CI->email->to("omararper@gmail.com");
		if($tipo==2){
			$this->CI->email->subject("Detalle de Ventas Total ".$this->fechaHoraElSalvador(date("Y-m-d"),1)." en China In ".$empresa);
		}else{
			$this->CI->email->subject("Detalle de Ventas Parcial ".$this->fechaHoraElSalvador(date("Y-m-d"),1)." en China In ".$empresa);
		}
		$this->CI->email->message($mensaje);
		
		$this->CI->email->send();
	}
	
	function sortObjectsByField($objects, $fieldName, $sortOrder = SORT_DESC, $sortFlag = SORT_REGULAR){
		$sortFields = array();
		foreach ($objects as $key => $row) {
			$sortFields[$key] = $row->{$fieldName};
		}
		array_multisort($sortFields, $sortOrder, $sortFlag, $objects);
		return $objects;
	}
	
	public function get_conf_value($config){
		foreach($config as $conf){
			$value=$this->CI->Generic_model->get('q','config','valor_config',array('campo_config'=>$conf->db_campo));
			if($value){
				$return=explode("|",$value[0]->valor_config);
				if(isset($return[1])){
					$returnMode=$return[1];
					switch($returnMode){
						case "i":/*integer*/
							$conf->value=(int)$return[0];
						break;
						case "d":/*decimal*/
							$conf->value=number_format($return[0],2);
						break;
						case "s":/*texto plano*/
							$conf->value=(string)$return[0];
						break;
						case "b":/*Boolean*/
							$conf->value=filter_var($return[0],FILTER_VALIDATE_BOOLEAN);
						break;
						case "a":/*array*/
							$conf->value=explode(",",$return[0]);
						break;
					}
				}else{
					$conf->value=$conf->default;
				}			
			}else{
				$conf->value=$conf->default;
			}
		}		
		return $config;
	}
	
	function fechaHoraElSalvador($timestamp,$type) {
		date_default_timezone_set('UTC');
		date_default_timezone_set("America/El_Salvador");
		$hora = strftime("%I:%M:%S %p", strtotime($timestamp));
		setlocale(LC_TIME, 'spanish');
		$fecha = utf8_encode(strftime("%A %d de %B del %Y", strtotime($timestamp)));
		$fecha_only = utf8_encode(strftime("%d de %B del %Y", strtotime($timestamp)));
		switch($type){
			case 0: return $fecha." a las ".$hora; break;
			case 1: return $fecha; break;
			case 2: return $hora; break;
			case 3: return $fecha_only; break;
		}
	}
	
	function TraducirMes($month){
		switch($month){
			case '01':
					return $mes = 'Enero';
				break;
			case '02':
					return $mes = 'Febrero';
				break;
			case '03':
					return $mes = 'Marzo';
				break;
			case '04':
					return $mes = 'Abril';
				break;
			case '05':
					return $mes = 'Mayo';
				break;
			case '06':
					return $mes = 'Junio';
				break;
			case '07':
					return $mes = 'Julio';
				break;
			case '08':
					return $mes = 'Agosto';
				break;
			case '09':
					return $mes = 'Septiembre';
				break;
			case '10':
					return $mes = 'Octubre';
				break;
			case '11':
					return $mes = 'Noviembre';
				break;
			case '12':
					return $mes = 'Diciembre';
				break;
		}
	}
	
	function TraducirMesInversa($month){
		switch($month){
			case 'Enero,':
					return $mes = '01';
				break;
			case 'Febrero,':
					return $mes = '02';
				break;
			case 'Marzo,':
					return $mes = '03';
				break;
			case 'Abril,':
					return $mes = '04';
				break;
			case 'Mayo,':
					return $mes = '05';
				break;
			case 'Junio,':
					return $mes = '06';
				break;
			case 'Julio,':
					return $mes = '07';
				break;
			case 'Agosto,':
					return $mes = '08';
				break;
			case 'Septiembre,':
					return $mes = '09';
				break;
			case 'Octubre,':
					return $mes = '10';
				break;
			case 'Noviembre,':
					return $mes = '11';
				break;
			case 'Diciembre,':
					return $mes = '12';
				break;
		}
	}
}