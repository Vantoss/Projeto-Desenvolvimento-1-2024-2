$(Document).ready(function(){

    // PESQUISA 
    
    $(".form-consulta").submit(function (e) { 
        e.preventDefault();
        var form = new FormData(this)
        
        if (this.id == "form-consultar-reservas"){
            
            form.append("consultar", "reservas")
        }
        
        if(this.id == "form-consultar-salas"){
            
            form.append("consultar","salas-disponiveis")

        }

        $.ajax({ 
            
            url:"../includes/server.php",
            type:"POST",
            processData: false,
            contentType: false,
            data: form,
            beforeSend:function(){
                $("#container-tabela").html("<span>Procurando...</span>")
                $("#container-tabela").css("display","block") 
            },
            success:function(data){
                $("#container-tabela").html(data) 
            }
            
        })
    })
    
})



