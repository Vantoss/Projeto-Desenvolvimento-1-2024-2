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

function turmasOptions($turno){

    $conn = initDB();
    $select = "SELECT id_turma as id, nome, codigo, turno FROM turmas WHERE turno = '$turno'";

    $stm = $conn->prepare($select);
    $stm->execute();

    $turmas = $stm->fetchAll(PDO::FETCH_ASSOC);

    if(!($turmas)){
        
        file_put_contents('dados_turmas.json', json_encode(" "));    
    }
    file_put_contents('dados_turmas.json', json_encode($turmas));    
    

}

function salasOptions($opcao){

        $conn = initDB();
        $select = "SELECT  id_sala as 'id' , tipo_sala as 'tipo', maquinas_tipo as 'maquinas' FROM salas";
        $stm = $conn->prepare($select);
        $stm->execute();
        $salas = $stm->fetchAll(PDO::FETCH_ASSOC);

        
        foreach ($salas as $sala) {
            $salas_tipos[] = $sala["tipo"];
            $maquinas_tipos[] = $sala["maquinas"]; 
            }

    if($opcao == "id_sala"){

        foreach ($salas as $sala) {?>
          <option value="<?php echo $sala["id"]?>" ><?php echo $sala["id"] ?></option>
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

// function gerarTabel

?>


