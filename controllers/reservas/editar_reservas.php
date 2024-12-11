<?php

parse_str( file_get_contents('php://input'),$_PUT);

try {
    
$conn = initDB();

$sql = [];

$editar_registro = $_PUT["editar-reserva"];

$id_reserva = $_PUT["id-reserva"]; // id da reserva 

$id_turma = $_PUT["id-turma"]; // id da turma atual

$nova_turma = $_PUT["id-turma-nova"];// id da turma nova

if($_PUT["responsavel-cadastro"]) $sql[] = " responsavel_cadastro = '{$_PUT["responsavel-cadastro"]}'";

$updateSQL ="UPDATE reservas SET id_turma = $nova_turma,";


if($sql) $updateSQL .= implode(',',$sql);   


if($editar_registro == "atual"){

    $updateSQL .= " WHERE id_reserva = '$id_reserva'";
    
} else if ($editar_registro == "todos"){
    
    $updateSQL .= " WHERE id_turma = '$id_turma'";

} else {
    // TROCA A TURMA EM TODAS AS RESERVAS QUE A TURMA ANTIGA ESTA CADASTRADA APARTIR (DATA) DA SELECIONADA
    $selectSQL = "SELECT data FROM reservas WHERE id_reserva = $id_reserva";

    $reserva = $conn->query($selectSQL)->fetch(PDO::FETCH_ASSOC);

    if($reserva){
        
        $data = $reserva["data"];
        $updateSQL .= " WHERE id_turma = '$id_turma' AND DATE(data) >= '$data'";

    } else {
        throw new Exception("Erro ao consultar os dados da reserva",500);
        
    }
}


if(isset($updateSQL)){
    $row_num = $conn->query($updateSQL)->rowCount();

    if($row_num > 0){
        $resposta["status"] = 200;
        
        if($row_num > 1){            
            $resposta["msg"] = $row_num . " reservas alteradas com sucesso";

        } else {
            $resposta["msg"] = "Reserva alterada com sucesso";
            
        }
        
    } else {
        throw new Exception("Erro ao alterar dados da reservas",500);
    }
}
    
} catch (Exception $e) {
    $resposta = [
        "status" => $e->getCode(),
        "msg" => $e->getMessage()
    ];
}

exit(json_encode($resposta));
