<?php

	require_once "phpmailer/PHPMailerAutoload.php";

	class Email{	

		public static function send($to,$subject,$contained){
			
			$json  = json_decode(CFG_JSON,1);			
			$_mail = new PHPMailer;

			$_mail->isSMTP();
			$_mail->SMTPDebug  = 0;
			$_mail->SMTPAuth   = true;
			$_mail->Host       = $json["mail"]["host"];
			$_mail->Port       = $json["mail"]["port"];
			$_mail->SMTPSecure = $json["mail"]["secure"];
			$_mail->Username   = $json["mail"]["user"];
			$_mail->Password   = $json["mail"]["password"];
			$str_mails = implode(';',$to);

			$_mail->setFrom("alex.vaiser2012@gmail.com","Presupuesto del Mes");
			$_mail->addAddress($str_mails);
			$_mail->addReplyTo($json["mail"]["user"]);


			$_mail->isHTML(true);
			$_mail->Subject = $subject;
			$_mail->Body = $contained;
			
			$_mail->CharSet = 'UTF-8';

			if(!$_mail->send()){				
				return false;
			}

			return true;

		}		

	}
?>