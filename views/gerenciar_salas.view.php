<?php
    // HEADER
    require_once ROOT_DIR. "views/partials/head.php";
    require_once ROOT_DIR. "views/partials/navbar.php";
?>
<body> 
    
<?php
    //MODAL EDITAR SALA
    require_once ROOT_DIR.'views/partials/modals/modal_editar_sala.php';

    // MODAL CADASTRAR SALA
    require_once ROOT_DIR.'views/partials/modals/modal_cadastrar_sala.php';

    // MODAL CADASTRAR SALA
    require_once ROOT_DIR.'views/partials/modals/modal_alerta.php'; 
?>

<h1 class="text-center m-5">Gerenciar Salas</h1>
<div class="container-fluid " id="container-tabela"></div>
    
</body>
</html>