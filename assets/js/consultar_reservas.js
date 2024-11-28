

    $(document).on('submit','#form-consultar-reservas', function (e) {
        e.preventDefault()
        $('#aviso').remove()
        atualizarTabelaReservas()
    })



    // BOTAO DELETAR
    $(document).on('click','.btn-deletar-reserva', function () {  
        const reserva_dados = $(this).val().split("-")
        $("#del-reserva-id-reserva").val(reserva_dados[0])
        $("#del-reserva-id-turma").val(reserva_dados[1])

        const tipo_reserva = $(this).parents("tr").children("td:nth-child(5)")

        // desabilita as opcoes (radio) de deletar todos os registros e apartir no modal deletar reservas 
        if(tipo_reserva.text() == "Avulsa"){
            $("#radio-del-apartir, #radio-del-todos").prop("disabled",true)
        } else {
            $("#radio-del-apartir, #radio-del-todos").prop("disabled",false)
        }
    })
        
    // MODAL-FORM DELETAR RESERVAS
    $(document).on('submit', '#form-del-reserva', function (e) { 
        e.preventDefault();
        form = $(this).serialize() 

        reqServidorPOST(form, atualizarTabelaReservas)
    })
    
    
    // PAGINACAO
    $(document).on('click','.pagina-reservas', function (e) {
        e.preventDefault()
        
        const pagina = $(this).val()
        
        $.ajax({
            url:"../JSON/dados_tabela_reservas.json",
            type:"GET",
            dataType: "json",
            success:function(dadosJSON){
                tabela = gerarTabelaReservas(dadosJSON.reservas, pagina)
                $("#container-tabela").html(tabela)
            }
        })
    })
    
    
    // BOTAO EDITAR
    
    $(document).on('click','.btn-editar-reserva', function () { 
        const reserva_dados  = this.value.split("-")


        id_reserva = reserva_dados[0]
        id_turma = reserva_dados[1]

        sala_row = $(this).parents("tr").children("td:nth-child(2)").text().split(" - ")
        
        reqServidorGET({sala_dados:sala_row[0]}, mostarSalaDados)
        

        dataText = $(this).parents("tr").children("td:nth-child(3)").text()
        turno = $(this).parents("tr").children("td:nth-child(4)").text()
        tipo_reserva = $(this).parents("tr").children("td:nth-child(5)").text()

        mostarReservaDados(dataText,tipo_reserva,turno)

        data_arr = dataText.split(" - ")
        
        data = data_arr[1].split("/").reverse().join("-")
        

        $("#inp-edit-id_reserva").val(id_reserva)
        $("#inp-edit-id_turma").val(id_turma)
        
        reqServidorGET({turmas_options: true, turno:turno, datas:data, id_turma:id_turma }, mostrarOptionsTurmas)

        reqServidorGET({dados_turma:id_turma}, mostrarDadosTurma)
        
        reqServidorGET({dados_turma:id_turma}, mostrarInputDadosTurma)
    })
    
   
    $(document).on('submit','#form-editar', function (e) {
        e.preventDefault()
        $("#modal-editar").modal('hide')
        $("#modal-editar-reserva").modal('toggle')
    })

    // SUBMIT FORM-MODAL TROCAR TURMA
    $(document).on('submit','#form-edit-reserva', function(e){
        e.preventDefault()
        let form = $(this).serialize() + "&" + $("#form-editar").serialize()
        console.log(form)
        reqServidorPOST(form, atualizarTabelaReservas)
    })
    

// LIMPAR DADOS MODAL EDITAR APOS CANCELAR OPERACAO

function atualizarTabelaReservas(){

    let form = $("#form-consultar-reservas").serialize()
    form += '&consultar=reservas'

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

            $.ajax({
                url:"../JSON/dados_tabela_reservas.json",
                type:"GET",
                dataType: "json",
                success:function(dadosJSON){
                    console.log(dadosJSON)
                    mostradorTabelaReservas(dadosJSON)
                }
            })
        }
    })
}


function gerarTabelaReservas(reservas, pagina){

    tabela = '<table class="table table-striped tabela-consulta">'
    tabela += '<thead>'
    tabela += '<tr>'
    tabela += '<th scope="col">Id</th>'
    tabela += '<th scope="col">Sala</th>'
    tabela += '<th scope="col">Data</th>'
    tabela += '<th scope="col">Turno</th>'
    tabela += '<th scope="col">Tipo de reserva</th>'
    tabela += '<th scope="col">Turma</th>'
    tabela += '<th scope="col">Docente</th>'
    tabela += '<th scope="col">Lotação</th>'
    tabela += '<th scope="col">Ação</th>'
    tabela += '</thead>'
    tabela += '</tr>'
    tabela += '<tbody>'
    
    reg_qtd = reservas.length 
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
        
        data = converterData(reservas[i].data)
        dia = diaSemana(reservas[i].data)

        tabela += '<tr>'
        tabela += '<td>' + reservas[i].id_reserva + '</td>' 
        tabela += '<td>' + reservas[i].sala + " - " + reservas[i].sala_tipo + '</td>'
        tabela += '<td>' + dia + ' - ' + data + '</td>'
        tabela += '<td>' + reservas[i].turno   + '</td>' 
        tabela += '<td>' + reservas[i].reserva + '</td>'
        tabela += '<td>' + reservas[i].turma   + '</td>'
        tabela += '<td>' + reservas[i].docente + '</td>' 
        tabela += '<td>' + reservas[i].lugares + '</td>'
        tabela += '<td>'
        tabela += '<div class="d-grid gap-2 d-md-flex justify-content-md-center">'
        tabela += '<button type="button" class="btn-editar-reserva btn btn-primary" data-bs-toggle="modal" value="' + reservas[i].id_reserva + '-' + reservas[i].id_turma +'" data-bs-target="#modal-editar">Editar</button>'
        tabela += '<button type="button" class="btn-deletar-reserva btn btn-danger" data-bs-toggle="modal" value="' + reservas[i].id_reserva + '-' + reservas[i].id_turma +'" data-bs-target="#deletar-reserva-modal">Deletar</button>'
        tabela += '</div>'
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
            tabela += '<li class="page-item pagina-reservas" type="button" value="' + e + '">'
            tabela += '<a class="page-link">' + e + '</a>'
            tabela += '</li>'
        }
    } 
    tabela += '</ul>'
    tabela += '</nav>'

    tabela += '<div style="margin-bottom: 20px;">'
    tabela += '<button type="button" onclick="gerarPDF()" class="btn btn-primary btn-reservar">'
    tabela += 'Gerar PDF'
    tabela += '</button>'
    tabela += '</div>'

    return tabela

}


function gerarTabelaHistorico(reservas, pagina){

    tabela = '<table class="table table-striped tabela-consulta">'
    tabela += '<thead>'
    tabela += '<tr>'
    tabela += '<th scope="col">Id</th>'
    tabela += '<th scope="col">Sala</th>'
    tabela += '<th scope="col">Data</th>'
    tabela += '<th scope="col">Turno</th>'
    tabela += '<th scope="col">Tipo de reserva</th>'
    tabela += '<th scope="col">Turma</th>'
    tabela += '<th scope="col">Docente</th>'
    tabela += '<th scope="col">Lotação</th>'
    tabela += '</thead>'
    tabela += '</tr>'
    tabela += '<tbody>'
    
    reg_qtd = reservas.length 
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
        
        data = converterData(reservas[i].data)
        dia = diaSemana(reservas[i].data)

        tabela += '<tr>'
        tabela += '<td>' + reservas[i].id_reserva + '</td>' 
        tabela += '<td>' + reservas[i].sala + " - " + reservas[i].sala_tipo + '</td>'
        tabela += '<td>' + dia + ' - ' + data + '</td>'
        tabela += '<td>' + reservas[i].turno   + '</td>' 
        tabela += '<td>' + reservas[i].reserva + '</td>'
        tabela += '<td>' + reservas[i].turma   + '</td>'
        tabela += '<td>' + reservas[i].docente + '</td>' 
        tabela += '<td>' + reservas[i].lugares + '</td>'
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
            tabela += '<li class="page-item pagina-reservas" type="button" value="' + e + '">'
            tabela += '<a class="page-link">' + e + '</a>'
            tabela += '</li>'
        }
    } 
    tabela += '</ul>'
    tabela += '</nav>'

    return tabela

}


function mostradorTabelaReservas(dadosJSON){

    if(dadosJSON.status == 200){     

        gerarTabela = (dadosJSON.reserva_status == "Ativa")? gerarTabelaReservas : gerarTabelaHistorico

        resposta = gerarTabela(dadosJSON.reservas, getPaginaAtual())
    } else {
        resposta = "<span>"+ dadosJSON.msg +"</span>"
    }
    
    $("#container-tabela").html(resposta)
}


function pdfBody(dados){
    let body = [];
    for (const i in dados){
        //console.log(dados[i].id_sala + " " + dados[i].tipo_sala + " " + dados[i].lugares_qtd + " " + dados[i].maquinas_qtd + " " + dados[i].maquinas_tipo);
        body.push({
            sala: dados[i].sala,
            sala_tipo: dados[i].sala_tipo,
            data: dados[i].data,
            reserva: dados[i].reserva,
            turma: dados[i].turma,
            docente: dados[i].docente,
            turno: dados[i].turno,
            lugares: dados[i].lugares,
        });
    }
    return body;
}

//GERAR PDF
function gerarPDF(){
    $.ajax({
        type: "GET",
        url: "../JSON/dados_tabela_reservas.json",
        dataType: "JSON",
        success: function (dadosJSON) {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();

            doc.setFontSize(24);
            let text = "Reservas cadastradas";
            let textX = (doc.internal.pageSize.getWidth() - doc.getTextWidth(text))/2
            doc.text(text, textX, 20);
            doc.setFontSize(12);

            let head = [{sala: 'Sala', sala_tipo: "Tipo Sala", data: 'Data', turno: 'Turno', reserva: 'Tipo Reserva', turma: 'Turma', docente:'Docente', lugares: 'Lugares'}];
            let body = pdfBody(dadosJSON.reservas);
            doc.autoTable({head: head, body: body, startY: 25});
            doc.save('Reservas.pdf');
        }
    });       

}







    