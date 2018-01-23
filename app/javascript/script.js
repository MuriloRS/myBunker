$(document).ready(function(){
    $('#carouselExampleControls').carousel({
        pause: true,
        interval: false
    });

    $("#btn-cadastro").click(function(){

        var email = $("#email-cad").val();
        var senha = $("#senha-cad").val();
        var login = $("#login-cad").val();
        var senha_rep =$("#senha-rep").val();
        
        var retorno = valida_campos(email, senha, senha_rep, login);
           
            $.ajax({
                url: '../controller/cadastra_usuario.php',
                method: 'POST',
                data: $("#form-cadastro").serialize(),
                success: function(data){
                    
                    if(retorno == ""){
                        //Limpa o formulário
                        document.getElementById("form-cadastro").reset();
                    }
                    else{
                        data = "";
                        data = '<div class="alert alert-warning alert-dismissible fade show" role="alert">';
                        data += retorno+'<button type="button" class="close" data-dismiss="alert" aria-label="Close">'
                        data += '<span aria-hidden="true">&times;</span></button></div>';
                    }

                    $("#aviso-geral").html(data); 
     
                }
              });
    });

    $("#btn-contato").click(function(){

        var nome = $("#nome-contato").val();
        var email = $("#email-contato").val();
        var assunto = $("#assunto-contato").val();
        var msg = $("#msg-contato").val();

        if(validacao_formulario_contato(nome, email, assunto, msg)){

            $.ajax({
                url: 'app/controller/envia_email_contato.php',
                method: 'POST',
                data: {'nome':nome, 'email':email, 'assunto':assunto, 'msg':msg},
                success: function(data){
                    if(data.length == 0){
                        $("#mensagem-contato").html("Email enviado com sucesso!");
                    }else{
                        $("#mensagem-contato").html(data);
                    }
                    $("#mensagem-contato").css("display","block");
                }
            });


            setTimeout(function(){
                $("#mensagem-contato").css("display","none");
              }, 6000);
        }

    });


});

function loginUsuarioFacebook(response){
    formData = new FormData();

    formData.append("id", response.id);
    formData.append("login", response.name);
    formData.append("email", response.email);
    formData.append("is_login_social", true);

    $.ajax({
        url: 'app/controller/login_social.php',
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (data) {
        
            window.location.href = "app/view/usuario_logado.php";
           
        }
    });
}

function validacao_formulario_contato(nome, email, assunto, msg){
    var mensagem = "";
    var enviar_email = false;

    //Validação do nome
    if(nome.length == 0 || nome.length > 15){
  
        $("#nome-contato").css("border-color", "rgb(220,53,69)");
        $("#invalid-n").css("font-size", "13px");

        if(nome.length == 0){

            mensagem = "Você precisa preencher o campo nome";
        }
        else if (nome.length > 15){
            mensagem = "O campo nome deve ter no máximo 15 caracteres";
        }

        if(mensagem != ""){
            $("#invalid-n").html(mensagem);

            enviar_email = false;
        }
        else{
            $("#invalid-n").html("");
            $("#nome-contato").css("border-color", "#efefef");

            enviar_email = true;
        }
        
    }

    mensagem = "";
    //validação email
    if (is_email(email)){
        if(email.length > 50){
            mensagem = "O campo email pode ter no máximo 50 caracteres";
        }
    }
    else{
        mensagem = "Esse não é um email válido."
    }

    if(mensagem != ""){
        $("#email-contato").css("border-color", "rgb(220,53,69)");
        $("#invalid-email").css("font-size", "13px");
        $("#invalid-email").html(mensagem);

        enviar_email = false;
    }
    else{
        $("#email-contato").css("border-color", "#efefef");
        $("#invalid-email").html("");

        enviar_email = true;
    }

    mensagem = "";
    //validacao do assunto
    if(assunto.length > 50){
        mensagem = "O assunto do email não pode conter mais que 50 caracteres.";
    }

    if(mensagem != ""){
        $("#assunto-contato").css("border-color", "rgb(220,53,69)");

        $("#invalid-assunto").css("font-size", "13px");
        $("#invalid-assunto").html(mensagem);
        enviar_email = false;
    }
    else{
        $("#assunto-contato").css("border-color", "#efefef");
        $("#invalid-assunto").html("");
        enviar_email = true;
    }


    mensagem = "";

    //validação da mensagem
    if(msg.length == 0){
        mensagem = "O campo mensagem precisa ser preenchido";
    }
    if(msg.length > 300){
        mensagem = "O campo mensagem pode ter no máximo 300 caracteres";
    }

    if(mensagem != ""){
        $("#msg-contato").css("border-color", "rgb(220,53,69)");

        $("#invalid-msg").css("font-size", "13px");
        $("#invalid-msg").html(mensagem);

        enviar_email = false;
    }
    else{
        $("#assunto-msg").css("border-color", "#efefef");
        $("#invalid-msg").html("");

        enviar_email = true;
    }


    return enviar_email;
}

function valida_campos(email, senha, senha_rep, login){
    var retorno = "";

    if(senha == "" || senha_rep == "" || email == "" || login == ""){
        retorno = "Você precisa preencher todos os campos";    
    }
    else{
        if(senha != senha_rep ){
            retorno = retorno + "As senhas precisam ser iguais.";
        }
        if(senha.length < 6){
            retorno = (retorno != "") ? "Sua senha precisa ter no mínimo 7 caracteres " :", sua senha precisa ter no mínimo caracteres no mínimo";
        }
        if(senha.length > 25){
            retorno = (retorno != "") ? "Sua senha precisa ter no máximo 25 caracteres " :", sua senha precisa ter no máximo caracteres no mínimo";
        }
        if(login.length > 30){
            retorno = (retorno != "") ? "Seu login não pode ultrapassar 15 caracteres ":
            ", seu login não pode ultrapassar 15 caracteres "
        }
        if(is_email(email) == false){
            retorno = (retorno != "") ? "Seu email é inválido" :", seu email é inválido";
        }
    }

    return retorno;
}


function is_email(email){
    er = /^[a-zA-Z0-9][a-zA-Z0-9\._-]+@([a-zA-Z0-9\._-]+\.)[a-zA-Z-0-9]{2,3}/; 
    if( !er.exec(email) )
    {
        return false;
    }
    else{
        return true;
    }
}