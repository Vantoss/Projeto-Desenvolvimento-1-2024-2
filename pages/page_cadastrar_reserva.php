<?php
    // CAMINHO RELATIVO DA PAGINA
    define('ROOT_DIR', '../');

    $pagina_titulo = 'Cadastrar Reserva';

    // HEADER
    require_once ROOT_DIR. "includes/layout/header.php";

?>
<body>

    
<?php 
    // BOX FILTROS CADASTRAR RESERVA
    require_once ROOT_DIR.'includes/components/forms/form_consultar_salas_disponiveis.php';

    require_once ROOT_DIR. 'includes/components/modals/modal_cadastrar_reserva.php';

    // MODAL ALERTA 
    require_once ROOT_DIR.'includes/components/modals/modal_alerta.php';
?>
    <div class="container-fluid" id="container-tabela"></div>
    
    
</body>
</html>