<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Ufood_utilities{
	/*Obtener el valor de  configuraciones*/
	public function get_conf_value($config){
		$CI =& get_instance();
		$CI->load->model('Generic_model');
		foreach($config as $conf){
			$value=$CI->Generic_model->get('q','config','valor_config',array('campo_config'=>$conf->db_campo));
			if($value){
				$return=explode("|",$value[0]->valor_config);
				$returnMode=$return[1];
				switch($returnMode){
					case "i":/*integer*/
						$conf->value=(int)$return[0];
					break;
					case "f":/*float*/
						$conf->value=(float)$return[0];
					break;
					case "s":/*texto plano*/
						$conf->value=$return[0];
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
		}		
		return $config;
	}
	/*Obtener el valor de los permisos de un modulo*/
	public function get_modulo_permiso($modulo){
		
	}
}