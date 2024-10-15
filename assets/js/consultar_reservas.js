

    $(document).on('submit','#form-consultar-reservas',function (e) {
        e.preventDefault()
        atualizarTabelaReservas()
    })


    // BOTAO DELETAR
    $(document).on('click','.btn-deletar-reserva', function () {  
        const reserva_dados = $(this).val().split("-")
        $("#inp-del-reserva").val(reserva_dados[0])
        $("#inp-del-turma").val(reserva_dados[1])

        const tipo_reserva = $(this).parents("tr").children("td:nth-child(5)")

        // desabilita as opcoes (radio) de deletar todos os registros e apartir no modal deletar reservas 
        if(tipo_reserva.text() == "Única"){
            $("#radio-del-todos").prop("disabled",true)
            $("#radio-del-apartir").prop("disabled",true)
        } else {
            $("#radio-del-todos")  .prop("disabled",false)
            $("#radio-del-apartir").prop("disabled",false)
        }
    })
        
    // MODAL-FORM DELETAR RESERVAS
    $(document).on('submit', '#form-del-reserva', function (e) { 
        e.preventDefault();
        form = $(this).serialize()

        enviarReqPOST(form,atualizarTabelaReservas)
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
    
    $(document).on('click','.btn-editar-reserva',function () { 
        const reserva_dados  = this.value.split("-")

        id_reserva = reserva_dados[0]
        id_turma = reserva_dados[1]
        data = $(this).parents("tr").children("td:nth-child(3)").text()
        turno = $(this).parents("tr").children("td:nth-child(4)").text()
        reserva_tipo = $(this).parents("tr").children("td:nth-child(5)").text()


        $("#modal-header-editar").html('<h1 class="modal-title fs-5">' + data + ' - ' + turno + ' - ' + reserva_tipo + '</h1>')
        $("#inp-edit-id_reserva").val(id_reserva)
        $("#inp-edit-id_turma").val(id_turma)

        optionsTurmas(turno)
        
        $.ajax({
            type: "GET",
            url: "../includes/server.php",
            data: {dados_turma : id_turma},
            success: function (resposta) {
                let objTurma = JSON.parse(resposta)
                
                $("#inp-turma").val(objTurma.nome)
                $("#inp-docente").val(objTurma.docente)
                $("#inp-curso").val(objTurma.curso)
                $("#inp-codigo").val(objTurma.codigo)
                $("#inp-participantes").val(objTurma.participantes_qtd)
            }
        })
        
    })

    
    
// MODAL EDITAR TURMA / TROCAR TURMA
    $(document).on('submit','#form-editar', function (e) {
        e.preventDefault()
        
        if($("#btn-editar-turma").prop("checked")){
            
            let form = $(this).serialize()

            enviarReqPOST(form,atualizarTabelaReservas)

            // turno = $(this).parents("tr").children("td:nth-child(4)").text()

            
        } else if ($("#btn-trocar-turma").prop("checked")){
            
            $("#modal-editar").modal('hide')

            $("#modal-editar-reserva").modal('toggle')

        }
    })

    
    // MODAL TROCAR TURMA
    $(document).on('submit','#form-edit-reserva',function(e){
        e.preventDefault()
        
        let form = $(this).serialize() + "&" + $("#form-editar").serialize()

        console.log(form)
        enviarReqPOST(form,atualizarTabelaReservas)
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
            resposta = JSON.parse(resposta)
            console.log(resposta.msg)
            $.ajax({
                url:"../JSON/dados_tabela_reservas.json",
                type:"GET",
                dataType: "json",
                success:function(dadosJSON){
                    
                    console.log(dadosJSON)

                    if(dadosJSON.status == 200){
                        
                        if(document.getElementById("current-page")){
                            pagina = Number($("#current-page").text())
                        } else {
                            pagina = 1
                        }
                        tabela = gerarTabelaReservas(dadosJSON.reservas, pagina)

                        $("#container-tabela").html(tabela)

                    } else {
                        
                        $("#container-tabela").html("<span>"+ dadosJSON.msg +"</span>")
                    }
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
        const diaSemana = ["Domingo","Segunda","Terça","Quarta","Quinta","Sexta","Sábado"]

        data = converterData(reservas[i].data)
        
        dia = diaSemana[date.getDay()];
        
        tabela += '<tr>'
        tabela += '<td>' + reservas[i].id_reserva + '</td>' 
        tabela += '<td>' + reservas[i].sala + " - " + reservas[i].sala_tipo + '</td>'
        tabela += '<td>' + dia + ' - ' + data +'</td>'
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

    return tabela

}



    