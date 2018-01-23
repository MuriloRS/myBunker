<?php
    session_start();

    require_once("../model/dao.class.php");
    require_once("../model/div_modelos.class.php");

    $dao = new dao("../");
    $modelo = new div_modelos();

    $email = $_GET['email'];

    //Monta a query para verificar se o email já existe
    $query = "SELECT * FROM usuarios
    WHERE usuarios.email = '".$email."'";

    $result = $dao->executeSelect($query);

    if($result == null){

        $query = "UPDATE usuarios SET usuarios.email = '".$email."'
        WHERE usuarios.nome_login = '".$_SESSION['login']."' ";

        $dao->executeUpdate($query);

        $msg = "Email confirmado com sucesso";

        $_SESSION['email'] = $email;
        
        echo $modelo->painel_mensagem($msg, 3);
    }
    else{
        $msg = "Esse email já está em cadastrado";

        echo $modelo->painel_mensagem($msg, 1);
    }
?>