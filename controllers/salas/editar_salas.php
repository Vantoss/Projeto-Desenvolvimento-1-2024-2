<?php

$conn = initDB();

parse_str( file_get_contents('php://input'),$_PUT);

try {
    //code...

$id_sala = $_PUT["id-sala"];

$sql = [];

$updateSQL = "UPDATE salas SET";


if($_PUT["tipo"]) $sql[] = " tipo_sala = '{$_PUT["tipo"]}'";

if($_PUT["lotacao"]) $sql[] = " lugares_qtd = '{$_PUT["lotacao"]}'";

if($_PUT["maquinas-tipo"]) $sql[] = " maquinas_tipo = '{$_PUT["maquinas-tipo"]}'";

if($_PUT["maquinas-qtd"]) $sql[] = " maquinas_qtd = '{$_PUT["maquinas-qtd"]}'";

if($_PUT["descricao"]) $sql[] = " descricao = '{$_PUT["descricao"]}'";


if($sql) $updateSQL .= implode(',',$sql) . " WHERE id_sala = $id_sala";


// EXECUTANDO SQL
$stm = $conn->prepare($updateSQL);

if($stm->execute()){
    $resposta["status"] = 200;
    $resposta["msg"] = "Sala editada com sucesso";
}

} catch (\Throwable $th) {
    $resposta["status"] = 500;
    $resposta["msg"] = "Erro ao editar sala";
}

gerarSalasJSON();

exit(json_encode($resposta));