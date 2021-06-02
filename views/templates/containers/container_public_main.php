<div class="card">
	<div class="card-heading bg-blue p-2">
		RESUMEN
	</div>
	<div class="card-body">	
		<div class="form-row">
			<div class="col-lg-6">
				<div class="form-group">				
					<label class="control-label col-lg-6">Total ingresos disponibles en el mes</label>
					<div class="col-lg-6">
						<input type="text" class="form-control-sm" id="nr_total_ingresos" value="<?php echo $datos[ctrlingresos][resumen][total];?>" readonly>
					</div>				
				</div>				
			</div>
			<div class="col-lg-6">
				<div class="form-group">			
					<label class="control-label col-lg-6">Total presupuestado disponible en el mes</label>
					<div class="col-lg-6">
						<input type="text" class="form-control-sm" id="nr_total_presupuesto" value="<?php echo $datos[ctrlpresupuesto][resumen][total_mes];?>" readonly>
					</div>
				</div>
			</div>
		</div>
		<!--<div class="form-row">
			<div class="col-lg-4">			
				<label class="control-label col-lg-6">Saldo Disponible</label>
				<div class="col-lg-6">
					<input type="text" class="form-control-sm" readonly>
				</div>
			</div>
		</div>-->		
	</div>
</div>

<?php include_once("views/templates/containers/container_tabs.php"); ?>