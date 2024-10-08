$(document).on('submit','#form-consultar-salas',function (e) {
    e.preventDefault()
    
    var form = $(this).serialize()
    
    form += '&consultar=' + 'salas_disponiveis'
    $.ajax({
        url:"../includes/server.php",
        type:"GET",
        data: form,
        beforeSend:function(){
            $("#container-tabela").html("<span>Procurando...</span>")
            $("#container-tabela").css("visibility","visible")
        },
        success:function(response){
            $("#container-tabela").html(response)
        }
    
    })
    
    $(document).on('click','#btn-reservar', function () {
        var id_sala = $(this).val()
        // FORM CADASTRO DA RESERVA
        $(document).on('submit','#cadastrar-reserva', function (e) {
            e.preventDefault()
            
            // COMBINA OS DADOS DA RESERVA COM OS DADOS DA TURMA
            formData = $("#cadastrar-reserva").serialize()
            formData += '&' + form
            formData += '&cadastrar-reserva=true'
            formData += '&id_sala=' + id_sala
            
            $.ajax({
                url:"../includes/server.php",
                type:"POST",
                data: formData,
                success:function(reservasosta){
                    
                    // apaga os inputs do modal cadastrar
                    $("#cadastrar-reserva")[0].reset()
                    
                    // esconde o modal cadastrar
                    $("#cadastrar-reserva-modal").modal('hide')
                    
                    // mostra a mesagem de alerta (resultado do cadastro)
                    $("#modal-alerta-msg").text(reservasosta)
                    
                    // mostra o modal alerta
                    $("#modal-alerta").modal('show')
                    
                }
            })
        })
    })
    
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







