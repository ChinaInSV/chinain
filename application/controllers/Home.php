<?php
class Home extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->caja=$this->get_caja("127.0.0.1");
		$this->session_ = $this->session->userdata('userInfo');
		$this->is_logged_in();
	}
	/**/
	function index(){
		$UIData['js_files']=array(
			'footer'=>array(
				'chinain/chinain.home_view',
				'chinain/chinain.home_ordenes_view',
				'chinain/chinain.home_ordenes_callcenter_view',
				'chinain/ufood.ordenes_nueva_view',
				'chinain/ufood.caja_facturacion_cobrar_view',
				'chinain/ufood.caja_cortes_view',
				'chinain/chinain.home_devolucion_view',
				'chinain/chinain.reportes_view',
				'chinain/chinain.caja_transacciones_view',
				'chinain/chinain.caja_transacciones_detalles_view',
			)
		);
		$UIData['plugins_files']=array(
			array("name"=>"bootstrap-datepicker","files"=>array(
					array("file"=>"bootstrap-datepicker","type"=>"js","place"=>"footer"),
					array("file"=>"locales/bootstrap-datepicker.es.min","type"=>"js","place"=>"footer"),
					array("file"=>"bootstrap-datepicker.min","type"=>"css","place"=>"header")
				)
			),				
			array("name"=>"daterangepicker","files"=>array(
					array("file"=>"css/daterangepicker","type"=>"css","place"=>"header"),
					array("file"=>"js/moment.min","type"=>"js","place"=>"header"),
					array("file"=>"js/daterangepicker","type"=>"js","place"=>"header")
				)
			),
			array("name"=>"highcharts","files"=>array(
					array("file"=>"js/highcharts","type"=>"js","place"=>"footer"),
					array("file"=>"js/exporting","type"=>"js","place"=>"footer"),
					array("file"=>"js/data","type"=>"js","place"=>"footer"),
					array("file"=>"js/drilldown","type"=>"js","place"=>"footer")
				)
			),
			array("name"=>"fooTable","files"=>array(
					array("file"=>"footable.min","type"=>"js","place"=>"footer"),
					array("file"=>"footable.bootstrap.min","type"=>"css","place"=>"header")
				)
			),
		);
		
		$UIData['section_title']="Inicio";
		$UIData['main_view']="home/home_view";
		
		$this->load->view('templates/template', $UIData);
	}
	/*Temp*/
	function moviltemp(){
		$UIData['js_files']=array(
			'footer'=>array(
				'chinain/chinain.homemovil_view',
				'chinain/ufood.ordenes_nueva_view',
				'chinain/ufood.caja_facturacion_cobrar_view',
				'chinain/ufood.caja_cortes_view',
				'chinain/chinain.home_devolucion_view',
				'chinain/chinain.reportes_view',
				'chinain/chinain.caja_transacciones_view',
				'chinain/chinain.caja_transacciones_detalles_view',
			)
		);
		$UIData['plugins_files']=array(
			array("name"=>"bootstrap-datepicker","files"=>array(
					array("file"=>"bootstrap-datepicker","type"=>"js","place"=>"footer"),
					array("file"=>"locales/bootstrap-datepicker.es.min","type"=>"js","place"=>"footer"),
					array("file"=>"bootstrap-datepicker.min","type"=>"css","place"=>"header")
				)
			),				
			array("name"=>"daterangepicker","files"=>array(
					array("file"=>"css/daterangepicker","type"=>"css","place"=>"header"),
					array("file"=>"js/moment.min","type"=>"js","place"=>"header"),
					array("file"=>"js/daterangepicker","type"=>"js","place"=>"header")
				)
			),
			array("name"=>"highcharts","files"=>array(
					array("file"=>"js/highcharts","type"=>"js","place"=>"footer"),
					array("file"=>"js/exporting","type"=>"js","place"=>"footer"),
					array("file"=>"js/data","type"=>"js","place"=>"footer"),
					array("file"=>"js/drilldown","type"=>"js","place"=>"footer")
				)
			),
		);
		
		$UIData['section_title']="Inicio";
		$UIData['main_view']="home/home_view";
		
		$this->load->view('templates/templatemovil', $UIData);
	}
		function goHomemovil(){
			if(!$this->caja){/*Validacion de caja*/
				$UIData["section_title"]="Error: Caja desconocida";
				$this->load->view('errores/error_nocaja_view', $UIData);
			}
			else{
				if($this->caja->estado_caja==0){/*Validacion de estado de caja*/
					$UIData["section_title"]="Error: Caja inactiva";
					$this->load->view('errores/error_caja_inactiva_view', $UIData);
				}
				else{		
					$UIData['user_info']=null;
					$UIData['section_title']="Inicio";
					/*Menus,categorias y platos*/
					$menus=$this->Generic_model->get("q","menus","id_menu as id,nombre_menu as nombre");
					if(count($menus)){/*Menus*/
						foreach($menus as $menu){
							 $menu->categorias=$this->Generic_model->get("q","categorias_menu","id_categoria_menu as id, id_menu as menu, nombre_categoria_menu as nombre",array("id_menu"=>$menu->id));
							 if(count($menu->categorias)){/*Categorias*/
								 foreach($menu->categorias as $categoria){/*Platos*/
									$platos=$this->Generic_model->get("q","platosxcategoria","platos.id_plato as id, platosxcategoria.id_categoria_menu as categoria, platos.nombre_plato as nombre,platos.precio_plato as precio",array("platosxcategoria.id_categoria_menu"=>$categoria->id),"","",array("platos"=>"platos.id_plato=platosxcategoria.id_plato"));
									if(count($platos)){/*Categorias acompanamientos*/
										foreach($platos as $plato){
											/*acompanamientos*/
											$acompanamientos_cat=$this->Generic_model->get("q","cat_acompanamientos","id_cat_acompanamiento as id,nombre_cat_acompanamiento as nombre,obligatorio_cat_acompanamiento as obligatorio",array("id_plato"=>$plato->id));
											if(count($acompanamientos_cat)){
												foreach($acompanamientos_cat as $acompanamiento_cat){
													$acompanamiento_cat->acompanamientos=$this->Generic_model->get("q","acompanamientos","id_acompanamiento as id,nombre_acompanamiento as nombre,precio_acompanamiento as precio, 0 as selected",array("id_cat_acompanamiento"=>$acompanamiento_cat->id));
												}
											}
											$plato->acompanamientos=$acompanamientos_cat;
											/*Notas predeterminadas*/
											$plato->notas=$this->Generic_model->get("q","notas","id_nota as id, texto_nota as texto",array("id_plato"=>$plato->id));
										}
									}
									$categoria->platos=$platos;
								 }
							 }
						}
					}
					$UIData["menus"]=$menus;
					/*Configuraciones*/
					$config= (object) array(
						"menu_mode"=>(object) array("db_campo"=>"nueva_orden_desktop_app_default_mode","default"=>0),
						"precios_decimal_precision"=>(object) array("db_campo"=>"decimal_individual_precios_precision","default"=>2),
						"totales_decimal_precision"=>(object) array("db_campo"=>"decimal_global_totales_precision","default"=>2),
						"cant_decimal_precision"=>(object) array("db_campo"=>"decimal_global_cant_precision","default"=>2)
					);
					$UIData["config"]=$this->ufood_utilities->get_conf_value($config);
					$this->load->view('home/home_homemovil_view', $UIData);			
				}
				
			}			
		}
		function goHome(){
			if(!$this->caja){/*Validacion de caja*/
				$UIData["section_title"]="Error: Caja desconocida";
				$this->load->view('errores/error_nocaja_view', $UIData);
			}
			else{
				if($this->caja->estado_caja==0){/*Validacion de estado de caja*/
					$UIData["section_title"]="Error: Caja inactiva";
					$this->load->view('errores/error_caja_inactiva_view', $UIData);
				}
				else{		
					$UIData['user_info']=null;
					$UIData['section_title']="Inicio";
					/*Menus,categorias y platos*/
					$menus=$this->Generic_model->get("q","menus","id_menu as id,nombre_menu as nombre");
					if(count($menus)){/*Menus*/
						foreach($menus as $menu){
							 $menu->categorias=$this->Generic_model->get("q","categorias_menu","id_categoria_menu as id, id_menu as menu, nombre_categoria_menu as nombre",array("id_menu"=>$menu->id));
							 if(count($menu->categorias)){/*Categorias*/
								 foreach($menu->categorias as $categoria){/*Platos*/
									$platos=$this->Generic_model->get("q","platosxcategoria","platos.id_plato as id, platosxcategoria.id_categoria_menu as categoria, platos.nombre_plato as nombre,platos.precio_plato as precio",array("platosxcategoria.id_categoria_menu"=>$categoria->id),"","",array("platos"=>"platos.id_plato=platosxcategoria.id_plato"));
									if(count($platos)){/*Categorias acompanamientos*/
										foreach($platos as $plato){
											/*acompanamientos*/
											$acompanamientos_cat=$this->Generic_model->get("q","cat_acompanamientos","id_cat_acompanamiento as id,nombre_cat_acompanamiento as nombre,obligatorio_cat_acompanamiento as obligatorio",array("id_plato"=>$plato->id));
											if(count($acompanamientos_cat)){
												foreach($acompanamientos_cat as $acompanamiento_cat){
													$acompanamiento_cat->acompanamientos=$this->Generic_model->get("q","acompanamientos","id_acompanamiento as id,nombre_acompanamiento as nombre,precio_acompanamiento as precio, 0 as selected",array("id_cat_acompanamiento"=>$acompanamiento_cat->id));
												}
											}
											$plato->acompanamientos=$acompanamientos_cat;
											/*Notas predeterminadas*/
											$plato->notas=$this->Generic_model->get("q","notas","id_nota as id, texto_nota as texto",array("id_plato"=>$plato->id));
										}
									}
									$categoria->platos=$platos;
								 }
							 }
						}
					}
					$UIData["menus"]=$menus;
					/*Configuraciones*/
					$config= (object) array(
						"menu_mode"=>(object) array("db_campo"=>"nueva_orden_desktop_app_default_mode","default"=>0),
						"precios_decimal_precision"=>(object) array("db_campo"=>"decimal_individual_precios_precision","default"=>2),
						"totales_decimal_precision"=>(object) array("db_campo"=>"decimal_global_totales_precision","default"=>2),
						"cant_decimal_precision"=>(object) array("db_campo"=>"decimal_global_cant_precision","default"=>2),
						"propina_aplicar"=>(object) array("db_campo"=>"propina_aplicar","default"=>1),
						"propina_porcentaje_aplicable"=>(object) array("db_campo"=>"propina_porcentaje_aplicable","default"=>10)
					);
					$UIData["config"]=$this->ufood_utilities->get_conf_value($config);
					
					/*MODO EDICION*/
					if($this->input->get("mode")=="edit" && ($this->input->get("id"))){
						/*Informacion orden*/
						$idorden=$this->input->get("id");
						$orden=$this->Generic_model->get("q","ordenes","num_orden as numero,usuario_orden as mesero_id,servicio_orden as servicio,id_salon as salon_id, id_mesa as mesa_id, cliente_orden as cliente,direccion_cliente as direccion,telefono_cliente as telefono, notas_orden as notas,formapago_orden as formapago,origen_orden as origen",array("id_orden"=>$idorden));
						$orden=$orden[0];
						
						$platos_orden=$this->Generic_model->get("q","platosxorden","platosxorden.id_plato as id,platosxorden.cantidad_plato as cant,platos.nombre_plato as nombre,platosxorden.precio_plato as precio,platosxorden.notas_platoxorden as notas",array("id_orden"=>$idorden,"eliminado_plato"=>0),"","",array("platos"=>"platos.id_plato=platosxorden.id_plato"));
						$UIData["platos_orden"]=$platos_orden;
						$UIData["id_orden"]=$idorden;
						$UIData["orden"]=$orden;
					}
					$this->load->view('home/home_home_view', $UIData);			
				}
				
			}			
		}
		function goOrders(){
			$salones=$this->Generic_model->get("q","salones","id_salon as id,nombre_salon as salon");
			if(count($salones)):
				foreach($salones as $salon):
					$mesas=$this->Generic_model->get("q","mesas","id_salon as salon,id_mesa as id,nombre_mesa as mesa,estado_mesa as estado,cliente_mesa as cliente",array("id_salon"=>$salon->id));
					$mesas_pidiendocuenta=$this->Generic_model->get("q","mesas","*",array("id_salon"=>$salon->id,"estado_mesa"=>"3"));
					$mesas_facturadas=$this->Generic_model->get("q","mesas","*",array("id_salon"=>$salon->id,"estado_mesa"=>"4"));
					$salon->mesas=$mesas;
					if(count($mesas_pidiendocuenta)):
						$salon->precuenta=true;
					else:
						$salon->precuenta=false;
					endif;
					
					if(count($mesas_facturadas)):
						foreach($mesas_facturadas as $mesa_facturada):
							$start_date = new DateTime(date("Y-m-d H:i:s"));
							$since_start = $start_date->diff(new DateTime($mesa_facturada->facturacion_mesa));
							if($since_start->i > 2){
								$this->Generic_model->update("mesas",array("estado_mesa"=>0),array("id_mesa"=>$mesa_facturada->id_mesa));	
							}
						endforeach;
					endif;
				endforeach;
			endif;
			$UIData["salones"]=$salones;
			$this->load->view('home/home_ordenes_view',$UIData);
		}
			function getOrderDetail(){
				/*Configuraciones*/
				$config= (object) array(
					"precios_decimal_precision"=>(object) array("db_campo"=>"decimal_individual_precios_precision","default"=>2),
					"totales_decimal_precision"=>(object) array("db_campo"=>"decimal_global_totales_precision","default"=>2),
					"cant_decimal_precision"=>(object) array("db_campo"=>"decimal_global_cant_precision","default"=>2)
				);
				$AjaxData["config"]=$this->ufood_utilities->get_conf_value($config);
				/*Orden*/
				$ordenes=$this->Generic_model->get("q","ordenes","ordenes.id_orden as id,ordenes.num_orden as num_orden,ordenes.fecha_orden as fecha,salones.nombre_salon as salon,mesas.nombre_mesa as mesa,ordenes.cliente_orden as cliente,usuarios.nombre_usuario as mesero,CASE WHEN ordenes.servicio_orden=0 THEN 'Restaurante' WHEN ordenes.servicio_orden=1 THEN 'P. Llevar' WHEN ordenes.servicio_orden=2 THEN 'Habitación' WHEN ordenes.servicio_orden=3 THEN 'Banquete' END as servicio,ordenes.sub_total_orden as subtotal,ordenes.propina_orden as propina, ordenes.descuento_orden as descuento,formapago_orden as formapago",array("ordenes.id_mesa"=>$this->input->get("id"),"ordenes.estado_orden"=>0),"","",array("salones"=>"salones.id_salon=ordenes.id_salon","mesas"=>"mesas.id_mesa=ordenes.id_mesa,LEFT","usuarios"=>"usuarios.id_usuario=ordenes.usuario_orden,LEFT"));
				
				if(count($ordenes)):foreach($ordenes as $orden):
					$platos_orden=$this->Generic_model->get("q","platosxorden","platosxorden.id_platoxorden as platoxorden,platosxorden.id_plato as id,platosxorden.cantidad_plato as cant,platos.nombre_plato as nombre,platosxorden.precio_plato as precio,platosxorden.notas_platoxorden as notas,platosxorden.eliminado_plato as eliminado",array("id_orden"=>$orden->id),"","",array("platos"=>"platos.id_plato=platosxorden.id_plato"));
					if(count($platos_orden)){
						foreach($platos_orden as $plato){
							$plato->acompanamientos=$this->Generic_model->get("q","acompanamientosxplato","cat_acompanamientos.nombre_cat_acompanamiento as categoria, acompanamientos.nombre_acompanamiento as acompanamiento",array("id_platoxorden"=>$plato->platoxorden),"","",array("cat_acompanamientos"=>"cat_acompanamientos.id_cat_acompanamiento=acompanamientosxplato.id_cat_acompanamiento","acompanamientos"=>"acompanamientos.id_acompanamiento=acompanamientosxplato.id_acompanamiento"));
						}
					}
					$orden->platos=$platos_orden;
				endforeach;endif;
				
				$AjaxData["ordenes"]=$ordenes;
				
				$mesaData=$this->Generic_model->get("q","mesas","*",array("id_mesa"=>$this->input->get("id")));
				$mesaData=$mesaData[0];
				
				$AjaxData["mesa"]=$this->input->get("id");
				$AjaxData["mesaData"]=$mesaData;
				$AjaxData["userid"]=$this->session_['userid'];
				
				$this->load->view('home/home_ordenes_detalles_view',$AjaxData);
			}
				function cambiar_estado_mesa(){
					echo $this->Generic_model->update("mesas",array("estado_mesa"=>$this->input->get("estado")),array("id_mesa"=>$this->input->get("id")));
				}
				function detalles_plato_orden(){
					$UIDataModal["title"]='Detalles del plato';
					$UIDataModal["content_view"]="home/home_info_plato_view";
					$UIDataModal["classes"]="modal-md";
					$UIDataModal["id"]="ordenes-detalles-platos-ordenes";
					/*Consulta*/
					$SQL_stmt="SELECT platos.nombre_plato as plato_nombre,notas_platoxorden as notas,";
					$SQL_stmt.="fecha_enviado_plato as fecha_agregado,meseros.nombre_usuario as mesero,";
					$SQL_stmt.="salones.nombre_salon as salon,mesas.nombre_mesa as mesa,";
					$SQL_stmt.="despachado_plato as despachado,fecha_despachado_plato as fecha_despachado,despachador.nombre_usuario as despachador_nombre,";
					$SQL_stmt.="eliminado_plato as eliminado,fecha_eliminado_plato as fecha_eliminado,eliminador.nombre_usuario as eliminador_nombre";
					$SQL_stmt.=" FROM platosxorden";
					$SQL_stmt.=" LEFT JOIN platos ON platos.id_plato=platosxorden.id_plato";
					$SQL_stmt.=" LEFT JOIN usuarios as meseros ON meseros.id_usuario=platosxorden.id_mesero";
					$SQL_stmt.=" LEFT JOIN salones ON salones.id_salon=platosxorden.id_salon";
					$SQL_stmt.=" LEFT JOIN mesas ON mesas.id_mesa=platosxorden.id_mesa";
					$SQL_stmt.=" LEFT JOIN usuarios as despachador ON despachador.id_usuario=platosxorden.id_usuario_despacho";
					$SQL_stmt.=" LEFT JOIN usuarios as eliminador ON eliminador.id_usuario=platosxorden.id_usuario_elimin";
					$SQL_stmt.=" WHERE id_platoxorden=".$this->input->get("id");
					$platoxorden=$this->Generic_model->sql_custom($SQL_stmt);
					
					$UIDataModal["plato"]=$platoxorden[0];
					$this->load->view('templates/template_modal',$UIDataModal); 
				}
		function goOrdersCallCenter(){
			$UIData["ordenes"]=$this->Generic_model->get("q","ordenes","*",array("estado_orden"=>0,"origen_orden"=>1));
			$this->load->view('home/home_ordenes_callcenter_view',$UIData);
		}
			function getOrderDetailCC(){
				/*Configuraciones*/
				$config= (object) array(
					"precios_decimal_precision"=>(object) array("db_campo"=>"decimal_individual_precios_precision","default"=>2),
					"totales_decimal_precision"=>(object) array("db_campo"=>"decimal_global_totales_precision","default"=>2),
					"cant_decimal_precision"=>(object) array("db_campo"=>"decimal_global_cant_precision","default"=>2)
				);
				$AjaxData["config"]=$this->ufood_utilities->get_conf_value($config);
				/*Orden*/
				$ordenes=$this->Generic_model->get("q","ordenes","ordenes.id_orden as id,ordenes.num_orden as num_orden,ordenes.fecha_orden as fecha,ordenes.cliente_orden as cliente,ordenes.sub_total_orden as subtotal,ordenes.propina_orden as propina, ordenes.descuento_orden as descuento,formapago_orden as formapago",array("ordenes.id_orden"=>$this->input->get("id"),"ordenes.estado_orden"=>0),"","");
				
				if(count($ordenes)):foreach($ordenes as $orden):
					$platos_orden=$this->Generic_model->get("q","platosxorden","platosxorden.id_platoxorden as platoxorden,platosxorden.id_plato as id,platosxorden.cantidad_plato as cant,platos.nombre_plato as nombre,platosxorden.precio_plato as precio,platosxorden.notas_platoxorden as notas,platosxorden.eliminado_plato as eliminado",array("id_orden"=>$orden->id),"","",array("platos"=>"platos.id_plato=platosxorden.id_plato"));
					if(count($platos_orden)){
						foreach($platos_orden as $plato){
							$plato->acompanamientos=$this->Generic_model->get("q","acompanamientosxplato","cat_acompanamientos.nombre_cat_acompanamiento as categoria, acompanamientos.nombre_acompanamiento as acompanamiento",array("id_platoxorden"=>$plato->platoxorden),"","",array("cat_acompanamientos"=>"cat_acompanamientos.id_cat_acompanamiento=acompanamientosxplato.id_cat_acompanamiento","acompanamientos"=>"acompanamientos.id_acompanamiento=acompanamientosxplato.id_acompanamiento"));
						}
					}
					$orden->platos=$platos_orden;
				endforeach;endif;
				
				$AjaxData["ordenes"]=$ordenes;
				$AjaxData["userid"]=$this->session_['userid'];
				
				$this->load->view('home/home_ordenes_detalles_callcenter_view',$AjaxData);
			}
		function tarjeta(){
			if(!$this->caja){/*Validacion de caja*/
				$UIDataModal["content_view"]="errores/error_nocaja_view";
				$UIDataModal["title"]="Error: Caja desconocida";
			}else{
				if($this->caja->estado_caja==0){/*Validacion de estado de caja*/
					$UIDataModal["content_view"]="errores/error_caja_inactiva_view";
					$UIDataModal["title"]="Error: Caja inactiva";
				}else{
					$UIDataModal['user_info']=null;
					$UIDataModal['content_view']="home/home_facturacion_tarjeta_view";
					$UIDataModal["classes"]="modal-md";
					$UIDataModal["id"]="caja-facturacion-tarjeta-modal";
					$UIDataModal['title']="Activacion de Tarjetas de Regalo";
					/*Configuraciones*/
					$config= (object) array(
						"precios_decimal_precision"=>(object) array("db_campo"=>"decimal_individual_precios_precision","default"=>2),
						"totales_decimal_precision"=>(object) array("db_campo"=>"decimal_global_totales_precision","default"=>2),
						"cant_decimal_precision"=>(object) array("db_campo"=>"decimal_global_cant_precision","default"=>2)
					);
					$UIDataModal["config"]=$this->ufood_utilities->get_conf_value($config);
				}
			}
			$this->load->view('templates/template_modal', $UIDataModal);
		}
		
		function cobrar(){
			$total=$this->input->get("total");
			$cliente=($this->input->get("cliente")?$this->input->get("cliente"):"");
			$direccion=($this->input->get("direccion")?$this->input->get("direccion"):"");
			$telefono=($this->input->get("telefono")?$this->input->get("telefono"):"");
			$servicio=($this->input->get("servicio")?$this->input->get("servicio"):"");
			$UIDataModal["title"]='Cobrar';
			$UIDataModal["content_view"]="home/home_facturacion_cobrar_view";
			$UIDataModal["classes"]="modal-xl";
			$UIDataModal["id"]="caja-facturacion-cobrar-modal";
			$UIDataModal["mode"]=$this->input->get("mode");
			$UIDataModal["winID"]=($this->input->get('winid')?$this->input->get('winid'):date('YmdHis'));
			
			$empleados = $this->Generic_model->get("q","empleados");
			
			if(count($empleados)):foreach($empleados as $empleado):
				$consumo=$this->Generic_model->get("q","consumos","*",array("id_empleado"=>$empleado->id_empleado,"date(fecha_consumo)"=>date("Y-m-d")));
				if(count($consumo)){
					$empleado->consumo=true;
				}else{
					$empleado->consumo=false;
				}
			endforeach;endif;
			
			$UIDataModal["empleados"]=$empleados;
			
			/*Configuraciones*/
			$config= (object) array(
				"totales_decimal_precision"=>(object) array("db_campo"=>"decimal_global_totales_precision","default"=>2),
				"maximo_consumo_empleado"=>(object) array("db_campo"=>"maximo_consumo_empleado","default"=>"3.49"),
			);
			$UIDataModal["config"]=$this->ufood_utilities->get_conf_value($config);
			
			$UIDataModal["total"]=$total;
			$UIDataModal["cliente"]=$cliente;
			$UIDataModal["direccion"]=$direccion;
			$UIDataModal["telefono"]=$telefono;
			$UIDataModal["servicio"]=$servicio;
			
			$this->load->view('templates/template_modal',$UIDataModal);
		}
		/*Temp*/
		function cobrarmovil(){
			$total=$this->input->get("total");
			$cliente=($this->input->get("cliente")?$this->input->get("cliente"):"");
			$UIDataModal["title"]='Cobrar';
			$UIDataModal["content_view"]="home/home_facturacion_cobrarmovil_view";
			$UIDataModal["classes"]="modal-lg";
			$UIDataModal["id"]="caja-facturacion-cobrar-modal";
			$UIDataModal["mode"]=$this->input->get("mode");
			$UIDataModal["winID"]=($this->input->get('winid')?$this->input->get('winid'):date('YmdHis'));
			
			$empleados = $this->Generic_model->get("q","empleados");
			
			if(count($empleados)):foreach($empleados as $empleado):
				$consumo=$this->Generic_model->get("q","consumos","*",array("id_empleado"=>$empleado->id_empleado,"date(fecha_consumo)"=>date("Y-m-d")));
				if(count($consumo)){
					$empleado->consumo=true;
				}else{
					$empleado->consumo=false;
				}
			endforeach;endif;
			
			$UIDataModal["empleados"]=$empleados;
			
			/*Configuraciones*/
			$config= (object) array(
				"totales_decimal_precision"=>(object) array("db_campo"=>"decimal_global_totales_precision","default"=>2),
				"maximo_consumo_empleado"=>(object) array("db_campo"=>"maximo_consumo_empleado","default"=>"3.49"),
			);
			$UIDataModal["config"]=$this->ufood_utilities->get_conf_value($config);
			
			$UIDataModal["total"]=$total;
			$UIDataModal["cliente"]=$cliente;
			
			$this->load->view('templates/template_modal',$UIDataModal);
		}
		function guardar_consumo(){
			$fecha=gmdate('Y-m-d H:i:s', strtotime('- 6 hours'));
			$subtotal=$this->input->post("subtotal");
			$servicio=$this->input->post("servicio");
			$usuario=$this->session_['userid'];
			$nombre_empleado=$this->input->post("empleado_nombre");
			$id_empleado=$this->input->post("id_empleado");
			$productos=json_decode($this->input->post('productos'));			
			$caja=$this->caja->id_caja;
			
			/*Registrar venta*/
			$consumoData=array(
				"id_cajero"=>$usuario,
				"id_caja"=>$caja,
				"id_empleado"=>$id_empleado,
				"nombre_empleado"=>$nombre_empleado,
				"fecha_consumo"=>$fecha,
				"subtotal_consumo"=>$subtotal
			);
			$idconsumo=$this->Generic_model->save("consumos",$consumoData,true);
			
			if($idconsumo){
				$productosxventaData=array();
				$productosPrint=array();
				foreach($productos as $producto){
					$productosxventaData[]=array(
						"id_consumo"=>$idconsumo,
						"id_plato"=>$producto->id,
						"cant_cproducto"=>$producto->cant,
						"costo_cproducto"=>$producto->precio
					);
					$productosPrint[]=array(
						"cant"=>$producto->cant,
						"desc"=>$producto->desc,
						"costo"=>$producto->precio
					);
				}
				if($this->Generic_model->savebatch("cproductosxconsumo",$productosxventaData)){
					/*Impresion*/
					$nombre_empresa=$this->ufood_utilities->get_conf_value((object) array("gral_info_nombre_empresa"=>(object) array("db_campo"=>"gral_info_nombre_empresa","default"=>"")));
					$rsocial_empresa=$this->ufood_utilities->get_conf_value((object) array("gral_info_propietario_empresa"=>(object) array("db_campo"=>"gral_info_propietario_empresa","default"=>"")));
					$direcion_empresa=$this->ufood_utilities->get_conf_value((object) array("gral_info_direccion_empresa"=>(object) array("db_campo"=>"gral_info_direccion_empresa","default"=>"")));
					$dataPrint['nombre_empresa']=$nombre_empresa->gral_info_nombre_empresa->value;
					$dataPrint['rsocial_empresa']=$rsocial_empresa->gral_info_propietario_empresa->value;
					$dataPrint['direcion_empresa']=$direcion_empresa->gral_info_direccion_empresa->value;
					$dataPrint['fecha']=date("d-m-Y H:i:s",strtotime($fecha));
					$dataPrint['caja']="Caja 1";
					$dataPrint['empleado']=$nombre_empleado;
					$dataPrint['vendedor']=$this->session_['username'];
					$dataPrint['referencia']="C-".$idconsumo;
					$dataPrint['servicio']=$servicio;
					$dataPrint['totales']["totalTotal"]=number_format($subtotal,2);
					
					$dataPrint['productos_normal']=json_decode (json_encode ($productosPrint), FALSE);
					
					$this->load->view('impresos/transacciones_facturacion_recibo_consumo_view',$dataPrint);
					echo true;
				}else{
					false;
				}
			}
		}
		function guardar_venta(){
			$forma_pago=$this->input->post("forma_pago");
			$origen_venta=$this->input->post("origen");
			$documento_pago=$this->input->post("documento_pago");
			$fecha=gmdate('Y-m-d H:i:s', strtotime('- 6 hours'));
			$orden=($this->input->post("orden") && $this->input->post("orden")!=""?$this->input->post("orden"):null);
			/**/
			$efectivo=$this->input->post("efectivo");
			$cambio=$this->input->post("cambio");
			$subtotal=$this->input->post("subtotal");
			$propina=$this->input->post("propina");
			$descuento=$this->input->post("descuento");
			$total=$this->input->post("total");
			$pos=$this->input->post("pos");
			$servicio=$this->input->post("servicio");
			/**/
			$usuario=$this->session_['userid'];
			/**/
			$nombre_cliente=$this->input->post("cliente_nombre");
			$notas=$this->input->post("notas");
			/**/
			$productos=json_decode($this->input->post('productos'));
			$iva=0;
			
			$caja=$this->caja->id_caja;
			$printOrden=true;
			$direccion_cliente=$telefono_cliente="";
			
			if($orden > 0){
				$printOrden=false;
				$ordenData=$this->Generic_model->get("q","ordenes","*",array("id_orden"=>$orden));
				$ordenData=$ordenData[0];
				$direccion_cliente=$ordenData->direccion_cliente;
				$telefono_cliente=$ordenData->telefono_cliente;
				
				$this->Generic_model->update("ordenes",array("estado_orden"=>1),array("id_orden"=>$ordenData->id_orden));
				$ordenes_pendientes = $this->Generic_model->get("q","ordenes","*",array("id_mesa"=>$ordenData->id_mesa,"estado_orden"=>0));
				
				if(count($ordenes_pendientes)==0 && $ordenData->id_mesa!="100"){
					$this->Generic_model->update("mesas",array("estado_mesa"=>4,"facturacion_mesa"=>$fecha,"cliente_mesa"=>""),array("id_mesa"=>$ordenData->id_mesa));
				}
			}
			
			if($documento_pago==0){
				$numero_ticket=$this->ufood_utilities->get_conf_value((object) array("ticket_correlativo"=>(object) array("db_campo"=>"ticket_correlativo","default"=>1)));
				$numero_ticket=$numero_ticket->ticket_correlativo->value;
				$doc_numero=$numero_ticket;				
			}else{
				$doc_numero=$this->input->post("numero_documento");
			}
			
			if($documento_pago==2){
				$subtotal=number_format(($subtotal/1.13),2);
				$iva=number_format(($subtotal - ($subtotal/1.13)),2);
			}
			
			switch($forma_pago){
				case "0":
					$forma_pago_venta=array("0"=>$total);
				break;
				case "1":
					$forma_pago_venta=array("1"=>$total);
				break;
				case "2":
					$forma_pago_venta=array("0"=>number_format(($total-$pos),2),"1"=>$pos);
				break;
			}

			/*Registrar venta*/
			$ventaData=array(
				"id_cajero"=>$usuario,
				"id_caja"=>$caja,
				"id_cliente"=>null,
				"id_orden"=>$orden,
				"origen_venta"=>$origen_venta,
				"nombre_cliente"=>$nombre_cliente,
				"dui_cliente"=>null,
				"nit_cliente"=>null,
				"nrc_cliente"=>null,
				"fecha_venta"=>$fecha,
				"forma_pago_venta"=>serialize($forma_pago_venta),
				"documento_venta"=>$documento_pago,
				"servicio_venta"=>$servicio,
				"id_serie"=>null,
				"num_doc_venta"=>$doc_numero,
				"estado_venta"=>0,
				"subtotal_venta"=>$subtotal,
				"iva_venta"=>$iva,
				"propina_venta"=>$propina,
				"descuento_venta"=>$descuento,
				"promotor_venta"=>$this->input->post("promotor"),
			);
			
			$idventa=$this->Generic_model->save("ventas",$ventaData,true);
			
			/*Cinta*/
			$correlativo_cinta=$this->caja->correlativo_cinta+1;
			$this->Generic_model->update("cajas",array("correlativo_cinta"=>$correlativo_cinta),array("id_caja"=>$this->caja->id_caja));
			$this->Generic_model->save("trans_cinta",array("id_cinta"=>$this->caja->id_cinta,"id_venta"=>$idventa,"correlativo_cinta"=>$correlativo_cinta));
			
			if(isset($idventa)){
				if($documento_pago==0){
					/*aumentar ticket correlativo*/
					$nuevoCorrelativo=$numero_ticket+=1;
					$this->Generic_model->update("config",array("valor_config"=>$nuevoCorrelativo."|i"),array("campo_config"=>"ticket_correlativo"));
				}
				/*productos por venta*/
				$productosxventaData=array();
				$productosPrint=array();
				foreach($productos as $producto){
					$productosxventaData[]=array(
						"id_venta"=>$idventa,
						"tipo_vproducto"=>0,
						"id_plato"=>$producto->id,
						"cant_vproducto"=>$producto->cant,
						"costo_vproducto"=>$producto->precio,
						"promo_vproducto"=>0,
					);
					$productosPrint[]=array(
						"cant"=>$producto->cant,
						"desc"=>$producto->desc,
						"costo"=>$producto->precio
					);
				}
				if($this->input->post("promotor")!=""){
					$wantanq=$this->Generic_model->get("q","platos","*",array("nombre_plato"=>"4 Wantan Gratis Promotor"));
					$wantanq=$wantanq[0];
					$wantan=array(
						"id_venta"=>$idventa,
						"tipo_vproducto"=>0,
						"id_plato"=>$wantanq->id_plato,
						"cant_vproducto"=>1,
						"costo_vproducto"=>0,
						"promo_vproducto"=>0
					);

					$productosPrint[]=array(
						"cant"=>1,
						"desc"=>$wantanq->nombre_plato,
						"costo"=>0
					);
					$this->Generic_model->save("vproductosxventa",$wantan);
				}

				print_r($productosPrint);
				if($this->Generic_model->savebatch("vproductosxventa",$productosxventaData)){
					/*modificar orden*/
					if($orden!=null)
						$this->Generic_model->update("ordenes",array("estado_orden"=>2),array("id_orden"=>$orden));
					/*Impresion*/
					$dataPrint["copias"]=0;
					$dataPrint['fecha']=date("d-m-Y H:i:s",strtotime($fecha));
					$dataPrint['caja']="Caja 1";
					$dataPrint['doc_numero']=$doc_numero;
					$dataPrint['cliente']=$nombre_cliente;
					$dataPrint['notas']=$notas;
					$dataPrint['dui_cliente']="";
					$dataPrint['nit_cliente']="";
					$dataPrint['nrc_cliente']="";
					$dataPrint['diascred']="";
					$dataPrint['condicion']="Contado";
					$dataPrint['condicion_num']=0;
					$dataPrint['direccion_cliente']=$direccion_cliente;
					$dataPrint['telefono_cliente']=$telefono_cliente;
					$dataPrint['cajero']="";
					$dataPrint['vendedor']=$this->session_['username'];
					$dataPrint['referencia']="V-".$idventa;
					$dataPrint['efectivo']=$efectivo;
					$dataPrint['pos']=$pos;
					$dataPrint['cambio']=$cambio;
					$dataPrint['servicio']=$servicio;
					
					$dataPrint['productos_normal']=json_decode (json_encode ($productosPrint), FALSE);
					$dataPrint['productos_interno']=json_decode (json_encode ($productosPrint), FALSE);
					$dataPrint['totales']=array();
					$dataPrint['totales']["totalTotal"]=number_format($total,2);
					$dataPrint['totales']["totalGrabadas"]=number_format($subtotal,2);
					$dataPrint['totales']["totalExento"]=number_format(0,2);
					$dataPrint['totales']["totalNS"]=number_format(0,2);
					$dataPrint['totales']["totalIVA"]=number_format($iva,2);
					$dataPrint['totales']["propina"]=number_format($propina,2);
					$dataPrint['totales']["descuento"]=number_format($descuento,2);
					
					$dataPrint['total_interno']=number_format($total,2);
					$this->imprimirFactura($dataPrint,$documento_pago,$printOrden);
					echo true;
				}else{
					false;
				}
			}else{
				echo false;
			}
		}
		/*IMPRIMIR DOCUMENTOS*/
		function imprimirFactura($dataPrint,$documento,$printOrden = false){
			/*--- Obtener configuraciones ---*/
			$nombre_empresa=$this->ufood_utilities->get_conf_value((object) array("gral_info_nombre_empresa"=>(object) array("db_campo"=>"gral_info_nombre_empresa","default"=>"")));
			$rsocial_empresa=$this->ufood_utilities->get_conf_value((object) array("gral_info_propietario_empresa"=>(object) array("db_campo"=>"gral_info_propietario_empresa","default"=>"")));
			$direcion_empresa=$this->ufood_utilities->get_conf_value((object) array("gral_info_direccion_empresa"=>(object) array("db_campo"=>"gral_info_direccion_empresa","default"=>"")));
			$nit_empresa=$this->ufood_utilities->get_conf_value((object) array("gral_info_nit_empresa"=>(object) array("db_campo"=>"gral_info_nit_empresa","default"=>"")));
			$nrc_empresa=$this->ufood_utilities->get_conf_value((object) array("gral_info_nrc_empresa"=>(object) array("db_campo"=>"gral_info_nrc_empresa","default"=>"")));
			$mensaje_ticket=$this->ufood_utilities->get_conf_value((object) array("mensaje_tickets"=>(object) array("db_campo"=>"mensaje_tickets","default"=>"")));
			
			$dataPrint['nombre_empresa']=$nombre_empresa->gral_info_nombre_empresa->value;
			$dataPrint['rsocial_empresa']=$rsocial_empresa->gral_info_propietario_empresa->value;
			$dataPrint['direcion_empresa']=$direcion_empresa->gral_info_direccion_empresa->value;
			$dataPrint['nit_empresa']=$nit_empresa->gral_info_nit_empresa->value;
			$dataPrint['nrc_empresa']=$nrc_empresa->gral_info_nrc_empresa->value;

			$dataPrint['doc_desde']="1";
			$dataPrint['doc_hasta']="100000";
			$dataPrint['doc_resolucion']="15012-RES-CR-33172-2019";
			$dataPrint['doc_autorizacion']="AMR-15041-023908-2019";
			$dataPrint['mensaje_ticket']=$mensaje_ticket->mensaje_tickets->value;
			
			switch($documento){
				case "0":
					if($printOrden){
						$this->load->view('impresos/transacciones_facturacion_orden_view',$dataPrint);						
					}
					$this->load->view('impresos/transacciones_facturacion_ticket_view',$dataPrint);				
				break;
				case "1":
					//$this->load->view('impresos/transacciones_facturacion_orden_view',$dataPrint);
					$this->load->view('impresos/transacciones_facturacion_factura_view',$dataPrint);				
				break;
				case "2":
					//$this->load->view('impresos/transacciones_facturacion_orden_view',$dataPrint);
					$this->load->view('impresos/transacciones_facturacion_ccf_view',$dataPrint);				
				break;
				case "4":
					$this->load->view('impresos/transacciones_facturacion_ticket_view',$dataPrint);				
				break;
				case "9":
					/*Ninguno*/
				break;
			}
		}
		
		function eliminar_orden(){
			$orden=$this->Generic_model->get("q","ordenes","*",array("id_orden"=>$this->input->get("id")));
			$orden=$orden[0];
			
			$fecha=gmdate('Y-m-d H:i:s', strtotime('- 6 hours'));
			$usuario=$this->session_['userid'];
			
			$this->Generic_model->update("ordenes",array("estado_orden"=>2,"usuario_elimin_orden"=>$usuario,"fecha_elimin_orden"=>$fecha),array("id_orden"=>$orden->id_orden));
			
			$ordenes_pendientes = $this->Generic_model->get("q","ordenes","*",array("id_mesa"=>$orden->id_mesa,"estado_orden"=>0));
				
			if(count($ordenes_pendientes)==0 && $orden->id_mesa!="100"){
				$this->Generic_model->update("mesas",array("estado_mesa"=>0,"cliente_mesa"=>""),array("id_mesa"=>$orden->id_mesa));
			}
			
			echo true;
		}
		
		function imprimirPrecuenta(){
			$nombre_empresa=$this->ufood_utilities->get_conf_value((object) array("gral_info_nombre_empresa"=>(object) array("db_campo"=>"gral_info_nombre_empresa","default"=>"")));
			$dataPrint['nombre_empresa']=$nombre_empresa->gral_info_nombre_empresa->value;
			
			$orden=$this->Generic_model->get("q","ordenes","ordenes.id_orden as id,ordenes.num_orden as num_orden,ordenes.fecha_orden as fecha,salones.nombre_salon as salon,mesas.nombre_mesa as mesa,ordenes.cliente_orden as cliente,usuarios.nombre_usuario as mesero,CASE WHEN ordenes.servicio_orden=0 THEN 'Restaurante' WHEN ordenes.servicio_orden=1 THEN 'P. Llevar' WHEN ordenes.servicio_orden=2 THEN 'Habitación' WHEN ordenes.servicio_orden=3 THEN 'Banquete' END as servicio,ordenes.sub_total_orden as subtotal,ordenes.propina_orden as propina, ordenes.descuento_orden as descuento",array("id_orden"=>$this->input->get("id")),"","",array("salones"=>"salones.id_salon=ordenes.id_salon,LEFT OUTER","mesas"=>"mesas.id_mesa=ordenes.id_mesa,LEFT OUTER","usuarios"=>"usuarios.id_usuario=ordenes.usuario_orden,LEFT"));
			$dataPrint["orden"]=$orden[0];
			/*Platos*/
			$platos_orden=$this->Generic_model->get("q","platosxorden","platosxorden.id_platoxorden as platoxorden,platosxorden.id_plato as id,platosxorden.cantidad_plato as cant,platos.nombre_plato as nombre,platosxorden.precio_plato as precio,platosxorden.notas_platoxorden as notas",array("id_orden"=>$this->input->get("id"),"eliminado_plato"=>0),"","",array("platos"=>"platos.id_plato=platosxorden.id_plato"));
			if(count($platos_orden)){
				foreach($platos_orden as $plato){
					$plato->acompanamientos=$this->Generic_model->get("q","acompanamientosxplato","cat_acompanamientos.nombre_cat_acompanamiento as categoria, acompanamientos.nombre_acompanamiento as acompanamiento",array("id_platoxorden"=>$plato->platoxorden),"","",array("cat_acompanamientos"=>"cat_acompanamientos.id_cat_acompanamiento=acompanamientosxplato.id_cat_acompanamiento","acompanamientos"=>"acompanamientos.id_acompanamiento=acompanamientosxplato.id_acompanamiento"));
				}
			}
			
			$dataPrint["platos"]=$platos_orden;
			
			$config= (object) array(
				"precios_decimal_precision"=>(object) array("db_campo"=>"decimal_individual_precios_precision","default"=>2),
				"totales_decimal_precision"=>(object) array("db_campo"=>"decimal_global_totales_precision","default"=>2),
				"cant_decimal_precision"=>(object) array("db_campo"=>"decimal_global_cant_precision","default"=>2),
				"propina_aplicar"=>(object) array("db_campo"=>"propina_aplicar","default"=>1),
				"propina_porcentaje_aplicable"=>(object) array("db_campo"=>"propina_porcentaje_aplicable","default"=>10)
			);
			$dataPrint["config"]=$this->ufood_utilities->get_conf_value($config);
			
			$this->load->view('impresos/transacciones_facturacion_precuenta_view',$dataPrint);
			
			echo true;
		}
			function eliminar_platoxorden(){
				$config= (object) array(
					"precios_decimal_precision"=>(object) array("db_campo"=>"decimal_individual_precios_precision","default"=>2),
					"totales_decimal_precision"=>(object) array("db_campo"=>"decimal_global_totales_precision","default"=>2),
					"cant_decimal_precision"=>(object) array("db_campo"=>"decimal_global_cant_precision","default"=>2),
					"propina_aplicar"=>(object) array("db_campo"=>"propina_aplicar","default"=>1),
					"propina_porcentaje_aplicable"=>(object) array("db_campo"=>"propina_porcentaje_aplicable","default"=>10)
				);
				$config=$this->ufood_utilities->get_conf_value($config);
				
				$fecha=gmdate('Y-m-d H:i:s', strtotime('- 6 hours'));
				$usuario=$this->session_['userid'];
				
				$this->Generic_model->update("platosxorden",array("eliminado_plato"=>1,"id_usuario_elimin"=>$usuario,"fecha_eliminado_plato"=>$fecha),array("id_platoxorden"=>$this->input->get("id")));
				
				$orden=$this->Generic_model->get("q","platosxorden","*",array("id_platoxorden"=>$this->input->get("id")));
				$orden=$orden[0];
				
				$propina=$subtotal=0;
				
				$platos_orden=$this->Generic_model->get("q","platosxorden","platosxorden.id_platoxorden as platoxorden,platosxorden.id_plato as id,platosxorden.cantidad_plato as cant,platos.nombre_plato as nombre,platosxorden.precio_plato as precio,platosxorden.notas_platoxorden as notas",array("id_orden"=>$orden->id_orden,"eliminado_plato"=>0),"","",array("platos"=>"platos.id_plato=platosxorden.id_plato"));
				if(count($platos_orden)){
					foreach($platos_orden as $plato){
						$subtotal+=number_format(($plato->cant*$plato->precio),$config->totales_decimal_precision->value);
						if($config->propina_aplicar->value == 1){
							$propina = number_format(($subtotal*$config->propina_porcentaje_aplicable->value),$config->totales_decimal_precision->value);
						}
					}
				}
				
				$dataOrden=array(
					"sub_total_orden"=>$subtotal,
					"propina_orden"=>$propina,
				);
				
				$this->Generic_model->update("ordenes",$dataOrden,array("id_orden"=>$orden->id_orden));
				
				echo true;
			}
		
		function devolucion(){
			if(!$this->caja){/*Validacion de caja*/
				$UIDataModal["content_view"]="errores/error_nocaja_view";
				$UIDataModal["title"]="Error: Caja desconocida";
			}else{
				if($this->caja->estado_caja==0){/*Validacion de estado de caja*/
					$UIDataModal["content_view"]="errores/error_caja_inactiva_view";
					$UIDataModal["title"]="Error: Caja inactiva";
				}else{
					$UIDataModal['user_info']=null;
					$UIDataModal['content_view']="home/home_devolucion_view";
					$UIDataModal["classes"]="modal-lg";
					$UIDataModal["id"]="caja-facturacion-devolucion-modal";
					$UIDataModal['title']="Inicio";
					/*Configuraciones*/
					$config= (object) array(
						"precios_decimal_precision"=>(object) array("db_campo"=>"decimal_individual_precios_precision","default"=>2),
						"totales_decimal_precision"=>(object) array("db_campo"=>"decimal_global_totales_precision","default"=>2),
						"cant_decimal_precision"=>(object) array("db_campo"=>"decimal_global_cant_precision","default"=>2)
					);
					$UIDataModal["config"]=$this->ufood_utilities->get_conf_value($config);
				}
			}
			$this->load->view('templates/template_modal', $UIDataModal);
		}
		function devolucion_info(){
			$ref=$this->input->get("ref");
			$winid=$this->input->get("winid");
			$venta=$this->Generic_model->get("q","ventas","*",array("id_venta"=>$ref));
			$venta=$venta[0];
			if(count($venta)){
				if($venta->estado_venta==0){
					$productosxventa=$this->Generic_model->get("q","vproductosxventa","vproductosxventa.id_plato as id, platos.nombre_plato as nombre,cant_vproducto as cant, costo_vproducto as precio",array("vproductosxventa.id_venta"=>$ref),"","",array("platos"=>"platos.id_plato=vproductosxventa.id_plato,LEFT"));
					$data["info_venta"]=$venta;
					$data["productos"]=$productosxventa;
					$data["winid"]=$winid;
					$this->load->view('home/home_devolucion_info_view',$data);
				}else{
					echo "<div class='alert alert-danger mar-all'><i class='fa fa-exclamation-triangle fa-2x'></i><span class='pad-all'>La venta asociada al numero de referencia: <strong>".$ref."</strong> ya ha sido anulada.</span></div>";
				}
			}
			else{
				echo "<div class='alert alert-danger mar-all'><i class='fa fa-exclamation-triangle fa-2x'></i><span class='pad-all'>No se encontro ninguna venta relacionada al numero de referencia: <strong>".$ref."</strong></span></div>";
			}
		}
		function guardar_devolucion(){
			$fecha=gmdate('Y-m-d H:i:s', strtotime('- 6 hours'));
			$total=$this->input->post("total");
			
			$cliente=$this->input->post("cliente");
			$dui=$this->input->post("dui");
			$motivo=$this->input->post("motivo");
			/**/
			$venta=$this->input->post("venta");
			/**/
			$usuario=$this->session_['userid'];
			/**/
			$productos=json_decode($this->input->post('productos'));
			/*Numero de ticke*/
			$serie_autorizacion="";
			$serie_resolucion="";
			$tiraje_desde="";
			$tiraje_hasta="";
			
			$caja=$this->caja->id_caja;
			
			$numero_ticket=$this->ufood_utilities->get_conf_value((object) array("ticket_correlativo"=>(object) array("db_campo"=>"ticket_correlativo","default"=>1)));
			$numero_ticket=$numero_ticket->ticket_correlativo->value;
			/*Registrar devolucion*/
			$devData=array(
				"id_caja"=>$caja,
				"id_cajero"=>$usuario,
				"id_venta"=>$venta,
				"fecha_devolucion"=>$fecha,
				"cliente_devolucion"=>$cliente,
				"dui_cliente_devolucion"=>$dui,
				"motivo_devolucion"=>$motivo,
				"doc_devolucion"=>0,
				"id_serie"=>null,
				"num_doc_devolucion"=>$numero_ticket,
				"forma_pago_devolucion"=>serialize(array("0"=>$total)),
				"subtotal_devolucion"=>$total,
				"iva_devolucion"=>0,
				"retencion_devolucion"=>0,
				"percepcion_devolucion"=>0,
				"exento_devolucion"=>0,
				"nosujeto_devolucion"=>0,
				"propina_devolucion"=>0,
				"descuento_devolucion"=>0
			);
			$dev=$this->Generic_model->save("devoluciones",$devData,true);
			
			/*Cinta*/
			$correlativo_cinta=$this->caja->correlativo_cinta+1;
			$this->Generic_model->update("cajas",array("correlativo_cinta"=>$correlativo_cinta),array("id_caja"=>$this->caja->id_caja));
			$this->Generic_model->save("trans_cinta",array("id_cinta"=>$this->caja->id_cinta,"id_venta"=>$idventa,"correlativo_cinta"=>$correlativo_cinta));
			
			if($dev){
				/*aumentar ticket correlativo*/
				$nuevoCorrelativo=$numero_ticket+=1;
				$this->Generic_model->update("config",array("valor_config"=>$nuevoCorrelativo."|i"),array("campo_config"=>"ticket_correlativo"));
				/*productos por venta*/
				$productosxventaData=array();
				$productosPrint=array();
				foreach($productos as $producto){
					$productosxventaData[]=array(
						"id_devolucion"=>$dev,
						"tipo_vproducto"=>0,
						"id_plato"=>$producto->id,
						"cant_vproducto"=>$producto->cant,
						"costo_vproducto"=>$producto->precio
					);
					$productosPrint[]=array(
						"cant"=>$producto->cant,
						"desc"=>$producto->desc,
						"costo"=>$producto->precio
					);
				}
				if($this->Generic_model->savebatch("vproductosxdevolucion",$productosxventaData)){
					/*modificar venta*/
					$this->Generic_model->update("ventas",array("estado_venta"=>1),array("id_venta"=>$venta));
					/*Impresion*/
					$dataPrint["copias"]=0;
					$dataPrint['fecha']=date("d-m-Y H:i:s",strtotime($fecha));
					$dataPrint['caja']="Caja 1";
					$dataPrint['doc_numero']=$numero_ticket;
					$dataPrint['cliente']=$cliente;
					$dataPrint['dui_cliente']=$dui;
					$dataPrint['nit_cliente']="";
					$dataPrint['nrc_cliente']="";
					$dataPrint['diascred']="";
					$dataPrint['condicion']="Contado";
					$dataPrint['condicion_num']=0;
					$dataPrint['direccion_cliente']="";
					$dataPrint['cajero']=$this->session_['username'];
					$dataPrint['vendedor']=$this->session_['username'];
					$dataPrint['referencia']="D-".$dev;
					$dataPrint['efectivo']=$total;
					
					$dataPrint['productos_normal']=json_decode (json_encode ($productosPrint), FALSE);
					$dataPrint['productos_interno']=json_decode (json_encode ($productosPrint), FALSE);
					$dataPrint['totales']=array();
					$dataPrint['totales']["totalTotal"]=number_format($total,2);
					$dataPrint['totales']["totalGrabadas"]=number_format($total,2);
					$dataPrint['totales']["totalExento"]=number_format(0,2);
					$dataPrint['totales']["totalNS"]=number_format(0,2);
					$dataPrint['totales']["totalIVA"]=number_format(0,2);
					$dataPrint['totales']["propina"]=number_format(0,2);
					$dataPrint['totales']["Descuento"]=number_format(0,2);
					
					$dataPrint['total_interno']=number_format($total,2);
					$this->imprimirFactura($dataPrint,1);
					echo true;
				}
			}
		}
		function modalhome(){
			$UIDataModal["title"]='Nueva modal';
			$UIDataModal["content_view"]="home/home_modal_view";
			$UIDataModal["classes"]="modal-lg";
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