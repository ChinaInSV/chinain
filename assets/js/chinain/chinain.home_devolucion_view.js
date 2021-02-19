var Devolucion_view=function(){
	this.baseUrl=null;
	this.windowId=null;
	this.configs=null;
		/*INICIO*/
	this.initializeEnviroment=function(url,winId,configs){
		this.baseUrl=url;
		this.windowId=winId;
		this.configs=configs;
		this.initializeGUIComponets();
		this.initializeListeners();
	},
	this.test=function(){
		console.log("La clase Devolucion_view se ha instanseado desde: "+this.baseUrl, " en la ventana: "+this.windowId);
	},
	/*Inicializar componentes de la interfaz*/
	this.initializeGUIComponets=function(){
		var _this=this;	
		this.modal={cliente_info:null}
		$("#"+this.windowId+" #devolucion-cargar-txt").focus();
	},
	/*EVENTOS*/
	this.initializeListeners=function(){
		var _this=this;
		/*BUTTON Cargar orden (CLICK)*/
		$("#"+this.windowId+" #devolucion-cargar-btn").click(function(){
			var ref=$("#"+_this.windowId+" #devolucion-cargar-txt").val();
			if(ref!=""){
				$.get(_this.baseUrl+"home/devolucion_info",{ref:ref,winid:_this.windowId},function(response){
					$("#"+_this.windowId+" #devolucion-info-wrapper").html(response);
					_this.modal.cliente_info=$("#devolucion-info-cliente-"+_this.windowId)
					/*MODAL acciones al cerrar modal de confirmar (HIDDEN)*/
					_this.modal.cliente_info.on("hidden.bs.modal",function(){
						$(this).appendTo("#"+_this.windowId+" #devolucion-modals-wrapper");
					});
				});

				setTimeout(function(){$("#devolucion-info-wrapper #devolucion-guardar-btn").focus()},500);
				
			}else{
				_this.showMsg("error","Ingrese un numero de referencia.");
				$("#"+_this.windowId+" #devolucion-cargar-txt").focus();
			}
		});
		/*TEXTBOX Ingresar referencia (KEYUP)*/
		$("#"+this.windowId+" #devolucion-cargar-txt").keyup(function(e){
			if(e.which==13){
				e.preventDefault();
				$("#"+_this.windowId+" #devolucion-cargar-btn").trigger("click");
			}else{
				return true;
			}
		});
		/*BUTTON Guardar Devolucion*/
		$("#"+this.windowId).on("click","#devolucion-guardar-btn",function(){
			_this.modal.cliente_info.modal("show");
			_this.modal.cliente_info.appendTo("body");
			
			setTimeout(function(){$("#devolucion-info-cliente-nombre").focus();},500)
			
			 $("#devolucion-info-cliente-continuar-btn").click(function(){
				 if($("#devolucion-info-cliente-nombre").val()!=""){
					 if($("#devolucion-info-cliente-dui").val()!=""){
						 if($("#devolucion-info-cliente-motivo").val()!=""){
							 _this.modal.cliente_info.modal("hide");
							_this.confirmarDevolucion();
						 }else{
							 _this.showMsg("error","Es necesario agregar un motivo de devoluci&oacute;n para continuar");
							 $("#devolucion-info-cliente-motivo").focus();
						 }
					 }else{
						 _this.showMsg("error","Es necesario agregar un el DUI del cliente para continuar");
						  $("#devolucion-info-cliente-dui").focus();
					 }
				 }else{
					 _this.showMsg("error","Es necesario agregar un el Nombre del cliente para continuar");
					  $("#devolucion-info-cliente-nombre").focus();
				 }
			 });
			 $("#devolucion-info-cliente-salir-btn").click(function(){
				_this.modal.cliente_info.modal("hide");
			});
		}); 
	},
	/**/
	this.confirmarDevolucion=function(){
		var _this=this;
		var total=$("#"+_this.windowId+" #devolucion-info-total-dev").val();
			swal({
				title:"Hacer devoluci&oacute;n",
				text: "Realmente desea realizar una devoluci&oacute;n de $"+total,
				html:true,
				type: "warning",
				showCancelButton: true,
				confirmButtonColor: "#DD6B55",
				confirmButtonText: "SI, Realizar devolución",
				cancelButtonText: "Cancelar",
				closeOnConfirm: true,
				closeOnCancel: true
			},
			function(isConfirm){
				if(isConfirm){
					var venta=$("#"+_this.windowId+" #devolucion-info-venta-dev").val();
					var cliente=$("#"+_this.windowId+" #devolucion-info-cliente-nombre").val();
					var dui=$("#"+_this.windowId+" #devolucion-info-cliente-dui").val();
					var motivo=$("#"+_this.windowId+" #devolucion-info-cliente-motivo").val();
					var rows=$("#"+_this.windowId+" #devolucion-productos-table-wrapper > table > tbody > tr");
					var productos=[];
					$.each(rows,function(index,producto){
						productos.push({
							id:$(producto).attr('data-id'),
							desc:$(producto).attr('data-nombre'),
							cant:$(producto).attr('data-cant'),
							precio:$(producto).attr('data-precio'),
							total:$(producto).attr('data-total'),
						}); 
					});
					/*send*/
					$.post(_this.baseUrl+"home/guardar_devolucion",{
						venta:venta,
						cliente:cliente,
						dui:dui,
						motivo:motivo,
						productos:JSON.stringify(productos),
						total:total
					},function(response){
						if(response){
							_this.showMsg("success","La devoluci&oacute;n se ha registrado con exito");
							Custombox.close();
						}else{
							_this.showMsg("error","Ha ocurrido un error, intentelo nuevamente o contacte a soporte tecnico");
						}
					});
				}
			});
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