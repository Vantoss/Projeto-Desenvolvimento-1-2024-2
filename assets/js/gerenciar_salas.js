$(document).ready(function () {
    getTabelaSalas(1,1)
});

// BOTAO PAGINA
$(document).on("click",".btn-pagina",function () {
    getTabelaSalas(pagina=$(this).val(),unidade=getUnidadeAtual())
})

// BOTAO UNIDADE
$(document).on("click",".unidade-tab", function (){
    getTabelaSalas(pagina=1,$(this).val())
})


// BTN EDITAR
$(document).on("click",".btn-editar-sala",function () { 
    const id_sala = $(this).val()
    $("#inp-editar-sala-id").val(id_sala)
    reqServidorGET("./salas", {'id-sala':id_sala}, modalEditarSalaDados)
    
});

// SUBMIT FORM EDITAR SALA
$(document).on("submit","#form-editar-sala", function (e) {
    e.preventDefault()
    form = $(this).serialize()
    console.log(form)
    reqServidorPUT("./salas", form, getTabelaSalas)
}) 




function modalEditarSalaDados(resposta){
    sala = JSON.parse(resposta)

    if(sala.unidade == 1){
        $("#inp-editar-unidade-1").prop("checked", true)
    } else {
        $("#inp-editar-unidade-2").prop("checked", true)
    }

    $("#span-numero-sala").html(sala.numero_sala)
    $("#inp-editar-tipo").val(sala.tipo_sala)
    $("#inp-editar-maquinas-qtd").val(sala.maquinas_qtd)
    $("#inp-editar-maquinas-tipo").val(sala.maquinas_tipo)
    $("#inp-editar-lotacao").val(sala.lugares_qtd)
    $("#inp-editar-descricao").val(sala.descricao)

}


function getTabelaSalas(pagina=getPaginaAtual(),unidade=getUnidadeAtual()){

    $.ajax({
        type: "GET",
        url: "./salas?tabela-salas=true&unidade=" + unidade,
        dataType: "json",
        beforeSend:function(){
            $("#container-tabela").css("visibility","visible")
        },
        success: function (resposta) { 

            console.log(resposta)
            if(resposta.status != 200 ){

                $("#container-tabela").html("<span>"+ resposta.msg + "</span>")
                return
            }
            
            tabela = gerarTabelaSalas(resposta.salas, pagina, unidade)
            $("#container-tabela").html(tabela)
        }
    });
}




        
function gerarTabelaSalas(salas, pagina, unidade){
    
    if(salas.length == 0){
       return "<h2>Nenhuma sala cadastrada</h2>" 
    }

    tabela = '<table class="table table-striped tabela-consulta">'
    tabela += '<br>'

    tabela += btnUnidade(unidade)

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

    const reg_qtd = salas.length 
    const reg_pag = 20  
    const paginas = Math.ceil(reg_qtd / reg_pag);

    if(pagina > paginas){
        pagina = paginas
    }
    const end = reg_pag * pagina; 
    let i = end - reg_pag; 

    for (i; i < end; i++){

        // console.log(i)

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
            tabela += '<div class="d-grid gap-2 d-md-flex justify-content-md-center">'
            tabela += '<button type="button" class="btn btn-primary btn-editar-sala" data-bs-toggle="modal" value="' + salas[i].id_sala + '" data-bs-target="#modal-editar-sala">Editar</button>'
            tabela += '<button type="button" class="btn btn-danger btn-deletar-sala" data-bs-toggle="modal" value="' + salas[i].id_sala +'" data-bs-target="#modal-deletar-sala">Deletar</button>'
            tabela += '</div>' 
            tabela += '</td>' 
            tabela += '</tr>'
        
    }
    tabela += '</tbody>'
    tabela +='</table>'

    tabela += btnPaginas(pagina, paginas)

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
        url: "././JSON/dados_salas.json",
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