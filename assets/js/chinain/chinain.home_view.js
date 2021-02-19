var Home=function(){
	this.baseUrl=null;
	this.windowId=null;
	/*INICIO*/
	this.initializeEnviroment=function(url,winId){
		this.baseUrl=url;
		this.windowId=winId;
		this.initializeListeners();
		this.initializeGUIComponets();
		this.goHome();
		this.downloadOrders();
	},
	this.test=function(){
		console.log("La clase Home se ha instanseado desde: "+this.baseUrl, " en la ventana: "+this.windowId);
	},
	/*EVENTOS*/
	this.initializeListeners=function(){
		var _this=this;
		$("#home-add-order-btn").on("click",function(){
			_this.goHome();
		});
		$("#home-orders-btn").on("click",function(){
			_this.goOrders();
		});
		$("#home-orders-callcenter-btn").on("click",function(){
			_this.goOrdersCallCenter();
		});
		
		$("#home-cortes-app-btn").click(function(e){
			e.preventDefault();
			Custombox.open({
				target:_this.baseUrl+"caja/caja_cortes",
				close: function(){
					$("#home-add-order-btn").click();
				},
			});
		});
	},
	/*Inicializar componentes de la interfaz*/
	this.initializeGUIComponets=function(){
		var _this=this;
		
		setInterval(function(){
			_this.downloadOrders();
		}, 180000);
		
		$( document ).idleTimer("destroy");
		
		$( document ).idleTimer( {
			timeout:5000
		});
		
		$( document ).on( "idle.idleTimer", function(event, elem, obj){
			/*Inactivo*/
			if($("#ordenes-contenido-wrapper").length > 0){
				_this.goOrders();
			}
			if($("#ordenes-callcenter-contenido-wrapper").length > 0){
				_this.goOrdersCallCenter();
			}
		});

		$( document ).on( "active.idleTimer", function(event, elem, obj, triggerevent){
			/*Activo*/
			if($("#ordenes-contenido-wrapper").length > 0){
				_this.goOrders();
			}
			if($("#ordenes-callcenter-contenido-wrapper").length > 0){
				_this.goOrdersCallCenter();
			}
		});
	},
	this.downloadOrders=function(){
		var _this=this;
		$.get(_this.baseUrl+"callcenter/descargar_ordenes",function(){});
	},
	this.goHome=function(){
		var _this=this;
		$.get(_this.baseUrl+"home/goHome",function(home){
			$("#"+_this.windowId).html(home);
			$("#home-search-by-cliente-wrapper").addClass("hidden");
		},"html");
	},
	this.goOrders=function(){
		var _this=this;
		$.get(_this.baseUrl+"home/goOrders",function(home){
			$("#"+_this.windowId).html(home);
			$("#home-search-by-cliente-wrapper").addClass("hidden");
		},"html");
	},
	this.goOrdersCallCenter=function(){
		var _this=this;
		$.get(_this.baseUrl+"home/goOrdersCallCenter",function(home){
			$("#"+_this.windowId).html(home);
			$("#home-search-by-cliente-wrapper").addClass("hidden");
		},"html");
	}
}