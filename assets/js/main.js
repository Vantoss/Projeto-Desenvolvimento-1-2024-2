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
    const id_turma = $(this).val()
    if(!id_turma){
        // $(".inp-turma-dados, #btn-deletar-turma").val("")
        resetSelectTurma()
        
    } else {
        $("#btn-deletar-turma").val(id_turma)
        reqServidorGET('./turmas',{'turma-dados':true,'id-turma': id_turma}, mostrarTurmaDados)
    }
    stateBtnTurmaDados()
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

function reqServidorPOST(url, form, atualizarTabela){

    $.ajax({    

        type: "POST",
        url: url,
        data: form,
        success: function (resposta) {

            console.log(resposta)

            resposta = JSON.parse(resposta)
            
            modalAlerta(resposta.msg)
            
            atualizarTabela()

        }
    })
}

function reqServidorPUT(url, form, atualizarTabela){

    console.log(form)

    $.ajax({    

        type: "PUT",
        url: url,
        data: form,
        success: function (resposta) {

            console.log(resposta)

            resposta = JSON.parse(resposta)
            
            modalAlerta(resposta.msg)
            
            atualizarTabela()

        }
    })
}


function reqServidorGET(url, requisicao, mostrarDados){
    $.ajax({
        type: "GET",
        url: url,
        data: requisicao,
        success: function (resposta) {
            
            console.log(resposta)

            mostrarDados(resposta)
        }
    })
}

function reqServidorDELETE(url,form, atualizarTabela){

    $.ajax({
        type: "DELETE",
        url: url,
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
        url: "./core/mysql_init.php",
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
$(document).on('click','#btn-deletar-turma',function(){

    let id_turma = $(this).val()
    
    $("#inp-deletar-turma-id").val(id_turma)
    
    console.log(id_turma)
    
    reqServidorGET("./turmas",{num_reservas_turma:id_turma}, mostrarModalDelTurma)
    
})

// SUBMIT FORM-MODAL DELETAR TURMA
$(document).on('submit','#form-deletar-turma', function (e) {
    e.preventDefault()

    form = $(this).serialize()
    
    console.log(form)

    atualizarTabela = (document.title == "Consultar Reserva") ? atualizarTabelaReservas : atualizarTabelaSalasDisponiveis

    reqServidorDELETE("./turmas",form, atualizarTabela)
    
})

// SUBMIT FORM EDITAR TURMA
$(document).on('submit','#form-editar-turma', function (e) {
    e.preventDefault()


    form = $(this).serialize()

    atualizarTabela = (document.title == "Consultar Reserva") ? atualizarTabelaReservas : atualizarTabelaSalasDisponiveis

    console.log(form)

    reqServidorPUT('./turmas',form, atualizarTabela)

    
})


// MOSTRADORES DE DADOS ===================================================================================
function mostrarTurmaDados(resposta){
    const turma = JSON.parse(resposta)

    $("#inp-editar-turma-id").val(turma.id_turma)
    $("#inp-editar-turma-nome").val(turma.nome)
    $("#inp-editar-turma-docente").val(turma.docente)
    $("#inp-editar-turma-curso").val(turma.curso)
    $("#inp-editar-turma-semestre").val(turma.semestre)
    $("#inp-editar-turma-participantes").val(turma.participantes_qtd)

}

function mostrarModalDelTurma(resposta){

    resposta = JSON.parse(resposta)

    $("#msg-del-turma").html(resposta.msg)
    $(".modal").modal('hide')
    $("#modal-deletar-turma").modal('show')
    $("inp-editar-turma-nome").val("")
}



function mostrarOptionsTurmas(resposta){
    $("#turma-cadastrada").html(resposta)
}

function mostrarSalaDados(resposta){

    objTurma = JSON.parse(resposta)

    dados = '<h6>'+ objTurma.numero_sala+ ' - '+ objTurma.tipo_sala + '</h6>'
    dados +='<h6>'+objTurma.lugares_qtd +' lugares</h6>'
    dados +='<h6> '+objTurma.maquinas_qtd +' maquinas ('+ objTurma.maquinas_tipo+ ')</h6>'

    $("#sala-dados").html(dados)
}

function mostrarReservaDados(datas,tipo_reserva,turno){

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
    if(document.getElementById("pagina-atual")){
        pagina = Number($("#pagina-atual").val())
    } else {
        pagina = 1
    }
    console.log(pagina)
    return pagina
}

function getUnidadeAtual(){
    if(document.getElementById("unidade-atual")){
        unidade = Number($("#unidade-atual").val())
    } else {
        unidade = 1
    }
    console.log(unidade)
    return unidade
}

function resetSelectTurma(){
    $("#turma-cadastrada, .inp-turma-dados, #btn-deletar-turma").val("")
    $(".btn-turma-dados").prop("disabled",true)
}

function stateBtnTurmaDados(){
    let turmaDados = $(".btn-turma-dados")

    if(!$("#turma-cadastrada").val()){
        turmaDados.prop("disabled",true)
    } else {
        turmaDados.prop("disabled",false)
    }
}


function btnPaginas(pagina,paginas){
    tabela = '<nav>'
    tabela += '<ul class="pagination pagination-sm">'

    for (e = 1; e < paginas + 1; e++) { 
        if(e == pagina){
            tabela += '<li class="page-item active" type="button"><button id="pagina-atual" value="'+ e +'" class="page-link">' + e + '</button></li>'
        } else { 
            tabela += '<li class="page-item btn-pagina" type="button" value="' + e + '">'
            tabela += '<button class="page-link">' + e + '</button>'
            tabela += '</li>'
        }
    }

    tabela += '</ul>'
    tabela += '</nav>'

    return tabela
}

function btnUnidade(unidade){

    const unidades = 2

    tabela = '<ul class="nav nav-pills">'
    
    for (e = 1; e <= unidades; e++) { 
        if(e == unidade){
            tabela += '<li class="nav-item"><button class="nav-link active unidade-tab" value="'+ e +'" id="unidade-atual" >Unidade '+ e +'</button></li>'
        } else { 
            tabela += '<li class="nav-item"><button class="nav-link unidade-tab" value="'+ e +'" >Unidade '+ e +'</button></li>'
        }
    } 
    tabela += '</ul>'

    return tabela
}


function alertaTabela(msg){
    return "<span class='alerta-Tabela'>" + msg + "</span>"
}






