
// RODA AO CLICAR O BOTAO "BUSCAR"
$(document).on('submit','#form-consultar-salas',function (e) {
    e.preventDefault()
    $('#aviso').detach()
    atualizarTabelaSalas()
})

// BOTAO RESERVAR
$(document).on('click','#btn-reservar', function () {

    $("#turma-cadastrada").val("")
    $(".turma-dados").empty()

    const id_sala = $(this).val()

    $("#inp-cadastrar-sala").val(id_sala)
    
    reqServidorGET({sala_dados:id_sala}, mostarSalaDados)
    
})

// BOTOES CADASTRAR/BUSCAR TURMA PARA CADASTRAR RESERVA
// DESABILITA INPUTS CONFORME OPCAO SELECIONADA
$(document).on("click",".btn-check", function(){

    if(this.id == "btn-cadastro-turma" ){ 
        $("#turma-cadastrada").prop("disabled",true)
        $("#turma-dados-cadastrar").css("background-color","#e9ecef");
        $(".inp-cadastrar-turma").prop("disabled",false)
        $("#turma-cadastrada").val("")
        $("#turma-dados-cadastrar").empty()
    } else {
        $("#turma-cadastrada").prop("disabled",false)
        $("#turma-dados-cadastrar").css("background-color","#fff");
        $(".inp-cadastrar-turma").prop("disabled",true)
    }

})

        
// SUBMIT MODAL-FORM CADASTRAR RESERVA
$(document).on('submit','#cadastrar-reserva', function (e) {
    e.preventDefault()
    
            // COMBINA OS DADOS DA RESERVA COM OS DADOS DA TURMA
            formData = $(this).serialize()
            formData += '&' + $("#form-consultar-salas").serialize()
            formData += '&cadastrar-reserva=true'

            reqServidorPOST(formData, atualizarTabelaSalas)
            
            // apaga os inputs do modal cadastrar
            $(".input-cadastrar-turma").val("")                
})


//
$(document).on('click','.pagina-salas', function (e) {
    e.preventDefault()
    
    pagina = $(this).val()
    
    $.ajax({
        url:"../JSON/dados_tabela_salas.json",
        type:"GET",
        dataType: "json",
        success:function(dadosJSON){
            
            tabela = gerarTabelaSalas(dadosJSON, pagina)
            

            $("#container-tabela").html(tabela)
            if ($('#aviso').is("span")){
                $('[id^="btn-reservar"]').each(function(){ //Pega cada botão reservar
                    $(this).prop('disabled', true) //Desabilita os botões
                })
            }
        }
    })
})



// DESABILITAR DATA FIM
$(document).on('change','#inp-consulta-reserva-tipo', function(){
    if(this.value == "Única"){
        $("#inp-consulta-data-fim").prop("disabled",true)
        $("#inp-consulta-data-fim").val('')
    } else {
        $("#inp-consulta-data-fim").prop("disabled",false)
    }
})


//DESABILITA BOTÕES RESERVAR CASO FORM MUDAR
$(document).on('change', '#form-consultar-salas', function block(){ 
    $('[id^="btn-reservar"]').each(function(){ //Pega cada botão reservar
        $(this).prop('disabled', true) //Desabilita os botões
    })
    if ($('#aviso').is("span") == false){ //Verifica o alerta de mudanças está na pág.
        $('.col-12').append("<span id='aviso'>Mudanças detectadas, por favor busque novamente.</span>").css("color", "red") //Alerta
    }
});



// TABELA SALAS DISPONIVEIS

function gerarTabelaSalas(dadosJSON, pagina){
    salas = dadosJSON.salas
    
    turno = dadosJSON.turno
    reserva_tipo = dadosJSON.reserva_tipo
    datas = dadosJSON.datas
    
    data = converterData(datas[0])
    dia = diaSemana(datas[0])

    date = dia + ' - ' + data

    mostarReservaDados(date,reserva_tipo,turno)
    
    tabela = '<table class="table table-striped tabela-consulta">'
    
    tabela += '<span class="badge text-bg-secondary " id="reserva-tipo-tag">'+ reserva_tipo +'</span>'
    
    tabela += '<span class="badge text-bg-secondary" id="turno-tag">'+ turno +'</span>'
    
    datas.forEach( (data) =>{
        tabela += '<span class="badge text-bg-secondary">' + converterData(data) + '</span>'
    })


    tabela += '<thead>'
    tabela += '<tr>'
    tabela += '<th scope="col">Sala</th>'
    tabela += '<th scope="col">Tipo</th>'
    tabela += '<th scope="col">N.&#xba; lugares</th>'
    tabela += '<th scope="col">N.&#xba; maquinas</th>'
    tabela += '<th scope="col">Maquinas tipo</th>'
    tabela += '<th scope="col">Ação</th>'
    tabela += '</thead>'
    tabela += '</tr>'
    tabela += '<tbody>'

    reg_qtd = salas.length 
    reg_pag = 20  
    paginas = Math.ceil(reg_qtd / reg_pag);
    if(pagina > paginas){
        pagina = paginas
    }
    end = reg_pag * pagina; 
    i = end - reg_pag; 
    
    for (i; i < end; i++){

        if (i == reg_qtd){
            break;
        }

        tabela += '<tr>'
        tabela += '<td>' + salas[i].sala + '</td>' 
        tabela += '<td>' + salas[i].sala_tipo + '</td>' 
        tabela += '<td>' + salas[i].lugares + '</td>'
        tabela += '<td>' + salas[i].maquinas_qtd   + '</td>' 
        tabela += '<td>' + salas[i].maquinas_tipo + '</td>'
        tabela += '<td>'
        tabela += '<button type="button" id="btn-reservar" class="btn btn-primary" data-bs-toggle="modal" value="' + salas[i].sala + '" data-bs-target="#cadastrar-reserva-modal">Reservar</button>'
        tabela += '</td>' 
        tabela += '</tr>'
    }
    tabela += '</tbody>'
    tabela +='</table>'

    tabela += '<nav aria-label="...">'
    tabela += '<ul class="pagination pagination-sm">'

    for (e = 1; e < paginas + 1; e++) { 
        if(e == pagina){
            tabela += '<li class="page-item active" aria-current="page"><span id="current-page" class="page-link">' + e + '</span></li>'
        } else { 
            tabela += '<li class="page-item pagina-salas" type="button" value="' + e + '">'
            tabela += '<a class="page-link" id="bb">' + e + '</a>'
            tabela += '</li>'
        }
    } 
    tabela += '</ul>'
    tabela += '</nav>'

    return tabela
}

function atualizarTabelaSalas(){

    let form = $('#form-consultar-salas').serialize()
    let turno = $("#inp-consulta-turno").val()

    form += '&consultar=salas_disponiveis'

    console.log(form)

    $.ajax({
        url:"../includes/server.php",
        type:"GET",
        data: form,
        beforeSend:function(){
        $("#container-tabela").css("visibility","visible")
        },
        success:function(resposta){

            console.log(resposta)
            resposta = JSON.parse(resposta)
            
            if(resposta.status == 200){
                console.log(resposta.msg)
                $.ajax({
                    url:"../JSON/dados_tabela_salas.json",
                    type:"GET",
                    dataType: "json",
                    success:function(dadosJSON){
                        
                        if(document.getElementById("current-page")){
                            pagina = Number($("#current-page").text())
                        } else {
                            pagina = 1
                        }
                        tabela = gerarTabelaSalas(dadosJSON, pagina)
                        
                        reqServidorGET({turmas_options:true,turno:turno}, mostrarOptionsTurmas)

                        $("#container-tabela").html(tabela)
                    }
                })
            } else if (resposta.status == 204) {
                
                $("#container-tabela").html("<span>" + resposta.msg + "</span>")
                
            } else {   
                console.log(resposta.msg)
            }
        } 
    })
}














