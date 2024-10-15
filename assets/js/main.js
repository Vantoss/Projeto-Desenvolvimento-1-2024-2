// DEFININDO COMPORTAMENTO DOS MODAIS
$(".modal").modal({
    keyboard: false,
    backdrop: 'static'
})

// LIMPAR DADOS DO MODAL EDITAR E CADASTRAR QUANDO O MODAL SUMIR (hidden.bs.modal)
// modal = (document.getElementById("modal-editar")) ? document.getElementById("modal-editar") : document.getElementById("cadastrar-reserva-modal")
// modal.addEventListener('hidden.bs.modal', () => {
//     $(".inp-dados-turma").val("")
//     $("#turma-cadastrada").val("")
//     $("#turma-dados").empty()
// })



// MODAL CADASTRAR/EDITAR RESERVA: DESABILITANDO OS INPUTS COM BASE NA OPCAO SELECIONADA (CADASTRAR E EDITAR TURMA/ESCOLHER TURMA)
$(document).on("click",".btn-check", function(){

    if(this.id == "btn-cadastro-turma" || this.id == "btn-editar-turma"){ 
        $("#btn-trocar-turma").prop("checked",false)
        $("#turma-cadastrada").prop("disabled",true)
        $("#turma-dados").css("background-color","#e9ecef");
        $(".inp-dados-turma").prop("disabled",false)
        $("#turma-cadastrada").val("")
        $("#turma-dados").empty()
    } else {
        $("#btn-editar-turma").prop("checked",false)
        $("#turma-cadastrada").prop("disabled",false)
        $("#turma-dados").css("background-color","#fff");
        $(".inp-dados-turma").prop("disabled",true)
        
    }

})


$(document).on("click",".btn-check", function(){
    if(this.id == "btn-cadastro-turma")
    
    $("btn-cadastro-turma").prop("checked",false)
})

// MODAL CADASTRAR/EDITAR RESERVA: CONTAINER INFORMACOES TURMA
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
                dados += "<div class='d-grid gap-3 d-md-flex justify-content-md-center edit-del-turma'>"
                dados += "<button type='button' class='btn btn-primary'value='"+ objTurma.id_turma +"'>Editar</button>"
                dados += "<button type='button' class='btn btn-danger btn-deletar-turma' value='"+ objTurma.id_turma +"'>Deletar</button>"
                dados += "</div>"

            $("#turma-dados").html(dados)
        }
    })
    }
})

// MODAL CADASTRAR/EDITAR RESERVA: OPCOES DE TURMA PARA ESCOLHER/TROCAR NA RESERVA
function optionsTurmas(turno){
    $("#turma-cadastrada").empty()

    fetch("../JSON/dados_turmas.json",{cache: 'no-store'})
        .then((res) => {
            if (!res.ok) {
                throw new Error
                    (`HTTP error! Status: ${res.status}`);
            }
            return res.json();
            })
        .then((dadosJSON) => {

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
        })
        .catch((error) =>
            console.error("Unable to fetch data:", error));
}
        


// CONVERTE DATA NO FORMATO "Y-m-d" PARA O FORMATO "d/m/Y"
function converterData(data){
    date = new Date (data + ' 00:00')
    const formatter = new Intl.DateTimeFormat('pt-BR', { dateStyle: 'short' })
    return data = formatter.format(date)
}


function modalAlerta(mesagem){
    // esconde o modal editar
    $(".modal").modal('hide')

    // mostra a mesagem de alerta 
    $("#modal-alerta-msg").html(mesagem)
    
    // mostra o modal alerta
    $("#modal-alerta").modal('show')
}


function enviarReqPOST(form, atualizarTabela){

    $.ajax({
        type: "POST",
        url: "../includes/server.php",
        data: form,
        success: function (resposta) {
            console.log(resposta)

            resposta = JSON.parse(resposta)
            
            modalAlerta(resposta.msg)
            
            atualizarTabela()

        }
    })
}

        
$(document).on('submit','#mysql-setup',function(e){
    e.preventDefault();

    form = $(this).serialize()

    $.ajax({
        type: "POST",
        url: "../includes/mysql_init.php",
        data: form,
        success: function (response) {
            console.log(response)
            
            response = JSON.parse(response)
        
            modalAlerta(response.msg)
            
        } 
    });
})

$(document).on('click','.btn-deletar-turma',function(){

    let id_turma = $(this).val()

    $.ajax({
        type: "GET",
        url: "../includes/server.php",
        data: {reservas_turma:id_turma},
        success: function (response) {
            
            console.log(response)

            if(response > 0){

                $("#msg-del-turma").html("<p>Certeza que deseja deletar a turma selecionada?<br>" + response +" reservas tambem serao deletadas</p>")
                
            } else {
                
                $("#msg-del-turma").html("<p>Certeza que deseja deletar a turma selecionada?<p>")
            }


            $("#modal-editar").modal('hide')
            
            $("#modal-deletar-turma").modal('toggle')
        }
    });

})



