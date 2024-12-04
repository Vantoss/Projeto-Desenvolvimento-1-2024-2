<?php 
    
    define('__DIR__', '../');

    $pagina_titulo = 'Teste';
    
    // HEADER
    // require_once __DIR__. "includes/layout/header.php";
?>

    <!-- <style>#btn-dia{
        font-weight: bold;
        color: #0d6efd;
    } </style> -->
<body>


  <?php
    
    // $nextTuesday = strtotime('next tuesday');
    // // $weekNo = date('W');
    // $weekNoNextTuesday = date('W', $nextTuesday);

    // echo $weekNoNextTuesday;

    // Create a new DateTime object
    $data_inicial = new DateTime();
    $sql = "data in (";

    $fim_semanda = array('6','0');

    // echo $data_inicial->format("w - l");
    // $data_inicial->modify("+1 day");
    // echo $data_inicial->format("w");
    

    var_dump($data_inicial->format("w"));
    $num = 20;

    $i = 0;
    while ($i < $num) {
      if(!in_array($data_inicial->format('w'),$fim_semanda)){
        $sql .= $data_inicial->format('Y-m-d - l  (w)');
        $i++;
        $sql .= $i < $num ? ", " : ")";
      }
      $data_inicial->modify("+1 day");
    }
    echo $sql;
    



// Modify the date it contains





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


