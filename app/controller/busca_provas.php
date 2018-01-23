<?php
        session_start();    

        //Importa os arquivos necessários
        require_once("../model/dao.class.php");
        require_once("../model/utils.class.php");

        
        //Instancia os objetos
        $dao = new dao("../");
        $utils = new utils();

        //Popula as variáveis com o conteúdo do formulário de filtro
        $universidade = isset($_POST['universidade-filtro'])? $_POST['universidade-filtro']: "";
        $materia = isset($_POST['materia-filtro'])? $_POST['materia-filtro']: "";
        $data_insercao = isset($_POST['data-insercao-filtro'])? $_POST['data-insercao-filtro']: "";
        $data_prova = isset($_POST['data-prova-filtro'])? $_POST['data-prova-filtro']: "";
        $ordenar = isset($_POST['ordenar-filtro'])? $_POST['ordenar-filtro']: "";

        $x = 0;
        $j = 1;
        $max = 8;

        if(isset($_POST['is_busca']) && $_POST['is_busca'] == 'false' && isset($_SESSION['n-provas'])){
            $max = $_SESSION['n-provas'];
            $max = $max+$max; 
        }

        //Monta a query de acordo com os filtros
        $query = montaQueryFiltros($universidade, $materia, $data_insercao, $data_prova, $ordenar, $max);
         
        //Executa a query
        $select = $dao->executeSelectAssoc($query);
                 
        $row = array(); 

        $id_foto = "";
        $retorno = "";

        //Mostra uma mensagem caso o usuário não tenha endereço de email confirmado.
        if(!isset($_SESSION['email'])){
            require_once("../model/div_modelos.class.php");

            $modelos = new div_modelos();

            $mensagem = "Você precisa confirmar seu endereço de e-mail para nos enviar provas. ";
            $mensagem .= "<a href='#' data-toggle='modal' ";
            $mensagem .= "data-target='#modal-confim-email'>confirmar e-mail</a>";

            $retorno .= "<div id='div-confirm-email'>";
            $retorno .= $modelos->painel_mensagem($mensagem,1);
            $retorno .= "</div>";
        }

        //Percorre as linhas do retorno da query
        while ($row = mysqli_fetch_assoc($select)){
            
            //Se x for igual a zero ou divisível por 3 então escreve a row 
            if($x == 0 || ($x % 4 == 0)){
                $retorno .= "<div class='row' style='margin-bottom:20px;'>\n";
            }

            //Monta o src para a imagem
            $caminho = $utils->montaCaminhoImagem($row['universidade'], $row['materia'], $row['foto'], "../../provas/");

            //Monta o alt da imagem
            $alt = $utils->montaAltImagem($row['universidade'], $row['materia'], $row['id_foto']);
            
            $id_foto = $row['id_dados'];
            $materia = $row['materia'];

            //Monta o card do bootstrap
            $retorno .= '
                <div class="col-3 "> 
                <a  id="'.$id_foto.'" class="class-prova" onclick="executaModal('.$id_foto.')">
                    <div class="card" >
                        <div class="card-body align-middle" style="height: 50px; max-height: 50px; display:table;">
                            <h3 style="display:table-cell">'.$materia.'</h3>
                        </div>
                        <img src="'.$caminho.'" alt="'.$alt.'">
                                                        
                    </div>
                </a>
                </div>
            ';
            
            //Escreve o fechamento da row depois de 4 cards
            if($x != 0 && ($j % 4 == 0)){
                $retorno .= "</div>\n";
                $retorno .= "";
            }

            //incrementa as variáveis auxiliares
            $x++;
            $j++;  

            //Se x for maior que max então atualiza n-provas e coloca o botão ver mais na tela 
            //e para o while
            if($x > $max-1){
                $_SESSION['n-provas']= $max;
                $retorno .= "<div style='text-align:center;'>
                                <a class='btn btn-danger' id='btn-vermais'>Ver mais</a>
                             </div>";
            }
        }
        
        if(isset($_POST['is_busca']) && $_POST['is_busca'] == 'false'){
         
            echo $retorno;    
            
        }



    function montaQueryFiltros($universidade, $materia, $data_insercao, $data_prova, $ordenar, $max){
        
        $query = "SELECT prova_dados.id as 'id_dados', prova_dados.universidade, prova_dados.materia, prova_fotos.foto, prova_fotos.id as 'id_foto'
        FROM prova_dados INNER JOIN prova_fotos ON (prova_fotos.id_dados_prova = prova_dados.id)";
        
        $is_and = false;

        $where = "";
        $order = "";


        if($universidade != ""){
            
            $where .= "prova_dados.universidade = '$universidade'";

            $is_and = true;
        }
        if($materia != ""){
            $where .= ($is_and == true) ? " and " : "";
            $where .= "prova_dados.materia = '$materia'";

            $is_and = true;
        }
        if($data_insercao != "" && $data_insercao != "zero"){

            if($data_insercao == "zero"){
                $where .= "";
            }else{
                $where .= ($is_and == true) ? " and " : "";
            }
            

            switch($data_insercao){
                case "dia":
                    $where .= " prova_dados.data_insercao > date_sub(prova_dados.data_insercao, INTERVAL 1 DAY) ";
                    
                    break;
                case "semana":
                    $where .= " prova_dados.data_insercao > date_sub(prova_dados.data_insercao, INTERVAL 7 DAY) ";
                    
                    break;
                case "mes";
                    $where .= " prova_dados.data_insercao > date_sub(prova_dados.data_insercao, INTERVAL 1 MONTH) ";
                    
                    break;
                case "semestre":
                    $where .= " prova_dados.data_insercao > date_sub(prova_dados.data_insercao, INTERVAL 6 MONTH) ";
                    
                    break;
                case "ano":
                    $where .= " prova_dados.data_insercao > date_sub(prova_dados.data_insercao, INTERVAL 1 YEAR) ";
                    
                    break;
            }
            
            

            $is_and = true;
        }
        if($data_prova != "" && $data_prova != "zero"){
            if($data_insercao == "zero"){
                $where .= "";
            }else{
                $where .= ($is_and == true) ? " and " : "";
            }
            
            switch($data_prova){

                case "ano":
                    $where .= "prova_dados.ano > date_sub(NOW(), INTERVAL 1 YEAR)";
                    break;
                case "3ano":
                    $where .= "prova_dados.ano > date_sub(NOW(), INTERVAL 3 YEAR)";
                    break;
                case "5ano":
                    $where .= "prova_dados.ano > date_sub(NOW(), INTERVAL 5 YEAR)";
                    break;
                case "5+ano":
                    $where .= "prova_dados.ano > date_sub(NOW(), INTERVAL 99 YEAR)";
                    break;
            }

            $is_and = true;
        }


        if($is_and){
            $query .= " WHERE ".$where;
        }

        $query .= " GROUP BY prova_fotos.id_dados_prova ";

        if($ordenar != ""){
            $query .= " ORDER BY ";
            $query .= ($ordenar == "dInsercao") ? "prova_dados.data_insercao" : "prova_dados.ano";
        }
         
        if($max != 0){
            $query .= " LIMIT ".$max;
        }

        return $query;
    }


?>