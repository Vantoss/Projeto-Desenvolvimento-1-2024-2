
<form method="post" id="form-editar-turma">
    <input type="hidden" name="id-turma" id="inp-editar-turma-id" value="">

    <div class="input-group-turma">
        <!-- INPUT NOME TURMA -->
        <div class="input-group">
            <span class="input-group-text" >Nome</span>
            <input type="text" class="form-control inp-turma-dados" id="inp-editar-turma-nome" placeholder="Nome" name="nome" value="" >
        </div>
        <!-- INPUT DOCENTE -->
        <div class="input-group">
            <span class="input-group-text" >Curso</span>
            <input type="text" class="form-control inp-turma-dados" id="inp-editar-turma-docente"  placeholder="Docente" name="docente" value="" >
        </div>
        <!-- INPUT CURSO -->
        <div class="input-group">
            <span class="input-group-text" >Docente</span>
            <input type="text" class="form-control inp-turma-dados" id="inp-editar-turma-curso" placeholder="Curso" name="curso" value="" >
        </div>
    <!-- INPUT SEMESTRE -->
    <div class="input-group">
        <span class="input-group-text" >Semestre</span>
        <input type="text" class="form-control inp-turma-dados" id="inp-editar-turma-semestre" placeholder="Semestre" name="semestre" value="">
    </div>
    <!-- INPUT PARTICIPANTES -->
    <div class="input-group">
        <span class="input-group-text">Participantes</span>
        <input type="number" class="form-control inp-turma-dados" id="inp-editar-turma-participantes" placeholder="Participantes" name="participantes" min="1" value="" >
    </div>

    <div class="btn-group" role="group" >
        <button type="submit" class='btn btn-sm btn-outline-primary btn-turma-dados'>Editar</button>
        <button type='button' class='btn btn-sm btn-outline-danger btn-turma-dados' id="btn-deletar-turma" value="">Deletar</button>
    </div>
</div>
    
</form>