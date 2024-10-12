$(document).ready(function () {

    $(document).on('submit','#form-consultar-reservas',function (e) {
        e.preventDefault()
        atualizarTabelaReservas(pagina=1)
    })

    
    // define o id reserva a ser apagado
    $(document).on('click','.btn-deletar-reserva', function () {  
        const reserva_dados = $(this).val().split("-")

        const id_reserva = reserva_dados[0]
        const id_turma = reserva_dados[1]

        const tipo_reserva = $(this).parents("tr").children("td:nth-child(5)")

        // desabilita as opcoes (radio) de deletar todos os registros e apartir no modal deletar reservas 
        if(tipo_reserva.text() == "Única"){
            $("#radio-del-todos").prop("disabled",true)
            $("#radio-del-apartir").prop("disabled",true)
        } else {
            $("#radio-del-todos")  .prop("disabled",false)
            $("#radio-del-apartir").prop("disabled",false)
        }
        

        $(document).on('submit', '#form-del-reserva', function (e) { 
            e.preventDefault();
            form = $(this).serialize()
            form += "&id_reserva=" + id_reserva
            form +="&id_turma=" + id_turma

           enviarReqPOST(form)    
        })
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
    
    
    // EDITAR DADOS TURMA
    
    $(document).on('click','.btn-editar-reserva',function () { 
        const reserva_dados  = this.value.split("-")
        const turno = $(this).parents("tr").children("td:nth-child(4)").text()
        
        let id_turma = reserva_dados[1]
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
        
        $(document).on('submit','#form-editar', function (e) {
            e.preventDefault()
            
            if($("#btn-editar-turma").prop("checked")){

                form = $(this).serialize()
                
            } else if ($("#btn-trocar-turma").prop("checked")){
                
                $("#modal-editar").modal('hide')
                $("#modal-editar-reserva").modal('toggle')
                
                $(document).on('submit','#form-edit-reserva',function(e){
                    e.preventDefault()
                    form = $(this).serialize()
                })
                
                form += '&id_turma=' + id_turma
                
            }
            enviarReqPOST(form)
            
        })
        
    })
    
})
    function atualizarTabelaReservas(pagina=null){
    
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
                        
                        if(!pagina){
                            pagina = Number($("#current-page").text())
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

function enviarReqPOST(form){

    $.ajax({
        type: "POST",
        url: "../includes/server.php",
        data: form,
        success: function (resposta) {
            console.log(resposta)

            resposta = JSON.parse(resposta)
            // esconde o modal editar
            $(".modal").modal('hide')

            // mostra a mesagem de alerta 
            $("#modal-alerta-msg").text(resposta.msg)
            
            // mostra o modal alerta
            $("#modal-alerta").modal('show')
            
            atualizarTabelaReservas()

            }
    })
}

    