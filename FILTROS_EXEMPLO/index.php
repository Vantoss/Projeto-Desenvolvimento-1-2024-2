<?php
 require_once "config.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- jquery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js" ></script> 

    <!-- BOOTSTAP -->
    <!-- Latest compiled and minified CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Latest compiled JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" ></script>

    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js" ></script> -->

    
    <script defer type="text/JavaScript">

        // JQUERY   
        $(Document).ready(function(){
                $("#buscar").on('click',function(){ // executa codigo abaixo com o click do botao "buscar"
                    var filtros = { // define uma array associativa com os nomes dos filtros e seus valores que podem existir ou nao
                        "tipo": $("#sala-tipo").val(),
                        "capacidade" : $("#capacidade").val()
                    }

                    $.ajax({ // envia a array filtros na forma de $_POST para o fetch.php
                        url:"fetch.php",
                        type:"POST",
                        data: {filtros: filtros},
                        beforeSend:function(){
                            $(".container").html("<span>Procurando...</span>");
                        },
                        success:function(data){
                            $(".container").html(data); // em caso de sucesso os dados sao carregados no container
                        }
                    });
                });
            });

    </script>

    <style>
        body{
            margin: 0;
            padding: 0;

        }
        #filtros{
            margin-left: 10%;
            margin-top: 2%;
            margin-bottom: 2%;
        }
    </style>
    <title>Filtros Exemplo</title>
</head>
<body>

    <div id="filtros">
        <label for="">Tipo de Sala</label>

        <select name="sala-tipo" id="sala-tipo">
            <option value="" selected="">Todos</option>
            <option value="laboratorio">Laboratiorio</option>
            <option value="cozinha">Cozinha</option>
            <option value="auditorio">auditorio</option>
        </select>

        <label for="capacidade">Capacidade</label>
        <input type="number" id="capacidade" name="capacidade" placeholder="Qualquer" >
    </div>
        <button id="buscar" type="submit">buscar</button>
    <div class="container">

        <!-- tabela e pesquisa predefinidas para fins de teste -->
        <!-- <table class="table">
            <thead>
                <tr>
                    <th scope="col">id</th>
                    <th scope="col">sala</th>
                    <th scope="col">tipo</th>
                    <th scope="col">capacidade</th>
                </tr>
                <tbody>
                    <?php

                
                        $query = "SELECT * FROM salas";
                        $result = mysqli_query($conn, $query);
                        while($row = mysqli_fetch_assoc($result)){?>
                            <tr>
                                <td><?php echo $row["id"]; ?></td>
                                <td><?php echo $row["sala"]; ?></td>
                                <td><?php echo $row["tipo"];?></td>
                                <td><?php echo $row["capacidade"]; ?></td> 
                            </tr>
                    <?php }?>
                </tbody>
            </thead>
        </table> -->
    </div>
    
</body>
</html>