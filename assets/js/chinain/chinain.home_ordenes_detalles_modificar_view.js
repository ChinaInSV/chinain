var Home_ordenes_detalles_modificar=function(){
	this.baseUrl=null;
	this.windowId=null;
	/*INICIO*/
	this.initializeEnviroment=function(url,winId){
		this.baseUrl=url;
		this.windowId=winId;
		this.initializeListeners();
	},
	/*EVENTOS*/
	this.initializeListeners=function(){
		var _this=this;
		
		$("#"+this.windowId).on("click","#detalles-plato-salir-btn",function(e){			
			e.preventDefault();
			Custombox.close();
		});
		
		$("#"+this.windowId).on("click","#detalles-plato-actualizar-btn",function(e){			
			e.preventDefault();
			var printVenta=false;
			
			if($("#"+_this.windowId+" #detalles-plato-cantidad").val()<= 0 || $("#"+_this.windowId+" #detalles-plato-cantidad").val()==""){
				_this.showMsg("error","Debe ingresar la cantidad de servicio para poder continuar");
				$("#"+_this.windowId+" #detalles-plato-cantidad").focus();
			}else if($("#"+_this.windowId+" #detalles-plato-costo").val()<= 0 || $("#"+_this.windowId+" #detalles-plato-costo").val()==""){
				_this.showMsg("error","Debe ingresar el costo de servicio para poder continuar");
				$("#"+_this.windowId+" #detalles-plato-costo").focus();
			}else{
				printVenta=true;
			}
			
			if(printVenta){
				swal({
					title: "¿Actualizar Plato?",
					text: "Esta acción actualizara el plato de esta Orden. ¿Esta seguro que desea continuar?",
					type: "warning",
					showCancelButton: true,
					confirmButtonColor: "#DD6B55",
					confirmButtonText: "Si, actualizar",
					cancelButtonText: "Cancelar",
				},function(isConfirm){
					if(isConfirm){
						$.post(_this.baseUrl+"home/actualizar_platoxorden",{
							id:$("#"+_this.windowId+" #detalles-plato-id").val(),
							cantidad:$("#"+_this.windowId+" #detalles-plato-cantidad").val(),
							precio:$("#"+_this.windowId+" #detalles-plato-costo").val(),
							
						}).done(function(saved){
							if(saved){
								_this.showMsg("success","Se ha actualizado el plato de esta orden exitosamente");
								Custombox.close();
							}
						}); 
					}
				});	
			}
		});
		
		$("#"+this.windowId+" .detalles-plato-disminuir-btn").on("click",function(){
			var $el = $(this);
			if($el.closest(".input-group").find(".detalles-plato-texts").attr("id")=="detalles-plato-cantidad"){
				var cantidadServicio=parseFloat($el.closest(".input-group").find(".detalles-plato-texts").val()) - 1;
				if(cantidadServicio>0){
					$el.closest(".input-group").find(".detalles-plato-texts").val(cantidadServicio);
				}
			}else{
				var costoServicio=parseFloat($el.closest(".input-group").find(".detalles-plato-texts").val()) - 0.25;
				if(costoServicio>0){
					$el.closest(".input-group").find(".detalles-plato-texts").val(costoServicio);
				}
			}
		});
		
		$("#"+this.windowId+" .detalles-plato-aumentar-btn").on("click",function(){
			var $el = $(this);
			if($el.closest(".input-group").find(".detalles-plato-texts").attr("id")=="detalles-plato-cantidad"){
				var cantidadServicio=parseFloat($el.closest(".input-group").find(".detalles-plato-texts").val()) + 1;
				$el.closest(".input-group").find(".detalles-plato-texts").val(cantidadServicio);
			}else{
				var costoServicio=parseFloat($el.closest(".input-group").find(".detalles-plato-texts").val()) + 0.25;
				$el.closest(".input-group").find(".detalles-plato-texts").val(costoServicio);
			}
		});
	},
	this.showMsg=function(tipo,mensaje){
		toastr.options = {
			"closeButton":true,
			"progressBar":true,
			"positionClass":"toast-top-right"
		}
		toastr[tipo](mensaje);
	}
}