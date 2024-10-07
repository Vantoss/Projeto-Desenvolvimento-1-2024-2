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
                
                conteudo = "<p> Nome: " + resposta.nome + "</p>"
                conteudo += "<p> Curso: " + resposta.curso + "</p>"
                conteudo += "<p> Docente: " + resposta.docente + "</p>"
                conteudo += "<p> Codigo: " + resposta.codigo + "</p>"
                conteudo += "<p> Participantes: " + resposta.participantes_qtd + "</p>"
                
                $("#turma-dados").html(conteudo)
                
            }
        })
    }
    
})


$(document).on("click",".btn-check", function(){

    if(this.id == "btn-cadastro-turma"){
        $("#turma-cadastrada").prop("disabled",true)
        $("#turma-dados").css("background-color","#e9ecef");
        $("#turma-dados").css("color","");
        $(".input-cadastrar-turma").prop("disabled",false)
        
    } else {
        $("#turma-cadastrada").prop("disabled",false)
        $(".input-cadastrar-turma").prop("disabled",true)
        $("#turma-dados").css("background-color","#fff");
        $("#turma-dados").css("color","#e9ecef");
    }

})



function disableData_fim(select_tipo){
    if(select_tipo.value == "única"){
        document.getElementById("data-fim").setAttribute("disabled","")
        $("#data-fim").val('')

    } else {
        document.getElementById("data-fim").removeAttribute("disabled")
    }
}







