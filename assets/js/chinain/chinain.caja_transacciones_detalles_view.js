var Productos_salidas_detalles_venta=function(){
	this.baseUrl=null;
	this.windowId=null;
	/*Inicializar entorno*/
	this.initializeEnviroment=function(url,winId,caja){
		var _this=this;
		this.baseUrl=url;
		this.windowId=winId;
		this.initializeGUIComponets();
		this.initializeListeners();
	},
	/*Inicializar componentes de la interfaz*/
	this.initializeGUIComponets=function(){
		$("#"+this.windowId+" #venta-detalles-wrapper").slimScroll({height:"80px",alwaysVisible:true});
	},
	this.initializeListeners=function(){
		var _this=this;
		/*BOTON Reimprimir (CLICK)*/
		$("#"+this.windowId+" #venta-detalles-reimprimir-btn").click(function(){
			if(!$(this).is(':disabled')){
				$(this).prop("disabled","disabled");
				if($("#"+_this.windowId+" #venta-detalles-doc-code").val()=="3")
					$("#"+_this.windowId+" #venta-detalles-reimpresion-copias-wrapper").show()
				else
					$("#"+_this.windowId+" #venta-detalles-reimpresion-copias-wrapper").hide()
				$("#"+_this.windowId+" #venta-detalles-reimpresion").modal("show");
			}
		});
		/*BOTON Confirmar impresion (CLICK)*/
		$("#"+this.windowId+" #venta-detalles-reimpresion-guardar-btn").click(function(){
			if(!$(this).is(':disabled')){
				$(this).prop("disabled","disabled");
				var productos=[];
				var totales=[];
				var products=$("#"+_this.windowId+" #nueva-venta-productos-wrapper table tr");
				var totals=$("#"+_this.windowId+" #nueva-venta-totales-wrapper tr");
				$.each(products,function(index,product){
					productos.push({interno:$(product).attr('data-interno'),desc:$(product).find('.table-desc').attr('data-value'),cant:$(product).find('.table-cant').attr('data-value'),costo:$(product).find('.table-precio').attr('data-value'),tipoventa:$(product).find('.table-tipoventa').attr('data-value')});
				});
				$.each(totals,function(index,total){
					switch($(total).attr('class')){
						case 'totalSumas':totales.push({totalSumas:$(total).find('.totalval').attr('data-value')});break;
						case 'totalGrabadas':totales.push({totalGrabadas:$(total).find('.totalval').attr('data-value')});break;
						case 'totalIVA':totales.push({totalIVA:$(total).find('.totalval').attr('data-value')});break;
						case 'totalIVApercibido':totales.push({totalIVApercibido:$(total).find('.totalval').attr('data-value')});break;
						case 'totalIVAretenido':totales.push({totalIVAretenido:$(total).find('.totalval').attr('data-value')});break;
						case 'totalSubtotal':totales.push({totalSubtotal:$(total).find('.totalval').attr('data-value')});break;
						case 'totalNS':totales.push({totalNS:$(total).find('.totalval').attr('data-value')});break;
						case 'totalExento':totales.push({totalExento:$(total).find('.totalval').attr('data-value')});break;
						case 'totalTotal':totales.push({totalTotal:$(total).find('.totalval').attr('data-value')});break;
					}
				});
				$.post(_this.baseUrl+'transacciones/reimprimirventa',{
					referencia:$("#"+_this.windowId+" #detalles-venta-info-id").attr("data-value"), 
					fecha:$("#"+_this.windowId+" #detalles-venta-fecha").attr("data-value"), 
					cliente:$("#"+_this.windowId+" #detalles-venta-info-idcliente").attr("data-value"),
					clientetxt:$("#"+_this.windowId+" #detalles-venta-info-cliente").attr("data-value"),
					dui:$("#"+_this.windowId+" #detalles-venta-info-dui").attr("data-value"),
					nit:$("#"+_this.windowId+" #detalles-venta-info-nit").attr("data-value"),
					nrc:$("#"+_this.windowId+" #detalles-venta-info-nrc").attr("data-value"),
					condicion:$("#"+_this.windowId+" #detalles-venta-info-cobro").attr("data-value"),
					documento:$("#"+_this.windowId+" #venta-detalles-doc-code").val(),
					serieid:$("#"+_this.windowId+" #venta-detalles-doc-serieid").val(),
					numero:$("#"+_this.windowId+" #detalles-venta-info-numdoc").attr("data-value"),
					vendedor:$("#"+_this.windowId+" #detalles-venta-info-vendedor").attr("data-value"),			
					cajero:$("#"+_this.windowId+" #detalles-venta-info-cajero").attr("data-value"),
					caja:$("#"+_this.windowId+" #detalles-venta-info-caja").attr("data-value"),
					copias:$("#"+_this.windowId+" #venta-detalles-reimpresion-copias").val(),
					productos:JSON.stringify(productos),
					totales:JSON.stringify(totales)}
				).done(function(saved){
					toastr.options = {
						"closeButton": true,
						"progressBar": true,
						"positionClass": "toast-top-right"
					}
					toastr["success"]("La orden de impresión se ha enviado");
					$("#"+_this.windowId+" #venta-detalles-reimpresion").modal("hide");
					$("#"+_this.windowId+" #venta-detalles-reimpresion-guardar-btn").removeAttr("disabled");
				});
			}
		});
		/*MODAL Cerrar modal reimpresion (EVENTO)*/
		$("#"+this.windowId+" #venta-detalles-reimpresion").on('hidden.bs.modal', function(e){
			$("#"+_this.windowId+" #venta-detalles-reimprimir-btn").removeAttr("disabled");
		});
		
	}
}