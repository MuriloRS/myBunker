<?php

    require_once("app/model/imports.class.php");
    require_once("app/controller/provas_pagina_inicial.php");
    require_once("app/model/div_modelos.class.php");

    $modelos = new div_modelos();
    $import = new imports();

    $erro = (isset($_GET['erro']) ? $_GET['erro'] : 0);
    
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>

    <meta charset="UTF-8">
    <title>Bunker</title>
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
    <meta name="HandheldFriendly" content="True">
    <meta name="MobileOptimized" content="320">
    
    <?php echo $import->importarBootstrapCss(); ?>

    <link rel="stylesheet" href="app/estilo/index.css" >
    <link rel="stylesheet" href="app/estilo/font-awesome/css/font-awesome.min.css">
</head>
<body>
    <?php 
        echo $modelos->btn_facebook_login();

        if(!isset($_SESSION['tipo_nav'])){
            session_start();
        }

        $_SESSION['tipo_nav'] = 0;

        require_once("app/view/nav_bar.php"); 
    ?>


    <div id="carousel" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">

            <div class="carousel-item active">
                <img class="d-block w-100 img-fluid" src="app/assets/carousel2.jpg" alt="First slide">

                <div class="carousel-caption d-none d-md-block">
                    <h3></h3>
                    <p></p>
                </div>
            </div>

        </div>
    </div>
    
    
 
        <div id="como_funciona">

            <div class="align-center">
                <h2 >Como funciona</h2>
            </div>
            
            <div id="itens" class="row">

                   
                    <div class="col-lg-4" >
                        <span class="lnr lnr-cog"></span>

                        <p>Você pode procurar por provas da disciplina que deseja e 
                        então comentar, avaliar e compartilhar com seus amigos para 
                        melhorar o ecosistema</p>

                    </div>
                    

                    <div class="col-lg-4" >
                        <span class="lnr lnr-cloud-upload"></span>

                        <p>Compartilhe suas provas conosco, isso pode salvar a pele de outras 
                            pessoas que necessitam do material.</p>

                    </div>
                    
                    <div class="col-lg-4" >
                        <span class="lnr lnr-bubble"></span>

                        <p>Discuta a correção das provas com seus amigos, as vezes pode 
                            não ter ficado claro o desenvolvimento de uma questão.</p>

                    </div>
                 

            </div>
 
    </div>

    
    
        <div id="provas_recentes">
            
            <h2>Provas recentes</h2>

            
            <div id="provas" class="row" >

                <div class="col-lg-1"></div>
                <div class="col-lg-10 col-sm-12">

                <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                   
                    <div class="carousel-inner">
                        <?php echo $carousel_provas ?>
                    </div>

                    <a class="carousel-control-prev " href="#carouselExampleControls" role="button" data-slide="prev">
                        <span class="lnr lnr-chevron-left "></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                        <span class="lnr lnr-chevron-right "></span>
                        <span class="sr-only" >Next</span>
                    </a>

                    
                </div>
                <div class="col-lg-1"></div>
            </div>


        </div>
    </div>    


    <div id="procure_prova">

        <h2>Procure uma prova</h2>

        <div class="row">
            <div class="col-lg-1"></div>

            <div class="col-lg-10 col-md-12 col-sm-12">
              
                <form action="" class="form-inline">
                    
                    <label for="universidade" class="col-form-label col-1" style="margin-right: 15px;">Universidade</label>
                    <input type="text" class="form-control col-4" id="procurar-universidade" >
                              
                    <label for="materia" class="col-form-label col-1" >Matéria</label>
                    <input type="text" class="form-control col-4" id="procurar-materia" >
                 
                    <button type="button" data-toggle="modal" data-target="#myModal" class="btn btn-primary col-2">Procurar
                        <span class="lnr lnr-magnifier"></span></button>
        
                </form>

            </div>

            <div class="col-lg-1"></div>
        </div>
        
    </div>


    <div id="feedbacks">

        <h2>Feedbacks</h2>

        <div class="row">

            <div class="col-lg-1 col-md-1 col-sm-1"></div>

            <div class="col-lg-10 col-md-10 col-sm-10">

                <div id="carouselFeed" class="carousel slide" data-ride="carousel" >

                    <div class="carousel-inner" >
                        
                        <div class="carousel-item active col-10" >
                            
                            <div class="row">


                                <div class="col-lg-3 col-md-3 col-sm-3">
                                    <img src="app/assets/carousel2.jpg" alt="" class="rounded-circle">
                                </div>

                                <div class="col-lg-9 col-md-9 col-sm-9">
                                    <p class="align-middle">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor 
                                    incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud 
                                    exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute 
                                    irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla 
                                    pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia 
                                    deserunt mollit anim id est laborum</p>

                                </div>
                                
                            </div>
                        </div>

                        <div class="carousel-item col-10" >
                            
                            <div class="row">
                                <div class="col-lg-3 col-md-3 col-sm-3">
                                    <img src="app/assets/carousel2.jpg" alt="" class="rounded-circle">
                                </div>

                                <div class="col-lg-9 col-md-9 col-sm-9">
                                    <p class="align-middle">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor 
                                    incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud 
                                    exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute 
                                    irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla 
                                    pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia 
                                    deserunt mollit anim id est laborum</p>

                                </div>
                                
                            </div>
                        </div>
 
                        <div class="carousel-item  col-10" >
                            
                            <div class="row">

                                <div class="col-lg-3 col-md-3 col-sm-3">
                                    <img src="app/assets/carousel2.jpg" alt="" class="rounded-circle">
                                </div>

                                <div class="col-lg-9 col-md-9 col-sm-9">
                                    <p class="align-middle">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor 
                                    incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud 
                                    exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute 
                                    irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla 
                                    pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia 
                                    deserunt mollit anim id est laborum</p>

                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>

                <a class="carousel-control-prev" href="#carouselFeed" role="button" data-slide="prev">
                    <span class="lnr lnr-chevron-left" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>

                <a class="carousel-control-next" href="#carouselFeed" role="button" data-slide="next">
                    <span class="lnr lnr-chevron-right" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>

                
            </div>

            <div class="col-lg-1 col-md-1 col-sm-1"></div>
        </div>
    </div>


    <div id="contato">

        <h2>Contato</h2>

        <div class="row">
            <div class="col-lg-3 col-md-2 col-sm-2"></div>

            <div class="col-lg-6 col-md-8 col-sm-8">
                <form id="form-contato" >
                    
                    <div class="form-group row">

                        <label for="nome-contato" class="col-sm-3 col-md-3 col-lg-3 col-form-label">Nome
                        <span style="color: rgb(220,53,69)">*</span>
                        </label>

                        <div class="col-sm-9 col-md-9 col-lg-9">
                            <input type="nome-contato" class="form-control" id="nome-contato" >
                            <div id="invalid-n" class="form-text text-danger">
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="email-contato" class="col-sm-3 col-md-3 col-lg-3 col-form-label">Email
                        <span style="color: rgb(220,53,69)">*</span>    
                        </label>
                        <div class="col-sm-9 col-md-9 col-lg-9">
                            <input type="email-contato" class="form-control" id="email-contato" >
                            <div id="invalid-email" class="form-text text-danger">
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label for="assunto-contato" class="col-sm-3 col-md-3 col-lg-3 col-form-label">Assunto</label>
                        <div class="col-sm-9 col-md-9 col-lg-9">
                            <input type="assunto-contato" class="form-control" id="assunto-contato" >
                            <div id="invalid-assunto" class="form-text text-danger">
                            </div>

                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="msg-contato" id="label-msg" class="col-sm-3 col-md-3 col-lg-3 col-form-label">
                            Mensagem
                            <span style="color: rgb(220,53,69)">*</span>
                        </label>
                        
                        <div class="col-sm-9 col-md-9 col-lg-9">
                            <textarea type="msg-contato" class="form-control" id="msg-contato" rows="5" 
                            style="resize: none;"></textarea>
                            <div id="invalid-msg" class="form-text text-danger">
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <button type="button" id="btn-contato" class="btn btn-primary" >Enviar <i class="fa fa-paper-plane" aria-hidden="true"></i></button>
                        </div>
                    </div>
                
                </form>


                <div style="display: none;" class="alert alert-success" role="alert" id="mensagem-contato">
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-2"></div>
    </div>


    <footer id="rodape">
        
        <div class="container">

            <div class="row">
                <div class="col-lg-3 col-md-4 ">
                    <span>&copy 2018 - myBunker<span>
                </div>

                <div class="col-lg-6 col-md-4">
                
                </div>

                <div class="col-lg-3 col-md-4">
                    <ul>
                        <li><a href="#"><img src="app/assets/facebook.png" alt=""></li></a>
                        <li><a href="#"><img src="app/assets/whats.png" alt=""></li></a>
                        <li><a href="#"><img src="app/assets/insta.png" alt=""></li></a>
                        
                    </ul>

                </div>
            </div>

        </div>

    </footer>
    
    <?php 
        echo $modelos->modal_login();

        echo $import->importarBootstrapJs(); 

        //Mostra o erro na hora do login
        require_once("app/model/div_modelos.class.php");

        $modelo = new div_modelos();

        $mensagem = '';
        if($erro == 2){
            $mensagem = 'Email ou senha estão incorretos.';
            echo "
            <script>
                $('#mensagem').html('".$modelo->painel_mensagem($mensagem, 2)."');
                $('#myModal').modal();         
            </script>
            ";
        }
        else if($erro == 3){
            $mensagem = 'Preencha todos os campos.';

            echo "
            <script>
                $('#mensagem').html('".$modelo->painel_mensagem($mensagem, 2)."');
                $('#myModal').modal();         
            </script>
            ";
        }
            
    ?>
    <script src="app/javascript/script.js"></script>
</body>
</html>