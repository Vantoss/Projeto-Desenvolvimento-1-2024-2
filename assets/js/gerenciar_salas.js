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

//TRAZ AS SALAS (sem criar a tabela de novo)
function getJSON(){
    $.ajax({
        type: "GET",
        url: "../JSON/dados_salas.json",
        dataType: "JSON",
        success: function (dadosJSON) {
            pdfBody(dadosJSON.salas);
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

    tabela += '<div style="margin-bottom: 20px;">'
    tabela += '<button type="button" onclick="gerarPDF()" class="btn btn-primary btn-reservar">'
    tabela += 'Gerar PDF'
    tabela += '</button>'
    tabela += '</div>'

    return tabela
}

//DADOS A SEREM INSERIDOS NO PDF
function pdfBody(dados){
    let body = [];
    for (const i in dados){
        //console.log(dados[i].id_sala + " " + dados[i].tipo_sala + " " + dados[i].lugares_qtd + " " + dados[i].maquinas_qtd + " " + dados[i].maquinas_tipo);
        body.push({
            id: dados[i].id_sala,
            tipo: dados[i].tipo_sala,
            lugares: dados[i].lugares_qtd,
            nmaq: dados[i].maquinas_qtd,
            tmaq: dados[i].maquinas_tipo
        });
    }
    return body;
}

//GERAR PDF
function gerarPDF(){
    $.ajax({
        type: "GET",
        url: "../JSON/dados_salas.json",
        dataType: "JSON",
        success: function (dadosJSON) {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();

            doc.setFontSize(24);
            let text = "Salas cadastradas";
            let textX = (doc.internal.pageSize.getWidth() - doc.getTextWidth(text))/2
            doc.text(text, textX, 20);
            doc.setFontSize(12);

            let head = [{id: 'Sala', tipo: 'Tipo', lugares: 'N.º lugares', nmaq: 'N.º Maquinas', tmaq: 'Maquinas tipo'}];
            let body = pdfBody(dadosJSON.salas);
            doc.autoTable({head: head, body: body, startY: 25});
            doc.save('Salas.pdf');
        }
    });       

}