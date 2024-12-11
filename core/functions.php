<?php 
// MOVE AS RESERVAS PARA A TABELA "reservas_historico"
function gerarHistorico(){
    $conn = initDB();
    $data = dataAtual();

    // verifica se as reservas ja foram movidas
    // faz uma nova verificacao a cada nova sessao iniciada  
    if(!isset($_SESSION["historico_gerado"]) || $_SESSION["historico_gerado"] < $data){

        $_SESSION["historico_gerado"] = $data;
        
        // echo "data: " . $_SESSION["historico_gerado"] . "<br>";
        
        $query = "CALL inserir_reservas_historico";
        $stm = $conn->prepare($query);
        $stm->execute(); 
        $reservas = $stm->rowCount();
        // echo $reservas ." reservas inseridas na tabela reservas_historico <br>";
        
        $query = "CALL deletar_reservas_passadas";
        $stm = $conn->prepare($query);
        $stm->execute();
        $reservas = $stm->rowCount();
        // echo $reservas ." reservas deletadas da tabela reservas";

    }
}

function activeTab($requestUri){
    $current_file_name = basename($_SERVER['REQUEST_URI'], ".php");
    if ($current_file_name == $requestUri) echo 'active'; 
  }

function customPageHeader($pagina_titulo){
    
    // HEADER DA PAGINA CADASTRAR RESERVA
    if($pagina_titulo == "Cadastrar Reserva"){?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo ROOT_DIR. "assets/styles/cadastrar_reserva.css"?>">
    <script src="<?php echo ROOT_DIR. 'assets/js/cadastrar_reservas.js'?>" defer></script> <?php
    } 

    // HEADER DA PAGINA CONSULTAR RESERVA
    else if ($pagina_titulo == "Consultar Reserva"){?>
    <link rel="stylesheet" href="<?php echo ROOT_DIR. 'assets/styles/consultar_reserva.css'?>">
    <script src="<?php echo ROOT_DIR. 'assets/js/consultar_reservas.js' ?>" defer ></script> <?php
    }

    else if ($pagina_titulo == "Gerenciar Salas"){?>
    <!-- <link rel="stylesheet" href="<?php echo ROOT_DIR. 'assets/styles/consultar_reserva.css'?>"> -->
    <script src="<?php echo ROOT_DIR. 'assets/js/gerenciar_salas.js' ?>" defer ></script> <?php
    }


}

function gerarDatasGraducao($data_inicial,$data_final=null,$semanas=null){
    $dias = "";

    if($data_final){
                
        while ($data_inicial <= $data_final) {
            $dias .= $data_inicial->format('\'Y-m-d\',');
            $data_inicial->modify("+1 week");
        }
        
    } else {

        for ($i=0; $i < $semanas; $i++) { 
            $dias .= $data_inicial->format('\'Y-m-d\',');
            $data_inicial->modify("+1 week");
        }
    }
    return $dias = substr_replace($dias,"",-1); 
}

function gerarDatasFIC($data_inicial,$data_final,$semanas){
    $dias ="";

    $semanas *= 5; 

    $fim_semanda = ["6","0"];

    if($data_final){

        while ($data_inicial <= $data_final) {
            if(!in_array($data_inicial->format('w'),$fim_semanda)){
                $dias .= (string) $data_inicial->format('\'Y-m-d\',');
            }
            $data_inicial->modify("+1 day");
        }

    } else {
        $i=0;
        while ($i < $semanas) {
            if(!in_array($data_inicial->format('w'),$fim_semanda)){
                $dias .=  $data_inicial->format('\'Y-m-d\',');
                $i++;
            }
            $data_inicial->modify("+1 day");
        }
    }

    return $dias = substr_replace($dias,"",-1); 
}
function gerarDatasPos($data_inicial,$dias_semana,$semanas){
    $dias ="";



    // if($data_final){

    //     while ($data_inicial <= $data_final) {
    //         if(!in_array($data_inicial->format('w'),$dias_semana)){
    //             $dias .= $data_inicial->format('Y-m-d,');
    //         }
    //         $data_inicial->modify("+1 day");
    //     }

    // } else {
        $i=0;
        while ($i < $semanas * count($dias_semana)) {
            if(in_array($data_inicial->format('w'),$dias_semana)){
                $dias .= $data_inicial->format('\'Y-m-d\',');
                $i++;
            }
            $data_inicial->modify("+1 day");
        }
    // }

    return $dias = substr_replace($dias,"",-1); 
}



function gerarTurmasJSON(){

    $conn = initDB();
    $select = "SELECT * FROM turmas";

    $stm = $conn->prepare($select);
    $stm->execute();

    $turmas = $stm->fetchAll(PDO::FETCH_ASSOC);

    if($turmas){
        
        $dados = [
            "status" => 200,
            "turmas" => $turmas
        ];

    } else {

        $dados = [
            "status" => 204,
            "msg" => "Nenhuma turma cadastrada",
        ];
    }

    touch(ROOT_DIR. 'JSON/dados_turmas.json');
    
    file_put_contents(ROOT_DIR. 'JSON/dados_turmas.json', json_encode($dados));
  
}


function gerarSalasJSON(){

    $conn = initDB();
    $select = "SELECT * FROM salas ORDER BY numero_sala";

    $stm = $conn->prepare($select);
    $stm->execute();

    $salas = $stm->fetchAll(PDO::FETCH_ASSOC);

    if(!$salas){
        $dados = [
            "status" => 204,
            "msg" => "Nenhuma sala cadastrada",
        ];
    }        

    $dados = [
        "status" => 200,
        "salas" => $salas
    ];

        
    touch(ROOT_DIR. 'JSON/salas.json');
    
    file_put_contents(ROOT_DIR. 'JSON/salas.json', json_encode($dados));

}

function salasOptions($opcao){
    
    if (!file_exists(ROOT_DIR. 'JSON/salas.json')) {
        gerarSalasJSON();
    }
    
    $salasJSON = json_decode(file_get_contents(ROOT_DIR. 'JSON/salas.json'),true);

    

    if(!$salasJSON){ 
       echo '<option value="" selected="">Nenhuma sala cadastrada </option>';
       return; 
    } 
    $salas = $salasJSON["salas"];
    
    foreach ($salas as $sala) {
        $salas_tipos[$sala["tipo_sala"]] = "";
            $maquinas_tipos[$sala["maquinas_tipo"]] = ""; 
        }

    if($opcao == "id_sala"){

        foreach ($salas as $sala) {?>
          <option value="<?php echo $sala["id_sala"]?>" ><?php echo $sala["numero_sala"] . " - Unidade " . $sala["unidade"] ?></option>
          <?php }
    } 
    else if ($opcao == "tipo_sala") {
        
        foreach (array_keys($salas_tipos) as $sala) {?>
          <option value="<?php echo $sala?>" ><?php echo ucfirst(mb_strtolower($sala))?></option>
          <?php } 

} else {
    
    foreach (array_keys($maquinas_tipos) as $maquina) {
        
        if($maquina){?>
            <option value="<?php echo $maquina?>" ><?php echo ucfirst(mb_strtolower($maquina))?></option>
            <?php }}
    }
}

function turmasOptions(){
    try {
        if (!file_exists(ROOT_DIR. 'JSON/dados_turmas.json')) {
            gerarturmasJSON();
        }
        $turmasJSON = json_decode(file_get_contents(ROOT_DIR. 'JSON/dados_turmas.json'),true);
        
        if(!$turmasJSON){ 
            return; 
     }
     
    $turmas = $turmasJSON["turmas"];
    foreach ($turmas as $turma) {
        $semestres[$turma["semestre"]] = "";   
    }
    
    foreach (array_keys($semestres) as $semestre) {
        
        if($semestre){?>
            <option value="<?php echo $semestre?>" ><?php echo $semestre?></option>
            <?php }}

} catch (\Throwable $th) {
    echo "<option> Erro ao carregar dados</option>";
}
}



function getConfig(){
    return parse_ini_file(ROOT_DIR.'conf/config.ini');
}

function initDB(){
    
    $config = getConfig();

    try {
        $conn = new PDO("mysql:host={$config['host']};dbname={$config['dbname']}", $config['user'], $config["password"]);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      //   echo "Connected successfully";
        return $conn;

      } catch(PDOException $e) {
        // echo "Connection failed: " . $e->getMessage();
      }

}

function checkDatabaseInstallation(){
        $conn = initDb();

		if (!$conn) {
            require_once './core/install.php';
            // return false;
            exit();
		}
		
        return true;
}


function redirectError($errid){
	// $_SESSION['err'] = array('date' => date("Y-m-d H:i:s"), 'message' => $errid);

	// redirectTo('./core/install.php');
    
}

function redirectTo($href){
    header( "Location: {$href}" );
    exit;

}


function dataAtual(){

    $dt = new DateTime("now", new DateTimeZone('America/Sao_Paulo'));
    return $dt->format('Y-m-d');
}

        
function dd($value){
    var_dump($value);
    die();
}


function getRequesData(){
    $query = parse_url($_SERVER["REQUEST_URI"])["query"] ?? null;

    if($query){
        parse_str($query,$data);
    } else {
        $data = json_decode(file_get_contents('php://input'),true);
    }
    // exit(var_dump($data));

    return $data;
}

function verificarId($tabela,$arr){
    $conn = initDB();

    $id_campo = array_keys($arr)[0];
    $id = array_values($arr)[0];

    $selectSQL = "SELECT 1 FROM $tabela WHERE $id_campo = $id";

    if($conn->query($selectSQL)->fetchColumn() == 0){
        exit(json_encode([
            "status" => 400,
            "msg" => "Id $id nao existe"
        ]));
    }

}


function getDataAtual(){
    $dias_semana = [
        'Monday' => 'Segunda-feira',
        'Tuesday' => 'Terça-feira',
        'Wednesday' => 'Quarta-feira',
        'Thursday' => 'Quinta-feira',
        'Friday' => 'Sexta-feira',
        'Saturday' => 'Sábado',
        'Sunday' => 'Domingo'
    ];
    $data_atual = date('d/m/Y'); // Formato: dia/mês/ano
    $dia = date('l');

    return  $dias_semana[$dia] . ", " .$data_atual;
}


function view($path){

    return ROOT_DIR. "views/".$path;
}
?>


