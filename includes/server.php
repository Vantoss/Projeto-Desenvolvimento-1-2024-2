<?php 

    //  =========================== CONSULTAR RESERVA ======================================

    define('__ROOT__', dirname(dirname(__FILE__,1)));
    
    require __ROOT__ . '/db/config.php';

    


    if(isset($_POST["consultar"])){
        
        
        // SERVER REQUEST CONSULTAR RESERVAS
        if($_POST["consultar"] == "reservas"){
            
            $sql = [];
            
            // filtro turma
            if($_POST["turma"]) $sql[] = " t.nome LIKE '{$_POST["turma"]}%'";
            
            // filtro docente
            if($_POST["docente"]) $sql[] = " t.docente LIKE '{$_POST["docente"]}%'";
            
            //filtro curso
            if($_POST["curso"]) $sql[] = " t.curso LIKE '{$_POST["curso"]}%'";
            
            // filtro sala 
            if($_POST["sala"]) $sql[] = " s.id_sala = '{$_POST["sala"]}'";
            
            // filtro turno
            if($_POST["turno"]) $sql[] = " t.turno = '{$_POST["turno"]}'";
            
            // filtro reserva tipo
            if($_POST["reserva-tipo"]) $sql[] = " r.reserva_tipo = '{$_POST["reserva-tipo"]}'"; 
            
            // filtro data inicio
            if($_POST["data-inicio"]) $sql[] = " DATE(data) >= '{$_POST["data-inicio"]}'"; 
            
            // filtro data fim
            if($_POST["data-fim"]) $sql[] = " DATE(data) <= '{$_POST["data-fim"]}'"; 
            
            
            // PESQUISA BASE CONSULTAR RESERVAS
            $query = "SELECT s.id_sala as 'sala',
                         s.tipo_sala as 'sala-tipo', 
                         r.data as 'data',
                         r.reserva_tipo as 'reserva',
                         r.id_reserva as 'id-reserva', 
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
            if ($_POST["registros"]) $query .= " LIMIT {$_POST["registros"]}";
            
            echo  "<hr>" . $query . "<hr>"; // mostra a pesquisa para teste
            
            // prepara a pesquisa para ser executada
            $stmt = $conn->prepare($query);
            // executa a pesquisa 
            $stmt->execute();
            // o resultado da pesquisa e convertido em uma array associativa
            $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            
            require_once "./layout/table_consultar_reservas.php";
        }
        
        
        // SERVER REQUEST CONSULTAR SALAS DISPONIVEIS
        
        if($_POST["consultar"] == "salas-disponiveis"){
            $sql = []; //guarda os parametros da pesquisa sql
            
            // filtro sala 
            if($_POST["sala"]) $sql[] = " s.id_sala = '{$_POST["sala"]}'"; 
            
            // filtro lugares quantidade
            
            if($_POST["sala-tipo"]) $sql[] = " s.tipo_sala = '{$_POST["sala-tipo"]}'";
            
            // filtro maquinas quantidade
            if($_POST["maquinas-qtd"]) $sql[] = " s.maquinas_qtd = '{$_POST["maquinas-qtd"]}'";
            
            // filtro maquinas tipo
            if($_POST["maquinas-tipo"]) $sql[] = " s.maquinas_tipo LIKE '{$_POST["maquinas-tipo"]}%'";
            
            // filtro lugares quantidade
            if($_POST["lugares-qtd"]) $sql[] = " s.lugares_qtd = '{$_POST["lugares-qtd"]}'";
            
            
            
            $query = "SELECT s.id_sala as 'sala',
                             s.tipo_sala as 'sala-tipo',
                             s.lugares_qtd as 'lugares',
                             s.maquinas_qtd as 'maquinas-qtd',
                             s.maquinas_tipo as 'maquinas-tipo'
                      FROM salas as s";
            
            $sql[] = " s.id_sala NOT IN (SELECT s.id_sala from salas as s 
            INNER JOIN reservas as r 
            ON s.id_sala = r.id_sala 
            INNER JOIN turmas as t 
            ON r.id_turma = t.id_turma";
            
            // coloca na posicao correta as tags WHERE e AND (WHERE é sempre a primeira tag, seguido pelos AND)
            if($sql) $query .= ' WHERE ' .implode(' AND ',$sql) . " WHERE ";
            
            
            if($_POST["reserva-tipo"] == "única"){
                
                $query .= " DATE(data) = '{$_POST["data-inicio"]}'";
                
                $days = $_POST["data-inicio"];
            } 
            else if ($_POST["reserva-tipo"] == "semanal"){  
                
                $days = "";
                
                $data_inicial=strtotime("{$_POST['data-inicio']}");
                $data_final=strtotime("{$_POST['data-fim']}", $data_inicial);
                
                while ($data_inicial < $data_final) {
                    
                    $days .=  date("'Y-m-d', ", $data_inicial);         
                    
                    $data_inicial = strtotime("+1 week", $data_inicial);
                }
                
                $days = substr_replace($days,"",-2);    
                
                $query .= "DATE(data) in ($days)";
                
            } else {
                
                $query .= " DATE(data) >= '{$_POST["data-inicio"]}'";
                
                $days = $_POST["data-inicio"];
            }
            
            
            
            // filtro turno
            $query .= $_POST["turno"] ? "AND t.turno = '{$_POST["turno"]}')": ")";
            
            
            // limita a quatidade de registros que o banco de dados ira retornar
            if ($_POST["registros"]) $query .= " LIMIT {$_POST["registros"]}";
            
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

        
        // func deletar reservas 
        if(isset($_POST["del-reservas"] )){

            
            
            if($_POST["del-reservas"] == "atual"){
                
                
                $id_reserva = $_POST["id-reserva"];
                $query = "DELETE FROM reservas WHERE id_reservas = '$id_reserva' ";
                
                $stm = $conn->prepare($query);
                
                if($stm->execute()){
                        echo "reserva deletado com sucesso";
                } else {
                    echo "Erro ao tentar deletar a reserva";
                }

            } else {

                $id_reserva = $_POST["id-reserva"];
                $query = "SELECT r.id_turma AS 'turma',
                                 r.data AS 'data'    
                            FROM reservas AS r 
                            WHERE id_reservas = '$id_reserva'";
            
            
                $stm = $conn->prepare($query);

                $stm->execute();

                $arr = $stm->fetch(PDO::FETCH_ASSOC);
                

                $query = "DELETE FROM reservas WHERE id_turma = '{$arr["turma"]}'";
                
                if($_POST["del-reservas"] == "apartir"){

                    $query .= " AND DATE(data) >= '{$arr["data"]}'";
                }
                
                
                $stm = $conn->prepare($query);

                echo $stm->execute() ? $stm->rowCount(). " reservas deletadas com sucesso" : "Erro ao tentar deletar as reservas";

            }
                
        }
            
            
            
            
            
            
                ?>
    
    