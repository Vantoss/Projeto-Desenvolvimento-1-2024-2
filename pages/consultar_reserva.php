<?php
    define('ROOT_DIR', '../');
    
    $page_title = 'Consultar Reserva';
    
    // HEADER
    require_once ROOT_DIR. 'includes/layout/header.php';

    function customPageHeader(){?>
        <!-- CSS DA PAGINA -->
        <link rel="stylesheet" href="<?php echo ROOT_DIR. 'assets/styles/consultar_reserva.css'?>">
    <?php } ?>

<body>
    
    
    <?php
    // BOX FILTROS 
    require_once ROOT_DIR.'includes/components/containers/filtros_consultar_reserva.php';
    
    // MODAL EDITAR RESERVA
    require_once ROOT_DIR.'includes/components/modals/modal_editar_reserva.php';

    // MODAL DELETAR RESERVA
    require_once ROOT_DIR.'includes/components/modals/modal_deletar_reserva.php'; 
    ?>

    
    
    <div class=".container" id="container-tabela"></div>
    
</body>
</html>