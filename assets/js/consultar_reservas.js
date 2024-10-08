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
                        url:"../includes/myJSON.json",
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
                    url:"../includes/myJSON.json",
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
})
    
    