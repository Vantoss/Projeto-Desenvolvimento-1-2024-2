<?php
$conn = initDB();

if(empty($_GET)){

    if (!file_exists(ROOT_DIR. 'JSON/salas.json')) {
        gerarSalasJSON();
    }
    
    $salas = file_get_contents(ROOT_DIR."JSON/salas.json");
    
    if(!$salas or empty($salas)){
        exit(json_encode(null));
    }
    exit($salas);
}

if(isset($_GET["tabela-salas"]) and isset($_GET["cached"])){
    $salas = file_get_contents(ROOT_DIR."JSON/salas.json");
    if(!$salas or empty($salas)){
        exit(json_encode(null));
    }
    exit($salas);
}

if(isset($_GET["tabela-salas"])){

    $unidade = $_GET["unidade"];

    $selectSQL = "SELECT * FROM salas WHERE unidade = $unidade";

    $stm = $conn->prepare($selectSQL);

    if(!$stm->execute()){
        $resposta["status"] = 400;
        $resposta["msg"] = "Erro ao bucar os dados no banco";
        exit(json_encode($resposta));
    }

    $salas = $stm->fetchAll(PDO::FETCH_ASSOC);
    
    if(!$salas){
        $resposta["status"] = 204;
        $resposta["msg"] = "Nenhum resultado encontrado";
        exit(json_encode($resposta));
    }

    $resposta["status"] = 200;
    $resposta["salas"] = $salas;

    echo json_encode($resposta);
}


if(isset($_GET["id-sala"])){

    $id_sala = $_GET["id-sala"];
    
    $json = json_decode(file_get_contents(ROOT_DIR. 'JSON/salas.json'),true);
    
    $salas = $json["salas"];
    
    foreach ($salas as $sala) {
        if($sala["id_sala"] == $id_sala){
            exit(json_encode($sala));
        }
    }
}

if(isset($_GET["disponiveis"]) and isset($_GET["salas-json"])){


    $dados_tabela = json_decode(file_get_contents(ROOT_DIR."JSON/tabela_salas_disponiveis.json"));
    
    $resposta["status"] = 200;
    $resposta["dados"] = $dados_tabela;

    exit(json_encode($resposta));
}


if(isset($_GET["disponiveis"])){

    
    $sql = []; //guarda os parametros da pesquisa sql
    
    // filtro sala 
    if($_GET["sala"]) $sql[] = " s.id_sala = '{$_GET["sala"]}'"; 
    
    // filtro lugares quantidade
    
    if($_GET["sala-tipo"]) $sql[] = " s.tipo_sala = '{$_GET["sala-tipo"]}'";
    
    
    if($_GET["unidade"]) $sql[] = " s.unidade = '{$_GET["unidade"]}'";

    
    // filtro maquinas quantidade
    if($_GET["maquinas-qtd"] >= 0) {
        
        $maquinas_qtd = (int) $_GET["maquinas-qtd"];

        $sql[] = " s.maquinas_qtd >= $maquinas_qtd";
    }
    
    // filtro maquinas_tipo
    if($_GET["maquinas-tipo"]) $sql[] = " s.maquinas_tipo LIKE '{$_GET["maquinas-tipo"]}%'";
    
    // filtro lugares quantidade
    if($_GET["lugares-qtd"]) $sql[] = " s.lugares_qtd >= '{$_GET["lugares-qtd"]}'";
    
    
    
    $selectSQL = "SELECT * FROM salas as s";
    
    $sql[] = " s.id_sala NOT IN (SELECT s.id_sala from salas as s 
                INNER JOIN reservas as r 
                ON s.id_sala = r.id_sala 
                INNER JOIN turmas as t 
                ON r.id_turma = t.id_turma";
    
    // coloca na posicao correta as tags WHERE e AND (WHERE é sempre a primeira tag, seguido pelos AND)
    if($sql) $selectSQL .= ' WHERE ' .implode(' AND ',$sql) . " WHERE ";

    
    $tipo_reserva = $_GET["tipo-reserva"];

    $data_inicial = new DateTime("{$_GET['data-inicio']}");

    $data_final = isset($_GET["data-fim"])? new DateTime($_GET["data-fim"]) : null;
    $semanas = isset($_GET["semanas"])? (int) $_GET["semanas"] : null;
    $dias_semana = isset($_GET["dias-semana"]) ? $_GET["dias-semana"]: null;


    switch ($tipo_reserva) {
        case "Avulsa":
            $dias = $data_inicial->format('\'Y-m-d\'');
            break;

        case "Graduação":
            $dias = gerarDatasGraducao($data_inicial,$data_final,$semanas);
            break;
        
        case "FIC":
            $dias = gerarDatasFIC($data_inicial,$data_final,$semanas);
            break;

        case "Pos-graduacao":
            $dias = gerarDatasPos($data_inicial,$dias_semana,$semanas);
            break;
    }

    
    $selectSQL .= "DATE(data) IN ($dias)";

    
    // filtro turno
    $selectSQL .= $_GET["turno"] ? " AND t.turno = '{$_GET["turno"]}')": ")";
    


    // echo $selectSQL;
    // exit();
    
    // echo  "<hr>" . $query . "<hr>"; // mostra a pesquisa para teste
    
    // prepara a pesquisa para ser executada
    
    $stm = $conn->prepare($selectSQL);
    
    if($stm->execute()){

        $datas = str_replace(array("'"),array(""),$dias);

        $datas = explode(",",$datas);
        
        $salas = $stm->fetchAll(PDO::FETCH_ASSOC);

        $dados_tabela = [
            "datas" => $datas,
            "turno" => $_GET["turno"],
            "tipo_reserva" => $_GET["tipo-reserva"],
            "salas" => $salas
        ];

        if($salas){

            if (!file_exists(ROOT_DIR. 'JSON/tabela_salas_disponiveis.json')) {
                touch(ROOT_DIR. 'JSON/tabela_salas_disponiveis.json');
            }

            file_put_contents(ROOT_DIR.'JSON/tabela_salas_disponiveis.json', json_encode($dados_tabela));

            $resposta["status"] = 200;
            $resposta["dados"] = $dados_tabela;

        } else {
            $resposta["status"] = 204;
            $resposta["msg"] = "Nenhum resultado encontrado";
            $resposta["dados"] = $dados_tabela;
        }

    } else {
        $resposta["status"] = 400;
        $resposta["msg"] = "Erro ao bucar os dados no banco";
    }
    
        echo json_encode($resposta);
    }

     
