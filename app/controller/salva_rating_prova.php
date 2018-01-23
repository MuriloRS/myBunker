<?php
    require_once("../model/dao.class.php");

    $dao = new dao("../");

    session_start();

    $id_usuario = $_SESSION['id'];
    $id_prova = $_POST['id_prova'];
    $rating = $_POST['rating'];

    $query = "SELECT * FROM avaliacao_prova
            WHERE avaliacao_prova.id_prova = ".$id_prova."
            AND avaliacao_prova.id_usuario = ".$id_usuario." ";  

    if($dao->executeSelect($query) == NULL){
        insereAvaliacaoProva($rating,$id_usuario, $id_prova,$dao);
    }
    else{
        atualizaAvaliacaoProva($rating,$id_usuario, $id_prova,$dao);
    }


    //atualizaAvaliacaoProva($dao);


    function insereAvaliacaoProva($avaliacao, $id_usuario, $id_prova, $dao){
        $query = "INSERT INTO avaliacao_prova(id_prova, id_usuario, avaliacao)
        VALUES (".$id_prova.", ".$id_usuario.", ".$avaliacao.")";

        $dao->executeInsert($query);
    }

    function atualizaAvaliacaoProva($avaliacao, $id_usuario, $id_prova,$dao ){
        $query = "UPDATE avaliacao_prova SET avaliacao = ".$avaliacao."
        WHERE avaliacao_prova.id_prova = ".$id_prova."
        AND avaliacao_prova.id_usuario = ".$id_usuario." ";

        $dao->executeUpdate($query);

        echo $query;
    }



?>