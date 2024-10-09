$(document).ready(function () {
    $(document).on('submit','#form-consultar-reservas',function (e) {
        e.preventDefault()
        var form = $(this).serialize()
        form += '&consultar=' + 'reservas'  
        $.ajax({
            url:"../includes/server.php",
            type:"GET",
            data: form,
            beforeSend:function(){
                $("#container-tabela").html("<span>Procurando...</span>")
                $("#container-tabela").css("visibility","visible")
            },
            success:function(response){
                response = JSON.parse(response)
                if(response.status == 200){
                    console.log(response.msg)
                    
                    $.ajax({
                        url:"../includes/dados_tabela_reservas.json",
                        type:"GET",
                        dataType: "json",
                        success:function(dadosJSON){      
                            tabela = gerarTabelaReservas(dadosJSON, 1)
                            $("#container-tabela").html(tabela)
                        }
                    })
                } else if (response.status == 204) {
                    $("#container-tabela").html("<span>" + response.msg + "</span>")
                } else {   
                    console.log(response.msg)
                }
            } 
        })
    })
    
    // define o id reserva a ser apagado
    $(document).on('click','.btn-deletar-reserva', function () {  
        var id_reserva = $(this).val()
        $("#id-reserva").val(id_reserva)
        var col_reserva = $(this).parents("tr").children("td:nth-child(5)")
        // desabilita as opcoes (radio) de deletar todos os registros e apartir no modal deletar reservas 
        if(col_reserva.text() == "Única"){
            $("#radio-del-todos").prop("disabled",true)
            $("#radio-del-apartir").prop("disabled",true)
        } else {
            $("#radio-del-todos")  .prop("disabled",false)
            $("#radio-del-apartir").prop("disabled",false)
        }
    })
    
    // apaga o id reserva escolhido para ser apagado
    $(document).on('click','#btn-del-cancelar', function () {  
        $("#id-reserva").val('')
    })
    
    $(document).on('submit', '#form-del-reserva', function (e) { 
        e.preventDefault();
        var form = new FormData(this)
        $.ajax({ 
            url:"../includes/server.php",
            type:"POST",
            processData: false,
            contentType: false,
            data: form,
            success:function(resposta){
                var resposta = JSON.parse(resposta)
                // esconde o modal cadastrar
                $("#deletar-reserva-modal").modal('hide')
                
                // mostra a mesagem de alerta (resultado do cadastro)
                $("#modal-alerta-msg").text(resposta.msg)
                
                // mostra o modal alerta
                $("#modal-alerta").modal('show')

                atualizarTabelaReservas()
            }      
        })
    })
})

function atualizarTabelaReservas(){
    
    form = $("#form-consultar-reservas").serialize()
    form += '&consultar=' + 'reservas'
    $.ajax({
        url:"../includes/server.php",
        type:"GET",
        data: form,
        success:function(resposta){
            
            resposta = JSON.parse(resposta)
            
            console.log(resposta.msg)
            
            $.ajax({
                url:"../includes/dados_tabela_reservas.json",
                type:"GET",
                dataType: "json",
                success:function(dadosJSON){
                    
                    pagina = Number($("#current-page").text())
                    tabela = gerarTabelaReservas(dadosJSON, pagina)
                    $("#container-tabela").html(tabela)
                }
            })
        }
    })
}

function gerarTabelaReservas(dadosJSON, pagina){

    reservas = dadosJSON

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
        
        date = new Date (reservas[i].data + ' 00:00')
        
        const formatter = new Intl.DateTimeFormat('pt-BR', { dateStyle: 'short' })
        
        data = formatter.format(date)
        
        dia = diaSemana[date.getDay()];
        
        tabela += '<tr id="id' + reservas[i].id_reserva + '">'
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
        tabela += '<button type="button" class="btn-editar-reserva btn btn-primary" data-bs-toggle="modal" value="' + reservas[i].id_reserva + '" data-bs-target="#editar-reserva-modal">Editar</button>'
        tabela += '<button type="button" class="btn-deletar-reserva btn btn-danger" data-bs-toggle="modal" value="' + reservas[i].id_reserva + '" data-bs-target="#deletar-reserva-modal">Deletar</button>'
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

$(document).on('click','.pagina-reservas', function (e) {
    e.preventDefault()

    pagina = $(this).val()

    $.ajax({
        url:"../includes/dados_tabela_reservas.json",
        type:"GET",
        dataType: "json",
        success:function(dadosJSON){

            tabela = gerarTabelaReservas(dadosJSON, pagina)
            
            $("#container-tabela").html(tabela)
        }
    })
})
    
    