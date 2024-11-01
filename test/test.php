<?php 
    
    define('ROOT_DIR', '../');

    $pagina_titulo = 'Teste';
    
    // HEADER
    require_once ROOT_DIR. "includes/layout/header.php";
?>

    <!-- <style>#btn-dia{
        font-weight: bold;
        color: #0d6efd;
    } </style> -->
<body>


  <?php
    $selectSQL = "SELECT DISTINCT id_turma FROM reservas WHERE";

    $sql = [];

    $sql[] = " DATE(data) BETWEEN '2024-11-01' AND '2024-11-08'";
    // $sql[] = " DATE(data) BETWEEN '2024-11-15' AND '2024-11-22'";

    $selectSQL .= implode(" OR ", $sql);

    echo $selectSQL;

  // $gap = date_diff(date_create('2024-11-01'),date_create('2024-11-09'));
  // echo (int)($gap->format("%a"));
  ?>

    <!-- <h1>Pagina teste</h1>

    
    
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
</div> -->

        


        


</body>
</html>


