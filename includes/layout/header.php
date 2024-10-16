<?php 
  if(session_status() !== PHP_SESSION_ACTIVE) session_start();
  require_once ROOT_DIR. 'includes/functions.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title> <?php echo isset($pagina_titulo) ? $pagina_titulo : "Default Title"; ?> </title>  
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- jquery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script> 
    
    <!-- BOOTSTAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Latest compiled JavaScript -->
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" ></script>

    
    <!-- global Script -->
    <script type="text/JavaScript" src="<?php echo ROOT_DIR. 'assets/js/main.js'?>" defer ></script>
    
    <!-- global Style -->
    <link rel="stylesheet" href="<?php echo ROOT_DIR. 'assets/styles/main.css'?>" > 
    
    <?php customPageHeader($pagina_titulo);?>

</head>


<?php 
$paginas_setup = ["Error","Install"];

if(!in_array($pagina_titulo ,$paginas_setup)){
    require_once ROOT_DIR. "includes/components/navbars/navbar_header.php";
} ?>