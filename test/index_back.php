<?php
define('ROOT_DIR', '');

require_once ROOT_DIR. 'includes/functions.php';

require_once ROOT_DIR. 'includes/loader.php';
    
require_once ROOT_DIR. 'router.php';


$root_url = '/Projeto-Desenvolvimento-1-2024-2/';

// var_dump(parse_url($_SERVER["REQUEST_URI"])["path"]);

// echo $_SERVER['REQUEST_URI'];
$router = new Router();

$router->addRoute('GET', $root_url.'pagina-inicial', function () {
    
    require_once ROOT_DIR.'pages/pagina_inicial.php';
    
});

$router->addRoute('GET', $root_url, function () {
    
    require_once ROOT_DIR.'pages/pagina_inicial.php';
    
});




$router->addRoute('GET', $root_url.'cadastrar-reservas', function () {
    
    require_once ROOT_DIR.'pages/cadastrar_reservas.php';
    
});


$router->addRoute('GET', $root_url.'cadastrar-reservas/salas-disponiveis/:getData', function ($getData) {
        
        require 'controllers/cadastrar_reservas_tabela.php';

        // echo gerarTabelaSalasDisponiveis($getData);
});

$router->addRoute('GET', $root_url.'consultar-reservas', function () {
    
    require_once ROOT_DIR.'pages/consultar_reservas.php';
    
});

$router->addRoute('GET', $root_url.'gerenciar-turmas', function () {
    
    require_once ROOT_DIR.'pages/gerenciar_turmas.php';
    
});

$router->addRoute('GET', $root_url.'gerenciar-salas', function () {
    
    require_once ROOT_DIR.'pages/gerenciar_salas.php';
    
});

$router->addRoute('GET', $root_url.'cadastrar-reservas/salas-disponiveis-tabela-json', function () {
    echo file_get_contents(ROOT_DIR."JSON/dados_tabela_salas.json");
    
});

$router->matchRoute();

// $method = $_SERVER["REQUEST_METHOD"];
// $_SERVER['REQUEST_URI'];

// switch ($method) {


//     case $root_url.'pagina-inicial':

//         require_once ROOT_DIR.'pages/pagina_inicial.php';

//         break;

//     case "POST":
//         break;

//     case "PUT":
//         putHandler();
//         break;

//     case "DELETE":
//         deleteHandler();
//         break;
    
// }








?>
