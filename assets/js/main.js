$(Document).ready(function(){


    

    // PESQUISA CONSULTAR RESERVAS 
    
    $("#form-consulta").on('submit',function (e) { 
        e.preventDefault();

        $.ajax({ // envia a array filtros no forma $_POST para o arquivo/funcao 
            // que ira fazer a pesquisa e retornar uma tabela com as reservas cadastradas
            url:"../includes/functions/func_consultar_reservas.php",
            type:"POST",
            data: $(this).serialize(),
            beforeSend:function(){
                $("#container-tabela").html("<span>Procurando...</span>")
                $("#container-tabela").css("display","block") // em caso de sucesso os dados sao carregados no container
            },
            success:function(data){
                $("#container-tabela").html(data) // em caso de sucesso os dados sao carregados no container
            }
            
        })
    })
    
    $("#form-consultar-salas-disponiveis").submit(function (e) { 
        e.preventDefault();

        $.ajax({ // envia a array filtros no forma $_POST para o arquivo/funcao 
            // que ira fazer a pesquisa e retornar uma tabela com as reservas cadastradas
            url:"../includes/functions/func_consultar_salas_disponiveis.php",
            type:"POST",
            data: $(this).serialize(),
            beforeSend:function(){
                $("#container-tabela").html("<span>Procurando...</span>")
                $("#container-tabela").css("display","block")
            },
            success:function(data){
                $("#container-tabela").html(data) // em caso de sucesso os dados sao carregados no container

            }
            
        })
    })
})





// const myModal = document.getElementById('myModal')
// const myInput = document.getElementById('myInput')

// myModal.addEventListener('shown.bs.modal', () => {
    //   myInput.focus()
    // })
    // executa codigo abaixo com o click do botao "buscar"
       // var filtros = { // define uma array associativa com os nomes dos filtros e seus valores 
       //     "filtro-tipo" : $("#btn-buscar").val(),
       //     "data-inicio" : $("#input-data-inicio").val(),
       //     "data-fim" : $("#input-data-fim").val(),
       //     "sala" : $("#input-sala").val(),
       //     "turno" : $("#input-turno").val(),
       //     "reserva-tipo" : $("#input-sala-tipo").val(),
       //     "registros" : $("#input-registros").val(),
       // }
       
       // if ($("#btn-buscar").val() == "consultar-reservas"){
       //     filtros["diciplina"] = $("#input-diciplina").val()
       //     filtros["docente"] = $("#input-docente").val()
           
       // } else {
       //     filtros["maquinas-qtd"] = $("#input-maquinas-qtd").val()
       //     filtros["maquinas-tipo"] = $("#input-maquinas-tipo").val()
       //     filtros["lugares-qtd"] = $("#input-lugares-qtd").val()
       //     filtros["sala-tipo"] = $("#input-sala-tipo").val()
       // }