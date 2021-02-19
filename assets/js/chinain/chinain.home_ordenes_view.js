var Home_ordenes=function(){
	this.baseUrl=null;
	this.windowId=null;
	/*INICIO*/
	this.initializeEnviroment=function(url,winId){
		this.baseUrl=url;
		this.windowId=winId;
		this.initializeListeners();
		this.initializeGUIComponets();
		$("#"+this.windowId+" .ordenes-salones-btn").first().click();
		$("#"+this.windowId+" .ordenes-mesa").height($("#"+this.windowId+" .ordenes-mesa").width());
	},
	this.test=function(){
		console.log("La clase Home se ha instanseado desde: "+this.baseUrl, " en la ventana: "+this.windowId);
	},
	/*EVENTOS*/
	this.initializeListeners=function(){
		var _this=this;
		
		$("#"+this.windowId+" .ordenes-salones-btn").click(function(){
			var $el=$(this);
			var active=$("#"+_this.windowId+" .ordenes-salones-wrapper").find("button.active");
			$("#"+_this.windowId+" #ordenes-mesas-wrapper").find(".ordenes-mesa-salon").css("display","none");
			if(active.length){
				$(active).removeClass("active");				
			}
			$("#"+_this.windowId+" #ordenes-mesas-wrapper").find(".ordenes-mesa-salon#salon-"+$el.data("id")).show();
		});
		
		$("#"+this.windowId+" #ordenes-mesas-wrapper").on("click",".ordenes-mesa",function(e){
			var id=$(this).attr("id").split("-")[1];
			$.get(_this.baseUrl+"home/getOrderDetail",{id:id},function(ordenDetalles){
				$("#"+_this.windowId+" #ordenes-detalles-wrapper").html(ordenDetalles);
			},"html");
		});
		
		/*BUTTON Ver detalles de un plato en la orden (CLICK)*/
		$("#"+this.windowId).on("click",".orden-plato-detail-btn",function(e){
			var id=$(this).attr("data-id");
			e.preventDefault();
			Custombox.open({
				target:_this.baseUrl+"home/detalles_plato_orden?id="+id,
				escKey:true,
				zIndex:12000,
				overlayClose:true
			});
		});

		/*BUTTON Editar un plato en la orden (CLICK)*/
		$("#"+this.windowId).on("click",".orden-plato-update-btn",function(e){
			var id=$(this).attr("data-id");
			var mesa=$("#detalles-mesa-id").val();
			e.preventDefault();
			Custombox.open({
				target:_this.baseUrl+"home/editar_plato_orden?id="+id,
				escKey:true,
				zIndex:12000,
				overlayClose:true,
				close:function(){
					$.get(_this.baseUrl+"home/getOrderDetail",{id:mesa},function(ordenDetalles){
						$("#"+_this.windowId+" #ordenes-detalles-wrapper").html(ordenDetalles);
					},"html");
				}
			});
		});
		$("#"+this.windowId).on("click",".detalles-mesa-estado-btn",function(e){
			var id=$(this).attr("data-id");
			var estado=$(this).attr("data-estado");
			e.preventDefault();
			swal({
				title: "¿Cambiar estado de esta mesa?",
				text: "Esta acción cambiara el estado de esta Mesa. ¿Esta seguro que desea continuar?",
				type: "warning",
				showCancelButton: true,
				confirmButtonColor: "#DD6B55",
				confirmButtonText: "Si, cambiar",
				cancelButtonText: "Cancelar",
			},function(isConfirm){
				if(isConfirm){
					$.get(_this.baseUrl+"home/cambiar_estado_mesa",{id:id,estado:estado},function(done){
						if(done){
							_this.showMsg("success","Se ha cambiado el estado de esta mesa exitosamente");
							$.get(_this.baseUrl+"home/goOrders",function(home){
								$("#home-main-wrapper").html(home);
							},"html");
						}
					},"html");
				}
			});	
		});
		$("#"+this.windowId).on("click",".orden-plato-delete-btn",function(e){
			var id=$(this).attr("data-id");
			var mesa=$("#detalles-mesa-id").val();
			e.preventDefault();
			swal({
				title: '¿Eliminar Plato?',
				input: 'textarea',
				inputValue: $("#detalles-orden-razon-eliminar").val(),
				showCancelButton: true,
				confirmButtonText: 'Eliminar',
				cancelButtonText: 'Cancelar',
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				showLoaderOnConfirm: true,
				animation: false,
				preConfirm: function (textarea) {
				return new Promise(function (resolve, reject) {
					setTimeout(function() {
						resolve()
					}, 1000)
				})
				},
				allowOutsideClick: false
			}).then(function (textarea) {
				swal({
					type: 'success',
					title: 'Plato eliminado',
					html: 'El plato se elimino por la siguiente razon: ' + textarea
				});
				$.get(_this.baseUrl+"home/eliminar_platoxorden?id="+id+"&razon="+textarea,function(data){
					$.get(_this.baseUrl+"home/getOrderDetail",{id:mesa},function(ordenDetalles){
						$("#"+_this.windowId+" #ordenes-detalles-wrapper").html(ordenDetalles);
					},"html");
				});				
			});
		});
		
		$("#"+this.windowId).on("click",".orden-detalles-eliminar-btn",function(e){
			var id=$(this).attr("data-id");
			e.preventDefault();
			swal({
				title: '&iquest;Eliminar Orden?',
				text: 'Esta acción eliminara la Orden. ¿Esta seguro que desea continuar?',
				type: 'warning',
				showCancelButton: true,
				confirmButtonText: 'Si, eliminar',
				cancelButtonText: 'No',
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				animation: false,
			}).then(function () {
				$.get(_this.baseUrl+"home/eliminar_orden",{id:id},function(deleted){
					if(deleted){
						swal(
							'Orden Eliminada',
							'La orden se elimino exitosamente',
							'success'
						)
						$.get(_this.baseUrl+"home/goOrders",function(home){
							$("#home-main-wrapper").html(home);
						},"html");					
					}
				});
			})
		});
		
		$("#"+this.windowId).on("click",".orden-detalles-cobrar-btn",function(e){
			var id=$(this).attr("data-id");
			e.preventDefault();
			$.get(_this.baseUrl+"home/goHome?mode=edit&id="+id,function(home){
				$("#home-main-wrapper").html(home);
			},"html");
		});
		
		$("#"+this.windowId).on("click",".orden-detalles-precuenta-btn",function(e){
			var id=$(this).attr("data-id");
			e.preventDefault();
			$.get(_this.baseUrl+"home/imprimirPrecuenta?id="+id,function(result){
				if(result){
					_this.showMsg("success","Se ha enviado el Estado de Cuenta de esta Orden a impresion exitosamente");
				}
			});
		});

		$("#"+this.windowId).on("click",".orden-detalles-dividir-btn",function(e){
			var id=$(this).attr("data-id");
			var mesa=$("#detalles-mesa-id").val();
			e.preventDefault();
			Custombox.open({
				target:_this.baseUrl+"home/dividir_cuenta?id="+id,
				escKey:true,
				overlayClose:true,
				close:function(){
					$.get(_this.baseUrl+"home/getOrderDetail",{id:mesa},function(ordenDetalles){
						$("#"+_this.windowId+" #ordenes-detalles-wrapper").html(ordenDetalles);
					},"html");
				}
			});
		});
	},
	/*Inicializar componentes de la interfaz*/
	this.initializeGUIComponets=function(){
		var _this=this;
		
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