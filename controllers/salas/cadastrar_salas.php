<?php
    $conn = initDB();

    

try {


    



    $numero_sala = $_POST["numero-sala"] ? $_POST["numero-sala"] : new Exception("campo numero sala vazio",400);

    $tipo_sala = $_POST["tipo"] ? $_POST["tipo"] : new Exception("campo sala tipo vazio",400);
    
    $lotacao = $_POST["lotacao"] ? $_POST["lotacao"] : new Exception("campo lotação vazio",400);

    $unidade = $_POST["unidade"] ? $_POST["unidade"] : new Exception("campo unidade vazio",400);
    
    $maquinas_qtd = $_POST["maquinas-qtd"] ? $_POST["maquinas-qtd"] : new Exception("campo maquinas quantidade vazio",400);
    
    $maquinas_tipo = $_POST["maquinas-tipo"] ? $_POST["maquinas-tipo"] : new Exception("campo maquinas tipo vazio",400);
    
    $descricao = $_POST["descricao"] ?? null;

    $selectSQL = "SELECT 1 FROM salas WHERE numero_sala = $numero_sala AND unidade = $unidade LIMIT 1";

    
    $num = $conn->query($selectSQL)->rowCount();
    
    if($num){
        throw new Exception("Sala de numero $numero_sala na unidade $unidade já existe.");
    }
        
    $insertSQL = "INSERT INTO salas ( numero_sala, tipo_sala, unidade, lugares_qtd, maquinas_qtd, maquinas_tipo, descricao) 
        VALUES ('$numero_sala','$tipo_sala','$unidade', '$lotacao', '$maquinas_qtd', '$maquinas_tipo', '$descricao')";
    
    $stm = $conn->query($insertSQL);

    if($stm->rowCount() > 0){
        $resposta = [
            "status" => 200,
            "msg" => "Sala cadastrada com sucesso"
        ];

    } else {
        throw new Exception("Erro ao cadastrar sala",500);
    }

    gerarSalasJSON();
    
 
} catch (Exception $e) {
    $resposta = [
        "status" => $e->getCode(),
        "msg" => $e->getMessage()
    ];
}

exit(json_encode($resposta));



