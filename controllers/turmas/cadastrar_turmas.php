<?php
    $conn = initDB();

    $tipo_turma = isset($_POST["tipo-reserva"]) ? $_POST["tipo-reserva"] : $_POST["tipo-turma"]; 
    
    $participantes = (int) $_POST["participantes"];
    
    $insertSQL = "INSERT INTO  turmas ( nome, curso, docente, semestre, tipo_turma, turno,  participantes_qtd) 
            VALUES ('{$_POST["nome"]}', '{$_POST["curso"]}', '{$_POST["docente"]}','{$_POST["semestre"]}', '$tipo_turma', '{$_POST["turno"]}', $participantes)";
            
    $stm = $conn->prepare($insertSQL);
    
    if(!$stm->execute()){
        
        exit(json_encode([
            "status" => 400,
            "msg" => "Erro ao tentar cadastrar turma"
        ]));
        
    } else {
        // ARMAZENA O ID DA TURMA QUE FOI CRIADA NO CODIGO ACIMA
        $id_turma = $conn->lastInsertId();
        // atualiza os dados do arquivo "dados_turmas.json"
        gerarTurmasJSON();

    } 

    if(!isset($_POST["cadastro-turma"])){

        echo json_encode([
            "status" => 200,
            "msg" => "Turma cadastrada com sucesso"
        ]);
    }