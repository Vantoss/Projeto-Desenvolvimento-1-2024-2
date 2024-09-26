<?php 

    //  =========================== CONSULTAR RESERVA ======================================

    define('__ROOT__', dirname(dirname(__FILE__,2)));
    
    require __ROOT__ . '/db/config.php';

            
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
        
        
            require_once "../layout/table_consultar_reservas.php";
           
        
     ?>
    
    