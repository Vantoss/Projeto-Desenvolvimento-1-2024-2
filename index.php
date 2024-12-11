<?php

const ROOT_DIR = '';

require_once ROOT_DIR. 'core/functions.php';

require_once ROOT_DIR. 'core/loader.php';

require_once ROOT_DIR. "Router/routes.php";

$root_url = '/Projeto-Desenvolvimento-1-2024-2/';


$uri = parse_url($_SERVER["REQUEST_URI"])["path"];

$method = $_SERVER["REQUEST_METHOD"];


$uri = str_replace($root_url,'/',$uri);


$router->route($uri,$method);


