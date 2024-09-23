<?php 
    define('ROOT_DIR', '');

    $page_title = "Pagina inicial";
    require_once ROOT_DIR. 'includes/layout/header.php';
?>
<body>

<?php echo basename($_SERVER['REQUEST_URI'], ".php");?>
    <h1>Pagina inical</h1>
</body>
</html>