<table id="table_ingresos" class="table">
	<thead>
		<tr>
			<th>Item</th>
			<th>Fecha de registro</th>
			<th>Hora de registro</th>
			<th>Monto</th>
		</tr>
	</thead>
	<tbody>
	<?php
		$count = 0;
		foreach($datos[ctrlingresos][listado][ingresos] as $item):
	?>
			<tr>
				<td><?php echo ++$count; ?></td>
				<td>
					<span style="display:none;"><?php echo $item->fecha_hora_sin_formato;?></span>
					<?php echo $item->fecha; ?>					
				</td>
				<td><?php echo $item->hora; ?></td>
				<td><?php echo $item->monto; ?></td>
			</tr>
	<?php
		endforeach;
	?>					
	</tbody>
</table>