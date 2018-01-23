<?php
    
    if(!isset($_SESSION['tipo_nav'])){
        session_start();
    }

    $tipo = $_SESSION['tipo_nav'];
    $tipo_usuario = isset($_SESSION['tipo_usuario']) ? $_SESSION['tipo_usuario'] : "";

?>

<style>
    /*
    Estilo navbar
    */
    @import url('https://fonts.googleapis.com/css?family=Open+Sans');


    :root {
        --color-nav: #186A3B;
        --admin-color: #581845;
        --admin-color-light: #5c2b4f;
    }

    html,body{
        font-family: 'Open Sans', sans-serif;
    }

    #navbarSupportedContent ul li{
        margin-right: 10px;
    }

    #mainNav{
        background-color: #3e2b69;
        -webkit-box-shadow: 0px 5px 8px -6px rgba(0,0,0,0.75);
        -moz-box-shadow: 0px 5px 8px -6px rgba(0,0,0,0.75);
        box-shadow: 0px 5px 8px -6px rgba(0,0,0,0.75);
    }

    #mainNav .navbar-brand,
    #mainNav a{
        color: white;
    }

    #mainNav .button-entrar{
        
    }

    
    #mainNav .button-entrar{
        color: white;
        background-color: transparent;
        border-color: white;
        box-shadow: none;
        -webkit-border-radius: 3px;
        -moz-border-radius: 3px;
        border-radius: 3px;
        cursor:pointer;
        padding: 5px 15px;
    }
    #mainNav .button-entrar:hover{
        border-color:#d1c8e4;
        color:#d1c8e4;
    }

    #mainNav ul li span{
        font-weight: 500;
    }

    #mainNav .dropdown-menu a{
        color: #3e2b69;
    }

    #botao-dropdown{
        color:white;
    }

    #mainNav ul li span{
        margin-right: 5px;
    }

    #mainNav .dropdown .dropdown-menu a:hover{
        background-color: #3e2b69;
        color: white;
    }

    #mainNav .navbar-toggler{
        background-color: white;
        color: #3e2b69;
        font-weight: 700px;
        font-size: 26px;
        padding: 0px 10px;
        
    }
    

</style>

<script>

    function apaga_sessao(){
        $.ajax({
            url: '../controller/sair.php',
            success: function(data){
            }
  
          });
    }
</script>
<?php

switch($tipo){
    case 1: 
        $ref = "../../";
       
        break;
    case 2:
        $ref = "../../";

        break;
    default:
        $ref = "";
}

?>

<nav id="mainNav" class="navbar fixed-top navbar-expand-lg " >
<div  class="container">
    <?php echo '<a class="navbar-brand" href="'.$ref.'">myBunker</a>';
    
            switch($tipo){
                case 0:
                    navbar_pagina_index();

                    break;
                case 1: 
                    navbar_pagina_usuario();
                   
                    break;
                case 2:
                    navbar_pagina_cadastro();

                    break;
            }

            function navbar_pagina_cadastro(){
                echo '
                <div class="" id="navbarSupportedContent">
                    <ul class="navbar-nav mt-2 mt-lg-0">
                        <li><a href="../../index.php" class="btn btn-link" id="btn-home" >Home</a></li>
                    </ul>
                    </div>
                ';
            }

            function navbar_pagina_index(){
                echo '<div class="" id="navbarSupportedContent">
                <ul class="navbar-nav mt-2 mt-lg-0">
                        <li><a href="app/view/cadastro.php" class="btn btn-link" >Inscrever-se</a></li>
                
                        <li>
                        <button type="button" class="btn btn-primary button-entrar" id="btn-login-modal" data-toggle="modal" data-target="#myModal">
                            Entrar
                        </button>
                        </li>
                    </ul>
                </div>
            
                </div>';
            }

            function navbar_pagina_usuario(){
                $botao_inserir_prova = "";
                $usuario = "";
                if(isset($_SESSION['tipo_usuario'])){
                    $usuario = "<li  ><a href='#' class='btn' >".ucfirst($_SESSION['login'])."</a></li>";

                    if($_SESSION['tipo_usuario'] == 1){
                        $botao_inserir_prova = '<a href="inserir_prova.php" class="dropdown-item" id="btn-inserir">
                        <span class="lnr lnr-upload"></span>Inserir Prova </a> ';
                    }
                }



                echo '<div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item dropdown">
                                    <a id="botao-dropdown" class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                                    '.$_SESSION['login'].'</a>
                                <div class="dropdown-menu">        

                                    '.$botao_inserir_prova.'  

                                    <a class="dropdown-item" href="sugestoes.php">
                                    <span class="lnr lnr-bubble"></span>Sugestões</a>
                                    <div class="dropdown-divider"></div>

                                    <a onclick="apaga_sessao();" href="../../index.php" class="dropdown-item" >
                                        <span class="lnr lnr-power-switch"></span>Sair</a>

                                </div>
                            </li>
                            
                        </ul>
                      </div>
                ';
            }
        ?>


        </div>
        </div>
    </nav>
    

    <div style="margin-top:70px;"></div>