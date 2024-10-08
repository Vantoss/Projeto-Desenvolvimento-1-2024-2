
$(document).on('click','.pagina', function (e) {
    e.preventDefault()

    pagina = $(this).val()

    $.ajax({
        url:"../includes/myJSON.json",
        type:"GET",
        dataType: "json",
        success:function(dadosJSON){

            tabela = gerarTabelaReservas(dadosJSON, pagina)
            
            $("#container-tabela").html(tabela)
        }
    })
})
    

function gerarTabelaReservas(dadosJSON, pagina){

    reservas = dadosJSON

    conteudo = '<table class="table table-striped tabela-consulta">'
    conteudo += '<thead>'
    conteudo += '<tr>'
    conteudo += '<th scope="col">Id</th>'
    conteudo += '<th scope="col">Sala</th>'
    conteudo += '<th scope="col">Data</th>'
    conteudo += '<th scope="col">Turno</th>'
    conteudo += '<th scope="col">Tipo de reserva</th>'
    conteudo += '<th scope="col">Turma</th>'
    conteudo += '<th scope="col">Docente</th>'
    conteudo += '<th scope="col">Lotação</th>'
    conteudo += '<th scope="col">Ação</th>'
    conteudo += '</thead>'
    conteudo += '</tr>'
    conteudo += '<tbody>'
    
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
        const diaSemana = ["Domingo","Segunda","Terça","Quarta","Quinta","Sexta","Sábado"];
        
        date = new Date (reservas[i].data + ' 00:00')
        
        const formatter = new Intl.DateTimeFormat('pt-BR', { dateStyle: 'short' });
        
        data = formatter.format(date)
        
        dia = diaSemana[date.getDay()];
        
        conteudo += '<tr id="id' + reservas[i].id_reserva + '">'
        conteudo += '<td>' + reservas[i].id_reserva + '</td>' 
        conteudo += '<td>' + reservas[i].sala + " - " + reservas[i].sala_tipo + '</td>'
        conteudo += '<td>' + dia + ' - ' + data +'</td>'
        conteudo += '<td>' + reservas[i].turno   + '</td>' 
        conteudo += '<td>' + reservas[i].reserva + '</td>'
        conteudo += '<td>' + reservas[i].turma   + '</td>'
        conteudo += '<td>' + reservas[i].docente + '</td>' 
        conteudo += '<td>' + reservas[i].lugares + '</td>'
        conteudo += '<td>'
        conteudo += '<div class="d-grid gap-2 d-md-flex justify-content-md-center">'
        conteudo += '<button type="button" class="btn-editar-reserva btn btn-primary" data-bs-toggle="modal" value="' + reservas[i].id_reserva + '" data-bs-target="#editar-reserva-modal">Editar</button>'
        conteudo += '<button type="button" class="btn-deletar-reserva btn btn-danger" data-bs-toggle="modal" value="' + reservas[i].id_reserva + '" data-bs-target="#deletar-reserva-modal">Deletar</button>'
        conteudo += '</div>'
        conteudo += '</td>' 
        conteudo += '</tr>'
    }
    conteudo += '</tbody>'
    conteudo +='</table>'

    conteudo += '<nav aria-label="...">'
    conteudo += '<ul class="pagination pagination-sm">'

    for (e = 1; e < paginas + 1; e++) { 
        if(e == pagina){
            conteudo += '<li class="page-item active" aria-current="page"><span id="current-page" class="page-link">' + e + '</span></li>'
        } else { 
            conteudo += '<li class="page-item pagina" type="button" value="' + e + '">'
            conteudo += '<a class="page-link">' + e + '</a>'
            conteudo += '</li>'
        }
    } 
    conteudo += '</ul>'
    conteudo += '</nav>'

    return conteudo

}







