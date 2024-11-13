<form method="post" id="form-editar-turma" >
    <input type="hidden" name="id_turma" id="inp-editar-turma-id" value="">
    <div class="div-cadastrar-turma">
    <div class="row text-center">
        <!-- INPUT TURMA -->
        <div class="col">
        
        <div class="form-floating ">
            <input type="text" class="form-control inp-editar-turma form-control-sm" id="inp-turma" placeholder="Turma" name="nome" autocomplete="off" value="<?php echo $turma["nome"]?>" >
            <label for="inp-turma" class="form-label">Turma</label>
        </div>
        
        <!-- INPUT DOCENTE -->
        <div class="form-floating ">
            <input type="text" class="form-control inp-editar-turma form-control-sm" id="inp-docente" placeholder="Docente" name="docente" autocomplete="off" value="<?php echo  $turma["docente"]?>" >
            <label for="inp-docente" class="form-label">Docente</label>
        </div>
        
        <!-- INPUT CURSO -->
        <div class="form-floating ">
            <input type="text" class="form-control inp-editar-turma form-control-sm" id="inp-curso" placeholder="Curso" name="curso" autocomplete="off" value="<?php echo  $turma["curso"]?>">
            <label for="inp-curso" class="form-label">Curso</label>
        </div>
        
        <!-- INPUT CODIGO TURMA -->
        <div class="form-floating ">
            <input type="text" class="form-control inp-editar-turma form-control-sm" id="inp-codigo" placeholder="Codigo" name="codigo" autocomplete="off" value="<?php echo  $turma["codigo"]?>" >
            <label for="inp-codigo" class="form-label">Código</label>
        </div>
        
        <!-- INPUT QUANTIDADE PARTICIPANTES -->
        <div class="form-floating ">
            <input type="number" class="form-control inp-editar-turma form-control-sm" id="inp-participantes" placeholder="N.&#xba; de participantes" name="participantes" min="1" value="<?php echo $turma["participantes_qtd"]?>" required>
            <label for="inp-participantes" class="form-label">N.&#xba; de participantes</label>
        </div>
        </div>
    </div>
    </div>
</form>