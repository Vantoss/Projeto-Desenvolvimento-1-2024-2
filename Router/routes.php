<?php

require 'Router.php';

$router = new Router();



// pagina_inicial
$router->get('/inicial', 'controllers/paginas/pagina_inicial/index.php');

$router->get('/', 'controllers/paginas/pagina_inicial/index.php');


// pagina gerenciamento salas
$router->get('/gerenciamento-salas','controllers/paginas/gerenciar_salas/index.php');

// salas
$router->get('/salas','controllers/salas/mostrar_salas.php');

$router->delete('/salas','controllers/salas/deletar_salas.php');

$router->put('/salas','controllers/salas/editar_salas.php');



// paginas gerenciamento reservas
$router->get('/cadastro-reservas','controllers/paginas/cadastrar_reservas/index.php');

$router->get('/consulta-reservas','controllers/paginas/consultar_reservas/index.php');

//reservas
$router->get('/reservas','controllers/reservas/mostrar_reservas.php');

$router->post('/reservas','controllers/reservas/cadastrar_reservas.php');

$router->put('/reservas','controllers/reservas/editar_reservas.php');

$router->delete('/reservas','controllers/reservas/deletar_reservas.php');


// pagina gerenciar turmas
$router->get('/gerenciamento-turmas','controllers/paginas/gerenciar_turmas/index.php');


// turmas
$router->get('/turmas','controllers/turmas/mostrar_turmas.php');

$router->post('/turmas','controllers/turmas/cadastrar_turmas.php');

$router->put('/turmas','controllers/turmas/editar_turmas.php');

$router->delete('/turmas','controllers/turmas/deletar_turmas.php');


$router->get("/test","test/test.php");


// gerenciamento de chaves

$router->get("/chaves","controllers/chaves/mostrar_chaves.php");

$router->put("/chaves","controllers/chaves/editar_chaves.php");

$router->delete("/chaves","controllers/chaves/deletar_chaves.php");

$router->post("/chaves","controllers/chaves/cadastrar_chaves.php");

$router->get("/chaves/movimentacoes","controllers/movimentacoes_chaves/mostrar_movimentacoes.php");

$router->post("/chaves/movimentacoes","controllers/movimentacoes_chaves/cadastrar_movimentacoes.php");