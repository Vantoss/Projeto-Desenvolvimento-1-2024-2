
function disable_input_turma(btn_radio){
    if(btn_radio.id == "btn-cadastro-turma"){

        document.getElementById("turma-cadastrada").setAttribute("disabled","")

        inp = document.getElementsByClassName("input-cadastrar-turma");
        for (i = 0; i <= 4; i++){
            inp[i].removeAttribute("disabled")
        }
   

    } else {

        document.getElementById("turma-cadastrada").removeAttribute("disabled")
        inp = document.getElementsByClassName("input-cadastrar-turma");
        for (i = 0; i <= 4; i++){
            inp[i].setAttribute("disabled","")
        }
        
        
    }

}


function disableData_fim(select_tipo){
    if(select_tipo.value == "única"){
        document.getElementById("data-fim").setAttribute("disabled","")
        $("#data-fim").val('')

    } else {
        document.getElementById("data-fim").removeAttribute("disabled")
    }
}







