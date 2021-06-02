<table id="table_presupuesto" class="table">
	<thead>
		<tr>			
			<th align="center">Folio</th>
			<th align="center">Fecha de registro</th>
			<th align="center">Hora de registro</th>
			<th align="right">Monto Total</th>
			<th align="center">Estado</th>
			<th align="center">Acciones</th>
		</tr>
	</thead>
	<tbody>
	<?php
		$count = 0;
		foreach($datos[ctrlpresupuesto][listado][presupuesto] as $item):
	?>
			<tr>				
				<td align="center"><?php echo $item->folio;?></td>
				<td align="center">
					<span style="display:none;"><?php echo $item->fecha_hora_sin_formato;?></span>
					<?php echo $item->fecha; ?>					
				</td>
				<td align="center"><?php echo $item->hora; ?></td>
				<td align="right"><?php echo $item->monto_total;?></td>
				<td align="center">
					<?php 
						if($item->is_cerrado):
					?>
							<span class="badge badge-danger">								
								Cerrado
							</span>
					<?php
						else:
					?>
							<span class="badge badge-success">								
								Abierto
							</span>
					<?php
						endif;
					?>
				</td>
				<td align="center">
					<?php 
						if(!$item->is_cerrado):
					?>
							<button type="button" class="btn btn-success btn-sm" onclick="Presupuesto.revisar('<?php echo $item->folio;?>')">
								<i class="fa fa-eye"></i>
							</button>
					<?php
						else:
					?>
							<button type="button" class="btn btn-info btn-sm" onclick="Presupuesto.modalEmail('<?php echo $item->folio;?>')">
								<i class="fa fa-envelope"></i>
							</button>
					<?php
						endif;
					?>
				</td>				
			</tr>
	<?php
		endforeach;
	?>					
	</tbody>
</table>