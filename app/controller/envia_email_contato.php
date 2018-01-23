<?php

    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $assunto = $_POST['assunto'];
	$mensagem = $_POST['msg'];
	$tipo_mensagem = $_POST['tipo_msg'];

    require_once('../Model/PHPMailer/class.phpmailer.php');
		$email = new PHPMailer();
		$email->CharSet = 'UTF-8';
		$email->From      = $email;
		$email->FromName  = ''.$nome;
		$email->Subject   = 'Subject';
		$email->Body      = 'Mensagem: '.$tipo_mensagem.' - '.$mensagem;
		
		$email->AddAddress( 'murilointer2011@hotmail.com' );

		return $email->Send();
?>