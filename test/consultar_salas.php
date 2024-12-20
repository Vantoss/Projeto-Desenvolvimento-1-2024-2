<?php 

//  =========================== CONSULTAR RESERVA ======================================

define('ROOT_DIR', '../');

require_once ROOT_DIR. 'includes/functions.php';


// =====================================================================================================================
// CONSULTAR RESERVA ===================================================================================================
// =====================================================================================================================

$conn = initDB();

if(isset($_GET["consultar"])){
    
    
    // SERVER REQUEST CONSULTAR RESERVAS
    if($_GET["consultar"] == "reservas"){

        $dados_tabela["reserva_status"] = $_GET["reserva_status"];
        
        $sql = [];
        
        // filtro turma
        if($_GET["turma"]){
            $turma = trim(preg_replace('/\s+/', ' ', $_GET["turma"]));
            $sql[] = " t.nome LIKE '$turma%'";
        } 
        
        // filtro docente
        if($_GET["docente"]) {
            $docente = trim(preg_replace('/\s+/', ' ', $_GET["docente"]));
            $sql[] = " t.docente LIKE '$docente%'";
        }
        
        //filtro curso
        if($_GET["curso"]){
            $curso = trim(preg_replace('/\s+/', ' ', $_GET["curso"]));
            $sql[] = " t.curso LIKE '$curso%'";
        } 
        
        // filtro sala 
        if($_GET["sala"]) $sql[] = " s.id_sala = '{$_GET["sala"]}'";
        
        // filtro turno
        if($_GET["turno"]) $sql[] = " t.turno = '{$_GET["turno"]}'";
        
        // filtro tipo_reserva
        if($_GET["tipo_reserva"]) $sql[] = " r.tipo_reserva = '{$_GET["tipo_reserva"]}'"; 
        
        // filtro data inicio
        if($_GET["data_inicio"]) $sql[] = " DATE(data) >= '{$_GET["data_inicio"]}'"; 
        
        // filtro data fim
        if($_GET["data_fim"]) $sql[] = " DATE(data) <= '{$_GET["data_fim"]}'"; 
        
        if($_GET["reserva_status"] == "Ativa"){

            // PESQUISA BASE CONSULTAR RESERVAS
            $insertSQL = "SELECT r.id_sala as 'sala',
                        r.id_reserva as 'id_reserva', 
                        s.tipo_sala as 'sala_tipo', 
                        r.data as 'data',
                        r.tipo_reserva as 'reserva',
                        t.id_turma as id_turma,
                        t.nome as 'turma',
                        t.docente as 'docente', 
                        t.turno as 'turno', 
                        CONCAT(t.participantes_qtd, '/', s.lugares_qtd) as 'lugares_qtd' 
                FROM reservas as r
                INNER JOIN turmas as t 
                ON r.id_turma = t.id_turma
                INNER JOIN salas as s
                ON r.id_sala = s.id_sala";
                
        } else {

            $insertSQL = "SELECT r.id_sala as 'sala',
                        r.id_reserva as 'id_reserva', 
                        s.tipo_sala as 'sala_tipo', 
                        r.data as 'data',
                        r.tipo_reserva as 'reserva',
                        r.nome_turma as 'turma',
                        r.docente as 'docente', 
                        r.turno as 'turno', 
                        CONCAT(r.participantes, '/', s.lugares_qtd) as 'lugares' 
                FROM reservas_historico as r
                INNER JOIN salas as s
                ON r.id_sala = s.id_sala";

        }
        
        
        // coloca na posicao correta as tags WHERE e AND (WHERE é sempre a primeira tag, seguido pelos AND)
        if($sql) $insertSQL .= ' WHERE ' .implode(' AND ',$sql); 
        
    
        
        // echo  "<hr>" . $query . "<hr>"; // mostra a pesquisa para teste
        
        $insertSQL .= " ORDER BY id_reserva";

        $stm = $conn->prepare($insertSQL);

        if(!$stm->execute()){

            $resposta["status"] = 400;
            $resposta["msg"] = "Erro ao bucar os dados no banco";

        } else {
            
            if($reservas = $stm->fetchAll(PDO::FETCH_ASSOC)){
                
                $dados_tabela["status"] = 200;
                $dados_tabela["reservas"] = $reservas;
                
            } else {
                
                $dados_tabela["status"] = 204;
                $dados_tabela["msg"] = "Nenhum resultado encontrado";
                
            }

            if (!file_exists(ROOT_DIR. 'JSON/dados_tabela_reservas.json')) {
                touch(ROOT_DIR. 'JSON/dados_tabela_reservas.json');
            }
            file_put_contents(ROOT_DIR.'JSON/dados_tabela_reservas.json', json_encode($dados_tabela));
            
            if($reservas){

                $resposta["status"] = 200;
                $resposta["msg"] = "Dados tranferidos para o arquivo json";
                
            } else {
                
                $resposta["status"] = 204;
                $resposta["msg"] = "Nenhum resultado encontrado";
            }
            
        }
        
        
        echo json_encode($resposta);
    }
    
    
    // ===================================================================================================================================
    // CONSULTAR SALAS DISPONIVEIS =======================================================================================================
    // ===================================================================================================================================
    
    
    if($_GET["consultar"] == "salas_disponiveis"){
        
        
        $sql = []; //guarda os parametros da pesquisa sql
        
        // filtro sala 
        if($_GET["sala"]) $sql[] = " s.id_sala = '{$_GET["sala"]}'"; 
        
        // filtro lugares quantidade
        
        if($_GET["sala_tipo"]) $sql[] = " s.tipo_sala = '{$_GET["sala_tipo"]}'";
        
        // filtro maquinas quantidade
        if($_GET["maquinas_qtd"] >= 0) {
            
            $maquinas_qtd = intval($_GET["maquinas_qtd"]);

            $sql[] = " s.maquinas_qtd >= '$maquinas_qtd'";}
        
        // filtro maquinas_tipo
        if($_GET["maquinas_tipo"]) $sql[] = " s.maquinas_tipo LIKE '{$_GET["maquinas_tipo"]}%'";
        
        // filtro lugares quantidade
        if($_GET["lugares_qtd"]) $sql[] = " s.lugares_qtd = '{$_GET["lugares_qtd"]}'";
        
        
        
        $insertSQL = "SELECT s.id_sala as 'sala',
                         s.tipo_sala as 'sala_tipo',
                         s.lugares_qtd as 'lugares',
                         s.maquinas_qtd as 'maquinas_qtd',
                         s.maquinas_tipo as 'maquinas_tipo'
                  FROM salas as s";
        
        $sql[] = " s.id_sala NOT IN (SELECT s.id_sala from salas as s 
                    INNER JOIN reservas as r 
                    ON s.id_sala = r.id_sala 
                    INNER JOIN turmas as t 
                    ON r.id_turma = t.id_turma";
        
        // coloca na posicao correta as tags WHERE e AND (WHERE é sempre a primeira tag, seguido pelos AND)
        if($sql) $insertSQL .= ' WHERE ' .implode(' AND ',$sql) . " WHERE ";
        
        $tipo_reserva = $_GET["tipo_reserva"];

        if($tipo_reserva == "Avulsa") {
            $insertSQL .= " DATE(data) = '{$_GET["data_inicio"]}'";
            $dias = $_GET["data_inicio"];

        } else if ($tipo_reserva == "Graduacao") {

            $dias = "";
            $data_inicial = strtotime("{$_GET['data_inicio']}");
            
            if(isset($_GET["data_fim"])){

                $data_final = strtotime("{$_GET['data_fim']}", $data_inicial);
                
                while ($data_inicial <= $data_final) {
                    $dias .=  date("'Y-m-d',", $data_inicial);                             
                    $data_inicial = strtotime("+1 week", $data_inicial);
                }
                
            } else {
                
                $econtros = $_GET["num_encontros"];
                
                for ($i=0; $i < $econtros; $i++) { 
                    $dias .=  date("'Y-m-d',", $data_inicial);
                    $data_inicial = strtotime("+1 week", $data_inicial);
                }
            }

            $dias = substr_replace($dias,"",-1);    
            
            $insertSQL .= "DATE(data) IN ($dias)";
        }
        
        // filtro turno
        $insertSQL .= $_GET["turno"] ? " AND t.turno = '{$_GET["turno"]}')": ")";
        
            // echo  "<hr>" . $query . "<hr>"; // mostra a pesquisa para teste
        
            // prepara a pesquisa para ser executada
            $stm = $conn->prepare($insertSQL);
        
            if($stm->execute()){

                $datas = str_replace(array("'"),array(""),$dias);
                $datas = explode(",",$datas);
                
                $salas = $stm->fetchAll(PDO::FETCH_ASSOC);

                $dados_tabela = [
                    "datas" => $datas,
                    "turno" => $_GET["turno"],
                    "tipo_reserva" => $_GET["tipo_reserva"],
                    "salas" => $salas
                ];

                if($salas){

                    if (!file_exists(ROOT_DIR. 'JSON/dados_tabela_salas.json')) {
                        touch(ROOT_DIR. 'JSON/dados_tabela_salas.json');
                    }
                    file_put_contents(ROOT_DIR.'JSON/dados_tabela_salas.json', json_encode($dados_tabela));

                    $resposta["status"] = 200;
                    $resposta["msg"] = "Dados tranferidos para o arquivo json";

                } else {
                    $resposta["status"] = 204;
                    $resposta["msg"] = "Nenhum resultado encontrado";
                }

            } else {
                $resposta["status"] = 400;
                $resposta["msg"] = "Erro ao bucar os dados no banco";
            }
            
            echo json_encode($resposta);
            
        }
        
    }
    
        
// =====================================================================================================================
// DELETAR RESERVA =====================================================================================================
// =====================================================================================================================

        
if(isset($_POST["del_reservas"] )){
    
    $id_reserva = $_POST["id_reserva"];
    $id_turma = $_POST["id_turma"];

    if($_POST["del_reservas"] == "atual"){

        // deleta uma unica reserva    
        $stm = $conn->prepare("DELETE FROM reservas WHERE id_reserva = '$id_reserva'");
        
        $resposta["msg"] = $stm->execute() ? "Reserva deletada com sucesso!" : "Erro ao tentar deletar reserva";
        
    } else if ($_POST["del_reservas"] == "apartir"){
        // busca os dados id_turma e data para executar o delete de multiplas reservas 
        $selectSQL = "SELECT r.data AS 'data' FROM reservas AS r WHERE id_reserva = $id_reserva";

        $stm = $conn->prepare($selectSQL);
        if(!$stm->execute()){
    
            $resposta["msg"] = "Erro ao tentar buscar os dados da reserva";
    
        } else {

            if($arr = $stm->fetch(PDO::FETCH_ASSOC)){

                $delete = "DELETE FROM reservas WHERE id_turma = '$id_turma' AND data >= '{$arr["data"]}'";

                // echo $delete;
                $stm = $conn->prepare($delete);
                $resposta["msg"] = $stm->execute() ? $stm->rowCount(). " reservas deletadas com sucesso!" : "Erro ao tentar deletar as reservas";

            } else {
                $resposta["msg"] = "Nenhuma reserva deletada";
            }

        }
        
    } else {
        
        $delete = "DELETE FROM reservas WHERE id_turma = '$id_turma'";
        $stm = $conn->prepare($delete);
        $resposta["msg"] = $stm->execute() ? $stm->rowCount(). " reservas deletadas com sucesso!" : "Erro ao tentar deletar as reservas";
    }
    
    echo json_encode($resposta);
}


// =====================================================================================================================
// CADASTRAR RESERVA ===================================================================================================
// =====================================================================================================================


if(isset($_POST["cadastrar-reserva"])){
    
    
    // ARMAZENA O ID DA TURMA CASO A TURMA JA EXISTA
    if(isset($_POST["id_turma"])) $id_turma = $_POST["id_turma"];
    
    $turno = $_POST["turno"];
    
    $tipo_reserva = $_POST["tipo_reserva"];

    // RODA CASO FOR UM NOVO CADASTRO 
    if($_POST["cadastro-turma"] == "nova"){
        
        // DADOS DA TURMA NOVA 
        $nome = $_POST["turma"] ? $_POST["turma"] : exit("ERRO: O CAMPO 'TURMA' ESTA VAZIO");
        
        $curso = $_POST["curso"] ? $_POST["curso"] : exit("ERRO: O CAMPO 'CURSO' ESTA VAZIO");
        
        $docente = $_POST["docente"] ? $_POST["docente"] : exit("ERRO: O CAMPO 'DOCENTE' ESTA VAZIO");
        
        $participantes = $_POST["participantes"] ? $_POST["participantes"] : exit("ERRO: O CAMPO 'PARTICIPANTES' ESTA VAZIO");
        
        
        $insertSQL = "INSERT INTO  turmas ( nome, curso, docente, turno, tipo_reserva, participantes_qtd) 
                VALUES ('$nome', '$curso', '$docente', '$turno','$tipo_reserva', $participantes)";
                
                
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
    }

        
        $id_sala = $_POST["id_sala"];
        

        $datas = explode(",",$_POST["datas"]);
    
        $insertSQL = "INSERT INTO `reservas`(`data`, `tipo_reserva`, `id_sala`, `id_turma`) VALUES";    
        
        foreach ($datas as $data) {
            $insertSQL .= "('$data','$tipo_reserva',$id_sala,$id_turma),";
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
}


// =====================================================================================================================
// EDITAR TURMA/RESERVA ================================================================================================
// =====================================================================================================================


if(isset($_POST["editar_turma"])){
    var_dump($_POST);

    // $resposta = editarTurma($_POST);

    echo json_encode($resposta);
}



if(isset($_POST["editar_reserva"])){

    $editar_registro = $_POST["editar_reserva"];

    $id_reserva = $_POST["id_reserva"]; // id da reserva 

    $id_turma = $_POST["id_turma"]; // id da turma atual

    $nova_turma = $_POST["id_turma_nova"];// id da turma nova

    if($editar_registro == "atual"){

        $updateSQL = "UPDATE reservas SET id_turma = '$nova_turma' WHERE id_reserva = '$id_reserva'";
        
    } else if ($editar_registro == "todos"){
        
        $updateSQL = "UPDATE reservas SET id_turma = '$nova_turma' WHERE id_turma = '$id_turma'";

    } else {
        // TROCA A TURMA EM TODAS AS RESERVAS QUE A TURMA ANTIGA ESTA CADASTRADA APARTIR (DATA) DA SELECIONADA
        $selectSQL = "SELECT data FROM reservas WHERE id_reserva = $id_reserva";
        $stm = $conn->query($selectSQL);
        if($stm){
            $reserva = $stm->fetch(PDO::FETCH_ASSOC);
            $data = $reserva["data"];
            $updateSQL = "UPDATE reservas SET id_turma = '$nova_turma' WHERE id_turma = '$id_turma' AND DATE(data) >= '$data'";
        } else {
            $resposta["status"] = 400;
            $resposta["msg"] = "Erro ao consultar os dados da reserva";
        }
    }

    if(isset($updateSQL)){
        $stm = $conn->prepare($updateSQL);
        if($stm->execute()){
            $resposta["status"] = 200;
            
            $row_num = $stm->rowCount();

            if($row_num > 1){
                
                $resposta["msg"] = $row_num . " reservas alteradas com sucesso";
            } else {
                $resposta["msg"] = "Reserva alterada com sucesso";
                
            }
            
        } else {
            $resposta["status"] = 400;
            $resposta["msg"] = "Erro ao alterar reservas";
        }
    }

    echo json_encode($resposta);
}


// =====================================================================================================================
// CONSULTAR TURMAS ===================================================================================================
// =====================================================================================================================

if(isset($_GET["dados_turma"])){

    if (!file_exists(ROOT_DIR. 'JSON/dados_turmas.json')) {
        gerarTurmasJSON();
    }

    $dadosJSON = json_decode(file_get_contents(ROOT_DIR. 'JSON/dados_turmas.json'),true);

    $turmas = $dadosJSON["turmas"];
     
    $id_turma = $_GET["dados_turma"];
    foreach ($turmas as $turma) {
        if($turma["id_turma"] == $id_turma){
            
            require_once ROOT_DIR."includes/components/containers/dados_turma.php";
            break;
        }
    }


}

if(isset($_GET["num_reservas_turma"])){

    $id_turma = $_GET["num_reservas_turma"];

    $selectSQL = "SELECT count(1) as 'reservas_num' FROM reservas WHERE id_turma = '$id_turma'";

    $stm = $conn->prepare($selectSQL);
    $stm->execute();
    $arr = $stm->fetch(PDO::FETCH_ASSOC);

    $reservas_num = $arr["reservas_num"];

    $resposta["msg"] = "<p>Certeza que deseja deletar a turma selecionada?";

    if($reservas_num == 1){
        $resposta["msg"] .= '<br>Uma reserva tambem sera deletada</p>';
    }
    else if ($reservas_num > 1) {
        $resposta["msg"] .= '<br>'. $reservas_num." reservas tambem serao deletadas";
    }
    
    echo json_encode($resposta);
}



// GERAR OPTIONS TURMA
if(isset($_GET["turmas_options"])){

    $id_turma = isset($_GET["id_turma"]) ? $_GET["id_turma"] : null;

    // optionsTurmas($_GET["turno"],$_GET["datas"],$id_turma );

}

if(isset($_POST["deletar_turma"])){
    
    $id_turma = $_POST["id_turma"];

    $delete = "DELETE FROM reservas WHERE id_turma = '$id_turma'";
    $stm = $conn->prepare($delete);
    
    $del_msg = "";

    if(!$stm->execute()){
        $del_msg = "Erro ao deletar reservas";    
    }

    $row_num = $stm->rowCount();

     if($row_num == 1) {
        $del_msg = "Uma reserva tambem foi deletada";
     } 
     else if($row_num > 1){
        $del_msg = $row_num. " reservas tambem foram deletadas";
     }
    
    $delete = "DELETE FROM turmas WHERE id_turma = '$id_turma'";
    $stm = $conn->prepare($delete);
    $resposta["msg"] = $stm->execute() ?  "Turma deletada com sucesso! " : "Erro ao deletar turma ";

    $resposta["msg"].= $del_msg;

    gerarTurmasJSON();

    echo json_encode($resposta);
    
}

if(isset($_GET["sala_dados"])){

    // echo json_encode(salaDados($_GET["sala_dados"]));
}

            
?>
    
    