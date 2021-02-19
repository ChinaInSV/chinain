<div id="<?php $windowid=date('YmdHis'); echo $windowid;?>">
	<div class="row">
		<div class="panel">
			<div class="panel-body bg-gray-light ">
				<div class="row">
					<div class="text-center mar-btm">
						<h4 id="detalles-plato-nombre"><?php echo $plato->plato_nombre;?></h4>
						<input type="hidden" id="detalles-plato-id" value="<?php echo $plato->id_platoxorden;?>"/>
					</div>
					<label class="control-label text-semibold text-lg">Cantidad</label>
					<div class="input-group mar-btm">
						<span class="input-group-btn">
							<button class="btn btn-danger btn-lg detalles-plato-disminuir-btn" type="button"><i class="fa fa-minus"></i></button>
						</span>
						<input type="text" placeholder="Cantidad" id="detalles-plato-cantidad" class="form-control input-lg detalles-plato-texts" value="<?php echo $plato->cantidad_plato;?>" step="1" min="1">
						<span class="input-group-btn">
							<button class="btn btn-info btn-lg detalles-plato-aumentar-btn" type="button"><i class="fa fa-plus"></i></button>
						</span>
					</div>
					<label class="control-label text-semibold text-lg">Precio</label>
					<div class="input-group mar-btm">
						<span class="input-group-btn">
							<button class="btn btn-danger btn-lg detalles-plato-disminuir-btn" type="button"><i class="fa fa-minus"></i></button>
						</span>
						<input type="text" placeholder="Costo" id="detalles-plato-costo" class="form-control input-lg detalles-plato-texts" value="<?php echo $plato->precio_plato;?>" step="5" min="1">
						<span class="input-group-btn">
							<button class="btn btn-info btn-lg detalles-plato-aumentar-btn" type="button"><i class="fa fa-plus"></i></button>
						</span>
					</div>
				</div>
			</div>
			<div class="row text-center mar-top">
				<button type="button" id="detalles-plato-actualizar-btn" class="btn btn-lg btn-success btn-labeled fa fa-save">Actualizar</button>
				<button type="button" id="detalles-plato-salir-btn" class="btn btn-lg btn-danger btn-labeled fa fa-window-close">Salir</button>
			</div>
		</div>
	</div>
</div>
<script>	
	$(document).ready(function () {
		var home_ordenes_detalles_modificar=new Home_ordenes_detalles_modificar();
		home_ordenes_detalles_modificar.initializeEnviroment("<?php echo base_url();?>","<?php echo $windowid;?>");
    });
</script>