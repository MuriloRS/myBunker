<?php
    session_start();

    $id = $_POST['id'];
    $login = $_POST['login'];
    $email = isset($_POST['email']) ? "padrao" : $_POST['email'];
    $_SESSION['is_login_social'] = true;
    $_SESSION['email'] = $email;

    $senha = md5(gerarSenha());

    $retorno = inserirUsuarioSocial($id, $login, $senha, $email);

    function inserirUsuarioSocial($id, $login, $senha, $email){
        require_once("../model/dao.class.php");

        $dao = new dao("../");

        $query = "SELECT tipo_usuario, nome_login, id FROM usuarios
        WHERE usuarios.id_social = '".$id."' and usuarios.nome_login = '".$login."'";
        
        $select = $dao->executeSelect($query);

        $_SESSION['tipo_usuario'] = $select['tipo_usuario'];
        $_SESSION['login'] = $select['nome_login'];
        $_SESSION['id'] = $select['id'];
        
        $query = "INSERT INTO usuarios(nome_login, email, senha, id_social)
        VALUES('".$login."', '".$email."', '".$senha."', '".$id."')";

        $dao->executeInsert($query);
    }
    function gerarSenha() {

        $tamanho=29;
        $forca=8;

        $vogais = 'aeuy';
        $consoantes = 'bdghjmnpqrstvz';
        if ($forca >= 1) {
            $consoantes .= 'BDGHJLMNPQRSTVWXZ';
        }
        if ($forca >= 2) {
            $vogais .= "AEUY";
        }
        if ($forca >= 4) {
            $consoantes .= '23456789';
        }
        if ($forca >= 8 ) {
            $vogais .= '@#$%';
        }
    
        $senha = '';
        $alt = time() % 2;
        for ($i = 0; $i < $tamanho; $i++) {
            if ($alt == 1) {
                $senha .= $consoantes[(rand() % strlen($consoantes))];
                $alt = 0;
            } else {
                $senha .= $vogais[(rand() % strlen($vogais))];
                $alt = 1;
            }
        }
        return $senha;
    }

?>