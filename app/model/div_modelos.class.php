<?php

    class div_modelos{

        function div_comentarios($id, $login, $data, $comentario, $tem_resposta){

            $retorno = '
                <li  id="'.$id.'">
                    <button class="btn btn-link">'.$login.'</button>
                    <p >'.$comentario.'</p>

                    <div class="botoes_comentario">
                        <button class="btn btn-link" onclick="executa_botao_resposta('.$id.');" >Responder</button>
                        <span id="campo_data_comentario">'.
                            strftime("%d de %B de %Y", strtotime($data))
                        .'</span>
                    </div>
                    <div class="div_comentarios_respostas" style="width: 150px;"> ';
                    
                        if($tem_resposta){
                            $retorno .= $this->botao_mostrar_respostas($id);
                            $retorno .= $this->botao_esconder_respostas($id);
                        }

                    $retorno .='<div id="div-respostas-'.$id.'" class="div-respostas" >
                        </div>
                            <div id="div-botoes-comentarios-'.$id.'" class="div-botoes-comentarios">
                            </div>
                        </div>
                        <li>';

            return $retorno;
        }

        function botao_mostrar_respostas($id){
            $retorno = '
            <button class="btn btn-link btn-comentario-resposta" onclick="acao_botao_ver_repostas('.$id.');"
            id="btn-comentario-resposta-'.$id.'" >Ver respostas</button>';
    
            return $retorno;
        }

        function botao_esconder_respostas($id){

            $retorno = '
            <button type="button" style="display: none;" class="btn btn-link btn-comentario-resposta" id="btn-esconde-resposta-'.$id.'"
            onclick="acao_botao_esconde_resposta('.$id.');" >Esconder respostas</button>';
    
            return $retorno;
        }

        function painel_mensagem($msg, $tipo){

            $retorno = '';

            if($tipo == 1){
                $retorno = '<div class="alert alert-warning alert-dismissible fade show" role="alert">';
                $retorno .= $msg.'<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
                $retorno .= '<span aria-hidden="true">&times;</span></button></div>';
            }
            if($tipo == 2){
                $retorno = '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
                $retorno .= $msg.'<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
                $retorno .= '<span aria-hidden="true">&times;</span></button></div>';
            }
            if($tipo == 3){
                $retorno = '<div class="alert alert-success alert-dismissible fade show" role="alert">';
                $retorno .= $msg.'<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
                $retorno .= '<span aria-hidden="true">&times;</span></button></div>';
                
            }

            return $retorno;

        }


        //Retorna o código necessário para o botão de login pelo Facebook
        function btn_facebook_login(){
            return "
                <div id='fb-root'></div>
                <script>
                function statusChangeCallback(response) {
                    if (response.status === 'connected') {
                        statusUsuario();
                    }
            
                }
                
                function checkLoginState() {
                    FB.getLoginStatus(function(response) {
                        statusChangeCallback(response);
                    });
                }
            
                function statusUsuario(){
                    FB.api('/me', function(dados) {
                        loginUsuarioFacebook(dados);
                    });
                }
            
                (function(d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id)) return;
                js = d.createElement(s); js.id = id;
                js.src = 'https://connect.facebook.net/pt_BR/sdk.js#xfbml=1&version=v2.11&appId=1968192540168962';
                fjs.parentNode.insertBefore(js, fjs);
                }(document, 'script', 'facebook-jssdk'));
            
                window.fbAsyncInit = function() {
                    FB.init({
                    appId            : '1968192540168962',
                    autoLogAppEvents : true,
                    xfbml            : true,
                    version          : 'v2.11'
                    });
                };
                </script>
            ";
        }

        function modal_login(){
            return '<div class="modal fade bd-example-modal-sm" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog  modal-sm" role="document">
                <div class="modal-content">
                <div class="modal-header ">
                    <h4 class="modal-title text-center" id="exampleModalLabel">Faça seu Login</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                <form id="form-login" action="app/controller/executa_login.php" method="POST">
                        
                        <div class="form-group row">
                            <div class="fb-login-button" style="margin:auto; text-align:center;" data-width="265" data-max-rows="1" data-size="large" 
                            data-button-type="login_with" data-show-faces="false" data-auto-logout-link="false" 
                            data-use-continue-as="false" onlogin="checkLoginState();" ></div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-sm-2 col-form-label">Email </label>
                            <div class="col-sm-10">
                                <input type="text"  name="email" class="form-control" id="email" placeholder="email@exemplo.com">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="senha" class="col-sm-2 col-form-label">Senha </label>
                            <div class="col-sm-10">
                            <input type="password"  class="form-control" placeholder="Sua senha" name="senha" id="senha">
                            </div>
                        </div>

                        <div class="form-group row" >
                        
                            <div class="col-sm-12">
                            <input type="submit" class="btn btn-success btn-block" id="btn-login" value="Entrar" 
                            />
                            </div>
                        </div>
                                                                
                    </form>

                    <div id="mensagem"></div>
                </div>
                <div class="modal-footer justify-content-center ">
                    <p >Não tem uma conta? <a  href="app/view/cadastro.php" target="_blank">Criar Conta</a> </p>
                </div>
                </div>
            </div>
            </div>';
        }

    }

    
?>