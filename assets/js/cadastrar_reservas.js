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



function disable_input_turma(btn_radio){
    if(btn_radio.id == "btn-cadastro-turma"){
        
        document.getElementById("turma-cadastrada").setAttribute("disabled","")
        $("#turma-dados").css("background-color","#e9ecef");
        $("#turma-dados").css("color","");
        
        
        
        inp = document.getElementsByClassName("input-cadastrar-turma");
        for (i = 0; i <= 4; i++){
            inp[i].removeAttribute("disabled")
        }
        
        
    } else {
        
        document.getElementById("turma-cadastrada").removeAttribute("disabled")
        inp = document.getElementsByClassName("input-cadastrar-turma");
        $("#turma-dados").css("background-color","#fff");
        $("#turma-dados").css("color","var(--bs-body-color)");

        for (i = 0; i <= 4; i++){
            inp[i].setAttribute("disabled","")
        }
        
        
    }

}


function disableData_fim(select_tipo){
    if(select_tipo.value == "única"){
        document.getElementById("data-fim").setAttribute("disabled","")
        $("#data-fim").val('')

    } else {
        document.getElementById("data-fim").removeAttribute("disabled")
    }
}







