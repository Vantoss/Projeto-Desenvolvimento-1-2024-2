<?php 

    // conexão do banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$database = "senac";

try {
  $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//   echo "Connected successfully";
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}
            
            $sql = []; //guarda os parametros da pesquisa sql
            
            // filtro sala 
            if($_POST["sala"]) $sql[] = " s.id_sala = '{$_POST["sala"]}'"; 
            
            // filtro maquinas quantidade
            if($_POST["maquinas-qtd"]) $sql[] = " s.maquinas_qtd = '{$_POST["maquinas-qtd"]}'";
            
            // filtro maquinas tipo
            // if($_POST["maquinas-tipo"]) $sql[] = " s.maquinas_tipo = '{$_POST["maquinas-tipo"]}'";
            
            // filtro lugares quantidade
            if($_POST["lugares-qtd"]) $sql[] = " s.lugares_qtd = '{$_POST["lugares-qtd"]}'";
            
            // filtro lugares quantidade
            if($_POST["sala-tipo"]) $sql[] = " s.sala_tipo = '{$_POST["sala-tipo"]}'";
            
            
            $query = "SELECT s.id_sala FROM salas as s";
            
            $sql[] = " salas.id_sala NOT IN (SELECT salas.id_sala from salas as s INNER JOIN reservas as r on salas.id_sala = reservas.id_sala";
            
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
                
                $query .= "DATE(data) in ($days)";
                
            } else {
                
                $query .= " DATE(data) >= '{$_POST["data-inicio"]}'";
            }

            // filtro turno
            $query .= $_POST["turno"]? "AND d.turno = '{$_POST["turno"]})'": ")";
            
            
            // limita a quatidade de registros que o banco de dados ira retornar
            if ($_POST["registros"]) $query .= " LIMIT {$_POST["registros"]}";
            
            echo  "<hr>" . $query . "<hr>"; // mostra a pesquisa para teste
            
            // prepara a pesquisa para ser executada
            // $stmt = $conn->prepare($query);
            // // executa a pesquisa 
            // $stmt->execute();
            // // o resultado da pesquisa e convertido em uma array associativa
            // $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            
            //     // tabela cadastrar reservas
            // require_once "./layout/table_cadastrar_reserva";
        
        
        
     ?>
    
    