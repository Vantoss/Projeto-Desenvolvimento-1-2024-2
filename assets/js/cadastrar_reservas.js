
// RODA AO CLICAR O BOTAO "BUSCAR"
$(document).on('submit','#form-consultar-salas',function (e) {
    e.preventDefault()
    $('#aviso').remove()
    atualizarTabelaSalas()
})

$(document).on('click','.close-badge', function(){
     
    let num = $(".data-badge").map(function(){
        return 1
    }).get()

    if(num.length > 1){
        $(this).closest('.data-badge').remove()
    }

})

// BOTAO RESERVAR
$(document).on('click','.btn-reservar', function () {

    $("#turma-cadastrada").val("")
    $(".turma-dados").empty()

    const id_sala = $(this).val()

    $("#inp-cadastrar-sala").val(id_sala)

    turno = $("#badge-turno").text()
    tipo_reserva = $("#badge-tipo-reserva").text()

    let datas = $(".data-badge").map(function(){
        return this.innerText
    }).get()

    console.log(datas)

    datas = ' Datas:<div id="reserva-datas">' + " " + datas.join(" - ") +"</div>"

    mostarReservaDados(datas, tipo_reserva, turno)
    
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

            let datas = $(".data-badge").map(function(){
                return this.value
            }).get()
            

            // COMBINA OS DADOS DA RESERVA COM OS DADOS DA TURMA
            form = $(this).serialize()
            form += '&' + $("#form-consultar-salas").serialize()
            form += '&cadastrar-reserva=true'
            form += '&datas=' + datas

            console.log(form)
            
            reqServidorPOST(form, atualizarTabelaSalas)
            
            // apaga os inputs do modal cadastrar
            $(".input-cadastrar-turma").val("")                
})


// BOTAO PAGINA
$(document).on('click','.pagina-salas', function (e) {
    e.preventDefault()
    
    const pagina = $(this).val()
    
    $.ajax({
        url:"../JSON/dados_tabela_salas.json",
        type:"GET",
        dataType: "json",
        success:function(dadosJSON){
            
            tabela = gerarTabelaSalas(dadosJSON, pagina)

            $("#container-tabela").html(tabela)

            if ($('#aviso').is("span")){
                $('.btn-reservar').prop('disabled', true) //Desabilita os botões 'reservar'
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
    checkDatas()
})



// TABELA SALAS DISPONIVEIS

function tabelaBadges(tipo_reserva,turno,datas){

    conteudo = '<button class="badge text-bg-primary " id="badge-tipo-reserva">'+ tipo_reserva +'</button>'
    
    conteudo += '<button class="badge text-bg-primary" id="badge-turno">'+ turno +'</button>'
    
    datas.forEach( (data) =>{
        conteudo += '<button class="badge data-badge text-bg-primary" value="'+ data + '"><div class=" d-inline-flex" data-bs-theme="dark">' + converterData(data) + '<i class="fa fa-close close-badge"></i></div></button>'
    })
    
    return conteudo
}


function gerarTabelaSalas(dadosJSON, pagina){
    salas = dadosJSON.salas
    
    turno = dadosJSON.turno
    tipo_reserva = dadosJSON.tipo_reserva
    datas = dadosJSON.datas
    
    data = converterData(datas[0])
    dia = diaSemana(datas[0])

    date = dia + ' - ' + data

    tabela = '<table class="table table-striped tabela-consulta">'
    
    tabela += tabelaBadges(tipo_reserva,turno,datas)

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
        tabela += '<button type="button" class="btn btn-primary btn-reservar" data-bs-toggle="modal" value="' + salas[i].sala + '" data-bs-target="#cadastrar-reserva-modal">Reservar</button>'
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
                        
                        tabela = gerarTabelaSalas(dadosJSON, getPaginaAtual())
                        
                        reqServidorGET({turmas_options:true, turno:dadosJSON.turno, datas:dadosJSON.datas}, mostrarOptionsTurmas)

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














