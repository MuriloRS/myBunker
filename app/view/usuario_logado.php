<?php
    require_once("../controller/busca_provas.php");
    require_once("../model/imports.class.php");

    $import = new imports();

    $tipo_usuario = 0;  

    if(!isset($_SESSION['login']) && !isset($_SESSION['tipo_usuario']) && !isset($_SESSION['email'])){
        header("Location: ../../index.php?erro=1");
    }

    $tipo_usuario = $_SESSION['tipo_usuario'];
    $usuario_login = $_SESSION['login'];

?>
<!DOCTYPE html>
<html lang="pt-br" >
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Página de Usuário</title>

    <?php echo $import->importarBootstrapCss() ?>
    <link rel="stylesheet" href="../estilo/usuario_logado.css">
    <link rel="stylesheet" href="../estilo/input_file.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
</head>
<body>
    <?php 
        if(!isset($_SESSION['tipo_nav'])){
            session_start();
        }
        
        $_SESSION['tipo_nav'] = 1; 
        $_SESSION['login'] = $usuario_login;
        
        require_once("nav_bar.php"); 
    ?>
    
    <div class="container-fluid" style="">

        <div class="row justify-content-md-center" >
            
            <div class="col-md-3 sidebar" id="painel-lateral">

                
                    <div class="row" style="margin:auto; text-align:center; ">
                        <div class="col-3"></div>
                        <div class="col-6">
                            <a  data-toggle="modal" id="btn-envia-prova" data-target="#myModal">Enviar prova</a>
                        </div>
                        <div class="col-3"></div>                        
                    </div>

                    <div class="row">           
                        <div class="col-11" id="div-filtros">
                            <button data-toggle="collapse" data-target="#filtros" id="btn-filtros" class="btn btn-secondary btn-sm">Filtros</button>

                            <div id="filtros" class="collapse">
                                <form id="form-filtro">

                                        <div class="form-group">
                                            <label for="universidade-filtro" class="col-form-label">Universidade</label>
                                            <input type="text" class="form-control form-control-sm" id="universidade-filtro" name="universidade-filtro" >
                                        </div>
                                        <div class="form-group">
                                            <label for="materia-filtro" class="col-form-label">Matéria</label>
                                            <input type="text" class="form-control form-control-sm" id="materia-filtro" name="materia-filtro" >
                                        </div>

                                        
                                        <div class="form-group">
                                            <label for="data-insercao" class="col-form-label">Data de inserção</label>
                                            <select id="data-insercao" class="form-control form-control-sm" name="data-insercao-filtro">
                                            
                                                <option selected value="zero"></option>
                                                <option value="dia">No último dia</option>
                                                <option value="semana">Na última semana</option>
                                                <option value="mes">No último mês</option>
                                                <option value="semestre">No último semestre</option>
                                                <option value="ano">No último ano</option>
                                                
                            
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="data-prova" class="col-form-label">Data da prova</label>
                                            <select id="data-prova" class="form-control form-control-sm" name="data-prova-filtro">
                                                
                                                <option selected value="zero"></option>
                                                <option value="ano">No último ano</option>
                                                <option value="3ano">Nos últimos 3 anos</option>
                                                <option value="5ano">Nos últimos 5 anos</option>
                                                <option value="5+ano">Mais de 5 anos atrás</option>
                                
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="ordenar" class="col-form-label">Ordernar por</label>
                                            <select id="ordenar" class="form-control form-control-sm" name="ordenar-filtro">
                                                <option selected value="dInsercao">Por data de inserção</option>
                                                <option value="dProva">Por data de prova</option>
                                
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <button type="button" class="btn btn-primary" id="btn-procurar">Procurar
                                            <span class="lnr lnr-magnifier"></span></button>
                                            
                                        </div>
                                </form>
                            </div>
                    </div>
                </div>

            </div>

            <div class="col-md-9 offset-md-3 main" id="painel-provas" >
                <div class="row justify-content-center" >
                    <div class="col-11" id="fotos-prova">
                            <?php
                                echo $retorno;
                            ?>
                    </div>

                </div>
            </div>

        </div>
    </div>
    
<!-- Modal -->
<div class="modal fade " id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header ">
        
            <h4 class="modal-title">Envie-nos sua prova</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>

        </div>
        <div class="modal-body">
            <form class="form-horizontal"  enctype="multipart/form-data" id="form-enviar-prova">
            
                <div class="form-group">
                    <label for="prova" class="col-form-label ">Selecione a foto:</label>

                    <div>
                        <input type="file"  name="prova[]" id="prova-env" multiple class="form-control file_customizada" >
                    </div>

                </div>

                <div class="form-group row">
                    <label for="materia" class="col-form-label col-sm-3">Matéria</label>

                    <div class="col-sm-9">
                        <input type="text"  class="form-control" name="materia" id="materia-env" placeholder="Digite o nome da matéria">
                    </div>
                </div>
                
                <div class="form-group row">
                    <label for="universidade" class="col-form-label col-sm-3">Universidade</label>

                    <div class="col-sm-9">
                        <input type="text"  class="form-control" name="universidade" id="universidade-env" placeholder="Digite o nome da Universidade">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="ano" class="col-form-label col-sm-4">Ano da prova</label>

                    <div class="col-sm-5"></div>
                    <div class="col-sm-3">
                    
                        <input type="number" name="ano" value="2017" min="1990" max="2018" id="ano-env"  class="form-control">
                    </div>
                </div>
                
            </form>
            <div id="resul-email"></div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn " id="btn-enviar-foto" >Enviar</button>
            <button type="button" class="btn " data-dismiss="modal" id="btn-cancelar">Cancelar</button>
        </div>
        </div>
    </div>
    </div>

    <div id="modal-prova">
        
    </div>

    <!-- Modal Confirmação de Email -->
    <div class="modal fade " id="modal-confim-email" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-body">
            <div class="form-group row">
                <label for="email" class="col-form-label col-sm-3">Email</label>

                <div class="col-sm-9">
                    <input type="text"  class="form-control" name="email" id="email-conf" placeholder="Preencha com seu e-mail">
                </div>
            </div>

            <div id="resul-confir-email"></div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary" id="btn-confirmar" >Confirmar</button>
            <button type="button" class="btn btn-light" data-dismiss="modal" id="btn-confirmar-cancelar">Cancelar</button>
        </div>
        </div>
    </div>
    </div>

                        
    <?php echo $import->importarBootstrapJs(); ?>
    <script src="../javascript/jquery.zoom.min.js"></script>
    <script src="../javascript/usuario_logado.js"></script>
    
</body>
</html>