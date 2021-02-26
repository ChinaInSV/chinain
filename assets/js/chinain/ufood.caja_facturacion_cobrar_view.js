var Caja_facturacion_cobrar=function(){
	this.baseUrl=null;
	this.windowId=null;
	this.parent=null;
		/*INICIO*/
	this.initializeEnviroment=function(url,winId,parent){
		this.baseUrl=url;
		this.windowId=winId;
		this.initializeListeners();
		this.parent=parent;
	},
	this.test=function(){
		console.log("La clase Caja_facturacion_cobrar se ha instanseado desde: "+this.baseUrl, " en la ventana: "+this.windowId);
	}
	this.initializeListeners=function(){
		var _this=this;
		/*temporal hack*/
		$("#"+this.windowId+" #facturacion-cobrar-pago-efectivo").focus();
		/**/
		$("#"+this.windowId+" #facturacion-cobrar-pago-efectivo").keyup(function(e){
			if(e.which==13){
				$("#"+_this.windowId+" #facturacion-cobrar-pago-cobrar-btn").trigger("click");
			}else{
				_this.calcCambio($(this).val());
			}
		});
		
		$("#"+this.windowId+" #facturacion-cobrar-pago-efectivo-mixto").keyup(function(e){
			if(e.which==13){
				$("#"+_this.windowId+" #facturacion-cobrar-pago-cobrar-btn").trigger("click");
			}else{
				_this.calcCambioMixto($(this).val());
			}
		});
		
		$("#"+this.windowId+" #facturacion-cobrar-pago-pos-mixto").keyup(function(e){
			if(e.which==13){
				$("#"+_this.windowId+" #facturacion-cobrar-pago-cobrar-btn").trigger("click");
			}else{
				_this.calcCambioMixto($("#"+_this.windowId+" #facturacion-cobrar-pago-efectivo-mixto").val());
			}
		});
		
		$("#"+this.windowId+" #facturacion-cobrar-pago-efectivo-consumo").keyup(function(e){
			if(e.which==13){
				$("#"+_this.windowId+" #facturacion-cobrar-pago-cobrar-btn").trigger("click");
			}else{
				_this.calcCambioConsumo($(this).val());
			}
		});
		
		$("#"+this.windowId+" .facturacion-forma-pago-btn").click(function(){
			var active=$("#"+_this.windowId+" #facturacion-forma-pago-wrapper").find("button.active");
			if(active.length){
				$(active).removeClass("active");				
			}
			var tipo=$(this).attr("data-tipo");
			$("#"+_this.windowId+" #facturacion-cobrar-descuento-wrapper").hide();
			$("#"+_this.windowId+" #facturacion-cobrar-pago-mixto-wrapper").hide();
			$("#"+_this.windowId+" #facturacion-cobrar-pago-efectivo-wrapper").hide();
			$("#"+_this.windowId+" #facturacion-cobrar-pago-pos-wrapper").hide();
			$("#"+_this.windowId+" #facturacion-cobrar-pago-consumo-wrapper").hide();
			$("#"+_this.windowId+" #facturacion-cliente-wrapper").hide();
			$("#"+_this.windowId+" #facturacion-empleado-wrapper").hide();
			$("#"+_this.windowId+" .facturacion-documento-ticket-wrapper").hide().find("button").prop("disabled",false).removeClass("active");
			$("#"+_this.windowId+" .facturacion-documento-ccf-wrapper").hide();
			$("#"+_this.windowId+" .facturacion-documento-factura-wrapper").hide();
			$("#"+_this.windowId+" .facturacion-documento-recibo-wrapper").hide().find("button").prop("disabled",false).removeClass("active");
			$("#"+_this.windowId+" .facturacion-servicio-btn").prop("disabled",false);
			switch(tipo){
				case "0":/*Efectivo*/
					$("#"+_this.windowId+" .facturacion-documento-ticket-wrapper,#"+_this.windowId+" .facturacion-documento-ccf-wrapper,#"+_this.windowId+" .facturacion-documento-factura-wrapper").show().find("button.facturacion-documento-btn-default").trigger("click");
					$("#"+_this.windowId+" #facturacion-cobrar-pago-efectivo-wrapper").show();
					$("#"+_this.windowId+" #facturacion-cliente-wrapper").show();
					setTimeout(function(){ $("#"+_this.windowId+" #facturacion-cobrar-pago-efectivo").focus(); }, 200);					
				break;
				case "1":/*POS*/
					$("#"+_this.windowId+" .facturacion-documento-ticket-wrapper,#"+_this.windowId+" .facturacion-documento-ccf-wrapper,#"+_this.windowId+" .facturacion-documento-factura-wrapper").show().find("button.facturacion-documento-btn-default").trigger("click");
					$("#"+_this.windowId+" #facturacion-cobrar-pago-pos-wrapper").show();
					$("#"+_this.windowId+" #facturacion-cliente-wrapper").show();
				break;
				case "2":/*Mixto*/
					$("#"+_this.windowId+" .facturacion-documento-ticket-wrapper,#"+_this.windowId+" .facturacion-documento-ccf-wrapper,#"+_this.windowId+" .facturacion-documento-factura-wrapper").show().find("button.facturacion-documento-btn-default").trigger("click");
					$("#"+_this.windowId+" #facturacion-cobrar-pago-mixto-wrapper").show();
					$("#"+_this.windowId+" #facturacion-cliente-wrapper").show();
					setTimeout(function(){ $("#"+_this.windowId+" #facturacion-cobrar-pago-pos-mixto").focus(); }, 200);					
				break;
				case "9":/*Consumo Empleado*/
					$("#"+_this.windowId+" .facturacion-documento-recibo-wrapper").show().find("button").trigger("click").prop("disabled",true);					
					$("#"+_this.windowId+" #facturacion-cobrar-pago-consumo-wrapper").show();
					$("#"+_this.windowId+" #facturacion-empleado-wrapper").show();
					if(parseFloat($("#"+_this.windowId+" #facturacion-cobrar-pago-total").val()) > parseFloat($("#"+_this.windowId+" #facturacion-cobrar-consumo").val())){
						$("#"+_this.windowId+" .facturacion-documento-ticket-wrapper").show().find("button").prop("disabled",true).addClass("active");
						setTimeout(function(){ $("#"+_this.windowId+" #facturacion-cobrar-pago-efectivo-consumo").focus(); }, 200);
					}
					$("#"+_this.windowId+" .facturacion-servicio-btn").prop("disabled",true).removeClass("active").first().addClass("active");				
				break;
				case "10":/*Descuento*/
				$("#"+_this.windowId+" .facturacion-documento-ticket-wrapper,#"+_this.windowId+" .facturacion-documento-ccf-wrapper,#"+_this.windowId+" .facturacion-documento-factura-wrapper").show().find("button.facturacion-documento-btn-default").trigger("click");
				$("#"+_this.windowId+" #facturacion-cobrar-descuento-wrapper").show();
					$("#"+_this.windowId+" #facturacion-cliente-wrapper").show();
					setTimeout(function(){ $("#"+_this.windowId+" #facturacion-cobrar-valor-descuento").focus(); }, 200);					
				break;
			}
		});
		
		$("#"+this.windowId+" .facturacion-servicio-btn").click(function(){
			var active=$("#"+_this.windowId+" #facturacion-servicio-wrapper").find("button.active");
			if(active.length){
				$(active).removeClass("active");
			}
			var tipo=$(this).attr("data-tipo");
			switch(tipo){
				case "Para comer aca":
					_this.parent.calcTotales();
				break;
				default:
					_this.parent.calcTotalesSP();
				break;
			}
			$("#"+_this.windowId+" #facturacion-cobrar-pago-total").val($("#"+_this.parent.windowId+" #nueva-orden-totales-total > td.total-value > span").text());
			$("#"+_this.windowId+" #facturacion-cobrar-pago-total-text").text($("#"+_this.parent.windowId+" #nueva-orden-totales-total > td.total-value > span").text());
			setTimeout(function(){ $("#"+_this.windowId+" #facturacion-cobrar-pago-efectivo").val("").focus(); }, 200);
			_this.calcCambio($("#"+_this.parent.windowId+" #nueva-orden-totales-total > td.total-value > span").text());
		});
		
		$("#"+this.windowId+" .facturacion-documento-btn").click(function(){
			var active=$("#"+_this.windowId+" #facturacion-documento-wrapper").find("button.active");
			if(active.length){
				$(active).removeClass("active");				
			}
			var tipo=$(this).attr("data-tipo");
			switch(tipo){
				case "0":case "9":
					$("#"+_this.windowId+" #facturacion-documento-numero").prop("disabled","disabled").val("");				
				break;
				case "1":
					$("#"+_this.windowId+" #facturacion-documento-numero").prop("disabled","").val("");
					setTimeout(function(){ $("#"+_this.windowId+" #facturacion-documento-numero").focus(); }, 200);					
				break;
				case "2":
					$("#"+_this.windowId+" #facturacion-documento-numero").prop("disabled","").val("");
					setTimeout(function(){ $("#"+_this.windowId+" #facturacion-documento-numero").focus(); }, 200);					
				break;
				case "3":
					$("#"+_this.windowId+" #facturacion-documento-numero").prop("disabled","disabled").val("");	
					setTimeout(function(){ $("#"+_this.windowId+" #facturacion-documento-numero").focus(); }, 200);					
				break;

				case "10":
					$("#"+_this.windowId+" #facturacion-documento-numero").prop("disabled","").val("");
					setTimeout(function(){ $("#"+_this.windowId+" #facturacion-documento-numero").focus(); }, 200);					
				break;
			}
		});
		$("#"+this.windowId+" #facturacion-cobrar-pago-salir-btn").click(function(){
			_this.parent.calcTotales();
			Custombox.close();
		});
		/**/
		$("#"+this.windowId+" #facturacion-cobrar-pago-cobrar-btn").click(function(){
			var sendInfo=true;
			var forma_pago=$("#"+_this.windowId+" #facturacion-forma-pago-wrapper").find("button.active");
			var documento_pago=$("#"+_this.windowId+" #facturacion-documento-wrapper").find("button.active");
			
			if($(documento_pago).attr("data-tipo")==1 || $(documento_pago).attr("data-tipo")==2){
				var num=parseInt($("#"+_this.windowId+" #facturacion-documento-numero").val());
				if(!isNaN(num)){
					sendInfo=true;
					if($(documento_pago).attr("data-tipo")==2){
						if($("#"+_this.windowId+" #facturacion-cobrar-pago-cliente").val()==""){
							_this.showMsg("error","Ingrese el nombre del Cliente");
							$("#"+_this.windowId+" #facturacion-cobrar-pago-cliente").focus();
							sendInfo=false;
						}else if($("#"+_this.windowId+" #facturacion-documento-nrc").val()==""){
							_this.showMsg("error","Ingrese el Numero de Registro del Cliente");
							$("#"+_this.windowId+" #facturacion-documento-nrc").focus();
							sendInfo=false;	
						}
					}
				}else{
					_this.showMsg("error","Ingrese un valor v&aacute;lido para el numero de Documento");
					$("#"+_this.windowId+" #facturacion-documento-numero").focus();
					sendInfo=false;
				}
			}
			
			if(sendInfo){
				switch($(forma_pago).attr("data-tipo")){
					case "0":{/*Efectivo*/
						var cambio=parseFloat($("#"+_this.windowId+" #facturacion-cobrar-pago-cambio").val());
						if(!isNaN(cambio)){
							var total=parseFloat($("#"+_this.windowId+" #facturacion-cobrar-pago-total").val());
							var efectivo=parseFloat($("#"+_this.windowId+" #facturacion-cobrar-pago-efectivo").val());
							if(efectivo>=total){
								sendInfo=true;
							}else{
								_this.showMsg("error","Ingrese un valor v&aacute;lido para el efectivo");
								$("#"+_this.windowId+" #facturacion-cobrar-pago-efectivo").focus();
								sendInfo=false;
							}
						}else{
							_this.showMsg("error","Ingrese un valor v&aacute;lido para el efectivo");
							$("#"+_this.windowId+" #facturacion-cobrar-pago-efectivo").focus();
							sendInfo=false;
						}
					}break;
					case "1":{/*POS*/
						sendInfo=true;
					}break;
					case "2":{/*Mixto*/
						var cambio=parseFloat($("#"+_this.windowId+" #facturacion-cobrar-pago-cambio-mixto").val());
						if(!isNaN(cambio)){
							var total=parseFloat($("#"+_this.windowId+" #facturacion-cobrar-pago-total").val());
							var efectivo=parseFloat($("#"+_this.windowId+" #facturacion-cobrar-pago-efectivo-mixto").val());
							var pos=parseFloat($("#"+_this.windowId+" #facturacion-cobrar-pago-pos-mixto").val());
							if(efectivo>=total){
								_this.showMsg("error","En un pago mixto el efectivo no puede ser mayor que el total");
								$("#"+_this.windowId+" #facturacion-cobrar-pago-efectivo-mixto").focus();
								sendInfo=false;
							}else if(pos>=total){
								_this.showMsg("error","En un pago mixto el POS no puede ser mayor que el total");
								$("#"+_this.windowId+" #facturacion-cobrar-pago-pos-mixto").focus();
								sendInfo=false;
							}else if((efectivo+pos) >= total){
								sendInfo=true;
							}else{
								_this.showMsg("error","Ingrese un valor v&aacute;lido para el efectivo o POS");
								$("#"+_this.windowId+" #facturacion-cobrar-pago-pos-mixto").focus();
								sendInfo=false;
							}
						}else{
							_this.showMsg("error","Ingrese un valor v&aacute;lido para el efectivo o POS");
							$("#"+_this.windowId+" #facturacion-cobrar-pago-efectivo-mixto").focus();
							sendInfo=false;
						}
					}break;
					case "9":{/*Consumo*/
						var id_empleado=$("#"+_this.windowId+" #facturacion-cobrar-pago-empleado").val();
						var cambio=parseFloat($("#"+_this.windowId+" #facturacion-cobrar-pago-cambio-consumo").val());
						if(id_empleado==null){
							_this.showMsg("error","Seleccione un empleado de la lista");
							$("#"+_this.windowId+" #facturacion-cobrar-pago-empleado").focus();
							sendInfo=false;
						}else if($("#"+_this.windowId+" #facturacion-cobrar-pago-consumo-forma-wrapper").is(":visible")){
							if(!isNaN(cambio)){
								var total=parseFloat($("#"+_this.windowId+" #facturacion-cobrar-pago-total").val()) - parseFloat($("#"+_this.windowId+" #facturacion-cobrar-consumo").val());
								var efectivo=parseFloat($("#"+_this.windowId+" #facturacion-cobrar-pago-efectivo-consumo").val());
								if(efectivo>=total){
									sendInfo=true;
								}else{
									_this.showMsg("error","Ingrese un valor v&aacute;lido para el efectivo");
									$("#"+_this.windowId+" #facturacion-cobrar-pago-efectivo-consumo").focus();
									sendInfo=false;
								}							
							}else{
								_this.showMsg("error","Ingrese un valor v&aacute;lido para el efectivo");
								$("#"+_this.windowId+" #facturacion-cobrar-pago-efectivo-consumo").focus();
								sendInfo=false;
							}
						}else{
							sendInfo=true;
						}
					}break;
				}
			}
			
			if(sendInfo){
				_this.setInfo();
			}
		});
	},
	
	this.calcCambio=function(efectivo){
		var total=$("#"+this.windowId+" #facturacion-cobrar-pago-total").val();
		var cambio=parseFloat(efectivo)-parseFloat(total);
		$("#"+this.windowId+" #facturacion-cobrar-pago-cambio").val(cambio.toFixed(2));
	}
	this.calcCambioConsumo=function(efectivo){
		var total=$("#"+this.windowId+" #facturacion-cobrar-pago-total").val();
		var descuento=$("#"+this.windowId+" #facturacion-cobrar-consumo").val();
		var cambio=parseFloat(efectivo)-(parseFloat(total)-parseFloat(descuento));
		$("#"+this.windowId+" #facturacion-cobrar-pago-cambio-consumo").val(cambio.toFixed(2));
	}
	this.calcCambioMixto=function(efectivo){
		var total=$("#"+this.windowId+" #facturacion-cobrar-pago-total").val();
		var pos=$("#"+this.windowId+" #facturacion-cobrar-pago-pos-mixto").val();
		var cambio=parseFloat(efectivo)-(parseFloat(total)-parseFloat(pos));
		$("#"+this.windowId+" #facturacion-cobrar-pago-cambio-mixto").val(cambio.toFixed(2));
	}
	/*Mostrar un mensaje*/
	this.showMsg=function(tipo, mensaje){
		toastr.options = {
			"closeButton": true,
			"progressBar": true,
			"positionClass": "toast-top-right"
		}
		toastr[tipo](mensaje);
	}
	this.setInfo=function(){
		var _this=this;
		var pos=0;
		var forma_pago=$("#"+this.windowId+" #facturacion-forma-pago-wrapper").find("button.active");
		var documento_pago=$("#"+this.windowId+" #facturacion-documento-wrapper").find("button.active");
		var servicio=$("#"+this.windowId+" #facturacion-servicio-wrapper").find("button.active");
		$("#"+this.windowId+" #facturacion-cobrar-pago-cobrar-btn").prop("disabled",true);
		
		if($(forma_pago).attr("data-tipo")==9){
			efectivo=parseFloat($("#"+_this.windowId+" #facturacion-cobrar-pago-efectivo-consumo").val());
			cambio=parseFloat($("#"+_this.windowId+" #facturacion-cobrar-pago-cambio-consumo").val());
		}else if($(forma_pago).attr("data-tipo")==2){
			efectivo=parseFloat($("#"+_this.windowId+" #facturacion-cobrar-pago-efectivo-mixto").val());
			pos=parseFloat($("#"+_this.windowId+" #facturacion-cobrar-pago-pos-mixto").val());
			cambio=parseFloat($("#"+_this.windowId+" #facturacion-cobrar-pago-cambio-mixto").val());
		}else{
			efectivo=parseFloat($("#"+_this.windowId+" #facturacion-cobrar-pago-efectivo").val());
			cambio=parseFloat($("#"+_this.windowId+" #facturacion-cobrar-pago-cambio").val());
		}
		
		if(this.parent){
			this.parent.setCobroInfo({
				total:parseFloat($("#"+_this.windowId+" #facturacion-cobrar-pago-total").val()),
				desc_empleado:parseFloat($("#"+_this.windowId+" #facturacion-cobrar-consumo").val()),
				forma_pago:$(forma_pago).attr("data-tipo"),
				documento_pago:$(documento_pago).attr("data-tipo"),
				servicio:$(servicio).attr("data-tipo"),
				efectivo:efectivo,
				pos:pos,
				cambio:cambio,
				numero_documento:$("#"+_this.windowId+" #facturacion-documento-numero").val(),
				notas:$("#"+_this.windowId+" #facturacion-cobrar-pago-notas").val(),
				cliente:$("#"+_this.windowId+" #facturacion-cobrar-pago-cliente").val(),
				direccion:$("#"+_this.windowId+" #facturacion-documento-direccion").val(),
				dui:$("#"+_this.windowId+" #facturacion-documento-dui").val(),
				nit:$("#"+_this.windowId+" #facturacion-documento-nit").val(),
				nrc:$("#"+_this.windowId+" #facturacion-documento-nrc").val(),
				empleado:$("#"+_this.windowId+" #facturacion-cobrar-pago-empleado option:selected").text(),
				id_empleado:$("#"+_this.windowId+" #facturacion-cobrar-pago-empleado option:selected").val(),
				promotor:$("#"+_this.windowId+" #facturacion-cobrar-promotor option:selected").val(),
				descuento:0,
			});
			Custombox.close();
		}
	}
}