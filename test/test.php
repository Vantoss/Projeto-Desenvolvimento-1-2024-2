<?php 
    
    define('ROOT_DIR', '../');

    $pagina_titulo = 'Teste';
    
    // HEADER
    require_once ROOT_DIR. "includes/layout/header.php";
?>

    <style>#btn-dia{
        font-weight: bold;
        color: #0d6efd;
    } </style>
<body>

    <h1>Pagina teste</h1>

    
    
    <p class="d-inline-flex gap-1">
  <a class="btn btn-primary" role="button" aria-expanded="false" >
    Link with href
  </a>
  <button class="btn btn-primary" type="button" aria-expanded="false" >
    Button with data-bs-target
  </button>
</p>
<div class="collapse" style="min-height: 20px;" id="collapseExample">
    Some placeholder content for the collapse component. This panel is hidden by default but revealed when the user activates the relevant trigger.<br>
    Some placeholder content for the collapse component. This panel is hidden by default but revealed when the user activates the relevant trigger.<br>
    Some placeholder content for the collapse component. This panel is hidden by default but revealed when the user activates the relevant trigger.<br>
    Some placeholder content for the collapse component. This panel is hidden by default but revealed when the user activates the relevant trigger.<br>
</div>

        


        


</body>
</html>


