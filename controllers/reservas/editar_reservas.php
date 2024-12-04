<?php

parse_str( file_get_contents('php://input'),$_PUT);

$conn = initDB();

$editar_registro = $_PUT["editar-reserva"];

$id_reserva = $_PUT["id-reserva"]; // id da reserva 

$id_turma = $_PUT["id-turma"]; // id da turma atual

$nova_turma = $_PUT["id-turma-nova"];// id da turma nova

if($editar_registro == "atual"){

    $updateSQL = "UPDATE reservas SET id_turma = '$nova_turma' WHERE id_reserva = '$id_reserva'";
    
} else if ($editar_registro == "todos"){
    
    $updateSQL = "UPDATE reservas SET id_turma = '$nova_turma' WHERE id_turma = '$id_turma'";

} else {
    // TROCA A TURMA EM TODAS AS RESERVAS QUE A TURMA ANTIGA ESTA CADASTRADA APARTIR (DATA) DA SELECIONADA
    $selectSQL = "SELECT data FROM reservas WHERE id_reserva = $id_reserva";
    $stm = $conn->query($selectSQL);
    if($stm){
        $reserva = $stm->fetch(PDO::FETCH_ASSOC);
        $data = $reserva["data"];
        $updateSQL = "UPDATE reservas SET id_turma = '$nova_turma' WHERE id_turma = '$id_turma' AND DATE(data) >= '$data'";
    } else {
        $resposta["status"] = 400;
        $resposta["msg"] = "Erro ao consultar os dados da reserva";
    }
}

if(isset($updateSQL)){
    $stm = $conn->prepare($updateSQL);
    if($stm->execute()){
        $resposta["status"] = 200;
        
        $row_num = $stm->rowCount();

        if($row_num > 1){
            
            $resposta["msg"] = $row_num . " reservas alteradas com sucesso";
        } else {
            $resposta["msg"] = "Reserva alterada com sucesso";
            
        }
        
    } else {
        $resposta["status"] = 400;
        $resposta["msg"] = "Erro ao alterar reservas";
    }
}

echo json_encode($resposta);
