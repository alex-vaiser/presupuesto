<table id="table_gasto_item" class="table">
	<thead>
		<tr>
			<th>Item</th>
			<th>Categor&iacute;a</th>
			<th>Sub Categor&iacute;a</th>			
			<th>Monto Presupuestado</th>			
			<th>Monto Gastado</th>
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
				<td align="right"><?php echo '$ '.number_format($item->saldo,0,',','.'); ?></td>				
				<td>
					<input type="text" id="gasto_id_<?php echo $item->id;?>" name="gasto_id_<?php echo $item->id;?>" class="form-control-sm">
				</td>
				<td align="center">
					<button type="button" class="btn btn-sm btn-success" onclick="Presupuesto.guardarGastoItem(<?php echo $item->id; ?>)">
						<i class="fa fa-save"></i>
					</button>
				</td>
			</tr>
	<?php
		endforeach;
	?>					
	</tbody>
</table>