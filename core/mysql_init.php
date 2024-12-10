<?php
// -----------------------------------------------------------------------------
// 1. Ping MYSQL Server
define('ROOT_DIR', '../');

require_once ROOT_DIR. 'core/functions.php';

  $host = $_POST['dbaddr'];
  $port = $_POST['dbport'];
  $user = $_POST['dbuser'];
  $pass = $_POST['dbpass'];
  $dbname = $_POST['dbname'];

  try {
    
    $conn =  new PDO("mysql:host=$host;port=$port", $user, $pass);
    
    if (!$conn) {
      throw new Exception("Erro ao conectar com o banco de dados MYSQL". $dbname,500);
    }
    
    // -----------------------------------------------------------------------------
    // 2. Criar Banco de dados
  
    
    
    
    $create_db = "CREATE DATABASE $dbname;";

    $stm = $conn->prepare($create_db);
    if (!$stm->execute()) {
      throw new Exception("Erro ao criar banco de dados ". $dbname,500);
    }
    
    $connect_db = "USE $dbname;";
  
  $stm = $conn->prepare($connect_db);
  if (!$stm->execute()) {
    throw new Exception("Erro conectar com o banco dados ",500);
  }
  
  
  // -----------------------------------------------------------------------------
  // 3. CRIAR TABELAS
  $tabela_turmas = "CREATE TABLE turmas (
  id_turma int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  nome varchar(80) DEFAULT NULL,
  curso varchar(80) DEFAULT NULL,
  docente varchar(50) DEFAULT NULL,
  turno varchar(10) DEFAULT NULL,
  semestre varchar(10) DEFAULT NULL,
  tipo_turma varchar(20) DEFAULT NULL,
  participantes_qtd int(11) DEFAULT NULL,
  reservas_cadastradas int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";


$stm = $conn->prepare($tabela_turmas);
if (!$stm->execute()) {
  throw new Exception("Erro ao criar tabela turmas",500);
}

$tabela_salas = "CREATE TABLE `salas` (
  `id_sala` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `numero_sala` int(11) NOT NULL,
  `tipo_sala` varchar(45) DEFAULT NULL,
  `lugares_qtd` int(11) DEFAULT NULL COMMENT 'capacidade das salas (lotação)',
  `maquinas_qtd` int(11) DEFAULT NULL,
  `maquinas_tipo` varchar(45) DEFAULT NULL,
  `unidade` int(11) NOT NULL,
  `descricao` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";

$stm = $conn->prepare($tabela_salas);
if (!$stm->execute()) {
  throw new Exception("Erro ao criar tabela salas",500);
}


$tabela_chaves = "CREATE TABLE `chaves`(
  `id_chave` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `id_sala` int(11) NOT NULL,
  `status` varchar(25) DEFAULT 'disponível'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";

$stm = $conn->prepare($tabela_chaves);
if (!$stm->execute()) {
  throw new Exception("Erro ao criar tabela chaves",500);
}

$tabela_chaves_reservas = "CREATE TABLE `chaves_reservas`(
  `id_chave` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `id_sala` int(11) NOT NULL,
  `status` varchar(25) DEFAULT 'disponível'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
$stm = $conn->prepare($tabela_chaves_reservas);
if (!$stm->execute()) {
  throw new Exception("Erro ao criar tabela chaves reservas",500);
}

$tabela_movimentacoes_chaves ="CREATE TABLE `movimentacoes_chaves`(
  `id_registro` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `id_chave` int(11) NOT NULL,
  `nome_responsavel` varchar(80) NOT NULL,
  `acao` varchar(25) NOT NULL,
  `data_hora` DATETIME NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";

$stm = $conn->prepare($tabela_movimentacoes_chaves);
if (!$stm->execute()) {
  throw new Exception("Erro ao criar tabela movimentacao chaves",500);
}


$tabela_reservas = "CREATE TABLE reservas (
  id_reserva int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `data` date NOT NULL,
  id_sala int(11) NOT NULL,
  id_turma int(11) NOT NULL,
  observacoes text DEFAULT NULL,
  responsavel_cadastro varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";


$stm = $conn->prepare($tabela_reservas);
if (!$stm->execute()) {
  throw new Exception("Erro ao criar tabela reservas",500);
  
}


$tabela_historico = "CREATE TABLE reservas_historico (
  id_reserva int(11) NOT NULL,
  `data` date NOT NULL,
  docente varchar(80) NOT NULL,
  participantes int(11) NOT NULL,
  id_turma int(11) NOT NULL,
  id_sala int(11) NOT NULL,
  responsavel_cadastro varchar(80) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";

$stm = $conn->prepare($tabela_historico);
if (!$stm->execute()) {
  throw new Exception("Erro ao criar tabela reservas historico",500);
}



$alter_tables = "ALTER TABLE `reservas`
  ADD KEY `id_sala` (`id_sala`),
  ADD KEY `id_turma` (`id_turma`);

  ALTER TABLE `reservas`
  ADD CONSTRAINT `reservas_ibfk_1` FOREIGN KEY (`id_sala`) REFERENCES `salas` (`id_sala`),
  ADD CONSTRAINT `reservas_ibfk_2` FOREIGN KEY (`id_turma`) REFERENCES `turmas` (`id_turma`);
  COMMIT;";

$stm = $conn->prepare($alter_tables);
if (!$stm->execute()) {
  throw new Exception("Erro ao modificar tabelas",500);
}

$procedures = "CREATE DEFINER=`root`@`localhost` PROCEDURE deletar_reservas_passadas ()   DELETE FROM reservas WHERE data < CURRENT_DATE;

CREATE DEFINER=`root`@`localhost` PROCEDURE inserir_reservas_historico ()   INSERT INTO reservas_historico (id_reserva, `data`, docente, participantes, id_turma, id_sala, responsavel_cadastro)
SELECT r.id_reserva, r.data, t.docente, t.participantes_qtd, r.id_turma, r.id_sala, r.responsavel_cadastro
FROM reservas as r
INNER JOIN turmas as t
ON r.id_turma = t.id_turma
WHERE r.data < CURRENT_DATE;";


$stm = $conn->prepare($procedures);
if (!$stm->execute()) {
  throw new Exception("Erro ao criar procedures",500);
}

// -----------------------------------------------------------------------------
// 4. Insert data

$insert_turmas = "INSERT INTO turmas ( nome, curso, docente, turno, tipo_turma, semestre, participantes_qtd) VALUES
('Desenvolvimento Interface Web','SPI','Fernando','Manhã','Graduação','2-2024',20),
('Desenvolvimento Interface Web','SPI','Fernando','Noite','Graduação','2-2024',25),
('Desenvolvimento Gráfico','PM','Roberto','Manhã','Graduação','2-2024',18),
('Desenvolvimento Gráfico','PM','Roberto','Noite','Graduação','2-2024',25),
('Algoritmos Estruturas de Dados I','ADS','Roberto','Manhã','Graduação','2-2024',27),
('Algoritmos Estruturas de Dados I','ADS','Roberto','Noite','Graduação','2-2024',22),
('Fundamentos Computacionais','ADS','Ronaldo','Manhã','Graduação','2-2024',22),
('Fundamentos Computacionais','ADS','Ronaldo','Noite','Graduação','2-2024',26);";

$stm = $conn->prepare($insert_turmas);
if (!$stm->execute()) {
  throw new Exception("Erro ao inserir dados na tabela turmas",500);
}


$insert_salas = "INSERT INTO salas (numero_sala, tipo_sala, lugares_qtd, maquinas_qtd, maquinas_tipo, unidade, descricao) VALUES
(101, 'Estúdio', 20, 20, 'Intel-i5-7',1, 'Vídeo / Foto'),
(102, 'Laboratório', 18, 30, 'Intel-i5-7',1, '18 PCs novos'),
(103, 'Laboratório', 13, 20, 'IMAC',1, '13 IMAC'),
(204, 'Sala de Aula', 30, 30, 'Ryzen-5',1, NULL),
(205, 'Sala de Aula', 30, 30, 'Ryzen-5',1, NULL),
(206, 'Sala de Aula', 40, 30, 'Ryzen-5',1, 'Desenho de Moda'),
(207, 'Sala de Aula', 20, 30, 'Ryzen-5',1, 'Modelagem de Moda - 5 Mesas e 20 lugares'),
(208, 'Laboratório', 45, 25, 'Ryzen-5',1, 'Confecção de Moda - 25 Máquinas e 25 lugares'),
(210, 'Sala de Aula', 45, 30, 'Ryzen-5',1, 'Modateca - Biblioteca da Moda'),
(301, 'Laboratório', 25, 20, 'Intel-i9-12',1, 'Sala nova'),
(302, 'Sala de Aula', 45, 30, 'Ryzen-5',1, NULL),
(303, 'Sala de Aula', 20, 30, 'Ryzen-5',1, NULL),
(304, 'Sala de Aula', 28, 30, 'Ryzen-5',1, NULL),
(305, 'Sala de Aula', 28, 30, 'Ryzen-5',1, 'Quarto de Hotel - 28 lugares (Cadeira universitária)'),
(306, 'Sala de Aula', 15, 30, 'Ryzen-5',1, NULL),
(308, 'Laboratório', 33, 19, 'Ryzen-5',1, '19 PCs novos'),
(309, 'Laboratório', 39, 19, 'Ryzen-5',1, '19 PCs novos'),
(310, 'Laboratório', 20, 20, 'Ryzen-5',1, NULL),
(311, 'Laboratório', 39, 19, 'Ryzen-5',1, 'Sala nova'),
(312, 'Laboratório', 34, 20, 'Ryzen-5',1, 'Cisco - 20 PCs novos'),
(406, 'Sala de Aula', 15, 1, 'Ryzen-5',1, NULL),
(407, 'Sala de Aula', 28, 1, 'Ryzen-5',1, NULL),
(408, 'Sala de Aula', 28, 1, 'Ryzen-5',1, NULL),
(409, 'Sala de Aula', 32, 1, 'Ryzen-5',1, NULL),
(410, 'Sala de Aula', 18, 1, 'Ryzen-5',1, NULL),
(411, 'Sala de Aula', 30, 1, 'Ryzen-5',1, NULL),
(412, 'Sala de Aula', 30, 1, 'Ryzen-5',1, NULL),
(413, 'Sala de Aula', 48, 1, 'Ryzen-5',1, NULL),
(501, 'Laboratório', 15, 13, 'Ryzen-5',1, NULL),
(502, 'Laboratório', 20, 20, 'Ryzen-5',1, 'Audaces - 20 PCs novos'),
(503, 'Laboratório', 22, 44, 'Ryzen-5',1, 'Audaces - 22 PCs novos'),
(504, 'Laboratório', 24, 28, 'Ryzen-5',1, '24 PCs novos'),
(505, 'Sala de Aula', 49, 1, 'Ryzen-5',1, NULL),
(506, 'Sala de Aula', 32, 1, 'Ryzen-5',1, NULL),
(507, 'Sala de Aula', 30, 1, 'Ryzen-5',1, NULL),
(601, 'Laboratório', 33, 34, 'Ryzen-5',1, NULL),
(602, 'Laboratório', 21, 21, 'Ryzen-5',1, NULL),
(603, 'Laboratório', 20, 25, 'Ryzen-5',1, NULL),
(604, 'Laboratório', 25, 30, 'Ryzen-5',1, NULL),
(701, 'Laboratório', 25, 40, 'Ryzen-5',1, '25 PCs novos'),
(702, 'Laboratório', 22, 27, 'Ryzen-5',1, NULL),
(703, 'Laboratório', 20, 31, 'Ryzen-5',1, NULL),
(704, 'Laboratório', 25, 29, 'Ryzen-5',1, '25 PCs novos'),
(801, 'Laboratório', 20, 31, 'Ryzen-5',1, '25 PCs novos'),
(802, 'Sala de Aula', 12, 1, 'Ryzen-5',1, NULL),
(803, 'Sala de Aula', 3, 1, 'Ryzen-5',1, NULL),
(122, 'Estúdio', 3, 1, 'Ryzen-5',1, 'Áudio'),

-- unidade 2

(201, 'Laboratório', 3, 20, 'Ryzen-5',2, NULL),
(202, 'Auditório', 70, 1, 'Ryzen-5',2, NULL),
(501, 'Laboratório', 30, 20, 'Ryzen-5',2, NULL),
(502, 'Laboratório', 30, 20, 'Ryzen-5',2, NULL),
(601, 'Sala de Aula', 50, 20, 'Ryzen-5',2, NULL),
(602, 'Sala de Aula', 50, 20, 'Ryzen-5',2, NULL),
(801, 'Sala de Aula', 50, 20, 'Ryzen-5',2, NULL),
(802, 'Sala de Aula', 50, 20, 'Ryzen-5',2, NULL),
(901, 'Sala de Aula', 50, 20, 'Ryzen-5',2, NULL),
(902, 'Sala de Aula', 50, 20, 'Ryzen-5',2, NULL),
(1001, 'Sala de Aula', 50, 20, 'Ryzen-5',2, NULL),
(1002, 'Sala de Aula', 50, 20, 'Ryzen-5',2, NULL),
(1101, 'Sala de Aula', 50, 20, 'Ryzen-5',2, NULL),
(1102, 'Sala de Aula', 50, 20, 'Ryzen-5',2, NULL),
(1201, 'Sala de Aula', 50, 20, 'Ryzen-5',2, NULL),
(1301, 'Sala de Aula', 40, 20, 'Ryzen-5',2, NULL),
(1302, 'Sala de Aula', 40, 20, 'Ryzen-5',2, NULL);";

$stm = $conn->prepare($insert_salas);
if (!$stm->execute()) {
  throw new Exception("Erro ao inserir dados na tabela salas",500);
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
$resposta["msg"] = "<p>Banco de dados criado. Ir para: <a href='inicial'>Pagina Inicial</a></p>";

} catch (Exception $e) {
  $resposta["status"] = $e->getCode();
  $resposta["msg"] = $e->getMessage();
}


exit(json_encode($resposta));
?>
