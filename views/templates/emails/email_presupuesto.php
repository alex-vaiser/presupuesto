<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<style type="text/css">
			p{
				width:80%;
				text-indent: 10px;
				text-align: justify;
				padding:15px 0;
			}			
			.table-modal{
				width:80%;
				border:1px solid #333;
				margin:10px;
			}
			.table-modal thead tr{
				background:#841582;
			}
			.table-modal thead tr > th{
				color:#FFF;				
				padding:10px;
			}
			.table-modal tbody tr > td{
				padding:10px;
			}
		</style>
	</head>
	<body>
		
		<strong>Estimado(a) <span id="nombre_destinatario"><?php echo $nombre_destinatario; ?></span>:</strong>
		
		<p>
			Por instrucci&oacute;n del remitente, emitimos a continuaci&oacute;n el siguiente detalle asociado al presupuesto N&deg; <span id="nro_presupuesto"><?php echo $nro_presupuesto; ?></span>
		</p>
		
		<table class="table-modal">
			<thead>
				<tr>
					<th>&Iacute;tem</th>
					<th>Categor&iacute;a</th>
					<th>Sub Categor&iacute;a</th>
					<th>Monto</th>
				</tr>
			</thead>
			<tbody>
				<?php 
					foreach($arrPresupuestoItems as $idx=>$item):
				?>
					<tr>
						<td><?php echo (++$idx);?></td>
						<td><?php echo $item->nombre_categoria;?></td>
						<td><?php echo $item->nombre_subcategoria;?></td>						
						<td><?php echo '$ '.number_format($item->monto_mes_actual,0,',','.');?></td>
					</tr>
				<?php
					endforeach;
				?>
			</tbody>
		</table>
		<br>
		<strong>
			
			Sin otro particular<br>
			Se despide atentamente<br>				
		</strong>
		<br>	
		<h4>Sistema Presup</h4>		
		
	</body>	
</html>