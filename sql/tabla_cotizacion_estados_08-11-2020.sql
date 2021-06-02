CREATE TABLE tb_cotizacion_estados (
	estado_id INT auto_increment NULL,
	estado_nombre varchar(100) NOT NULL,	
	estado_clase_html varchar(100) NULL,
	estado_activo TINYINT DEFAULT 1 NULL,
	CONSTRAINT tb_cotizacion_estado_PK PRIMARY KEY (estado_id)
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8
COLLATE=utf8_general_ci
AUTO_INCREMENT=1;

-- Registros
INSERT INTO tb_cotizacion_estados (estado_nombre,estado_clase_html,estado_activo) VALUES
('Solicitado','badge badge-primary',1),
('Generando Cotizaci&oacute;n','badge badge-warning',1),
('Enviado','badge badge-secondary',1),
('Visto','badge badge-dark',1),
('En proceso','badge badge-info',1),
('No concretado','badge badge-danger',1),
('Contratado','badge badge-success',1);