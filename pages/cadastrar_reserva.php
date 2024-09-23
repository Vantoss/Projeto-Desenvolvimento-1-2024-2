<?php
    define('ROOT_DIR', '../');

    $page_title = 'Cadastrar Reserva';

    function customPageHeader(){?>
        <link rel="stylesheet" href="<?php ROOT_DIR. 'assets/styles/cadastrar_reserva.css'?>">

    <?php } 
    
    require_once ROOT_DIR. "includes/layout/header.php";
    
    ?>
 
<body>
    
    <?php require_once ROOT_DIR.'includes/layout/box_filtros.php'; ?>        
    <div class="container" id="cadastrar-reserva-tabela"></div>
    
</body>
</html>