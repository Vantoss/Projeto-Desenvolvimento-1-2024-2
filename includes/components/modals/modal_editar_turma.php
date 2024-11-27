<div class="modal fade" id="modal-editar-turma" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal">
    <div class="modal-content">
      <div class="modal-header" id="modal-header-editar">
        <h1 class="modal-title fs-5">Editar turma</h1> 
      </div>
      <div class="modal-body">
        <form method="post" id="form-editar-turma">
          
          <input type="hidden" name="id_turma" id="inp-editar-turma-id" value="">
          <div class="div-cadastrar-turma">
            <div class="row text-center">
              <!-- INPUT TURMA -->
              <div class="col">
                <div class="form-floating ">
                  <input type="text" class="form-control inp-editar-turma" id="inp-turma" placeholder="Turma" name="nome" autocomplete="off" >
                  <label for="inp-turma" class="form-label">Turma</label>
                </div>
                
                <!-- INPUT DOCENTE -->
                <div class="form-floating ">
                  <input type="text" class="form-control inp-editar-turma" id="inp-docente" placeholder="Docente" name="docente" autocomplete="off" >
                  <label for="inp-docente" class="form-label">Docente</label>
                </div>
                
                <!-- INPUT CURSO -->
                <div class="form-floating ">
                  <input type="text" class="form-control inp-editar-turma" id="inp-curso" placeholder="Curso" name="curso" autocomplete="off" >
                  <label for="inp-curso" class="form-label">Curso</label>
                </div>

                <!-- INPUT SEMESTRE -->
                <div class="form-floating ">
                    <input type="text" class="form-control inp-editar-turma form-control-sm" id="inp-semestre" placeholder="Semestre" name="semestre" autocomplete="off" >
                    <label for="inp-semestre" class="form-label">Semestre</label>
                </div>

                <!-- INPUT QUANTIDADE PARTICIPANTES -->
                <div class="form-floating ">
                  <input type="number" class="form-control inp-editar-turma" id="inp-participantes" placeholder="N.&#xba; de participantes" name="participantes" min="1" >
                  <label for="inp-participantes" class="form-label">N.&#xba; de participantes</label>
                </div>
                
              </div>
            </div>
          </div>
        </form>

        
      </div>
      
      <div class="modal-footer">
          <button type="submit" form="form-editar-turma" id="btn-salvar-editar" class="btn btn-primary">Salvar</button>
          <button type="reset" class="btn btn-secondary" data-bs-target=".modal-principal" data-bs-toggle="modal">Cancelar</button>
      </div>
      
      </div>
    </div>
</div>


