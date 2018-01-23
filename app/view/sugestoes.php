<?php
    require_once("../model/imports.class.php");
    require_once("../model/div_modelos.class.php");

    $import = new imports();
    $modelo = new div_modelos();

	session_start();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Inserir Prova</title>

    <?php $import->importarBootstrapCss() ?>
    <link rel="stylesheet" href="../estilo/usuario_logado.css">
    <link rel="stylesheet" href="../estilo/sugestoes.css">
</head>
<body>
    <?php
        
        $_SESSION['tipo_nav'] = 1; 
        
        require_once("nav_bar.php"); 
    ?>
    <br>

    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="row">
                    <div class="col-md-12" class="btn-voltar">
                        <a href="usuario_logado.php" class="btn btn-link"  >Voltar</a>
                    </div>
                </div>

            </div>
            <div class="col-md-6" >

                <div class="painel">
                    <?php
                        $msg = "<div class='row'>
                        Se você quer nos sugerir alguma mudança, ferramenta nova ou relatar algum 
                        em nosso site, não tenha vergonha e nos ajude a melhorar o nosso serviço.
                        </div>";
                        echo $modelo->painel_mensagem($msg,1);
                    ?>

                    <form id="form-sugestao">

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="assunto" >Título</label>
                                    <input type="text" class="form-control " name="assunto" id="assunto">
                                </div>

                                <div class="form-group col-md-6">
                                        <label for="tipo_msg" >Assunto</label>
                                        <select name="tipo_msg" id="tipo_msg" class="form-control ">
                                            <option selected value="Reclamacao">Reclamação</option>
                                            <option value="Sugestao">Sugestão</option>
                                            <option value="Erro">Relatar erro</option>
                                        </select>
                                </div>
                            </div>

                            <div class="form-groups">
                                <label for="email" class="col-form-label">Email</label>
                                <input type="email" name="email" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="msg" class="col-form-label">Mensagem</label>
                                <textarea name="msg" id="mensagem_msgconselho" class="form-control"
                                cols="30" rows="5" style="resize:none;"></textarea>
                            </div>  
                            

                            <div class="form-row">
                                <div class="col-md-10"></div>
                                <div class="col-md-2">
                                    
                                    <button type="button" class="btn" id="btn-enviar-sugestao">Enviar</button>
                                </div>
                           
                            </div>
                            
                    </form>

                    <div id="div-resultado-sugestao"></div>
                </div>
            </div>
            <div class="col-md-3"></div>
        </div>

    </div>


    <?php $import->importarBootstrapJs() ?>
    <script src="../javascript/inserir_prova.js"></script>
    <script src="../javascript/sugestoes.js"></script>
</body>
</html>