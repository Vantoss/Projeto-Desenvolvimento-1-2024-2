<div class="modal fade" id="cadastrar-reserva-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header" id="modal-header-cadastrar">

      </div>
      
      <div class="modal-body">
        
        <div id="sala-dados">
        </div>
        <form method="post" id="cadastrar-reserva" >
          <input id="inp-cadastrar-sala" type="hidden" value="" name="id_sala">
          <div class="div-cadastrar-turma">
            <div class="row text-center">
              <!-- INPUT TURMA -->
              <div class="col">
                <div class="row row-btn-check">
                  <div class="form-btn-check">
                    <input type="radio" class="btn-check"  id="btn-cadastro-turma" name="cadastro-turma" value="nova" autocomplete="off" checked>
                    <label class="btn btn-primary" for="btn-cadastro-turma">Cadastrar Turma</label>
                  </div>
                </div>
                
                <div class="form-floating ">
                  <input type="text" class="form-control inp-dados-turma" id="inp-turma" placeholder="Turma" name="turma" autocomplete="off" required>
                  <label for="inp-cad-turma" class="form-label">Turma</label>
                </div>
                
                <!-- INPUT DOCENTE -->
                <div class="form-floating ">
                  <input type="text" class="form-control inp-dados-turma" id="inp-docente" placeholder="Docente" name="docente" autocomplete="off" required>
                  <label for="inp-docente" class="form-label">Docente</label>
                </div>
                
                <!-- INPUT CURSO -->
                <div class="form-floating ">
                  <input type="text" class="form-control inp-dados-turma" id="inp-curso" placeholder="Curso" name="curso" autocomplete="off" required>
                  <label for="inp-curso" class="form-label">Curso</label>
                </div>
                
                <!-- INPUT CODIGO TURMA -->
                <div class="form-floating ">
                  <input type="text" class="form-control inp-dados-turma" id="inp-codigo" placeholder="Codigo" name="codigo" autocomplete="off" required>
                  <label for="inp-codigo" class="form-label">Código</label>
                </div>
                
                <!-- INPUT QUANTIDADE PARTICIPANTES -->
                <div class="form-floating ">
                  <input type="number" class="form-control inp-dados-turma" id="inp-participantes" placeholder="N.&#xba; de participantes" name="participantes" min="1" required>
                  <label for="inp-participantes" class="form-label">N.&#xba; de participantes</label>
                </div>
              </div>
              
              <div class="col">
                <div class="row row-btn-check">
                  <div class="form-btn-check">
                    <input type="radio" class="btn-check" id="btn-buscar-turma"  name="cadastro-turma" value="cadastrada" autocomplete="off" >
                    <label class="btn btn-primary" for="btn-buscar-turma">Buscar Turma</label>
                  </div>
                </div>
                
                <div class="form-floating">
                  <select id="turma-cadastrada" class="form-select" disabled="" name="id_turma" aria-label="Floating label select example"  required>
                    <option value="" selected="">Selecione uma turma</option> 
                    
                  </select>
                  <label for="turma-cadastrada">Turma</label>
                </div>
                <div id="turma-dados"></div>
              </div>
            </div>
          </div>
        </form>
      </div>
      
      <div class="modal-footer">
          <button type="submit" form="cadastrar-reserva" class="btn btn-primary " >Salvar</button>
          <button type="button"  class="btn btn-secondary " data-bs-dismiss="modal" id="btn-cancelar-reserva" >Cancelar</button>
        </div>
      </div>
    </div>
</div>
