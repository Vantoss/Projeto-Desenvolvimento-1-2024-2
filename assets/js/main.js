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

    $.ajax({
        type: "GET",
        url: "../includes/server.php",
        data: {turmas_options:turno},
        success: function (response) {
            
            $("#turma-cadastrada").html(response)
        }
    })
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
        success: function (resposta) {

            console.log(resposta)
            
            resposta = JSON.parse(resposta)
        
            modalAlerta(resposta.msg)
            
        } 
    });
})

$(document).on('click','.btn-deletar-turma',function(){

    let id_turma = $(this).val()

    $("#del-turma-id-turma").val(id_turma)

    console.log(id_turma)

    $.ajax({
        type: "GET",
        url: "../includes/server.php",
        data: {reservas_turma:id_turma},
        success: function (resposta) {
            console.log(resposta)
            resposta = JSON.parse(resposta)

            $("#msg-del-turma").html(resposta.msg)

            $(".modal").modal('hide')
            
            $("#modal-deletar-turma").modal('show')
        }
    });

})

$(document).on('submit','#form-del-turma', function (e) {
    e.preventDefault()

    form = $(this).serialize()
    
    console.log(form)

    atualizarTabela = (document.title == "Consultar Reserva") ? atualizarTabelaReservas : atualizarTabelaSalas

    enviarReqPOST(form, atualizarTabela)
    
})



