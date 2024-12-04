<?php

parse_str( file_get_contents('php://input'),$_DELETE);

$conn = initDB();

    $id_turma = $_DELETE["id-turma"];

    $delete = "DELETE FROM reservas WHERE id_turma = '$id_turma'";
    $stm = $conn->prepare($delete);
    
    $del_msg = "";

    if(!$stm->execute()){
        $del_msg = "Erro ao deletar reservas";    
    }

    $row_num = $stm->rowCount();

     if($row_num == 1) {
        $del_msg = "Uma reserva tambem foi deletada";
     } 
     else if($row_num > 1){
        $del_msg = $row_num. " reservas tambem foram deletadas";
     }
    
    $delete = "DELETE FROM turmas WHERE id_turma = '$id_turma'";
    $stm = $conn->prepare($delete);


    $resposta["msg"] = $stm->execute() && $stm->rowCount() ?  "Turma deletada com sucesso! " : "Erro ao deletar turma ";

    $resposta["msg"].= $del_msg;

    gerarTurmasJSON();

    echo json_encode($resposta);
