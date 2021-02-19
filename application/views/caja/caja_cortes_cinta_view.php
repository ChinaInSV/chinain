<div class="row" id="<?php $winid=date('YmdHis'); echo $winid;?>">
	<div class="panel">
		<!--Panel body-->
		<div class="panel-body">
			<div class="col-sm-12">
				<div class="form-group text-center">
					<label class="col-sm-3 control-label text-right text-semibold" for="" style="margin-top:8px;">Rollo</label>
					<div class="col-sm-5">
						<select id="cinta-app-rollo" class="form-control">
							<?php $num_rollo=1;$item=1;for($i=1;$i<=$items;$i++):?>
							<?php if($item>=$max_item):?>
							<option value="<?php echo $num_rollo;?>">Imprimir rollo <?php echo $num_rollo;?></option>
							<?php $item=1;$num_rollo++;else:$item++;?>
							<?php endif;endfor;?>
							<?php if($item>1):?>
							<option value="<?php echo $num_rollo;?>">Imprimir rollo <?php echo $num_rollo;?></option>
							<?php endif;?>
						</select>
					</div>
					<!--Resolucion-->
					<input type="hidden" id="cinta-app-id" value="<?php echo $cinta;?>">
					<!--Generar-->
					<div class="col-sm-4">
						<button class="btn btn-success pad-hor" id="cinta-app-generar-rollo-btn" type="button">Generar</button>						
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row text-center">
		<button type="button" id="" onclick="Custombox.close();" class="btn btn-lg btn-danger btn-labeled fa fa-window-close">Salir</button>
	</div>
</div>
<script>
	$("#cinta-app-generar-rollo-btn").on("click",function(){
		$.get("<?php echo base_url("caja/printcinta");?>",{id:$("#cinta-app-id").val(),rollo:$("#cinta-app-rollo").val()},function(e){
			toastr.options = {
			  "closeButton": true,
			  "progressBar": true,
			  "positionClass": "toast-top-right"
			}
			toastr.info('Se ha enviado la orden');
			
		},"text");
	});
</script>