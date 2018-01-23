<?php
    session_start();
    
    $provas = $_FILES['prova'];
    $materia = $_POST['materia'];
    $universidade = $_POST['universidade'];
    $ano = $_POST['ano'];

    $mensagem = "";

    if(isset($provas)){

        require_once("../model/dao.class.php");
        require_once("../model/div_modelos.php");

        $obj_dao = new dao("../");
        $modelo = new div_modelos();

        $id_usuario = busca_id_usuario($obj_dao, $_SESSION['login']);

        $diretorio = procura_diretorio_foto($universidade, $materia);
        $diretorio = $diretorio."/";

        if($id_usuario != null){

            $query = "insert into prova_dados(universidade, materia, ano, id_usuario_prova, data_insercao)
            values ('$universidade', '$materia', $ano, $id_usuario, NOW())";
            
            if($obj_dao->executeInsert($query)){
                $mensagem =  $modelo->painel_mensagem("A prova e suas fotos foram inseridas no banco de dados com sucesso
                ",3);
            }
            else{
                $mensagem = $modelo->painel_mensagem("Não foi possível enviar as fotos para o servidor.", 2);
            }

            $id_dados_prova = busca_id_dados_prova($obj_dao);

            for($x = 0; $x < count($provas['type']); $x++){
                    //Retorna o tamanho da extensão -1 para adicionar o novo nome com a extensão;
                    $pos = procura_extensao($provas['name'][$x]);

                    $pos = ($pos-1);

                    $extensao = strtolower(substr($provas['name'][$x], $pos));

                    //Se a extensão do arquivo for de um formato inválido então mostra um aviso
                    if($extensao == ".pdf" || $extensao == ".zip" || $extensao == ".bmp"){
                        $mensagem = "Não foi possível inserir no banco de dados pois uma 
                        ou mais foto contém um extensão inválida (pdf, zip, bmp). 
                        Por favor, só insira no banco de dados arquivos de extensão 
                        pjpeg, jpeg, png e jpg.";


                        echo $modelo->painel_mensagem($mensagem,1);

                        die();
                    }

                    $novo_nome = md5(time()+rand(0,30)).$extensao;
                    
                    move_uploaded_file($provas['tmp_name'][$x], $diretorio.$novo_nome);               
       
                    $query = "INSERT INTO prova_fotos(foto, id_dados_prova) values('$novo_nome', $id_dados_prova)";

                    
                    //Se a inserção das informações da prova foram concluídas com sucesso
                    //então insere o caminho da imagens
                    if($obj_dao->executeInsert($query)){                    
                    }
                    else{

                        $mensagem = $modelo->painel_mensagem("Não foi possível enviar as fotos para o servidor.",2);
                            
                    }

                }
            }

            echo $mensagem;
    }

    function busca_id_usuario($dao, $nome_usuario){
        $query = "SELECT id FROM usuarios
                    WHERE nome_login = '$nome_usuario'";

        
        if($select = $dao->executeSelect($query)){
            return $select['id'];
          
        }
        else {
            return null;
        }
    }

    function busca_id_dados_prova($dao){
        //Monta um select e pega o id da última linha da tabela de prova_dados inserida
        $query = "SELECT id FROM prova_dados ORDER by id DESC LIMIT 1";

        if($select = $dao->executeSelect($query)){
            return $select['id'];
        }
        else {
            return null;
        }
    }

    function procura_diretorio_foto($universidade, $materia){
        require_once("../model/utils.class.php");

        $utils = new utils();

        //Tira os acentos das palavras com o método da classe utils
        $universidade = $utils->tirarAcentos($universidade);
        $materia = $utils->tirarAcentos($materia);

        //Especifica um caminho padrão para as provas
        $caminho = "../../provas/".ucfirst($universidade);

        //Se não existir a pasta no caminho então ele cria a pasta
        if(!is_dir($caminho)){
            mkdir($caminho) or die("erro ao criar diretório no caminho ".$caminho);            
        }

        //Deixa a primeira letra em maiúsculo
        $caminho = $caminho."/".ucfirst($materia);
        
        if(!is_dir($caminho)){
            mkdir($caminho) or die("Erro ao criar o diretório no caminho ".$caminho);
            
        }

        return $caminho;

    }

    function procura_extensao($arquivo){

        if (strrpos($arquivo, 'pjpeg') !== false) {
            return -4;
        }
        else if (strrpos($arquivo, 'jpeg') !== false) {
            return -4;
        }
        else if (strrpos($arquivo, 'png') !== false) {
            return -3;
        }
        else if (strrpos($arquivo, 'bmp') !== false) {
            return -3;
        }
        else if (strrpos($arquivo, 'jpg') !== false) {
            return -3;
        }
        else if (strrpos($arquivo, 'pdf') !== false) {
            return -3;
        }

    }


    


?>