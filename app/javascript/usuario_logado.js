$(document).ready(function () {

    //Tira o efeito de passar os slides do carousel
    $('.carousel').carousel({
        pause: true,
        interval: false
    });

    $("#btn-confirmar").click(function(){

        var email = $("#email-conf").val();

        $.ajax({
            url: "../controller/confirmar_email.php",
            method: "GET",
            data: {"email":email},
            success: function(data){
                $("#resul-confir-email").html(data);

                $("#div-confirm-email").html("");
            }
        });
    });

    $("#btn-procurar, #btn-vermais").on('click', function (e) {
        e.preventDefault();

        var myForm = document.getElementById('form-filtro');
        formData = new FormData(myForm);
        formData.append("is_busca", 'false');

        $.ajax({
            url: '../controller/busca_provas.php',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (data) {

                $("#fotos-prova").html(data);

            }
        });
    });

    $("#btn-enviar-foto").on('click', function (e) {

        e.preventDefault();

        var materia = $("#materia-env").val();
        var ano = $("#ano-env").val();
        var universidade = $("#universidade-env").val();

        //Cria um objeto do tipo FormData para enviar por ajax a imagem e os campo matéria e ano
        var myForm = document.getElementById('form-enviar-prova');
        formData = new FormData(myForm);
        formData.append("materia", materia);
        formData.append("ano", ano);
        formData.append("universidade", universidade);

        if (materia != "" && $("#prova-env").val() != "") {

            //Requisição ajax para enviar a prova para o banco de dados
            $.ajax({
                url: '../Controller/verifica_arquivos.php',
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (data) {
                    if (data == "1") {
                        //Quer dizer que esta todo certo com as imagens e agora é só enviar para o email
                        enviar_email_prova(formData);
                    } else if (data == "0") {
                        $("#resul-email").html('<div class="alert alert-danger alert-dismissible fade show" role="alert">Algum erro ocorreu com o upload das suas imagens, verifique o formato das fotos.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button> </div>');

                    }
                }

            });

        } else {
            $("#resul-email").html('<div class="alert alert-danger alert-dismissible fade show" role="alert">Você precisa preencher todos os campos.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button> </div>');
        }

    });

});

function atualizaAvaliacaoProva(id, id_prova){
    var rating = id.split("-")
    

    $.ajax({
        url: '../controller/salva_rating_prova.php',
        method: 'POST',
        data: {
            "id_prova": id_prova,
            "rating" : rating[1]
        },
        success: function (data) {
            
        }
    });

}


function envia_comentario(id_prova) {
    var msg = $("#comentario-msg").val();

    if (msg.length > 300) {
        alert("O comentário não pode ultrapassar o limite de 300 caracteres.");

        return;
    }
    if (msg.length == 0) {
        return
    }

    $.ajax({
        url: '../controller/envia_comentario.php',
        method: 'POST',
        data: {
            "comentario": msg,
            "id_prova": id_prova
        },
        success: function (data) {

            document.getElementById("form-comentario").reset();
            $("#comentarios ul").prepend(data);

            if (data == "1") {
                $("#form-comentario").append(data);
            }
        }
    });
}

function executaModal(id) {

    $.ajax({
        url: "../controller/busca-modal-prova.php",
        method: "POST",
        data: {
            "id": id
        },

        success: function (data) {
        
            $("#modal-prova").html(data);
            $('#myModalProva').modal('show');

        }
    });
}

function enviar_email_prova(formData) {

    //Requisição ajax para enviar a prova para o banco de dados
    $.ajax({
        url: '../controller/envia_email_gmail.php',
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (data) {

            if (data == "") {

                $("#resul-email").html('<div class="alert alert-success alert-dismissible fade show" role="alert">Seu email foi enviado com sucesso.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            } else {
                $("#resul-email").html('<div class="alert alert-danger alert-dismissible fade show" role="alert"> Não foi possível enviar seu email<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            }
        }
    });
}

function executa_botao_resposta(id_comentario) {
    var campo_responder = "";

    campo_responder += "    <div class='row'>";
    campo_responder += "        <textarea placeholder='Adicione sua resposta' class='form-control form-control-sm responder-msg' ";
    campo_responder += "        style='resize: none' rows='1' id='responder-msg-"+id_comentario+"'></textarea>";
    campo_responder += "    </div>";

    campo_responder += "    <div class='row'>"
    campo_responder += "        <span class='col-5'></span> ";
    campo_responder += "        <button type='button'  class='btn btn-default btn-sm col-3 btn-cancelar'";
    campo_responder += "        onclick='acao_btn_cancelar(" + id_comentario + ");'>Cancelar</button>";
    campo_responder += "        <button type='button'  class='btn btn-primary btn-sm col-3 btn-responder'";
    campo_responder += "        onclick='acao_btn_responder("+ id_comentario +")' >Responder</button>";
    campo_responder += "    </div>";

    $("#div-botoes-comentarios-" + id_comentario).html(campo_responder);
    
    $("#responder-msg-"+id_comentario).focus();
}

function carregarComentarios(id_resposta){
    
        $.ajax({
            url: '../controller/carrega_comentarios_respostas.php',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (data) {
                $("#btn-comentario-resposta-"+id_resposta).css("display", "none");
                
                $("#btn-esconde-resposta-"+id_resposta).css("display", "block");
    
                $("#div-respostas-"+id_resposta).html(data);
            }
        });
    }

// FUNÇÕES BOTÕES COMENTÁRIOS
function acao_btn_cancelar(id_comentario) {

    $("#div-botoes-comentarios-" + id_comentario).html("");
}

function acao_btn_responder(id_comentario){
    var myForm = document.getElementById('form-enviar-prova');

    formData = new FormData();
    formData.append("id", id_comentario);
    formData.append("comentario", $("#responder-msg-"+id_comentario).val());
    formData.append("inserir_resposta", true);
    
    $.ajax({
        url: '../controller/carrega_comentarios_respostas.php',
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (data) {

            
            $("#responder-msg-"+id_comentario).val('');
            $("#responder-msg-"+id_comentario).attr("placeholder", "Adicione sua resposta");
            $("#div-respostas-"+id_comentario).html("<ul class='respostas'>"+data+"</ul>");
        }
    });
}

function acao_botao_ver_repostas(id_resposta){

    formData = new FormData();
    formData.append("id", id_resposta);
    formData.append("inserir_resposta", false);

    carregarComentarios(id_resposta);
}

function acao_botao_esconde_resposta(id_resposta){
    
    $("#btn-comentario-resposta-"+id_resposta).css("display", "block");
    $("#btn-esconde-resposta-"+id_resposta).css("display", "none");
    
    $("#div-respostas-"+id_resposta).html("");
}

