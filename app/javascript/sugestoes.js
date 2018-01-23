$(document).ready(function () {

    $("#btn-enviar-sugestao").click(function(){

        $.ajax({
            url: "../controller/envia_email_contato.php",
            method: "POST",
            data: $("#form-sugestao").serialize(),
            success: function(data){
                
                if(data == ""){
                    var mensagem = "<p style='color:green;'> Mensagem enviada com sucesso!</p>";
                }
                else{
                    var mensagem = "<p style='color:red;'> Erro no envio da mensagem, verifique os campos preenchidos!</p>";
                }

                $("#div-resultado-sugestao").html(mensagem);

                    setTimeout(function(){
                        $("#div-resultado-sugestao").html("");
                    }, 6000);
            }
        });
    });
});