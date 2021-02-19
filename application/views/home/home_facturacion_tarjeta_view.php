<div class="row" id="<?php $winid=date('YmdHis'); echo $winid;?>">
	<div class="panel">
		<!--Panel body-->
		<div class="panel-body">
			<div class="row">
				<div class="col-sm-12">
					<div class="form-group">
						<label class="control-label text-lg">Codigo de la Tarjeta</label> <span class="required-mark">*</span>
						<input type="text" class="form-control input-lg">
					</div>
				</div>
				<div class="col-sm-12">
					<div class="form-group">
						<label class="control-label text-lg">Confirme Codigo</label> <span class="required-mark">*</span>
						<input type="text" class="form-control input-lg">
					</div>
				</div>
				<div class="col-sm-12" id="nueva-cita-alert-wrapper">
					<div class="alert alert-info">
						<span class="text-semibold" id="nueva-cita-citasdefault">Ingrese una fecha para comprobar si existen citas para esta</span>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row text-center">
		<button type="button" id="" onclick="" class="btn btn-lg btn-success btn-labeled fa fa-save">Guardar</button>
		<button type="button" id="" onclick="Custombox.close();" class="btn btn-lg btn-danger btn-labeled fa fa-window-close">Salir</button>
	</div>
</div>