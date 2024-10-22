<div class="modal fade modal-principal" id="modal-editar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header" id="modal-header-editar">
        <h1 class="modal-title fs-4">Editar Reserva</h1> 
      </div>
      
      <div class="modal-body">
        
        <!-- DADOS SALA -->
        <div class="row row-cols-2" style="margin-bottom: 10px;" >
          <div class="col">
            <div class="modal-dados" id="sala-dados"></div>
          </div>
          <!-- DADOS RESERVA -->
          <div class="col">
            <div class="modal-dados" id="reserva-dados"></div>
          </div>
        </div>

        <form method="post" id="form-editar" >
          <input type="hidden" name="id_reserva" id="inp-edit-id_reserva" value="">
          <input type="hidden" name="id_turma" id="inp-edit-id_turma" value="">
          
            <div class="row text-center">


              <div class="col">
                <div class="form-floating">
                  <select id="turma-cadastrada" class="form-select" name="id_turma_nova" aria-label="Floating label select example"  required>
                    <!-- <option value="" selected="">Selecione uma turma</option> -->
                  </select>
                  <label for="turma-cadastrada">turma</label>
                </div>

                <!-- BOX DE DADOS TURMA -->
                <div class="turma-dados" id="turmas-dados-editar"></div>
              </div>
            </div>
    
        </form>
      </div>

      <div class="modal-footer">
          <button type="submit" class="btn btn-primary" form="form-editar" id="btn-salvar-editar" >Salvar</button>
          <button type="button" class="btn btn-secondary btn-cancelar-modal-principal" data-bs-dismiss="modal">Cancelar</button>
      </div>

    </div>
   </div>
</div>

<!-- MODAL EDITAR RESERVAS -->

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

<?php 
require_once "modal_deletar_turma.php"; 
require_once "modal_editar_turma.php"; 
?>
