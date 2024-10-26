<?php
// -----------------------------------------------------------------------------
// 1. Ping MYSQL Server

define("ROOT_DIR","../");
require_once ROOT_DIR. 'includes/functions.php';

  $host = $_POST['dbaddr'];
  $port = $_POST['dbport'];
  $user = $_POST['dbuser'];
  $pass = $_POST['dbpass'];
  $dbname = $_POST['dbname'];

  $conn =  new PDO("mysql:host=$host;port=$port", $user, $pass);
  if (!$conn) {
    $resposta["status"] = 400;
    $resposta["msg"] = "Erro ao conectar com o banco de dados MYSQL";
  }
  
  // -----------------------------------------------------------------------------
  // 2. Criar Banco de dados
  
  $create_db = "CREATE DATABASE $dbname;";
  if (!$conn->query($create_db)) {
    $resposta["status"] = 400;
    $resposta["msg"] = "Erro ao criar banco de dados ". $dbname;
  }
  
  $connect_db = "USE $dbname;";
  if (!$conn->query($connect_db)) {
    $resposta["status"] = 400;
    $resposta["msg"] = "Erro conectar com o banco dados ". $dbname;
  }
  
  // -----------------------------------------------------------------------------
  // 3. Create tables
  $tabela_turmas = "CREATE TABLE turmas (
  id_turma int(11) NOT NULL,
  nome varchar(80) DEFAULT NULL,
  curso varchar(80) DEFAULT NULL,
  docente varchar(50) DEFAULT NULL,
  turno varchar(10) DEFAULT NULL,
  codigo varchar(60) DEFAULT NULL,
  participantes_qtd int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";

// $table_users = "CREATE TABLE users (id INT(6) NOT NULL auto_increment, name VARCHAR(15), surname VARCHAR(32), password VARCHAR(40), PRIMARY KEY (id) );";
if (!$conn->query($tabela_turmas)) {
  $resposta["status"] = 400;
  $resposta["msg"] = "Erro ao criar tabela turmas";
}

$tabela_salas = "CREATE TABLE `salas` (
  `id_sala` int(11) NOT NULL,
  `tipo_sala` varchar(45) DEFAULT NULL,
  `lugares_qtd` int(11) DEFAULT NULL COMMENT 'capacidade das salas (lotação)',
  `maquinas_qtd` int(11) DEFAULT NULL,
  `maquinas_tipo` varchar(45) DEFAULT NULL,
  `descricao` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";

if (!$conn->query($tabela_salas)) {
  $resposta["status"] = 400;
  $resposta["msg"] = "Erro ao criar tabela salas";
}

$tabela_reservas = "CREATE TABLE reservas (
  id_reserva int(11) NOT NULL,
  `data` date NOT NULL,
  tipo_reserva varchar(30) DEFAULT NULL,
  id_sala int(11) NOT NULL,
  id_turma int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";


if (!$conn->query($tabela_reservas)) {
  $resposta["status"] = 400;
  $resposta["msg"] = "Erro ao criar tabela reservas";
}


$tabela_historico = "CREATE TABLE reservas_historico (
  id_reserva int(11) NOT NULL,
  tipo_reserva varchar(30) DEFAULT NULL,
  `data` date NOT NULL,
  docente varchar(80) NOT NULL,
  nome_turma varchar(80) DEFAULT NULL,
  curso varchar(80) DEFAULT NULL,
  turno varchar(10) DEFAULT NULL,
  codigo varchar(60) DEFAULT NULL,
  participantes int(11) NOT NULL,
  id_sala int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";

if (!$conn->query($tabela_historico)) {
  $resposta["status"] = 400;
  $resposta["msg"] = "Erro ao criar tabela reservas historico";
}

$alter_tables = "ALTER TABLE `turmas`
  ADD PRIMARY KEY (`id_turma`);
  
  ALTER TABLE `reservas`
  ADD PRIMARY KEY (`id_reserva`),
  ADD KEY `id_sala` (`id_sala`),
  ADD KEY `id_turma` (`id_turma`);

  ALTER TABLE `salas`
  ADD PRIMARY KEY (`id_sala`);

  ALTER TABLE `turmas`
  MODIFY `id_turma` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

  ALTER TABLE `reservas`
  MODIFY `id_reserva` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=127;

  ALTER TABLE `reservas`
  ADD CONSTRAINT `reservas_ibfk_1` FOREIGN KEY (`id_sala`) REFERENCES `salas` (`id_sala`),
  ADD CONSTRAINT `reservas_ibfk_2` FOREIGN KEY (`id_turma`) REFERENCES `turmas` (`id_turma`);
  COMMIT;";

if (!$conn->query($alter_tables)) {
  $resposta["status"] = 400;
  $resposta["msg"] = "Erro ao modificar tabelas";
}

$procedures = "CREATE DEFINER=`root`@`localhost` PROCEDURE deletar_reservas_passadas ()   DELETE FROM reservas WHERE data < CURRENT_DATE;

CREATE DEFINER=`root`@`localhost` PROCEDURE inserir_reservas_histórico ()   INSERT INTO reservas_historico (id_reserva, tipo_reserva, data, docente, nome_turma, curso, turno, codigo, participantes, id_sala)
SELECT r.id_reserva, r.tipo_reserva, r.data, t.docente, t.nome, t.curso, t.turno, t.codigo, t.participantes_qtd, r.id_sala
FROM reservas as r
INNER JOIN turmas as t
ON r.id_turma = t.id_turma
WHERE r.data < CURRENT_DATE;";


if (!$conn->query($procedures)) {
  $resposta["status"] = 400;
  $resposta["msg"] = "Erro ao criar procedures";
}

// -----------------------------------------------------------------------------
// 4. Insert data

$insert_turmas = "INSERT INTO `turmas` (`id_turma`, `nome`, `curso`, `docente`, `turno`, `codigo`, `participantes_qtd`) VALUES
(1, 'Desenvolvimento Interface Web', 'SPI', 'Fernando', 'Manhã', 'RS-20231-FSPOA-DlW-PRE-SPI1M24-1A', 20),
(2, 'Desenvolvimento Interface Web', 'SPI', 'Fernando', 'Noite', 'RS-20231-FSPOA-DlW-PRE-SPI1N24-1A', 25),
(3, 'Desenvolvimento Gráfico', 'PM', 'Roberto', 'Manhã', 'RS-20242-FSPOA-DGR-PRE-PM1M24-2', 18),
(4, 'Desenvolvimento Gráfico', 'PM', 'Roberto', 'Noite', 'RS-20242-FSPOA-DGR-PRE-PM1N24-2', 25),
(5, 'Algoritmos Estruturas de Dados I', 'ADS', 'Roberto', 'Manhã', 'RS-20232-FSPOA-ALG1-PRE-ADS3M24-2', 27),
(6, 'Algoritmos Estruturas de Dados I', 'ADS', 'Roberto', 'Noite', 'RS-20232-FSPOA-ALG1-PRE-ADS3N24-2', 22),
(7, 'Fundamentos Computacionais', 'ADS', 'Ronaldo', 'Manhã', 'RS-20222-FSPOA-FUND-PRE-ADS1M24-2', 22),
(8, 'Fundamentos Computacionais', 'ADS', 'Ronaldo', 'Noite', 'RS-20222-FSPOA-FUND-PRE-ADS1N24-2', 26);";

if (!$conn->query($insert_turmas)) {
  $resposta["status"] = 400;
  $resposta["msg"] = "Erro ao inserir dados na tabela turmas";
}


$insert_salas = "INSERT INTO `salas` (`id_sala`, `tipo_sala`, `lugares_qtd`, `maquinas_qtd`, `maquinas_tipo`, `descricao`) VALUES
(101, 'Laboratório', 20, 20, 'Intel-i5-7', NULL),
(102, 'Laboratório', 40, 30, 'Intel-i5-7', NULL),
(103, 'Laboratório', 30, 20, 'Intel-i3-7', NULL),
(104, 'Auditório', 100, 2, 'Intel-i3-7', NULL),
(105, 'Laboratório', 30, 20, 'Intel-i3-7', NULL),
(122, 'Estudio de Aúdio', 10, 2, 'Intel-i3-7', NULL),
(201, 'Laboratório', 30, 30, 'Ryzen-5', NULL),
(202, 'Laboratório', 40, 30, 'Ryzen-5', NULL),
(203, 'Laboratório', 35, 20, 'Ryzen-5', NULL),
(204, 'Laboratório', 45, 30, 'Ryzen-5', NULL),
(205, 'Laboratório', 45, 30, 'Ryzen-5', NULL),
(301, 'Laboratório', 25, 20, 'Intel-i9-12', NULL),
(302, 'Laboratório', 25, 20, 'Intel-i9-12', NULL),
(303, 'Laboratório', 25, 20, 'Intel-i9-12', NULL),
(304, 'Laboratório', 45, 35, 'IMAC', NULL),
(305, 'Laboratório', 45, 35, 'IMAC', NULL),
(306, 'Laboratório', 45, 35, 'IMAC', NULL),
(307, 'Laboratório', 30, 30, 'Intel-i7-10', NULL),
(401, 'Sala de aula', 40, 0, NULL, NULL),
(402, 'Sala de aula', 50, 0, NULL, NULL),
(403, 'Sala de aula', 40, 0, NULL, NULL),
(404, 'Sala de aula', 60, 0, NULL, NULL),
(501, 'Laboratório', 30, 30, 'Ryzen-5', NULL),
(502, 'Laboratório', 50, 30, 'Ryzen-5', NULL),
(503, 'Laboratório', 25, 25, 'Ryzen-5', NULL),
(504, 'Laboratório', 50, 35, 'Ryzen-5', NULL),
(505, 'Laboratório', 50, 35, 'Ryzen-5', NULL),
(601, 'Laboratório', 30, 30, 'Intel-i5-6', NULL),
(602, 'Laboratório', 40, 28, 'Intel-i5-6', NULL),
(603, 'Laboratório', 20, 22, 'Intel-i5-6', NULL),
(604, 'Laboratório', 30, 35, 'Intel-i5-6', NULL),
(605, 'Laboratório', 30, 30, 'Intel-i5-6', NULL),
(801, 'Auditório', 100, 1, 'Intel-i7-10', NULL),
(802, 'Auditório', 80, 1, 'Intel-i7-10', NULL),
(803, 'Auditório', 150, 1, 'Intel-i7-10', NULL);";


if (!$conn->query($insert_salas)) {
  $resposta["status"] = 400;
  $resposta["msg"] = "Erro ao inserir dados na tabela salas";
}



// -----------------------------------------------------------------------------
// 4. Save config file

$configFilePath = ROOT_DIR . 'conf/config.ini';

$configDB = "
[Database]
host = $host
dbname = $dbname
user = $user
password = $pass";


if (!file_exists(ROOT_DIR. 'conf/config.ini')) {
  touch(ROOT_DIR. 'conf/config.ini');
}

file_put_contents($configFilePath, $configDB);



// -----------------------------------------------------------------------------
// 5. Done

$resposta["status"] = 200;
$resposta["msg"] = "<p>Banco de dados criado. Ir para: <a href='".ROOT_DIR."index.php'>Pagina Inicial</a></p>";


echo json_encode($resposta);

?>
