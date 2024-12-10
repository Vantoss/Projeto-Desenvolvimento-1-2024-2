<?php 
header("Content-Type: application/json");
$conn = initDB();

try {

$_GET = getRequesData();

// exit(var_dump($_GET));

if(isset($_GET["status"])){
    
}

$tabela = isset($_GET["reservas"])? "chaves_reservas" : "chaves";

$selectSQL = "SELECT * FROM $tabela";

if(isset($_GET["retiradas"])){

    $selectSQL = "SELECT id_chave,nome_responsavel, acao as `status`, data_hora 
                  FROM movimentacoes_chaves AS c 
                  WHERE c.id_registro = (SELECT id_registro 
                            FROM `movimentacoes_chaves` 
                            WHERE id_chave = c.id_chave 
                            AND acao = 'retirada' 
                            ORDER BY id_registro 
                            DESC LIMIT 1);";
}
else if(isset($_GET["id-chave"])){
    
    $id_chave = (int) $_GET["id-chave"];

    $selectSQL .= " WHERE id_chave = $id_chave";
}

$stm = $conn->query($selectSQL);

if($stm->rowCount() > 0){
    $chaves = $stm->fetchAll(PDO::FETCH_ASSOC);
    $resposta["status"] = 200;
    $resposta["chaves"] = $chaves;


} else {
    $resposta["status"] = 204;
    $resposta["msg"] = isset($id_chave) ?  "Chave de id-chave $id_chave não existe" : "Nenhuma chave cadastrada" ;
}

exit(json_encode($resposta));


} catch (Exception $e) {
    exit(json_encode([
        "status" => 400,
        "msg" => $e->getMessage()
    ]));
}
