<div class="row" id="<?php $winid=date('YmdHis'); echo $winid;?>">
	<div class="panel">
		<!--Panel body-->
		<div class="panel-body">
			<div class="col-sm-12">
				<div class="form-group text-center">
					<label class="col-sm-3 control-label text-right text-semibold text-2x" for="" style="margin-top:8px;">Corte</label>
					<div class="col-sm-5">
						<!--<select id="cortes-app-tipo-corte" class="form-control input-lg">
							<option selected disabled>Seleccione uno...</option>
							<option value="0">Corte X inicial</option>
							<option value="1">Corte X parcial</option>
							<option value="2">Corte Z</option>
							<option value="3">Corte Z mensual</option>
						</select>-->
						<div class="btn-group btn-group-lg btn-group-justified">
							<div class="dropdown">
								<button class="btn btn-default btn-lg dropdown-toggle" data-toggle="dropdown" type="button" aria-expanded="false">
									<span id="cortes-app-tipo-corte-text" data-type="none">Seleccione un tipo</span> <i class="dropdown-caret"></i>
								</button>
								<ul class="dropdown-menu dropdown-menu-lg" id="cortes-app-tipo-corte-ul">
									<li><a href="javascript:void(0);" id="cortes-app-tipo-corte-xinicial-btn" data-type="0" class="text-2x cortes-app-tipo-corte">Corte X Inicial</a></li>
									<li><a href="javascript:void(0);" id="cortes-app-tipo-corte-xparcial-btn" data-type="1" class="text-2x cortes-app-tipo-corte">Corte X Parcial</a></li>
									<li><a href="javascript:void(0);" id="cortes-app-tipo-corte-zdiario-btn" data-type="2" class="text-2x cortes-app-tipo-corte">Corte Z Diario</a></li>
									<li><a href="javascript:void(0);" id="cortes-app-tipo-corte-zmensual-btn" data-type="3" class="text-2x cortes-app-tipo-corte">Corte Z Mensual</a></li>
								</ul>
							</div>
							<div class="checkbox">
								<input id="corte-email" class="magic-checkbox" type="checkbox" disabled>
								<label for="corte-email" class="control-label">Enviar Email</label>
							</div>
						</div>
					</div>
					<!--Resolucion-->
					<input type="hidden" id="cortes-app-resolucion">
					<input type="hidden" id="cortes-app-dotacion">
					<!--Generar-->
					<div class="col-sm-4">
						<button class="btn btn-success pad-hor btn-lg" id="cortes-app-generar-corte-btn" type="button">Generar</button>						
					</div>
				</div>
			</div>
			<div class="col-sm-12 pad-all bord-all mar-top" id="cortes-app-corte-wrapper" style="height:475px;">
				
			</div>
		</div>
	</div>
	<div class="row text-center">
		<button type="button" id="" onclick="Custombox.close();" class="btn btn-lg btn-danger btn-labeled fa fa-window-close">Salir</button>
		<button type="button" id="cortes-app-exportar-imprimir" class="btn btn-primary btn-lg btn-labeled fa fa-file-pdf-o" disabled>Exportar/Imprimir</button>
		<button type="button" id="cortes-app-exportar-cinta" class="btn btn-info btn-lg btn-labeled fa fa-shopping-cart" disabled>Cinta</button>
	</div>
	<!--Modales-->
	<div id="cortes-app-modales-wrapper">
		<!--Detalles del corte-->
		<div class="modal fade" id="cortes-app-generar-opciones-<?php echo $winid;?>" tabindex="-1" role="dialog"  aria-hidden="true">
			<div class="modal-dialog modal-md">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="">Generador de cortes</h4>
					</div>
					<div class="modal-body">
						<div id="cortes-app-generar-opciones-loading"class="text-center">
							<i class="fa fa-spinner fa-3x"></i>
							<span id="cortes-app-generar-opciones-loading-status" style="display:block" >Inicializando...</span>
						</div>
						<div id="cortes-app-generar-opciones-wrapper" style="display:none;">
							<!--Mensaje-->
							<div id="cortes-app-generar-opciones-msg" class="alert alert-warning" style="display:none;">
							</div>
							<!--Dotacion-->
							<div id="cortes-app-generar-opciones-dotacion" class="form-group" style="display:none;">
								<label class="control-label text-2x">Dotacion:</label>
								<input type="text" class="form-control input-lg key-num" id="cortes-app-generar-dotacion-text" value="">
							</div>
							<!--Serie de tickets-->
							<div id="cortes-app-generar-opciones-serie" class="form-group" style="display:none;">
								<label class="control-label">Serie de Tickets:</label>
								<select class="form-control" id="cortes-app-generar-tickets-serie">
								</select>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" id="cortes-app-generar-cancelar-btn" class="btn btn-white btn-lg" data-dismiss="modal" style="display:none">Cancelar</button>
						<button type="button" id="cortes-app-generar-continuar-btn" class="btn btn-primary btn-lg" style="display:none">Continuar</button>
					</div>
				</div>
			</div>
		</div>
		<!--Detalles del exportar imprimir-->
		<div class="modal inmodal fade" id="cortes-app-exportar-opciones-<?php echo $winid;?>" tabindex="-1" role="dialog"  aria-hidden="true">
			<div class="modal-dialog modal-md">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="">Opciones de cortes</h4>
					</div>
					<div class="modal-body">
						<label class="control-label text-2x">Incluir</label>
						<div class="checkbox">
							<input id="corte-fiscal" class="magic-checkbox" type="checkbox" checked>
							<label for="corte-fiscal" class="control-label text-2x">Corte Fiscal</label>
						</div>
						<label class="control-label text-2x">Acci&oacute;n:</label>
						<select class="form-control input-lg" id="cortes-app-exportar-opcion">
							<option value="0" selected>Imprimir</option>
							<option value="1">Exportar</option>
						</select>
					</div>
					<div class="modal-footer">
						<button type="button" id="cortes-app-exportar-cancelar-btn" class="btn btn-white btn-lg" data-dismiss="modal">Cancelar</button>
						<button type="button" id="cortes-app-exportar-continuar-btn" class="btn btn-primary btn-lg">Continuar</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function () {
		var caja_cortes=new Caja_cortes();
		caja_cortes.initializeEnviroment("<?php echo base_url();?>","<?php echo $winid;?>","<?php echo $caja->id_caja;?>");
		caja_cortes.loadOptions("<?php echo $caja->estado_caja;?>","<?php echo $cortes;?>");
		ChinaInTools.initializeKeyboard("<?php echo $winid;?>");
    });
</script>