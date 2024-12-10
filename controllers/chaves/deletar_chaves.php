<?php
header("Content-Type: application/json");
$conn = initDB();
try {

    $_DELETE = getRequesData();

//  exit(var_dump($_DELETE));

if(!isset($_DELETE["id-chave"])){

    exit(json_encode([
        "status" => 400,
        "msg" => "Um campo 'id-chave' precisa definido no corpo da requisição"
    ]));
}

$id_chave = (int) $_DELETE["id-chave"];

verificarId("chaves",["id_chave" => $id_chave]);

$tabela = isset($_GET["reservas"]) ? "chaves_reservas" : "chaves";


$deleteSQL = "DELETE FROM $tabela WHERE id_chave = $id_chave";


$stm = $conn->prepare($deleteSQL);
    
if(!$stm->execute() or $stm->rowCount() == 0){
        
    exit(json_encode([
        "status" => 400,
        "msg" => "Erro ao tentar deletar chave"
    ]));
}

exit(json_encode([
    "status" => 200,
    "msg" => "Chave deletada com sucesso"
]));


} catch (\Throwable $err) {
    exit(json_encode([
        "status" => 400,
        "msg" => $err->getMessage()
    ]));
}
