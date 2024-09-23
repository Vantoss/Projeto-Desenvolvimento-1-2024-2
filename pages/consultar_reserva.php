<?php
    define('ROOT_DIR', '../');
    
    $page_title = 'Consultar Reserva';

    function customPageHeader(){?>
        <link rel="stylesheet" href="<?php ROOT_DIR. 'assets/styles/consultar_reserva.css'?>">

    <?php } 
    
    require_once ROOT_DIR. 'includes/layout/header.php';
    ?>

<body>
    
    <!-- BOX FILTROS  -->
    <?php 
    require_once ROOT_DIR.'includes/layout/box_filtros.php'; ?>
    
    <div class=".container-sm" id="tabela-consulta"></div>
    
</body>
</html>