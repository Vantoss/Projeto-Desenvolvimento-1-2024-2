$(Document).ready(function(){

    // PESQUISA
    $(document).on('submit','.form-consulta',function (e) {
        e.preventDefault()

        var form = $(this).serialize()
        
        // identifica de qual formulario os dados estao vindo
        if (this.id == "form-consultar-reservas") form += '&consultar=' + 'reservas'  
        if(this.id == "form-consultar-salas") form += '&consultar=' + 'salas_disponiveis'
        
        $.ajax({

            
            url:"../includes/server.php",
            type:"GET",
            data: form,
            beforeSend:function(){
                $("#container-tabela").html("<span>Procurando...</span>")
                $("#container-tabela").css("display","block")
            },
            success:function(data){
                $("#container-tabela").html(data)
            }
        })

        $(document).on('click', '#btn-reservar', function () {
            
            var id_sala = $(this).val()

            // FORM CADASTRO DA RESERVA
            $(document).on('submit','#cadastrar-reserva', function (e) {
                e.preventDefault()
                // COMBINA OS DADOS DA RESERVA COM OS DADOS DA TURMA
                formData = $("#cadastrar-reserva").serialize()
                formData += '&' + form
                formData += '&cadastrar-reserva=true'
                formData += '&id_sala=' + id_sala
                
                $.ajax({
                    url:"../includes/server.php",
                    type:"POST",
                    data: formData,
                    success:function(data){
                        $("#dados-cad").text(data)
                        $("#cadastrar-reserva")[0].reset()
                    }
                })
            })

        })  
        
    })

//     const myModal = new bootstrap.Modal(document.getElementById('myModal'), options)
// // or
//     const myModalAlternative = new bootstrap.Modal('#myModal', options)
   
})
