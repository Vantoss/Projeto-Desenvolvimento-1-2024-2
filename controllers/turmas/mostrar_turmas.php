<?php

$conn = initDB();

if(empty($_GET)) {
    echo file_get_contents(ROOT_DIR. 'JSON/dados_turmas.json');
    exit();
}

if(isset($_GET["disponiveis"])){

    $id_turma = $_GET["id-turma"] ?? null;

    if($id_turma){
        $selectSQL = "SELECT t.turno as turno,
                             t.tipo_turma as tipo_turma,
                             r.data as `data`
        FROM reservas as r 
        INNER JOIN turmas as t 
        ON t.id_turma = r.id_turma 
        WHERE r.id_turma = $id_turma";

        $turma = $conn->query($selectSQL)->fetch(PDO::FETCH_ASSOC);

        $tipo_turma = $turma["tipo_turma"];
        $turno = $turma["turno"];
        $datas = $turma["data"];

    } else {
        $tipo_turma = $_GET["tipo-reserva"];
        $turno = $_GET["turno"];
        $datas = $_GET["datas"];
    }

    if (!file_exists(ROOT_DIR. 'JSON/dados_turmas.json')) {
        gerarTurmasJSON();
    }

    if(!is_array($datas)){
        $datas = array($datas);
    }

    $dadosJSON = json_decode(file_get_contents(ROOT_DIR. 'JSON/dados_turmas.json'),true);

    $turmas = $dadosJSON["turmas"];
    
    $turmaEncontrada = false;

    if($tipo_turma == "Graduação"){
        
        $selectSQL = "SELECT DISTINCT r.id_turma 
                      FROM reservas as r
                      INNER JOIN turmas as t 
                      ON r.id_turma = t.id_turma
                      WHERE t.tipo_turma = 'Graduação' AND";

        $sql = [];

        $i = 0;
    
        while(isset($datas[$i])){

            $data_inicial = date('Y-m-d',strtotime("-6 days",strtotime($datas[$i])));

            while(isset($datas[$i+1])){
                $diff = date_diff(date_create($datas[$i]),date_create($datas[$i+1]),true);
                if((int) $diff->format("%a") > 7 ){
                    break;
                }
                $i++;
            }
            $data_final = date('Y-m-d',strtotime("+6 days",strtotime($datas[$i])));
            $sql[] = " DATE(r.data) BETWEEN '$data_inicial' AND '$data_final'";
            $i++;
        }

        $selectSQL .= implode(" OR ", $sql);
    
    } else if ($tipo_turma == "Avulsa"){

        $selectSQL = "SELECT DISTINCT r.id_turma 
                    FROM reservas as r
                    INNER JOIN turmas as t
                    ON r.id_turma = t.id_turma
                    WHERE t.tipo_turma = 'Avulsa' AND DATE(r.data) = '$datas[0]'";

    } else if ($tipo_turma == "FIC"){

        $selectSQL = "SELECT DISTINCT r.id_turma 
                    FROM reservas as r
                    INNER JOIN turmas as t
                    ON r.id_turma = t.id_turma
                    WHERE t.tipo_turma = 'Avulsa'";
                    
        foreach ($variable as $key => $value) {
            
        }
        
    }
        
    $stm = $conn->query($selectSQL);
    $arr_ids = $stm->fetchAll(PDO::FETCH_COLUMN);

    if($dadosJSON["status"] == 200) {
        
        foreach ($turmas as $turma) {

            if($turma["turno"] == $turno and $turma["tipo_turma"] == $tipo_turma){

                if($id_turma and $turma["id_turma"] == $id_turma){?>
                    <option value="<?php echo $turma["id_turma"] ?>" id="opt-<?php echo $turma["id_turma"] ?>" selected="" >  <?php echo $turma["nome"]?> </option>
                <?php } 

                if(!in_array($turma["id_turma"],$arr_ids)){
                    $turmaEncontrada = true;?>
                    <option value="<?php echo $turma["id_turma"] ?>" id="opt-<?php echo $turma["id_turma"] ?>" >  <?php echo $turma["nome"]?> </option>
                    <?php } 
                    else if (in_array($turma["id_turma"],$arr_ids) && $turma["id_turma"] != $id_turma) {?>
                    <option value="" disabled>  <?php echo $turma["nome"]?> - indisponível</option>

                <?php }
            }
        }




}


    if(!$turmaEncontrada and !$id_turma){?>
        <option value="" >Nenhuma turma disponível</option>
<?php }
    else if(!$id_turma){?>
        <option value="" selected="">Selecione uma turma</option>
        <?php }


        exit();
} 

if(isset($_GET['turma-dados'])){

    $id_turma = $_GET["id-turma"];
    
    if (!file_exists(ROOT_DIR. 'JSON/dados_turmas.json')) {
        gerarTurmasJSON();
    }
    
    $dadosJSON = json_decode(file_get_contents(ROOT_DIR. 'JSON/dados_turmas.json'),true);
    
    $turmas = $dadosJSON["turmas"];
    
    foreach ($turmas as $turma) {
        if($turma["id_turma"] == $id_turma){
            
            exit(json_encode($turma));
        }
    }

} 


if(isset($_GET["num_reservas_turma"])){

    $id_turma = $_GET["num_reservas_turma"];

    $selectSQL = "SELECT count(1) as 'reservas_num' FROM reservas WHERE id_turma = '$id_turma'";

    $stm = $conn->prepare($selectSQL);
    $stm->execute();
    $arr = $stm->fetch(PDO::FETCH_ASSOC);

    $reservas_num = $arr["reservas_num"];

    $resposta["msg"] = "<p>Certeza que deseja deletar a turma selecionada?";

    if($reservas_num == 1){
        $resposta["msg"] .= '<br>Uma reserva tambem sera deletada</p>';
    }
    else if ($reservas_num > 1) {
        $resposta["msg"] .= '<br>'. $reservas_num." reservas tambem serao deletadas";
    }
    
    echo json_encode($resposta);
}


?>

   