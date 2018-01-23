<?php
    require_once("../model/dao.class.php");
    
    session_start();
    $id = isset($_POST['id']) ? $_POST['id'] : "";

    $dao = new dao("../");
   
    $query = "SELECT prova_dados.universidade, prova_dados.materia, prova_dados.ano,
                    prova_fotos.foto, prova_fotos.id_dados_prova, prova_dados.id_usuario_prova,
                    prova_dados.ano, prova_dados.id as 'id_dados'
    FROM prova_dados INNER JOIN prova_fotos 
    ON prova_dados.id = prova_fotos.id_dados_prova 
    WHERE prova_fotos.id_dados_prova = ".$id." ";

    //Executa a query
    $select = $dao->executeSelectAssoc($query);

    //Monta o carousel da prova
    $row_dados_prova = montaCarousel($select);


    //Busca a avaliação que o usuário logado deu para essa prova
    $query = "SELECT * FROM avaliacao_prova 
    WHERE avaliacao_prova.id_prova = ".$id." 
    AND avaliacao_prova.id_usuario = ".$_SESSION['id']." ";

    $avaliacao_select = $dao->executeSelect($query);
    $avaliacao = $avaliacao_select['avaliacao'];

    //Busca os dados do usuário
    $dados_usuario = busca_usuario($row_dados_prova['id_usuario_prova'], $dao);
    //Busca os comentários da prova
    $comentarios = buscaComentarios($row_dados_prova['id_dados'], $dao);
    
    $modal = "";

    //Transforma o $select em um vetor associativo
    $dado_especifico = mysqli_fetch_assoc($select);

    
    //Modal do carousel da prova
    $modal .= '
        <div class="modal"  id="myModalProva" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document" >
            <div class="modal-content" >
                <div class="modal-body" id="modal-prova" style="padding:0;" >
                    
                    <div class="row">
                        <div class="col-7">
                            '.$row_dados_prova["carousel"].'
                        </div>

                        <div class="col-5" id="modal-right">
                      
                            <div class="" id="cabecalho-prova">

                                <div class=" row">
                                    <div class="descricao-cabecalho col-10">
                                        <h4 class="col-12" style="margin-bottom: 0px;">Compartilhado por:  '.$dados_usuario['nome_login'].'<h4>                                 
                                        <h4 class="col-12">Prova de: '.$row_dados_prova['materia'].'<h4>
                                        <h4 class="col-12">Universidade: '.$row_dados_prova['universidade'].'</h4>
                                        <h4 class="col-12">Ano da prova: '.$row_dados_prova['ano'].'</h4>
                                    </div>

                                    <div class="close-cabecalho col-2">
                                        <button  type="button" class="close col-2" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                </div>

                                    <div class="prova-rating row">
                                        <h4 class="col-5">Avalie essa prova: </h4>
                                        
                                        <div class="estrelas col">
                                            <input type="radio" id="cm_star-empty" name="fb" value="" checked/>';
                        
                                            
                                            $style = "";
                                            for($x = 0; $x < 5; $x++){
                                                
                                                if($x < $avaliacao){
                                                    $style = 'item_avav';
                                                }
                                                else{
                                                    $style = "";
                                                }

                                                $modal .= '
                                                <label for="cm_star-'.($x+1).'" ><i class="fa '.$style.'"  ></i></label>
                                                <input type="radio" onclick="atualizaAvaliacaoProva(this.id, '.$id.');" id="cm_star-'.($x+1).'" name="fb" value="'.($x+1).'"/>
                                                ';
                                            }


                                        $modal .= '</div>
                                    </div>
                                    
                            </div>

                            <div class="row" >
                                <div id="comentarios-prova">
                                    <form id="form-comentario">

                                        <div class="form-row">
                                            <div class="col-10">
                                                <textarea placeholder="Sua mensagem" class="form-control form-control-sm " 
                                                style="resize: none" id="comentario-msg" rows="1"></textarea>
                                            </div>
                                            <div class="col-2">
                                                <button  type="button" onclick="envia_comentario('.$row_dados_prova['id_dados'].
                                                ');" id="btn-comentario" class="btn btn-primary btn-sm ">Publicar</button>
                                            </div>
                                        </div>
                                
                                    </form>
                                </div>
                            </div>

                            <div class="row" id="comentarios">
                                '. $comentarios . '
                            </div>
                   
                        </div>
                    </div>

                </div>
            </div>
            </div>
        </div>
    ';


    echo $modal;

    function busca_usuario($id, $dao){
        $query = "SELECT usuarios.nome_login FROM usuarios
        WHERE usuarios.id = $id ";

        return $dao->executeSelect($query);
    }

    function buscaComentarios($id_prova, $dao){
        $retorno_funcao = '';

        $query = "SELECT prova_comentario.id_comentario, comentario, nome_login, prova_comentario.data_postagem
        FROM prova_comentario
        INNER JOIN usuarios ON prova_comentario.id_usuario = usuarios.id
        INNER JOIN prova_dados ON prova_comentario.id_prova_dados = prova_dados.id
        WHERE prova_dados.id = ".$id_prova."";


        $select = $dao->executeSelectAssoc($query);

        $query = "
            SELECT * FROM prova_comentario_resposta
        ";

        return montaComentarios($select, $dao);
    }
    
    function montaComentarios($select, $dao){

        require_once("../model/div_modelos.class.php");

        $modelo = new div_modelos();

        $retorno_comentarios = "<ul>";

        //Set locale para a data ficar no formato padrão brasileiro
        setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8", "portuguese");

        while($row = mysqli_fetch_assoc($select)){
            
            //Select para selecionar as respostas de cada comentário

            $query = "SELECT prova_comentario_resposta.comentario FROM prova_comentario_resposta
            INNER JOIN prova_comentario ON (prova_comentario_resposta.id_comentario
            = prova_comentario.id_comentario)
            INNER JOIN usuarios ON (usuarios.id = prova_comentario_resposta.id_usuario)
            WHERE prova_comentario.id_comentario = ".$row['id_comentario']."";
            
            $select_respostas = $dao->executeSelectAssoc($query);

            $tem_resposta = false;
            
            //Percorre o resultado da query para saber se esse comentario tem respostas
            while($row_respostas = mysqli_fetch_assoc($select_respostas)){
                if($row_respostas != null){
                    $tem_resposta = true;
                    
                    break;
                }
                else{
                    $tem_resposta = false;
                }
            }

            $retorno_comentarios .= $modelo->div_comentarios($row['id_comentario'], $row['nome_login'], 
                                                                $row['data_postagem'], $row['comentario'],
                                                                $tem_resposta);
        
        }

        $retorno_comentarios .= "</ul>" ;

        return $retorno_comentarios;
    }


    function montaCarousel($select){
        require_once("../model/utils.class.php");

        $utils = new utils();

        $row_dados_prova = array();

        $x = 0;
        
        $carousel = '
            <div id="carouselExampleControls" class="carousel" data-ride="carousel">
                <div class="carousel-inner">';
                
                while ($row = mysqli_fetch_assoc($select)){
                    
                    if($x == 0){
                        $carousel .= '<div class="carousel-item active">
                        <div class="zoom">
                            
                            <img class="d-block w-100 " onclick="alert();"  src="'.$utils->montaCaminhoImagem(
                                $row['universidade'], $row['materia'], $row['foto'], "../../provas/").'" alt="'.
                                    $utils->montaAltImagem($row['universidade'], $row['materia'], $row['id_dados_prova'])
                                .'">
                                </div>
                                
                        </div>';
                        
                        $row_dados_prova = $row;
                    }
                    else{
                        $carousel .= '<div class="carousel-item" >
                            <div class="zoom">
                                <img  class="d-block w-100 " onclick="alert();"  src="'.$utils->montaCaminhoImagem(
                                    $row['universidade'], $row['materia'], $row['foto'], "../../provas/").'"  alt="'.
                                    $utils->montaAltImagem($row['universidade'], $row['materia'], $row['id_dados_prova'])
                                .'">
                            </div>
                        </div>';
                    }
                    
                    $x++;
                }

                $teste = ($x == 1) ? "style='display:none;'" : " ";

                $carousel .='
                    </div>
                        <a '.$teste.' class="carousel-control-prev icon" href="#carouselExampleControls" role="button" data-slide="prev">
                            <span  aria-hidden="true">
                            <i class="fa fa-angle-left" aria-hidden="true"></i>
                            </span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a '.$teste.' class="carousel-control-next icon" href="#carouselExampleControls" role="button" data-slide="next">
                            <span  aria-hidden="true"><i class="fa fa-angle-right" aria-hidden="true"></i></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>

                    <script>
                        $(function () {
                            $(".carousel").carousel({
                                interval: 99999,
                                pause: false
                            });
                        
                            $(".zoom").zoom({ on: "click" });
                        });

                    </script>
                    ';

                $row_dados_prova["carousel"] = $carousel;

                return $row_dados_prova;
    }
?>