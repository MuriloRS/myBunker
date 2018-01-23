<?php
    require_once("../model/imports.class.php");

    $import = new imports();

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
    <link rel="stylesheet" href="../estilo/inserir_prova.css">
    <link rel="stylesheet" href="../estilo/input_file.css">
</head>
<body>
    <?php
        
        $_SESSION['tipo_nav'] = 1; 
        
        require_once("nav_bar.php"); 
    ?>


<br>
    <div class="container" >
        
        <div class="row">

        <div class="col-md-3">
            <div >
                <a href="usuario_logado.php" class="btn btn-link" id="btn-voltar">
                Voltar</a>
            </div>

        </div>
        
        <div class="col-md-6" id="painel-principal"  >
            <div class="painel">
                <form enctype="multipart/form-data" id="form-inserir-prova">
        
                    <div class="form-group ">
                        <label  class="col-form-label">Sua prova</label>
                        <input type="file"   class="form-control file_customizada" multiple class="form-control-file form-control" name="prova[]" id="provas">
                    </div>

                    <div class="form-group row">
                        <label for="materia" class="col-sm-3 col-form-label">Matéria</label>
                        <div class="col-sm-9">
                            <input type="text"  class="form-control" id="materia" name="materia" placeholder="A matéria da prova">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="universidade" class="col-sm-3 col-form-label">Universidade</label>
                        <div class="col-sm-9">
                            <input type="text"  class="form-control" id="universidade" name="universidade" placeholder="Sua Universidade">
                        </div>
                    </div>  
                
                    <div class="form-group row">
                        <label for="ano" class="col-sm-3 col-form-label">Ano</label>
                        <div class="col-sm-6"></div>
                        <div class="col-sm-3">
                        
                            <input type="number" value="2017"  class="form-control" name="ano" min="1990" max="2018" id="ano">
                        </div>
                    </div>

                </form>
            

                <div style="float: right;">

                    <button class="btn btn-primary" id="btn-enviar">Enviar</button>
                    <br>
                
                </div>
                <br><br>
                <div id="div-resultado"></div>
            </div>
        </div>

        <div class="col-md-3">
        </div>

        </div>
    </div>

    <?php $import->importarBootstrapJs() ?>
    <script src="../javascript/inserir_prova.js"></script>
  
</body>
</html>