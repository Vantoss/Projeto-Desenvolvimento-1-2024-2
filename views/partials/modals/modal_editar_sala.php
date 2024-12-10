<div class="modal fade" id="modal-editar-sala" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal">
    <div class="modal-content">
      <div class="modal-header" id="modal-header-editar">
        <h1 class="modal-title fs-5">Editar Sala - <span id="span-numero-sala"></span> <span id="sala-numero"></span></h1> 
      </div>
      <div class="modal-body">
        <form method="post" id="form-editar-sala">
          
          <input type="hidden" name="id-sala" id="inp-editar-sala-id" value="">
          
            <div class="row">
              <div class="col">
                
                <!-- INPUT UNIDADE -->
                <div class="mb-3">
                  <label class="form-check-label d-block"> N.&#xba; unidade</label>

                   <div class="form-check form-check-inline">
                     <input class="form-check-input" type="radio" name="unidade" id="inp-editar-unidade-1" value="1">
                     <label class="form-check-label" for="inp-editar-unidade-1">1</label>
                    </div>
                    
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="unidade" id="inp-editar-unidade-2" value="2">
                    <label class="form-check-label" for="inp-editar-unidade-2">2</label>
                  </div>
                </div>

                <!-- INPUT TIPO -->
                <div class="form-floating ">
                  <input type="text" class="form-control mb-3" id="inp-editar-tipo" placeholder="Tipo" name="tipo" autocomplete="off" >
                  <label for="inp-editar-tipo" class="form-label">Tipo</label>
                </div>

                <!-- INPUT NUMERO MAQUINAS -->
                <div class="form-floating ">
                  <input type="number" class="form-control mb-3" id="inp-editar-maquinas-qtd" placeholder="N.&#xba; de máquinas" name="maquinas-qtd" min="1" >
                  <label for="inp-editar-maquinas-qtd" class="form-label">N.&#xba; de máquinas</label>
                </div>

                <!-- INPUT MAQUINAS TIPO -->
                <div class="form-floating ">
                  <input type="text" class="form-control mb-3" id="inp-editar-maquinas-tipo" placeholder="Tipo de maquinas" name="maquinas-tipo" min="1" >
                  <label for="inp-editar-maquinas-tipo" class="form-label">Tipo de máquinas</label>
                </div>

                <!-- INPUT LOTAÇÃO -->
                <div class="form-floating ">
                  <input type="number" class="form-control mb-3" id="inp-editar-lotacao" placeholder="Lotação" name="lotacao" min="1" >
                  <label for="inp-editar-lotacao" class="form-label">Lotação</label>
                </div>

                
                
                <!-- INPUT OBS -->
                <div class="form-floating ">
                    <textarea class="form-control mb-3" style="height: 150px"  id="inp-editar-descricao" placeholder="Descrição" name="descricao"></textarea>
                    <label for="inp-editar-descricao" class="form-label">Descrição</label>
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