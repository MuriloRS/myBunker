<?php
		session_start();

		//PEGA AS VARIÁVEIS NECESSÁRIAS
		$materia =  $_POST['materia'];
		$ano =  $_POST['ano'];
		$universidade = $_POST['universidade'];
		$email_usuario = $_SESSION['email'];
		$provas = $_FILES['prova'];

		require_once('../Model/PHPMailer/class.phpmailer.php');
		$email = new PHPMailer();
		$email->CharSet = 'UTF-8';
		$email->From      = "murilo_haas@outlook.com";
		$email->FromName  = $email_usuario;
		$email->Subject   = 'Subject';
		$email->Body      = "Matéria: ".$materia."\n Ano da prova: ". $ano."\n"."Universidade: ".$universidade;
		
		$email->AddAddress( 'murilointer2011@hotmail.com' );

		for($x = 0 ; $x < count($provas['type']); $x++){
			// Arquivo enviado via formulário
			$path = $provas['tmp_name'][$x]; 
			$fileType = $provas['type'][$x]; 
			$fileName = $provas['name'][$x]; 

			$email->AddAttachment( $path , $fileName, 'base64', 'application/octet-stream' );
		}

		return $email->Send();

?>
