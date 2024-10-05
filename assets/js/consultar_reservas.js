$(document).ready(function () {
    


    $(document).on('click','.btn-editar-reserva', function () {
        
        var id_reserva = $(this).val()
        alert(id_reserva)
    });
    
    // define o id reserva a ser apagado
    $(document).on('click','.btn-deletar-reserva', function () {
        
        var id_reserva = $(this).val()
        $("#id-reserva").val(id_reserva)

        var col_reserva = $(this).parents("tr").children("td:nth-child(5)")

        // desabilita as opcoes (radio) de deletar todos os registros e apartir no modal deletar reservas 
        if(col_reserva.text() == "Única"){
            document.getElementById("radio-del-todos").setAttribute("disabled","")
            document.getElementById("radio-del-apartir").setAttribute("disabled","")
        } else {
            document.getElementById("radio-del-todos").removeAttribute("disabled")
            document.getElementById("radio-del-apartir").removeAttribute("disabled")
        }
        
    });
    
    // apaga o id reserva escolhido para ser apagado
    $(document).on('click','#btn-del-cancelar', function () {
        
        $("#id-reserva").val('')
        
    });


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

                var arr = resposta.registros_deletados
                // remove da tabela as reservas deletadas
                for (let i = 0; i < arr.length; i++) {
                    $("#id" + arr[i]).remove()
                }  

            }
            
        })
    })


    
});