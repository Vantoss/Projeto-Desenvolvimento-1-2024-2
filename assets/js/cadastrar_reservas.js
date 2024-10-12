
    // RODA AO CLICAR O BOTAO "BUSCAR"
    $(document).on('submit','#form-consultar-salas',function (e) {
        e.preventDefault()
        let form = $(this).serialize()
        let turno = $("#inp-consulta-turno").val()
        form += '&consultar=salas_disponiveis'
        
        console.log(form)
        $.ajax({
            url:"../includes/server.php",
            type:"GET",
            data: form,
            beforeSend:function(){
            $("#container-tabela").html("<span>Procurando...</span>")
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
                            tabela = gerarTabelaSalas(dadosJSON, 1)
                            
                            optionsTurmas(turno)

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

       
    })
            
    // BOTAO RESERVAR
    
        $(document).on('click','#btn-reservar', function () {
            let id_sala = $(this).val()
            // FORM CADASTRO DA RESERVA
            
            $(document).on('submit','#cadastrar-reserva', function (e) {
                e.preventDefault()
                
                // COMBINA OS DADOS DA RESERVA COM OS DADOS DA TURMA
                formData = $(this).serialize()
                formData += '&' + $("#form-consultar-salas").serialize()
                formData += '&cadastrar-reserva=true'
                formData += '&id_sala=' + id_sala


                $.ajax({
                    url:"../includes/server.php",
                    type:"POST",
                    data: formData,
                    success:function(resposta){

                        console.log(resposta)

                        resposta = JSON.parse(resposta)

                            // apaga os inputs do modal cadastrar
                            $(".input-cadastrar-turma").val("")
                            
                            // esconde o modal cadastrar
                            $("#cadastrar-reserva-modal").modal('hide')
                            
                            // mostra a mesagem de alerta (resultado do cadastro)
                            $("#modal-alerta-msg").text(resposta.msg)
                            
                            // mostra o modal alerta
                            $("#modal-alerta").modal('show')
                        
                    }
                })
            })
        })
    

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
            }
        })
    })

    // DESABILITAR DATA FIM
    $(document).on('change','#inp-consulta-reserva-tipo',function(){
        if(this.value == "única"){
            $("#inp-consulta-data-fim").prop("disabled",true)
            $("#inp-consulta-data-fim").val('')
        } else {
            $("#inp-consulta-data-fim").prop("disabled",false)
        }
    })



// TABELA SALAS DISPONIVEIS

function gerarTabelaSalas(dadosJSON, pagina){
    salas = dadosJSON.salas
    turno = dadosJSON.turno
    reserva_tipo = dadosJSON.reserva_tipo
    datas = dadosJSON.datas
    
    data = converterData(datas[0])

    $("#modal-header-cadastrar").html('<h1 class="modal-title fs-5">' + data + ' - ' + turno + ' - ' + reserva_tipo + '</h1>')
    
    tabela = '<table class="table table-striped tabela-consulta">'
    
    tabela += '<button id="data-tag" class="btn btn-primary btn-sm">'+ reserva_tipo +'</button>'
    
    tabela += '<button id="data-tag" class="btn btn-primary btn-sm">'+ turno + '</button>'
    
    datas.forEach( (data) =>{
        tabela += '<button id="data-tag" class="btn btn-primary btn-sm ">' + converterData(data) + '</button>'
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
            tabela += '<a class="page-link">' + e + '</a>'
            tabela += '</li>'
        }
    } 
    tabela += '</ul>'
    tabela += '</nav>'

    return tabela
}

// function atualizarTabelaReservas(){
    
//     let form = $("#form-consultar-reservas").serialize()
//     form += '&consultar=reservas'
//     $.ajax({
//         url:"../includes/server.php",
//         type:"GET",
//         data: form,
//         success:function(resposta){
//             resposta = JSON.parse(resposta)
//             console.log(resposta.msg)
//             $.ajax({
//                 url:"../JSON/dados_tabela_reservas.json",
//                 type:"GET",
//                 dataType: "json",
//                 success:function(dadosJSON){
                    
//                     if(dadosJSON.status == 200){
//                         pagina = Number($("#current-page").text())
//                         tabela = gerarTabelaReservas(dadosJSON.reservas, pagina)
//                         $("#container-tabela").html(tabela)
//                     } else {
                        
//                         $("#container-tabela").html("<span>"+ dadosJSON.msg +"</span>")
//                     }
//                 }
//             })
//         }
//     })
// }













