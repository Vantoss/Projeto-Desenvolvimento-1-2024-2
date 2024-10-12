
$(".modal").modal({
    keyboard: false,
    backdrop: 'static'
})



// modal = document.getElementById("cadastrar-reserva-modal");
// modal.addEventListener('hidden.bs.modal', event => {
//     $(".input-cadastrar-turma").val("")
//     $("#turma-cadastrada").val("")
//     $("#turma-dados").empty()
//   })



// MODAL CADASTRAR/EDITAR RESERVA/TURMA
$(document).on("click",".btn-check", function(){

    if(this.id == "btn-cadastro-turma" || this.id == "btn-editar-turma"){ 
        $("#turma-cadastrada").prop("disabled",true)
        $("#turma-dados").css("background-color","#e9ecef");
        $(".inp-dados-turma").prop("disabled",false)
    } else {
        $("#turma-cadastrada").prop("disabled",false)
        $("#turma-dados").css("background-color","#fff");
        $(".inp-dados-turma").prop("disabled",true)
    }

})

// MODAL CADASTRAR RESERVA: CONTAINER INFORMACOES TURMA
$(document).on('change','#turma-cadastrada', function(e){
    
    id_turma = $(this).val()
    
    if(!id_turma){

        $("#turma-dados").empty()
        
    } else {

        $.ajax({

            type: "GET",
            url: "../includes/server.php",
            data: {dados_turma : id_turma},
            success: function (resposta) {
                
                let objTurma = JSON.parse(resposta)
                dados = "<p> Nome: " + objTurma.nome + "</p>"
                dados += "<p> Curso: " + objTurma.curso + "</p>"
                dados += "<p> Docente: " + objTurma.docente + "</p>"
                dados += "<p> Codigo: " + objTurma.codigo + "</p>"
                dados += "<p> Participantes: " + objTurma.participantes_qtd + "</p>"
            
            $("#turma-dados").html(dados)
        }
    })
    }
})

// OPTIONS TURMAS 
function optionsTurmas(turno){
    $("#turma-cadastrada").empty();
        $.ajax({
            type: "GET",
            url: "../JSON/dados_turmas.json",
            dataType: "json",
            success: function (dadosJSON) {
                msg = dadosJSON.msg
                let turmaEncontrada = false

                if(dadosJSON.status == 200){

                    options = '<option value="" selected="">Selecione uma turma</option>'
        
                    turmas = dadosJSON.turmas

                    turmas.forEach((turma) => {
                        
                        if(turma.turno == turno){
                            turmaEncontrada = true
                            options += '<option value="' + turma.id_turma +'">' + turma.nome + " - " + turma.turno + '</option>'
                        }
                    })
                }

                if(!turmaEncontrada) { options = '<option value="" selected="">Nenhuma turma cadastrada</option>'}
                    
                $("#turma-cadastrada").html(options)

            }
        })
    
}

function converterData(data){

    date = new Date (data + ' 00:00')
        
    const formatter = new Intl.DateTimeFormat('pt-BR', { dateStyle: 'short' })
    
    return data = formatter.format(date)
}


