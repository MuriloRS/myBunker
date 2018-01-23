<?php

    session_start();

    $email = $_POST['email'];
    $senha = $_POST['senha'];

    require_once("../model/dao.class.php");
    $dao = new dao("../");

    $query = "SELECT email, senha, tipo_usuario, nome_login,id FROM usuarios
    where email = '$email' and senha = '$senha'";

    //Executa a query select
    $resultado_select = $dao->executeSelect($query);

    //Se o resultado for diferente de null quer dizer que existe um usuário com esse email ou senha
    if($resultado_select != null){
        
        $_SESSION['email'] = $email;
        $_SESSION['tipo_usuario'] = $resultado_select['tipo_usuario'];
        $_SESSION['login'] =  $resultado_select['nome_login'];
        $_SESSION['id'] = $resultado_select['id'];

        header("Location: ../view/usuario_logado.php");
    }
    else{
        if($email == '' && $senha == ''){
            header("Location: ../../index.php?erro=3");
        }
        else{
            header("Location: ../../index.php?erro=2");
        }
    }

?>