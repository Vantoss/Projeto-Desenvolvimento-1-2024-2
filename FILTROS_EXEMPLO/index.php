<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- jquery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js" ></script> 

    <!-- BOOTSTAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Latest compiled JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" ></script>

    <!-- My Script -->
    <script src="myScript.js" defer type="text/JavaScript"></script>
    
    <!-- My Style -->
    <link rel="stylesheet" href="style.css">

    <style>
        
    </style>
    <title>Filtros Exemplo</title>
</head>
<body>

    <div id="">

    </div>

    <div id="filtros">
    
        <div class="filtro">
            <label for="diciplina">Diciplina</label>
            <input type="text" name="diciplina" id="diciplina">
        </div>
        <div class="filtro">
            <label for="docente">Docente</label>
            <input type="text" name="docente" id="docente">
        </div>

        <div class="filtro">
            <label for="data-inicio">De data</label>
            <input type="date" name="data-inicio" id="data-inicio" >
        </div>
    
        <div class="filtro">
            <label>Ate data</label>
            <input type="date" name="data-fim" id="data-fim" >
        </div>

        <div class="filtro">
            <label for="sala">Sala</label>
            <input type="number" id="sala" name="sala"  placeholder="Todas" >
        </div>

        <div class="filtro">
            <label for="turno">Turno</label>
            <select name="turno" id="turno">
                <option value="" selected="">Todos</option>
                <option value="Manhã">Manhã</option>
                <option value="Tarde">Tarde</option>
                <option value="Noite">Noite</option>
            </select>
        </div>

        <div class="filtro">
            <label for="registros">Registros</label>
            <input type="number" id="registros" name="registros" min="1" placeholder="Todos" >
        </div>
        
        <div class="filtro">
            <label for="maquinas-qtd">Quantidade de Máquinas</label>
            <input type="number" id="maquinas-qtd" name="maquinas-qtd" placeholder="Qualquer" >
        </div>

        <button id="buscar" type="submit">buscar</button>
     </div>   
    <div class="container">

        
    </div>
    
</body>
</html>