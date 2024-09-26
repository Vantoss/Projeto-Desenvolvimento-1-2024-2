<?php 

    define('__ROOT__', dirname(dirname(__FILE__,2)));
    
    require __ROOT__ . '/db/config.php';

            
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
                
            } 
            else if ($_POST["reserva-tipo"] == "semanal"){  
                
                $data_inicial=strtotime("{$_POST['data-inicio']}");
                $data_final=strtotime("{$_POST['data-fim']}", $data_inicial);
                
                $days = "";
                while ($data_inicial < $data_final) {
                    
                    $days .=  date("'Y-m-d', ", $data_inicial);         
                    
                    $data_inicial = strtotime("+1 week", $data_inicial);
                }
                $days = substr_replace($days,"",-2);
                

                $dias = str_replace(array("-","'"),array("/",""),$days);

                $query .= "DATE(data) in ($days)";
                
            } else {
                
                $query .= " DATE(data) >= '{$_POST["data-inicio"]}'";
            }

            // filtro turno
            $query .= $_POST["turno"]? "AND t.turno = '{$_POST["turno"]}')": ")";
            
            
            // limita a quatidade de registros que o banco de dados ira retornar
            if ($_POST["registros"]) $query .= " LIMIT {$_POST["registros"]}";


            
            echo  "<hr>" . $query . "<hr>"; // mostra a pesquisa para teste
            
            // prepara a pesquisa para ser executada
            $stmt = $conn->prepare($query);
            // // executa a pesquisa 
            $stmt->execute();
            // // o resultado da pesquisa e convertido em uma array associativa
            $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            
            //     // tabela cadastrar reservas
            require_once "../layout/table_cadastrar_reservas.php";
        
        
        
     ?>
    
    