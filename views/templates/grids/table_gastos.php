<table id="table_gasto" class="table">
	<thead>
		<tr>
			<th>Item</th>
			<th>Categor&iacute;a</th>
			<th>Sub Categor&iacute;a</th>					
			<th>Monto Gastado</th>			
		</tr>
	</thead>
	<tbody>
	<?php
		$count = 0;
		foreach($datos[ctrlpresupuesto][listado][presupuesto_gastos] as $item):
	?>
			<tr>
				<td><?php echo ++$count; ?></td>
				<td><?php echo $item->nombre_categoria;?></td>
				<td><?php echo $item->nombre_subcategoria;?></td>				
				<td><?php echo '$ '.number_format($item->monto,0,',','.'); ?></td>			
			</tr>
	<?php
		endforeach;
	?>					
	</tbody>
</table>