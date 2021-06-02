<?php
	class Funcion{
		
		public static function convertirFechaToDB($_fecha){
			$strFecha = str_replace('/','-',$_fecha);
			$arrFecha = explode('-',$strFecha);
			$arrFecha = array_reverse($arrFecha);

			if(checkdate($arrFecha[1], $arrFecha[2], $arrFecha[0])){
				return implode('-',$arrFecha);
			}

			return "";
		}

		public static function convertirHoraToDB($_tiempo,$_formato = "12h"){
			switch($_formato){
				case "12h":	
					$arrHora = ['01','02','03','04','05','06','07','08','09','10','11','12'];

					if(stripos($_tiempo,'pm') !== FALSE){
						$arrHora = ['13','14','15','16','17','18','19','20','21','22','23','24'];						
					}

					$strTiempo = str_replace(['AM','PM'],'',$_tiempo);
					$arrTiempo = explode(':',$strTiempo);
					$arrIdx    = array_keys($arrHora);
					$isFound   = false;        

					if(in_array(($arrTiempo[0]-1),$arrIdx)){						
						$arrTiempo[0] = $arrHora[$arrTiempo[0]-1];
						$isFound      = true;
					}					

					if($isFound and ($arrTiempo[1] < 61 && $arrTiempo[1] > -1)){
						if(count($arrTiempo) == 2){
							return trim(implode(':',$arrTiempo)) . ':00';
						}
						return implode(':',$arrTiempo);
					}

					return "";

			}
		}
	}
?>