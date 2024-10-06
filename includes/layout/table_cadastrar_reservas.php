<?php

    // roda caso exista registros na pesquisa
if ($arr){

    require_once ROOT_DIR. 'includes/components/modals/modal_cadastrar_reserva.php';
    
    ?>

<table class="table table-striped tabela-consulta">

    <button id="data-tag" class="btn btn-primary btn-sm"><?php echo $_GET["reserva_tipo"];?></button>
            <button id="data-tag" class="btn btn-primary btn-sm"><?php echo $_GET["turno"];?></button>
            <?php foreach ($datas as $data) {?>
                <button id="data-tag" class="btn btn-primary btn-sm ">
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
        echo "<span>Nenhum resultado encontrado</span>";
    }
    ?>
    </thead>
    <tbody>
        <?php 
        foreach ($arr as $_ => $row){?>
            <tr>
                <td><?php echo $row["sala"]?></td>
                <td><?php echo $row["sala_tipo"]?></td>
                <td><?php echo $row["lugares"]?></td>
                <td><?php echo $row["maquinas_qtd"]?></td>
                <td><?php echo $row["maquinas_tipo"]?></td>
                <td>
                    <button type="button" id="btn-reservar" class="btn btn-primary" data-bs-toggle="modal" value="<?php echo $row["sala"]?>" data-bs-target="#cadastrar-reserva-modal">Reservar</button>   
                </td> 
            </tr>
            <?php }?>
        </tbody>
    </table>