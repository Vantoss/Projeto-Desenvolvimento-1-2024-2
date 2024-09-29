<?php function activeTab($requestUri){
    $current_file_name = basename($_SERVER['REQUEST_URI'], ".php");
    if ($current_file_name == $requestUri) echo 'active'; }
    $page_title = "Pagina Inicial";
  ?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title> <?= isset($page_title) ? $page_title : "Default Title"?> </title>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- jquery -->
    <script defer src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script> 
    
    <!-- BOOTSTAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Latest compiled JavaScript -->
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" ></script>
    
    <!-- global Script -->
    <script type="text/JavaScript" src="../assets/js/main.js" defer ></script>
    
    <!-- global Style -->
    <link rel="stylesheet" href="../assets/styles/main.css">
    
    <?php if (function_exists('customPageHeader')){
        customPageHeader();
    }?>

</head>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Navbar</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">

      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item" >
          <a class="nav-link <?php activeTab("index")?>" aria-current="page" href="<?php echo ROOT_DIR ?>">Pagina Inicial</a>
        </li>
        <li class="nav-item" >
          <a class="nav-link <?php activeTab("consultar_reserva")?>" aria-current="page" href=<?php echo ROOT_DIR. 'pages/page_consultar_reserva.php'?>>Consultar Reserva</a>
        </li>
        <li class="nav-item" >
          <a class="nav-link <?php activeTab("cadastrar_reserva")?>" aria-current="page" href=<?php echo ROOT_DIR. 'pages/page_cadastrar_reserva.php'?>>Cadastrar Reserva</a>
        </li>
      </ul>
      <form class="d-flex">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form>
    </div>
  </div>
</nav>