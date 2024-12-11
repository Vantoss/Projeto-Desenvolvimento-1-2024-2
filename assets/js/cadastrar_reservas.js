$(document).ready(function () {
    $(".inp-turma-dados").prop("disabled",true)
    $(".btn-turma-dados").prop("disabled",true)
});

// RODA AO CLICAR O BOTAO "BUSCAR"
$(document).on('submit','#form-consultar-salas',function (e) {
    e.preventDefault()
    $('#aviso').remove()
    atualizarTabelaSalasDisponiveis()
})

$(document).on('click','.close-badge', function(){
     
    let num = $(".data-badge").map(function(){
        return 1
    }).get()

    if(num.length > 1){
        $(this).closest('.data-badge-div').remove()
    }


})

// BOTAO RESERVAR
$(document).on('click','.btn-reservar', function () {
    resetInpCadastrarReserva()
    const id_sala = $(this).val()
    const turno = $("#badge-turno").text()
    const tipo_reserva = $("#badge-tipo-reserva").text()

    $("#inp-cadastrar-sala").val(id_sala)

    let datas = $(".data-badge").map(function(){
        return this.value
    }).get()

    const str_datas = '<h6>'+ diaSemana(datas[0]) +'</h6><h6 id="reserva-datas" class="overflow-x-auto">' + " " + datas.join(" - ") +"</h6>"

    console.log(datas)
    
    mostrarReservaDados(str_datas, tipo_reserva, turno)
    reqServidorGET("./salas", {'id-sala':id_sala}, mostrarSalaDados)
    reqServidorGET("./turmas",{'disponiveis': true,'turno':turno, 'tipo-reserva':tipo_reserva,'datas':datas}, mostrarOptionsTurmas)
    
})

// BOTOES CADASTRAR/BUSCAR TURMA PARA CADASTRAR RESERVA
// DESABILITA INPUTS CONFORME OPCAO SELECIONADA
$(document).on("click",".btn-check", function(){

    if(this.id == "btn-cadastro-turma"){ 
        $("#turma-cadastrada, .inp-turma-dados, .btn-turma-dados").prop("disabled",true)
        $(".inp-cadastrar-turma").prop("disabled",false)
    } else {
        $("#turma-cadastrada, .inp-turma-dados").prop("disabled",false)
        $(".inp-cadastrar-turma").prop("disabled",true)
        stateBtnTurmaDados()
    }
    
})

        
// SUBMIT MODAL-FORM CADASTRAR RESERVA
$(document).on('submit','#cadastrar-reserva', function (e) {
    e.preventDefault()

            let datas = $(".data-badge").map(function(){
                return this.value
            }).get()
            
            // COMBINA OS DADOS DA RESERVA COM OS DADOS DA TURMA
            form = $(this).serialize()
            form += '&' + $("#form-consultar-salas").serialize()
            form += '&datas=' + datas

            console.log(form)
            
            reqServidorPOST("./reservas",form, atualizarTabelaSalasDisponiveis)
})

function resetInpCadastrarReserva(){
    resetSelectTurma()
    $(".inp-cadastrar-turma").val("")                
    $(".inp-turma-dados").val("")
    $("#inp-responsavel-cadastro").val("")
}



// BOTAO PAGINA
$(document).on('click','.btn-pagina', function (){
    getTabelaSalasDisponiveisCached(pagina=$(this).val(),getUnidadeAtual())
})

// BOTAO UNIDADE
$(document).on("click",".unidade-tab", function (){
    atualizarTabelaSalasDisponiveis(unidade=$(this).val())
    // getTabelaSalasDisponiveisCached(pagina=1,unidade=$(this).val())
})


function getTabelaSalasDisponiveisCached(pagina,unidade){

    $.ajax({
        url:"./salas",
        type:"GET",
        data: {'disponiveis': true, 'salas-json': true},
        dataType: "json",
        success:function(resposta){
            
            console.log(resposta)
            tabela = gerarTabelaSalasDisponiveis(resposta, pagina, unidade)

            $("#container-tabela").html(tabela)

            if ($('#aviso').is("span")){
                $('.btn-reservar').prop('disabled', true) //Desabilita os botões 'reservar'
            }
        }
    })
}




// DESABILITAR DATA FIM
$(document).on('change','#inp-consulta-reserva-tipo', function(){
    
    $("#inp-consulta-data-fim, #inp-semanas, .inp-dia-semana").prop("disabled",true)
    $("#inp-consulta-data-fim, #inp-semanas").val('')
    $(".inp-dia-semana").prop("checked",false)

    if(this.value == "Avulsa"){
        
    } else if(this.value == "Pos-graduacao"){
        
        $(".inp-dia-semana, #inp-semanas").prop("disabled",false)
        
    }
    else if(this.value == "FIC"){
        
        $("#inp-semanas").prop("disabled",false)
    }
    else if(this.value == "Graduação"){
        
        $("#inp-semanas,#inp-consulta-data-fim").prop("disabled",false)
    }


    checkDatas()
})


$(document).on('change','#inp-semanas, #inp-consulta-data-fim', function(){

    if(this.id == "inp-semanas" && !this.value == ''){
        $("#inp-consulta-data-fim").prop("disabled",true)
    }
    else if(this.id == "inp-consulta-data-fim" && !this.value == ''){
        $("#inp-semanas").prop("disabled",true)
    } 
    else {
        $("#inp-consulta-data-fim, #inp-semanas").prop("disabled",false)
    }
})



// TABELA SALAS DISPONIVEIS

function tabelaBadges(tipo_reserva,turno,datas){

    conteudo = '<div class="collapse d-inline-flex flex-wrap" id="tabDatas" >'
    
    conteudo += '<div class="data-badge-div d-flex"><button class="badge text-bg-primary " id="badge-tipo-reserva">'+ tipo_reserva +'</button></div>'
    
    conteudo += '<div class="data-badge-div d-flex"><button class="badge text-bg-primary" id="badge-turno">'+ turno +'</button></div>'

    
    datas.forEach( (data) =>{
        conteudo += '<div class="data-badge-div d-flex"><button class="badge data-badge text-bg-primary" value="'+ data + '"><div class=" d-inline-flex" data-bs-theme="dark">' + converterData(data) + '<svg xmlns="http://www.w3.org/2000/svg" class="close-badge"  viewBox="0 0 72 72" width="14px" height="14px"><path d="M 19 15 C 17.977 15 16.951875 15.390875 16.171875 16.171875 C 14.609875 17.733875 14.609875 20.266125 16.171875 21.828125 L 30.34375 36 L 16.171875 50.171875 C 14.609875 51.733875 14.609875 54.266125 16.171875 55.828125 C 16.951875 56.608125 17.977 57 19 57 C 20.023 57 21.048125 56.609125 21.828125 55.828125 L 36 41.65625 L 50.171875 55.828125 C 51.731875 57.390125 54.267125 57.390125 55.828125 55.828125 C 57.391125 54.265125 57.391125 51.734875 55.828125 50.171875 L 41.65625 36 L 55.828125 21.828125 C 57.390125 20.266125 57.390125 17.733875 55.828125 16.171875 C 54.268125 14.610875 51.731875 14.609875 50.171875 16.171875 L 36 30.34375 L 21.828125 16.171875 C 21.048125 15.391875 20.023 15 19 15 z"/></svg></div></button></div>'
    })

    conteudo += "</div>"
    
    return conteudo
}


function gerarTabelaSalasDisponiveis(resposta, pagina, unidade){

    dadosJSON = resposta.dados

    const turno = dadosJSON.turno
    const tipo_reserva = dadosJSON.tipo_reserva
    let datas = dadosJSON.datas
    
    data = converterData(datas[0])
    dia = diaSemana(datas[0])
    
    date = dia + ' - ' + data
    
    tabela = '<table class="table table-striped tabela-consulta">'
    
    tabela += tabelaBadges(tipo_reserva,turno,datas)
    
    tabela += btnUnidade(unidade)
    
    if(resposta.status == 200){

    const salas = dadosJSON.salas

    tabela += "<br>"
    tabela += '<thead>'
    tabela += '<tr>'
    tabela += '<th scope="col">Sala</th>'
    tabela += '<th scope="col">Tipo</th>'
    tabela += '<th scope="col">Lotação</th>'
    tabela += '<th scope="col">N.&#xba; maquinas</th>'
    tabela += '<th scope="col">Maquinas tipo</th>'
    tabela += '<th scope="col">Ação</th>'
    tabela += '</thead>'
    tabela += '</tr>'
    tabela += '<tbody>'

    let reg_qtd = salas.length

    const reg_pag = 20  
    const paginas = Math.ceil(reg_qtd / reg_pag);
    
    if(pagina > paginas){
        pagina = paginas
    }
    const end = reg_pag * pagina; 
    let i = end - reg_pag; 
    
    for (i; i < end; i++){
        
        if (i == reg_qtd){
            break;
        }
        
        maquinas_tipo = (!salas[i].maquinas_tipo) ? "Nenhum" : salas[i].maquinas_tipo
        
        tabela += '<tr>'
        tabela += '<td>' + salas[i].numero_sala + '</td>'
        tabela += '<td>' + salas[i].tipo_sala + '</td>'
        tabela += '<td>' + salas[i].lugares_qtd + '</td>'
        tabela += '<td>' + salas[i].maquinas_qtd   + '</td>'
        tabela += '<td>' + maquinas_tipo + '</td>'
        tabela += '<td>'
        tabela += '<button type="button" class="btn btn-primary btn-reservar" data-bs-toggle="modal" value="' + salas[i].id_sala + '" data-bs-target="#cadastrar-reserva-modal">Reservar</button>'
        tabela += '</td>'
        tabela += '</tr>'
        
    }
    tabela += '</tbody>'
    tabela +='</table>'
    
    tabela += btnPaginas(pagina, paginas)
} else {
    tabela += alertaTabela(resposta.msg)
}
   return tabela
}

function atualizarTabelaSalasDisponiveis(unidade=null){

    if(!unidade){
        unidade = getUnidadeAtual()
    }

    let form = $('#form-consultar-salas').serialize() + "&unidade=" + unidade

    console.log(form)

    $.ajax({
        url:"./salas?disponiveis=true&"+ form,
        type:"GET",
        dataType: "json",
        beforeSend:function(){
        $("#container-tabela").css("visibility","visible")
        },
        success:function(resposta){
            
            console.log(resposta)

            tabela = gerarTabelaSalasDisponiveis(resposta, pagina=getPaginaAtual(), unidade)

            $("#container-tabela").html(tabela)

            $("#tabDatas").on('mouseenter', () => {
                $("#tabDatas").collapse('show');
            })
            
            $("#tabDatas").mouseleave(() => {
                $("#tabDatas").collapse('hide');
            })
                        
              
        } 
    })
}














