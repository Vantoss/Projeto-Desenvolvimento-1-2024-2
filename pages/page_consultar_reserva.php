<?php
    define('ROOT_DIR', '../');
    
    $page_title = 'Consultar Reserva';
    
    // HEADER
    require_once ROOT_DIR. 'includes/layout/header.php';

    function customPageHeader(){?>
        <!-- CSS DA PAGINA -->
        <link rel="stylesheet" href="<?php echo ROOT_DIR. 'assets/styles/consultar_reserva.css'?>">
        <!-- JS DA PAGINA -->
         <script src="<?php echo ROOT_DIR. 'assets/js/consultar_reservas.js' ?>" defer ></script>
    <?php } ?>

<body>
    
    <?php
    // BOX FILTROS (FORM) BUSCAR RESERVA
    require_once ROOT_DIR.'includes/components/forms/form_consultar_reservas.php';
    
    // MODAIS EDITAR E DELETAR RESERVA
    require_once ROOT_DIR.'includes/components/modals/modal_consultar_reservas.php';
 
    ?>

    
    
    <div class="container-fluid" id="container-tabela"></div>
    
</body>
</html>