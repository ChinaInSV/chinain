var Ordenes_nueva=function(){
	this.baseUrl=null;
	this.windowId=null;
	this.mode=null;
	this.ordenWizardSchema=null;
	this.ordenWizardCurrentStep=0;
	this.modal=null;
	this.config=null;
	this.idPlato=1;
	/*INICIO*/
	this.initializeEnviroment=function(url,winId,config,mode){
		this.baseUrl=url;
		this.windowId=winId;
		this.config=config;
		this.mode=mode;
		this.initializeGUIComponets();
		this.initializeListeners();
		this.initializeHotKeys();
		
		if(mode=="update"){
			this.calcTotales();
		}
	},
	this.test=function(){
		console.log("La clase Ordenes Nueva se ha instanseado desde: "+this.baseUrl, " en la ventana: "+this.windowId);
	},
	/*Inicializar componentes de la interfaz*/
	this.initializeGUIComponets=function(){
		var _this=this;	
		this.modal={
			acompanamientos:$("#nueva-orden-acompanamientos-plato-"+_this.windowId),
			confirmar:$("#nueva-orden-confirmar-guardar-"+_this.windowId),
			modificar_precios:$("#nueva-orden-modificar-precios-"+_this.windowId),
			procesar_venta:$("#facturacion-app-procesar-venta-"+_this.windowId)
		}
	}
	/*EVENTOS*/
	this.initializeListeners=function(){
		var _this=this;
		/*BOTONES anterior y siguiente de asistente de nueva orden (CLICK)*/
		$("#"+this.windowId+" #nueva-orden-buttons-wrapper").on('click','.btn-nueva-orden-wizzard',function(e){
			var action=$(this).attr("data-action");
			var nextStep=0;
			switch(action){
				case "prev":nextStep=_this.ordenWizardCurrentStep-1;break;
				case "next":nextStep=_this.ordenWizardCurrentStep+1;break;
			}
			if(nextStep>=0){
				if(nextStep<_this.ordenWizardSchema.length){
					if(_this.validateStep(_this.ordenWizardCurrentStep)){/*Validar paso*/
						$("#"+_this.windowId+" #"+_this.ordenWizardSchema[_this.ordenWizardCurrentStep]).hide();
						_this.ordenWizardCurrentStep=nextStep;
						$("#"+_this.windowId+" #"+_this.ordenWizardSchema[_this.ordenWizardCurrentStep]).show();
						if(nextStep==1){/*Contenido de la orden*/
							if($("#"+_this.windowId+" #nueva-orden-modo-lista-wrapper").is(":visible")){
								$("#"+_this.windowId+" #nueva-orden-lista-plato-txt").focus();
							}
						}
					}
				}else if(nextStep==_this.ordenWizardSchema.length){/*Guardar*/
					/* Custombox.close(); */
					_this.validarGuardarOrden();
				}
				
			}
		});		
		/*BOTONES SALONES Seleccionar salon (CLICK)*/
		$("#"+this.windowId+" #nueva-orden-salones-wrapper").on("click",".btn-salon > button",function(){
			var $salon=$(this);
			var idSalon=$salon.data("id");
			$mesas=$("#"+_this.windowId+" #nueva-orden-mesas-wrapper").find(".btn-mesa");
			$mesas.each(function(i,mesa){
				var mesaSalonId=$($(mesa).find("button")[0]).data("salon");
				if(mesaSalonId!=idSalon){
					$(mesa).hide();
				}else{
					$(mesa).show();
				}
				$($(mesa).find("button")[0]).removeClass("active");
			});
		});
		/*BOTONES MODO MENU Seleccionar modo de menu (CLICK)*/
		$("#"+this.windowId+" #nueva-orden-menu-mode-view-wrapper > button").click(function(e){
			var $option=$(this);
			$("#"+_this.windowId+" #nueva-orden-menu-mode-view-wrapper > button.active").removeClass("active");
			 $option.addClass("active");
			var modo=$option.data("mode");
			if(modo=="lista" && !$("#"+_this.windowId+" #nueva-orden-modo-lista-wrapper").is(":visible")){
				$("#"+_this.windowId+" #nueva-orden-modo-lista-wrapper").show();
				$("#"+_this.windowId+" #nueva-orden-modo-menu-wrapper").hide();
				$("#"+_this.windowId+" #nueva-orden-menus-wrapper").hide();
				$("#"+_this.windowId+" #nueva-orden-lista-plato-txt").focus();
			}
			else if(modo=="menu" && !$("#"+_this.windowId+" #nueva-orden-modo-menu-wrapper").is(":visible")){
				$("#"+_this.windowId+" #nueva-orden-modo-menu-wrapper").show();
				$("#"+_this.windowId+" #nueva-orden-menus-wrapper").show();
				$("#"+_this.windowId+" #nueva-orden-modo-lista-wrapper").hide();
			}
		});
		/*===========================================================================*/
		/*------------------------------------------ MODO LISTA -----------------------------------------*/
		/*TEXTBOX Buscar platos en la lista (KEYUP)*/
		$("#"+this.windowId+" #nueva-orden-lista-plato-txt").keyup(function(e){
			if(e.which==38 || e.keyCode==38){/*Ir arriba*/
				e.preventDefault();
				_this.listaPlatosGoTop();
			}
			else if(e.which==40 || e.keyCode==40){/*Ir abajo*/
				e.preventDefault();
				_this.listaPlatosGoBottom();
			}
			else if(e.which==13 || e.keyCode==13){/*Seleccionar*/
				e.preventDefault();
				 var currentSel=$("#"+_this.windowId+" #nueva-orden-lista-platos-wrapper > table > tbody > tr.table-selected-item");
				if(currentSel.length){
					$("#"+_this.windowId+" #nueva-orden-lista-plato-txt").val(currentSel.data("nombre"));
					$("#"+_this.windowId+" #nueva-orden-lista-plato-txt").attr("readonly","true");
					$("#"+_this.windowId+" #nueva-orden-lista-plato-cant-txt").select();
				}
			}
			else{/*Filtrar*/
				var searchVal=$.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();
				var $rows=$("#"+_this.windowId+" #nueva-orden-lista-platos-wrapper > table > tbody tr")
				$rows.show().filter(function() {
					var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
					return !~text.indexOf(searchVal);
				}).hide();
				$("#"+_this.windowId+" #nueva-orden-lista-platos-wrapper > table > tbody tr.table-selected-item").removeClass("table-selected-item");
				$("#"+_this.windowId+" #nueva-orden-lista-platos-wrapper > table > tbody tr:visible:first").addClass("table-selected-item");
			}
		});
		/*CELDA usar un plato una celda (DOBLECLICK)*/
		$("#"+this.windowId+" #nueva-orden-lista-platos-wrapper").on("click","table > tbody > tr", function(){
			$(this).closest("table").find("tr.table-selected-item").removeClass("table-selected-item");
			$(this).addClass("table-selected-item");
		});
		/*CELDA Seleccionar una celda (CLICK)*/
		$("#"+this.windowId+" #nueva-orden-lista-platos-wrapper").on("dblclick","table > tbody > tr", function(){
			$(this).closest("table").find("tr.table-selected-item").removeClass("table-selected-item");
			$(this).addClass("table-selected-item");
			$("#"+_this.windowId+" #nueva-orden-lista-plato-txt").val($(this).data("nombre"));
			$("#"+_this.windowId+" #nueva-orden-lista-plato-txt").attr("readonly","true");
			$("#"+_this.windowId+" #nueva-orden-lista-plato-cant-txt").select();
		});
		/*BOTON Agregar plato a la orden CLICK*/
		$("#"+_this.windowId+" #nueva-orden-lista-agregar-btn").click(function(){
			var currentSel=$("#"+_this.windowId+" #nueva-orden-lista-platos-wrapper > table > tbody > tr.table-selected-item");
			if(currentSel.length){
				var cant=$("#"+_this.windowId+" #nueva-orden-lista-plato-cant-txt").val();
				cant=parseInt(cant);
				if(isNaN(cant)){
					cant=1;
				}		
				$("#"+_this.windowId+" #nueva-orden-agregar-plato-id").val(currentSel.data("id"));
				$("#"+_this.windowId+" #nueva-orden-agregar-plato-categoria").val(currentSel.data("categoria"));
				$("#"+_this.windowId+" #nueva-orden-agregar-plato-cant").val(cant);
				$("#"+_this.windowId+" #nueva-orden-agregar-plato-nombre").val(currentSel.data("nombre"));
				$("#"+_this.windowId+" #nueva-orden-agregar-plato-precio").val(currentSel.data("precio"));
				$("#"+_this.windowId+" #nueva-orden-agregar-plato-acompanamientos").val((currentSel.data("acompanamientos")!=""?JSON.stringify(currentSel.data("acompanamientos")):""));
				$("#"+_this.windowId+" #nueva-orden-agregar-plato-notas").val((currentSel.data("notas")!=""?JSON.stringify(currentSel.data("notas")):""));
				$("#"+_this.windowId+" #nueva-orden-agregar-plato-modo").val("set");
				_this.validarAgregarPlato();
				_this.listaResetParam();
			}
		});
		/*BOTON Limpiar campo de buscar plato CLICK*/
		$("#"+_this.windowId+" #nueva-orden-lista-plato-clear").click(function(){
			_this.listaResetParam();
		});
		/*=========================================================================*/
		/*----------------------------------------- MODO MENU ---------------------------------------*/
		/*BOTONES MENU Seleccionar menu (CLICK)*/
		$("#"+this.windowId+" #nueva-orden-menus-wrapper").on("click",".btn-menu",function(){
			/*Limpiar div platos*/
			$platos=$("#"+_this.windowId+" #nueva-orden-platos-wrapper").find(".btn-plato");
			$platos.each(function(i,plato){
				$(plato).hide();
			});
			/*Mostrar mensaje de seleccion de categorias*/
			$("#"+_this.windowId+" #nueva-orden-selcat-msg-wrapper").show();
			/*Mostrar categorias del menu seleccionado*/
			var idMenu=$(this).data("id");
			$catsMenu=$("#"+_this.windowId+" #nueva-orden-categorias-wrapper").find(".btn-cat-menu");
			$catsMenu.each(function(i,categoria){
				var catMenuId=$(categoria).data("menu");
				if(catMenuId!=idMenu){
					$(categoria).hide();
				}else{
					$(categoria).show();
				}
				$(categoria).removeClass("active");
			});
		});
		/*BOTONES CATEGORIAS Seleccionar una categoria (CLICK)*/
		$("#"+this.windowId+" #nueva-orden-categorias-wrapper").on("click",".btn-cat-menu",function(){
			/*Ocultar mensaje de seleccion de categorias*/
			$("#"+_this.windowId+" #nueva-orden-selcat-msg-wrapper").hide();
			var idCat=$(this).data("id");
			$platos=$("#"+_this.windowId+" #nueva-orden-platos-wrapper").find(".btn-plato");
			$platos.each(function(i,plato){
				var platoIdCat=$($(plato).find("button")[0]).data("categoria");
				if(platoIdCat!=idCat){
					$(plato).hide();
				}else{
					$(plato).show();
				}
			});
		});
		/*BOTONES aumentar o disminuir la cantidad de platos a agregar (CLICK)*/
		$("#"+this.windowId+" .btn-platos-cant-selector").click(function(e){
			var func=$(this).data("function");
			var cantPlatos=$("#"+_this.windowId+" #norden-menu-cant-platos").val();
			cantPlatos=parseInt(cantPlatos);
			if(!isNaN(cantPlatos)){
				var newCant=0;
				if(func=="add"){
					newCant=cantPlatos+1;
				}else{
					newCant=cantPlatos-1;
				}
				if(newCant>0){
					$("#"+_this.windowId+" #norden-menu-cant-platos").val(newCant);
				}
			}else{
				$("#"+_this.windowId+" #norden-menu-cant-platos").val("1");
			}
		});
		/*BOTONES agregar plato a la orden (CLICK)*/
		$("#"+this.windowId+" #nueva-orden-platos-wrapper").on("click",".btn-plato > button",function(){
			var plato=$(this);
			/*Cantidad*/
			var cant=$("#"+_this.windowId+" #norden-menu-cant-platos").val();
			cant=parseInt(cant);
			if(isNaN(cant)){
				cant=1;
			}
			$("#"+_this.windowId+" #nueva-orden-agregar-plato-categoria").val(plato.data("categoria"));
			$("#"+_this.windowId+" #nueva-orden-agregar-plato-id").val(plato.data("id"));
			$("#"+_this.windowId+" #nueva-orden-agregar-plato-cant").val(cant);
			$("#"+_this.windowId+" #nueva-orden-agregar-plato-nombre").val(plato.text());
			$("#"+_this.windowId+" #nueva-orden-agregar-plato-precio").val(plato.data("precio"));
			$("#"+_this.windowId+" #nueva-orden-agregar-plato-acompanamientos").val((plato.data("acompanamientos")!=""?JSON.stringify(plato.data("acompanamientos")):""));
			$("#"+_this.windowId+" #nueva-orden-agregar-plato-notas").val((plato.data("notas")!=""?JSON.stringify(plato.data("notas")):""));
			$("#"+_this.windowId+" #nueva-orden-agregar-plato-modo").val("set");
			/*Agregar a tabla*/
			_this.validarAgregarPlato();
			/*reiniciar cant platos*/
			$("#"+_this.windowId+" #norden-menu-cant-platos").val("1");
		});
		/*=======================================================================*/	
		/*----------------------------- MODAL ACOMPANAMIENTOS ----------------------------------*/
		if(this.modal.acompanamientos){
			/*MODAL acciones al abrir modal de acompanamientos (SHOW)*/
			this.modal.acompanamientos.on("shown.bs.modal",function(){
				$(this).find("select:first").focus();
			});
			/*SELECT Elegir un acompanamiento (ENTER)*/
			this.modal.acompanamientos.on('keydown',' #nueva-orden-acompanamientos-wrapper select', function(e){
				var modalID=_this.modal.acompanamientos.attr("id");
				 if(e.which==13 || e.keyCode==13){
					e.preventDefault();
					var nextSelect=$(this).closest('div').next('div').find("select");
					if(nextSelect.length){
						nextSelect.focus();
					}else{
						$("#"+modalID+" #nueva-orden-acompanamientos-notas-continuar-btn").focus();
					}
				 }
			});
			/*BOTONES Agregar una nota predeterminada*/
			this.modal.acompanamientos.on("click","#nueva-orden-acompanamientos-notas-wrapper button",function(){
				var notasTxt=$("#"+_this.modal.acompanamientos.attr("id")+" #nueva-orden-notas-txt");
				if($.trim(notasTxt.text()).length>1){
					notasTxt.text(notasTxt.text()+", "+$(this).data("texto"));
				}else{
					notasTxt.text($(this).data("texto"));
				}
			});
			/*BOTON Continuar seteando acompanamientos (CLICK)*/
			this.modal.acompanamientos.on("click"," #nueva-orden-acompanamientos-notas-continuar-btn",function(){
				var modalID=_this.modal.acompanamientos.attr("id");
				/*Validar categorias*/
				var validCats=true;
				var catSelects=$("#"+modalID+" #nueva-orden-acompanamientos-wrapper select");
				var setCats=[];
				if(catSelects.length){
					catSelects.each(function(i,catSelect){
						catSelectData=$(catSelect).data();
						if(catSelectData.required && $(catSelect).find("option:selected").val()==""){/*Mostrar mensaje de error*/
							validCats=false;
							uFoodTools.showMsg("error","Necesita Seleccionar una opci&oacute;n de <b>"+catSelectData.cat_acomp_nombre+"</b> para poder continuar");
							$(catSelect).focus();
						}
						else{/*Agregar a array de categorias con acompanamiento valido*/
							/*acompanamientos seleccionado para cada categoria*/
							setCats[catSelectData.cat_acompanamiento]=$(catSelect).find("option:selected").val();
						}
						return validCats;
					});
				}
				if(validCats){
					if(catSelects.length){
						var selectCatArray=[];
						var catAcompanamientos=$("#"+_this.windowId+" #nueva-orden-agregar-plato-acompanamientos").val();						
						if(typeof catAcompanamientos==="string"){
							catAcompanamientos=JSON.parse(catAcompanamientos);
							if(typeof catAcompanamientos==="string"){
								catAcompanamientos=JSON.parse(catAcompanamientos);
							}
						}
						/*marcar acompanamientos seleccionados de cada categoria*/
						$.each(catAcompanamientos,function(i,catAcom){
							var selitem=setCats[catAcom.id];
							selitem=parseInt(selitem);
							if(!isNaN(selitem)){
								$.each(catAcom.acompanamientos,function(ii,acompanamiento){
									if(acompanamiento.id==selitem){
										acompanamiento.selected="1";
									}else{
										acompanamiento.selected="0";
									}
								});
							}
							else{
								$.each(catAcom.acompanamientos,function(ii,acompanamiento){
									acompanamiento.selected="0";
								});
							}
						});
					}else{
						catAcompanamientos="";
					}
					/*Agregar plato*/
					var id=$("#"+_this.windowId+" #nueva-orden-agregar-plato-id").val();
					var categoria=$("#"+_this.windowId+" #nueva-orden-agregar-plato-categoria").val();
					var cant=$("#"+_this.windowId+" #nueva-orden-agregar-plato-cant").val();
					var nombre=$("#"+_this.windowId+" #nueva-orden-agregar-plato-nombre").val();
					var precio=$("#"+_this.windowId+" #nueva-orden-agregar-plato-precio").val();
					var prenotas=($("#"+_this.windowId+" #nueva-orden-agregar-plato-notas").val()!=""?JSON.parse($("#"+_this.windowId+" #nueva-orden-agregar-plato-notas").val()):"");
					var notas=$("#"+modalID+" #nueva-orden-notas-txt").text();
					var modo=$("#"+_this.windowId+" #nueva-orden-agregar-plato-modo").val();
					
					_this.agregarPlato(modo,id,cant,nombre,precio,catAcompanamientos,prenotas,notas,categoria);
					_this.modal.acompanamientos.modal('hide');
					 /* $("#"+modalID).appendTo("#"+_this.windowId+" #nueva-orden-modals-wrapper"); */
				}
			});
			/*MODAL acciones al cerrar modal de acompanamientos (HIDDEN)*/
			this.modal.acompanamientos.on("hidden.bs.modal",function(){
				$(this).appendTo("#"+_this.windowId+" #nueva-orden-modals-wrapper");
			});
		}		
		/*=======================================================================*/	
		/*--------------------- MODAL MODIFICAR PRECIOS --------------------------*/
		if(this.modal.modificar_precios){
			/*BOTON Continuar modificar precios (CLICK)*/
			this.modal.modificar_precios.on("click","#nueva-orden-cantidades-actualizar-btn",function(){
				var selPlato=$("#"+_this.windowId+" #nueva-orden-platos-tabla tr.table-selected-item");
				cant=parseFloat(_this.modal.modificar_precios.find("#nueva-orden-cantidades-cantidad").val());
				precio=parseFloat(_this.modal.modificar_precios.find("#nueva-orden-cantidades-costo").val());
				total=cant*precio;
				cant=cant.toFixed(_this.config.cant_decimal_precision);
				precio=precio.toFixed(_this.config.precios_decimal_precision);
				total=total.toFixed(_this.config.precios_decimal_precision);
				
				if(_this.modal.modificar_precios.find("#nueva-orden-cantidades-cantidad").val()<= 0 || _this.modal.modificar_precios.find("#nueva-orden-cantidades-cantidad").val()==""){
					_this.showMsg("error","Debe ingresar la cantidad de servicio para poder continuar");
					$("#"+_this.windowId+" #nueva-orden-cantidades-cantidad").focus();
				}else if(_this.modal.modificar_precios.find("#nueva-orden-cantidades-costo").val()<= 0 || _this.modal.modificar_precios.find("#nueva-orden-cantidades-costo").val()==""){
					_this.showMsg("error","Debe ingresar el costo de servicio para poder continuar");
					$("#"+_this.windowId+" #nueva-orden-cantidades-costo").focus();
				}else{
					total=(parseFloat(cant)*parseFloat(precio)).toFixed(2);
					selPlato.attr("data-total",total);
					selPlato.attr("data-cant",cant);
					selPlato.attr("data-precio",precio);					
					selPlato.find(".plato-cant-field").html(cant);
					selPlato.find(".plato-precio-field").html(precio);
					selPlato.find(".plato-total-field").html(total);
					
					_this.calcTotales();
					_this.modal.modificar_precios.modal('hide');
				}
				
			});
			this.modal.modificar_precios.on("click","#nueva-orden-cantidades-agregar-btn",function(){
				/*Agregar plato*/
				var id=$("#"+_this.windowId+" #nueva-orden-agregar-plato-id").val();
				var categoria=$("#"+_this.windowId+" #nueva-orden-agregar-plato-categoria").val();
				//var cant=$("#"+_this.windowId+" #nueva-orden-agregar-plato-cant").val();
				var nombre=$("#"+_this.windowId+" #nueva-orden-agregar-plato-nombre").val();
				//var precio=$("#"+_this.windowId+" #nueva-orden-agregar-plato-precio").val();
				var prenotas=($("#"+_this.windowId+" #nueva-orden-agregar-plato-notas").val()!=""?JSON.parse($("#"+_this.windowId+" #nueva-orden-agregar-plato-notas").val()):"");
				var modo=$("#"+_this.windowId+" #nueva-orden-agregar-plato-modo").val();
				var acompanamientos=$("#"+_this.windowId+" #nueva-orden-agregar-plato-acompanamientos").val();				
				
				if(_this.modal.modificar_precios.find("#nueva-orden-cantidades-cantidad").val()<= 0 || _this.modal.modificar_precios.find("#nueva-orden-cantidades-cantidad").val()==""){
					_this.showMsg("error","Debe ingresar la cantidad de servicio para poder continuar");
					$("#"+_this.windowId+" #nueva-orden-cantidades-cantidad").focus();
				}else if(_this.modal.modificar_precios.find("#nueva-orden-cantidades-costo").val()<= 0 || _this.modal.modificar_precios.find("#nueva-orden-cantidades-costo").val()==""){
					_this.showMsg("error","Debe ingresar el costo de servicio para poder continuar");
					$("#"+_this.windowId+" #nueva-orden-cantidades-costo").focus();
				}else{
					_this.agregarPlato(modo,id,_this.modal.modificar_precios.find("#nueva-orden-cantidades-cantidad").val(),nombre,_this.modal.modificar_precios.find("#nueva-orden-cantidades-costo").val(),acompanamientos,prenotas,"",categoria);
					_this.modal.modificar_precios.modal('hide');
				}
			});
			
			this.modal.modificar_precios.on("click",".nueva-orden-cantidades-disminuir-btn",function(){
				var $el = $(this);
				if($el.closest(".input-group").find(".nueva-orden-cantidades-texts").attr("id")=="nueva-orden-cantidades-cantidad"){
					var cantidadServicio=parseFloat($el.closest(".input-group").find(".nueva-orden-cantidades-texts").val()) - 1;
					if(cantidadServicio>0){
						$el.closest(".input-group").find(".nueva-orden-cantidades-texts").val(cantidadServicio);
					}
				}else{
					var costoServicio=parseFloat($el.closest(".input-group").find(".nueva-orden-cantidades-texts").val()) - 0.25;
					if(costoServicio>0){
						$el.closest(".input-group").find(".nueva-orden-cantidades-texts").val(costoServicio);
					}
				}
			});
			
			this.modal.modificar_precios.on("click",".nueva-orden-cantidades-aumentar-btn",function(){
				var $el = $(this);
				if($el.closest(".input-group").find(".nueva-orden-cantidades-texts").attr("id")=="nueva-orden-cantidades-cantidad"){
					var cantidadServicio=parseFloat($el.closest(".input-group").find(".nueva-orden-cantidades-texts").val()) + 1;
					$el.closest(".input-group").find(".nueva-orden-cantidades-texts").val(cantidadServicio);
				}else{
					var costoServicio=parseFloat($el.closest(".input-group").find(".nueva-orden-cantidades-texts").val()) + 0.25;
					$el.closest(".input-group").find(".nueva-orden-cantidades-texts").val(costoServicio);
				}
			});
			
			/*MODAL acciones al cerrar modal de modificar precios (HIDDEN)*/
			this.modal.modificar_precios.on("hidden.bs.modal",function(){
				$(this).appendTo("#"+_this.windowId+" #nueva-orden-modals-wrapper");
			});
		}
		/*=======================================================================*/	
		/*---------------------------------- TABLA DE PRODUCTOS ----------------------------------*/	
		/*CELDA Seleccionar un plato de la lista(CLICK)*/
		$("#"+this.windowId+" #nueva-orden-platos-tabla").on('click','tr',function(){
			var $parent=$(this).closest("table");
			var plato=$(this);
			$parent.find("tr.table-selected-item").removeClass('table-selected-item');
			plato.addClass('table-selected-item');
			platoData=plato.data();
			/* $("#"+_this.windowId+" #nueva-orden-herramientas-aumentar").prop("disabled","disabled");
			$("#"+_this.windowId+" #nueva-orden-herramientas-disminuir").prop("disabled","disabled");
			$("#"+_this.windowId+" #nueva-orden-herramientas-notas").prop("disabled","disabled");
			$("#"+_this.windowId+" #nueva-orden-herramientas-eliminar").prop("disabled","disabled"); */
				$("#"+_this.windowId+" #nueva-orden-herramientas-aumentar").removeAttr("disabled");
				$("#"+_this.windowId+" #nueva-orden-herramientas-disminuir").removeAttr("disabled");
				$("#"+_this.windowId+" #nueva-orden-herramientas-notas").removeAttr("disabled");
				$("#"+_this.windowId+" #nueva-orden-herramientas-eliminar").removeAttr("disabled");
				$("#"+_this.windowId+" #nueva-orden-herramientas-modificar").removeAttr("disabled");
			
		});
		/*BOTON Modificar la cantidad y precio de un plato (CLICK)*/
		$("#"+this.windowId+" #nueva-orden-herramientas-modificar").click(function(){
			var selPlato=$("#"+_this.windowId+" #nueva-orden-platos-tabla tr.table-selected-item");
			var nombre=selPlato.attr("data-nombre");
			var cant=selPlato.attr("data-cant");
			var precio=selPlato.attr("data-precio");
			_this.modal.modificar_precios.find(".modal-dialog > .modal-content > .modal-header > .modal-title > b").text(nombre);
			_this.modal.modificar_precios.find("#nueva-orden-cantidades-cantidad").val(cant);
			_this.modal.modificar_precios.find("#nueva-orden-cantidades-costo").val(precio);
			_this.modal.modificar_precios.find("#nueva-orden-cantidades-agregar-btn").addClass("hidden");
			_this.modal.modificar_precios.find("#nueva-orden-cantidades-actualizar-btn").removeClass("hidden");
			_this.modal.modificar_precios.modal('show');
			_this.modal.modificar_precios.appendTo("body");
		});
		/*BOTON Aumentar la cantidad de un plato (CLICK)*/
		$("#"+this.windowId+" #nueva-orden-herramientas-aumentar").click(function(){
			var selPlato=$("#"+_this.windowId+" #nueva-orden-platos-tabla tr.table-selected-item");
			_this.aumentarPlato(selPlato,true);
		});
		/*BOTON Disminuir la cantidad de un plato (CLICK)*/
		$("#"+this.windowId+" #nueva-orden-herramientas-disminuir").click(function(){
			var selPlato=$("#"+_this.windowId+" #nueva-orden-platos-tabla tr.table-selected-item");
			if(selPlato.length){
				var cantAct=parseInt(selPlato.attr("data-cant"));
				var newCant=cantAct-1;
				if(newCant>0){
					/*Cant*/
					selPlato.attr("data-cant",newCant.toFixed(_this.config.cant_decimal_precision));
					selPlato.find(".plato-cant-field").html(newCant.toFixed(_this.config.cant_decimal_precision));
					/*Total*/
					var precio=parseFloat(selPlato.attr("data-precio"));
					var total=newCant*precio;
					selPlato.attr("data-total",total.toFixed(_this.config.precios_decimal_precision));
					selPlato.find(".plato-total-field").html(total.toFixed(_this.config.precios_decimal_precision));
					_this.calcTotales();
				}
			}
		});
		/*BOTON Colocar/modificar acompanamientos/notas de un plato (CLICK)*/
		$("#"+this.windowId+" #nueva-orden-herramientas-notas").click(function(){
			var selPlato=$("#"+_this.windowId+" #nueva-orden-platos-tabla tr.table-selected-item");
			if(selPlato.length){
				$("#"+_this.windowId+" #nueva-orden-agregar-plato-id").val(selPlato.attr("data-id"));
				$("#"+_this.windowId+" #nueva-orden-agregar-plato-categoria").val(selPlato.attr("data-categoria"));
				$("#"+_this.windowId+" #nueva-orden-agregar-plato-cant").val(selPlato.attr("data-cant"));
				$("#"+_this.windowId+" #nueva-orden-agregar-plato-nombre").val(selPlato.attr("data-nombre"));
				$("#"+_this.windowId+" #nueva-orden-agregar-plato-precio").val(selPlato.attr("data-precio"));
				$("#"+_this.windowId+" #nueva-orden-agregar-plato-acompanamientos").val(selPlato.attr("data-acompanamientos"));
				$("#"+_this.windowId+" #nueva-orden-agregar-plato-notas").val(selPlato.attr("data-prenotas"));
				$("#"+_this.windowId+" #nueva-orden-agregar-plato-modo").val("update");
				
				
				var id=$("#"+_this.windowId+" #nueva-orden-agregar-plato-id").val();
				var categoria=$("#"+_this.windowId+" #nueva-orden-agregar-plato-categoria").val();
				var cant=$("#"+_this.windowId+" #nueva-orden-agregar-plato-cant").val();
				var nombre=$("#"+_this.windowId+" #nueva-orden-agregar-plato-nombre").val();
				var precio=$("#"+_this.windowId+" #nueva-orden-agregar-plato-precio").val();
				var acompanamientos=$("#"+_this.windowId+" #nueva-orden-agregar-plato-acompanamientos").val();
				var prenotas=$("#"+_this.windowId+" #nueva-orden-agregar-plato-notas").val();
				var modo=$("#"+_this.windowId+" #nueva-orden-agregar-plato-modo").val();
				
				_this.setAcompanamientos(nombre,acompanamientos,prenotas,selPlato.attr("data-notas"));			
			}
		});
		/*BOTON Agregar una linea divisoria (CLICK)*/
		$("#"+this.windowId+" #nueva-orden-herramientas-division").click(function(){
			var lista=$("#"+_this.windowId+" #nueva-orden-platos-tabla > tbody");
			var item=lista.find("tr.table-selected-item");
			var action=1;/*1 - set, 0-Unset*/
			if(!item.length){
				item=lista.find("tr:last");
			}
			if(item.length){
				if($(item).attr("data-div")=="true"){
					var action=0;
				}
				if(action){
					$(item).attr("data-div","true");
					$(item).css("border-bottom","solid 2px #777");
				}else{
					$(item).attr("data-div","false");
					$(item).css("border-bottom","none");
				}
			}
		});
		/*BOTON Eliminar un plato (CLICK)*/
		$("#"+this.windowId+" #nueva-orden-herramientas-eliminar").click(function(){
			var selPlato=$("#"+_this.windowId+" #nueva-orden-platos-tabla tr.table-selected-item");
			if(selPlato.length){
				selPlato.remove();
				_this.updatePlatoCombo();
				_this.calcTotales();
			}
		});		
		/*BOTON seleccionar mesero,servicio,salon,mesas y categorias de menu*/
		$("#"+this.windowId+" .nueva-orden-togglesbtn").on('click','button',function(){
			var $el = $(this).parent();
			$el.closest('.nueva-orden-togglesbtn').find('.active').removeClass('active');
			$el.addClass('active');
		});
		/*BOTONES cambiar Menu*/
		$("#"+this.windowId+" .nueva-orden-changemenu").on('click','button', function (e) {
			var $el = $(e.target);
			$el.closest('.nueva-orden-changemenu').find('button').removeClass('btn-success').addClass('btn-grey');
			$el.addClass("btn-success").removeClass('btn-grey');		
		});
		/*=======================================================================*/	
		/*--------------------------------- MODAL CONFIRMAR --------------------------------------*/	
		if(this.modal.confirmar){
			/*MODAL acciones al abrir modal de confirmar (SHOW)*/
			this.modal.confirmar.on("shown.bs.modal",function(){
				$(this).find("#nueva-orden-button-guardar").focus();
			});
			/*BOTON confirmar guardar orden (CLICK)*/
			this.modal.confirmar.on("click","#nueva-orden-button-guardar",function(){
				_this.guardarOrden();
			});
			/*BOTON cancelar guardar orden (CLICK)*/
			this.modal.confirmar.on("click","#nueva-orden-button-cancelar",function(){
				_this.modal.confirmar.modal('hide');
			});
			/*BOTON  nueva orden (CLICK)*/
			this.modal.confirmar.on("click","#nueva-orden-button-nuevaorden",function(){
				_this.resetForm();
				_this.modal.confirmar.modal('hide');
			});
			/*BOTON  nueva orden (CLICK)*/
			this.modal.confirmar.on("click","#nueva-orden-button-salir",function(){
				_this.modal.confirmar.modal('hide');
					setTimeout(function(){Custombox.close();}, 300);
			});
			/*MODAL acciones al cerrar modal de confirmar (HIDDEN)*/
			this.modal.confirmar.on("hidden.bs.modal",function(){
				$(this).appendTo("#"+_this.windowId+" #nueva-orden-modals-wrapper");
			});
		}
		/*BOTON Cobrar (click)*/
		$("#"+this.windowId+" #nueva-orden-cobrar-btn").click(function(){
			var rows=$("#"+_this.windowId+" #nueva-orden-platos-tabla-wrapper table > tbody > tr");
			if(rows.length){
				var total=$("#"+_this.windowId+" #nueva-orden-totales-total").attr("data-value");
				var cliente=$("#"+_this.windowId+" #nueva-orden-cliente").val();
				var direccion="";
				var telefono=$("#"+_this.windowId+" #nueva-orden-telefono").val();
				var servicio=$("#"+_this.windowId+" #nueva-orden-servicio").val();
				var formapago=$("#"+_this.windowId+" #nueva-orden-formapago").val();
				var winID=Date.now();
				Custombox.open({
					target:_this.baseUrl+"home/cobrar?total="+total+"&cliente="+cliente+"&direccion="+direccion+"&telefono="+telefono+"&servicio="+servicio+"&jsready=true&winid="+winID,
					effect: 'fadein',
					escKey:false,
					overlayClose:false,
					zIndex:"10002",
					complete:function(){
						var facturacion_cobrar= new Caja_facturacion_cobrar();
						facturacion_cobrar.initializeEnviroment(_this.baseUrl,winID,_this);
						if(servicio==1){
							$("#facturacion-servicio-llevar-btn").click();
						}else if(servicio==2){
							$("#facturacion-servicio-domicilio-btn").click();
						}
						
						if(formapago==1){
							$("#facturacion-forma-pago-pos-btn").click();
						}
					}
				});
			}
			else{
				_this.showMsg("error","Es necesario agregar productos a la lista para continuar facturando.");
			}
		});
		/*BOTON Cobrar Movil temp (click)*/
		$("#"+this.windowId+" #nueva-orden-cobrarmovil-btn").click(function(){
			var rows=$("#"+_this.windowId+" #nueva-orden-platos-tabla-wrapper table > tbody > tr");
			if(rows.length){
				var total=$("#"+_this.windowId+" #nueva-orden-totales-total").attr("data-value");
				var cliente="";
				var winID=Date.now();
				Custombox.open({
					target:_this.baseUrl+"home/cobrarmovil?total="+total+"&cliente="+cliente+"&jsready=true&winid="+winID,
					effect: 'fadein',
					escKey:false,
					overlayClose:false,
					zIndex:"10002",
					complete:function(){
						var facturacion_cobrar= new Caja_facturacion_cobrar();
						facturacion_cobrar.initializeEnviroment(_this.baseUrl,winID,_this);
					}
				});
			}
			else{
				_this.showMsg("error","Es necesario agregar productos a la lista para continuar facturando.");
			}
		});
		/*-------------------------- MODAL PROCESO DE VENTA -----------------------------*/
		if(this.modal.procesar_venta){
			this.modal.procesar_venta.on("click","#facturacion-app-venta-cobro-salir-btn",function(){
				//location.reload();
				_this.modal.procesar_venta.modal('hide');
				$("#home-add-order-btn").click();
			});
		}
		
	},
	/*HOTKEYS*/
	this.initializeHotKeys=function(){
		var _this=this;
		/*TEXTBOX cantidad de plato (ENTER)*/
		$("#"+this.windowId+" #nueva-orden-lista-plato-cant-txt").bind("keyup", "return", function(e){
			if($("#"+_this.windowId).is(":visible")){
				e.preventDefault();
				$("#"+_this.windowId+" #nueva-orden-lista-agregar-btn").trigger("click");
			}
		});
	},
	/*FUNCIONES*/
	this.validateStep=function(step){
		var validStep=true;
		switch(step){
			case 0:{ /*Validar orden info*/
				var validItems=[];
				validItems.push({nombre:"mesero",valid:$("#"+this.windowId+" #nueva-orden-meseros-wrapper").find("button.active").length,msg:"un <b>MESERO</b>"});
				validItems.push({nombre:"servicio",valid:$("#"+this.windowId+" #nueva-orden-servicio-wrapper").find("button.active").length,msg:"el <b>SERVICIO</b>"});
				validItems.push({nombre:"salon",valid:$("#"+this.windowId+" #nueva-orden-salones-wrapper").find("button.active").length,msg:"un <b>SAL&Oacute;N</b>"});
				validItems.push({nombre:"mesa",valid:$("#"+this.windowId+" #nueva-orden-mesas-wrapper").find("button.active").length,msg:"una <b>MESA</b>"});
				for(var i=0;i<validItems.length;i++){
					if(!validItems[i].valid){
						validStep=false;
						uFoodTools.showMsg("error","Debe seleccionar "+validItems[i].msg+" para poder continuar");
						break;
					}
				}
			}break;
		}
		return validStep;
	}
	/*------------------------------ MODO LISTA ------------------------------*/
	/*FUNCION: Ir arriba en lista de platos*/
	this.listaPlatosGoTop=function(){
		if($("#"+this.windowId+" #nueva-orden-lista-platos-wrapper").is(":visible")){
			var trows=$("#"+this.windowId+" #nueva-orden-lista-platos-wrapper > table > tbody tr:visible");
			if(trows.length){
				var currentSel=$("#"+this.windowId+" #nueva-orden-lista-platos-wrapper > table > tbody > tr.table-selected-item");
				var prevSel=currentSel.prevAll("tr:visible").first();
				if(prevSel.length){
					currentSel.removeClass("table-selected-item");
					prevSel.addClass("table-selected-item");
					/*Auto scroll*/	
					if(((prevSel.index()+1)*prevSel.height()-prevSel.height()) <= $("#"+this.windowId+" #nueva-orden-lista-platos-wrapper").scrollTop()){
						 $("#"+this.windowId+" #nueva-orden-lista-platos-wrapper").scrollTop($("#"+this.windowId+" #nueva-orden-lista-platos-wrapper").scrollTop()-prevSel.height());
					 }
				}
			}
		}
	},
	/*FUNCION: Ir abajo en lista de platos*/
	this.listaPlatosGoBottom=function(){
		if($("#"+this.windowId+" #nueva-orden-lista-platos-wrapper").is(":visible")){
			var trows=$("#"+this.windowId+" #nueva-orden-lista-platos-wrapper > table > tbody tr:visible");
			if(trows.length){
				var currentSel=$("#"+this.windowId+" #nueva-orden-lista-platos-wrapper > table > tbody > tr.table-selected-item");
				var nextSel=currentSel.nextAll("tr:visible").first();
				if(nextSel.length){
					currentSel.removeClass("table-selected-item");
					nextSel.addClass("table-selected-item");
					/*Auto scroll*/								
					 if((((nextSel.index()+1)*nextSel.height())+nextSel.height()) >= ($("#"+this.windowId+" #nueva-orden-lista-platos-wrapper").scrollTop()+$("#"+this.windowId+" #nueva-orden-lista-platos-wrapper").height())){
						 $("#"+this.windowId+" #nueva-orden-lista-platos-wrapper").scrollTop( $("#"+this.windowId+" #nueva-orden-lista-platos-wrapper").scrollTop()+nextSel.height());
					 }
				}
			}
		}
	}
	/*FUNCION: Reiniciar controles y lista de busqueda*/
	this.listaResetParam=function(){
		$("#"+this.windowId+" #nueva-orden-lista-plato-txt").val("");
		$("#"+this.windowId+" #nueva-orden-lista-plato-txt").removeAttr("readonly");
		$("#"+this.windowId+" #nueva-orden-lista-plato-cant-txt").val(1);
		$("#"+this.windowId+" #nueva-orden-lista-platos-wrapper > table > tbody tr").show();
		$("#"+this.windowId+" #nueva-orden-lista-platos-wrapper > table > tbody tr.table-selected-item").removeClass("table-selected-item");
		$("#"+this.windowId+" #nueva-orden-lista-platos-wrapper > table > tbody tr:first").addClass("table-selected-item");
	}
	/*---------------------------- END MODO LISTA ----------------------------*/
	/*-------------------------------------------------------------------------*/
	/*FUNCION: Validar plato a la orden*/
	this.validarAgregarPlato=function(){
		var _this=this;
		var id=$("#"+this.windowId+" #nueva-orden-agregar-plato-id").val();
		var categoria=$("#"+this.windowId+" #nueva-orden-agregar-plato-categoria").val();
		var cant=$("#"+this.windowId+" #nueva-orden-agregar-plato-cant").val();
		var nombre=$("#"+this.windowId+" #nueva-orden-agregar-plato-nombre").val();
		var precio=$("#"+this.windowId+" #nueva-orden-agregar-plato-precio").val();
		var acompanamientos=$("#"+this.windowId+" #nueva-orden-agregar-plato-acompanamientos").val();
		var prenotas=$("#"+this.windowId+" #nueva-orden-agregar-plato-notas").val();
		var setNotas=$("#"+this.windowId+" #nueva-orden-agregar-plato-selnotas").val();
		var modo=$("#"+this.windowId+" #nueva-orden-agregar-plato-modo").val();
		/*Verificar acompanamientos*/
		if(acompanamientos!=""){
			/*Setear acompanamientos*/
			this.setAcompanamientos(nombre,acompanamientos,prenotas,"");		
		}else{
			if(this.config.modificar_precios==1 && this.config.modificar_precios_add==1){
				/*Mostrar formulario de modificar precios*/
				_this.modal.modificar_precios.find(".modal-dialog > .modal-content > .modal-header > .modal-title > b").text(nombre);
				_this.modal.modificar_precios.modal('show');
				_this.modal.modificar_precios.appendTo("body");
				_this.modal.modificar_precios.find("#nueva-orden-cantidades-cantidad").val("1");
				_this.modal.modificar_precios.find("#nueva-orden-cantidades-costo").val(precio);
				_this.modal.modificar_precios.find("#nueva-orden-cantidades-agregar-btn").removeClass("hidden");
				_this.modal.modificar_precios.find("#nueva-orden-cantidades-actualizar-btn").addClass("hidden");
			}else{
				_this.agregarPlato(modo,id,cant,nombre,precio,acompanamientos,prenotas,"",categoria);
				_this.updatePlatoCombo();
			}
		}		
	},
	this.setPrices-function(){
		
	},
	/*FUNCION: Colocar/editar acompanamientos y notas*/
	this.setAcompanamientos=function(nombre,acompanamientos,prenotas,notas){
		$("#"+this.windowId+" #nueva-orden-acompanamientos-wrapper").empty();
		$("#"+this.windowId+" #nueva-orden-notas-txt").empty();
		$("#"+this.windowId+" #nueva-orden-notas-wrapper-1").empty();
		$("#"+this.windowId+" #nueva-orden-notas-wrapper-2").empty();
		$("#"+this.windowId+" #nueva-orden-notas-txt").text(notas);
		/*Verificar si hay acompanamientos*/
		if(acompanamientos!=""){
			acompanamientos=JSON.parse(acompanamientos);
		}
		if(typeof(acompanamientos)=="object"){
			var _this=this;
			/*Agregar categorias y acompanamientos al formulario*/
			$.each(acompanamientos,function(i,cat_acompanamiento){
				/*Crear elemento*/
				var htmlCat="<div class='col-sm-6'>";
				if(parseInt(cat_acompanamiento.obligatorio)){
					htmlCat+="<label class='text-semibold'>"+cat_acompanamiento.nombre+" <span class='text-danger'>*</span></label>";
					htmlCat+="<select class='form-control mar-btm' style='font-size:15px;' data-cat_acompanamiento='"+cat_acompanamiento.id+"' data-cat_acomp_nombre='"+cat_acompanamiento.nombre+"' data-required='required'>";
					htmlCat+="<option disabled selected value=''>Seleccione uno...</option>";
				}
				else{
					htmlCat+="<label class='text-semibold'>"+cat_acompanamiento.nombre+"</label>";
					htmlCat+="<select class='form-control mar-btm' style='font-size:15px;' data-cat_acompanamiento='"+cat_acompanamiento.id+"' data-cat_acomp_nombre='"+cat_acompanamiento.nombre+"' >";
					htmlCat+="<option selected value=''>Sin especificar</option>";
				}
				$.each(cat_acompanamiento.acompanamientos,function(ii,acompanamiento){
					
					if(parseInt(acompanamiento.selected)){
						htmlCat+="<option value='"+acompanamiento.id+"' selected>"+acompanamiento.nombre+"</option>";
					}else{
						htmlCat+="<option value='"+acompanamiento.id+"'>"+acompanamiento.nombre+"</option>";
					}
					
				});
			
				htmlCat+="</select></div>";
				/*Agregar a ventana*/
				$("#"+_this.windowId+" #nueva-orden-acompanamientos-wrapper").append(htmlCat);
			});
			/*Agregar notas a formulario*/
			if(prenotas!=""){
				prenotas=JSON.parse(prenotas);
				if(typeof(prenotas)=="object"){
					var notasColCount=1;
					$.each(prenotas,function(i,nota){
						var htmlNota="<button type='button' class='btn btn-block btn-lg btn-grey mar-btm' data-id='"+nota.id+"' data-texto='"+nota.texto+"' style='white-space:normal;'>"+nota.texto+"</button>";
						$("#"+_this.windowId+" #nueva-orden-notas-wrapper-"+notasColCount).append(htmlNota);
						if(notasColCount<2){notasColCount+=1;}
						else{notasColCount=1;}
					});
				}
			}
		}
		/*Mostrar formulario de acompanamientos y notas*/
		this.modal.acompanamientos.find(".modal-dialog > .modal-content > .modal-header > .modal-title > b").text(nombre);
		this.modal.acompanamientos.modal('show');
		this.modal.acompanamientos.appendTo("body");
		
	},
	/*FUNCTION: agregar 2do combo a mitad de precio*/
	this.updatePlatoCombo=function(){
		var _this=this;
		if($("#"+_this.windowId+" #nueva-orden-agregar-plato-promo").val()==1){
			var rows=$("#"+_this.windowId+" #nueva-orden-platos-tabla-wrapper table > tbody > tr[data-categoria='1']");
			/* var max1=max2=max1id=max2id=0;
			var apliPromo=false; */
			var countPlatos=0;
			var id=precio_ant=0;
			$("#"+_this.windowId+" #nueva-orden-platos-tabla > tbody tr.nueva-orden-agregar-plato-promo").removeClass('nueva-orden-agregar-plato-promo text-danger');
			$.each(rows,function(index,producto){
				$(producto).attr("data-precio",$(producto).attr("data-precioreal"));
				$(producto).attr("data-total",parseFloat($(producto).attr("data-precioreal"))*parseFloat($(producto).attr("data-cant")));
				$(producto).find(".plato-precio-field").html($(producto).attr("data-precioreal"));
				$(producto).find(".plato-total-field").html(parseFloat($(producto).attr("data-precioreal"))*parseFloat($(producto).attr("data-cant")));				
				
				var total=precio=0;
				var cant=1;
				countPlatos++;
				if(countPlatos%2){
					//No Aplica
					id=$(producto).attr("id");
					precio_ant=parseFloat($(producto).attr("data-precioreal"));
				}else{
					//Aplica Promocion
					if(precio_ant > $(producto).attr("data-precioreal")){
						/*El plato anterior es mayor*/						
						precio = parseFloat($("#"+_this.windowId+" #nueva-orden-platos-tabla > tbody tr#"+$(producto).attr("id")).attr("data-precioreal"));
						precio = precio / 2;
						
						total=cant*precio;
						
						cant=cant.toFixed(_this.config.cant_decimal_precision);
						precio=precio.toFixed(_this.config.precios_decimal_precision);
						total=total.toFixed(_this.config.precios_decimal_precision);
						
						$("#"+_this.windowId+" #nueva-orden-platos-tabla > tbody tr#"+$(producto).attr("id")).find(".plato-precio-field").html(precio);
						$("#"+_this.windowId+" #nueva-orden-platos-tabla > tbody tr#"+$(producto).attr("id")).find(".plato-total-field").html(precio);
						$("#"+_this.windowId+" #nueva-orden-platos-tabla > tbody tr#"+$(producto).attr("id")).find(".plato-cant-field").html(cant);
						$("#"+_this.windowId+" #nueva-orden-platos-tabla > tbody tr#"+$(producto).attr("id")).attr("data-precio",precio);
						$("#"+_this.windowId+" #nueva-orden-platos-tabla > tbody tr#"+$(producto).attr("id")).attr("data-cant",cant);
						$("#"+_this.windowId+" #nueva-orden-platos-tabla > tbody tr#"+$(producto).attr("id")).attr("data-total",total);
						$("#"+_this.windowId+" #nueva-orden-platos-tabla > tbody tr#"+$(producto).attr("id")).attr("data-promo",1);
						$("#"+_this.windowId+" #nueva-orden-platos-tabla > tbody tr#"+$(producto).attr("id")).addClass("nueva-orden-agregar-plato-promo text-danger");
					}else{
						/*El plato anterior es menor*/
						precio = parseFloat($("#"+_this.windowId+" #nueva-orden-platos-tabla > tbody tr#"+id).attr("data-precioreal"));
						precio = precio / 2;
						
						total=cant*precio;
						
						cant=cant.toFixed(_this.config.cant_decimal_precision);
						precio=precio.toFixed(_this.config.precios_decimal_precision);
						total=total.toFixed(_this.config.precios_decimal_precision);
						
						$("#"+_this.windowId+" #nueva-orden-platos-tabla > tbody tr#"+id).find(".plato-precio-field").html(precio);
						$("#"+_this.windowId+" #nueva-orden-platos-tabla > tbody tr#"+id).find(".plato-total-field").html(precio);
						$("#"+_this.windowId+" #nueva-orden-platos-tabla > tbody tr#"+id).find(".plato-cant-field").html(cant);
						$("#"+_this.windowId+" #nueva-orden-platos-tabla > tbody tr#"+id).attr("data-precio",precio);
						$("#"+_this.windowId+" #nueva-orden-platos-tabla > tbody tr#"+id).attr("data-cant",cant);
						$("#"+_this.windowId+" #nueva-orden-platos-tabla > tbody tr#"+id).attr("data-total",total);
						$("#"+_this.windowId+" #nueva-orden-platos-tabla > tbody tr#"+id).attr("data-promo",1);
						$("#"+_this.windowId+" #nueva-orden-platos-tabla > tbody tr#"+id).addClass("nueva-orden-agregar-plato-promo text-danger");
					}
				}
				/* if($(producto).attr('data-id')!=1 && $(producto).attr('data-categoria')==1){
					$(producto).attr("data-precio",$(producto).attr("data-precioreal"));
					$(producto).attr("data-total",parseFloat($(producto).attr("data-precioreal"))*parseFloat($(producto).attr("data-cant")));
					$(producto).find(".plato-precio-field").html($(producto).attr("data-precioreal"));
					$(producto).find(".plato-total-field").html(parseFloat($(producto).attr("data-precioreal"))*parseFloat($(producto).attr("data-cant")));
					
					if($(producto).attr('data-precio')>max1){
						max2=max1;
						max2id=max1id;
						max1=$(producto).attr('data-precio');
						max1id=$(producto).attr('id');
					}else if($(producto).attr('data-precio')>max2){
						max2=$(producto).attr('data-precio');
						max2id=$(producto).attr('id');
					}					
					
				} */
				
			});
			
			/* if(countPlatos >= 2){
				apliPromo=true;
			}
			
			$("#"+_this.windowId+" #nueva-orden-platos-tabla > tbody tr.nueva-orden-agregar-plato-promo").removeClass('nueva-orden-agregar-plato-promo text-danger');
			
			if(apliPromo==true){
				console.log(max2id);
				
				$("#"+_this.windowId+" #nueva-orden-platos-tabla > tbody tr#"+max2id).addClass("nueva-orden-agregar-plato-promo text-danger");
				
				var total=precio=0;
				var cant=1;
				
				precio = parseFloat($("#"+_this.windowId+" #nueva-orden-platos-tabla > tbody tr#"+max2id).attr("data-precio"));
				precio = precio / 2;
				
				total=cant*precio;
				
				cant=cant.toFixed(this.config.cant_decimal_precision);
				precio=precio.toFixed(this.config.precios_decimal_precision);
				total=total.toFixed(this.config.precios_decimal_precision);
				
				$("#"+_this.windowId+" #nueva-orden-platos-tabla > tbody tr#"+max2id).find(".plato-precio-field").html(precio);
				$("#"+_this.windowId+" #nueva-orden-platos-tabla > tbody tr#"+max2id).find(".plato-total-field").html(precio);
				$("#"+_this.windowId+" #nueva-orden-platos-tabla > tbody tr#"+max2id).find(".plato-cant-field").html(cant);
				$("#"+_this.windowId+" #nueva-orden-platos-tabla > tbody tr#"+max2id).attr("data-precio",precio);
				$("#"+_this.windowId+" #nueva-orden-platos-tabla > tbody tr#"+max2id).attr("data-cant",cant);
				$("#"+_this.windowId+" #nueva-orden-platos-tabla > tbody tr#"+max2id).attr("data-total",total);
				$("#"+_this.windowId+" #nueva-orden-platos-tabla > tbody tr#"+max2id).attr("data-promo",1);
				
			*/
			_this.calcTotales();
		}
	},
	/*FUNCION: Agregar un plato a la orden*/
	this.agregarPlato=function(modo,id,cant,nombre,precio,acompanamientos,prenotas,notas,categoria){
		if(id==1){
			categoria=2;
		}else{
			categoria=parseFloat(categoria);			
		}
		promo=0;
		cant=parseFloat(cant);
		precio=parseFloat(precio);
		total=cant*precio;
		cant=cant.toFixed(this.config.cant_decimal_precision);
		precio=precio.toFixed(this.config.precios_decimal_precision);
		total=total.toFixed(this.config.precios_decimal_precision);
		var acompanamientosStr="";
		if(typeof acompanamientos=="object"){
			$.each(acompanamientos,function(i,cat){
				$.each(cat.acompanamientos,function(ii,acompanamiento){
					if(parseInt(acompanamiento.selected)){
						acompanamientosStr+=" "+cat.nombre+": "+acompanamiento.nombre+",";
					}
				});
			});
			if(acompanamientosStr!=""){
				acompanamientosStr= " - "+acompanamientosStr.substring(0, acompanamientosStr.length - 1);	
			}
		}		
		
		if(modo=="set"){
			var trHTML="<tr id='"+this.idPlato+"' data-promo='"+promo+"' data-id='"+id+"' data-categoria='"+categoria+"' data-cant='"+cant+"' data-nombre='"+nombre+"' data-precio='"+precio+"' data-precioreal='"+precio+"' data-total='"+total+"' data-acompanamientos='"+(typeof acompanamientos=="object"?JSON.stringify(acompanamientos):"")+"' data-acompanamientosstr='"+acompanamientosStr+"' data-prenotas='"+(typeof prenotas=="object" && prenotas!=null?JSON.stringify(prenotas):"")+"' data-notas='"+notas+"' data-enviado='0'>";
			trHTML+="<td class='plato-cant-field text-center text-semibold' width='10%'>"+cant+"</td>";/*Cantidad*/
			trHTML+="<td class='plato-nombre-field text-left' width='55%'><span class='text-semibold'>"+nombre+acompanamientosStr+"</span>";/*Producto*/
			if(notas!=""){
				trHTML+="<small style='display:block' class='text-mutted'>Notas: "+notas+"</small>";
			}
			trHTML+="</td>";
			trHTML+="<td class='plato-precio-field text-center text-semibold' width='15%'>"+precio+"</td>";/*Precio*/
			trHTML+="<td class='plato-total-field text-center text-semibold' width='20%'>"+total+"</td>";/*Total*/
			trHTML+="</tr>";
			$("#"+this.windowId+" #nueva-orden-platos-tabla tbody").append(trHTML);
			/*Scroll*/
			if($("#"+this.windowId+" #nueva-orden-platos-tabla-wrapper > table ").height()>=($("#"+this.windowId+" #nueva-orden-platos-tabla-wrapper").scrollTop()+$("#"+this.windowId+" #nueva-orden-platos-tabla-wrapper").height())){
				$("#"+this.windowId+" #nueva-orden-platos-tabla-wrapper").scrollTop($("#"+this.windowId+" #nueva-orden-platos-tabla-wrapper").scrollTop()+60);
			}
			this.idPlato++;
		}
		else if(modo=="update"){
			var selPlato=$("#"+this.windowId+" #nueva-orden-platos-tabla tr.table-selected-item");
			selPlato.attr("data-id",id);
			selPlato.attr("data-categoria",categoria);
			selPlato.attr("data-promo",promo);
			selPlato.attr("data-cant",cant);
			selPlato.attr("data-nombre",nombre);
			selPlato.attr("data-precio",precio);
			selPlato.attr("data-total",total);
			selPlato.attr("data-acompanamientos",(typeof acompanamientos=="object"?JSON.stringify(acompanamientos):""));
			selPlato.attr("data-acompanamientosstr",acompanamientosStr);
			selPlato.attr("data-prenotas",(typeof prenotas=="object" && prenotas!=null?JSON.stringify(prenotas):""));
			selPlato.attr("data-notas",notas);
			selPlato.attr("data-enviado","0");
			
			selPlato.find(".plato-cant-field").html(cant);
			selPlato.find(".plato-precio-field").html(precio);
			var htmlNombre="<span class='text-semibold'>"+nombre+acompanamientosStr+"</span>";
			if(notas!=""){
				htmlNombre+="<small style='display:block' class='text-mutted'>Notas: "+notas+"</small>";
			}
			selPlato.find(".plato-nombre-field").html(htmlNombre);
		}
		/*Calcular totales*/
		this.calcTotales();
		/*Limpiar campos*/
		this.resetAgregarCampos();
	},
	/*FUNCION: Limpiar campos agregar plato*/
	this.resetAgregarCampos=function(){
		$("#"+this.windowId+" #nueva-orden-agregar-plato-id").val("");
		$("#"+this.windowId+" #nueva-orden-agregar-plato-categoria").val("");
		$("#"+this.windowId+" #nueva-orden-agregar-plato-cant").val("");
		$("#"+this.windowId+" #nueva-orden-agregar-plato-nombre").val("");
		$("#"+this.windowId+" #nueva-orden-agregar-plato-precio").val("");
		$("#"+this.windowId+" #nueva-orden-agregar-plato-acompanamientos").val("");
		$("#"+this.windowId+" #nueva-orden-agregar-plato-selacompanamientos").val("");
		$("#"+this.windowId+" #nueva-orden-agregar-plato-notas").val("");
		$("#"+this.windowId+" #nueva-orden-agregar-plato-selnotas").val("");
		$("#"+this.windowId+" #nueva-orden-agregar-plato-notas").val("");
		$("#"+this.windowId+" #nueva-orden-agregar-plato-modo").val("");
		
		$("#"+this.windowId+" #nueva-orden-platos-tabla > tbody tr.table-selected-item").removeClass('table-selected-item');
		
		/*Enviar foco modo lista*/
		if($("#"+this.windowId+" #nueva-orden-modo-lista-wrapper").is(":visible")){
			var _this=this;
			setTimeout(function(){
				$("#"+_this.windowId+" #nueva-orden-lista-plato-txt").focus();
			}, 500);
		}
	},
	/*FUNCION: Aumentar un la cantidad de un plato*/
	this.aumentarPlato=function(plato,validated){
		var _this=this;
		/*Aumentar plato*/
		if(plato.length && !plato.hasClass("nueva-orden-agregar-plato-promo")){
			/*cant*/
			var cantAct=parseFloat(plato.attr("data-cant"));
			var newCant=cantAct+1;
			plato.attr("data-cant",newCant.toFixed(this.config.cant_decimal_precision));
			plato.find(".plato-cant-field").html(newCant.toFixed(this.config.cant_decimal_precision));
			/*Total*/
			var precio=parseFloat(plato.attr("data-precio"));
			var total=newCant*precio;
			plato.attr("data-total",total.toFixed(this.config.precios_decimal_precision));
			plato.find(".plato-total-field").html(total.toFixed(this.config.precios_decimal_precision));
			this.calcTotales();
		}else{
			_this.showMsg("error","No puedes agregar mas de 1 plato en promocion");
		}
	},
	this.calcTotales=function(){
		var total=0;
		var propina=0;
		var subtotal=0;
		
		var rows=$("#"+this.windowId+" #nueva-orden-platos-tabla-wrapper table > tbody > tr");
		if(rows.length){
			rows.each(function(i,row){
				var totalUnitario=$(row).attr("data-total");
				subtotal+=parseFloat(totalUnitario);
			});	
		}
		if(this.config.totales_decimal_precision){
			subtotal=(Math.round(subtotal*100)/100).toFixed(this.config.totales_decimal_precision);
		}
		
		if(this.config.propina_aplicar==1){
			propina=parseFloat(subtotal*this.config.propina_porcentaje_aplicable).toFixed(this.config.totales_decimal_precision);			
		}
		
		total=(parseFloat(subtotal)+parseFloat(propina)).toFixed(this.config.totales_decimal_precision);
			
		$("#"+this.windowId+" #nueva-orden-totales-subtotal").attr("data-value",subtotal);
		$("#"+this.windowId+" #nueva-orden-totales-subtotal > td.total-value > span").text(subtotal);
		
		$("#"+this.windowId+" #nueva-orden-totales-propina").attr("data-value",propina);
		$("#"+this.windowId+" #nueva-orden-totales-propina > td.total-value > span").text(propina);
		
		$("#"+this.windowId+" #nueva-orden-totales-total").attr("data-value",total);
		$("#"+this.windowId+" #nueva-orden-totales-total > td.total-value > span").text(total);
	},
	this.calcTotalesSP=function(){
		var total=0;
		var propina=0;
		var subtotal=0;
		
		var rows=$("#"+this.windowId+" #nueva-orden-platos-tabla-wrapper table > tbody > tr");
		if(rows.length){
			rows.each(function(i,row){
				var totalUnitario=$(row).attr("data-total");
				subtotal+=parseFloat(totalUnitario);
			});	
		}
		if(this.config.totales_decimal_precision){
			subtotal=(Math.round(subtotal*100)/100).toFixed(this.config.totales_decimal_precision);
		}
		
		propina=parseFloat(subtotal*0.0).toFixed(this.config.totales_decimal_precision);
		
		total=(parseFloat(subtotal)+parseFloat(propina)).toFixed(this.config.totales_decimal_precision);
			
		$("#"+this.windowId+" #nueva-orden-totales-subtotal").attr("data-value",subtotal);
		$("#"+this.windowId+" #nueva-orden-totales-subtotal > td.total-value > span").text(subtotal);
		
		$("#"+this.windowId+" #nueva-orden-totales-propina").attr("data-value",propina);
		$("#"+this.windowId+" #nueva-orden-totales-propina > td.total-value > span").text(propina);
		
		$("#"+this.windowId+" #nueva-orden-totales-total").attr("data-value",total);
		$("#"+this.windowId+" #nueva-orden-totales-total > td.total-value > span").text(total);
	},
	/*Validar un guardar orden*/
	this.validarGuardarOrden=function(){
		/*Productos en la tabla*/
		var productos=$("#"+this.windowId+" #nueva-orden-platos-tabla > tbody > tr");
		if(productos.length){
			this.showConfirmModal(true,"question","&iquest;Desea guardar y enviar esta orden a cocina?");
		}else{
			uFoodTools.showMsg("error","Necesita agregar al menos un plato para poder continuar");
		}
	},
	/*Guardar orden*/
	this.guardarOrden=function(){
		var _this=this;
		/*----Cambair estado de pantalla----*/
		this.showConfirmModal(false,"wait","Guardando...");
		/*orden*/
		var orden=$("#"+this.windowId+" #nueva-orden-id").val();
		var origen=$("#"+this.windowId+" #nueva-orden-origen").val();
		var numOrden=$("#"+this.windowId+" #nueva-orden-numero").val();
		/*Mesero*/
		var meseroData=$("#"+this.windowId+" #nueva-orden-meseros-wrapper").find("button.active").data();
		/*Servicio*/
		var servicioData=$("#"+this.windowId+" #nueva-orden-servicio-wrapper").find("button.active").data();
		/*Salon*/
		var salonData=$("#"+this.windowId+" #nueva-orden-salones-wrapper").find("button.active").data();
		/*Mesa*/
		var mesaData=$("#"+this.windowId+" #nueva-orden-mesas-wrapper").find("button.active").data();
		/*Cliente*/
		var cliente=$("#"+this.windowId+" #nueva-orden-cliente-nombre").val();
		/*subtotal*/
		var subtotal=0;
		/*Platos*/
		var platos=$("#"+this.windowId+" #nueva-orden-platos-tabla > tbody > tr");
		var platos_list=[];
		for(var i=0;i<platos.length;i++){
			var plato=$(platos[i]);
			/*categorias aconpanamientos plato*/
			var acompanamientos_plato=[];
			var acompanamientos_cat=plato.attr("data-acompanamientos");
			if(acompanamientos_cat!=""){
				acompanamientos_cat=JSON.parse(acompanamientos_cat);
				if(typeof acompanamientos_cat=="object"){
					for(var ic=0; ic<acompanamientos_cat.length;ic++){
						/*aconpanamientos en la categoria plato*/
						var acompanamientos=acompanamientos_cat[ic].acompanamientos;
						for(var ica=0;ica<acompanamientos.length;ica++){
							if(parseInt(acompanamientos[ica].selected)){
								acompanamientos_plato.push({cat:acompanamientos_cat[ic].id,acom:acompanamientos[ica].id});
							}
						}
					}
				}
			}
			var platodiv=0;
			if(plato.attr("data-div")=="true"){
				 platodiv=1;
			}
			
			platos_list.push({
				id:plato.attr("data-id"),
				cant:plato.attr("data-cant"),
				nombre:plato.attr("data-nombre"),
				precio:plato.attr("data-precio"),
				acompanamientos:(acompanamientos_plato.length?acompanamientos_plato:null),
				enviado:plato.attr("data-enviado"),
				cantenviados:plato.attr("data-cantenviados"),
				acompanamientosstr:plato.attr("data-acompanamientosstr"),
				notas:plato.attr("data-notas"),
				div:platodiv
			}); 
			subtotal+=parseFloat(plato.attr("data-precio"))*parseFloat(plato.attr("data-cant"));
		}
		/*Organizar parametros*/
		 var params="origen="+origen+"orden="+orden+"&numorden="+numOrden+"&meseroid="+meseroData.id+"&meseronombre="+meseroData.nombre+"&servicio="+servicioData.tipo+"&salonid="+salonData.id+"&salonnombre="+salonData.nombre+"&mesaid="+mesaData.id+"&mesanombre="+mesaData.nombre+"&clientenombre="+cliente+"&platos="+JSON.stringify(platos_list)+"&subtotal="+subtotal;
		 /*Enviar*/
		var http=new XMLHttpRequest();
		var url=this.baseUrl+"ordenes/guardar_orden";
		 http.onerror= function(){
			_this.showConfirmModal(false,"error","&excl;La orden no se ha guardado!</br>Ha ocurrido un problema al intentar guardar la orden, por favor intentelo de nuevo.");
		}
		http.open("POST", url, true);
		http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		http.onreadystatechange = function(){
			if(http.readyState==4 && http.status==200) {
				if(http.response){
					var response=JSON.parse(http.response);
					_this.showConfirmModal(false,"success","&excl;La orden se ha guardado!<br> <b>No.Orden: "+response.numero_orden+"</b></br><small>ID orden: <b>"+response.id_orden+"</b><small>");
				}else{
					_this.showConfirmModal(false,"error","&excl;La orden no se ha guardado!</br>Ha ocurrido un problema al intentar guardar la orden, por favor intentelo de nuevo.");
				}
			}else{
				_this.showConfirmModal(false,"error","&excl;La orden no se ha guardado!</br>Ha ocurrido un problema al intentar guardar la orden, por favor intentelo de nuevo.");
			}
		}
		http.send(params);
	}
	/*Mostrar modal de confirmación*/
	this.showConfirmModal=function(show,mode,message){
		var iconWrapper=this.modal.confirmar.find("#nueva-orden-guardar-state-icon-wrapper");
		var icon=$(iconWrapper).find("i");
		var text=this.modal.confirmar.find("#nueva-orden-guardar-state-text-wrapper h5");
		var buttons=this.modal.confirmar.find("#nueva-orden-guardar-state-buttons-wrapper button");
		$(buttons).hide();
		var focus=null;
		/*Clear*/
		$(icon).removeClass();
		$(iconWrapper).removeClass();
		switch(mode){
			case "question":{
				$(icon).addClass("fa fa-question-circle-o");
				$(iconWrapper).addClass("text-center text-info");
				this.modal.confirmar.find("#nueva-orden-button-guardar").show().removeAttr("disabled").focus();
				this.modal.confirmar.find("#nueva-orden-button-cancelar").show().removeAttr("disabled");
				/* 	this.modal.confirmar.find("#nueva-orden-button-nuevaorden").show().focus();  */
			}break;
			case "wait":{
				$(icon).addClass("fa fa-spinner");
				$(iconWrapper).addClass("text-center text-mutted");
				this.modal.confirmar.find("#nueva-orden-button-guardar").show().prop("disabled","disabled");
				this.modal.confirmar.find("#nueva-orden-button-cancelar").show().prop("disabled","disabled");
			}break;
			case "success":{
				$(icon).addClass("fa fa-check-circle-o");
				$(iconWrapper).addClass("text-center text-success");
				this.modal.confirmar.find("#nueva-orden-button-nuevaorden").show().focus();
				this.modal.confirmar.find("#nueva-orden-button-salir").show();
			}break;
			case "error":{
				$(icon).addClass("fa fa-exclamation-circle");
				$(iconWrapper).addClass("text-center text-danger");
				this.modal.confirmar.find("#nueva-orden-button-reintentar").show().focus();
				this.modal.confirmar.find("#nueva-orden-button-salir").show();
			}break;
		}
		$(text).html(message);
		if(show){
			this.modal.confirmar.modal('show');
			this.modal.confirmar.appendTo("body");
		}
	},
	/*Reiniciar formulariio*/
	this.resetForm=function(){
		/*limpiar tabla de productos*/
		$("#"+this.windowId+" #nueva-orden-platos-tabla tbody").empty();
		/*Reiniciar hidden de agregar*/
		$("#"+this.windowId+" #nueva-orden-agregar-plato-id").val("");
		$("#"+this.windowId+" #nueva-orden-agregar-plato-categoria").val("");
		$("#"+this.windowId+" #nueva-orden-agregar-plato-cant").val("");
		$("#"+this.windowId+" #nueva-orden-agregar-plato-nombre").val("");
		$("#"+this.windowId+" #nueva-orden-agregar-plato-precio").val("");
		$("#"+this.windowId+" #nueva-orden-agregar-plato-acompanamientos").val("");
		$("#"+this.windowId+" #nueva-orden-agregar-plato-selacompanamientos").val("");
		$("#"+this.windowId+" #nueva-orden-agregar-plato-notas").val("");
		$("#"+this.windowId+" #nueva-orden-agregar-plato-selnotas").val("");
		$("#"+this.windowId+" #nueva-orden-agregar-plato-notas").val("");
		$("#"+this.windowId+" #nueva-orden-agregar-plato-modo").val("");
		
		$("#"+this.windowId+" #nueva-orden-id").val("");
		$("#"+this.windowId+" #nueva-orden-numero").val("");
		/*reiniciar modo lista*/
		this.listaResetParam();
		/*reiniciar contador de agregar plato*/
		$("#"+this.windowId+" #norden-menu-cant-platos").val("1");
		/*modo de menu por defecto*/
		var activeModeItem=$("#"+this.windowId+" #nueva-orden-menu-mode-view-wrapper").find("button.active");
		switch(parseInt(this.config.menu_mode)){
			case 0:{/*Modo lista*/
				if($(activeModeItem).attr("data-mode")!="lista"){
					$("#"+this.windowId+" #nueva-orden-menu-mode-view-lista").trigger("click");
				}
			}break;
			case 1:{/*Modo menu*/
				if($(activeModeItem).attr("data-mode")!="menu"){
					$("#"+this.windowId+" #nueva-orden-menu-mode-view-menu").trigger("click");
				}
			}break;
		}
		/*deseleccionar mesero*/
		$("#"+this.windowId+" #nueva-orden-meseros-wrapper").find("button.active").removeClass("active");
		/*deseleccionar servicio*/
		$("#"+this.windowId+" #nueva-orden-servicio-wrapper").find("button.active").removeClass("active");
		/*deseleccionar salon*/
		$("#"+this.windowId+" #nueva-orden-salones-wrapper").find("button.active").removeClass("active");
		/*deseleccionar mesa*/
		$("#"+this.windowId+" #nueva-orden-mesas-wrapper").find("button.active").removeClass("active");
		/*Seleccionar servicio por defecto*/
		$("#"+this.windowId+" #nueva-orden-servicio-wrapper").find("button:first").addClass("active");
		/*Seleccionar salon por defecto*/
		var defaultSalon=$("#"+this.windowId+" #nueva-orden-salones-wrapper").find("button:first");
		defaultSalon.addClass("active");
		var defaultSalonID=defaultSalon.attr("data-id");
		/*Mostrar mesas del salon por defecto*/
		var mesas=$("#"+this.windowId+" #nueva-orden-mesas-wrapper").find(".btn-mesa");
		$(mesas).hide();
		mesas.each(function(i,mesa){
			var mesaBtn=$(mesa).find("button")[0];
			if($(mesaBtn) && $(mesaBtn).attr("data-salon")==defaultSalonID){
				$(mesa).show();
			}
		}); 
		/*Regresar a pantalla inicio*/
		$("#"+this.windowId+" #nueva-orden-wizzard-btn-prev").trigger("click");
	},
	this.setCobroInfo=function(info){
		var _this=this;
		var total=parseFloat(info.total).toFixed(2);
		var efectivo=parseFloat(info.efectivo).toFixed(2);
		var pos=parseFloat(info.pos).toFixed(2);
		var cambio=parseFloat(info.cambio).toFixed(2);
		var desc_empleado=parseFloat(info.desc_empleado).toFixed(2);
		var descuento=parseFloat(info.descuento).toFixed(2);
		var forma_pago=info.forma_pago;
		var documento_pago=info.documento_pago;
		var numero_documento=info.numero_documento;
		var servicio=info.servicio;
		var propina=$("#"+_this.windowId+" #nueva-orden-totales-propina").attr("data-value");
		var subtotal = (parseFloat(total) - parseFloat(propina)).toFixed(2);
		
		$("#"+this.windowId+" #facturacion-app-venta-cobro-total").text(subtotal);
		$("#"+this.windowId+" #facturacion-app-venta-cobro-efectivo").text(efectivo);
		$("#"+this.windowId+" #facturacion-app-venta-cobro-pos").text(pos);
		$("#"+this.windowId+" #facturacion-app-venta-cobro-cambio").text(cambio);
		
		if(forma_pago=="1"){
			$("#"+this.windowId+" #facturacion-app-venta-cobro-pos-wrapper").hide();
			$("#"+this.windowId+" #facturacion-app-venta-cobro-efectivo-wrapper").hide();
			$("#"+this.windowId+" #facturacion-app-venta-cobro-cambio-wrapper").hide();
		}		
		
		var cliente_nombre=info.cliente;
		var empleado_nombre=info.empleado;
		var direccion=info.direccion;
		var dui=info.dui;
		var nit=info.nit;
		var nrc=info.nrc;
		var id_empleado=info.id_empleado;
		var printVenta=false;
		var printConsumo=false;
		var notas=info.notas;
		
		if(forma_pago==9){
			printConsumo=true;
			descuento=desc_empleado;
			if(total > desc_empleado){
				forma_pago=0;
				documento_pago=0;
				printVenta=true;
			}else{
				if(desc_empleado > total){
					$("#"+this.windowId+" #facturacion-app-venta-cobro-efectivo-wrapper").hide();
					$("#"+this.windowId+" #facturacion-app-venta-cobro-cambio-wrapper").hide();		
					$("#"+this.windowId+" #facturacion-app-venta-cobro-totalfinal-wrapper").hide();
					$("#"+this.windowId+" #facturacion-app-venta-cobro-descuento-wrapper").hide();
				}else{
					$("#"+this.windowId+" #facturacion-app-venta-cobro-efectivo-wrapper").hide();
					$("#"+this.windowId+" #facturacion-app-venta-cobro-cambio-wrapper").hide();					
				}
			}
		}else{
			printVenta=true;
		}
		
		$("#"+this.windowId+" #facturacion-app-venta-cobro-descuento").text(descuento);
		$("#"+this.windowId+" #facturacion-app-venta-cobro-propina").text(propina);
		$("#"+this.windowId+" #facturacion-app-venta-cobro-totalfinal").text((parseFloat(total) - parseFloat(descuento)).toFixed(2));
		
		this.modal.procesar_venta.modal('show');
		this.modal.procesar_venta.appendTo("body");
		
		var rows=$("#"+this.windowId+" #nueva-orden-platos-tabla-wrapper table > tbody > tr");
		var productos=[];
		$.each(rows,function(index,producto){
			productos.push({
				id:$(producto).attr('data-id'),
				desc:$(producto).attr('data-nombre'),
				cant:$(producto).attr('data-cant'),
				precio:$(producto).attr('data-precio'),
				total:$(producto).attr('data-total'),
				promo:$(producto).attr('data-promo')
			});
		});
		
		if(printVenta){
			$.post(_this.baseUrl+"home/guardar_venta",{
				orden:$("#"+_this.windowId+" #nueva-orden-id").val(),
				origen:$("#"+_this.windowId+" #nueva-orden-origen").val(),
				mesero:$("#"+_this.windowId+" #facturacion-app-orden-mesero-id").val(),
				notas:notas,
				cliente_nombre:cliente_nombre,
				direccion:direccion,
				dui:dui,
				nit:nit,
				nrc:nrc,
				empleado_nombre:empleado_nombre,
				subtotal:subtotal,
				propina:propina,
				descuento:descuento,
				total:total,
				forma_pago:forma_pago,
				documento_pago:documento_pago,
				numero_documento:numero_documento,
				servicio:servicio,
				efectivo:efectivo,
				pos:pos,
				cambio:cambio,
				productos:JSON.stringify(productos)
			}).done(function(saved){
				if(saved){
					$("#facturacion-app-procesar-venta-"+_this.windowId+" #facturacion-app-procesar-venta-icon").removeClass("fa-spinner");
					$("#facturacion-app-procesar-venta-"+_this.windowId+" #facturacion-app-procesar-venta-icon").addClass("fa-check-circle");
					$("#facturacion-app-procesar-venta-"+_this.windowId+" #facturacion-app-procesar-venta-icon").addClass("text-success");
					$("#facturacion-app-procesar-venta-"+_this.windowId+" #facturacion-app-procesar-venta-text").text("¡La transaccion se ha guardado!");	
					$("#facturacion-app-procesar-venta-"+_this.windowId+" #facturacion-app-venta-cobro-salir-btn").removeAttr("disabled");
				}else{
					$("#facturacion-app-procesar-venta-"+_this.windowId+" #facturacion-app-procesar-venta-icon").removeClass("fa-spinner");
					$("#facturacion-app-procesar-venta-"+_this.windowId+" #facturacion-app-procesar-venta-icon").addClass("fa-exclamation-triangle");
					$("#facturacion-app-procesar-venta-"+_this.windowId+" #facturacion-app-procesar-venta-icon").addClass("text-warning");
					$("#facturacion-app-procesar-venta-"+_this.windowId+" #facturacion-app-procesar-venta-text").text("¡Ha ocurrido un error al procesar la venta!");
					$("#facturacion-app-procesar-venta-"+_this.windowId+" #facturacion-app-venta-cobro-salir-btn").removeAttr("disabled");
				} 
			}); 			
		}
		if(printConsumo){
			$.post(_this.baseUrl+"home/guardar_consumo",{
				orden:$("#"+_this.windowId+" #facturacion-app-orden-id").val(),
				mesero:$("#"+_this.windowId+" #facturacion-app-orden-mesero-id").val(),
				cliente_nombre:cliente_nombre,
				empleado_nombre:empleado_nombre,
				id_empleado:id_empleado,
				subtotal:subtotal,
				propina:propina,
				descuento:descuento,
				total:total,
				forma_pago:forma_pago,
				servicio:servicio,
				efectivo:efectivo,
				cambio:cambio,
				productos:JSON.stringify(productos)
			}).done(function(saved){
				if(printVenta==false){
					$("#facturacion-app-procesar-venta-"+_this.windowId+" #facturacion-app-procesar-venta-icon").removeClass("fa-spinner");
					$("#facturacion-app-procesar-venta-"+_this.windowId+" #facturacion-app-procesar-venta-icon").addClass("fa-check-circle");
					$("#facturacion-app-procesar-venta-"+_this.windowId+" #facturacion-app-procesar-venta-icon").addClass("text-success");
					$("#facturacion-app-procesar-venta-"+_this.windowId+" #facturacion-app-procesar-venta-text").text("¡La transaccion se ha guardado!");	
					$("#facturacion-app-procesar-venta-"+_this.windowId+" #facturacion-app-venta-cobro-salir-btn").removeAttr("disabled");
				}
			}); 			
		}
	},
	/*Mostrar un mensaje*/
	this.showMsg=function(tipo, mensaje){
		toastr.options = {
			"closeButton": true,
			"progressBar": true,
			"positionClass": "toast-top-right"
		}
		toastr[tipo](mensaje);
	}
}