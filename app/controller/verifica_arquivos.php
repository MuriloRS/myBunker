<?php
    session_start();
    
    $provas = $_FILES['prova'];
    $materia =  $_POST['materia'];
    $ano =  $_POST['ano'];
    $email = $_SESSION['email'];

    //Verifica se existe email_usuario materia e imagem
    if(isset($email) && isset($materia)){

        for($x = 0 ; $x < count($provas['type']); $x++){
            if(!preg_match('/(pjpeg|jpeg|png|bmp|jpg|zip|pdf)$/', $provas['type'][$x])){
                echo "Um ou mais arquivos são de formato inválido do tipo = ".$provas['type'][$x];
            }
            else{
                //  Passa o email da sessão e o objeto dao para conexão
                // com banco de dados para pegar o id do cliente logado.
                //$id_usuario = busca_id_usuario_logado($email, $dao);
                echo "1";
               
            }
        }
    }
    else{
        echo "alguns dados estão faltando";
    }
    
?>