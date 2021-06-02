<table id="table_presupuesto_item" class="table">
	<thead>
		<tr>
			<th>Item</th>
			<th>Categor&iacute;a</th>
			<th>Sub Categor&iacute;a</th>
			<th>Monto mes anterior</th>
			<th>Monto mes actual</th>
			<th>Acciones</th>
		</tr>
	</thead>
	<tbody>
	<?php
		$count = 0;
		foreach($datos[ctrlpresupuesto][listado][presupuesto_item] as $item):
	?>
			<tr>
				<td><?php echo ++$count; ?></td>
				<td><?php echo $item->nombre_categoria;?></td>
				<td><?php echo $item->nombre_subcategoria;?></td>
				<td><?php echo $item->monto_mes_anterior;?></td>
				<td><?php echo $item->monto_mes_actual; ?></td>
				<td align="center">
					<button type="button" class="btn btn-sm btn-danger" onclick="Presupuesto.eliminarItem(<?php echo $item->id; ?>)">
						<i class="fa fa-trash"></i>
					</button>
				</td>
			</tr>
	<?php
		endforeach;
	?>					
	</tbody>
</table>