var Reportes=function(){
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
		console.log("La clase Reportes se ha instanseado desde: "+this.baseUrl, " en la ventana: "+this.windowId);
	},
	/*EVENTOS*/
	this.initializeListeners=function(){
		var _this=this;
		
		////////////
		/*Reportes*/
		////////////
		
		/*Pagos*/
		$("#"+this.windowId+" #reporte-pagos-forma").change(function(e){
			if($(this).val()==0){
				$("#"+_this.windowId+" #reporte-pagos-fechas-months").hide();
				$("#"+_this.windowId+" #reporte-pagos-fechas-days").show();
			}else{
				$("#"+_this.windowId+" #reporte-pagos-fechas-days").hide();
				$("#"+_this.windowId+" #reporte-pagos-fechas-months").show();
			}
		});
		$("#"+this.windowId+" #reporte-pagos-btn").click(function(e){
			e.preventDefault();
			var valid=false;
			
			if($("#"+_this.windowId+" #reporte-pagos-fechas-days").is(":visible")){
				if($("#"+_this.windowId+" #reporte-pagos-fechadesde-day").val()==""){
					ChinaInTools.showMsg("error","Favor ingrese una fecha de inicio");$("#"+_this.windowId+" #reporte-pagos-fechadesde-day").focus();
				}else if($("#"+_this.windowId+" #reporte-pagos-fechahasta-day").val()==""){
					ChinaInTools.showMsg("error","Favor ingrese una fecha de final");$("#"+_this.windowId+" #reporte-pagos-fechahasta-day").focus();
				}else{
					fechadesde = $("#"+_this.windowId+" #reporte-pagos-fechadesde-day").val();
					fechahasta = $("#"+_this.windowId+" #reporte-pagos-fechahasta-day").val();
					valid=true;
				}
			}else{
				if($("#"+_this.windowId+" #reporte-pagos-fechadesde-month").val()==""){
					ChinaInTools.showMsg("error","Favor ingrese un mes de inicio");$("#"+_this.windowId+" #reporte-pagos-fechadesde-month").focus();
				}else if($("#"+_this.windowId+" #reporte-pagos-fechahasta-month").val()==""){
					ChinaInTools.showMsg("error","Favor ingrese un mes de final");$("#"+_this.windowId+" #reporte-pagos-fechahasta-month").focus();
				}else{
					fechadesde = $("#"+_this.windowId+" #reporte-pagos-fechadesde-month").val();
					fechahasta = $("#"+_this.windowId+" #reporte-pagos-fechahasta-month").val();
					valid=true;
				}
			}
			
			if(valid){
				var data={
					metodo:$("#"+_this.windowId+" #reporte-pagos-metodo").val(),
					forma:$("#"+_this.windowId+" #reporte-pagos-forma").val(),
					cliente:$("#"+_this.windowId+" #reporte-pagos-clientes").val(),
					usuario:$("#"+_this.windowId+" #reporte-pagos-usuarios").val(),
					fechadesde:fechadesde,
					fechahasta:fechahasta,
					devoluciones:$("#"+_this.windowId+" #reporte-pagos-devoluciones").is(":checked"),
					valores:$("#"+_this.windowId+" #reporte-pagos-valores").is(":checked"),
				};
				_this.makeReport("reporte_pagos",data);				
			}
		});
		
		/*Platos*/
		$("#"+this.windowId+" #reporte-platos-btn").click(function(e){
			e.preventDefault();
			var valid=false;
			
			if($("#"+_this.windowId+" #reporte-platos-fechadesde-day").val()==""){
					ChinaInTools.showMsg("error","Favor ingrese una fecha de inicio");$("#"+_this.windowId+" #reporte-platos-fechadesde-day").focus();
				}else if($("#"+_this.windowId+" #reporte-platos-fechahasta-day").val()==""){
					ChinaInTools.showMsg("error","Favor ingrese una fecha de final");$("#"+_this.windowId+" #reporte-platos-fechahasta-day").focus();
				}else{
					fechadesde = $("#"+_this.windowId+" #reporte-platos-fechadesde-day").val();
					fechahasta = $("#"+_this.windowId+" #reporte-platos-fechahasta-day").val();
					valid=true;
				}
			
			if(valid){
				var data={
					forma:$("#"+_this.windowId+" #reporte-platos-forma").val(),
					fechadesde:fechadesde,
					fechahasta:fechahasta,
					grupos:$("#"+_this.windowId+" #reporte-platos-grupos").is(":checked"),
					cero:$("#"+_this.windowId+" #reporte-platos-cero").is(":checked"),
				};
				_this.makeReport("reporte_platos",data);				
			}
		});
		
		////////////
		/*Graficos*/
		////////////
		
		/*Pagos*/
		$("#"+this.windowId+" #grafico-pagos-forma").change(function(e){
			if($(this).val()==0){
				$("#"+_this.windowId+" #grafico-pagos-fechas-months").hide();
				$("#"+_this.windowId+" #grafico-pagos-fechas-days").show();
			}else{
				$("#"+_this.windowId+" #grafico-pagos-fechas-days").hide();
				$("#"+_this.windowId+" #grafico-pagos-fechas-months").show();
			}
		});
		$("#"+this.windowId+" #grafico-pagos-btn").click(function(e){
			e.preventDefault();
			var valid=false;
			
			if($("#"+_this.windowId+" #grafico-pagos-fechas-days").is(":visible")){
				if($("#"+_this.windowId+" #grafico-pagos-fechadesde-day").val()==""){
					ChinaInTools.showMsg("error","Favor ingrese una fecha de inicio");$("#"+_this.windowId+" #grafico-pagos-fechadesde-day").focus();
				}else if($("#"+_this.windowId+" #grafico-pagos-fechahasta-day").val()==""){
					ChinaInTools.showMsg("error","Favor ingrese una fecha de final");$("#"+_this.windowId+" #grafico-pagos-fechahasta-day").focus();
				}else{
					fechadesde = $("#"+_this.windowId+" #grafico-pagos-fechadesde-day").val();
					fechahasta = $("#"+_this.windowId+" #grafico-pagos-fechahasta-day").val();
					valid=true;
				}
			}else{
				if($("#"+_this.windowId+" #grafico-pagos-fechadesde-month").val()==""){
					ChinaInTools.showMsg("error","Favor ingrese un mes de inicio");$("#"+_this.windowId+" #grafico-pagos-fechadesde-month").focus();
				}else if($("#"+_this.windowId+" #grafico-pagos-fechahasta-month").val()==""){
					ChinaInTools.showMsg("error","Favor ingrese un mes de final");$("#"+_this.windowId+" #grafico-pagos-fechahasta-month").focus();
				}else{
					fechadesde = $("#"+_this.windowId+" #grafico-pagos-fechadesde-month").val();
					fechahasta = $("#"+_this.windowId+" #grafico-pagos-fechahasta-month").val();
					valid=true;
				}
			}
			
			if(valid){
				var data={
					forma:$("#"+_this.windowId+" #grafico-pagos-forma").val(),
					fechadesde:fechadesde,
					fechahasta:fechahasta,
					valores:$("#"+_this.windowId+" #grafico-pagos-valores").is(":checked")
				};
				_this.makeGraphic("grafico_pagos",data,"grafico-pagos-div");				
			}
		});
		
		/*Grupos*/
		$("#"+this.windowId+" #grafico-grupos-btn").click(function(e){
			e.preventDefault();
			var valid=false;
			
			if($("#"+_this.windowId+" #grafico-grupos-fechadesde-day").val()==""){
				ChinaInTools.showMsg("error","Favor ingrese una fecha de inicio");$("#"+_this.windowId+" #grafico-grupos-fechadesde-day").focus();
			}else if($("#"+_this.windowId+" #grafico-grupos-fechahasta-day").val()==""){
				ChinaInTools.showMsg("error","Favor ingrese una fecha de final");$("#"+_this.windowId+" #grafico-grupos-fechahasta-day").focus();
			}else{
				fechadesde = $("#"+_this.windowId+" #grafico-grupos-fechadesde-day").val();
				fechahasta = $("#"+_this.windowId+" #grafico-grupos-fechahasta-day").val();
				valid=true;
			}
			
			if(valid){
				var data={
					tipo:$("#"+_this.windowId+" #grafico-grupos-tipo").val(),
					fechadesde:fechadesde,
					fechahasta:fechahasta,
					valores:$("#"+_this.windowId+" #grafico-grupos-valores").is(":checked")
				};
				_this.makeGraphic("grafico_servicios",data,"grafico-grupos-div");				
			}
		});
	},
	/*Inicializar componentes de la interfaz*/
	this.initializeGUIComponets=function(){
		var _this=this;
		
		$("#"+this.windowId+" .input-daterange-days").datepicker({
			format: "dd MM, yyyy",
			todayBtn: "linked",
			autoclose: true,
			todayHighlight: true,
			clearBtn: true
		});
		
		$("#"+this.windowId+" .input-daterange-months").datepicker({
			todayBtn: "linked",
			autoclose: true,
			todayHighlight: true,
			clearBtn: true,
			format: "MM, yyyy",
			viewMode: "months", 
			minViewMode: "months"
		});
		
		$("#"+this.windowId+" #reportes-wrapper").slimScroll({
			height: ($(window).height()-190)+"px"
		});
		
		/*Chosen cliente*/
		$("#"+this.windowId+" #reporte-pagos-clientes,#"+this.windowId+" #reporte-pagos-usuarios").chosen({
			no_results_text:"No se encontro ningun resultado",
			allow_single_deselect:true
		}).change(function(){
			
		});
	},
	this.makeReport=function(url,data){
		var _this=this;
		var parametros="";
		if(data){
			parametros="?"+$.param(data);
		}
		window.open(_this.baseUrl+"reportes/"+url+parametros);
	},
	this.makeGraphic=function(url,data,div){
		var _this=this;
		var parametros="";
		if(data){
			parametros="?"+$.param(data);
		}
		$.get(_this.baseUrl+"reportes/"+url+parametros)
		.done(function(data){                
			$("#"+_this.windowId+" #"+div).html(data);
		});
	}
}