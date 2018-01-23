<?php
    session_start();

    require_once("../model/dao.class.php");
    require_once("../model/div_modelos.class.php");
         
    $modelo = new div_modelos();
    $dao = new dao("../");

    $id_usuario = $_SESSION['id'];
    $comentario = $_POST['comentario'];
    $id_prova = $_POST['id_prova'];

    $query = "INSERT INTO prova_comentario(comentario, id_prova_dados, id_usuario)
    VALUES('".$comentario."', ".$id_prova.", ".$id_usuario.")";

    //Set locale para a data ficar no formato padrão brasileiro
    setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8", "portuguese");
    
    if($dao->executeInsert($query)){
        $comentarioSelect = busca_id_comentario($dao);
    
        echo $modelo->div_comentarios($comentarioSelect['id_comentario'], $_SESSION['login'], 
                                        $comentarioSelect['data_postagem'], $comentario, false); 

    }
    else{
        echo "1";
    }

    function busca_id_comentario($dao){
        $query = "
            SELECT id_comentario, data_postagem FROM prova_comentario
            ORDER BY id_comentario DESC, data_postagem DESC
            LIMIT 1
        ";

        $comentario = $dao->executeSelect($query);

        return $comentario;
    }
?>