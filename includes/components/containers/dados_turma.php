

<form method="post" id="form-editar-turma">


    <input type="hidden" name="id_turma" id="inp-editar-turma-id" value="<?php echo $turma["id_turma"] ?>">
    <!-- INPUT NOME TURMA -->
    <div class="input-group">
        <span class="input-group-text" >Nome</span>
        <input type="text" class="form-control"  placeholder="Turma" name="nome" value="<?php echo $turma["nome"] ?>">
    </div>
    <!-- INPUT DOCENTE -->
    <div class="input-group">
        <span class="input-group-text" >Curso</span>
        <input type="text" class="form-control"  placeholder="Docente" name="docente" value="<?php echo $turma["curso"] ?>">
    </div>
    <!-- INPUT CURSO -->
    <div class="input-group">
        <span class="input-group-text" >Docente</span>
        <input type="text" class="form-control" placeholder="Curso" name="curso" value="<?php echo $turma["docente"] ?>">
    </div>
    <!-- INPUT SEMESTRE -->
    <div class="input-group">
        <span class="input-group-text" >Semestre</span>
        <input type="text" class="form-control" placeholder="Semestre" name="semestre" value="<?php echo $turma["semestre"] ?>">
    </div>
    <!-- INPUT PARTICIPANTES -->
    <div class="input-group">
        <span class="input-group-text">Participantes</span>
        <input type="number" class="form-control" name="participantes" min="1" value="<?php echo $turma['participantes_qtd']?>" >
    </div>

</form>

<div >
    <button type="submit" form="form-editar-turma" class='btn btn-sm btn-primary '>Editar</button>
    <button type='button' class='btn btn-sm btn-danger btn-deletar-turma' value="<?php echo $turma["id_turma"] ?>">Deletar</button>
</div>
   