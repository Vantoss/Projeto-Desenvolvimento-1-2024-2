<?php
define('ROOT_DIR', '../');
// require_once(ROOT_DIR.'includes/functions.php');

$pagina_titulo = 'Error';

require_once ROOT_DIR. 'includes/layout/header.php';
?> 

<?php
$pErrorMsg = $_SESSION['err'];
if ($pErrorMsg) {
  $errorMessage =  $pErrorMsg['date'].' - '.$pErrorMsg['message'];
}
else {
  $errorMessage = 'Unknown error. <a href="https://github.com/David-Amrani-Hernandez/fith/issues/new" target="_blank">Open issue on github.</a>';
}
?>
<html>
<body>
  
  <h2>Error</h2>
  <p class="alert alert-danger"><?php echo $errorMessage ?></p>
  
</body>
  </html>

