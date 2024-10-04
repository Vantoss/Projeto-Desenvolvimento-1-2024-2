<div class="modal fade" id="cadastrar-reserva-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">
          <?php $data = $_GET["data_inicio"];
          echo date_format(date_create($data)," l - d/m/Y") ." - ". $_GET["turno"] . " - " . $_GET["reserva_tipo"]; ?>
        </h1>
        
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>  
      </div>
      
      <div class="modal-body">
        
        <div id="sala-dados">
          
          
          <h4 id="sala-id">704 - Laboratorio</h4>
          <h5 id="sala-">40 lugares </h5>
          <h5 id="sala-maquinas"> 30 maquinas</h5>
          <h5 id="sala-lugares"></h5>
          
        </div>
        <!-- HIDDEN INPUTS -->

        <p id="dados-cad"></p>
        
        
        <form method="post" id="cadastrar-reserva" >
          <div class="div-cadastrar-turma">
            <div class="row text-center">
              <!-- INPUT TURMA -->
              <div class="col">
                <div class="row row-btn-check">
                  <div class="form-btn-check">
                    <input type="radio" class="btn-check" onchange="disable_input_turma(this)" id="btn-cadastro-turma" name="cadastro-turma" value="nova" autocomplete="off" checked>
                    <label class="btn btn-primary" for="btn-cadastro-turma">Cadastrar Turma</label>
                  </div>
                </div>
                
                <div class="form-floating ">
                  <input type="text" class="form-control input-cadastrar-turma" id="cad-turma" placeholder="Turma" name="turma" autocomplete="off" required>
                  <label for="cad-turma" class="form-label">Turma</label>
                </div>
                
                <!-- INPUT DOCENTE -->
                <div class="form-floating ">
                  <input type="text" class="form-control input-cadastrar-turma" id="docente" placeholder="Docente" name="docente" autocomplete="off" required>
                  <label for="docente" class="form-label">Docente</label>
                </div>
                
                <!-- INPUT CURSO -->
                <div class="form-floating ">
                  <input type="text" class="form-control input-cadastrar-turma" id="curso" placeholder="Curso" name="curso" autocomplete="off" required>
                  <label for="curso" class="form-label">Curso</label>
                </div>
                
                <!-- INPUT CODIGO TURMA -->
                <div class="form-floating ">
                  <input type="text" class="form-control input-cadastrar-turma" id="codigo" placeholder="Codigo" name="codigo" autocomplete="off" required>
                  <label for="codigo" class="form-label">Código</label>
                </div>
                
                <!-- INPUT QUANTIDADE PARTICIPANTES -->
                <div class="form-floating ">
                  <input type="number" class="form-control input-cadastrar-turma" id="participantes"  placeholder="N participantes" name="participantes" min="1" required>
                  <label for="participantes" class="form-label"> Participantes</label>
                </div>
              </div>
              
              <div class="col">
                <div class="row row-btn-check">
                  <div class="form-btn-check">
                    <input type="radio" class="btn-check" id="btn-buscar-turma" onchange="disable_input_turma(this)" name="cadastro-turma" value="cadastrada" autocomplete="off" required >
                    <label class="btn btn-primary" for="btn-buscar-turma">Buscar Turma</label>
                  </div>
                </div>
                
                <div class="form-floating">
                  <select id="turma-cadastrada" class="form-select" disabled="" name="turma_cadastrada" aria-label="Floating label select example" required>
                    <option  selected="">Qualquer</option>
                    <option value="Manhã">Manhã</option>
                    <option value="Tarde">Tarde</option>
                    <option value="Noite">Noite</option>
                  </select>
                  <label for="turma-cadastrada">Turma</label>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
      
      <div class="modal-footer">
          <button type="submit"form="cadastrar-reserva" class="btn btn-primary">Salvar</button>
          <button type="reset" form="cadastrar-reserva" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        </div>
      </div>
    </div>
</div>