<!DOCTYPE html>
<html lang="es">
	<head>
		<title>
			<?php 
				if(!empty($title)){
					echo $title;
				}else{
					echo "PRESUPUESTO";
				}
			?>					
		</title>
		<meta charset="UTF-8">
		<meta name="robots" content="noindex">
		<meta name="viewport" content="width=device-width,initial-scale=1">
		<link type="text/css" href="<?php echo Uri::getBaseUri();?>plugins/bootstrap-4.5.0/dist/css/bootstrap.css?<?php echo uniqid(); ?>" rel="stylesheet">
		<link type="text/css" href="<?php echo Uri::getBaseUri();?>plugins/jquery-ui-1.10.1/css/jquery-ui.css?<?php echo uniqid(); ?>" rel="stylesheet">
		<link type="text/css" href="<?php echo Uri::getBaseUri();?>plugins/jquery-ui-1.10.1/css/jquery-ui.timepicker.min.css?<?php echo uniqid(); ?>" rel="stylesheet">
		<link type="text/css" href="<?php echo Uri::getBaseUri();?>plugins/fontawesome-free-5.14.0-web/css/all.css?<?php echo uniqid(); ?>" rel="stylesheet">
		<link type="text/css" href="<?php echo Uri::getBaseUri();?>plugins/flexslider/css/flexslider.css?<?php echo uniqid(); ?>" rel="stylesheet">
		<link type="text/css" href="<?php echo Uri::getBaseUri();?>plugins/flexslider/css/demo.css?<?php echo uniqid(); ?>" rel="stylesheet">
		<link type="text/css" href="<?php echo Uri::getBaseUri();?>plugins/DataTables-1.10.22/css/datatables.css?<?php echo uniqid(); ?>" rel="stylesheet">
		<link type="text/css" href="<?php echo Uri::getBaseUri();?>views/css/base.css?<?php echo uniqid(); ?>" rel="stylesheet">
		<?php echo Loader::$_css_code; ?>
	</head>
	<body>
		<div class="container">
			<header>				
				<label for="chk_menu">
					<i class="fa fa-2x fa-bars"></i>
				</label>
				<div class="row">
					<div class="col-lg-4 col-md-12 col-sm-12 col-12">
						<h1>PRESUPUESTO</h1>
					</div>
					<div class="col-lg-8 col-md-12 col-sm-12 col-12">
						
					</div>
				</div>
			</header>
			<section id="main">
				<div class="container">
					<div class="d-flex justify-content-end">
						<?php 	if(!empty($_SESSION["id_user"])):?>
									<button type="button" class="btn btn-danger" onclick="location.href=Base.getBaseUri()+'Publico/cerrarSession'">Cerrar</button>
						<?php   endif; ?>
					</div>
					<div class="mt-2">
						<?php 
							if(isset($contained) and !empty($contained)){
								echo $contained;
							}
						?>
					</div>
				</div>
			</section>
			<section class="mt-2">&nbsp;</section>
			<footer>
				<div class="container">
					<div class="row">
						<div class="col-lg-12 col-md-12 col-sm-12 col-12 text-center">
							<small>DESARROLLADO POR ALVISSERWEB &copy;2021 <br> Contacto: contacto@alvisserweb.cl</small>
						</div>
					</div>
				</div>
			</footer>
		</div>
		<script type="text/javascript" src="<?php echo Uri::getBaseUri();?>plugins/jquery-3.5.1/js/jquery.js?<?php echo uniqid(); ?>"></script>		
		<script type="text/javascript" src="<?php echo Uri::getBaseUri();?>plugins/jquery-ui-1.10.1/js/jquery-ui.js?<?php echo uniqid(); ?>"></script>
		<script type="text/javascript" src="<?php echo Uri::getBaseUri();?>plugins/jquery-ui-1.10.1/js/jquery.ui.datepicker-es.js?<?php echo uniqid(); ?>"></script>
		<script type="text/javascript" src="<?php echo Uri::getBaseUri();?>plugins/jquery-ui-1.10.1/js/jquery.ui.timepicker.min.js?<?php echo uniqid(); ?>"></script>		
		<script type="text/javascript" src="<?php echo Uri::getBaseUri();?>plugins/bootstrap-4.5.0/dist/js/popper.min.js?<?php echo uniqid(); ?>"></script>
		<script type="text/javascript" src="<?php echo Uri::getBaseUri();?>plugins/bootstrap-4.5.0/dist/js/bootstrap.bundle.js?<?php echo uniqid(); ?>"></script>
		<script type="text/javascript" src="<?php echo Uri::getBaseUri();?>plugins/bootstrap-4.5.0/dist/js/bootstrap.js?<?php echo uniqid(); ?>"></script>
		<script type="text/javascript" src="<?php echo Uri::getBaseUri();?>plugins/fontawesome-free-5.14.0-web/js/all.js?<?php echo uniqid(); ?>"></script>
		<script type="text/javascript" src="<?php echo Uri::getBaseUri();?>plugins/DataTables-1.10.22/js/datatables.js?<?php echo uniqid(); ?>"></script>
		<script type="text/javascript" src="<?php echo Uri::getBaseUri();?>plugins/bootbox-5.4.1/js/bootbox.js?<?php echo uniqid(); ?>"></script>
		<script type="text/javascript" src="<?php echo Uri::getBaseUri();?>plugins/flexslider/js/jquery.flexslider.js?<?php echo uniqid(); ?>"></script>		
		<script type="text/javascript" src="<?php echo Uri::getBaseUri();?>views/js/base.js?<?php echo uniqid(); ?>"></script>
		<script type="text/javascript" src="<?php echo Uri::getBaseUri();?>views/js/validacion.js?<?php echo uniqid(); ?>"></script>
		<script type="text/javascript" src="<?php echo Uri::getBaseUri();?>views/js/ventanaModal.js?<?php echo uniqid(); ?>"></script>
		<?php echo Loader::$_js_code; ?>
	</body>
</html>