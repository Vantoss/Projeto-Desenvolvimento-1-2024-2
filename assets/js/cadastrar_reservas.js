
function disable_input_turma(btn_radio){
    if(btn_radio.id == "btn-cadastro-turma"){
        document.getElementById("turma-cadastrada").setAttribute("disabled","")
        inp = document.getElementsByClassName("input-cadastrar-turma");
        inp[0].removeAttribute("disabled")
        inp[1].removeAttribute("disabled")
        inp[2].removeAttribute("disabled")
        inp[3].removeAttribute("disabled")
        inp[4].removeAttribute("disabled")

    } else {
        inp = document.getElementsByClassName("input-cadastrar-turma");
        inp[0].setAttribute("disabled","")
        inp[1].setAttribute("disabled","")
        inp[2].setAttribute("disabled","")
        inp[3].setAttribute("disabled","")
        inp[4].setAttribute("disabled","")
        
        document.getElementById("turma-cadastrada").removeAttribute("disabled")
    }

}


function disableData_fim(select_tipo){
    if(select_tipo.value == "única"){
        document.getElementById("data-fim").setAttribute("disabled","")
    } else {
        document.getElementById("data-fim").removeAttribute("disabled")
    }
}







