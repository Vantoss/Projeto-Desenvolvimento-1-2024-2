<?php 

parse_str( file_get_contents('php://input'),$_DELETE);

$conn = initDB();

$id_reserva = $_DELETE["id-reserva"];

$id_turma = $_DELETE["id-turma"];

if($_DELETE["del-reservas"] == "atual"){

    // deleta uma unica reserva    
    $stm = $conn->prepare("DELETE FROM reservas WHERE id_reserva = '$id_reserva'");
    
    $resposta["msg"] = $stm->execute() ? "Reserva deletada com sucesso!" : "Erro ao tentar deletar reserva";
    
} else if ($_DELETE["del-reservas"] == "apartir"){
    // busca os dados id_turma e data para executar o delete de multiplas reservas 
    $selectSQL = "SELECT r.data AS 'data' FROM reservas AS r WHERE id_reserva = $id_reserva";

    $stm = $conn->prepare($selectSQL);
    if(!$stm->execute()){

        $resposta["msg"] = "Erro ao tentar buscar os dados da reserva";

    } else {

        if($arr = $stm->fetch(PDO::FETCH_ASSOC)){

            $deleteSQL = "DELETE FROM reservas WHERE id_turma = '$id_turma' AND data >= '{$arr["data"]}'";

            // echo $delete;
            $stm = $conn->prepare($deleteSQL);
            $resposta["msg"] = $stm->execute() ? $stm->rowCount(). " reservas deletadas com sucesso!" : "Erro ao tentar deletar as reservas";

        } else {
            $resposta["msg"] = "Nenhuma reserva deletada";
        }

    }
    
} else {
    
    $deleteSQL = "DELETE FROM reservas WHERE id_turma = '$id_turma'";
    $stm = $conn->prepare($deleteSQL);
    $resposta["msg"] = $stm->execute() ? $stm->rowCount(). " reservas deletadas com sucesso!" : "Erro ao tentar deletar as reservas";
}

echo json_encode($resposta);
