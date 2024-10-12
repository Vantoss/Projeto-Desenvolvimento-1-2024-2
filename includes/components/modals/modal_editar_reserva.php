<div class="modal fade" id="modal-editar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5">
          <!-- <?php $data = $_GET["data_inicio"];
          echo date_format(date_create($data)," l - d/m/Y") ." - ". $_GET["turno"] . " - " . $_GET["reserva_tipo"]; ?> -->
        </h1> 
      </div>
      
      <div class="modal-body">
        
        <div id="sala-dados">
          <h4 id="sala-id">704 - Laboratorio</h4>
          <h5 id="sala-">40 lugares </h5>
          <h5 id="sala-maquinas"> 30 maquinas</h5>
          <h5 id="sala-lugares"></h5>
        </div>

        <form method="post" id="form-editar" >
          <div class="div-cadastrar-turma">
            <div class="row text-center">
              <!-- INPUT TURMA -->
              <div class="col">
                <div class="row row-btn-check">
                  <div class="form-btn-check">
                    <input type="radio" class="btn-check " id="btn-editar-turma" name="editar" value="turma" autocomplete="off" checked>
                    <label class="btn btn-primary" for="btn-editar-turma">Editar Turma</label>
                  </div>
                </div>
                
                <div class="form-floating ">
                  <input type="text" class="form-control inp-dados-turma" id="inp-turma" placeholder="Turma" name="turma" autocomplete="off" >
                  <label for="inp-turma" class="form-label">Turma</label>
                </div>
                
                <!-- INPUT DOCENTE -->
                <div class="form-floating ">
                  <input type="text" class="form-control inp-dados-turma" id="inp-docente" placeholder="Docente" name="docente" autocomplete="off" >
                  <label for="inp-docente" class="form-label">Docente</label>
                </div>
                
                <!-- INPUT CURSO -->
                <div class="form-floating ">
                  <input type="text" class="form-control inp-dados-turma" id="inp-curso" placeholder="Curso" name="curso" autocomplete="off" >
                  <label for="inp-curso" class="form-label">Curso</label>
                </div>
                
                <!-- INPUT CODIGO TURMA -->
                <div class="form-floating ">
                  <input type="text" class="form-control inp-dados-turma" id="inp-codigo" placeholder="Codigo" name="codigo" autocomplete="off" >
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
                    <input type="radio" class="btn-check" id="btn-trocar-turma"  name="editar" value="reserva" autocomplete="off" required>
                    <label class="btn btn-primary" for="btn-trocar-turma">Trocar turma</label>
                  </div>
                </div>
                
                <div class="form-floating">
                  <select id="turma-cadastrada" class="form-select" disabled="" name="id_turma_nova" aria-label="Floating label select example"  required>
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
          <button type="submit" form="form-editar" id="btn-salvar-editar" class="btn btn-primary">Salvar</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        </div>
      </div>
    </div>
</div>

<div class="modal fade" id="modal-editar-reserva" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5">Editar Reserva</h1>
      </div>
      <form method="post" id="form-edit-reserva">
        <div class="modal-body">
          <div class="form-check">
            <input class="form-check-input" id="radio-edit-atual" type="radio" name="edit_reserva" value="atual" checked>
            <label class="form-check-label" for="radio-edit-atual">Editar registro atual</label>
          </div>
          <div class="form-check">
            <input class="form-check-input" id="radio-edit-todos" type="radio" name="edit_reserva" value="todos">
            <label class="form-check-label" for="radio-edit-todos">Editar todos os registros</label>
          </div>
          <div class="form-check">
            <input class="form-check-input" id="radio-edit-apartir" type="radio" name="edit_reserva" value="apartir">
            <label class="form-check-label" for="radio-edit-apartir">Editar os registros a partir do atual</label>
          </div>
        </div>
        <div class="modal-footer">
          <button  type="submit" class="btn btn-primary" data-bs-dismiss="modal">Editar</button>
          <button  type="reset" id="btn-edit-cancelar" class="btn btn-secondary" data-bs-target="#modal-editar" data-bs-toggle="modal" >Cancelar</button>
        </div>
      </form>
    </div>
  </div>
</div>
