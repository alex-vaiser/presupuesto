<div class="card">
	<div class="card-heading bg-blue p-2">
		<span style="float:left">REGISTRO DE GASTOS</span>
		<span style="font-size:12px;float:right;padding:2px 5px;cursor:pointer" data-panel="panel_reg_gastos" onclick="Base.mostrarOcultarPanel(this,1)">
			<span>OCULTAR</span>
			<i class="fa fa-chevron-up"></i>
		</span>
	</div>
	<div class="card-body panel" id="panel_reg_gastos">
		<form id="form_reg_gastos">					
			<div class="form-row mt-2">
				<div class="col-lg-6">
					<div class="form-row">				
						<label class="control-label col-lg-4">N&deg; Folio</label>
						<div class="col-lg-4">
							<input type="text" id="input_folio_gastos" name="input_folio_gastos" class="form-control-sm" value="" onchange="Presupuesto.get(this.value)">
						</div>
					</div>
				</div>
			</div>
			<hr>
			<div class="form-row mt-2">
				<div class="col-lg-12">
					<div id="tb_gastos_item" class="table-responsive">
						<?php include_once("views/templates/grids/table_gastos_item.php"); ?>
					</div>
				</div>		
			</div>		
		</form>	
	</div>
</div>

<div class="card mt-2">
	<div class="card-heading bg-blue p-2">
		<span style="float:left">LISTADO DE GASTOS</span>
		<span style="font-size:12px;float:right;padding:2px 5px;cursor:pointer" data-panel="panel_gastos" onclick="Base.mostrarOcultarPanel(this,1)">
			<span>OCULTAR</span>
			<i class="fa fa-chevron-up"></i>
		</span>
	</div>
	<div class="card-body panel" id="panel_gastos">		
		<div class="form-row mt-2">
			<div class="col-lg-12">
				<div id="tb_gastos" class="table-responsive">
					<?php include_once("views/templates/grids/table_gastos.php"); ?>
				</div>
			</div>		
		</div>		
	</div>
</div>