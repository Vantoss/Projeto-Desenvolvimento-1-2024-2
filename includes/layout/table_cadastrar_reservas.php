
<?php

echo "<h4>Turno: " . $_POST["turno"] . "</h4>";        
?>
<table class="table table-striped tabela-consulta">
    <?php

    // roda caso exista registros na pesquisa
    if ($arr){
     

?> 
    
<thead>
    <tr>
        <th scope="col">Sala</th>
        <th scope="col">Tipo</th>
        <th scope="col">N.&#xba; lugares</th>
        <th scope="col">N.&#xba; maquinas</th>
        <th scope="col">Maquinas tipo</th>
        <th scope="col">Ação</th>
        
    </tr>
    
    <?php } else { // roda caso nao exista registros na pesquisa
        echo "Nenhum resultado encontrado";
    }
    ?>
    </thead>
    <tbody>
        <?php 
        foreach ($arr as $_ => $row){?>
            <tr>
                <td><?php echo $row["sala"]?></td>
                <td><?php echo $row["sala-tipo"]?></td>
                <td><?php echo $row["lugares"]?></td>
                <td><?php echo $row["maquinas-qtd"]?></td>
                <td><?php echo $row["maquinas-tipo"]?></td>
                <td>
                    <button type="button" class="btn btn-success " data-bs-toggle="modal" data-bs-target="#editar-reserva-modal">Reservar</button>   
                </td> 
            </tr>
            <?php }?>
        </tbody>
    </table>