<?php

    require_once("app/model/dao.class.php");
    
    require_once("app/model/utils.class.php");

    $dao = new dao("app/");
    $utils = new utils();

    $carousel_provas = '<div class="carousel-item active">';
    $item_prova = '';

    $query = '
        SELECT * from prova_dados
        inner join prova_fotos
        on prova_fotos.id_dados_prova = prova_dados.id
        group by prova_dados.id
        order by prova_dados.data_insercao desc
        limit 15
    ';                

    $contador = 1;

    $select = $dao->executeSelectAssoc($query);

    while($row = mysqli_fetch_assoc($select)){

        if($contador == 6 || $contador == 11){
            $carousel_provas .= '<div class="carousel-item">';
        }

        $carousel_provas .= '<div class="prova-item">
                <h4>'.$utils->cortaString($row['materia'], 22).'</h4>
                <img class="card-img-top img-responsive" src="'.$utils->montaCaminhoImagem($row['universidade'], $row['materia'],$row['foto'], "provas/")
                .'" alt="'.$utils->montaAltImagem($row['universidade'], $row['materia'],$row['foto']).'">
        </div>';
        if($contador == 5 || $contador == 10 || $contador == 15){
            $carousel_provas .= '</div>';
        }

        $contador++;
    }
?>