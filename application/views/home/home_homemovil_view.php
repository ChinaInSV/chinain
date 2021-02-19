<div class="row" id="<?php $winid=date('YmdHis'); echo $winid;?>" style="background:#E9EAEE">
	<div class="pad-all">
		<!--ORDEN CONTENIDO-->
		<div id="nueva-orden-contenido-wrapper" style="">
			<div class="row">
				<div class="col-md-12 col-sm-12 col-lg-12 col-xs-12">
					<div class="panel">
						<div class="panel-body">
							<!--Modo de vista y seleccion del menu-->
							<div class="row bord-btm pad-btm" style="visibility:hidden;position:absolute;">
								<!--Modo de vista del menu-->
								<div class="col-md-5 col-lg-5 col-sm-6 col-xs-6 text-left bord-rgt" id="nueva-orden-menu-mode-view-wrapper">
									<button type="button" class="btn btn-lg btn-active-success btn-labeled fa fa-list <?php if($config->menu_mode->value==0):?>active<?php endif;?>" data-mode="lista"  id="nueva-orden-menu-mode-view-lista">Lista</button>
									<button type="button" class="btn btn-lg btn-active-success btn-labeled fa fa-th-large <?php if($config->menu_mode->value==1):?>active<?php endif;?>" data-mode="menu"  id="nueva-orden-menu-mode-view-menu">Menu</button>
								</div>
								<!--Menus-->
								<div class="col-md-7 col-lg-7 col-sm-6 col-xs-6 text-left nueva-orden-togglesbtn nueva-orden-changemenu" id="nueva-orden-menus-wrapper">
									<?php 
										if(count($menus)):
											$count_menu=0;
											$id_sel_menu=null;
											foreach($menus as $menu):
									?>
									<button type="button" class="btn btn-menu btn-lg btn-active-success <?php if($count_menu==0): $id_sel_menu=$menu->id;?>active<?php endif;?>"  data-id="<?php echo $menu->id;?>" ><?php echo $menu->nombre;?></button>
									<?php 
											$count_menu+=1;
											endforeach;
										endif;
									?>
								</div>
							</div>
							<!--Menu o lista de platos-->
							<div class="row">
								<div id="nueva-orden-menu-wrapper" class="mar-top" style="height:450px;">
									<!--------------------MODO LISTA---------------------->
									<div class="row" id="nueva-orden-modo-lista-wrapper" <?php if($config->menu_mode->value!=0):?>style="display:none;"<?php endif;?>>
										<!--Buscar y agregar producto-->
										<div class="form-group">
											<!--Producto txt-->
											<div class="col-sm-8">
												<div class="input-group">
													<input type="text" class="form-control" id="nueva-orden-lista-plato-txt" placeholder="Producto">
													<span class="input-group-btn">
														<button class="btn btn-danger" id="nueva-orden-lista-plato-clear"><i class="fa fa-times"></i></button>
													</span>
												</div>
											</div>
											<!--Producto cant-->
											<div class="col-sm-2">
												<input type="number" id="nueva-orden-lista-plato-cant-txt" class="form-control" placeholder="Cantidad" value="1">
											</div>
											<div class="col-sm-2">
												<button class="btn btn-info" id="nueva-orden-lista-agregar-btn">Agregar</button>
											</div>
											<div class="clearfix"></div>
										</div>
										<!--Tabla de platos-->
										<div id="nueva-orden-lista-platos-wrapper" style="overflow-y:auto;height:324px">
											<table class="table">
												<tbody>
													<?php 
														 if(count($menus)):
															foreach($menus as $plmenu):
																if(count($plmenu->categorias)):
																	foreach($plmenu->categorias as $plcategoria):
																		if(count($plcategoria->platos)):
																			foreach($plcategoria->platos as $platol):
													?>
													<tr data-id="<?php echo $platol->id;?>" data-categoria="<?php echo $plcategoria->id;?>" data-nombre="<?php echo $platol->nombre;?>" data-acompanamientos='<?php if(count($platol->acompanamientos)):echo json_encode($platol->acompanamientos);endif;?>' data-notas='<?php echo json_encode($platol->notas);?>' data-precio='<?php echo number_format($platol->precio,$config->precios_decimal_precision->value);?>'>
														<td width="60%"><?php echo $platol->nombre;?></td>
														<td width="40%"><?php echo $plmenu->nombre;?> -<?php echo $plcategoria->nombre;?></td>
													</tr>
													<?php 
																			endforeach;
																		endif;
																	endforeach;
																endif;
															endforeach;
														endif;
													?>
												</tbody>
											</table>
										</div>
									</div>
									<!--------------------/MODO LISTA--------------------->
									<!--------------------MODO MENU---------------------->
									<div class="row" id="nueva-orden-modo-menu-wrapper" <?php if($config->menu_mode->value!=1):?>style="display:none;"<?php endif;?>>
										<!--Categorias del menu-->
										<div class="col-sm-12 bord-all bg-gray-light">
											<div class="mar-ver nueva-orden-togglesbtn " id="nueva-orden-categorias-wrapper" style="overflow-y:auto;height:100%;">
												<?php 
													if(count($menus)):
														foreach($menus as $cmenu):
															if(count($cmenu->categorias)):
																foreach($cmenu->categorias as $categoria):
												?>												
												<button type="button"  style="white-space:normal;height:64px;" data-toggle="button" class="btn-cat-menu btn btn-block btn-lg btn-primary btn-active-mint mar-btm" <?php if($cmenu->id!=$id_sel_menu):?>style="display:none;"<?php endif;?> data-menu="<?php echo $cmenu->id;?>" data-id="<?php echo $categoria->id;?>"><?php echo $categoria->nombre;?></button>
												<?php  
																endforeach;
															endif;
														endforeach;
													endif;
												?>
											</div>
										</div>
										<!--Platos de la categoria-->
										<div class="col-sm-12">
											<!--Selector de cantidad de platos-->
											<div class="form-group pad-btm bord-btm" style="visibility:hidden;position:absolute;">
												<label class="control-label pad-top col-sm-4">Cantidad de Platos:</label>
												<div class="col-sm-4">
													<div class="input-group">
														<span class="input-group-btn">
															<button class="btn btn-danger btn-lg btn-platos-cant-selector" type="button" data-function="less"><i class="fa fa-minus"></i></button>
														</span>
														<input  type="text" class="form-control input-lg key-num" value="1" placeholder="Cantidad" id="norden-menu-cant-platos" onkeypress="">
														<span class="input-group-btn">
															<button class="btn btn-mint btn-lg btn-platos-cant-selector" type="button" data-function="add"><i class="fa fa-plus"></i></button>
														</span>
													</div>
												</div>
												<div class="clearfix"></div>
											</div>
											<!--Contenedor de platos-->
											<div class="row">
												<div class="mar-ver" id="nueva-orden-platos-wrapper" style="overflow-y:auto;min-height:478px;display:block;">
													<!--Mensaje de seleccion de categoria-->
													<div class="well well-sm mar-all bg-gray-light" id="nueva-orden-selcat-msg-wrapper">
														<div class="row">
															<div class="col-xs-3 text-right">
																<i class="fa fa-arrow-left fa-5x"></i>
															</div>
															<div class="col-xs-9">
																<h4>Seleccione una categoria</h4>
																<span>Haga clic sobre una categoria para mostrar los platos que contiene.</span>
															</div>
														</div>
													</div>
													<?php 
														$colPlatos=array();
														 if(count($menus)):
															foreach($menus as $pmenu):
																if(count($pmenu->categorias)):
																	foreach($pmenu->categorias as $pcategoria):
																		if(count($pcategoria->platos)):
																			$divCol=0;
																			foreach($pcategoria->platos as $plato):
																				$colPlatos[$pcategoria->id][$divCol][]= $plato;
																				if($divCol<2)
																					$divCol+=1;
																				else
																					$divCol=0;
																			endforeach;
																		else:
													?>
													<div class="well well-sm bg-grey-light text-center mar-all btn-plato" style="display:none;">
														<h4>No hay platos en esta categoria (<?php echo $pcategoria->nombre;?>)</h4><br><span>Para modificar el men&uacute; vaya a: Administraci&oacute;n -> Restaurante -> Men&uacute;</span>
														<button data-categoria="<?php echo $pcategoria->id;?>" style="display:none;"></button>
													</div>
													<?php
																		endif;
																	endforeach;
																endif;
															endforeach;
														endif;
													?>
													<div class="col-sm-4">
														<?php
															if(count($colPlatos)):
																foreach($colPlatos as $platos_categoria):
																	if(isset($platos_categoria[0])):
																		if(count($platos_categoria[0])):
																			foreach($platos_categoria[0] as $cplatos):
														?> 
														<div class="mar-btm btn-plato" style="display:none;">
															<button type="button" class="btn btn-block btn-lg btn-default " style="height:90px;background-color:rgb(211,211,211);color:rgb(48,48,48);white-space:normal;" data-categoria="<?php echo $cplatos->categoria;?>" data-id="<?php echo $cplatos->id;?>" data-acompanamientos='<?php if(count($cplatos->acompanamientos)):echo json_encode($cplatos->acompanamientos);endif;?>' data-notas='<?php echo json_encode($cplatos->notas);?>' data-precio="<?php echo number_format($cplatos->precio,$config->precios_decimal_precision->value);?>"  style="white-space:normal;"><?php echo $cplatos->nombre;?></button>
														</div>
														<?php 
																			endforeach;
																		endif;
																	endif;
																endforeach;
															endif;
														?>
													</div>
													<div class="col-sm-4">
														<?php
															if(count($colPlatos)):
																foreach($colPlatos as $platos_categoria):
																	if(isset($platos_categoria[1])):
																		if(count($platos_categoria[1])):
																			foreach($platos_categoria[1] as $cplatos):
														?> 
														<div class="mar-btm btn-plato" style="display:none;">
															<button type="button" class="btn btn-block btn-lg btn-default " style="height:90px;background-color:rgb(211,211,211);color:rgb(48,48,48);white-space:normal;" data-categoria="<?php echo $cplatos->categoria;?>" data-id="<?php echo $cplatos->id;?>" data-acompanamientos='<?php if(count($cplatos->acompanamientos)):echo json_encode($cplatos->acompanamientos);endif;?>' data-notas='<?php echo json_encode($cplatos->notas);?>' data-precio="<?php echo number_format($cplatos->precio,$config->precios_decimal_precision->value);?>" style="white-space:normal;"><?php echo $cplatos->nombre;?></button>
														</div>
														<?php 
																			endforeach;
																		endif;
																	endif;
																endforeach;
															endif;
														?>
													</div>
													<div class="col-sm-4">
													<?php
															if(count($colPlatos)):
																foreach($colPlatos as $platos_categoria):
																	if(isset($platos_categoria[2])):
																		if(count($platos_categoria[2])):
																			foreach($platos_categoria[2] as $cplatos):
														?> 
														<div class="mar-btm btn-plato" style="display:none;">
															<button type="button" class="btn btn-block btn-lg btn-default " style="height:90px;background-color:rgb(211,211,211);color:rgb(48,48,48);white-space:normal;" data-categoria="<?php echo $cplatos->categoria;?>" data-id="<?php echo $cplatos->id;?>" data-acompanamientos='<?php if(count($cplatos->acompanamientos)):echo json_encode($cplatos->acompanamientos);endif;?>' data-notas='<?php echo json_encode($cplatos->notas);?>' data-precio="<?php echo number_format($cplatos->precio,$config->precios_decimal_precision->value);?>" style="white-space:normal;"><?php echo $cplatos->nombre;?></button>
														</div>
														<?php 
																			endforeach;
																		endif;
																	endif;
																endforeach;
															endif;
														?>
													</div>
												</div>
											</div>
										</div>
									</div>
									<!--------------------/MODO MENU--------------------->
									<!--Valores del plato a agregar-->
									<?php
										$dias = array("domingo","lunes","martes","miercoles","jueves","viernes","sabado");
										$promo=0;
										if($dias[date("w")]=="martes" || $dias[date("w")]=="jueves"):
											$promo=1;
										endif;
									?>						
									<input id="nueva-orden-agregar-plato-promo" type="hidden" value="<?php echo $promo;?>">
									
									<input id="nueva-orden-agregar-plato-id" type="hidden" value="">
									<input id="nueva-orden-agregar-plato-categoria" type="hidden" value="">
									<input id="nueva-orden-agregar-plato-cant" type="hidden" value="">
									<input id="nueva-orden-agregar-plato-nombre" type="hidden" value="">
									<input id="nueva-orden-agregar-plato-precio" type="hidden" value="">
									<input id="nueva-orden-agregar-plato-acompanamientos" type="hidden" value="">
									<input id="nueva-orden-agregar-plato-notas" type="hidden" value="">
									<input id="nueva-orden-agregar-plato-modo" type="hidden" value="">
									<!--Valores de edicion-->
									<input id="nueva-orden-id" type="hidden" value="<?php if(isset($id_orden))echo $id_orden;?>">
									<input id="nueva-orden-numero" type="hidden" value="<?php if(isset($orden->numero))echo $orden->numero;?>">
								<!--/Ajax Load-->
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-12">
					<div class="panel">
						<div class="panel-body">
							<div class="row">
								<!--Herramientas de la orden-->
								<div class="col-md-2 text-center">
									<button class="btn btn-info mar-btm pad-all" id="nueva-orden-herramientas-aumentar" disabled="disabled"><i class="fa fa-plus-circle fa-2x"></i></button>
									<button class="btn btn-warning mar-btm pad-all" id="nueva-orden-herramientas-disminuir" disabled="disabled"><i class="fa fa-minus-circle fa-2x"></i></button>
									<button class="btn btn-success mar-btm pad-all" id="nueva-orden-herramientas-notas" disabled="disabled"><i class="fa fa-pencil fa-2x"></i></button>
									<!--<button class="btn btn-purple mar-btm pad-all" id="nueva-orden-herramientas-division"><i class="fa fa-window-minimize fa-2x"></i></button>-->
									<button class="btn btn-danger mar-btm pad-all" id="nueva-orden-herramientas-eliminar" disabled="disabled"><i class="fa fa-trash fa-2x"></i></button>
								</div>
								<!--Tabla de la orden y cliente-->
								<div class="col-md-10">
									<!--Encabezado tabla-->
									<table class="table table-hover table-vcenter bg-gray" style="margin-bottom:0px;">
										<thead>
											<tr>
												<th class="text-center" width="10%">Cant</th>
												<th class="text-center" width="55%">Producto</th>
												<th class="text-center" width="15%">Precio</th>
												<th class="text-center" width="20%">Total</th>
											</tr>
										</thead>
									</table>
									<!--tabla-->
									<div style="overflow-y:auto;height:335px;" class="bord-all" id="nueva-orden-platos-tabla-wrapper">
										<table class="table table-hover table-vcenter table-striped" id="nueva-orden-platos-tabla">
											<tbody>
											<?php 
												if(isset($platos_orden) && count($platos_orden)):
													foreach($platos_orden as $plato):
											?>
											<tr id="" data-id="<?php echo $plato->id;?>" data-cant="<?php echo number_format($plato->cant,$config->cant_decimal_precision->value);?>" data-nombre="<?php echo $plato->nombre;?>" data-precio="<?php echo number_format($plato->precio,$config->precios_decimal_precision->value);?>"  data-total="<?php echo number_format(($plato->precio*$plato->cant),$config->precios_decimal_precision->value);?>" data-acompanamientos="" data-acompanamientosstr="" data-prenotas="" data-notas="<?php $plato->notas?>" data-enviado="1" data-cantenviados="<?php echo number_format($plato->cant,$config->cant_decimal_precision->value);?>" <?php if($plato->div):?>data-div="true" style="border-bottom: 2px solid rgb(119, 119, 119);"<?php endif;?>>
												<td class="plato-cant-field text-center text-semibold" width="10%"><?php echo number_format($plato->cant,$config->cant_decimal_precision->value);?></td>
												<td class="plato-nombre-field text-left " width="55%"><span class="text-semibold"><?php echo $plato->nombre;?></span></td>
												<td class="plato-precio-field text-left " width="15%"><?php echo number_format($plato->precio,$config->precios_decimal_precision->value);?></td>
												<td class="plato-total-field text-left " width="20%"><?php echo number_format(($plato->precio*$plato->cant),$config->precios_decimal_precision->value);?></td>
												<!--<td><span class="text-semibold label label-success">SI</span></td>-->
											</tr>
											<?php 
													endforeach;
												endif;
											?>
											</tbody>
										</table>
									</div>
									<!--Totales-->
									<div class="row mar-top">
										<div class="col-sm-4"></div>
										<div class="col-sm-8">
											<table class="ufood-transaccion-table">
												<tbody>
													<tr id="nueva-orden-totales-subtotal" class="bord-all bg-gray-light" data-value="0.00">
														<td ><span class="text-semibold text-2x">SUBTOTAL</span></td>
														<td class="text-right"><span class="text-semibold text-2x">$</span></td>
														<td class="text-right total-value"><span class="text-semibold text-2x">0.00</span></td>
													</tr>
													<tr id="nueva-orden-totales-propina" class="bord-all bg-gray-light" data-value="0.00">
														<td ><span class="text-semibold text-2x">PROPINA</span></td>
														<td class="text-right"><span class="text-semibold text-2x">$</span></td>
														<td class="text-right total-value"><span class="text-semibold text-2x">0.00</span></td>
													</tr>
													<tr id="nueva-orden-totales-total" class="bord-all bg-gray-light" data-value="0.00">
														<td ><span class="text-semibold text-2x">TOTAL</span></td>
														<td class="text-right"><span class="text-semibold text-2x">$</span></td>
														<td class="text-right total-value"><span class="text-semibold text-2x">0.00</span></td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>
									<!--botones-->
									<div class="row mar-top bord-top pad-top text-center">
										<button id="nueva-orden-cobrarmovil-btn" class="btn btn-lg btn-info" style="padding:16px 24px">COBRAR</button>
									</div>
									
									<!--Cliente-->
									<!--<div class="form-group">
										<label class="control-label">Cliente</label>
										<input type="text" class="form-control" id="nueva-orden-cliente-nombre" value="<?php if(isset($orden->cliente) && $orden->cliente): echo $orden->cliente; endif;?>">
									</div>-->	
								</div>
							</div>
						</div>
					</div>
					<?php if($promo==1):?>
					<div class="alert alert-danger">
						<button class="close" data-dismiss="alert"><i class="pci-cross pci-circle"></i></button>
						<strong>Promocion Activa!</strong> Segundo Combo a mitad de precio
					</div>
					<?php endif;?>
				</div>
			</div>
		</div>
		<!--MODALES-->
		<div id="nueva-orden-modals-wrapper">
			<!--Acompanamientos modal-->
			<div class="modal fade" id="nueva-orden-acompanamientos-plato-<?php echo $winid;?>" data-parent="#<?php echo $winid;?>" role="dialog" tabindex="-1" aria-hidden="true">
				<div class="modal-dialog modal-lg">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal"><i class="fa fa-times"></i></button>
							<h4 class="modal-title">Acompa&ntilde;amientos y notas de <b></b></h4>
						</div>
						<div class="modal-body bg-gray">
							<div class="row">
								<!--Acompanamientos-->
								<div class="col-sm-6">
									<div class="panel">
										<div class="panel-heading">
											<h3 class="panel-title">Acompa&ntilde;amientos</h3>
										</div>
										<div class="panel-body">
											<div id="nueva-orden-acompanamientos-wrapper" style="height:225px; overflow-y:auto;"></div>
											<div class="clearfix"></div>
										</div>
									</div>
								</div>
								<!--Notas-->
								<div class="col-sm-6">
									<div class="panel">
										<div class="panel-heading">
											<h3 class="panel-title">Notas</h3>
										</div>
										<div class="panel-body">
											<div class="form-control" id="nueva-orden-notas-txt" rows="3" contenteditable="true" style="height:60px;overflow-y:scroll;">
											</div>
											<div class="mar-top" id="nueva-orden-acompanamientos-notas-wrapper" style="height:150px;overflow-y:auto;">
												<div class="col-sm-6" id="nueva-orden-notas-wrapper-1"></div>
												<div class="col-sm-6" id="nueva-orden-notas-wrapper-2"></div>
											</div>
										</div>
									</div>
								</div>
								<div class="clearfix"></div>
							</div>
							<div class="row text-center mar-top">
								<button type="button" class="btn btn-lg btn-info" id="nueva-orden-acompanamientos-notas-continuar-btn">Continuar</button>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!--Confirmar Modal-->
			<div class="modal fade" id="nueva-orden-confirmar-guardar-<?php echo $winid;?>" data-parent="#<?php echo $winid;?>" data-backdrop="static" data-keyboard="false" role="dialog" tabindex="-1" aria-hidden="true">
				<div class="modal-dialog modal-sm">
					<div class="modal-content">
						<div class="modal-header">
							<h4 class="modal-title">Confirmar</h4>
						</div>
						<div class="modal-body">
							<div class="text-center text-info" id="nueva-orden-guardar-state-icon-wrapper" style="font-size:90px;">
								<i class="fa fa-question-circle-o"></i>
							</div>
							<div class="text-center" id="nueva-orden-guardar-state-text-wrapper">
								<h5 class="">&iquest;Desea guardar y enviar esta orden a cocina?</h5>
							</div>
							<div class="text-center" id="nueva-orden-guardar-state-buttons-wrapper">
								<button class="btn btn-lg btn-success pad-all" id="nueva-orden-button-guardar">Si Guardar</button>
								<button class="btn btn-lg btn-success pad-all" id="nueva-orden-button-reintentar">Reintentar</button>
								<button class="btn btn-lg btn-info pad-all" id="nueva-orden-button-nuevaorden">Nueva orden</button>
								
								<button class="btn btn-lg btn-danger mar-top mar-btm"  id="nueva-orden-button-cancelar">Cancelar</button>
								<button class="btn btn-lg btn-danger mar-top mar-btm"  id="nueva-orden-button-salir">Salir</button>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!--Procesar pago-->
			<div class="modal fade" data-keyboard="false" data-backdrop="static" id="facturacion-app-procesar-venta-<?php echo $winid;?>" data-parent="#<?php echo $winid;?>" role="dialog" tabindex="-1" aria-hidden="true">
				<div class="modal-dialog modal-md">
					<div class="modal-content">
						<div class="modal-header">
							<h4 class="modal-title">Venta</h4>
						</div>
						<div class="modal-body bg-gray">
							<div class="text-center mar-btm">
								<i id="facturacion-app-procesar-venta-icon" class="fa fa-spinner fa-5x"></i></br>
								<span id="facturacion-app-procesar-venta-text" class="text-2x">Procesando venta...</span>
							</div>
							<!--Subtotal-->
							<div id="facturacion-app-venta-cobro-total-wrapper" class="row bord-btm">
								<span class="col-sm-5 text-right text-main text-2x" id="facturacion-app-venta-cobro-total-text">Subtotal</span>
								<div class="col-sm-1 text-right">
									<p class="text-main text-2x">$</p>
								</div>
								<div class="col-sm-4 text-right">
									<p id="facturacion-app-venta-cobro-total" class="text-main text-2x"></p>
								</div>
							</div>
							<!--Descuento-->
							<div id="facturacion-app-venta-cobro-descuento-wrapper"  class="row bord-btm">
								<span class="col-sm-5 text-right text-2x text-mint" id="facturacion-app-venta-cobro-descuento-text">Descuento</span>
								<div class="col-sm-1 text-right">
									<p class="text-main text-2x">$</p>
								</div>
								<div class="col-sm-4 text-right">
									<p id="facturacion-app-venta-cobro-descuento" class="text-2x text-mint"></p>
								</div>
							</div>
							<!--Propina-->
							<div id="facturacion-app-venta-cobro-propina-wrapper"  class="row bord-btm">
								<span class="col-sm-5 text-right text-2x text-info" id="facturacion-app-venta-cobro-propina-text">Propina</span>
								<div class="col-sm-1 text-right">
									<p class="text-main text-2x">$</p>
								</div>
								<div class="col-sm-4 text-right">
									<p id="facturacion-app-venta-cobro-propina" class="text-2x text-info"></p>
								</div>
							</div>
							<!--Totaltotal-->
							<div id="facturacion-app-venta-cobro-totalfinal-wrapper"  class="row bord-btm">
								<span class="col-sm-5 text-right text-main text-2x text-bold" id="facturacion-app-venta-cobro-totalfinal-text">Total</span>
								<div class="col-sm-1 text-right">
									<p class="text-main text-2x">$</p>
								</div>
								<div class="col-sm-4 text-right">
									<p id="facturacion-app-venta-cobro-totalfinal" class="text-main text-2x text-bold"></p>
								</div>
							</div>
							<!--Efectivo-->
							<div id="facturacion-app-venta-cobro-efectivo-wrapper" class="row">
								<span class="col-sm-5 text-right text-main text-2x">Efectivo</span>
								<div class="col-sm-1 text-right">
									<p class="text-main text-2x">$</p>
								</div>
								<div class="col-sm-4 text-right">
									<p id="facturacion-app-venta-cobro-efectivo"  class="text-main text-2x"></p>
								</div>
							</div>
							<!--Cambio-->
							<div id="facturacion-app-venta-cobro-cambio-wrapper" class="row text-center bord-all bg-gray-light ">
								<span class="text-main text-2x">Cambio</span>
								<p id="facturacion-app-venta-cobro-cambio" class=" text-semibold text-4x text-info"></p>
							</div>
							<div class="text-center bord-top mar-top pad-all">
								<button id="facturacion-app-venta-cobro-salir-btn" class="btn btn-danger btn-lg" disabled>Salir</button>
							</div>
						</div>
					</div>
				</div>
			</div>
	</div>
		<!--BOTONES-->
		<!--<div id="nueva-orden-buttons-wrapper" class="text-center">
			<div class="panel">
				<div class="panel-body">
					<button type="button" class="btn btn-mint btn-lg btn-nueva-orden-wizzard" id="nueva-orden-wizzard-btn-prev" data-action="prev">Anterior</button>
					<button type="button" class="btn btn-mint btn-lg btn-nueva-orden-wizzard" id="nueva-orden-wizzard-btn-next" data-action="next">Continuar</button>
				</div>
			</div>
		</div>-->
	</div>
</div>
<script>	
	$(document).ready(function () {
		var ordenes_nueva=new Ordenes_nueva();
		ordenes_nueva.initializeEnviroment("<?php echo base_url();?>","<?php echo $winid;?>",{
			menu_mode:<?php echo $config->menu_mode->value;?>,
			cant_decimal_precision:<?php echo $config->cant_decimal_precision->value;?>,
			precios_decimal_precision: <?php echo $config->precios_decimal_precision->value;?>,
			totales_decimal_precision: <?php echo $config->totales_decimal_precision->value;?>
		},'<?php echo (!isset($id_orden)?"create":"update");?>');
		
		ordenes_nueva.ordenWizardSchema=["nueva-orden-info-wrapper","nueva-orden-contenido-wrapper"];
		
		
		ChinaInTools.initializeKeyboard("<?php echo $winid;?>");
	});
</script>