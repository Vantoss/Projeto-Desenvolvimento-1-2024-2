<?php

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



