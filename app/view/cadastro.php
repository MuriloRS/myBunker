<?php
    require_once("../model/imports.class.php");

    $import = new imports();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cadastro de Usuário</title>

    <?php $import->importarBootstrapCss() ?>
    <link rel="stylesheet" href="../estilo/index.css">
</head>
<body>
    <?php
    
        if(!isset($_SESSION['tipo_nav'])){
            session_start();
        }

        $_SESSION['tipo_nav'] = 2;

        require_once("nav_bar.php");
    ?>

    <div class="container">

        <div class="row">

            <div class="col-lg-3 col-sm-2"></div>

            <div class="col-lg-6 col-sm-8" id="div-form-cadastro">
                
                <div style="margin-top: 15px;">
                    <h2>Cadastro</h2>
                </div>

                <form id="form-cadastro">
                <div class="form-group">
                        <label for="login-cad">Nome de usuário</label>
                        <input type="text"  class="form-control" id="login-cad" name="login-cad" placeholder="Seu nickname">
                  
                    </div>
                    <div class="form-group">
                        <label for="email-cad">Endereço de email</label>
                        <input type="email"  class="form-control" id="email-cad" name="email-cad" placeholder="Seu melhor email">
                       
                    </div>
                    <div class="form-group">
                        <label for="senha-cad">Senha</label>
                        <input type="password"  class="form-control" name="senha-cad" id="senha-cad" placeholder="Sua senha">
                        
                    </div>
                    <div class="form-group">
                        <label for="senha-rep">Repita sua senha</label>
                        <input type="password"  class="form-control" id="senha-rep" name="senha-rep" placeholder="Repita sua senha">
                       
                    </div>
                    <br>
                    <button type="button" class="btn btn-block" id="btn-cadastro">Cadastrar</button>
                </form>
                
                <div id="aviso-geral">
                </div>


            </div>
            <div class="col-lg-3 col-sm-2"></div>

        </div>
    </div>



    <?php $import->importarBootstrapJs() ?>

    <script src="../javascript/script.js"></script>
</body>
</html>