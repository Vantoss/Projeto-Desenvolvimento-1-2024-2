<?php
    define('ROOT_DIR', '../');

    $page_title = 'Cadastrar Reserva';
    
    // HEADER
    require_once ROOT_DIR. "includes/layout/header.php";

    function customPageHeader(){?>
        <!-- CSS DA PAGINA -->
        <link rel="stylesheet" href="<?php echo ROOT_DIR. "assets/styles/cadastrar_reserva.css"?>">
        <!-- JS DA PAGINA -->
        <script src="../assets/js/cadastrar_reservas.js" defer></script>
    <?php } ?>
 
<body>
    
    <?php 
    // BOX FILTROS CADASTRAR RESERVA
    require_once ROOT_DIR.'includes/components/forms/form_consultar_salas_disponiveis.php';

    // MODAL CADASTRAR RESERVA
    // require_once ROOT_DIR.'includes/components/modals/modal_cadastrar_reserva.php';



    ?>


    <div class="container-fluid" id="container-tabela"></div>
    
    
    
</body>
</html>