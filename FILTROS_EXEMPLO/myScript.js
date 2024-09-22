$(Document).ready(function(){
    $("#buscar").on('click',function(){ // executa codigo abaixo com o click do botao "buscar"
        var filtros = { // define uma array associativa com os nomes dos filtros e seus valores que podem existir ou nao
            "sala" : $("#sala").val(),
            "turno" : $("#turno").val(),
            "data-inicio" : $("#data-inicio").val(),
            "data-fim" : $("#data-fim").val(),
            "registros" : $("#registros").val(),
            "diciplina" : $("#diciplina").val(),
            "docente" : $("#docente").val(),
        }

        $.ajax({ // envia a array filtros na forma de $_POST para o fetch.php
            url:"fetch.php",
            type:"POST",
            data: {filtros : filtros},
            beforeSend:function(){
                $(".container").html("<span>Procurando...</span>");
            },
            success:function(data){
                $(".container").html(data); // em caso de sucesso os dados sao carregados no container
            }
        });
    });
});