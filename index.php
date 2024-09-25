<?php 
    define('ROOT_DIR', '');

    $page_title = "Pagina inicial";
    require_once ROOT_DIR. 'includes/layout/header.php';
?>
<body>

    <h1>Pagina inical</h1>


<?php
$startdate=strtotime("2024-03-04");
$enddate=strtotime("+2024-04-04", $startdate);

$days = "";



while ($startdate < $enddate) {
   $days .=  date("'Y-m-d',", $startdate);

  
$startdate = strtotime("+2 days", $startdate);
}

$days .= ")";
$days = str_replace(",)","",$days);

// IN ('Germany', 'France', 'UK')

echo $days;

// echo $query = "SELECT * FROM salas WHERE salas.id_sala NOT IN (SELECT salas.id_sala FROM salas INNER JOIN reservas on salas.id_sala = reservas.id_sala WHERE DATE(data) IN ($days))";
$date1=date_create("2013-03-15");
$date2=date_create("2013-12-12");
$diff=date_diff($date1,$date2);
echo "<hr>" . $diff->format("%a -  days");
?>

</body>
</html>