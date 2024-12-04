<div class="modal fade modal-principal" id="cadastrar-reserva-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header" id="modal-header-cadastrar"><h1 class="modal-title fs-4">Cadastrar Reserva</h1></div>
        
        <div class="modal-body ">
          <div class="container p-0">
          
        <!-- DADOS SALA -->
        <div class="row row-cols-2">
          <div class="col">
            <div class="modal-dados" id="sala-dados"></div>
          </div>
          <!-- DADOS RESERVA -->
          <div class="col">
            <div class="modal-dados" id="reserva-dados"></div>
          </div>
        </div>

          <form method="post" id="cadastrar-reserva" ></form>
            <input id="inp-cadastrar-sala" form="cadastrar-reserva" type="hidden" value="" name="id-sala">
          
                <div class="row row-cols-2 text-center ">

                  <div class="col">
                    
                  <!-- BTN TURMA CADASTRADA -->
                    <div class="form-btn-check row-btn-check">
                      <input type="radio" class="btn-check" form="cadastrar-reserva" id="btn-buscar-turma"  name="cadastro-turma" value="cadastrada" autocomplete="off" >
                      <label class="btn btn-outline-primary" for="btn-buscar-turma">Buscar Turma</label>
                    </div>

                    <div class="form-floating">
                      <select id="turma-cadastrada" form="cadastrar-reserva" class="form-select" disabled="" name="id-turma" aria-label="Floating label select example"  required>
                      </select>
                      <label for="turma-cadastrada">Turma</label>
                    </div>

                  </div>
                  
                  <div class="col">
                    <!-- BTN CADASTRAR TURMA -->
                    <div class="form-btn-check row-btn-check">
                      <input type="radio" class="btn-check" form="cadastrar-reserva"  id="btn-cadastro-turma" name="cadastro-turma" value="nova" autocomplete="off" checked>
                      <label class="btn btn-outline-primary" for="btn-cadastro-turma">Cadastrar Turma</label>
                    </div>

                    <div class="form-floating ">
                      <input type="text" form="cadastrar-reserva"  class="form-control inp-cadastrar-turma" id="inp-nome" placeholder="Nome" name="nome" autocomplete="off" required>
                      <label for="inp-nome" class="form-label">Nome</label>
                    </div>

                  </div>

                </div>
                
                <div class="row row-cols-2">

                  <div class="col col-turma-dados" style="margin-top: 10px;">
                      <div class="turma-dados" id="turma-dados-cadastrar">

                      <?php require ROOT_DIR."views/partials/containers/form_turma_edit_del.php"; ?>

                      </div>
                  </div>

                  <div class="col">
                    <!-- INPUT DOCENTE -->
                    <div class="form-floating ">
                      <input type="text" form="cadastrar-reserva"  class="form-control inp-cadastrar-turma" id="inp-cadastrar-docente" placeholder="Docente" name="docente" autocomplete="off" required>
                      <label for="inp-docente" class="form-label">Docente</label>
                    </div>
                    
                    <!-- INPUT CURSO -->
                    <div class="form-floating ">
                      <input type="text" form="cadastrar-reserva"  class="form-control inp-cadastrar-turma" id="inp-cadastrar-curso" placeholder="Curso" name="curso" autocomplete="off" required>
                      <label for="inp-curso" class="form-label">Curso</label>
                    </div>
                    
                    <!-- INPUT SEMESTRE-->
                    <div class="form-floating ">
                      <input type="text" form="cadastrar-reserva"  class="form-control inp-cadastrar-turma" id="inp-semestre" placeholder="Semestre" name="semestre" autocomplete="off" required>
                      <label for="inp-semestre" class="form-label">Semestre</label>
                    </div>
                
                    <!-- INPUT QUANTIDADE PARTICIPANTES -->
                    <div class="form-floating ">
                      <input type="number" form="cadastrar-reserva"  class="form-control inp-cadastrar-turma" id="inp-cadastrar-participantes" placeholder="N.&#xba; de participantes" name="participantes" min="1" required>
                      <label for="inp-participantes" class="form-label">N.&#xba; de participantes</label>
                    </div>
                  </div>
                </div>
                
                <!-- INPUT RESPONSAVEL CADASTRO -->
                <div class="form-floating mt-3 ">
                  <input type="text" form="cadastrar-reserva"  class="form-control" id="inp-responsavel-cadastro" placeholder="Responsável Cadastro" name="responsavel-cadastro" autocomplete="off" required>
                  <label for="inp-responsavel-cadastro" class="form-label">Responsável Cadastro</label>
                </div>
              </div>
      </div>
      
      <div class="modal-footer">
          <button type="submit" form="cadastrar-reserva" class="btn btn-primary " >Salvar</button>
          <button type="button"  class="btn btn-secondary btn-cancelar-modal-principal" data-bs-dismiss="modal" id="btn-cancelar-reserva" >Cancelar</button>
      </div>
      </div>
    </div>
</div>

