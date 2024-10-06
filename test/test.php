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


        $conn = initDB();

        $select = "SELECT id_sala, tipo_sala FROM  salas";

        $stm = $conn->prepare($select);

        $stm->execute();

        $arr = $stm->fetchAll(PDO::FETCH_ASSOC);

        $reg_qtd = $stm->rowCount();


        $reg_pag = 20;

        $pag = 4; 

        $end = $reg_pag * $pag;
        
        $i = $end - $reg_pag;

        $pages = ceil($reg_qtd / $reg_pag);
        
        for ($i; $i < $end; $i++) { 
            
            if ($i == $reg_qtd){
                break;
            }
                echo $arr[$i]["id_sala"] . "<br>";

        }

        echo $pag . "<hr>";

        echo $pages . "<br>";
        for ($e = 1; $e < $pages + 1; $e++) { 
            echo $e . " ";
        }




        
        ?>

</body>
</html>


