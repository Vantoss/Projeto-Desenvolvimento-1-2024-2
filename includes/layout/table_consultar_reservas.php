<table class="table table-striped tabela-consulta">
    <?php
    // roda caso exista registros na pesquisa
    if ($arr){?> 

    <thead>
        <tr>
            <th scope="col">Id</th>
            <th scope="col">Sala</th>
            <th scope="col">Data</th>
            <th scope="col">Turno</th>
            <th scope="col">Tipo de reserva</th>
            <th scope="col">Turma</th>
            <th scope="col">Docente</th>
            <th scope="col">Lotação</th>
            <th scope="col">Ação</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $pag = isset($_GET["pagina"])? $_GET["pagina"] : 1;
        // $pag = 1; // pagina atual
        $reg_qtd = count($arr); // quantidade total de registros
        $reg_pag = 20; //quantidade de registros por pagina
        $end = $reg_pag * $pag; // ultimo registro da pagina
        $i = $end - $reg_pag; // primeiro registro da pagina 
        $pages = ceil($reg_qtd / $reg_pag); // quantidade de paginas  

        for ($i; $i < $end; $i++){
            if ($i == $reg_qtd){
                break;
            }
            ?>
            <tr id="<?php echo "id" . $arr[$i]["id_reserva"]; ?>">
                <td><?php echo $arr[$i]['id_reserva']; ?></td> 
                <td><?php echo $arr[$i]["sala"] . " - " . $arr[$i]["sala_tipo"]; ?></td>
                <td>
                    <!-- converte a data de formato Y-m-d para "dia da semana" - d/m/Y -->
                    <?php echo date_format(date_create($arr[$i]["data"])," l - d/m/Y");?>
                </td>
                <td><?php echo $arr[$i]["turno"]; ?></td> 
                <td><?php echo $arr[$i]["reserva"]; ?></td>
                <td><?php echo $arr[$i]["turma"]; ?></td>
                <td><?php echo $arr[$i]["docente"]; ?></td> 
                <td><?php echo $arr[$i]["lugares"]; ?></td>
                <td>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                        <button type="button" class="btn-editar-reserva btn btn-primary" data-bs-toggle="modal" value="<?php echo $arr[$i]['id_reserva']?>" data-bs-target="#editar-reserva-modal">Editar</button>
                        <button type="button" class="btn-deletar-reserva btn btn-danger" data-bs-toggle="modal" value="<?php echo $arr[$i]['id_reserva']?>" data-bs-target="#deletar-reserva-modal">Deletar</button>
                    </div>
                </td> 
            </tr>
            <?php }?>
        </tbody>
</table>
        
    <nav aria-label="...">
        <ul class="pagination pagination-sm">
            <?php 
            for ($e = 1; $e < $pages + 1; $e++) { 
                if($e == $pag){?>
                    <li class="page-item active" aria-current="page"><span class="page-link"><?php echo $e;?></span></li>
                <?php 
                } else { ?>
                    <li class="page-item pagina" type="button" value="<?php echo $e?>">
                        <a class="page-link" ><?php echo $e;?></a>
                    </li>
          <?php }
            } ?>
        </ul>
    </nav>
        
    <?php } else { // roda caso nao exista registros na pesquisa
        echo "<span>Nenhum resultado encontrado</span>";
    }
    ?>
    