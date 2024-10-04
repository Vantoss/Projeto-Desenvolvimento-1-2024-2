<?php 

//  =========================== CONSULTAR RESERVA ======================================

define('__ROOT__', dirname(dirname(__FILE__,1)));

require __ROOT__ . '/db/config.php';


echo print_r($_GET);
echo print_r($_POST);


// =====================================================================================================================
// CONSULTAR RESERVA ===================================================================================================
// =====================================================================================================================


    if(isset($_GET["consultar"])){
        
        
        // SERVER REQUEST CONSULTAR RESERVAS
        if($_GET["consultar"] == "reservas"){
            
            $sql = [];
            
            // filtro turma
            if($_GET["turma"]) $sql[] = " t.nome LIKE '{$_GET["turma"]}%'";
            
            // filtro docente
            if($_GET["docente"]) $sql[] = " t.docente LIKE '{$_GET["docente"]}%'";
            
            //filtro curso
            if($_GET["curso"]) $sql[] = " t.curso LIKE '{$_GET["curso"]}%'";
            
            // filtro sala 
            if($_GET["sala"]) $sql[] = " s.id_sala = '{$_GET["sala"]}'";
            
            // filtro turno
            if($_GET["turno"]) $sql[] = " t.turno = '{$_GET["turno"]}'";
            
            // filtro reserva_tipo
            if($_GET["reserva_tipo"]) $sql[] = " r.reserva_tipo = '{$_GET["reserva_tipo"]}'"; 
            
            // filtro data inicio
            if($_GET["data_inicio"]) $sql[] = " DATE(data) >= '{$_GET["data_inicio"]}'"; 
            
            // filtro data fim
            if($_GET["data_fim"]) $sql[] = " DATE(data) <= '{$_GET["data_fim"]}'"; 
            
            
            // PESQUISA BASE CONSULTAR RESERVAS
            $query = "SELECT s.id_sala as 'sala',
                         s.tipo_sala as 'sala_tipo', 
                         r.data as 'data',
                         r.reserva_tipo as 'reserva',
                         r.id_reserva as 'id_reserva', 
                         t.nome as 'turma', 
                         t.docente as 'docente', 
                         t.turno as 'turno', 
                         CONCAT(t.participantes_qtd, '/', s.lugares_qtd) as 'lugares' 
                 FROM reservas as r
                 INNER JOIN turmas as t 
                 ON r.id_turma = t.id_turma
                 INNER JOIN salas as s
                 ON r.id_sala = s.id_sala";
            
            
            // coloca na posicao correta as tags WHERE e AND (WHERE é sempre a primeira tag, seguido pelos AND)
            if($sql) $query .= ' WHERE ' .implode(' AND ',$sql); 
            
            
            // limita a quatidade de registros que o banco de dados ira retornar
            if ($_GET["registros"]) $query .= " LIMIT {$_GET["registros"]}";
            
            echo  "<hr>" . $query . "<hr>"; // mostra a pesquisa para teste
            
            // prepara a pesquisa para ser executada
            $stmt = $conn->prepare($query);
            // executa a pesquisa 
            $stmt->execute();
            // o resultado da pesquisa e convertido em uma array associativa
            $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            
            require_once "./layout/table_consultar_reservas.php";
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
            
            
            
            $query = "SELECT s.id_sala as 'sala',
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
            if($sql) $query .= ' WHERE ' .implode(' AND ',$sql) . " WHERE ";
            
            
            if($_GET["reserva_tipo"] == "única"){
                
                $query .= " DATE(data) = '{$_GET["data_inicio"]}'";
                
                $days = $_GET["data_inicio"];
            } 
            else {  
                
                $days = "";
                
                $data_inicial=strtotime("{$_GET['data_inicio']}");
                $data_final=strtotime("{$_GET['data_fim']}", $data_inicial);
                
                while ($data_inicial < $data_final) {
                    
                    $days .=  date("'Y-m-d', ", $data_inicial);         
                    
                    $data_inicial = strtotime("+1 week", $data_inicial);
                }
                
                $days = substr_replace($days,"",-2);    
                
                $query .= "DATE(data) in ($days)";
            }
            
            // filtro turno
            $query .= $_GET["turno"] ? " AND t.turno = '{$_GET["turno"]}')": ")";
            
            // limita a quatidade de registros que o banco de dados ira retornar
            if ($_GET["registros"]) $query .= " LIMIT {$_GET["registros"]}";
            
            echo  "<hr>" . $query . "<hr>"; // mostra a pesquisa para teste
            
            // prepara a pesquisa para ser executada
            
            $stmt = $conn->prepare($query);
            // executa a pesquisa 
            $stmt->execute();
            // o resultado da pesquisa e convertido em uma array associativa
            $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);

                // gerar as datas para mostrar na tabela
                $datas = str_replace(array("'"),array(""),$days);
                $datas = explode(",",$datas);
                // tabela cadastrar reservas
                require_once "./layout/table_cadastrar_reservas.php";
                
            }
            
    }

        
        // =====================================================================================================================
        // DELETAR RESERVA =====================================================================================================
        // =====================================================================================================================

        
    if(isset($_POST["del_reservas"] )){
        
        if($_POST["del_reservas"] == "atual"){
            
            $id_reserva = $_POST["id_reserva"];
            $query = "DELETE FROM reservas WHERE id_reserva = '$id_reserva' ";
            
            $stm = $conn->prepare($query);
            
            echo $stm->execute() ? "reserva deletado com sucesso" : "Erro ao tentar deletar a reserva";
            
        } else {

            $id_reserva = $_POST["id_reserva"];
            $query = "SELECT r.id_turma AS 'turma',
                                r.data AS 'data'    
                        FROM reservas AS r 
                        WHERE id_reserva = '$id_reserva'";
        
        
            $stm = $conn->prepare($query);

            if(!$stm->execute()){

                exit("ERRO AO BUSCAR OS DADOS DA RESERVA");

            } else {

                $arr = $stm->fetch(PDO::FETCH_ASSOC);
            }

            

            $query = "DELETE FROM reservas WHERE id_turma = '{$arr["turma"]}'";

            
            if($_POST["del_reservas"] == "apartir") $query .= " AND DATE(data) >= '{$arr["data"]}'";
            
            $stm = $conn->prepare($query);
            
            echo $stm->execute() ? $stm->rowCount(). " reservas deletadas com sucesso" : "Erro ao tentar deletar as reservas";
            
        }
    }


        // =====================================================================================================================
        // CADASTRAR RESERVA ===================================================================================================
        // =====================================================================================================================


        if(isset($_POST["cadastrar-reserva"])){

            // ARMAZENA O ID DA TURMA CASO A TURMA JA EXISTA
            if(isset($_POST["id_turma"])) $id_turma = $_POST["id_turma"];

            // DADOS DA RESERVA
            $reserva_tipo = $_POST["reserva_tipo"] ? $_POST["reserva_tipo"]: exit("ERRO: O CAMPO 'RESERVA TIPO' ESTA VAZIO");
            // INPUT ID SALA 
            $id_sala = $_POST["id_sala"] ? $_POST["id_sala"]: exit("ERRO: O CAMPO 'ID SALA TIPO' ESTA VAZIO");
            // INPUT TURNO
            $turno = $_POST["turno"] ? $_POST["turno"]: exit("ERRO: O CAMPO 'TURNO' ESTA VAZIO");
            // INPUT DATA INICIO
            $data_inicio = $_POST['data_inicio'] ? $_POST["data_inicio"] : exit("ERRO: O CAMPO DATA INICIO ESTA VAZIO");

            // RODA CASO FOR UM NOVO CADASTRO 
            if($_POST["cadastro-turma"] == "nova"){

                // DADOS DA TURMA NOVA 
                $nome = $_POST["turma"] ? $_POST["turma"] : exit("ERRO: O CAMPO 'TURMA' ESTA VAZIO");

                $codigo = $_POST["codigo"] ? $_POST["codigo"] : exit("ERRO: O CAMPO 'CODIGO' ESTA VAZIO");

                $curso = $_POST["curso"] ? $_POST["curso"] : exit("ERRO: O CAMPO 'CURSO' ESTA VAZIO");

                $docente = $_POST["docente"] ? $_POST["docente"] : exit("ERRO: O CAMPO 'DOCENTE' ESTA VAZIO");

                $participantes = $_POST["participantes"] ? $_POST["participantes"] : exit("ERRO: O CAMPO 'PARTICIPANTES' ESTA VAZIO");

                
                $query = "INSERT INTO `turmas`(`nome`, `curso`, `docente`, `turno`, `codigo`, `participantes_qtd`) 
                VALUES ('$nome', '$curso', '$docente', '$turno', '$codigo', $participantes)";
                
                
                $stm = $conn->prepare($query);

                if(!$stm->execute()){

                    exit("erro ao cadastrar a turma");

                } else{
                    // ARMAZENA O ID DA TURMA QUE FOI CRIADA NO CODIGO ACIMA
                    $id_turma = $conn->lastInsertId();
                }

            } 
            
            //  RODA CASO FOR UMA RESERVA SEMANAL
            if($reserva_tipo == "semanal"){

                $query = "INSERT INTO `reservas`(`data`, `reserva_tipo`, `id_sala`, `id_turma`) VALUES";    

                // INPUT DATA FIM
                $data_fim = $_POST['data_fim'] ? $_POST["data_fim"] : exit("ERRO: O CAMPO DATA FIM ESTA VAZIO");

                $data_inicial = strtotime($data_inicio);
                $data_final = strtotime( $data_fim);
                
                while ($data_inicial < $data_final) {
                    
                    $data =  date("Y-m-d", $data_inicial);         
                    
                    $query .= " ('$data','$reserva_tipo',$id_sala, $id_turma),";

                    $data_inicial = strtotime("+1 week", $data_inicial);

                }

                $query = substr_replace($query,"",-1);

                $stm = $conn->prepare($query);

                echo !$stm->execute()? "ERRO AO TENTAR INSERIR AS RESERVAS" : "RESERVAS INSERIDAS COM SUCESSO";
                
                    
                // RODA CASO A RESERVA FOR UNICA
                } else {

                    $query = "INSERT INTO `reservas`(`data`, `reserva_tipo`, `id_sala`, `id_turma`) 
                    VALUES ('$data_inicio','$reserva_tipo', $id_sala, $id_turma)";

                    $stm = $conn->prepare($query);

                    echo !$stm->execute() ? "ERRO AO TENTAR INSERIR A RESERVA" : "RESERVA INSERIDA COM SUCESSO";
                        
                }

        }
                
            
            
            
            
            
            
                ?>
    
    