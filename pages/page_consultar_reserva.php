<?php
    // CAMINHO RELATIVO DA PAGINA
    define('ROOT_DIR', '../');

    $pagina_titulo = 'Consultar Reserva';

    // HEADER
    require_once ROOT_DIR. 'includes/layout/header.php';
?>
        
<body>
    
<?php
    // BOX FILTROS (FORM) BUSCAR RESERVA
    require_once ROOT_DIR.'includes/components/forms/form_consultar_reservas.php';
    
    // MODAIS DELETAR RESERVA
    require_once ROOT_DIR.'includes/components/modals/modal_deletar_reserva.php';
    
    // MODAL EDITAR RESERVA
    require_once ROOT_DIR.'includes/components/modals/modal_editar_reserva.php';

    // MODAL ALERTA 
    require_once ROOT_DIR.'includes/components/modals/modal_alerta.php';
?>

    <div class="container-fluid" id="container-tabela"></div>
    
</body>
</html>