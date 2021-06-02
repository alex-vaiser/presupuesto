<div class="card">
	<div class="card-heading bg-blue p-2">
		<span style="float:left">LISTADO PRESUPUESTOS</span>
		<span id="span_panel_list_presupuesto" style="font-size:12px;float:right;padding:2px 5px;cursor:pointer" data-panel="panel_list_presupuesto" onclick="Base.mostrarOcultarPanel(this,1)">
			<span>OCULTAR</span>
			<i class="fa fa-chevron-up"></i>
		</span>
	</div>
	<div class="card-body panel" id="panel_list_presupuesto">
		<div class="form-row justify-content-end">
			<div class="col-lg-2" style="padding-right:0px">
				<button type="button" class="btn btn-sm btn-success" id="btn_nuevo_presupuesto" onclick="Presupuesto.nuevo()">
					<i class="fa fa-plus"></i>&nbsp;Nuevo presupuesto
				</button>
			</div>
		</div>
		<div class="form-row mt-2">
			<div class="col-lg-12">
				<div id="tb_presupuesto" class="table-responsive">
					<?php include_once("views/templates/grids/table_presupuesto.php"); ?>
				</div>
			</div>
		</div>
	</div>
</div>


<div class="card mt-2">
	<div class="card-heading bg-blue p-2">
		<span style="float:left">ARMADO DE PRESUPUESTO</span>
		<span id="span_panel_reg_presupuesto" style="font-size:12px;float:right;padding:2px 5px;cursor:pointer" data-panel="panel_reg_presupuesto" onclick="Base.mostrarOcultarPanel(this,1)">
			<span>MOSTRAR</span>
			<i class="fa fa-chevron-down"></i>
		</span>
	</div>
	<div class="card-body panel" id="panel_reg_presupuesto" style="display:none">
		<form id="form_presupuesto_items">	
			<input type="hidden" id="input_mes_anterior" name="input_mes_anterior" value="<?php echo ((date('n')-1) == 0) ? ucwords(strtolower($meses[12])) :  ucwords(strtolower($meses[date('n')-1]));?>">		
			<input type="hidden" id="input_mes_actual" name="input_mes_actual" value="<?php echo  ucwords(strtolower($meses[date('n')]));?>">	
			<div class="form-row mt-2">
				<div class="col-lg-6">
					<div class="form-row">				
						<label class="control-label col-lg-4">N&deg; Folio</label>
						<div class="col-lg-4">
							<input type="text" id="input_folio" name="input_folio" class="form-control-sm" value="<?php echo $datos[folio];?>" readonly>
						</div>
					</div>
				</div>
			</div>	
			<div class="form-row mt-2">
				<div class="col-lg-6">
					<div class="form-row">				
						<label class="control-label col-lg-4 required">Categor&iacute;a</label>
						<div class="col-lg-4">
							<select id="select_categoria" name="select_categoria" class="form-control-sm" onchange="Presupuesto.cargarSubCategorias(this,'select_subcategoria');" style="width:100%!important">
								<option value="0">Seleccione</option>
								<?php 
									foreach($datos["ctrlpresupuesto"]["listado"]["categorias"] as $categoria):
								?>
										<option value="<?php echo $categoria->id;?>"><?php echo $categoria->nombre; ?></option>
								<?php
									endforeach;
								?>
							</select>
						</div>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="form-row">				
						<label class="control-label col-lg-4 required">Sub Categor&iacute;a</label>
						<div class="col-lg-4">
							<select id="select_subcategoria" name="select_subcategoria" class="form-control-sm" style="width:100%!important" onchange="Presupuesto.getMontoMesAnteriorBySubCategoria(this)">
								<option value="0">Seleccione</option>							
							</select>
						</div>
					</div>
				</div>
			</div>
			<div class="form-row mt-2">
				<div class="col-lg-6">
					<div class="form-row">				
						<label class="control-label col-lg-4">Monto mes <?php echo ((date('n')-1) == 0) ? ucwords(strtolower($meses[12])) :  ucwords(strtolower($meses[date('n')-1]));?></label>
						<div class="col-lg-3">
							<input type="text" id="input_monto_presupuesto_anterior" name="input_monto_presupuesto_anterior" class="form-control-sm" value="0" readonly>
						</div>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="form-row">				
						<label class="control-label col-lg-4 required">Monto mes <?php echo  ucwords(strtolower($meses[date('n')]));?></label>
						<div class="col-lg-3">
							<input type="text" id="input_monto_presupuesto_actual" name="input_monto_presupuesto_actual" class="form-control-sm" onkeyup="Base.desbloquearBloquear(this,'btn_registrar')">
						</div>
					</div>
				</div>
			</div>
			<div class="form-row mt-2 justify-content-end">
				<button type="button" id="btn_registrar" name="btn_registrar" class="btn btn-success btn-sm" onclick="Presupuesto.guardarItem()" disabled>
					<i class="fa fa-save"></i>&nbsp;Registrar
				</button>
			</div>
		</form>	
		<hr>
		<div class="form-row mt-2">
			<div class="col-lg-12">
				<div id="tb_presupuesto_item" class="table-responsive">
					<?php include_once("views/templates/grids/table_presupuesto_item.php"); ?>
				</div>	
			</div>	
		</div>
		<hr>
		<div class="form-row mt-2 justify-content-end">
			<button type="button" id="btn_finalizar" class="btn btn-sm btn-danger" onclick="Presupuesto.finalizar()" disabled>
				<i class="fa fa-lock"></i>&nbsp;Finalizar
			</button>
		</div>
	</div>	
</div>