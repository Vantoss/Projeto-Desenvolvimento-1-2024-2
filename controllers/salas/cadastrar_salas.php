<?php

// `id_sala` int(11) NOT NULL,
//   `tipo_sala` varchar(45) DEFAULT NULL,
//   `lugares_qtd` int(11) DEFAULT NULL COMMENT 'capacidade das salas (lotação)',
//   `maquinas_qtd` int(11) DEFAULT NULL,
//   `maquinas_tipo` varchar(45) DEFAULT NULL,
//   `descricao` text DEFAULT NULL
try {

    
    $sala_tipo = $_POST["tipo"] ? $_POST["tipo"] : new Exception("campo sala tipo vazio");
    
    $lugares_qtd = $_POST["lugares-qtd"] ? $_POST["lugares-qtd"] : new Exception("campo sala tipo vazio");
    
    $maquinas_qtd = $_POST["maquinas-qtd"] ? $_POST["maquinas-qtd"] : new Exception("campo sala tipo vazio");
    
    $maquinas_tipo = $_POST["maquinas-tipo"] ? $_POST["maquinas-tipo"] : new Exception("campo sala tipo vazio");
    
    $descricao = $_POST["descricao"] ? $_POST["descricao"] : new Exception("campo sala tipo vazio");
    
    
    $insertSQL = "INSERT INTO salas ( sala_tipo, lugares_qtd, maquinas_qtd, maquinas_tipo, descricao) 
        VALUES ('$sala_tipo', '$lugares_qtd', '$maquinas_qtd', '$maquinas_tipo', '$descricao')";
    
    $stm = $conn->prepare($insertSQL);
        
    !$stm->execute();

    gerarSalasJSON();
    
    echo json_encode([
        "status" => 200,
        "msg" => "Turma cadastrada com sucesso"
    ]);
 
} catch (\Throwable $err) {
    json_encode([
        "status" => 400,
        "msg" => $err->getMessage()
    ]);
}



