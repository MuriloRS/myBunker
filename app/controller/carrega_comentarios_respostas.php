<?php
    session_start();

    require_once("../model/dao.class.php");
    require_once("../model/div_modelos.class.php");

    $modelo = new div_modelos();
    $dao = new dao("../");

    if(isset($_POST['comentario']) && $_POST['inserir_resposta'] == true){
        $query = "INSERT INTO prova_comentario_resposta(id_usuario, comentario, id_comentario)
        VALUES (".$_SESSION['id'].", '".$_POST['comentario']."', ".$_POST['id'].")";

        $dao->executeInsert($query);
    }

    $query = "SELECT prova_comentario_resposta.comentario, usuarios.nome_login FROM prova_comentario_resposta
    INNER JOIN prova_comentario ON (prova_comentario_resposta.id_comentario
    = prova_comentario.id_comentario)
    INNER JOIN usuarios ON (usuarios.id = prova_comentario_resposta.id_usuario)
    WHERE prova_comentario.id_comentario = ".$_POST['id']."";

    $select = $dao->executeSelectAssoc($query);
    
    $retorno = '';

    $retorno .= '<ul>';
    
    while($row = mysqli_fetch_assoc($select)){

        $retorno .= '
            <li id="comentario-resposta-'.$_POST['id'].'" class="comentario-resposta">
                <button class="btn btn-link">'.$row['nome_login'].'</button>
                <p>'.$row['comentario'].'</p>
            </li>
        ';
    }

    $retorno .= "</ul>";
    
    echo $retorno;
?>