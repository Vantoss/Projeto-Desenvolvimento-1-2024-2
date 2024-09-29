$(document).ready(function () {
    


    $(document).on('click','.btn-editar-reserva', function () {
        
        var id_reserva = $(this).val()
        alert(id_reserva)
    });
    
    // define o id reserva a ser apagado
    $(document).on('click','.btn-deletar-reserva', function () {
        
        var id_reserva = $(this).val()
        $("#id-reserva").val(id_reserva)
        
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
            success:function(response){
                $("#btn-buscar").click()
                alert(response)

            }
            
            
            
        })
    })
});