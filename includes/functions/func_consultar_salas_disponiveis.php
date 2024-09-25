<?php 

    // conexão do banco de dados
    require_once "../db/conn.php";
            
            $sql = []; //guarda os parametros da pesquisa sql
            
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
            // filtro diciplina
                
            
        
                if($_POST["data-inicio"] && $_POST["data-fim"]){

                    if($_POST["reserva-tipo"]){
                        $data_inicial=strtotime("{$_POST['data-inicio']}");
                        $data_final=strtotime("{$_POST['data-fim']}", $data_inicial);
                        
                        while ($data_inicio < $data_final) {
                            $days .=  date("'Y-m-d',", $data_inicial);         
                            
                            
                            $data_inicial = strtotime("{$_POST['reserva-tipo']}", $data_inicial);
                        }
                        
                    } 

                    $sql[] = " r.reserva_tipo = '{$_POST["reserva-tipo"]}'";    
                        
                }

                if($_POST["maquinas-qtd"]) $sql[] = " s.maquinas_qtd = '{$_POST["maquinas-qtd"]}'";
                if($_POST["maquinas-tipo"]) $sql[] = " s.maquinas_tipo = '{$_POST["maquinas-tipo"]}'";
                if($_POST["lugares-qtd"]) $sql[] = " s.lugares_qtd = '{$_POST["lugares-qtd"]}'";
                if($_POST["sala-tipo"]) $sql[] = " s.sala_tipo = '{$_POST["sala-tipo"]}'";

                $query = "SELECT * FROM salas WHERE salas.id_sala NOT IN (SELECT salas.id_sala from salas INNER JOIN reservas on salas.id_sala = reservas.id_sala WHERE Date(data) = '2024-03-04')";
            
            
        
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
        
        if ($_POST["filtro-tipo"] == "consultar-reservas"){
            // tabela consultar reservas
            require_once "./layout/table_consultar_reservas.php";
        } else {
            // tabela cadastrar reservas
            require_once "./layout/table_consulater.php";
        }
        
        
        
     ?>
    
    