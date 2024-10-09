



$(document).on("click",".btn-check", function(){

    if(this.id == "btn-cadastro-turma"){
        $("#turma-cadastrada").prop("disabled",true)
        $("#turma-dados").css("background-color","#e9ecef");
        $(".input-cadastrar-turma").prop("disabled",false)
        // $("#turma-dados").css("color","");
        
    } else {
        $("#turma-cadastrada").prop("disabled",false)
        $("#turma-dados").css("background-color","#fff");
        $(".input-cadastrar-turma").prop("disabled",true)
        // $("#turma-dados").css("color","");
    }

})

$(document).on('change','#turma-cadastrada', function(e){
    
    id_turma = $(this).val()
    
    if(!id_turma){
        $("#turma-dados").empty();
    } else {
        
        $.ajax({
            type: "GET",
            url: "../includes/server.php",
            data: {dados_turma : id_turma},
            success: function (resposta) {
                
                resposta = JSON.parse(resposta)
                
                tabela = "<p> Nome: " + resposta.nome + "</p>"
                tabela += "<p> Curso: " + resposta.curso + "</p>"
                tabela += "<p> Docente: " + resposta.docente + "</p>"
                tabela += "<p> Codigo: " + resposta.codigo + "</p>"
                tabela += "<p> Participantes: " + resposta.participantes_qtd + "</p>"
                
                $("#turma-dados").html(tabela)
            }
        })
    }
})






