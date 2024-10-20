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

    
    
    <!-- <?php
    // $datas = "'2024-03-04', '2024-03-06', '2024-03-08', '2024-03-10'";
    $datas = "'2024-04-04'";
    
    $datas = str_replace(array("'"),array(""),$datas);

    $datas = explode(",",$datas);

    
    foreach ($datas as $data) {?>
        <button id="btn-dia" class="btn btn-light"><?php echo date_format(date_create($data),"d/m/Y"); ?></button>
        
    <?php } ?> -->


        <?php
        $locale = "pt_BR";

        $fmt = datefmt_create($locale,IntlDateFormatter::FULL,IntlDateFormatter::NONE,'America/Sao_Paulo',IntlDateFormatter::GREGORIAN);

        echo datefmt_format($fmt,0);

        
// datefmt_create(
//     ?string $locale,
//     int $dateType = IntlDateFormatter::FULL,
//     int $timeType = IntlDateFormatter::FULL,
//     IntlTimeZone|DateTimeZone|string|null $timezone = null,
//     IntlCalendar|int|null $calendar = null,
//     ?string $pattern = null
// ): ?IntlDateFormatter


        




        
        ?>

</body>
</html>


