<?php
    define('ROOT_DIR', '../');

    $page_title = 'Cadastrar Reserva';
    
    // HEADER
    require_once ROOT_DIR. "includes/layout/header.php";

    function customPageHeader(){?>
        <!-- CSS DA PAGINA -->
        <link rel="stylesheet" href="<?php echo ROOT_DIR. 'assets/styles/cadastrar_reserva.css'?>">
    <?php } ?>
 
<body>
    <!-- BOX FILTROS -->
    <?php require_once ROOT_DIR.'includes/components/containers/filtros_cadastrar_reserva.php'; ?>
    
    
    <div class="container" id="cadastrar-reserva-tabela"></div>
    
</body>
</html>