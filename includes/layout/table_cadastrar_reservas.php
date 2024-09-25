<table class="table table-striped tabela-consulta">
    <?php
    // roda caso exista registros na pesquisa
    if ($arr){?> 

<thead>
    <tr>
        <th scope="col">Sala</th>
        <th scope="col">Data</th>
        <th scope="col">Tipo de reserva</th>
        <th scope="col">Disciplina</th>
        <th scope="col">Docente</th>
        <th scope="col">Turno</th>
        <th scope="col">Lotação</th>
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
                <td><?php echo $row["sala"] . " - " . $row["sala-tipo"]; ?></td>
                <td>
                    <!-- converte a data de formato Y-m-d para "dia da semana" - d/m/Y -->
                    <?php echo date_format(date_create($row["data"])," l - d/m/Y");?>
                </td>
                <td><?php echo $row["reserva"]; ?></td>
                <td><?php echo $row["diciplina"]; ?></td>
                <td><?php echo $row["docente"]; ?></td> 
                <td><?php echo $row["turno"]; ?></td> 
                <td><?php echo $row["lotacao"]; ?></td>
                <td>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editar-reserva-modal">Editar</button>
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deletar-reserva-modal">Deletar</button>
                </td> 
            </tr>
            <?php }?>
        </tbody>
    </table>