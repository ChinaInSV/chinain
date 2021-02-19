var Caja_cortes=function(){
	this.baseUrl=null;
	this.windowId=null;
	this.caja=null;
	this.modal=null;
	/*INICIO*/
	this.initializeEnviroment=function(url,winId,caja){
		this.baseUrl=url;
		this.caja=caja;
		this.windowId=winId;
		this.initializeListeners();
		this.initializeGUIComponets();
	},
	this.test=function(){
		console.log("La clase Caja Cortes se ha instanseado desde: "+this.baseUrl, " en la ventana: "+this.windowId);
	},
	/*EVENTOS*/
	this.initializeListeners=function(){
		var _this=this;
		$("#"+this.windowId+" .cortes-app-tipo-corte").on("click",function(){
			var $this=$(this);
			switch($this.attr("id")){
				case "cortes-app-tipo-corte-xinicial-btn":
					$("#corte-email").prop({"disabled":true,"checked":false});
				break;
				case "cortes-app-tipo-corte-xparcial-btn":
					$("#corte-email").prop({"disabled":false,"checked":false});
				break;
				case "cortes-app-tipo-corte-zdiario-btn":
					$("#corte-email").prop({"disabled":true,"checked":true});
				break;
				case "cortes-app-tipo-corte-zmensual-btn":
					$("#corte-email").prop({"disabled":true,"checked":false});
				break;
			}
		});
		
		/*BOTON generar corte (CLICK)*/
		$("#"+this.windowId+" #cortes-app-generar-corte-btn").click(function(e){
			if(!$(this).is(':disabled')){
				if($("#"+_this.windowId+" #cortes-app-tipo-corte-text").attr("data-type")>=0){
					_this.validCorte($(this),$("#"+_this.windowId+" #cortes-app-tipo-corte-text").parent(),null);
				}else{
					_this.showMsg("warning","Seleccione un tipo de corte");
					$("#"+_this.windowId+" #cortes-app-tipo-corte-text").parent().focus();
				}
			}
		});
		/*BOTON generar corte opciones cancelar (CLICK)*/
		$("#"+this.windowId+" #cortes-app-generar-cancelar-btn").click(function(e){
			if(!$(this).is(':disabled')){
				_this.clearOptionsForm(true,true);
				_this.modal.generar.appendTo("#"+_this.windowId+" #cortes-app-modales-wrapper");
				$("#"+_this.windowId+" #cortes-app-generar-corte-btn").removeAttr("disabled");
				$("#"+_this.windowId+" #cortes-app-tipo-corte").removeAttr("disabled");
				$("#"+_this.windowId+" #cortes-app-tipo-corte").find("option:first").removeAttr("disabled");
				$("#"+_this.windowId+" #cortes-app-tipo-corte").find("option:first").prop("selected","selected");
				$("#"+_this.windowId+" #cortes-app-tipo-corte").find("option:first").attr("disabled","disabled");
			}
		});
		/*BOTON generar corte opciones continuar (CLICK)*/
		$("#"+this.windowId+" #cortes-app-generar-continuar-btn").click(function(e){
			if(!$(this).is(':disabled')){
				var valid=true;
				var info={
					dotacion:$("#"+_this.windowId+" #cortes-app-dotacion").val(),
					ticketSerie:$("#"+_this.windowId+" #cortes-app-resolucion").val()
				}
				var capDotacion=null;
				var capSerie=null;
				var requiredDotacion=_this.modal.generar.find("#cortes-app-generar-opciones-dotacion").is(":visible");
				var requiredSerie=_this.modal.generar.find("#cortes-app-generar-opciones-serie").is(":visible");
				var requiredMsg=_this.modal.generar.find("#cortes-app-generar-opciones-msg").is(":visible");
				if(requiredMsg && !requiredDotacion && !requiredSerie){
					_this.makeCorte();
				}else{
					if(requiredDotacion){
						if(_this.modal.generar.find("#cortes-app-generar-dotacion-text").val()==""){
							_this.showMsg("warning","Por favor ingrese una cantidad v&aacute; para la dotaci&oacute;n");
							_this.modal.generar.find("#cortes-app-generar-dotacion-text").focus();
							valid=false;
						}else{
							info.dotacion=_this.modal.generar.find("#cortes-app-generar-dotacion-text").val();
						}
					}
					if(requiredSerie){
						info.ticketSerie=_this.modal.generar.find("#cortes-app-generar-tickets-serie").val();
					}
				}
				if(valid)
					_this.validCorte($(this),$("#"+_this.windowId+" #cortes-app-tipo-corte-text").parent(),info); 
			}
		});
		/*BOTON exportar/imprimir corte (CLICK)*/
		$("#"+this.windowId+" #cortes-app-exportar-imprimir").click(function(e){
			if(!$(this).is(':disabled')){
				_this.modal.exportar.modal('show');
				_this.modal.exportar.appendTo("body");
			}
		});
		
		$("#"+this.windowId+" #cortes-app-exportar-cancelar-btn").click(function(e){
			_this.modal.exportar.appendTo("#"+_this.windowId+" #cortes-app-modales-wrapper");
		});
		
		$("#"+this.windowId+" #cortes-app-exportar-cinta").click(function(e){
			var id=$("#"+_this.windowId+" #id_corte").val();
			Custombox.open({
				target:_this.baseUrl+"caja/cinta?id="+id,
				effect: 'fadein',
				zIndex: 11000
			});
		});
		
		$("#"+this.windowId+" #cortes-app-exportar-continuar-btn").click(function(e){
			if(!$(this).is(':disabled')){
			var corte=_this.modal.exportar.find("#corte-fiscal").is(":checked");
				var id=$("#"+_this.windowId+" #id_corte").val();
			
				if(_this.modal.exportar.find("#cortes-app-exportar-opcion").val()==0){
					url="caja/print_corte";
					$.get(_this.baseUrl+url,{id:id,corte:corte},function(e){
						_this.modal.exportar.modal('hide');
						_this.modal.exportar.appendTo("#"+_this.windowId+" #cortes-app-modales-wrapper");
						_this.showMsg("info","Se ha enviado la orden");
					},"text");
				}else{
					url="caja/exportar_corte";
					window.open(_this.baseUrl+url+"?id="+id+"&corte="+corte,"_blank");
					_this.modal.exportar.modal('hide');
					_this.modal.exportar.appendTo("#"+_this.windowId+" #cortes-app-modales-wrapper");
				}				
			}
		});
		
		
		/*Botones cortes*/
		$("#"+this.windowId+" .cortes-app-tipo-corte").click(function(e){
			$("#"+_this.windowId+" #cortes-app-tipo-corte-text").attr("data-type",$(this).data("type")).text($(this).text());
		});
	},
	/*Inicializar componentes de la interfaz*/
	this.initializeGUIComponets=function(){
		var _this=this;
		/*modales*/
		this.modal={
			generar:$("#cortes-app-generar-opciones-"+_this.windowId),
			exportar:$("#cortes-app-exportar-opciones-"+_this.windowId),
		}
	},
	/*Cargar opciones de corte para estado de caja*/
	this.loadOptions=function(estadoCaja,cortes){
		if(estadoCaja=="0"){/*Inactiva*/
			$("#"+this.windowId+" #cortes-app-tipo-corte-xparcial-btn").parent().remove();
			$("#"+this.windowId+" #cortes-app-tipo-corte-zdiario-btn").parent().remove();
			if(cortes==0){
				$("#"+this.windowId+" #cortes-app-tipo-corte-zmensual-btn").parent().remove();
			}
		}else if(estadoCaja=="1"){/*Activa*/
			$("#"+this.windowId+" #cortes-app-tipo-corte-xinicial-btn").parent().remove();
			$("#"+this.windowId+" #cortes-app-tipo-corte-zmensual-btn").parent().remove();
		}
	},
	/*Validar corte*/
	this.validCorte=function($sender,$typeWrapper,info){
		var _this=this;
		$sender.prop("disabled","disabled");
		$typeWrapper.prop("disabled","disabled");
		this.clearOptionsForm(true,true);
		var _this=this;
		var type=parseInt($("#"+_this.windowId+" #cortes-app-tipo-corte-text").attr("data-type"));
		var okTicketSerie=true;
		var okDotacion=true;
		var okMsg=true;
		var ticketSerie="na";
		var dotacion="na"
		var msg="";
		if(info)
			infoCorte=info;
		else{
			infoCorte={};
		}
		/*Mostrar ventana de opciones - modo procesando*/
		_this.modal.generar.modal('show');
		_this.modal.generar.appendTo("body");
		_this.modal.generar.find("#cortes-app-generar-opciones-loading").show();
		_this.modal.generar.find("#cortes-app-generar-opciones-wrapper").hide();
		
		/*Verificar dotación para corte x iniciarl*/
		if(type===0){
			if(!infoCorte.dotacion || infoCorte.dotacion==''){
				okDotacion=false;
			}else{
				dotacion=infoCorte.dotacion;
			}
		}
		$("#"+_this.windowId+" #cortes-app-dotacion").val(dotacion);
		$("#"+_this.windowId+" #cortes-app-resolucion").val(ticketSerie)		
		
		/*Procesar cortes*/
		if(okTicketSerie && okDotacion && okMsg){
			this.makeCorte();
		}else{
			var $focus=null;
			/*Cambiar ventana de opciones a modo captura de datos*/
			_this.modal.generar.find("#cortes-app-generar-opciones-loading").hide();
			_this.modal.generar.find("#cortes-app-generar-opciones-wrapper").show();
			_this.modal.generar.find("#cortes-app-generar-cancelar-btn").show();
			_this.modal.generar.find("#cortes-app-generar-continuar-btn").show();
			this.clearOptionsForm(false,true);
			if(!okTicketSerie){
				_this.modal.generar.find("#cortes-app-generar-opciones-serie").show();
				$focus=_this.modal.generar.find("#cortes-app-generar-tickets-serie");
			}
			if(!okDotacion){
				_this.modal.generar.find("#cortes-app-generar-opciones-dotacion").show();
				$focus=_this.modal.generar.find("#cortes-app-generar-dotacion-text");
			}
			if(!okMsg){
				_this.modal.generar.find("#cortes-app-generar-opciones-msg").show();
				_this.modal.generar.find("#cortes-app-generar-opciones-msg").text(msg);
				$focus=_this.modal.generar.find("#cortes-app-generar-continuar-btn");
			}
			if(focus){
				setTimeout(function(){$focus.focus();},800);
			}
		}		
	},
	/*Limpiar formulario*/
	this.clearOptionsForm=function(clear,hide){
		var _this=this;
		if(clear){
			_this.modal.generar.find("#cortes-app-generar-opciones-msg").text("");
			_this.modal.generar.find("#cortes-app-generar-dotacion-text").val("");
			_this.modal.generar.find("#cortes-app-generar-tickets-serie option").remove();
			_this.modal.generar.find("#cortes-app-generar-tickets-serie").val("");
			
			_this.modal.generar.find("#cortes-app-dotacion").val("");
			_this.modal.generar.find("#cortes-app-resolucion").val("");
		}
		if(hide){
			_this.modal.generar.find("#cortes-app-generar-opciones-msg").hide();
			_this.modal.generar.find("#cortes-app-generar-opciones-dotacion").hide();
			_this.modal.generar.find("#cortes-app-generar-opciones-serie").hide();
		}
	},
	/*Hace corte*/
	this.makeCorte=function(){
		var _this=this;
		_this.modal.generar.find("#cortes-app-generar-opciones-wrapper").hide();
		_this.modal.generar.find("#cortes-app-generar-opciones-loading").show();
		_this.modal.generar.find("#cortes-app-generar-opciones-loading-status").text('Procesando...');
		_this.modal.generar.find("#cortes-app-generar-cancelar-btn").hide();
		_this.modal.generar.find("#cortes-app-generar-continuar-btn").hide();
		var email=$("#corte-email").is(":checked");
		
		$.get(this.baseUrl+"caja/makecorte",{email:email,tipo:$("#"+this.windowId+" #cortes-app-tipo-corte-text").data("type"),dotacion:$("#"+this.windowId+" #cortes-app-dotacion").val(),serie:$("#"+this.windowId+" #cortes-app-resolucion").val()},function(cortes){
			_this.modal.generar.modal("hide");
			_this.modal.generar.appendTo("#"+_this.windowId+" #cortes-app-modales-wrapper");
			$("#"+_this.windowId+" #cortes-app-exportar-imprimir").removeAttr("disabled");
			if($("#"+_this.windowId+" #cortes-app-tipo-corte-text").data("type")==2){
				$("#"+_this.windowId+" #cortes-app-exportar-cinta").removeAttr("disabled");	
			}
			$("#corte-email").prop({"disabled":true});
			$("#"+_this.windowId+" #cortes-app-corte-wrapper").html(cortes);
			_this.showMsg("success","Corte generado con exito");				
		},"html");
	},
	/*Mostar mensaje*/
	this.showMsg=function(tipo, mensaje){
		new $.Zebra_Dialog({
			title: 'China In App',
			message: mensaje,
			custom_class:"zebra-"+tipo
		});
	}
}