var Caja_transacciones=function(){
	this.baseUrl=null;
	this.windowId=null;
	this.users=null;
	/*INICIO*/
	this.initializeEnviroment=function(url,winId,users){
		this.baseUrl=url;
		this.windowId=winId;
		this.users=users;
		this.initializeListeners();
		this.initializeGUIComponets();
	},
	this.test=function(){
		console.log("La clase Caja_transacciones se ha instanseado desde: "+this.baseUrl, " en la ventana: "+this.windowId);
	},
	/*EVENTOS*/
	this.initializeListeners=function(){
		var _this=this;
		
		$("#salidas-ventas-tabla").on("click",".ventas-table-view-btn",function(e){
			e.preventDefault();
			var id= $(this).attr("data-id");
			Custombox.open({
				target: _this.baseUrl+'caja/salida_detalles?transaccion='+id+'&source=venta',
			});
		});
	}
	/*Inicializar componentes de la interfaz*/
	this.initializeGUIComponets=function(){
		var _this=this;
		
		var tableVentas=$("#salidas-ventas-tabla").DataTable({
			serverSide: true,
			ajax:{
				url:_this.baseUrl+'caja/cargar_ventas',
				data:function(d){
					d.search['by']=$('#ventas-param-select-search').val();
					d.search['doc']=$('#ventas-doc-select-search').val();
				}
			},
			dom: 'l<"custom_searchbox_ventas">tip',
			order: [ 0, 'desc' ],
			columns:[
				{name:'referencia',data:0},
				{name:'fecha',data:1},
				{name:'vendedor',data:2},
				{name:'cliente',data:3},
				{name:'documento',data:4},
				{name:'numero',data:5},
				{name:'total',data:6,orderable:false},
				{name:'estado',data:7},
				{name:'acciones',data:8,orderable:false},
			],
			language: {
				"emptyTable":"",
				"lengthMenu": "Mostrar _MENU_ registros por pagina",
				"zeroRecords":"",
				"info": "Pagina _PAGE_ de _PAGES_ de _MAX_ registros encontrados",
				"infoEmpty":"No hay registros",
				"infoFiltered":"(Ningun resultado encontrado de _MAX_ registros)",
				"search":"Buscar:",
				"paginate": {
					"first":"Primero",
					"last": "Ultimo",
					"next": "Siguiente",
					"previous":"Anterior"
				}
			},
		});
		$("div.custom_searchbox_ventas").html("<div class='pull-right m-sm'><label>Buscar:</label> <select class='form-control' id='ventas-param-select-search'><option value='referencia' selected>Referencia</option><option value='fecha'>Fecha</option><option value='vendedor'>Vendedor</option><option value='cliente'>Cliente</option><option value='documento'>Documento</option></select><div id='ventas-field-search-wrapper' class='pull-right'><input type='text' id='ventas-table-search-field' class='form-control' style='width:250px;' placeholder='Numero de referencia'></div></div><div class='clear-fix'></div>")
		$("#ventas-param-select-search").on("change",function(){
			$fieldWrapper=$("#ventas-field-search-wrapper");
			$fieldWrapper.html("");
			var $textbox=$("<input type='text' id='ventas-textbox-search' class='form-control' style='width:250px;'>");
			var $select=$("<select id='ventas-select-search' class='form-control' style='width:250px;'></select>");
			switch($(this).val()){
				case "referencia":
					$textbox.attr("placeholder","Numero de referencia");
					$fieldWrapper.append($textbox);
					$textbox.on("keyup",function(){
						tableVentas.search($(this).val()).draw();
					});
					$textbox.focus();
				break;
				case "fecha":
					$textbox.attr("placeholder","Seleccione una fecha");
					$textbox.attr("readonly","readonly");
					$fieldWrapper.append($textbox);
					$textbox.daterangepicker({
						format: 'DD-MM-YYYY',
						separator: ' al ',
						singleDatePicker: true,
						locale:{
							applyLabel: 'Aplicar',
							cancelLabel: 'Cancelar',
							fromLabel: 'Desde',
							toLabel: 'Hasta',
							weekLabel: 'W',
							customRangeLabel: 'Custom Range',
							daysOfWeek: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi','Sa'],
							monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre']
						},
						showDropdowns: true
					});
					$textbox.on("change",function(){
						tableVentas.search($(this).val()).draw();
					});
					$textbox.focus();
				break;
				case "vendedor":
					$select.html("<option disabled selected>Seleccione uno...</option>"+_this.users);
					$fieldWrapper.append($select);
					$select.on("change",function(){
						tableVentas.search($(this).val()).draw();
					});
					$select.focus();
					break;
				case "cliente":
					$textbox.attr("placeholder","Nombre del cliente");
					$fieldWrapper.append($textbox);
					$textbox.on("keyup",function(){
						tableVentas.search($(this).val()).draw();
					});
					$textbox.focus();
					break;
				case "documento":
					$select.html("<option value='' selected>Todos</option><option value='1'>Factura</option><option value='2'>CCF</option><option value='3'>Ticket</option><option value='4'>N. Remisi&oacute;n</option><option value='5'>N. Env&iacute;o</option>")
					$select.attr("style","width:125px;");
					$select.attr("id","ventas-doc-select-search");
					$textbox.attr("style","width:125px;");
					$fieldWrapper.append($select);
					$fieldWrapper.append($textbox);
					$select.on("change",function(){
						tableVentas.search('').draw();
						$textbox.val('');
						$textbox.focus();
					});
					$textbox.on("keyup",function(){
						tableVentas.search($(this).val()).draw();
					});
					$select.focus();
					break;
			}
			tableVentas.search('').draw();
		});
		$("#ventas-table-search-field").on("keyup",function(){
			tableVentas.search($(this).val()).draw();
		});
	}
}