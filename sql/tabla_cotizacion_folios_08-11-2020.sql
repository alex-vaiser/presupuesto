CREATE TABLE `tb_cotizacion_folio` (
  `folio_anio` tinyint(2) NOT NULL,
  `folio_codigo_id` tinyint(1) NOT NULL,
  `folio_correlativo_id` bigint(20) auto_increment NOT NULL,
  `folio_cotizacion_manual` tinyint(1) NOT NULL DEFAULT 1,
  `folio_utilizado` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`folio_correlativo_id`,`folio_codigo_id`,`folio_anio`)
) 
ENGINE=InnoDB 
DEFAULT CHARSET=utf8 
COLLATE=utf8_general_ci
AUTO_INCREMENT=1541;