<table class="table table-striped tabela-consulta">
    <?php

    // roda caso exista registros na pesquisa
    if ($arr){?>
        

            <button id="data-tag" class="btn btn-primary"><?php echo $_POST["turno"];?></button>
            <?php foreach ($datas as $data) {?>
                <button id="data-tag" class="btn btn-primary ">
                    <?php echo date_format(date_create($data),"d/m/Y"); ?>
                    
                </button>
                
                <?php } ?>   
        
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
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editar-reserva-modal">Reservar</button>   
                </td> 
            </tr>
            <?php }?>
        </tbody>
    </table>