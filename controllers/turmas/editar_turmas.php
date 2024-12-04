<?php
// print_r($_SERVER);

// header("Content-type: application/json");

parse_str(file_get_contents('php://input'),$_PUT);

$conn = initDB();

$sql = [];

$updateSQL = "UPDATE turmas SET";

if($_PUT["nome"]) $sql[] = " nome = '{$_PUT["nome"]}'";

if($_PUT["docente"]) $sql[] = " docente = '{$_PUT["docente"]}'";

if($_PUT["participantes"]) $sql[] = " participantes_qtd = {$_PUT["participantes"]}";

if($_PUT["curso"]) $sql[] = " curso = '{$_PUT["curso"]}'";

if($_PUT["semestre"]) $sql[] = " semestre = '{$_PUT["semestre"]}'";


if($sql) $updateSQL .= implode(',',$sql) . " WHERE id_turma = {$_PUT["id-turma"]}";


// EXECUTANDO SQL
$stm = $conn->prepare($updateSQL);

if($stm->execute()){
    $resposta["status"] = 200;
    $resposta["msg"] = "Turma editada com sucesso";
}

gerarTurmasJSON();

echo json_encode($resposta);
