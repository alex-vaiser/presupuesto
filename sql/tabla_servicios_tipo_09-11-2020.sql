CREATE TABLE `tb_servicios_tipo` (
  `servicio_tipo_id` int(11) NOT NULL AUTO_INCREMENT,
  `servicio_tipo_nombre` varchar(100) NOT NULL,
  `servicio_tipo_activo` int(1) DEFAULT 1,
  PRIMARY KEY (`servicio_tipo_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;


INSERT INTO tb_cotizacion_servicio_tipo (servicio_tipo_nombre,servicio_tipo_activo) VALUES
('Banqueter&iacute;a',1),
('Decoraci&oacute;n',1);
