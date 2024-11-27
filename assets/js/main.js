// DEFININDO COMPORTAMENTO DOS MODAIS
$(".modal").modal({
    keyboard: false,
    backdrop: 'static'
})


//DESABILITA BOTÕES RESERVAR CASO FORM MUDAR
$(document).on('change', '.form-consulta', function (){

    $('.btn-reservar').prop('disabled', true) //Desabilita os botões 'reservar'

    if ($('#aviso').is("span") == false){ //Verifica o alerta de mudanças está na pág.
        $('.col-12').append("<span id='aviso'>Mudanças detectadas, por favor busque novamente.</span>").css({"color": "#dc3545", "font-size": ".875em"}) //Alerta
    }
});


// MODAL CADASTRAR/EDITAR RESERVA: CONTAINER INFORMACOES TURMA
$(document).on('change','#turma-cadastrada', function(e){
    id_turma = $(this).val()
    if(!id_turma){
        $(".turma-dados").empty()
    } else {
        reqServidorGET({dados_turma : id_turma}, mostrarDadosTurma)
    }
})

    
// CONVERTE DATA NO FORMATO "Y-m-d" PARA O FORMATO "d/m/Y"
function converterData(data){
    date = new Date (data + ' 00:00')
    const formatter = new Intl.DateTimeFormat('pt-BR', { dateStyle: 'short' })
    return formatter.format(date)
}


function diaSemana(data){

    if(data.includes("/")){

        data = data.split("/").reverse().join("-")
    }

    date = new Date (data + ' 00:00')
    const diaSemana = ["Domingo","Segunda","Terça","Quarta","Quinta","Sexta","Sábado"]
    return diaSemana[date.getDay()]
}


function modalAlerta(mesagem){
    // esconde o modal editar
    $(".modal").modal('hide')
    // mostra a mesagem de alerta 
    $("#modal-alerta-msg").html(mesagem)
    // mostra o modal alerta
    $("#modal-alerta").modal('show')
}

function reqServidorPOST(form, atualizarTabela){

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


function reqServidorGET(requisicao, mostrarDados){
    $.ajax({
        type: "GET",
        url: "../includes/server.php",
        data: requisicao,
        success: function (resposta) {
            
            console.log(resposta)

            mostrarDados(resposta)
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


// FUNC EDITAR/DELETAR TURMA ======================================================================================

// BOTAO DELETAR TURMA
$(document).on('click','.btn-deletar-turma',function(){

    let id_turma = $(this).val()
    
    $("#inp-deletar-turma-id").val(id_turma)
    
    console.log(id_turma)
    
    reqServidorGET({num_reservas_turma:id_turma}, mostrarModalDelTurma)
    
})

// SUBMIT FORM-MODAL DELETAR TURMA
$(document).on('submit','#form-deletar-turma', function (e) {
    e.preventDefault()

    form = $(this).serialize() + "&deletar_turma=true"
    
    console.log(form)

    atualizarTabela = (document.title == "Consultar Reserva") ? atualizarTabelaReservas : atualizarTabelaSalasDisponiveis

    reqServidorPOST(form, atualizarTabela)
    
})

// BOTAO EDITAR TURMA
// $(document).on('click','.btn-editar-turma',function(){

//     let id_turma = $(this).val()

//     $("#inp-editar-turma-id").val(id_turma)

//     console.log(id_turma)

//     reqServidorGET({dados_turma:id_turma}, mostrarModalEditarTurma)

// })

// SUBMIT FORM EDITAR TURMA

$(document).on('submit','#form-editar-turma', function (e) {
    e.preventDefault()

    $(".turma-dados").empty()

    form = $(this).serialize() + '&editar_turma=true'

    atualizarTabela = (document.title == "Consultar Reserva") ? atualizarTabelaReservas : atualizarTabelaSalasDisponiveis

    reqServidorPOST(form, atualizarTabela)

})



// MOSTRADORES DE DADOS ====================================================================================

function mostrarDadosTurma(resposta){
    
    $(".turma-dados").html(resposta)
    
}

function mostrarModalDelTurma(resposta){
    resposta = JSON.parse(resposta)

            $("#msg-del-turma").html(resposta.msg)

            $(".modal").modal('hide')
            
            $("#modal-deletar-turma").modal('show')
}


function mostrarModalEditarTurma(resposta){

    mostrarInputDadosTurma(resposta)

    $(".modal").modal('hide')
    
    $("#modal-editar-turma").modal('show')

}

function mostrarOptionsTurmas(resposta){
    
    $("#turma-cadastrada").empty()
    
    $("#turma-cadastrada").html(resposta)
    
}

function mostrarInputDadosTurma(resposta){

    let objTurma = JSON.parse(resposta)
                
    $("#inp-turma").val(objTurma.nome)
    $("#inp-docente").val(objTurma.docente)
    $("#inp-curso").val(objTurma.curso)
    $("#inp-participantes").val(objTurma.participantes_qtd)
}

function mostarSalaDados(resposta){

    objTurma = JSON.parse(resposta)

        dados = '<h6>'+ objTurma.id_sala+ ' - '+ objTurma.tipo_sala + '</h6>'
        dados +='<h6>'+objTurma.lugares_qtd +' lugares</h6>'
        dados +='<h6> '+objTurma.maquinas_qtd +' maquinas ('+ objTurma.maquinas_tipo+ ')</h6>'

    $("#sala-dados").html(dados)
}

function mostarReservaDados(datas,tipo_reserva,turno){

    dados = datas 
    dados += '<h6>' + tipo_reserva + '</h6>'
    dados += '<h6>' + turno + '</h6>'

    $("#reserva-dados").html(dados)

}

$(document).on('change',".inp-data", function(){
    checkDatas()
})


function checkDatas(){
    if(!$('#inp-consulta-data-fim').val() == '' && $("#inp-consulta-data-inicio").val() > $("#inp-consulta-data-fim").val() ){
        $(".inp-data").addClass('is-invalid')
        $(".btn-buscar").prop("disabled",true)
    } else {   
        $(".inp-data").removeClass('is-invalid')
        $(".btn-buscar").prop("disabled",false)
    }
}

function getPaginaAtual(){
    if(document.getElementById("current-page")){
        pagina = Number($("#current-page").text())
    } else {
        pagina = 1
    }
    return pagina
}

// $('#datepicker').datepicker({
//     startDate: new Date(),
//     multidate: true,
//     format: "dd/mm/yyyy",
//     daysOfWeekHighlighted: "5,6",
//     datesDisabled: ['31/08/2017'],
//     language: 'pt-br'
// }).on('changeDate', function(e) {
//     // `e` here contains the extra attributes
//     $(this).find('.input-group-addon .count').text(' ' + e.dates.length);
// });






