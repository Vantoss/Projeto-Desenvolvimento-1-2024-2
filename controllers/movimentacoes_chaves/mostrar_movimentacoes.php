
<?php 
header("Content-Type: application/json");
$conn = initDB();

try {

$_GET = getRequesData();

// exit(var_dump($_GET));

$selectSQL = "SELECT * FROM movimentacoes_chaves";

if(isset($_GET["id-chave"])){
    
    $id_chave = $_GET["id-chave"];

    verificarId("chaves",["id_chave"=> $id_chave]);

    $selectSQL .= " WHERE id_chave = $id_chave";
}

$stm = $conn->query($selectSQL);

if($stm->rowCount() > 0){
    $movimentacoes = $stm->fetchAll(PDO::FETCH_ASSOC);
    $resposta["status"] = 200;
    $resposta["movimentacoes"] = $movimentacoes;
} 

else {
    $resposta["status"] = 204;
    $resposta["msg"] = isset($id_chave) ?  "Chave de id-chave $id_chave não existe" : "Nenhuma chave cadastrada" ;
}

exit(json_encode($resposta));


} catch (Exception $err) {
    exit(json_encode([
        "status" => 400,
        "msg" => $err->getMessage()
    ]));
}
