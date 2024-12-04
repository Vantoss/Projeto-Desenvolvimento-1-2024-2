<?php 

$conn = initDB();

if(isset($GET["reservas-json"])){
    
    exit(file_get_contents(ROOT_DIR.'JSON/dados_tabela_reservas.json'));

} 



$dados_tabela["reserva_status"] = $_GET["reserva-status"];

$sql = [];

// filtro turma
if($_GET["turma"]){
    $turma = trim(preg_replace('/\s+/', ' ', $_GET["turma"]));
    $sql[] = " t.nome LIKE '$turma%'";
} 

// filtro docente
if($_GET["docente"]){
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

// filtro semestre
if($_GET["semestre"]) $sql[] = " t.semestre = '{$_GET["semestre"]}'";

// filtro turno
if($_GET["turno"]) $sql[] = " t.turno = '{$_GET["turno"]}'";

// filtro tipo_reserva
if($_GET["tipo-reserva"]) $sql[] = " t.tipo_turma = '{$_GET["tipo_reserva"]}'";

// filtro data inicio
if($_GET["data-inicio"]) $sql[] = " DATE(data) >= '{$_GET["data_inicio"]}'";

// filtro data fim
if($_GET["data-fim"]) $sql[] = " DATE(data) <= '{$_GET["data_fim"]}'";

if($_GET["reserva-status"] == "Ativa"){

    // PESQUISA BASE CONSULTAR RESERVAS
    $selectSQL = "SELECT r.id_sala as 'sala',
                r.id_reserva as 'id_reserva', 
                s.tipo_sala as 'sala_tipo', 
                r.data as 'data',
                t.tipo_turma as 'reserva',
                t.id_turma as id_turma,
                t.nome as 'turma',
                t.docente as 'docente', 
                t.turno as 'turno',
                t.semestre as 'semestre', 
                CONCAT(t.participantes_qtd, '/', s.lugares_qtd) as 'lugares' 
        FROM reservas as r
        INNER JOIN turmas as t 
        ON r.id_turma = t.id_turma
        INNER JOIN salas as s
        ON r.id_sala = s.id_sala";
        
} else {

    $selectSQL = "SELECT r.id_sala as 'sala',
                r.id_reserva as 'id_reserva', 
                s.tipo_sala as 'sala_tipo', 
                r.data as 'data',
                t.tipo_turma as 'reserva',
                t.nome as 'turma',
                r.docente as 'docente',
                t.id_turma as 'id_turma' 
                t.turno as 'turno',
                t.semestre as 'semestre', 
                CONCAT(r.participantes, '/', s.lugares_qtd) as 'lugares' 
        FROM reservas_historico as r
        INNER JOIN turmas as t 
        ON r.id_turma = t.id_turma
        INNER JOIN salas as s
        ON r.id_sala = s.id_sala";

}


// coloca na posicao correta as tags WHERE e AND (WHERE é sempre a primeira tag, seguido pelos AND)
if($sql) $selectSQL .= ' WHERE' .implode(' AND ',$sql); 



// echo  "<hr>" . $selectSQL . "<hr>"; // mostra a pesquisa para teste

$selectSQL .= " ORDER BY id_reserva";

$stm = $conn->prepare($selectSQL);

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
        $resposta["dados"] = $dados_tabela;
        
    } else {
        
        $resposta["status"] = 204;
        $resposta["msg"] = "Nenhum resultado encontrado";
    }
    
}

echo json_encode($resposta);



