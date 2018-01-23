
$(document).ready(function(){
    
        $("#btn-enviar").click(function(){
            
            var universidade = $("#universidade").val();
            var materia = $("#materia").val();
            var ano = $("#ano").val();
            var provas = $("#prova").val();
    
            if(materia != "" && provas != ""){
                
                var myForm = document.getElementById('form-inserir-prova');
                formData = new FormData(myForm);
                formData.append("materia", materia);
                formData.append("ano", ano);
                formData.append("universidade", universidade);

                $.ajax({
                    url: '../controller/inserir_prova_banco.php',
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(data){
                        var retorno = data;
                       
                        //Limpa o campo envio-email
                        document.getElementById("form-inserir-prova").reset();
                            
                        $("#div-resultado").html(data);
                    }
          
                  });
    
            }
            else{
               $("#div-resultado").html('<div class="alert alert-danger alert-dismissible fade show" role="alert">Você precisa preencher todos os campos<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
              
            }
    
        });
    
    });