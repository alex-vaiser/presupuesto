<?php
	//error_reporting(0);
	//display_errors("Off");
	require_once("libs/mpdf/vendor/autoload.php");

	class Pdf{

		public static function generarPDF($contained,$filename = "files/ejemplo.pdf"){
			$css = file_get_contents(Uri::getBaseUri()."views/css/pdf.css");
 			$pdf = new \Mpdf\Mpdf();
			$pdf->debug = true;
			$pdf->WriteHTML($css,1);
			$pdf->WriteHTML($contained,2,1,1);
			$pdf->Output($filename,'I');
		}
		
	}
?>