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
		function reporte_consumos(){
			$reportData['configs'] = $this->configs;
			$reportData['fecha_desde'] = $this->input->get("fechadesde");
			$reportData['fecha_hasta'] = $this->input->get("fechahasta");
			$reportData['cero'] = filter_var($this->input->get("cero"),FILTER_VALIDATE_BOOLEAN);
			$reportData['empleados'] = filter_var($this->input->get("empleados"),FILTER_VALIDATE_BOOLEAN);
			
			$fecha_desde = explode(" ",$this->input->get("fechadesde"));
			$fecha_hasta = explode(" ",$this->input->get("fechahasta"));
			$fecha_desde = $fecha_desde[2]."-".$this->app_utilities->TraducirMesInversa($fecha_desde[1])."-".$fecha_desde[0];				
			$fecha_hasta = $fecha_hasta[2]."-".$this->app_utilities->TraducirMesInversa($fecha_hasta[1])."-".$fecha_hasta[0];

			/*--- Obtener configuraciones ---*/
			$nombre_empresa=$this->ufood_utilities->get_conf_value((object) array("nombre_ubicacion_empresa"=>(object) array("db_campo"=>"nombre_ubicacion_empresa","default"=>"")));
			$consumo_empresa=$this->ufood_utilities->get_conf_value((object) array("maximo_consumo_empleado"=>(object) array("db_campo"=>"maximo_consumo_empleado","default"=>"3.49")));
			
			$begin = new DateTime($fecha_desde.' 00:00:00');
			$end = new DateTime($fecha_hasta.' 23:59:59');

			$interval = DateInterval::createFromDateString('1 day');
			$period = new DatePeriod($begin, $interval, $end);
			
			$variable = <<<XYZ
<style>
table,h2 {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
</style>
XYZ;
echo $variable;
$html="";
$consumos = array();
$count=0;

			$html.= "<h2>Consumos China In ".$nombre_empresa->nombre_ubicacion_empresa->value."</h2>";
			$html.= "<table><thead><tr><th>Fecha</th><th>Consumo</th></tr></thead><tbody>";
			$total=0;
			foreach ($period as $dt) {
				$inicio=$this->Generic_model->get("q","consumos","SUM(IF(subtotal_consumo>3.85, '3.85', subtotal_consumo)) as total",array("date(fecha_consumo)"=>$dt->format("Y-m-d"),"estado_consumo"=>0),array("fecha_consumo"=>"ASC"),"","",1);
				$inicio=$inicio[0];
				
				if(isset($inicio)){
					$total+=number_format($inicio->total,2);
					$empleados=$this->Generic_model->get("q","consumos","subtotal_consumo,nombre_empleado as empleado",array("date(fecha_consumo)"=>$dt->format("Y-m-d"),"estado_consumo"=>0),array("fecha_consumo"=>"ASC"));
					if($inicio->total > 0){
						$html.= "<tr style='font-weight:bold;'><td>".$this->app_utilities->fechaHoraElSalvador($dt->format("Y-m-d"),1)."</td><td>$ ".number_format($inicio->total,2)."</td></tr>";
						$consumos[$count] = array(
							"dia" => $this->app_utilities->fechaHoraElSalvador($dt->format("Y-m-d"),1),
							"total_dia" => number_format($inicio->total,2),
						);
						if($reportData['empleados']){
							$empleados_ = array();
							foreach($empleados as $empleado):
								$html.= "<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$empleado->empleado."</td><td>$ ".(($empleado->subtotal_consumo > $consumo_empresa->maximo_consumo_empleado->value)?number_format($consumo_empresa->maximo_consumo_empleado->value,2)." (".number_format($empleado->subtotal_consumo,2).")":number_format($empleado->subtotal_consumo,2))."</td></tr>";
								$empleados_[] = array(
									"empleado" => $empleado->empleado,
									"total_empleado"=> (($empleado->subtotal_consumo > $consumo_empresa->maximo_consumo_empleado->value)?number_format($consumo_empresa->maximo_consumo_empleado->value,2)." (".number_format($empleado->subtotal_consumo,2).")":number_format($empleado->subtotal_consumo,2))
								);
							endforeach;
							$consumos[$count]["empleados"]=$empleados_;
						}
					}else{
						if($reportData['cero']){
							$html.= "<tr style='font-weight:bold;><td>".$this->app_utilities->fechaHoraElSalvador($dt->format("Y-m-d"),1)."</td><td>--</td></tr>";
						}
					}
				}else{
					$html.= "<tr style='font-weight:bold;><td>".$this->app_utilities->fechaHoraElSalvador($dt->format("Y-m-d"),1)."</td><td>--</td></tr>";
				}
				$count++;
			}
			$html.= "<tfoot style='font-weight:bold;'><tr><td>Total</td><td>$ ".$total."</td></tr></tfoot>";
			$html.= "</tbody></table>";

			if($this->input->get("tipo")=="excel"){
				/* foreach($consumos as $key => $value):
					echo $value["dia"]." $".$value["total_dia"]."<br>";
					foreach($value["empleados"] as $employ):
						echo $employ["empleado"]." $".$employ["total_empleado"]."<br>";
					endforeach;
				endforeach; */
				$reportData["consumos"] = $consumos;
				$reportData["total"] = $total;
				$this->load->view('reportes/reportes/reporte_consumos_excel',$reportData);
			}else{
				echo $html;
			}
			
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