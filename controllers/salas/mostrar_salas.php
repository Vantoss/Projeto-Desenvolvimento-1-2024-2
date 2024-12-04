<?php

if(empty($_GET)){

    if (!file_exists(ROOT_DIR. 'JSON/dados_salas.json')) {
        gerarSalasJSON();
    }
    
    $salas = file_get_contents(ROOT_DIR."JSON/dados_salas.json");
    
    if(!$salas or empty($salas)){
        exit(json_encode(null));
    }
    
    echo $salas;
    return;
}


if(isset($_GET["id-sala"])){

    $id_sala = $_GET["id-sala"];
    
    $json = json_decode(file_get_contents(ROOT_DIR. 'JSON/dados_salas.json'),true);
    
    $salas = $json["salas"];
    
    foreach ($salas as $sala) {
        if($sala["id_sala"] == $id_sala){
            echo json_encode($sala);
        }
    }
    return;
}

if(isset($_GET["disponiveis"]) && isset($_GET["salas-json"])){

    echo file_get_contents(ROOT_DIR."JSON/dados_tabela_salas.json");
    return;
}

if(isset($_GET["disponiveis"])){
    
    $sql = []; //guarda os parametros da pesquisa sql
    
    // filtro sala 
    if($_GET["sala"]) $sql[] = " s.id_sala = '{$_GET["sala"]}'"; 
    
    // filtro lugares quantidade
    
    if($_GET["sala-tipo"]) $sql[] = " s.tipo_sala = '{$_GET["sala-tipo"]}'";
    
    // filtro maquinas quantidade
    if($_GET["maquinas-qtd"] >= 0) {
        
        $maquinas_qtd = (int)$_GET["maquinas-qtd"];

        $sql[] = " s.maquinas_qtd >= '$maquinas_qtd'";
    }
    
    // filtro maquinas_tipo
    if($_GET["maquinas-tipo"]) $sql[] = " s.maquinas_tipo LIKE '{$_GET["maquinas-tipo"]}%'";
    
    // filtro lugares quantidade
    if($_GET["lugares-qtd"]) $sql[] = " s.lugares_qtd = '{$_GET["lugares-qtd"]}'";
    
    
    
    $insertSQL = "SELECT s.id_sala as 'sala',
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
    if($sql) $insertSQL .= ' WHERE ' .implode(' AND ',$sql) . " WHERE ";

    
    $tipo_reserva = $_GET["tipo-reserva"];


    if($tipo_reserva == "Avulsa") {

        // $insertSQL .= " DATE(data) = '{$_GET["data-inicio"]}'";

        $dias = $_GET["data-inicio"];

    } else {

        $data_inicial = new DateTime("{$_GET['data-inicio']}");
        $data_final = isset($_GET["data-fim"])? new DateTime($_GET["data-fim"]) : null;
        $num_encontros = isset($_GET["num-encontros"])? (int) $_GET["num-encontros"] : null;


        switch ($tipo_reserva) {
            case "Graduação":
                $dias = gerarDatasGraducao($data_inicial,$data_final,$num_encontros);
                break;
            
            case "FIC":
                $dias = gerarDatasFIC($data_inicial,$data_final,$num_encontros);
                break;
        }

    }

    $insertSQL .= "DATE(data) IN ($dias)";

    
    // filtro turno
    $insertSQL .= $_GET["turno"] ? " AND t.turno = '{$_GET["turno"]}')": ")";
    
    // echo  "<hr>" . $query . "<hr>"; // mostra a pesquisa para teste
    
    // prepara a pesquisa para ser executada
    $conn = initDB();
    $stm = $conn->prepare($insertSQL);
    
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

            if (!file_exists(ROOT_DIR. 'JSON/dados_tabela_salas.json')) {
                touch(ROOT_DIR. 'JSON/dados_tabela_salas.json');
            }
            file_put_contents(ROOT_DIR.'JSON/dados_tabela_salas.json', json_encode($dados_tabela));

            $resposta["status"] = 200;
            // $resposta["msg"] = "Dados tranferidos para o arquivo json";
            $resposta["dados"] = $dados_tabela;

        } else {
            $resposta["status"] = 204;
            $resposta["msg"] = "Nenhum resultado encontrado";
        }

    } else {
        $resposta["status"] = 400;
        $resposta["msg"] = "Erro ao bucar os dados no banco";
    }
    
        echo json_encode($resposta);
    }

     
