<div class="card">		
	<div class="card-body">
		<form>
			<input type="text" class="hide" id="input_folio_pre" name="input_folio_pre" value="<?php echo $folio;?>">

			<div class="form-row">
				<div class="col-lg-4">		
					<label class="control-label col-lg-8">Nombre destinatario</label>
					<div class="col-lg-6">
						<input type="text" id="input_nombre_dest" name="input_nombre_dest" class="form-control-sm">
					</div>	
				</div>	
				<div class="col-lg-4">		
					<label class="control-label col-lg-8">Email de destino</label>
					<div class="col-lg-6">
						<input type="text" id="input_email" name="input_email" class="form-control-sm">
					</div>	
				</div>
			</div>		
		</form> 
	</div>	
</div>
<div class="card mt-4">
	<div class="card-body">
		VISTA PREVIA
		<hr>
		<div class="col-lg-12">
			<?php include_once("views/templates/emails/email_presupuesto.php"); ?>
		</div>
	</div>
</div>