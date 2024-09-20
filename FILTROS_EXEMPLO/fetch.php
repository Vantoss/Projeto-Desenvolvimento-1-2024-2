<?php 
    require_once "config.php";

    $query = "SELECT * FROM salas"; // pesquisa sem os filtros 

    if (isset($_POST["filtros"]) ){ // roda caso a array filtros existir
        
        $filtros = $_POST["filtros"]; 
        $i = 0;
        foreach ($filtros as $filtro => $valor) {
           
            if (!empty($valor)) { //roda caso existir um valor associado ao filtro da iteracao
                
                $query .= $i > 0 ? " AND " : " WHERE "; // versao curta do if e else // concatena " AND " caso " WHERE " ja estiver na pesquisa ($query)
               
                // caso o fitro seja de capacidade, o operador de comparacao sera o " >= " caso contrario sera o " = "
                $query .= $filtro == "capacidade" ? "$filtro >= '$valor'"  :"$filtro = '$valor'"; 

                $i++; // conta a quantidade de iteracoes a fim de determinar se o " WHERE " ja esta na pesquisa
            }
            
        }

        echo  $query . "<hr>"; // mostra a pesquisa para fins de teste 

        }

        mysql: $result = mysqli_query($conn,$query); // gera a pesquisa no banco de dados
        $count = mysqli_num_rows($result);
    
?>

<table class="table">

    <?php
    if ($count){?>

    <thead>
            <tr>
                <th scope="col">id</th>
                <th scope="col">sala</th>
                <th scope="col">tipo</th>
                <th scope="col">capacidade</th>
            </tr>

        <?php } else {
            echo "Nenhum resultado encontrado";
        }
        ?>
    </thead>
    <tbody>
        <?php 
        while ($row = mysqli_fetch_assoc($result)){?>
            <tr>
                <td><?php echo $row["id"]; ?></td>
                <td><?php echo $row["sala"]; ?></td>
                <td><?php echo $row["tipo"]; ?></td>
                <td><?php echo $row["capacidade"]; ?></td> 
            </tr>
            <?php }?>

    </tbody>
</table>
            