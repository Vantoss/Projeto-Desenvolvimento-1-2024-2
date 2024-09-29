
function disableData_fim(select_tipo){
    if(select_tipo.value == "única"){
        document.getElementById("data-fim").setAttribute("disabled","")
    } else {
        document.getElementById("data-fim").removeAttribute("disabled")
    }
}







