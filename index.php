<?php
    // CAMINHO RELATIVO DA PAGINA
    define('ROOT_DIR', '');

    $pagina_titulo = "Pagina inicial";

    // HEADER
    require_once ROOT_DIR. 'includes/layout/header.php';
    gerarHistorico($conn)
?>
<body>

    <h1>Pagina inicial</h1>

</body>

</html>