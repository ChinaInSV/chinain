<?php
class Reportes extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->session_ = $this->session->userdata('userInfo');
		$this->is_logged_in();
		$this->load->library('App_utilities');
		/*Configuraciones*/
		$this->configs = (object) array(
			"nombre_empresa"=>(object) array("db_campo"=>"gral_info_nombre_empresa","default"=>""),
			"direccion_empresa"=>(object) array("db_campo"=>"gral_info_direccion_empresa","default"=>""),
			"telefono_empresa"=>(object) array("db_campo"=>"gral_info_telefono_empresa","default"=>""),
			"logo_empresa"=>(object) array("db_campo"=>"gral_info_logo_empresa","default"=>"assets/img/chinainlogowhiteblack.png")
		);
		
		$this->configs=$this->app_utilities->get_conf_value($this->configs);
	}
	/**/
	function reportes_texto(){
		$UIDataModal["title"]='Reportes';
		$UIDataModal["content_view"]="reportes/reportes_view";
		$UIDataModal["classes"]="modal-custom";
		$UIDataModal["width"]=$this->input->get("width")*0.95;
		$UIDataModal["height"]=$this->input->get("height")*0.70;
		$UIDataModal["id"]="caja-reportes-texto-modal";
		$UIDataModal["mode"]=$this->input->get("mode");
		
		$UIDataModal["usuarios"]=$this->Generic_model->get("q","usuarios","id_usuario as id, nombre_usuario as nombre");
		$UIDataModal["clientes"]=$this->Generic_model->get("q","clientes","id_cliente as id, nombre_cliente as nombre");
		
		$this->load->view('templates/template_modal',$UIDataModal);
	}
		function reporte_pagos(){
			$reportData['configs'] = $this->configs;
			$reportData['metodo'] = $this->input->get("metodo");
			$reportData['fecha_desde'] = $this->input->get("fechadesde");
			$reportData['fecha_hasta'] = $this->input->get("fechahasta");
			$reportData['devoluciones'] = filter_var($this->input->get("devoluciones"),FILTER_VALIDATE_BOOLEAN);
			$reportData['valores'] = filter_var($this->input->get("valores"),FILTER_VALIDATE_BOOLEAN);
			
			$fecha_desde = explode(" ",$this->input->get("fechadesde"));
			$fecha_hasta = explode(" ",$this->input->get("fechahasta"));
			
			if($this->input->get("forma")==0){
				$fecha_desde = $fecha_desde[2]."-".$this->app_utilities->TraducirMesInversa($fecha_desde[1])."-".$fecha_desde[0];				
				$fecha_hasta = $fecha_hasta[2]."-".$this->app_utilities->TraducirMesInversa($fecha_hasta[1])."-".$fecha_hasta[0];
				
				$SQLStmt="(SELECT *";
				$SQLStmt.=" FROM ventas";
				$SQLStmt.=" LEFT OUTER JOIN usuarios on usuarios.id_usuario=ventas.id_cajero";
				$SQLStmt.=" LEFT OUTER JOIN clientes on clientes.id_cliente=ventas.id_cliente";
				$SQLStmt.=" WHERE DATE(`fecha_venta`) >= '".$fecha_desde."' AND DATE(`fecha_venta`) <= '".$fecha_hasta."'";
				if($this->input->get("metodo")!="-"):
					$SQLStmt.=" AND forma_pago_venta = '".$this->input->get("metodo")."'";
				endif;
				if($this->input->get("cliente")!="-"){
					$SQLStmt.=" AND ventas.id_cliente = ".$this->input->get("cliente");
				}
				if($this->input->get("usuario")!="-"){
					$SQLStmt.=" AND ventas.id_cajero = ".$this->input->get("usuario");
				}
				
				$SQLStmt.=" ORDER BY fecha_venta DESC";
				$SQLStmt.=")";
				
				$transacciones=$this->Generic_model->sql_custom($SQLStmt);
				
				if($transacciones){
					foreach($transacciones as $transaccion):
						$transaccion->platos=$this->Generic_model->get("q","vproductosxventa","*",array("id_venta"=>$transaccion->id_venta),"","",array("platos"=>"platos.id_plato=vproductosxventa.id_plato"));
						if(filter_var($this->input->get("devoluciones"),FILTER_VALIDATE_BOOLEAN)){
							$transaccion->devolucion=$this->Generic_model->get("q","devoluciones","*",array("id_venta"=>$transaccion->id_venta),"","",array("usuarios"=>"usuarios.id_usuario=devoluciones.id_cajero"));
						}else{
							$devolucion=$this->Generic_model->get("q","devoluciones","*",array("id_venta"=>$transaccion->id_venta));
							if($devolucion){
								$transaccion->subtotal_venta=$transaccion->subtotal_venta-$devolucion[0]->subtotal_devolucion;								
							}
						}
					endforeach;
					$reportData["transacciones"]=$transacciones;
				}
				
				$this->load->view("reportes/reportes/reporte_pagos_diarios_pdf",$reportData);
			}else{
				$fecha_desde = date($fecha_desde[1]."-".$this->app_utilities->TraducirMesInversa($fecha_desde[0])."-01");				
				$fecha_hasta = date($fecha_hasta[1]."-".$this->app_utilities->TraducirMesInversa($fecha_hasta[0])."-t");
				
				$SQLStmt="(SELECT DATE_FORMAT(`fecha_venta`, '%m-%Y') as Fecha, SUM(subtotal_venta) as Monto";
				$SQLStmt.=" FROM ventas";
				$SQLStmt.=" WHERE DATE(`fecha_venta`) >= '".$fecha_desde."' AND DATE(`fecha_venta`) <= '".$fecha_hasta."'";
				$SQLStmt.=" AND estado_venta = 0";
				$SQLStmt.=" GROUP BY DATE_FORMAT(`fecha_venta`, '%m-%Y')";
				$SQLStmt.=" ORDER BY fecha_venta ASC";
				$SQLStmt.=")";
				
				$reportData["transacciones"]=$this->Generic_model->sql_custom($SQLStmt);
				$this->load->view("reportes/reportes/reporte_pagos_mensuales_pdf",$reportData);
			}			
		}
		
		function reporte_platos(){
			$reportData['configs'] = $this->configs;
			$reportData['fecha_desde'] = $this->input->get("fechadesde");
			$reportData['fecha_hasta'] = $this->input->get("fechahasta");
			$reportData['cero'] = filter_var($this->input->get("cero"),FILTER_VALIDATE_BOOLEAN);
			
			$fecha_desde = explode(" ",$this->input->get("fechadesde"));
			$fecha_hasta = explode(" ",$this->input->get("fechahasta"));
			$fecha_desde = $fecha_desde[2]."-".$this->app_utilities->TraducirMesInversa($fecha_desde[1])."-".$fecha_desde[0];				
			$fecha_hasta = $fecha_hasta[2]."-".$this->app_utilities->TraducirMesInversa($fecha_hasta[1])."-".$fecha_hasta[0];
			
			if(filter_var($this->input->get("grupos"),FILTER_VALIDATE_BOOLEAN)){
				$grupos=$this->Generic_model->get("q","categorias_menu");
				
				if(count($grupos)){
					foreach($grupos as $grupo){
						$total_grupo=0;
						$platos=$this->Generic_model->get("q","platosxcategoria","*",array("id_categoria_menu"=>$grupo->id_categoria_menu),"","",array("platos"=>"platos.id_plato=platosxcategoria.id_plato"));
						if(count($platos)){
							foreach($platos as $plato){
								$wheres=array(
									"id_plato"=>$plato->id_plato,
									"DATE(fecha_venta) >="=>$fecha_desde,
									"DATE(fecha_venta) <="=>$fecha_hasta,
									"estado_venta"=>0,
								);
								$transacciones=$this->Generic_model->get("q","vproductosxventa","SUM(cant_vproducto * costo_vproducto) as Total, SUM(cant_vproducto) as Platos",$wheres,"","",array("ventas"=>"ventas.id_venta=vproductosxventa.id_venta"));
								if(count($transacciones)){
									$plato->pagos=$transacciones[0]->Total;
									$plato->platos=$transacciones[0]->Platos;
									$total_grupo+=$transacciones[0]->Total;
								}else{
									$plato->pagos=0;
									$plato->platos=0;
								}
							}
						}
						$grupo->total=$total_grupo;
						$grupo->platos=$platos;
					}
				}
				$reportData["grupos"]=$this->app_utilities->sortObjectsByField($grupos,"total");
				$this->load->view("reportes/reportes/reporte_serviciosxgrupo_pdf",$reportData);
			}else{
				$platos=$this->Generic_model->get("q","platos","*");
				if(count($platos)){
					foreach($platos as $plato){
						$transacciones="";
						$wheres=array(
							"id_plato"=>$plato->id_plato,
							"DATE(fecha_venta) >="=>$fecha_desde,
							"DATE(fecha_venta) <="=>$fecha_hasta,
							"estado_venta"=>0,
						);
						$transacciones=$this->Generic_model->get("q","vproductosxventa","SUM(cant_vproducto * costo_vproducto) as Total, SUM(cant_vproducto) as Platos",$wheres,"","",array("ventas"=>"ventas.id_venta=vproductosxventa.id_venta"));
						if(count($transacciones)){
							$plato->pagos=$transacciones[0]->Total;
							$plato->platos=$transacciones[0]->Platos;
						}else{
							$plato->pagos=0;
							$plato->platos=0;
						}
					}
				}
				$reportData["servicios"]=$this->app_utilities->sortObjectsByField($platos,"pagos");
				$this->load->view("reportes/reportes/reporte_servicios_pdf",$reportData);
			}
		}
	
	function reportes_grafico(){
		$UIDataModal["title"]='Graficos';
		$UIDataModal["content_view"]="reportes/reportes_grafico_view";
		$UIDataModal["classes"]="modal-custom";
		$UIDataModal["width"]=$this->input->get("width")*0.95;
		$UIDataModal["height"]=$this->input->get("height")*0.70;
		$UIDataModal["id"]="caja-reportes-grafico-modal";
		$UIDataModal["mode"]=$this->input->get("mode");
		
		$this->load->view('templates/template_modal',$UIDataModal);
	}
		function grafico_pagos(){
			$graphicData['valores'] = $this->input->get("valores");
			$graphicData['fecha_desde'] = $this->input->get("fechadesde");
			$graphicData['fecha_hasta'] = $this->input->get("fechahasta");
			
			$fecha_desde = explode(" ",$this->input->get("fechadesde"));
			$fecha_hasta = explode(" ",$this->input->get("fechahasta"));
			
			if($this->input->get("forma")==0){
				$fecha_desde = $fecha_desde[2]."-".$this->app_utilities->TraducirMesInversa($fecha_desde[1])."-".$fecha_desde[0];				
				$fecha_hasta = $fecha_hasta[2]."-".$this->app_utilities->TraducirMesInversa($fecha_hasta[1])."-".$fecha_hasta[0];
				
				$SQLStmt="(SELECT DATE(fecha_venta) as Fecha, SUM(subtotal_venta) as Total";
				$SQLStmt.=" FROM ventas";
				$SQLStmt.=" WHERE DATE(`fecha_venta`) >= '".$fecha_desde."' AND DATE(`fecha_venta`) <= '".$fecha_hasta."'";
				$SQLStmt.=" AND estado_venta = 0";
				$SQLStmt.=" GROUP BY DATE(`fecha_venta`)";
				$SQLStmt.=" ORDER BY fecha_venta ASC";
				$SQLStmt.=")";
				
				$graphicData["transacciones"]=$this->Generic_model->sql_custom($SQLStmt);
				$this->load->view("reportes/graficos/grafico_pagos_diarios",$graphicData);
			}else{
				$fecha_desde = date($fecha_desde[1]."-".$this->app_utilities->TraducirMesInversa($fecha_desde[0])."-01");				
				$fecha_hasta = date($fecha_hasta[1]."-".$this->app_utilities->TraducirMesInversa($fecha_hasta[0])."-t");
				
				$SQLStmt="(SELECT DATE_FORMAT(`fecha_venta`, '%m-%Y') as Fecha, SUM(subtotal_venta) as Total";
				$SQLStmt.=" FROM ventas";
				$SQLStmt.=" WHERE DATE(`fecha_venta`) >= '".$fecha_desde."' AND DATE(`fecha_venta`) <= '".$fecha_hasta."'";
				$SQLStmt.=" AND estado_venta = 0";
				$SQLStmt.=" GROUP BY DATE_FORMAT(`fecha_venta`, '%m-%Y')";
				$SQLStmt.=" ORDER BY fecha_venta ASC";
				$SQLStmt.=")";
				
				$graphicData["transacciones"]=$this->Generic_model->sql_custom($SQLStmt);
				$this->load->view("reportes/graficos/grafico_pagos_mensuales",$graphicData);
			}
		}
		function grafico_servicios(){
			$graphicData['valores'] = $this->input->get("valores");
			$graphicData['fecha_desde'] = $this->input->get("fechadesde");
			$graphicData['fecha_hasta'] = $this->input->get("fechahasta");
			
			$fecha_desde = explode(" ",$this->input->get("fechadesde"));
			$fecha_hasta = explode(" ",$this->input->get("fechahasta"));
			$fecha_desde = $fecha_desde[2]."-".$this->app_utilities->TraducirMesInversa($fecha_desde[1])."-".$fecha_desde[0];				
			$fecha_hasta = $fecha_hasta[2]."-".$this->app_utilities->TraducirMesInversa($fecha_hasta[1])."-".$fecha_hasta[0];
			
			$grupos=$this->Generic_model->get("q","categorias_menu");
				
			if(count($grupos)){
				foreach($grupos as $grupo){
					$total_grupo=0;
					$platos=$this->Generic_model->get("q","platosxcategoria","*",array("id_categoria_menu"=>$grupo->id_categoria_menu),"","",array("platos"=>"platos.id_plato=platosxcategoria.id_plato"));
					if(count($platos)){
						foreach($platos as $plato){
							$wheres=array(
								"id_plato"=>$plato->id_plato,
								"DATE(fecha_venta) >="=>$fecha_desde,
								"DATE(fecha_venta) <="=>$fecha_hasta,
							);
							$pagos=$this->Generic_model->get("q","vproductosxventa","SUM(cant_vproducto * costo_vproducto) as Total",$wheres,"","",array("ventas"=>"ventas.id_venta=vproductosxventa.id_venta"),"","id_plato");
							if(count($pagos)){
								$plato->pagos=$pagos[0]->Total;
								$total_grupo+=$pagos[0]->Total;
							}else{
								$plato->pagos=0;
							}
						}
					}
					$grupo->total=$total_grupo;
					$grupo->platos=$platos;
				}
			}
			$graphicData["grupos"]=$grupos;
			if($this->input->get("tipo")==0){
				$this->load->view("reportes/graficos/grafico_grupos_barras_pdf",$graphicData);	
			}else{
				$this->load->view("reportes/graficos/grafico_grupos_pastel_pdf",$graphicData);
			}
		}
	
	function is_logged_in(){
		$session = $this->session->userdata('userInfo');
		$is_logged_in =$session['is_logged_in'];
		
		if(!isset($is_logged_in) || $is_logged_in !== 0){
			redirect(base_url("login"));
			die();
		}
	}
}