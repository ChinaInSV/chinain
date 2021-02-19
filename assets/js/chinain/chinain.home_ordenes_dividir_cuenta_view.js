var Home_ordenes_dividir_cuenta=function(){
	this.baseUrl=null;
    this.windowId=null;
    this.modal=null;
	this.config=null;
	/*INICIO*/
	this.initializeEnviroment=function(url,winId,config){
		this.baseUrl=url;
        this.windowId=winId;
        this.config=config;
        this.initializeGUIComponets();
        this.initializeListeners();
    },
    /*Inicializar componentes de la interfaz*/
	this.initializeGUIComponets=function(){
		var _this=this;	
		this.modal={
			modificar_precios:$("#dividir-cuenta-modificar-precios-"+_this.windowId)
		}
	}
	/*EVENTOS*/
	this.initializeListeners=function(){
		var _this=this;
		
		$("#"+this.windowId).on("click","#dividir-cuenta-salir-btn",function(e){			
			e.preventDefault();
			Custombox.close();
        });
        
        /*BOTON Modificar la cantidad y precio de un plato (CLICK)*/
		$("#"+this.windowId+" .dividir-cuenta-plato-btn").click(function(){
			var selPlato=$(this);
			var platoxorden=selPlato.attr("data-platoxorden");
			var id=selPlato.attr("data-id");
			var nombre=selPlato.attr("data-nombre");
			var cant=selPlato.attr("data-cant");
            var precio=selPlato.attr("data-precio");
            $("#"+_this.windowId+" #dividir-cuenta-plato-platoxorden").val(platoxorden);
            $("#"+_this.windowId+" #dividir-cuenta-plato-id").val(id);
            $("#"+_this.windowId+" #dividir-cuenta-plato-precio").val(precio);
            $("#"+_this.windowId+" #dividir-cuenta-plato-cant").val(cant);
            $("#"+_this.windowId+" #dividir-cuenta-plato-desc").val(nombre);
			_this.modal.modificar_precios.find(".modal-dialog > .modal-content > .modal-header > .modal-title > b").text(nombre);
			_this.modal.modificar_precios.find("#dividir-cuenta-cantidades-cantidad").val(cant);
			_this.modal.modificar_precios.find("#dividir-cuenta-cantidades-costo").val(precio);
			_this.modal.modificar_precios.find("#dividir-cuenta-cantidades-agregar-btn").removeClass("hidden");
			_this.modal.modificar_precios.modal('show');
			_this.modal.modificar_precios.appendTo("body");
        });
        
        /*--------------------- MODAL MODIFICAR PRECIOS --------------------------*/
		if(this.modal.modificar_precios){
			/*BOTON Continuar modificar precios (CLICK)*/
			this.modal.modificar_precios.on("click","#dividir-cuenta-cantidades-agregar-btn",function(){
				var selPlato=$("#"+_this.windowId+" .dividir-orden-item-actual#item-actual-"+$("#"+_this.windowId+" #dividir-cuenta-plato-platoxorden").val());
				cant=parseFloat(_this.modal.modificar_precios.find("#dividir-cuenta-cantidades-cantidad").val());
				precio=parseFloat(_this.modal.modificar_precios.find("#dividir-cuenta-cantidades-costo").val());
				total=cant*precio;
				cant=cant.toFixed(_this.config.cant_decimal_precision);
				precio=precio.toFixed(_this.config.precios_decimal_precision);
                total=total.toFixed(_this.config.precios_decimal_precision);

                
                cant_anterior=parseFloat(selPlato.attr("data-cant"));
				precio_anterior=parseFloat(selPlato.attr("data-precio"));
				cant_anterior=cant_anterior.toFixed(_this.config.cant_decimal_precision);
				precio_anterior=precio_anterior.toFixed(_this.config.precios_decimal_precision);
				
				if(_this.modal.modificar_precios.find("#dividir-cuenta-cantidades-cantidad").val()<= 0 || _this.modal.modificar_precios.find("#dividir-cuenta-cantidades-cantidad").val()=="" || _this.modal.modificar_precios.find("#dividir-cuenta-cantidades-cantidad").val() > $("#"+_this.windowId+" #dividir-cuenta-plato-cant").val()){
					_this.showMsg("error","Debe ingresar la cantidad de servicio valida para poder continuar");
					_this.modal.modificar_precios.find("#dividir-cuenta-cantidades-cantidad").focus();
				}else if(_this.modal.modificar_precios.find("#dividir-cuenta-cantidades-costo").val()<= 0 || _this.modal.modificar_precios.find("#dividir-cuenta-cantidades-costo").val()==""){
					_this.showMsg("error","Debe ingresar el costo de servicio valida para poder continuar");
					_this.modal.modificar_precios.find("#dividir-cuenta-cantidades-costo").focus();
				}else{
					total_anterior=(parseFloat(cant_anterior - cant)*parseFloat(precio_anterior)).toFixed(_this.config.precios_decimal_precision);
					selPlato.attr("data-cant",cant_anterior - cant);					
					selPlato.find(".plato-cant-field").html(cant_anterior - cant);
					selPlato.find(".plato-precio-field").html(precio_anterior);
					selPlato.find(".plato-total-field").html(total_anterior);
					
					//_this.calcTotales();
					_this.modal.modificar_precios.modal('hide');
				}
				
			});
			
			this.modal.modificar_precios.on("click",".dividir-cuenta-cantidades-disminuir-btn",function(){
				var $el = $(this);
				if($el.closest(".input-group").find(".dividir-cuenta-cantidades-texts").attr("id")=="dividir-cuenta-cantidades-cantidad"){
					var cantidadServicio=parseFloat($el.closest(".input-group").find(".dividir-cuenta-cantidades-texts").val()) - 1;
					if(cantidadServicio>0){
						$el.closest(".input-group").find(".dividir-cuenta-cantidades-texts").val(cantidadServicio);
					}
				}else{
					var costoServicio=parseFloat($el.closest(".input-group").find(".dividir-cuenta-cantidades-texts").val()) - 0.25;
					if(costoServicio>0){
						$el.closest(".input-group").find(".dividir-cuenta-cantidades-texts").val(costoServicio);
					}
				}
			});
			
			this.modal.modificar_precios.on("click",".dividir-cuenta-cantidades-aumentar-btn",function(){
				var $el = $(this);
				if($el.closest(".input-group").find(".dividir-cuenta-cantidades-texts").attr("id")=="dividir-cuenta-cantidades-cantidad"){
					var cantidadServicio=parseFloat($el.closest(".input-group").find(".dividir-cuenta-cantidades-texts").val()) + 1;
					$el.closest(".input-group").find(".dividir-cuenta-cantidades-texts").val(cantidadServicio);
				}else{
					var costoServicio=parseFloat($el.closest(".input-group").find(".dividir-cuenta-cantidades-texts").val()) + 0.25;
					$el.closest(".input-group").find(".dividir-cuenta-cantidades-texts").val(costoServicio);
				}
			});
			
			/*MODAL acciones al cerrar modal de modificar precios (HIDDEN)*/
			this.modal.modificar_precios.on("hidden.bs.modal",function(){
                $(this).appendTo("#"+_this.windowId+" #dividir-cuenta-modals-wrapper");
                $("#"+_this.windowId+" #dividir-cuenta-plato-platoxorden").val("");
                $("#"+_this.windowId+" #dividir-cuenta-plato-id").val("");
                $("#"+_this.windowId+" #dividir-cuenta-plato-precio").val("");
                $("#"+_this.windowId+" #dividir-cuenta-plato-cant").val("");
                $("#"+_this.windowId+" #dividir-cuenta-plato-desc").val("");
			});
		}
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