<div class="mt-3">
	<ul class="nav nav-tabs">
		<?php
			$active = "";
			foreach($menu as $item):
				if($item->id == 2):
					$active = "active";
				endif;
		?>
				<li class="nav-item">
					<a class="nav-link <?php echo $active; ?>" data-toggle="tab" role="tab" href="#<?php echo 'contenido_'.$item->id;?>">
						<?php echo $item->nombre;?>
					</a>
				</li>
		<?php

				$active = "";
			endforeach;
		?>
	</ul>
	<div class="tab-content">		
		<div class="tab-pane  fade in " id="contenido_1">
			<div class="card-body bg-grey">
				<?php include_once("views/templates/containers/container_ingresos.php");?>
			</div>
		</div>
		<div class="tab-pane show fade in active" id="contenido_2">
			<div class="card-body">
				<?php include_once("views/templates/containers/container_presupuesto.php");?>
			</div>
		</div>
		<div class="tab-pane show fade in " id="contenido_3">
			<div class="card-body">
				<?php include_once("views/templates/containers/container_gastos.php");?>
			</div>
		</div>		
	</div>
	</div>
