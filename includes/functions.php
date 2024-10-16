<?php 
// MOVE AS RESERVAS PARA A TABELA "reservas_historico"
function gerarHistorico(){
    $conn = initDB();
    $data = date('Y-m-d');

    // verifica se as reservas ja foram movidas
    // faz uma nova verificacao a cada nova sessao iniciada  
    if(!isset($_SESSION["historico_gerado"]) || $_SESSION["historico_gerado"] < $data){

        $_SESSION["historico_gerado"] = $data;
        
        echo "data: " . $_SESSION["historico_gerado"] . "<br>";
        
        $query = "CALL inserir_reservas_historico";
        $stm = $conn->prepare($query);
        $stm->execute(); 
        $reservas = $stm->rowCount();
        echo $reservas ." reservas inseridas na tabela reservas_historico <br>";
        
        $query = "CALL deletar_reservas_passadas";
        $stm = $conn->prepare($query);
        $stm->execute();
        $reservas = $stm->rowCount();
        echo $reservas ." reservas deletadas da tabela reservas";

    }
}
function activeTab($requestUri){
    $current_file_name = basename($_SERVER['REQUEST_URI'], ".php");
    if ($current_file_name == $requestUri) echo 'active'; 
  }

function customPageHeader($pagina_titulo){
    
    // HEADER DA PAGINA CADASTRAR RESERVA
    if($pagina_titulo == "Cadastrar Reserva"){?>
    <link rel="stylesheet" href="<?php echo ROOT_DIR. "assets/styles/cadastrar_reserva.css"?>">
    <script src="<?php echo ROOT_DIR. 'assets/js/cadastrar_reservas.js'?>" defer></script> <?php
    } 

    // HEADER DA PAGINA CONSULTAR RESERVA
    else if ($pagina_titulo == "Consultar Reserva"){?>
    <link rel="stylesheet" href="<?php echo ROOT_DIR. 'assets/styles/consultar_reserva.css'?>">
    <script src="<?php echo ROOT_DIR. 'assets/js/consultar_reservas.js' ?>" defer ></script> <?php
    }
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

    if (!file_exists(ROOT_DIR. 'JSON/dados_turmas.json')) {
        touch(ROOT_DIR. 'JSON/dados_turmas.json');
    }

    file_put_contents(ROOT_DIR. 'JSON/dados_turmas.json', json_encode($dados));
  
}

function optionsTurmas($turno){

    $dadosJSON = json_decode(file_get_contents(ROOT_DIR. 'JSON/dados_turmas.json'),true);

    $turmas = $dadosJSON["turmas"];
    
    $turmaEncontrada = false;

    if($dadosJSON["status"] == 200){?>
        <option value="" selected="">Selecione uma turma</option>    
<?php   foreach ($turmas as $turma) {

            if($turma["turno"] == $turno){
                $turmaEncontrada = true;?>
                <option value="<?php echo $turma["id_turma"]; ?>"> <?php echo $turma["nome"] . " - " . $turma["turno"];?> </option>
      <?php }
        }
    }
    if(!$turmaEncontrada){?>
        <option value="" selected="">Nenhuma turma cadastrada</option>
<?php }

}


function gerarSalasJSON(){

    $conn = initDB();
    $select = "SELECT * FROM salas";

    $stm = $conn->prepare($select);
    $stm->execute();

    $salas = $stm->fetchAll(PDO::FETCH_ASSOC);

    if($salas){
        
        $dados = [
            "status" => 200,
            "salas" => $salas
        ];

    } else {

        $dados = [
            "status" => 204,
            "msg" => "Nenhuma sala cadastrada",
        ];
    }

    
    touch(ROOT_DIR. 'JSON/dados_salas.json');
    
    file_put_contents(ROOT_DIR. 'JSON/dados_salas.json', json_encode($dados));

}

function salasOptions($opcao){

    if (!file_exists(ROOT_DIR. 'JSON/dados_salas.json')) {
        gerarSalasJSON();
    }

    $salasJSON = json_decode(file_get_contents(ROOT_DIR. 'JSON/dados_salas.json'),true);

    $salas = $salasJSON["salas"];
        
        foreach ($salas as $sala) {
            $salas_tipos[] = $sala["tipo_sala"];
            $maquinas_tipos[] = $sala["maquinas_qtd"]; 
            }

    if($opcao == "id_sala"){

        foreach ($salas as $sala) {?>
          <option value="<?php echo $sala["id_sala"]?>" ><?php echo $sala["id_sala"] ?></option>
          <?php }
    } 
    else if ($opcao == "tipo_sala") {

        foreach (array_unique($salas_tipos) as $sala) {?>
          <option value="<?php echo $sala?>" ><?php echo ucfirst(mb_strtolower($sala))?></option>
          <?php } 

    } else {
        
        foreach (array_unique($maquinas_tipos) as $maquina) {
            
            if($maquina){?>
            <option value="<?php echo $maquina?>" ><?php echo ucfirst(mb_strtolower($maquina))?></option>
            <?php }}

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
      } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
      }

      return $conn;
}

function checkDatabaseInstallation(){
		$conn = initDb();
		if (!$conn) {
			redirectError('Could not connect to database. Please, try to <a href="../pages/install.php">install</a>.');
		}
		
	}


function redirectError($errid){
	$_SESSION['err'] = array('date' => date("Y-m-d H:i:s"), 'message' => $errid);
	redirectTo('./pages/error.php');
}

function redirectTo($href){
    header( "Location: {$href}" );
  exit;
}


function editarTurma($turma){

    $conn = initDB();
    
    $sql = [];
        $updateSQL = "UPDATE turmas SET";

        if($turma["nome"]) $sql[] = " nome = '{$_POST["nome"]}'";
        
        if($turma["docente"]) $sql[] = " docente = '{$_POST["docente"]}'";
        
        if($turma["participantes"]) $sql[] = " participantes_qtd = {$_POST["participantes"]}";
        
        if($turma["curso"]) $sql[] = " curso = '{$_POST["curso"]}'";
        
        if($turma["codigo"]) $sql[] = " codigo = '{$_POST["codigo"]}'";
        
        if($sql) $updateSQL .= implode(',',$sql) . " WHERE id_turma = {$_POST["id_turma"]}";


        // EXECUTANDO SQL
        $stm = $conn->prepare($updateSQL);

        if($stm->execute()){
            $resposta["status"] = 200;
            $resposta["msg"] = "Turma editada com sucesso";
        }

        gerarTurmasJSON();
        
        return $resposta;
}

?>


