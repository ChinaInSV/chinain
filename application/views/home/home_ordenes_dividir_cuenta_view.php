<div class="row mar-all" id="<?php $winid=date('YmdHis'); echo $winid;$this->load->library("App_utilities");$PadillaApp = new App_utilities();?>">
	<div class="row mar-top">
		<input type="hidden" id="dividir-cuenta-orden-id" value="<?php echo $orden->id;?>">
		<input type="hidden" id="dividir-cuenta-plato-platoxorden" value="">
		<input type="hidden" id="dividir-cuenta-plato-id" value="">
		<input type="hidden" id="dividir-cuenta-plato-cant" value="">
		<input type="hidden" id="dividir-cuenta-plato-precio" value="">
		<input type="hidden" id="dividir-cuenta-plato-desc" value="">
		<div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
			<h5 class="text-main text-bold" style="margin:5px auto;">No. Orden: <span class="text-normal"><?php echo $orden->num_orden;?></span> <small>(ID: <?php echo $orden->id;?>)</small></h5>								
		</div>
		<div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
			<h5 class="text-main text-bold" style="margin:5px auto;">Fecha: <span class="text-normal"><?php echo date("d-m-Y h:i a",strtotime($orden->fecha));?></span></h5>								
		</div>
		<div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
			<h5 class="text-main text-bold" style="margin:5px auto;">Cliente: <span class="text-normal"><?php echo $orden->cliente;?></span></h5>								
		</div>
		<div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
			<h5 class="text-main text-bold" style="margin:5px auto;">Destino: <span class="text-normal"><?php echo $orden->salon." - ".$orden->mesa;?></span></h5>								
		</div>
		<div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
			<h5 class="text-main text-bold" style="margin:5px auto;">Mesero: <span class="text-normal"><?php echo $orden->mesero;?></span></h5>
		</div>
		<div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
			<h5 class="text-main text-bold" style="margin:5px auto;">Servicio: <span class="text-normal"><?php echo $orden->servicio;?></span></h5>
		</div>
	</div>
    <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
        <!--Tabla wrapper-->
        <div class="row bord-all">
            <!--Encabezado de tabla-->
            <table class="table table-hover table-vcenter" style="margin-bottom:0px;">
                <thead>
                    <tr>
                        <th></th>
                        <th class="text-center">Cantidad</th>
                        <th class="text-center">Descripcion</th>
                        <th class="text-center">Precio</th>
                        <th class="text-center">Total</th>
                        <th></th>
                    </tr>
                </thead>
            </table>
            <!--Tabla de productos-->
            <div style="overflow-y:scroll;height:200px;" class="table-reponsive">
                <table class="table table-hover table-vcenter">
                    <tbody>
                        <?php if(count($platos)):foreach($platos as $plato):?>
                        <tr style="<?php echo ($plato->eliminado)?"text-decoration:line-through;":"";?>" class="dividir-orden-item-actual" id="item-actual-<?php echo $plato->platoxorden;?>" data-cant="<?php echo number_format($plato->cant,$config->cant_decimal_precision->value)?>" data-precio="<?php echo number_format($plato->precio,$config->precios_decimal_precision->value)?>">
                            <td class="text-center"><i class="fa fa-circle fa-1x text-<?php echo ($plato->eliminado)?"danger":"success";?>"></i></td>
                            <td class="text-center"><span class="text-main text-semibold plato-cant-field"><?php echo number_format($plato->cant,$config->cant_decimal_precision->value)?></span></td>
                            <td>
                                <span class="text-main text-semibold"><?php echo $plato->nombre?></span>
                                <?php $length=count($plato->acompanamientos);if($length):$i=0;?>
                                    <span class="text-main"> -
                                    <?php foreach($plato->acompanamientos as $acompanamiento):
                                    $i+=1;
                                    echo $acompanamiento->categoria.": ".$acompanamiento->acompanamiento;
                                    if($i<$length){
                                        echo ", ";
                                    }
                                    endforeach;?>
                                    </span>
                                <?php endif;?>
                                <br>
                                <small class="text-muted"><?php echo $plato->notas?></small>
                            </td>
                            <td class="text-right"><span class="text-main plato-precio-field"><?php echo number_format($plato->precio,$config->precios_decimal_precision->value);?></span></td>
                            <td class="text-right"><span class="text-main plato-total-field"><?php echo number_format($plato->cant*$plato->precio,$config->precios_decimal_precision->value);?></span></td>
                            <td class="text-center">
                                <button <?php echo ($plato->eliminado)?"disabled":"";?> class="btn btn-info btn-icon btn-circle dividir-cuenta-plato-btn" data-platoxorden="<?php echo $plato->platoxorden;?>" data-id="<?php echo $plato->id;?>" data-nombre="<?php echo $plato->nombre;?>" data-cant="<?php echo number_format($plato->cant,$config->cant_decimal_precision->value)?>" data-precio="<?php echo number_format($plato->precio,$config->precios_decimal_precision->value)?>"><i class="fa fa-arrows-h"></i></button>
                            </td>
                        </tr>
                        <?php endforeach;endif;?>
                    </tbody>
                </table>
            </div>
            <!---->
        </div>
        <div class="row">
            <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12 mar-top">
                
            </div>
            <!--Totales-->
            <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12 mar-top bg-gray-light">
                <!--Sumas-->
                <h5 class="text-normal col-xs-5 mar-no" style="line-height:20px;">Sumas</h5>
                <h5 class="text-normal col-xs-1 mar-no" style="line-height:20px;">$</h5>
                <h5 class="text-normal text-right col-xs-5 mar-no" style="line-height:20px;"><?php echo ($orden->subtotal?number_format($orden->subtotal,$config->totales_decimal_precision->value):'N/A');?></h5>
                <!--Propina-->
                <h5 class="text-normal col-xs-5 mar-no" style="line-height:20px;">Propina</h5>
                <h5 class="text-normal col-xs-1 mar-no" style="line-height:20px;">$</h5>
                <h5 class="text-normal text-right col-xs-5 mar-no" style="line-height:20px;"><?php echo ($orden->propina?number_format($orden->propina,$config->totales_decimal_precision->value):'N/A');?></h5>
                <!--Descuento-->
                <h5 class="text-normal col-xs-5 mar-no" style="line-height:20px;">Descuento</h5>
                <h5 class="text-normal col-xs-1 mar-no" style="line-height:20px;">$</h5>
                <h5 class="text-normal text-right col-xs-5 mar-no" style="line-height:20px;"><?php echo ($orden->descuento?number_format($orden->descuento,$config->totales_decimal_precision->value):'N/A');?></h5>
                
                <h4 class="text-bold col-xs-5 mar-no" style="line-height:20px;">Total</h4>
                <h4 class="text-bold col-xs-1 mar-no" style="line-height:20px;">$</h4>
                <h4 class="text-bold text-right col-xs-5 mar-no" style="line-height:20px;"><?php echo ($orden->subtotal?number_format($orden->subtotal+$orden->propina-$orden->descuento,$config->totales_decimal_precision->value):'N/A');?></h4>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
        <!--Tabla wrapper-->
        <div class="row bord-all">
            <!--Encabezado de tabla-->
            <table class="table table-hover table-vcenter" style="margin-bottom:0px;">
                <thead>
                    <tr>
                        <th></th>
                        <th class="text-center">Cantidad</th>
                        <th class="text-center">Descripcion</th>
                        <th class="text-center">Precio</th>
                        <th class="text-center">Total</th>
                        <th></th>
                    </tr>
                </thead>
            </table>
            <!--Tabla de productos-->
            <div style="overflow-y:scroll;height:200px;" class="table-reponsive">
                <table class="table table-hover table-vcenter">
                    <tbody>
                        
                    </tbody>
                </table>
            </div>
            <!---->
        </div>
        <div class="row">
            <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12 mar-top">
                
            </div>
            <!--Totales-->
            <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12 mar-top bg-gray-light">
                <!--Sumas-->
                <h5 class="text-normal col-xs-5 mar-no" style="line-height:20px;">Sumas</h5>
                <h5 class="text-normal col-xs-1 mar-no" style="line-height:20px;">$</h5>
                <h5 class="text-normal text-right col-xs-5 mar-no" style="line-height:20px;">0.00</h5>
                <!--Propina-->
                <h5 class="text-normal col-xs-5 mar-no" style="line-height:20px;">Propina</h5>
                <h5 class="text-normal col-xs-1 mar-no" style="line-height:20px;">$</h5>
                <h5 class="text-normal text-right col-xs-5 mar-no" style="line-height:20px;">0.00</h5>
                <!--Descuento-->
                <h5 class="text-normal col-xs-5 mar-no" style="line-height:20px;">Descuento</h5>
                <h5 class="text-normal col-xs-1 mar-no" style="line-height:20px;">$</h5>
                <h5 class="text-normal text-right col-xs-5 mar-no" style="line-height:20px;">0.00</h5>
                
                <h4 class="text-bold col-xs-5 mar-no" style="line-height:20px;">Total</h4>
                <h4 class="text-bold col-xs-1 mar-no" style="line-height:20px;">$</h4>
                <h4 class="text-bold text-right col-xs-5 mar-no" style="line-height:20px;">0.00</h4>
            </div>
        </div>                        
    </div>
    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 mar-top bord-top pad-top text-center">
        <button type="button" id="dividir-cuenta-actualizar-btn" class="btn btn-lg btn-success btn-labeled fa fa-save">Actualizar</button>
        <button type="button" id="dividir-cuenta-salir-btn" class="btn btn-lg btn-danger btn-labeled fa fa-window-close">Salir</button>
    </div>
    <!--MODALES-->
    <div id="dividir-cuenta-modals-wrapper">
        <!--Precios Modal-->
        <div style="z-index:300000;" class="modal" id="dividir-cuenta-modificar-precios-<?php echo $winid;?>" data-parent="#<?php echo $winid;?>" role="dialog" tabindex="-1" aria-labelledby="demo-default-modal" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><i class="fa fa-times"></i></button>
                        <h4 class="modal-title">Cantidad y precio de <b></b></h4>
                    </div>
                    <div class="modal-body">
                        <div class="text-center mar-btm">
                            <h4 id="dividir-cuenta-cantidades-servicio"></h4>
                            <input type="hidden" id="dividir-cuenta-cantidades-servicio-id" value=""/>
                        </div>
                        <label class="control-label text-semibold text-lg">Cantidad</label>
                        <div class="input-group mar-btm">
                            <span class="input-group-btn">
                                <button class="btn btn-danger btn-lg dividir-cuenta-cantidades-disminuir-btn" type="button"><i class="fa fa-minus"></i></button>
                            </span>
                            <input type="text" placeholder="Cantidad" id="dividir-cuenta-cantidades-cantidad" class="form-control input-lg dividir-cuenta-cantidades-texts" value="1" step="1" min="1">
                            <span class="input-group-btn">
                                <button class="btn btn-info btn-lg dividir-cuenta-cantidades-aumentar-btn" type="button"><i class="fa fa-plus"></i></button>
                            </span>
                        </div>
                        <label class="control-label text-semibold text-lg">Precio</label>
                        <div class="input-group mar-btm">
                            <span class="input-group-btn">
                                <button class="btn btn-danger btn-lg dividir-cuenta-cantidades-disminuir-btn" type="button"><i class="fa fa-minus"></i></button>
                            </span>
                            <input type="text" placeholder="Costo" id="dividir-cuenta-cantidades-costo" class="form-control input-lg dividir-cuenta-cantidades-texts" value="1" step="5" min="1">
                            <span class="input-group-btn">
                                <button class="btn btn-info btn-lg dividir-cuenta-cantidades-aumentar-btn" type="button"><i class="fa fa-plus"></i></button>
                            </span>
                        </div>
                    </div>
                    <div class="modal-footer" id="dividir-cuenta-cantidades-buttons">
                        <button type="button" id="dividir-cuenta-cantidades-cancelar-btn" class="btn btn-warning btn-lg" data-dismiss="modal">Cancelar</button>
                        <button type="button" id="dividir-cuenta-cantidades-agregar-btn" class="btn btn-info btn-lg hidden">Agregar plato</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>	
	$(document).ready(function () {
		var home_ordenes_dividir_cuenta=new Home_ordenes_dividir_cuenta();
		home_ordenes_dividir_cuenta.initializeEnviroment("<?php echo base_url();?>","<?php echo $winid;?>",{
			menu_mode:<?php echo $config->menu_mode->value;?>,
			cant_decimal_precision:<?php echo $config->cant_decimal_precision->value;?>,
			precios_decimal_precision: <?php echo $config->precios_decimal_precision->value;?>,
			totales_decimal_precision: <?php echo $config->totales_decimal_precision->value;?>,
			propina_aplicar: <?php echo $config->propina_aplicar->value;?>,
			propina_porcentaje_aplicable: <?php echo $config->propina_porcentaje_aplicable->value;?>,
			modificar_precios: <?php echo $config->modificar_precios->value;?>,
			modificar_precios_add: <?php echo $config->modificar_precios_add->value;?>,
		});
    });
</script>