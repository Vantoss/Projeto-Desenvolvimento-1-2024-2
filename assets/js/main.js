$(Document).ready(function(){


    // PESQUISA
   
    $(document).on('submit','.form-consulta',function (e) {
        e.preventDefault();

        var form = $(this).serialize()
        
        // identifica de qual formulario os dados estao vindo
        if (this.id == "form-consultar-reservas") form = form + '&consultar=' + 'reservas '    
        if(this.id == "form-consultar-salas") form = form + '&consultar=' + 'salas_disponiveis '
            
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

            // CADASTRO DA RESERVA
            $(document).on('submit','#cadastrar-reserva', function (e) {
                e.preventDefault();            
                // form_cad = $(".form-consulta, #cadastrar-reserva").serialize()
                
                
                formData = $(".form-consulta, #cadastrar-reserva").serialize() + '&cadastrar-reserva=true'  
                formData += '&id_sala=' + id_sala  
                
                
                // form = form + $(this).serialize()
                $.ajax({
                    url:"../includes/server.php",
                    type:"POST",
                    data: formData,
                    success:function(data){
                        $("#dados-cad").text(data)
                        $("#cadastrar-reserva")[0].reset()                        
                        // $(".form-consulta").submit()
                    }
                })
            });

        })  
        
    })

    const myModal = new bootstrap.Modal(document.getElementById('myModal'), options)
// or
    const myModalAlternative = new bootstrap.Modal('#myModal', options)
   
})
