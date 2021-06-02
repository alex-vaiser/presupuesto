CREATE TABLE tb_cotizaciones(
	cotizacion_id INT auto_increment NULL,
	cotizacion_origen_id INT NULL,
	cotizacion_folio_nro INT NOT NULL,
	cotizacion_fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP NULL,
	cotizacion_estado_id INT NULL,
	cotizacion_cliente_nombres varchar(100) NOT NULL,
	cotizacion_cliente_apellidos varchar(100) NOT NULL,	
	cotizacion_cliente_json_contactos LONGTEXT NULL,
	cotizacion_evento_recinto_nombre VARCHAR(50) DEFAULT NULL NULL,
	cotizacion_evento_fecha DATE NULL,
	cotizacion_evento_hora TIME NULL,
	cotizacion_personas_cantidad INT NOT NULL,
	cotizacion_monto_total  DOUBLE NULL,	
	CONSTRAINT tb_cotizacion_PK PRIMARY KEY (cotizacion_id)
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8
COLLATE=utf8_general_ci
AUTO_INCREMENT=1;

