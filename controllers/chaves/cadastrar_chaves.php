<?php
header("Content-Type: application/json");
$conn = initDB();
try {

$_POST = getRequesData();
 
$id_sala = $_POST["id-sala"];


verificarId("salas",["id_sala" =>$id_sala]);


$tabela = isset($_GET["reservas"])? "chaves_reservas" : "chaves"; 

    $insertSQL = "INSERT INTO $tabela (id_sala)
    VALUES ('$id_sala')";


$stm = $conn->prepare($insertSQL);
    

if(!$stm->execute() or $stm->rowCount() == 0){
        
    exit(json_encode([
        "status" => 400,
        "msg" => "Erro ao tentar cadastrar chave"
    ]));
}

exit(json_encode([
    "status" => 200,
    "msg" => "Chave cadastrada com sucesso"
]));


} catch (Exception $e) {
    exit(json_encode([
        "status" => 400,
        "msg" => $e->getMessage()
    ]));
}
