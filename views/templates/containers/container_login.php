<div class="card">
	<div class="card-heading bg-blue p-2">
		<span style="float:left">CREDENCIALES</span>		
	</div>
	<div class="card-body panel" id="panel_autenticacion">
		<form id="form_autenticacion">					
			<div class="form-row mt-2">
				<div class="col-lg-6">
					<div class="form-row">				
						<label class="control-label col-lg-4">Usuario</label>
						<div class="col-lg-4">
							<input type="text" id="input_usuario" name="input_usuario" class="form-control-sm" value="">
						</div>
					</div>
					<div class="form-row mt-2">				
						<label class="control-label col-lg-4">Contraseña</label>
						<div class="col-lg-4">
							<input type="password" id="input_clave" name="input_clave" class="form-control-sm" value="">
						</div>
					</div>
				</div>				
			</div>
			<div class="justify-content-end">
				<button type="button" class="btn btn-success btn-sm" onclick="Usuario.autenticar()">Ingresar</button>
			</div>				
		</form>	
	</div>
</div>