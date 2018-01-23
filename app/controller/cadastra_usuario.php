<?php

    $email = $_POST['email-cad'];
    $senha = $_POST['senha-cad'];
    $login = $_POST['login-cad'];
    

    require_once("../model/dao.class.php");
    require_once("../model/div_modelos.class.php");

    $dao = new dao("../");
    $div_modelos = new div_modelos();
    
    //Se tipo_usuario for 0 então não existe um usuário com esse login e email, 
    //se o retorno for 1 existe um usuário com esse email
    //se o retorno for 2 existe um usuário com esse login
    $tipo_usuario = verifica_usuario_existe($login, $email, $dao);


    if($tipo_usuario == 1){
        echo $div_modelos->painel_mensagem( "Já existe um usuário cadastrado com esse login", 1);
    }
    else if($tipo_usuario == 2){
        echo $div_modelos->painel_mensagem( "Esse email já está cadastrado.", 1);
    }
    else{
        $query = "insert into usuarios(nome_login, email,senha) values('$login', '$email', '$senha')";

        if($dao->executeInsert($query) == true){

            echo $div_modelos->painel_mensagem("Usuário cadastrado com sucesso", 3);
        }
        else{
            
            echo $tipo_usuario;
        }
    }

    function verifica_usuario_existe($login, $email, $dao){

        //Query para verificar se já existe um login
        $query="SELECT nome_login FROM usuarios
            WHERE nome_login = '$login'";

        //Executa a query select
        $existe_usuario = $dao->executeSelect($query);

        //Se o resultado for diferente de null quer dizer que existe um usuário com esse login
        if($existe_usuario != null){
            return 1;
        }

        //Query para verificar se já existe um email
        $query="SELECT email FROM usuarios
        WHERE email = '$email'";

        //Executa a query select
        $existe_usuario = null;
        $existe_usuario = $dao->executeSelect($query);

        if($existe_usuario != null){
            return 2;
        }

        return 0;

    }

?>