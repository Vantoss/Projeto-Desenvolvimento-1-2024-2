// BTN ABRIR MODAL EDITAR TURMA
$(document).on('click','.btn-editar-turma',function(){

    const id_turma = $(this).val()

    $("#inp-editar-turma-id").val(id_turma)

    console.log(id_turma)

    reqServidorGET({dados_turma:id_turma}, mostrarModalEditarTurma)

})

function mostrarModalEditarTurma(resposta){

    mostrarInputDadosTurma(resposta)

    $(".modal").modal('hide')
    
    $("#modal-editar-turma").modal('show')

}

function mostrarInputDadosTurma(resposta){

    let objTurma = JSON.parse(resposta)
                
    $("#inp-turma").val(objTurma.nome)
    $("#inp-docente").val(objTurma.docente)
    $("#inp-curso").val(objTurma.curso)
    $("#inp-participantes").val(objTurma.participantes_qtd)
}
