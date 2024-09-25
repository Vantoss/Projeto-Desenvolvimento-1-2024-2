<?php 

    //  =========================== CONSULTAR RESERVA ======================================

    // conexão do banco de dados
    // require_once "./includes/conn.php";

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
            
        $sql = [];
            
            // filtro diciplina
        if($_POST["diciplina"]) $sql[] = " d.nome LIKE '{$_POST["diciplina"]}%'";

            // filtro docente
        if($_POST["docente"]) $sql[] = " d.docente LIKE '{$_POST["docente"]}%'";

            // filtro sala 
            if($_POST["sala"]) $sql[] = " s.id_sala = '{$_POST["sala"]}'";

            // filtro turno
            if($_POST["turno"]) $sql[] = " d.turno = '{$_POST["turno"]}'";

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
                         d.nome as 'diciplina', 
                         d.docente as 'docente', 
                         d.turno as 'turno', 
                         CONCAT(d.participantes_qtd, '/', s.lugares_qtd) as 'lugares' 
                 FROM reservas as r
                 INNER JOIN disciplinas as d 
                 ON r.id_disciplina = d.id_disciplina
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
        
        
            require_once "../layout/table_consultar_reservas.php";
           
        
     ?>
    
    