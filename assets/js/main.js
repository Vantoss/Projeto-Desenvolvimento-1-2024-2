$(Document).ready(function(){
    $("#btn-buscar").on('click',function(){ // executa codigo abaixo com o click do botao "buscar"
        var filtros = { // define uma array associativa com os nomes dos filtros e seus valores que podem existir ou nao
            "sala" : $("#filtro-sala").val(),
            "turno" : $("#filtro-turno").val(),
            "data-inicio" : $("#filtro-data-inicio").val(),
            "data-fim" : $("#filtro-data-fim").val(),
            "registros" : $("#filtro-registros").val(),
            "diciplina" : $("#filtro-diciplina").val(),
            "docente" : $("#filtro-docente").val(),
        }

        $.ajax({ // envia a array filtros na forma de $_POST para o fetch.php
            url:"../includes/fetch.php",
            type:"POST",
            data: {filtros : filtros},
            beforeSend:function(){
                $("#container-tabela").html("<span>Procurando...</span>");
            },
            success:function(data){
                $("#container-tabela").html(data); // em caso de sucesso os dados sao carregados no container
            }
        });
    });
});


const myModal = document.getElementById('myModal')
const myInput = document.getElementById('myInput')

myModal.addEventListener('shown.bs.modal', () => {
  myInput.focus()
})