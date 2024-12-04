<?php
    $conn = initDB();
    // ARMAZENA O ID DA TURMA CASO A TURMA JA EXISTA
    if(isset($_POST["id-turma"])) $id_turma = $_POST["id-turma"];
    
    $turno = $_POST["turno"];
    
    $tipo_turma = $_POST["tipo-reserva"];

    // RODA CASO FOR UM NOVO CADASTRO 
    if($_POST["cadastro-turma"] == "nova"){
        
        require_once ROOT_DIR. "controllers/turmas/cadastrar_turmas.php";  
    }

        $id_sala = $_POST["id-sala"];
        
        $responsavel_cadastro = $_POST["responsavel-cadastro"];

        $datas = explode(",",$_POST["datas"]);
    
        $insertSQL = "INSERT INTO `reservas`(`data`, `id_sala`, `id_turma`, `responsavel_cadastro`) VALUES";    
        
        foreach ($datas as $data) {
            $insertSQL .= "('$data',$id_sala,$id_turma,'$responsavel_cadastro'),";
        }
        
        $insertSQL = substr_replace($insertSQL,"",-1);
        
        $stm = $conn->query($insertSQL);

         if($stm) { 
            $resposta["status"] = 200;

            $row_num = $stm->rowCount();

            $resposta["msg"] = $row_num > 1 ? $row_num . " reservas cadastradas com sucesso!" : "Reserva cadastrada com sucesso!"; 

        } else {

            $resposta["status"] = 400;
            $resposta["msg"] = "Erro ao tentar cadastrar as reservas";
        }
    

    echo json_encode($resposta);

