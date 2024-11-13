$(document).ready(function () {
    getTabelaSalas()
});

function getTabelaSalas(pagina=null){
    $.ajax({
        type: "GET",
        url: "../JSON/dados_salas.json",
        dataType: "JSON",
        beforeSend:function(){
            $("#container-tabela").css("visibility","visible")
        },
        success: function (dadosJSON) {
            if(!pagina){
                pagina = getPaginaAtual()
            }
            tabela = gerarTabelaSalas(dadosJSON, pagina)
            $("#container-tabela").html(tabela)
        }
    });
}


// BOTAO PAGINA
$(document).on('click','.pagina-salas', function (e) {
    e.preventDefault()
    const pagina = $(this).val()
    getTabelaSalas(pagina)
})
        
        
function gerarTabelaSalas(dadosJSON, pagina){

    
    salas = dadosJSON.salas
    tabela = '<table class="table table-striped tabela-consulta">'
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

        maquinas_tipo = (!salas[i].maquinas_tipo) ? "Nenhum" : salas[i].maquinas_tipo

        tabela += '<tr>'
        tabela += '<td>' + salas[i].id_sala + '</td>' 
        tabela += '<td>' + salas[i].tipo_sala + '</td>' 
        tabela += '<td>' + salas[i].lugares_qtd + '</td>'
        tabela += '<td>' + salas[i].maquinas_qtd   + '</td>' 
        tabela += '<td>' + maquinas_tipo + '</td>'
        tabela += '<td>'
        tabela += '<button type="button" class="btn btn-primary btn-editar" data-bs-toggle="modal" value="' + salas[i].id_sala + '" data-bs-target="">Editar</button>'
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