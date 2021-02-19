<div id="<?php $windowid=date('YmdHis'); echo $windowid;?>">
	<div class="row">
		<div class="panel">
		<h4><?php echo $plato->plato_nombre;?></h4>
			<div class="panel-body bg-gray-light ">
				<div class="row">
					<!--Agregado-->
					<p>
						<span class="text-main text-semibold">Agregado:</span><br>						
						<span class="text-main"><?php echo date("d-m-Y h:i:s a",strtotime($plato->fecha_agregado));?> por <?php echo ($plato->mesero?$plato->mesero:"(Desconocido)");?></span>			
					</p>
					<!--Destino-->
					<p>
						<span class="text-main text-semibold">Destino:</span><br>						
						<span class="text-main"><?php echo $plato->salon;?> - <?php echo $plato->mesa;?></span>								
					</p>
					<!--Despacho-->
					<?php if($plato->despachado):?>
					<p>
						<span class="text-main text-semibold">Despacho:</span><br>						
						<span class="text-main"><?php echo ($plato->fecha_despachado?date("d-m-Y h:i:s a",strtotime($plato->fecha_despachado)):"(Desconocido)");?> por <?php echo ($plato->despachador_nombre?$plato->despachador_nombre:"(Desconocido)");?></span>								
					</p>
					<?php endif;?>
					<!--Eliminado-->
					<?php if($plato->eliminado):?>
					<p>
						<span class="text-main text-semibold">Eliminado:</span><br>						
						<span class="text-main"><?php echo ($plato->fecha_eliminado?date("d-m-Y h:i:s a",strtotime($plato->fecha_eliminado)):"(Desconocido)");?> por <?php echo ($plato->eliminador_nombre?$plato->eliminador_nombre:"(Desconocido)");?></span>								
					</p>
					<p>
						<span class="text-main text-semibold">Razon:</span><br>						
						<span class="text-main"><?php echo $plato->razon_eliminado;?></span>								
					</p>
					<?php endif;?>
					<!--Notas-->
					<p>
						<span class="text-main text-semibold">Notas:</span><br>						
						<span class="text-main"><?php echo $plato->notas;?></span>								
					</p>
				</div>
			</div>
		</div>
	</div>
</div>