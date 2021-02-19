<?php
class Caja extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->caja=$this->get_caja("127.0.0.1");
		$this->session_ = $this->session->userdata('userInfo');
		$this->is_logged_in();
		$this->load->library('App_utilities');
	}
	/**/
	function transaccionesxcaja(){
		$UIDataModal["title"]='Transacciones';
		$UIDataModal["content_view"]="caja/caja_transacciones_view";
		$UIDataModal["classes"]="modal-custom";
		$UIDataModal["id"]="caja-transacciones-modal";
		$UIDataModal["mode"]=$this->input->get("mode");
		$UIDataModal["width"]=$this->input->get("width")*0.7;
		$UIDataModal["height"]=$this->input->get("height")*0.5;
		
		$UIDataModal['caja']=$this->caja;
		$UIDataModal['cortes']=$this->Generic_model->get("q","cortes");
		$UIDataModal['vendedores'] = $this->Generic_model->get("q","usuarios","*",array("id_usuario >" => 0)); 
		
		$this->load->view('templates/template_modal',$UIDataModal);
	}
		function cargar_ventas(){
			$columns=$this->input->get("columns");
			/*Search*/
			$search_data=$this->input->get("search");
			$where=array();
			$like=array();
			if(isset($search_data["doc"]) && $search_data["doc"]!=""){
				$where["documento_venta"]=$search_data["doc"];
			}
			if(isset($search_data["by"]) && isset($search_data["value"]) && $search_data["value"]!=""){
				switch($search_data["by"]){
					case "referencia":
						$refsearch=explode("-",$search_data["value"]);
						$ref=(isset($refsearch[1])?$refsearch[1]:$search_data["value"]);
						$where["id_venta"]=$ref;
					break;
					case "fecha":
						$where["DATE(fecha_venta)"]=date("Y-m-d",strtotime($search_data["value"]));
					break;
					case "vendedor":
						$where["id_cajero"]=$search_data["value"];
					break;
					case "cliente":
						$like["nombre_cliente"]=$search_data["value"];
					break;
					case "documento":
						$like["num_doc_venta"]=$search_data["value"];
					break;
				}
			}
			/*Order*/
			$order_data=$this->input->get("order");
			$order=array($columns[$order_data[0]["column"]]["name"]=>$order_data[0]["dir"]);
			/*Query*/
			$all_ventas=$this->Generic_model->get("q","ventas","count(*) as rows",$where,'',$like);
			$all_ventas=$all_ventas[0]->rows;
			$ventas=$this->Generic_model->get("q","ventas","id_venta as referencia,fecha_venta as fecha,vendedores.nombre_usuario as vendedor,nombre_cliente as cliente,CASE documento_venta WHEN 0 THEN 'Ninguno' WHEN 1 THEN 'Factura' WHEN 2 THEN 'CCF' WHEN 3 THEN 'Ticket' WHEN 4 THEN  'N. Remision' WHEN 5 THEN 'N. Envio' ELSE 'Desconocido' END as documento, num_doc_venta as numero, (subtotal_venta+iva_venta-retencion_venta+percepcion_venta+total_nosujeto_venta+total_exento_venta) as total, CASE estado_venta WHEN 0 THEN 'Activa' WHEN 1 THEN 'Inactiva' END as estado",$where,$order,$like,array("usuarios as vendedores"=>"vendedores.id_usuario=ventas.id_cajero,LEFT"),array($this->input->get("length")=>$this->input->get("start")));
			$ventas_data=array();
			if(count($ventas)>0){
				foreach($ventas as $venta){
					$ventas_data[]=array("V-".$venta->referencia,$this->app_utilities->fechaHoraElSalvador($venta->fecha,1),$venta->vendedor,$venta->cliente,$venta->documento,$venta->numero,$venta->total,'<span class=\'label '.($venta->estado=='Activa'?'label-info':'label-warning').'\'>'.$venta->estado.'</span>','<button class=\'btn btn-xs btn-primary ventas-table-view-btn\' data-id=\''.$venta->referencia.'\'>Ver</button>');
				}
			}
			$data=array(
				"draw"=>$this->input->get("draw"),
				"recordsTotal"=>$all_ventas,
				"recordsFiltered"=>$all_ventas,
				"data"=>$ventas_data
			);
			echo json_encode($data);	
		}
			function salida_detalles(){
				$UIDataModal["title"]="Detalles de salida por venta";
				$view="caja/caja_transacciones_detalles_venta_view";
				
				if(isset($view) && $view!=""){
					$UIDataModal["content_view"]=$view;
				}else{
					$UIDataModal["content_view"]="error_nodisponible_view";
				}
				//$UIDataModal['productos']=$productos;
				$UIDataModal["close_button"]=true;
				$UIDataModal["classes"]="modal-lg";
				$UIDataModal["id"]="inventario-nueva-entrada-modal";
				$this->load->view('templates/template_modal',$UIDataModal);
			}
		function cargar_devoluciones(){
			
		}
		function cargar_cortes(){
			
		}
		function cargar_cintas(){
			
		}
	
	function caja_cortes(){
		$UIDataModal["title"]='Cortes';
		$UIDataModal["content_view"]="caja/caja_cortes_view";
		$UIDataModal["classes"]="modal-md";
		$UIDataModal["id"]="caja-cortes-modal";
		$UIDataModal["mode"]=$this->input->get("mode");
		
		$UIDataModal['caja']=$this->caja;
		$UIDataModal['cortes']=$this->Generic_model->get("c","cortes");
		
		$this->load->view('templates/template_modal',$UIDataModal);
	}
		function makecorte(){
			$fecha=gmdate('Y-m-d H:i:s', strtotime('- 6 hours'));
			$getType=$this->input->get('tipo');
			$getRes=$this->input->get('serie');
			$getDotacion=$this->input->get('dotacion');
			$dotacion=0;
			$ticketInicioVenta="-";
			$ticketInicioDev="-";
			$ticketFinVenta="-";
			$ticketFinDev="-";
			
			/*Obtener resolucion*/
			if(is_numeric($getRes)){
				$resolucionTicket=$this->Generic_model->get("q","resoluciones_caja","*",array("id_resolucion"=>$getRes));
				$resolucionTicket=$resolucionTicket[0];
			}else{
				$resolucionTicket=null;
			}
			/*Obtener correlativo de ultimo corte*/
			$lastCorteCorrelativo=$this->Generic_model->get("q","cortes","correlativo_corte as correlativo",array("id_caja"=>$this->caja->id_caja),array("fecha_corte"=>"DESC"),"","",1);
			$lastCorteCorrelativo=$lastCorteCorrelativo[0];
			if(isset($lastCorteCorrelativo->correlativo)){
				$correlativo=$lastCorteCorrelativo->correlativo;
			}else{
				$correlativo=0;
			}
			
			/*Informacion de ultimo corte, dotacion y estado de caja*/
			if($getType==0){/*Corte X inicial*/
				$lastCorte=$this->Generic_model->get("q","cortes","fecha_corte as fecha",array("id_caja"=>$this->caja->id_caja,"tipo_corte"=>2),array("fecha_corte"=>"DESC"),"","",1);
				$dotacion=$getDotacion;
				if(count($lastCorte)){
					$lastCorte=$lastCorte[0];
					$lastCorte=$lastCorte->fecha;
				}else{
					$lastCorte="0000-00-00 00:00:00";
				}
				
				$cinta=$this->Generic_model->save("cintas",array("fecha_cinta"=>$fecha),true);
			
				/*Informacion de caja*/
				$dataCaja["estado_caja"]=1;
				$dataCaja["dotacion_caja"]=$getDotacion;
				$dataCaja["id_cinta"]=$cinta;
				$dataCaja["correlativo_cinta"]=1;
				$correlativo_cinta=1;
			}else if($getType==3){/*Z mensual*/
				$lastCorte=$this->Generic_model->get("q","cortes","fecha_corte as fecha",array("id_caja"=>$this->caja->id_caja,"tipo_corte"=>3),array("fecha_corte"=>"DESC"),"","",1);
				$lastCorte=$lastCorte[0];
				if(count($lastCorte)){
					$lastCorte=$lastCorte->fecha;
				}else{
					$lastCorte="2019-07-01 06:00:00";
				}
				$dataCaja["correlativo_cinta"]=$this->caja->correlativo_cinta+1;
				$correlativo_cinta=$this->caja->correlativo_cinta+1;
				$cinta=$this->caja->id_cinta;
			}else{/*Corte X Parcial y Z */
				$lastCorte=$this->Generic_model->get("q","cortes","fecha_corte as fecha",array("id_caja"=>$this->caja->id_caja,"tipo_corte"=>0),array("fecha_corte"=>"DESC"),"","",1);
				$lastCorte=$lastCorte[0]->fecha;
				if($getType==2){
					/*Caja*/
					$dataCaja["estado_caja"]=0;
				}
				$dataCaja["correlativo_cinta"]=$this->caja->correlativo_cinta+1;
				$correlativo_cinta=$this->caja->correlativo_cinta+1;
				$cinta=$this->caja->id_cinta;
			}
			/*Actualizar caja*/
				$this->Generic_model->update("cajas",$dataCaja,array("id_caja"=>$this->caja->id_caja));
			if(isset($dataCaja) && !empty($dataCaja)){
			}
			
			/*Obtener ventas*/
			$ventasSQL="(SELECT estado_venta as estado,servicio_venta as servicio,forma_pago_venta as medio,origen_venta as origen,documento_venta as documento,num_doc_venta as documento_numero,subtotal_venta as grabado,total_exento_venta as exento,total_nosujeto_venta as nosujeto,iva_venta as iva,propina_venta as propina,retencion_venta as retencion,percepcion_venta as percepcion,descuento_venta as descuento,((subtotal_venta+total_exento_venta+total_nosujeto_venta+iva_venta+propina_venta)-descuento_venta) as total FROM ventas WHERE id_caja = '".$this->caja->id_caja."' AND fecha_venta > '".$lastCorte."' AND (documento_venta = '0' OR documento_venta = '1' OR documento_venta = '2' OR documento_venta = '9') AND estado_venta=0 ORDER BY fecha_venta ASC)";
			$ventas=$this->Generic_model->sql_custom($ventasSQL);
			
			$usuarios = $this->Generic_model->get("q","usuarios");
			foreach($usuarios as $usuario){
				$total_ventas_usuario=$this->Generic_model->sql_custom("SELECT SUM((subtotal_venta+total_exento_venta+total_nosujeto_venta+iva_venta+propina_venta)-descuento_venta) as total FROM ventas WHERE id_caja = '".$this->caja->id_caja."' AND id_cajero = '".$usuario->id_usuario."' AND estado_venta = 0 AND fecha_venta > '".$lastCorte."' AND (documento_venta = '0' OR documento_venta = '1') ORDER BY fecha_venta ASC");
				$total_ventas_tickets_usuario=$this->Generic_model->sql_custom("SELECT *FROM ventas WHERE id_caja = '".$this->caja->id_caja."' AND id_cajero = '".$usuario->id_usuario."' AND estado_venta = 0 AND fecha_venta > '".$lastCorte."' AND (documento_venta = '0' OR documento_venta = '1') ORDER BY fecha_venta ASC");
				if(count($total_ventas_usuario)){
					$total_ventas_usuario=number_format($total_ventas_usuario[0]->total,2);
				}else{
					$total_ventas_usuario="0.00";
				}
				
				$usuario->ventas=$total_ventas_usuario;
				$usuario->total_ventas_tickets=count($total_ventas_tickets_usuario);
			}
			
			/*Obtener devoluciones*/
			$devolucionesSQL="(SELECT forma_pago_devolucion as medio, doc_devolucion as documento, num_doc_devolucion as documento_numero, retencion_devolucion as retencion,percepcion_devolucion as percepcion,descuento_devolucion as descuento,propina_devolucion as propina,((subtotal_devolucion + exento_devolucion + nosujeto_devolucion + iva_devolucion + propina_devolucion)-descuento_devolucion) as total FROM devoluciones WHERE id_caja = '".$this->caja->id_caja."' AND fecha_devolucion > '".$lastCorte."' AND doc_devolucion = '0' ORDER BY fecha_devolucion ASC)";
			$devoluciones=$this->Generic_model->sql_custom($devolucionesSQL);
			
			/*totales - corte fiscal*/
			$total_sdocumento_grabado=$total_sdocumento_exento=$total_sdocumento_nosujeto=0;
			$total_factura_grabado=$total_factura_exento=$total_factura_nosujeto=0;
			$total_ccf_grabado=$total_ccf_exento=$total_ccf_nosujeto=$total_ccf_percibido=$total_ccf_retenido=0;
			$total_ticket_grabado=$total_ticket_interno=$total_ticket_exento=$total_ticket_nosujeto=0;
			$total_nremision_grabado=$total_nremision_exento=$total_nremision_nosujeto=0;
			$total_nenvio_grabado=$total_nenvio_exento=$total_nenvio_nosujeto=0;
			$total_devolucion_sdocumento=$total_devolucion_factura=$total_devolucion_ccf=$total_devolucion_ticket=$total_devolucion_nremision=$total_devolucion_nenvio=$total_devolucion_ncredito=0;
			$total_trans_sdocumento=$total_trans_factura=$total_trans_ccf=$total_trans_ticket=$total_trans_ticket_dev=$total_trans_nremision=$total_trans_nenvio=$total_trans_ncredito=0;
			$ticketInicio=$ticketFin="-";
			$total_para_comer_aca=$total_para_llevar=$total_domicilio=$total_domicilio_a_pie=$total_domicilio_efectivo_cc=$total_domicilio_pos_cc=0;
			$total_ventas_efectivo=$total_ventas_pos=0;
			$propina=$propina_pos=0;
			$propina_declarada=$propina_declarada_pos=0;
			$total_ventas_efectivo_cc=$total_ventas_pos_cc=0;
			
			/*------- CALCULO DE TOTALES DE VENTA -------*/
			if(count($ventas)){
				foreach($ventas as $venta){
					$medio=unserialize($venta->medio);
				
					if(isset($medio[1])){
						if($venta->origen==1){
							$total_ventas_pos_cc+=($medio[1]-$venta->descuento);
						}else{
							$total_ventas_pos+=($medio[1]-$venta->descuento);
							$propina_pos+=$venta->propina;
							if(isset($medio[0])){
								$total_ventas_efectivo+=($medio[0]-$venta->descuento);
							}
						}
					}else{
						if($venta->origen==1){
							$total_ventas_efectivo_cc+=($medio[0]-$venta->descuento);
						}else{
							$total_ventas_efectivo+=($medio[0]-$venta->descuento);
							$propina+=$venta->propina;
						}
					}
					
					/*segun documento*/
					switch($venta->documento){
						case 0:/*Ticket*/
							/*Segun tipo venta*/
							$total_ticket_grabado+=$venta->grabado+$venta->percepcion-($venta->retencion+$venta->descuento);
							$total_ticket_exento+=$venta->exento;
							$total_ticket_nosujeto+=$venta->nosujeto;
							$total_trans_ticket++;
							/*primer ticket*/
							if($ticketInicio==="-"){
								$ticketInicio=$venta->documento_numero;
							}
							/*ultimo ticket*/
							$ticketFin=$venta->documento_numero;

							if(isset($medio[1])){
								$propina_declarada_pos+=$venta->propina;
							}else{
								$propina_declarada+=$venta->propina;
							}
						break;
						case 1:/*Factura*/
							/*Segun tipo venta*/
							$total_factura_grabado+=$venta->grabado+$venta->percepcion-($venta->retencion+$venta->descuento);
							$total_factura_exento+=$venta->exento;
							$total_factura_nosujeto+=$venta->nosujeto;
							$total_trans_factura++;
							if(isset($medio[1])){
								$propina_declarada_pos+=$venta->propina;
							}else{
								$propina_declarada+=$venta->propina;
							}
						break;
						case 2:/*CCF*/
							/*Segun tipo venta*/
							$total_ccf_grabado+=$venta->grabado+$venta->iva+$venta->percepcion-($venta->retencion+$venta->descuento);
							$total_ccf_exento+=$venta->exento;
							$total_ccf_nosujeto+=$venta->nosujeto;
							$total_trans_ccf++;
							if(isset($medio[1])){
								$propina_declarada_pos+=$venta->propina;
							}else{
								$propina_declarada+=$venta->propina;
							}
						break;
						case 9:/*Ninguno*/
							/*Segun tipo venta*/
							$total_sdocumento_grabado+=$venta->grabado+$venta->iva+$venta->percepcion-($venta->retencion+$venta->descuento);
							$total_sdocumento_exento+=$venta->exento;
							$total_sdocumento_nosujeto+=$venta->nosujeto;
							$total_trans_sdocumento++;
						break;
					}				
					
					if($venta->estado==0){
						switch($venta->servicio){
							case "Para comer aca":
								$total_para_comer_aca+=$venta->grabado+$venta->percepcion+$venta->propina-($venta->retencion+$venta->descuento);
							break;
							case "Para llevar":
								$total_para_llevar+=$venta->grabado+$venta->percepcion+$venta->propina-($venta->retencion+$venta->descuento);
							break;
							case "Domicilio":
								$total_domicilio+=$venta->grabado+$venta->percepcion+$venta->propina-($venta->retencion+$venta->descuento);
							break;
							case "Domicilio a pie":
								$total_domicilio_a_pie+=$venta->grabado+$venta->percepcion+$venta->propina-($venta->retencion+$venta->descuento);
							break;
						}						
					}
				}
			}
			
			/*--- CALCULO DE TOTALES DEVOLUCIONES ----*/
			if(count($devoluciones)>0){
				foreach($devoluciones as $devolucion){
					$propina-=$devolucion->propina;
					/*Segun documento*/
					switch($devolucion->documento){
						case 0:/*Ticket*/
							$total_devolucion_ticket+=($devolucion->total+$devolucion->percepcion-$devolucion->retencion);
							/*Transacciones con tickets*/
							$total_trans_ticket_dev++;
							/*Primer ticket*/
							if($devolucion->documento_numero < $ticketInicio){
								$ticketInicio=$devolucion->documento_numero;
							}
							/*Ultimo ticket*/
							if($devolucion->documento_numero > $ticketFin){
								$ticketFin=$devolucion->documento_numero;
							}
						break;
					}
				}
			}
			/*Ajuste para ticket inicio*/
			if($ticketInicio==="-"){
				$numero_ticket=$this->ufood_utilities->get_conf_value((object) array("ticket_correlativo"=>(object) array("db_campo"=>"ticket_correlativo","default"=>1)));
				$ticketInicio=$numero_ticket->ticket_correlativo->value;
			}
			
			$dataCorteFiscal=array(
				"total_sdocumento_grabado"=>$total_sdocumento_grabado,
				"total_sdocumento_exento"=>$total_sdocumento_exento,
				"total_sdocumento_nosujeto"=>$total_sdocumento_nosujeto,
				"total_factura_grabado"=>$total_factura_grabado,
				"total_factura_exento"=>$total_factura_exento,
				"total_factura_nosujeto"=>$total_factura_nosujeto,
				"total_ccf_grabado"=>$total_ccf_grabado,
				"total_ccf_exento"=>$total_ccf_exento,
				"total_ccf_nosujeto"=>$total_ccf_nosujeto,
				"total_ticket_grabado"=>$total_ticket_grabado,
				"total_ticket_interno"=>$total_ticket_interno,
				"total_ticket_exento"=>$total_ticket_exento,
				"total_ticket_nosujeto"=>$total_ticket_nosujeto,
				"total_nremision_grabado"=>$total_nremision_grabado,
				"total_nremision_exento"=>$total_nremision_exento,
				"total_nremision_nosujeto"=>$total_nremision_nosujeto,
				"total_nenvio_grabado"=>$total_nenvio_grabado,
				"total_nenvio_exento"=>$total_nenvio_exento,
				"total_nenvio_nosujeto"=>$total_nenvio_nosujeto,
				"total_devolucion_sdocumento"=>$total_devolucion_sdocumento,
				"total_devolucion_factura"=>$total_devolucion_factura,
				"total_devolucion_ccf"=>$total_devolucion_ccf,
				"total_devolucion_ticket"=>$total_devolucion_ticket,
				"total_devolucion_nremision"=>$total_devolucion_nremision,
				"total_devolucion_nenvio"=>$total_devolucion_nenvio,
				"total_devolucion_ncredito"=>$total_devolucion_ncredito,
				"total_trans_sdocumento"=>$total_trans_sdocumento,
				"total_trans_factura"=>$total_trans_factura,
				"total_trans_ccf"=>$total_trans_ccf,
				"total_trans_ticket"=>$total_trans_ticket,
				"total_trans_ticket_dev"=>$total_trans_ticket_dev,
				"ticketInicio"=>$ticketInicio,
				"ticketFin"=>$ticketFin,
				"total_trans_nremision"=>$total_trans_nremision,
				"total_trans_nenvio"=>$total_trans_nenvio,
				"total_trans_ncredito"=>$total_trans_ncredito,
				"total_ventas_efectivo"=>$total_ventas_efectivo,
				"total_ventas_pos"=>$total_ventas_pos,
				"total_ventas_efectivo_cc"=>$total_ventas_efectivo_cc,
				"total_ventas_pos_cc"=>$total_ventas_pos_cc,
				"total_propina"=>$propina,
				"total_propina_declarada"=>$propina_declarada,
				"total_propina_declarada_pos"=>$propina_declarada_pos,
				"total_propina_pos"=>$propina_pos,
				"dotacion"=>$this->caja->dotacion_caja
			);
			
			$platos=$this->Generic_model->get("q","platos","*",array("platosxcategoria.id_categoria_menu!="=>10),"","",array("platosxcategoria"=>"platosxcategoria.id_plato=platos.id_plato"),"","platos.id_plato");
			$platosh=$this->Generic_model->get("q","platos","*",array("platosxcategoria.id_categoria_menu"=>10),"","",array("platosxcategoria"=>"platosxcategoria.id_plato=platos.id_plato"),"","platos.id_plato");
			$ordenes=$this->Generic_model->get("q","ordenes","*",array("fecha_elimin_orden >"=>$lastCorte),"","",array("usuarios"=>"usuarios.id_usuario=ordenes.usuario_elimin_orden","mesas"=>"mesas.id_mesa=ordenes.id_mesa"));
			$dataCorteConsumoTxt="";
			$mensaje="";
			if($getType==2 || filter_var($this->input->get("email"),FILTER_VALIDATE_BOOLEAN)){
				if(count($platos)){
					$mensaje="";
					$mensaje.="Total ventas ".$this->app_utilities->fechaHoraElSalvador($fecha,1)."<strong> $ ".(($total_ccf_grabado+$total_factura_grabado+$total_ticket_grabado+$propina+$propina_pos)-$total_devolucion_ticket)."</strong><br><br>";
					$sendmail=false;
					$mensaje.="<strong>Detalle de platos (Ventas Locales):</strong><br>";
					
					/*Platos Locales En restaurante*/
					$mensaje.="<strong>En Restaurante:</strong><br>";
					$total_platos=0;
					$total_dinero_platos=0;
					foreach($platos as $plato){
						$transacciones="";
						$wheres=array(
							"id_plato"=>$plato->id_plato,
							"fecha_venta >"=>$lastCorte,
							"estado_venta"=>0,
							"origen_venta"=>0,
							"servicio_venta"=>"Para comer aca"
						);
						$transacciones=$this->Generic_model->get("q","vproductosxventa","SUM(cant_vproducto * costo_vproducto) as Total, SUM(cant_vproducto) as Platos",$wheres,"","",array("ventas"=>"ventas.id_venta=vproductosxventa.id_venta"));
						if(isset($transacciones)){
							$plato->pagos=$transacciones[0]->Total;
							$plato->platos=$transacciones[0]->Platos;
							$sendmail=true;
							if($plato->platos>0 AND $plato->pagos>0):
								$mensaje.=number_format($plato->platos,0)." ".$plato->nombre_plato." $ ".number_format($plato->pagos,2)."<br>";
								$total_platos+=number_format($plato->platos,0);
								$total_dinero_platos+=number_format($plato->pagos,2);
							endif;
						}
					}
					$mensaje.="<strong>Total platos en Restaurante:</strong> ".$total_platos.", $".($total_dinero_platos)."<br><br>";

					/*Platos Locales Para llevar*/
					$mensaje.="<strong>Para llevar:</strong><br>";
					$total_platos=0;
					$total_dinero_platos=0;
					foreach($platos as $plato){
						$transacciones="";
						$wheres=array(
							"id_plato"=>$plato->id_plato,
							"fecha_venta >"=>$lastCorte,
							"estado_venta"=>0,
							"origen_venta"=>0,
							"servicio_venta"=>"Para llevar"
						);
						$transacciones=$this->Generic_model->get("q","vproductosxventa","SUM(cant_vproducto * costo_vproducto) as Total, SUM(cant_vproducto) as Platos",$wheres,"","",array("ventas"=>"ventas.id_venta=vproductosxventa.id_venta"));
						if(isset($transacciones)){
							$plato->pagos=$transacciones[0]->Total;
							$plato->platos=$transacciones[0]->Platos;
							$sendmail=true;
							if($plato->platos>0 AND $plato->pagos>0):
								$mensaje.=number_format($plato->platos,0)." ".$plato->nombre_plato." $ ".number_format($plato->pagos,2)."<br>";
								$total_platos+=number_format($plato->platos,0);
								$total_dinero_platos+=number_format($plato->pagos,2);
							endif;
						}
					}
					$mensaje.="<strong>Total platos para llevar:</strong> ".$total_platos.", $".($total_dinero_platos)."<br><br>";

					/*Platos Locales domicilio*/
					$mensaje.="<strong>Domicilio:</strong><br>";
					$total_platos=0;
					$total_dinero_platos=0;
					foreach($platos as $plato){
						$transacciones="";
						$wheres=array(
							"id_plato"=>$plato->id_plato,
							"fecha_venta >"=>$lastCorte,
							"estado_venta"=>0,
							"origen_venta"=>0,
							"servicio_venta"=>"Domicilio"
						);
						$transacciones=$this->Generic_model->get("q","vproductosxventa","SUM(cant_vproducto * costo_vproducto) as Total, SUM(cant_vproducto) as Platos",$wheres,"","",array("ventas"=>"ventas.id_venta=vproductosxventa.id_venta"));
						if(isset($transacciones)){
							$plato->pagos=$transacciones[0]->Total;
							$plato->platos=$transacciones[0]->Platos;
							$sendmail=true;
							if($plato->platos>0 AND $plato->pagos>0):
								$mensaje.=number_format($plato->platos,0)." ".$plato->nombre_plato." $ ".number_format($plato->pagos,2)."<br>";
								$total_platos+=number_format($plato->platos,0);
								$total_dinero_platos+=number_format($plato->pagos,2);
							endif;
						}
					}
					$mensaje.="<strong>Total platos Domicilio:</strong> ".$total_platos.", $".($total_dinero_platos)."<br><br>";

					/*Platos Call Center*/
					$mensaje.="<strong>Detalle de platos (Ventas desde Call Center):</strong><br>";
					$total_platos=0;
					$total_dinero_platos=0;
					foreach($platos as $plato){
						$transacciones="";
						$wheres=array(
							"id_plato"=>$plato->id_plato,
							"fecha_venta >"=>$lastCorte,
							"estado_venta"=>0,
							"origen_venta"=>1
						);
						$transacciones=$this->Generic_model->get("q","vproductosxventa","SUM(cant_vproducto * costo_vproducto) as Total, SUM(cant_vproducto) as Platos",$wheres,"","",array("ventas"=>"ventas.id_venta=vproductosxventa.id_venta"));
						if(isset($transacciones)){
							$plato->pagos=$transacciones[0]->Total;
							$plato->platos=$transacciones[0]->Platos;
							$sendmail=true;
							if($plato->platos>0 AND $plato->pagos>0):
								$mensaje.=number_format($plato->platos,0)." ".$plato->nombre_plato." $ ".number_format($plato->pagos,2)."<br>";
								$total_platos+=number_format($plato->platos,0);
								$total_dinero_platos+=number_format($plato->pagos,2);
							endif;
						}
					}
					$mensaje.="<strong>Total platos:</strong> ".$total_platos.", $".($total_ventas_efectivo_cc+$total_ventas_pos_cc)."<br>";
					
					/*Promocion*/
					$promo=0;
					$dias = array("domingo","lunes","martes","miercoles","jueves","viernes","sabado");
					if($dias[date("w")]=="martes" || $dias[date("w")]=="jueves" && $promo==1):
						$mensaje.="<br><strong>Detalle de platos promocionales:</strong><br>";
						$total_platos=0;
						$total_dinero_platos=0;
						foreach($platos as $plato){
							$transacciones="";
							$wheres=array(
								"id_plato"=>$plato->id_plato,
								"fecha_venta >"=>$lastCorte,
								"estado_venta"=>0,
								"promo_vproducto"=>1,
							);
							$transacciones=$this->Generic_model->get("q","vproductosxventa","SUM(cant_vproducto * costo_vproducto) as Total, SUM(cant_vproducto) as Platos",$wheres,"","",array("ventas"=>"ventas.id_venta=vproductosxventa.id_venta"));
							if(isset($transacciones)){
								$plato->pagos=$transacciones[0]->Total;
								$plato->platos=$transacciones[0]->Platos;
								$sendmail=true;
								if($plato->platos>0 AND $plato->pagos>0):
									$mensaje.=number_format($plato->platos,0)." ".$plato->nombre_plato." $ ".number_format($plato->pagos,2)."<br>";
									$total_platos+=number_format($plato->platos,0);
									$total_dinero_platos+=number_format($plato->pagos,2);
								endif;
							}
						}
						$mensaje.="<strong>Total platos:</strong> ".$total_platos.", $".$total_dinero_platos."<br>";
					endif;
					
					/*Total segun tipo de servicio*/
					$mensaje.="<br><strong>Totales segun Servicio</strong><br>";
					$mensaje.="Para comer aca: $".$total_para_comer_aca."<br>";
					$mensaje.="Para llevar: $".$total_para_llevar."<br>";
					$mensaje.="Total Domicilio: $".$total_domicilio."<br>";
					$mensaje.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Domicilio Local: $".($total_domicilio - ($total_ventas_pos_cc+$total_ventas_efectivo_cc))."<br>";
					$mensaje.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Domicilio CC Efectivo: $".$total_ventas_efectivo_cc."<br>";
					$mensaje.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Domicilio CC POS: $".$total_ventas_pos_cc."<br>";
					$mensaje.="Domicilio a pie: $".$total_domicilio_a_pie."<br>";
					
					/*Total segun medio de pago*/
					$mensaje.="<br><strong>Totales segun Medio de Pago</strong><br>";
					$mensaje.="Efectivo: $".$total_ventas_efectivo."<br>";
					$mensaje.="Efectivo CC: $".$total_ventas_efectivo_cc."<br>";
					$mensaje.="POS: $".$total_ventas_pos."<br>";
					$mensaje.="POS CC: $".$total_ventas_pos_cc."<br>";
					
					/*Total segun medio de pago*/
					$mensaje.="<br><strong>Totales segun Medio de Pago con desgloce de Propina</strong><br>";
					$mensaje.="Efectivo: $".number_format($total_ventas_efectivo-$propina,2)."<br>";
					$mensaje.="POS: $".number_format($total_ventas_pos-$propina_pos,2)."<br>";
					$mensaje.="Propina Efectivo: $".number_format($propina,2)."<br>";
					$mensaje.="Propina POS: $".number_format($propina_pos,2)."<br>";
					
					/*Devoluciones*/
					$mensaje.="<br><strong>Devoluciones</strong><br>";
					$mensaje.="Devoluciones: ".$total_trans_ticket_dev."<br>";
					$mensaje.="Total Devoluciones: $".$total_devolucion_ticket."<br>";
					
					/*Tiraje*/
					$mensaje.="<br><strong>Tiraje de Ventas Tickets</strong><br>";
					$mensaje.="Transacciones con Tickets: ".$total_trans_ticket."<br>";
					$mensaje.="Inicio: ".$ticketInicio."<br>";
					$mensaje.="Final: ".$ticketFin."<br>";
					
					/*Otros docs*/
					$mensaje.="<br><strong>Transacciones con otros documentos</strong><br>";
					$mensaje.="Transacciones con Facturas: ".$total_trans_factura."<br>";
					$mensaje.="Transacciones con CCF: ".$total_trans_ccf."<br>";
					
					/*Segun Vendedor*/
					$mensaje.="<br><strong>Totales segun Cajero</strong>";
					foreach($usuarios as $usuario){
						if($usuario->ventas>0){
							$mensaje.="<br><strong>".$usuario->nombre_usuario."</strong><br>";
							$mensaje.="Total en Ventas $".$usuario->ventas."<br>";
							$mensaje.="Transacciones realizadas: ".$usuario->total_ventas_tickets."<br>";
						}
					}
					
					/*Consumo de Empleados*/
					$wheres=array(
						"fecha_consumo >"=>$lastCorte,
						"estado_consumo"=>0,
					);
					$consumos=$this->Generic_model->get("q","consumos","*",$wheres,"","",array("empleados"=>"empleados.id_empleado=consumos.id_empleado"));
					
					if(count($consumos)):
						$total_prestacion=0;
						$mensaje.="<br><strong>Detalle de Prestacion Alimenticia:</strong>";
						foreach($consumos as $consumo):
							$mensaje.="<br><strong>".$consumo->nombre_empleado."</strong><br>";
							$mensaje.="Consumo $".number_format($consumo->subtotal_consumo,2)."<br>";
							$mensaje.="Platos:<br>";
							$platosxconsumo=$this->Generic_model->get("q","cproductosxconsumo","*",array("id_consumo"=>$consumo->id_consumo),"","",array("platos"=>"platos.id_plato=cproductosxconsumo.id_plato"));
							$consumo->platos=$platosxconsumo;
							foreach($platosxconsumo as $platoxc):
								$mensaje.=number_format($platoxc->cant_cproducto,0)." ".$platoxc->nombre_plato."<br>";
							endforeach;
							$total_prestacion+=$consumo->subtotal_consumo;
							$dataCorteConsumoTxt.=$consumo->nombre_empleado." $".$consumo->subtotal_consumo."|";
						endforeach;
						$mensaje.="<br>Total Prestacion Alimenticia: <strong>$".number_format($total_prestacion,2)."</strong>";
					endif;
				}
				
				$total_dinero_platosh=0;
				if(count($platosh)){
					$mensaje.="<br><br><strong>Detalle de platos HUGO:</strong><br>";
					$total_platosh=0;
					foreach($platosh as $plato){
						$transacciones="";
						$wheres=array(
							"id_plato"=>$plato->id_plato,
							"fecha_venta >"=>$lastCorte,
							"estado_venta"=>0
						);
						$transacciones=$this->Generic_model->get("q","vproductosxventa","SUM(cant_vproducto * costo_vproducto) as Total, SUM(cant_vproducto) as Platos",$wheres,"","",array("ventas"=>"ventas.id_venta=vproductosxventa.id_venta"));
						if(isset($transacciones)){
							$plato->pagos=$transacciones[0]->Total;
							$plato->platos=$transacciones[0]->Platos;
							$sendmail=true;
							if($plato->platos>0 AND $plato->pagos>0):
								$mensaje.=number_format($plato->platos,0)." ".$plato->nombre_plato." $ ".number_format($plato->pagos,2)."<br>";
								$total_platosh+=number_format($plato->platos,0);
								$total_dinero_platosh+=number_format($plato->pagos,2);
							endif;
						}
					}
					$mensaje.="<strong>Total platos HUGO:</strong> ".$total_platosh.", $".($total_dinero_platosh)."<br>";
				}
				if(count($ordenes)){
					$mensaje.="<br><br><strong>Detalle de Ordenes Eliminadas:</strong><br>";
					$mensaje.="<table border='1' cellspacing='0'><thead><tr><th>Cliente</th><th>Mesa</th><th>Usuario</th><th>Motivo</th><th>Total</th></tr></thead><tbody>";
					foreach($ordenes as $orden):
						$mensaje.="<tr><td>".$orden->cliente_orden."</td><td>".$orden->nombre_mesa."</td><td>".$orden->nombre_usuario."</td><td></td><td>$".number_format(($orden->sub_total_orden+$orden->propina_orden),2)."</td></tr>";
					endforeach;
					$mensaje.="</tbody></table>";
				}	
				
				if($sendmail && filter_var($this->input->get("email"),FILTER_VALIDATE_BOOLEAN)){
					$nombre_ubicacion_empresa=$this->ufood_utilities->get_conf_value((object) array("nombre_ubicacion_empresa"=>(object) array("db_campo"=>"nombre_ubicacion_empresa","default"=>"")));
					//$this->app_utilities->send($mensaje,$getType,$nombre_ubicacion_empresa->nombre_ubicacion_empresa->value);
				}
			}else{
				$total_dinero_platosh=0;
				/*Consumo de Empleados*/
				$wheres=array(
					"fecha_consumo >"=>$lastCorte,
					"estado_consumo"=>0,
				);
				$consumos=$this->Generic_model->get("q","consumos","*",$wheres,"","",array("empleados"=>"empleados.id_empleado=consumos.id_empleado"));
				
				if(count($consumos)):
					$total_prestacion=0;
					$mensaje.="<br><strong>Detalle de Prestacion Alimenticia:</strong>";
					foreach($consumos as $consumo):
						$mensaje.="<br><strong>".$consumo->nombre_empleado."</strong><br>";
						$mensaje.="Consumo $".number_format($consumo->subtotal_consumo,2)."<br>";
						$mensaje.="Platos:<br>";
						$platosxconsumo=$this->Generic_model->get("q","cproductosxconsumo","*",array("id_consumo"=>$consumo->id_consumo),"","",array("platos"=>"platos.id_plato=cproductosxconsumo.id_plato"));
						$consumo->platos=$platosxconsumo;
						foreach($platosxconsumo as $platoxc):
							$mensaje.=number_format($platoxc->cant_cproducto,0)." ".$platoxc->nombre_plato."<br>";
						endforeach;
						$total_prestacion+=$consumo->subtotal_consumo;
						$dataCorteConsumoTxt.=$consumo->nombre_empleado." $".$consumo->subtotal_consumo."|";
					endforeach;
					$mensaje.="<br>Total Prestacion Alimenticia: <strong>$".number_format($total_prestacion,2)."</strong>";
				endif;
				
				$total_dinero_platosh=0;
				if(count($platosh)){
					$mensaje.="<br><strong>Detalle de platos HUGO:</strong><br>";
					$total_platosh=0;
					foreach($platosh as $plato){
						$transacciones="";
						$wheres=array(
							"id_plato"=>$plato->id_plato,
							"fecha_venta >"=>$lastCorte,
							"estado_venta"=>0
						);
						$transacciones=$this->Generic_model->get("q","vproductosxventa","SUM(cant_vproducto * costo_vproducto) as Total, SUM(cant_vproducto) as Platos",$wheres,"","",array("ventas"=>"ventas.id_venta=vproductosxventa.id_venta"));
						if(isset($transacciones)){
							$plato->pagos=$transacciones[0]->Total;
							$plato->platos=$transacciones[0]->Platos;
							$sendmail=true;
							if($plato->platos>0 AND $plato->pagos>0):
								$mensaje.=number_format($plato->platos,0)." ".$plato->nombre_plato." $ ".number_format($plato->pagos,2)."<br>";
								$total_platosh+=number_format($plato->platos,0);
								$total_dinero_platosh+=number_format($plato->pagos,2);
							endif;
						}
					}
					$mensaje.="<strong>Total platos HUGO:</strong> ".$total_platosh.", $".($total_dinero_platosh)."<br>";
				}	
			}
			
			$dataCorteFiscal['total_hugo']=$total_dinero_platosh;

			$dataCorte['id_caja']=$this->caja->id_caja;
			$dataCorte['id_usuario']=$this->session_['userid'];
			$dataCorte['fecha_corte']=$fecha;
			$dataCorte['correlativo_corte']=$correlativo+1;
			$dataCorte['tipo_corte']=$getType;
			$dataCorte['id_serie']=null;
			$dataCorte['corte1_corte']=serialize($dataCorteFiscal);
			$dataCorte['corte2_corte']=null;
			$dataCorte['corte3_corte']=$mensaje;
			$dataCorte['corte4_corte']=null;
			$dataCorte['corte5_corte']=null;
			$dataCorte['id_cinta']=$cinta;
			
			if(count($consumos)){
				$dataCorte['corte2_corte']=serialize($dataCorteConsumoTxt);				
			}else{
				$dataCorte['corte2_corte']=null;
			}
			
			$corte=$this->Generic_model->save("cortes",$dataCorte,true);
			
			$this->Generic_model->save("trans_cinta",array("id_cinta"=>$cinta,"id_corte"=>$corte,"correlativo_cinta"=>$correlativo_cinta));
			
			$this->load->view("caja/caja_cortes_detalles_view",array("id_corte"=>$corte,"corteFiscal"=>$dataCorteFiscal,"mensajeCorreo"=>$mensaje));
		}
		function print_corte(){
			$corte=$this->Generic_model->get("q","cortes","*",array("id_corte"=>$this->input->get("id")),"","",array("usuarios"=>"usuarios.id_usuario=cortes.id_usuario,LEFT OUTER","cajas"=>"cajas.id_caja=cortes.id_corte,LEFT"));
			$corte=$corte[0];
			
			/*--- Obtener configuraciones ---*/
			$nombre_empresa=$this->ufood_utilities->get_conf_value((object) array("gral_info_nombre_empresa"=>(object) array("db_campo"=>"gral_info_nombre_empresa","default"=>"")));
			$rsocial_empresa=$this->ufood_utilities->get_conf_value((object) array("gral_info_propietario_empresa"=>(object) array("db_campo"=>"gral_info_propietario_empresa","default"=>"")));
			$direcion_empresa=$this->ufood_utilities->get_conf_value((object) array("gral_info_direccion_empresa"=>(object) array("db_campo"=>"gral_info_direccion_empresa","default"=>"")));
			$nit_empresa=$this->ufood_utilities->get_conf_value((object) array("gral_info_nit_empresa"=>(object) array("db_campo"=>"gral_info_nit_empresa","default"=>"")));
			$nrc_empresa=$this->ufood_utilities->get_conf_value((object) array("gral_info_nrc_empresa"=>(object) array("db_campo"=>"gral_info_nrc_empresa","default"=>"")));
			
			$dataPrint['nombre_empresa']=$nombre_empresa->gral_info_nombre_empresa->value;
			$dataPrint['rsocial_empresa']=$rsocial_empresa->gral_info_propietario_empresa->value;
			$dataPrint['direcion_empresa']=$direcion_empresa->gral_info_direccion_empresa->value;
			$dataPrint['nit_empresa']=$nit_empresa->gral_info_nit_empresa->value;
			$dataPrint['nrc_empresa']=$nrc_empresa->gral_info_nrc_empresa->value;
			
			$dataPrint['tipo_corte']=($corte->tipo_corte==0?"X":($corte->tipo_corte==1?"X PARCIAL":($corte->tipo_corte==2?"Z":($corte->tipo_corte==3?"Z MENSUAL":""))));
			$dataPrint['numero_corte']=$corte->correlativo_corte;
			$dataPrint['tipo']=$corte->tipo_corte;
			$dataPrint['caja']=$corte->nombre_caja;
			$dataPrint['cajero']=$corte->nombre_usuario;
			$dataPrint['fecha']=$corte->fecha_corte;
			$dataPrint['dotacion']=$this->caja->dotacion_caja;
			
			$dataPrint['doc_desde']="1";
			$dataPrint['doc_hasta']="100000";
			$dataPrint['doc_resolucion']="15012-RES-CR-33172-2019";
			$dataPrint['doc_autorizacion']="AMR-15041-023908-2019";
			
			$dataPrint['dataCorteFiscal']=unserialize($corte->corte1_corte);
			$dataPrint['dataCorteConsumo']=unserialize($corte->corte2_corte);
			$dataPrint['printCorteFiscal']=filter_var($this->input->get("corte"),FILTER_VALIDATE_BOOLEAN);
			
			$this->load->view("impresos/corte_view",$dataPrint);
		}
		function exportar_corte(){
			$this->load->view('reportes/pdf/reporte_corte_pdf');
		}
		function cinta(){
			$UIDataModal["title"]='Cinta de Auditoria';
			$UIDataModal["content_view"]="caja/caja_cortes_cinta_view";
			$UIDataModal["classes"]="modal-md";
			$UIDataModal["id"]="caja-cortes-cinta-modal";
			
			$corte=$this->Generic_model->get("q","cortes","*",array("id_corte"=>$this->input->get("id")),"","",array("usuarios"=>"usuarios.id_usuario=cortes.id_usuario,LEFT OUTER","cajas"=>"cajas.id_caja=cortes.id_caja"));
			$corte=$corte[0];
			
			$UIDataModal["max_item"]=400;
			$UIDataModal["items"]=$corte->correlativo_cinta;
			$UIDataModal["cinta"]=$corte->id_cinta;
			
			$this->load->view('templates/template_modal',$UIDataModal);
		}
		function printcinta(){
			$cinta=$this->input->get("id");
			$rollo=$this->input->get("rollo");
			$max_item=400;
			
			$inicio=($rollo*$max_item)-$max_item;
			$fin=$rollo*$max_item;
			
			//echo "Inicio: ".$inicio.", Fin: ".$fin;
			
			$trans_cinta=$this->Generic_model->get("q","trans_cinta","*",array("id_cinta"=>$cinta,"correlativo_cinta >"=>$inicio,"correlativo_cinta <="=>$fin),array("correlativo_cinta"=>"ASC"));
			
			$nombre_empresa=$this->ufood_utilities->get_conf_value((object) array("gral_info_nombre_empresa"=>(object) array("db_campo"=>"gral_info_nombre_empresa","default"=>"")));
			$rsocial_empresa=$this->ufood_utilities->get_conf_value((object) array("gral_info_propietario_empresa"=>(object) array("db_campo"=>"gral_info_propietario_empresa","default"=>"")));
			$direcion_empresa=$this->ufood_utilities->get_conf_value((object) array("gral_info_direccion_empresa"=>(object) array("db_campo"=>"gral_info_direccion_empresa","default"=>"")));
			$nit_empresa=$this->ufood_utilities->get_conf_value((object) array("gral_info_nit_empresa"=>(object) array("db_campo"=>"gral_info_nit_empresa","default"=>"")));
			$nrc_empresa=$this->ufood_utilities->get_conf_value((object) array("gral_info_nrc_empresa"=>(object) array("db_campo"=>"gral_info_nrc_empresa","default"=>"")));
			
			$dataPrint['nombre_empresa']=$nombre_empresa->gral_info_nombre_empresa->value;
			$dataPrint['rsocial_empresa']=$rsocial_empresa->gral_info_propietario_empresa->value;
			$dataPrint['direcion_empresa']=$direcion_empresa->gral_info_direccion_empresa->value;
			$dataPrint['nit_empresa']=$nit_empresa->gral_info_nit_empresa->value;
			$dataPrint['nrc_empresa']=$nrc_empresa->gral_info_nrc_empresa->value;

			$dataPrint['doc_desde']="1";
			$dataPrint['doc_hasta']="100000";
			$dataPrint['doc_resolucion']="15012-RES-CR-33172-2019";
			$dataPrint['doc_autorizacion']="AMR-15041-023908-2019";
			$dataPrint['mensaje_ticket']="Gracias por preferirnos, te esperamos pronto";	
			
			foreach($trans_cinta as $transaccion):
				if(!is_null($transaccion->id_corte)):
					$corte=$this->Generic_model->get("q","cortes","*",array("id_corte"=>$transaccion->id_corte),"","",array("usuarios"=>"usuarios.id_usuario=cortes.id_usuario,LEFT OUTER","cajas"=>"cajas.id_caja=cortes.id_corte,LEFT"));
					$transaccion->corte=$corte[0];
					$transaccion->dataCorteFiscal=unserialize($corte[0]->corte1_corte);
					$transaccion->tipo="Corte";
				endif;
				if(!is_null($transaccion->id_venta)):
					$venta=$this->Generic_model->get("q","ventas","*",array("id_venta"=>$transaccion->id_venta),"","",array("usuarios"=>"usuarios.id_usuario=ventas.id_cajero,LEFT OUTER","cajas"=>"cajas.id_caja=ventas.id_caja,LEFT"));
					$transaccion->venta=$venta[0];
					$transaccion->productos=$this->Generic_model->get("q","vproductosxventa","*",array("id_venta"=>$transaccion->id_venta),"","",array("platos"=>"platos.id_plato=vproductosxventa.id_plato"));
					$transaccion->tipo="Venta";
				endif;
				if(!is_null($transaccion->id_devolucion)):
					$devolucion=$this->Generic_model->get("q","devoluciones","*",array("id_devolucion"=>$transaccion->id_devolucion));
					$transaccion->devolucion=$devolucion[0];
					$transaccion->productos=$this->Generic_model->get("q","vproductosxdevolucion","*",array("id_devolucion"=>$transaccion->id_devolucion),"","",array("platos"=>"platos.id_plato=vproductosxdevolucion.id_plato"));
					$transaccion->tipo="Devolucion";
				endif;
			endforeach;
			
			/* echo "<pre>";
				print_r($trans_cinta);
			echo "</pre>"; */
			
			$dataPrint["trans_cinta"]=$trans_cinta;
			
			$this->load->view("impresos/cinta_view",$dataPrint);
		}
	
	function caja_devoluciones(){
		if(!$this->caja){/*Validacion de caja*/
			$UIDataModal["content_view"]="errores/error_nocaja_view";
			$UIDataWindow["title"]="Error: Caja desconocida";
		}else{
			if($this->caja->estado_caja==0){/*Validacion de estado de caja*/
				$UIDataModal["content_view"]="errores/error_caja_inactiva_view";
				$UIDataModal["title"]="Error: Caja inactiva";
			}else{
				$UIDataModal["title"]='Devoluciones';
				$UIDataModal["content_view"]="caja/caja_devoluciones_view";
				$UIDataModal["classes"]="modal-xl";
				$UIDataModal["id"]="caja-devoluciones-modal";
				$UIDataModal["mode"]=$this->input->get("mode");
			}
		}
		
		$this->load->view('templates/template_modal',$UIDataModal);
	}
	
	function get_caja($ip){
		$caja=$this->Generic_model->get("q","cajas","*",array("dir_ip_caja"=>$ip));
		if(count($caja)>0)
			return $caja[0];
		else
			return null;
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
?>