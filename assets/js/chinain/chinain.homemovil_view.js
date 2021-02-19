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
		
	},
	this.goHome=function(){
		var _this=this;
		$.get(_this.baseUrl+"home/goHomemovil",function(home){
			$("#"+_this.windowId).html(home);
		},"html");
	}
}