<div class="card">
	<div class="card-heading bg-blue p-2">
		<span style="float:left">REGISTRO DE INGRESOS</span>
		<span style="font-size:12px;float:right;padding:2px 5px;cursor:pointer" data-panel="panel_reg_ingresos" onclick="Base.mostrarOcultarPanel(this,1)">
			<span>OCULTAR</span>
			<i class="fa fa-chevron-up"></i>
		</span>
	</div>
	<div class="card-body panel" id="panel_reg_ingresos">
		<form id="form_ingresos" onSubmit="return false;">
			<div class="form-row">
				<label class="control-label required col-lg-2 text-right">Monto</label>
				<div class="col-lg-3">
					<input type="text" id="nr_monto" name="nr_monto" class="form-control-sm">
				</div>
				<button type="button" class="btn btn-success btn-sm" onclick="Ingreso.guardar()">
					<i class="fa fa-save"></i>&nbsp;Registrar
				</button>
			</div>			
		</form>
		<hr>
		<div id="tb_ingresos" class="table-responsive">
			<?php include_once("views/templates/grids/table_ingresos.php"); ?>
		</div>
	</div>
</div>