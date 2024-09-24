<?php 

    // conexão do banco de dados
    require_once "../db/conn.php";

function gerar_consulta($conn){

}

    if(isset($_POST["filtros"])){

            $filtros = $_POST["filtros"];
            
            $sql = []; //guarda os parametros da pesquisa sql
            
            // filtro sala
            if($filtros["sala"]) $sql[] = " s.id_sala = '{$filtros["sala"]}'"; 
            // filtro data inicio
            if($filtros["data-inicio"]) $sql[] = " DATE(data) >= '{$filtros["data-inicio"]}'"; 
            // filtro data fim
            if($filtros["data-fim"]) $sql[] = " DATE(data) <= '{$filtros["data-fim"]}'"; 
            // filtro turno
            if($filtros["turno"]) $sql[] = " d.turno = '{$filtros["turno"]}'"; 
            // filtro diciplina
            if($filtros["diciplina"]) $sql[] = " d.nome LIKE '{$filtros["diciplina"]}%'";
            // filtro docente
            if($filtros["docente"]) $sql[] = " d.docente LIKE '{$filtros["docente"]}%'";
            
            // pesquisa base
            $query = "SELECT s.id_sala as 'sala', 
                         r.data as 'data', 
                         d.nome as 'diciplina', 
                         d.docente as 'docente', 
                         d.turno as 'turno', 
                         CONCAT(d.participantes_qtd,'/',s.capacidade) as 'lotacao' 
                 FROM reservas as r
                 INNER JOIN disciplinas as d 
                 ON r.id_disciplina = d.id_disciplina
                 INNER JOIN salas as s
                 ON r.id_sala = s.id_sala";
        
        // coloca na posicao correta as tags WHERE e AND (WHERE é sempre a primeira tag, seguido pelos AND)
        if($sql) $query .= ' WHERE ' .implode(' AND ',$sql); 
        
        
        // limita a quatidade de registros que o banco de dados ira retornar
        if ($filtros["registros"]) $query .= " LIMIT {$filtros["registros"]}";
        
        echo  "<hr>" . $query . "<hr>"; // mostra a pesquisa para teste
        
        // prepara a pesquisa para ser executada
        $stmt = $conn->prepare($query);
        // executa a pesquisa 
        $stmt->execute();
        // o resultado da pesquisa e convertido em uma array associativa
        $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        ?>

<table class="table table-striped tabela-consulta">
    
    <?php
    // roda caso exista registros na pesquisa
    if ($arr){?> 

<thead>
    <tr>
        <th scope="col">Sala</th>
        <th scope="col">Data</th>
        <th scope="col">Disciplina</th>
        <th scope="col">Docente</th>
        <th scope="col">Turno</th>
        <th scope="col">Lotação</th>
        <th scope="col">Ação</th>
    </tr>
    
    <?php } else { // roda caso nao exista registros na pesquisa
        echo "Nenhum resultado encontrado";
    }
    ?>
    </thead>
    <tbody>
        <?php 
        foreach ($arr as $_ => $row ){?>
            <tr>
                <td><?php echo $row["sala"]; ?></td>
                <td>
                    <!-- converte a data de formato Y-m-d para "dia da semana" - d/m/Y -->
                    <?php echo date_format(date_create($row["data"])," l - d/m/Y");?>
                </td>
                <td><?php echo $row["diciplina"]; ?></td>
                <td><?php echo $row["docente"]; ?></td> 
                <td><?php echo $row["turno"]; ?></td> 
                <td><?php echo $row["lotacao"]; ?></td>
                <td><button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editar-reserva-modal">Editar</button></td>
                <td><button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deletar-reserva-modal">Deletar</button></td> 
            </tr>
            <?php }?>
        </tbody>
    </table>

    
    <?php } ?>
    
    
    