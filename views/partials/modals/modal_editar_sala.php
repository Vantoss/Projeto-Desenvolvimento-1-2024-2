<div class="modal fade" id="modal-editar-sala" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal">
    <div class="modal-content">
      <div class="modal-header" id="modal-header-editar">
        <h1 class="modal-title fs-5">Editar Sala <span id="sala-numero"></span></h1> 
      </div>
      <div class="modal-body">
        <form method="post" id="form-editar-sala">
          
          <input type="hidden" name="id-sala" id="inp-editar-sala-id" value="">
          
            <div class="row text-center">
              <!-- INPUT TIPO -->
              <div class="col">
                <div class="form-floating ">
                  <input type="text" class="form-control mb-3" id="inp-tipo" placeholder="Tipo" name="tipo" autocomplete="off" >
                  <label for="inp-tipo" class="form-label">Tipo</label>
                </div>
                
                <!-- INPUT NUMERO MAQUINAS -->
                <div class="form-floating ">
                  <input type="number" class="form-control mb-3" id="inp-maquinas-qtd" placeholder="N.&#xba; de máquinas" name="maquinas-qtd" min="1" >
                  <label for="inp-maquinas-qtd" class="form-label">N.&#xba; de máquinas</label>
                </div>

                <!-- INPUT MAQUINAS TIPO -->
                <div class="form-floating ">
                  <input type="number" class="form-control mb-3" id="inp-maquinas-tipo" placeholder="Tipo de maquinas" name="maquinas-tipo" min="1" >
                  <label for="inp-maquinas-tipo" class="form-label">Tipo de máquinas</label>
                </div>

                <!-- INPUT LOTAÇÃO -->
                <div class="form-floating ">
                  <input type="number" class="form-control mb-3" id="inp-lotacao" placeholder="Lotação" name="lotacao" min="1" >
                  <label for="inp-lotacao" class="form-label">Lotação</label>
                </div>
                
                <!-- INPUT OBS -->
                <div class="form-floating ">
                    <textarea class="form-control mb-3" style="height: 150px"  id="inp-sala-obs" placeholder="Observações" name="descricao"></textarea>
                    <label for="inp-sala-obs" class="form-label">Observações</label>
                </div>
            </div>
          </div>
        </form>
      </div>
      
      <div class="modal-footer">
          <button type="submit" form="form-editar-sala" id="btn-salvar-editar" class="btn btn-primary">Salvar</button>
          <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal" data-bs-target=".modal" >Cancelar</button>
      </div>
      
      </div>
    </div>
</div>