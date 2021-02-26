var Home_ordenes_callcenter=function(){
	this.baseUrl=null;
	this.windowId=null;
	/*INICIO*/
	this.initializeEnviroment=function(url,winId){
		this.baseUrl=url;
		this.windowId=winId;
		this.initializeListeners();
		this.initializeGUIComponets();
	},
	this.test=function(){
		console.log("La clase Home se ha instanseado desde: "+this.baseUrl, " en la ventana: "+this.windowId);
	},
	/*EVENTOS*/
	this.initializeListeners=function(){
		var _this=this;
		
		$("#"+this.windowId+" #table-ordenes").on("click",".ordenes-table-detalles-btn",function(e){
			var id=$(this).data("id");
			$.get(_this.baseUrl+"home/getOrderDetailCC",{id:id,origen:1},function(ordenDetalles){
				$("#"+_this.windowId+" #ordenes-callcenter-detalles-wrapper").html(ordenDetalles);
			},"html");
		});
		
		$("#"+this.windowId+" #ordenes-buscar-text").on("keyup",function(e){
			$("#ordenes-buscar-mesas,ordenes-buscar-meseros").val(0);
			_this.searchOrder(0);
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
		
		$("#"+this.windowId).on("click",".orden-plato-delete-btn",function(e){
			var id=$(this).attr("data-id");
			var orden=$("#detalles-orden-id").val();
			e.preventDefault();
			swal({
				title: "¿Eliminar Plato?",
				text: "Esta acción eliminara el plato de esta Orden. ¿Esta seguro que desea continuar?",
				type: "warning",
				showCancelButton: true,
				confirmButtonColor: "#DD6B55",
				confirmButtonText: "Si, eliminar",
				cancelButtonText: "Cancelar",
			},function(isConfirm){
				if(isConfirm){
					$.get(_this.baseUrl+"home/eliminar_platoxorden",{id:id},function(done){
						if(done){
							_this.showMsg("success","Se ha eliminado el plato de esta orden exitosamente");
							$.get(_this.baseUrl+"home/getOrderDetailCC",{id:orden,origen:1},function(ordenDetalles){
								$("#"+_this.windowId+" #ordenes-callcenter-detalles-wrapper").html(ordenDetalles);
							},"html");
						}
					},"html");
				}
			});	
		});
		
		$("#"+this.windowId).on("click",".orden-detalles-eliminar-btn",function(e){
			var id=$(this).attr("data-id");
			e.preventDefault();
			swal({
				title: "¿Eliminar Orden?",
				text: "Esta acción eliminara la Orden. ¿Esta seguro que desea continuar?",
				type: "warning",
				showCancelButton: true,
				confirmButtonColor: "#DD6B55",
				confirmButtonText: "Si, eliminar",
				cancelButtonText: "Cancelar",
			},function(isConfirm){
				if(isConfirm){
					$.get(_this.baseUrl+"home/eliminar_orden",{id:id},function(done){
						if(done){
							_this.showMsg("success","Se ha eliminado la orden de esta mesa exitosamente");
							$.get(_this.baseUrl+"home/goOrdersCallCenter",function(home){
								$("#home-main-wrapper").html(home);
							},"html");
						}
					},"html");
				}
			});	
		});
		
		$("#"+this.windowId).on("click",".orden-detalles-cobrar-btn",function(e){
			var id=$(this).attr("data-id");
			e.preventDefault();
			$.get(_this.baseUrl+"home/goHome?mode=edit&id="+id,function(home){
				$("#home-main-wrapper").html(home);
			},"html");
		});
	},
	/*Inicializar componentes de la interfaz*/
	this.initializeGUIComponets=function(){
		var _this=this;
		$("#"+_this.windowId+" #table-ordenes").footable();
	},
	this.searchOrder=function(by){
		var input, filter, table, tr, td, i, txtValue;
		switch(by){
			case 0:
				input = document.getElementById("ordenes-buscar-text");			
				filter = input.value.toUpperCase();
			break;
			case 1:
				if($("#ordenes-buscar-mesas").val()==0){
					input = "";
					filter = "";
				}else{
					input = $("#ordenes-buscar-mesas option:selected").text()+" ("+$("#ordenes-buscar-mesas option:selected").closest('optgroup').attr('label')+")";
					filter = input.toUpperCase();
				}
			break;
			case 2:
				if($("#ordenes-buscar-meseros").val()==0){
					input = "";
					filter = "";
				}else{
					input = document.getElementById("ordenes-mesero-text");			
					filter = input.value.toUpperCase();
				}
			break;
		}
		table = document.getElementById("table-ordenes");
		tr = table.getElementsByTagName("tr");

		for (i = 0; i < tr.length; i++) {
			switch(by){
				case 0:
					td = tr[i].getElementsByTagName("td")[3];
				break;
				case 1:
					td = tr[i].getElementsByTagName("td")[1];
				break;
				case 2:
					td = tr[i].getElementsByTagName("td")[2];
				break;
			}
			
			if (td) {
				txtValue = td.textContent || td.innerText;
				if (txtValue.toUpperCase().indexOf(filter) > -1) {
					tr[i].style.display = "";
				} else {
					tr[i].style.display = "none";
				}
			}
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