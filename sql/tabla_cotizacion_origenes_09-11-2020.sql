CREATE TABLE `tb_cotizacion_origenes` (
  `origen_id` int(11) NOT NULL AUTO_INCREMENT,
  `origen_nombre` varchar(100) NOT NULL,
  `origen_activo` int(1) NOT NULL DEFAULT 1,
  `origen_visible` int(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`origen_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

INSERT INTO tb_cotizacion_origenes (origen_nombre,origen_activo,origen_visible) VALUES
('Sitio',1,0),
('Banqueter&iacute;a.com',1,1),
('Facebook',1,1),
('Instagram',1,1),
('Por recomendaci&oacute;n',1,1);