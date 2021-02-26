<?php
class Callcenter extends CI_Controller{
	function __construct(){
		parent::__construct();
		/* $this->is_logged_in(); */
		$this->load->model('Callcenter_model');
		$this->restaurante_id=5; /*ID RESTAURANTE <- Colocar id del restaurante correspondiente, verificar usando funcion http://[direccion_sistema_sucursal]/callcenter/comprobar_restaurante*/
	}
	function comprobar_restaurante(){
		$restaurante_callcenter=$this->Callcenter_model->get("q","restaurantes","id_restaurante,nombre_restaurante,direccion_restaurante,nombre_departamento,nombre_municipio",array("id_restaurante"=>$this->restaurante_id),"","",array("departamentos"=>"departamentos.id_departamento=restaurantes.id_departamento","municipios"=>"municipios.id_municipio=restaurantes.id_municipio"));
		echo "<div style='text-align:center;'>";
		if(count($restaurante_callcenter)){
			echo "El restaurante local debe ser: <br>";
			echo "<h2>".$restaurante_callcenter[0]->nombre_restaurante." (ID: ".$restaurante_callcenter[0]->id_restaurante.")</h2><br>";
			echo "<span>".$restaurante_callcenter[0]->nombre_restaurante.", ".$restaurante_callcenter[0]->nombre_municipio.", ".$restaurante_callcenter[0]->direccion_restaurante."</span>";
		}else{
			echo "No se han encontrado el restaurante especificado (ID: ".$this->restaurante_id.") <b>Se debe verificar antes de continuar con cualquier otra accion</b>";
		}
		echo "</div>";
	}
	function exportar_menus(){
		/*Obtener menus*/
		$time=gmdate('Y-m-d H:i:s',strtotime('- 6 hours')); 
		echo $time." : Iniciar exportacion de menus locales.<br>";
		$menus_locales_data=array();
		$menus_locales=$this->Generic_model->get("q","menus","id_menu,nombre_menu");
		if(count($menus_locales)){
			foreach($menus_locales as $menu_local){
				$menus_locales_data[]=array(
					"id_menu_local"=>$menu_local->id_menu,
					"id_restaurante"=>$this->restaurante_id,
					"nombre_menu"=>$menu_local->nombre_menu
				);
			}
		}
		/*Guardar menus*/
		if(count($menus_locales_data)){
			$time=gmdate('Y-m-d H:i:s',strtotime('- 6 hours')); 
			echo $time." : Guardar menus en call center. <br>";
			if($this->Callcenter_model->savebatch("menus",$menus_locales_data)){
				$time=gmdate('Y-m-d H:i:s',strtotime('- 6 hours')); 
				echo $time." : Proceso de exportacion de menu ha concluido. <br>";
				echo "<a href='".base_url()."callcenter/exportar_categorias'>Continuar exportando categorias.</a>";
			}else{
				$time=gmdate('Y-m-d H:i:s',strtotime('- 6 hours')); 
				echo $time." : Ha ocurrido un problema reinicie la base de datos e intentelo nuevamente.<br>";
			}
		}
	}
	function exportar_categorias(){
		/*Obtener menus en callcenter*/
		$time=gmdate('Y-m-d H:i:s',strtotime('- 6 hours')); 
		echo $time." : Iniciar exportacion de categorias locales.<br>";
		echo $time." : Obtener menus en call center.<br>";
		$menus_callcenter=$this->Callcenter_model->get("q","menus","id_menu,id_menu_local",array("id_restaurante"=>$this->restaurante_id));
		$cats_menus_locales_data=array();
		if(count($menus_callcenter)){
			$time=gmdate('Y-m-d H:i:s',strtotime('- 6 hours')); 
			echo $time." : Obtener categorias locales.<br>";
			foreach($menus_callcenter as $menu_callcenter){
				$categorias_locales=$this->Generic_model->get("q","categorias_menu","id_categoria_menu,nombre_categoria_menu",array("id_menu"=>$menu_callcenter->id_menu_local));
				if(count($categorias_locales)){
					foreach($categorias_locales as $categoria_local){
						$cats_menus_locales_data[]=array(
							"id_categoria_menu_local"=>$categoria_local->id_categoria_menu,
							"id_menu"=>$menu_callcenter->id_menu,
							"id_restaurante"=>$this->restaurante_id,
							"nombre_categoria_menu"=>$categoria_local->nombre_categoria_menu
						);
					}
				}
			}
			
		}
		/*Guardar categorias*/
		if(count($cats_menus_locales_data)){
			$time=gmdate('Y-m-d H:i:s',strtotime('- 6 hours')); 
			echo $time." : Guardar categorias en call center. <br>";
			if($this->Callcenter_model->savebatch("categorias_menu",$cats_menus_locales_data)){
				$time=gmdate('Y-m-d H:i:s',strtotime('- 6 hours')); 
				echo $time." : Proceso de exportacion de categorias ha concluido. <br>";
				echo "<a href='".base_url()."callcenter/exportar_platos'>Continuar exportando platos.</a>";
			}else{
				$time=gmdate('Y-m-d H:i:s',strtotime('- 6 hours')); 
				echo $time." : Ha ocurrido un problema reinicie la base de datos e intentelo nuevamente.<br>";
			}
		}
	}
	function exportar_platos(){
		/*Obtener platos locales*/
		$time=gmdate('Y-m-d H:i:s',strtotime('- 6 hours')); 
		echo $time." : Iniciar exportacion de platos locales.<br>";
		echo $time." : Obtener platos locales.<br>";
		$platos_locales=$this->Generic_model->get("q","platos","id_plato,nombre_plato,descripcion_plato,precio_plato",array("id"));
		$platos_locales_data=array();
		if(count($platos_locales)){
			foreach($platos_locales as $plato_local){
				$platos_locales_data[]=array(
					"id_plato_local"=>$plato_local->id_plato,
					"id_restaurante"=>$this->restaurante_id,
					"nombre_plato"=>$plato_local->nombre_plato,
					"descripcion_plato"=>$plato_local->descripcion_plato,
					"precio_plato"=>$plato_local->precio_plato
				);
			}
		}
		/*Guardar platos*/
		if(count($platos_locales_data)){
			$time=gmdate('Y-m-d H:i:s',strtotime('- 6 hours')); 
			echo $time." : Guardar platos en call center.<br>";
			if($this->Callcenter_model->savebatch("platos",$platos_locales_data)){
				$time=gmdate('Y-m-d H:i:s',strtotime('- 6 hours')); 
				echo $time." : Proceso de exportacion de platos ha concluido. <br>";
				echo "<a href='".base_url()."callcenter/vincular_platos'>Continuar vinculando platos y categorias.</a>";
			}else{
				$time=gmdate('Y-m-d H:i:s',strtotime('- 6 hours')); 
				echo $time." : Ha ocurrido un problema reinicie la base de datos e intentelo nuevamente.<br>";
			}
			
		}
	}
	function vincular_platos(){
		/*Obtener categorias call center*/
		$time=gmdate('Y-m-d H:i:s',strtotime('- 6 hours')); 
		echo $time." : Iniciar proceso de vinculacion de platos y categorias.<br>";
		echo $time." : Obtener categorias Call center.<br>";
		$categorias_callcenter=$this->Callcenter_model->get("q","categorias_menu","id_categoria_menu,id_categoria_menu_local",array("id_restaurante"=>$this->restaurante_id));
		$formated_categorias=array();
		if(count($categorias_callcenter)){
			foreach($categorias_callcenter as $categoria_callcenter){
				$formated_categorias[$categoria_callcenter->id_categoria_menu_local]=$categoria_callcenter->id_categoria_menu;
			}
		}
		/*Obtener platos call center*/
		$time=gmdate('Y-m-d H:i:s',strtotime('- 6 hours')); 
		echo $time." : Obtener platos Call center.<br>";
		$platos_callcenter=$this->Callcenter_model->get("q","platos","id_plato,id_plato_local",array("id_restaurante"=>$this->restaurante_id));
		$formated_platos=array();
		if(count($platos_callcenter)){
			foreach($platos_callcenter as $plato_callcenter){
				$formated_platos[$plato_callcenter->id_plato_local]=$plato_callcenter->id_plato;
			}
		}
		/*Obtener categorias locales*/
		$time=gmdate('Y-m-d H:i:s',strtotime('- 6 hours')); 
		echo $time." : Obtener relaciones platos/categorias Local.<br>";
		$relaciones_locales=$this->Generic_model->get("q","platosxcategoria","*");
		$relaciones_locales_data=array();
		if(count($relaciones_locales) && count($formated_categorias) && count($formated_platos)){
			foreach($relaciones_locales as $relacion_local){
				$relaciones_locales_data[]=array(
					"id_categoria_menu"=>$formated_categorias[$relacion_local->id_categoria_menu],
					"id_plato"=>$formated_platos[$relacion_local->id_plato]
				);
			}
		}
		if(count($relaciones_locales_data)){
			$time=gmdate('Y-m-d H:i:s',strtotime('- 6 hours')); 
			echo $time." : Guardar relaciones platos/categorias en call center. <br>";
			if($this->Callcenter_model->savebatch("platosxcategoria",$relaciones_locales_data)){
				$time=gmdate('Y-m-d H:i:s',strtotime('- 6 hours')); 
				echo $time." : Proceso de exportacion de relaciones platos/categorias ha concluido. <br>";
				echo "Proceso de habilitacion de restaurante en sistema de callcenter concluido</a>";
			}else{
				$time=gmdate('Y-m-d H:i:s',strtotime('- 6 hours')); 
				echo $time." : Ha ocurrido un problema reinicie la base de datos e intentelo nuevamente.<br>";
			}
		}
	}
	/*--------------------------------------------------------------------------------------------------------*/
	function descargar_ordenes_(){
		$select="id_orden,fecha_orden,clientes.nombre_cliente as cliente,telefono_orden,notas_orden,total_orden,cambio_orden";
		$select.=",ordenes.id_direccion,departamentos.id_departamento,departamentos.nombre_departamento,municipios.nombre_municipio,direcciones.complemento_direccion,direcciones.notas_direccion";
		$joins=array(
			"clientes"=>"clientes.id_cliente=ordenes.id_cliente",
			"direcciones"=>"direcciones.id_direccion=ordenes.id_direccion",
			"departamentos"=>"departamentos.id_departamento=direcciones.id_departamento",
			"municipios"=>"municipios.id_municipio=direcciones.id_municipio"
		);
		$ordenes=$this->Callcenter_model->get("q","ordenes",$select,array("id_restaurante"=>$this->restaurante_id,"estado_orden"=>0),"","",$joins);
		if(count($ordenes)):
			foreach($ordenes as $orden):
				$orden->platos=$this->Callcenter_model->get("q","platosxorden","*",array("id_orden"=>$orden->id_orden),"","",array("platos"=>"platos.id_plato=platosxorden.id_plato"));
			endforeach;
			echo "<pre>";
			print_r($ordenes);
			echo "</pre>";
		endif;
	}
	function descargar_ordenes(){
		$select="id_orden,fecha_orden,clientes.nombre_cliente as cliente,telefono_orden,notas_orden,total_orden,cambio_orden,formapago_orden";
		$select.=",ordenes.id_direccion,departamentos.id_departamento,departamentos.nombre_departamento,municipios.nombre_municipio,direcciones.complemento_direccion,direcciones.notas_direccion";
		$select.=",usuarios.id_usuario,usuarios.nombre_usuario";
		$joins=array(
			"usuarios"=>"usuarios.id_usuario=ordenes.id_usuario",
			"clientes"=>"clientes.id_cliente=ordenes.id_cliente",
			"direcciones"=>"direcciones.id_direccion=ordenes.id_direccion",
			"departamentos"=>"departamentos.id_departamento=direcciones.id_departamento",
			"municipios"=>"municipios.id_municipio=direcciones.id_municipio"
		);
		$ordenes=$this->Callcenter_model->get("q","ordenes",$select,array("id_restaurante"=>$this->restaurante_id,"estado_orden"=>0),"","",$joins);
		if(count($ordenes)):
			foreach($ordenes as $orden):
				$platos=$this->Callcenter_model->get("q","platosxorden","platos.nombre_plato,platos.id_plato_local,platosxorden.precio_plato,platosxorden.cantidad_plato,platosxorden.notas_platoxorden",array("id_orden"=>$orden->id_orden),"","",array("platos"=>"platos.id_plato=platosxorden.id_plato"));
				/*Cargar configuraciones*/
				$config= (object) array(
					"numero_orden"=>(object) array("db_campo"=>"ordenes_numero_orden_actual","default"=>0)
				);
				$config=$this->ufood_utilities->get_conf_value($config);
				/*Fecha*/
				$fecha=gmdate('Y-m-d H:i:s',strtotime('- 6 hours'));
				/*Numero de orden*/
				$numero_orden=$config->numero_orden->value+1;
				/*totales*/
				$subtotal=(float)$orden->total_orden;
				
				$orden_data=array(
					"id_salon"=>null,
					"id_mesa"=>null,
					"usuario_orden"=>null,
					"usuario_callcenter_orden"=>$orden->nombre_usuario,
					"num_orden"=>$numero_orden,
					"fecha_orden"=>$fecha,
					"servicio_orden"=>2,
					"cliente_orden"=>$orden->cliente,
					"telefono_cliente"=>$orden->telefono_orden,
					"direccion_cliente"=>$orden->nombre_municipio." ".$orden->complemento_direccion.", ".$orden->notas_direccion,
					"estado_orden"=>0,
					"origen_orden"=>1,
					"sub_total_orden"=>$subtotal,
					"formapago_orden"=>$orden->formapago_orden,
					"propina_orden"=>0,
					"descuento_orden"=>0
				 );
				/*Guardar orden*/
				$orden_local=$this->Generic_model->save("ordenes",$orden_data,true);
				/*Actializar num orden*/
				$this->Generic_model->update("config",array("valor_config"=>$numero_orden."|i"),array("campo_config"=>"ordenes_numero_orden_actual"));
				
				if($orden_local){
					$impresos=array();
					/*Platos de la orden*/
					foreach($platos as $plato){
						$platoxorden_data=array(
							"id_orden"=>$orden_local,
							"id_plato"=>$plato->id_plato_local,
							"id_mesero"=>null,
							"id_salon"=>null,
							"id_mesa"=>null,
							"fecha_enviado_plato"=>$fecha,
							"despachado_plato"=>0,
							"eliminado_plato"=>0,
							"cantidad_plato"=>$plato->cantidad_plato,
							"precio_plato"=>$plato->precio_plato,
							"notas_platoxorden"=>$plato->notas_platoxorden
						);
						/*Guardar platosxorden*/
						$platoxorden=$this->Generic_model->save("platosxorden",$platoxorden_data,true);
						
						/*Agregar a arreglo de impresion*/
						$platos_print_array[]=array(
							"cant"=>$plato->cantidad_plato,
							"plato"=>$plato->nombre_plato,
							"acompanamientos"=>"",
							"notas"=>$plato->notas_platoxorden
						);
						
						$cocinaxplato=$this->Generic_model->get("q","platosxrestaurante","cocinas.impresor_cocina,cocinas.nombre_cocina,cocinas.anchopapel_cocina",array("id_plato"=>$plato->id_plato_local,"id_restaurante"=>1),"","",array("cocinas"=>"cocinas.id_cocina=platosxrestaurante.id_cocina"));
						
						if(isset($cocinaxplato[0]->impresor_cocina)){
							if(array_key_exists ($cocinaxplato[0]->impresor_cocina,$impresos)){
								$impresos[$cocinaxplato[0]->impresor_cocina]["platos"][]=array($plato->cantidad_plato,$plato->nombre_plato,"",$plato->notas_platoxorden);
							}else{
								$impresos[$cocinaxplato[0]->impresor_cocina]=array(
									"fecha"=>$fecha,
									"cocina"=>$cocinaxplato[0]->nombre_cocina,
									"anchopapel"=>$cocinaxplato[0]->anchopapel_cocina,
									"id_orden"=>$orden_local,
									"servicio"=>"A domicilio",
									"direccion"=>$orden->nombre_municipio." ".$orden->complemento_direccion.", ".$orden->notas_direccion,
									"telefono"=>$orden->telefono_orden,
									"cambio"=>$orden->cambio_orden,
									"mesa"=>"N/A",
									"mesero"=>"",
									"cliente"=>$orden->cliente,
									"notas"=>$orden->notas_orden,
									"formapago"=>($orden->formapago_orden==0)?"Efectivo":"POS",
									"platos"=>array(
										array($plato->cantidad_plato,$plato->nombre_plato,"",$plato->notas_platoxorden)
									)
								);
							}
						}
					}
				}
				if(count($impresos)){
					$printData["impresos"]=$impresos;
					$this->load->view("impresos/orden_callcenter_view",$printData);
				}
				
				$this->Callcenter_model->update("ordenes",array("estado_orden"=>1,"descarga_orden"=>$fecha),array("id_orden"=>$orden->id_orden));
			endforeach;
		endif;
	}
}