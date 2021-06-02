CREATE TABLE tb_servicios (
   servicio_id int(11) NOT NULL AUTO_INCREMENT,
   servicio_tipo_id int(11) NOT NULL,
   servicio_nombre varchar(100) NOT NULL,
   servicio_activo int(1) NOT NULL DEFAULT 1,
   CONSTRAINT tb_servicios_PK PRIMARY KEY (servicio_id)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;


INSERT INTO tb_servicios (servicio_tipo_id,servicio_nombre,servicio_activo) VALUES
	 (1,'Coctel inicial',1),
	 (1,'Cena o Almuerzo',1),
	 (1,'Postre &uacute;nico',1),
	 (1,'Buffet de postres',1),
	 (1,'Candy bar',1),
	 (1,'Tentaci&oacute;n de dulces',1),
	 (1,'Estaci&oacute;n de caf&eacute;',1),
	 (1,'Bar abierto',1),
	 (1,'Tragos especiales',1),
	 (1,'M&uacute;sica e Iluminaci&oacute;n (DJ + Audio)',1),
	 (1,'Data y Tel&oacute;n',1),
	 (1,'Fotograf&iacute;a',1),
	 (1,'Video',1),
	 (1,'Manteler&iacute;a',1),
	 (1,'Inmobiliario',1),
	 (1,'Personal de cocina y Sal&oacute;n',1),
	 (2,'Ramo de novia soltera',1),
	 (2,'Ramos de dama de honor',1),
	 (2,'Botonier Padrinos',1),
	 (2,'Iglesia y Ceremonia',1),
	 (2,'Ceremonia',1),
	 (2,'Integral',1),
	 (2,'Ambientaciones',1),
	 (2,'Montajes tem&aacute;ticos',1),
	 (2,'Rosas para entrega (4&deg; Medio)',1),
	 (2,'Ramos o Bouquet',1);
