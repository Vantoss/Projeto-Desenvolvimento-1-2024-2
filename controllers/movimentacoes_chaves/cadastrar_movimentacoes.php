<?php
header("Content-Type: application/json");
$conn = initDB();

try {

$_POST = getRequesData();
 
$id_chave = $_POST["id-chave"];

$nome_responsavel = $_POST["nome-responsavel"];

verificarId("chaves",["id_chave" => $id_chave]);

$selectSQL = "SELECT count(*) FROM movimentacoes_chaves WHERE id_chave = $id_chave";

$num_rows = $conn->query($selectSQL)->fetchColumn();

// exit(var_dump($num_rows));

if($num_rows % 2 == 0){
    $status = "retirada";
    $acao = "retirada";
} else {
    $acao = "devolvida";
    $status = "disponível";
}

$updateSQL = "UPDATE chaves SET `status` = '$status' WHERE id_chave = $id_chave";

$conn->query($updateSQL);

$data_hora = date('Y-m-d H:i:s');

$insertSQL ="INSERT INTO movimentacoes_chaves (id_chave, nome_responsavel, acao, data_hora)
VALUES($id_chave,'$nome_responsavel','$acao','$data_hora')";
// exit(var_dump($conn->exec($insertSQL)));

$stm = $conn->prepare($insertSQL);
if($stm->execute() && $stm->rowCount() > 0){
    exit(json_encode([
        "status" => 203,
        "msg" => "Chave $acao com sucesso",
        "data_hora" =>$data_hora
    ]));
    
} else {
    
    exit(json_encode([
        "status" => 400,
        "msg" => "Nao foi possivel $acao chave",
    ]));
}

} catch (Exception $e) {
    exit(json_encode([
        "status" => 400,
        "msg" => $e->getMessage()
    ]));
}
