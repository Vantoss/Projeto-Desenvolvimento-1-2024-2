<div class="modal fade" id="modal-cadastrar-sala" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5">Cadastrar Sala </h1> 
      </div>
      <div class="modal-body">
        <form method="post" id="form-cadastrar-sala">
            <div class="row">
              <div class="col">
                <!-- INPUT NUMERO SALA-->
                <div class="form-floating ">
                  <input type="number" class="form-control mb-3" id="inp-cadastrar-numero-sala" placeholder="N.&#xba; Sala" name="numero-sala" min="1" required>
                  <label for="inp-cadastrar-numero-sala" class="form-label">N.&#xba; Sala</label>
                </div>
                <!-- INPUT UNIDADE -->
                <div class="mb-3">
                  <label class="form-check-label d-block"> N.&#xba; unidade</label>

                   <div class="form-check form-check-inline">
                     <input class="form-check-input" type="radio" name="unidade" id="inp-cadastrar-unidade-1" value="1" required>
                     <label class="form-check-label" for="inp-cadastrar-unidade-1">1</label>
                    </div>
                    
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="unidade" id="inp-cadastrar-unidade-2" value="2"required>
                    <label class="form-check-label" for="inp-cadastrar-unidade-2">2</label>
                  </div>
                </div>

                <!-- INPUT TIPO -->
                <div class="form-floating ">
                  <input type="text" class="form-control mb-3" id="inp-cadastrar-tipo" placeholder="Tipo" name="tipo" autocomplete="off" required>
                  <label for="inp-cadastrar-tipo" class="form-label">Tipo</label>
                </div>

                <!-- INPUT NUMERO MAQUINAS -->
                <div class="form-floating ">
                  <input type="number" class="form-control mb-3" id="inp-cadastrar-maquinas-qtd" placeholder="N.&#xba; de máquinas" name="maquinas-qtd" min="1" required>
                  <label for="inp-cadastrar-maquinas-qtd" class="form-label">N.&#xba; de máquinas</label>
                </div>

                <!-- INPUT MAQUINAS TIPO -->
                <div class="form-floating ">
                  <input type="text" class="form-control mb-3" id="inp-cadastrar-maquinas-tipo" placeholder="Tipo de maquinas" name="maquinas-tipo" min="1"required >
                  <label for="inp-cadastrar-maquinas-tipo" class="form-label">Tipo de máquinas</label>
                </div>

                <!-- INPUT LOTAÇÃO -->
                <div class="form-floating ">
                  <input type="number" class="form-control mb-3" id="inp-cadastrar-lotacao" placeholder="Lotação" name="lotacao" min="1" required >
                  <label for="inp-cadastrar-lotacao" class="form-label">Lotação</label>
                </div>

                
                
                <!-- INPUT OBS -->
                <div class="form-floating ">
                    <textarea class="form-control mb-3" style="height: 150px"  id="inp-cadastrar-descricao" placeholder="Descrição" name="descricao"></textarea>
                    <label for="inp-cadastrar-descricao" class="form-label">Descrição</label>
                </div>
            </div>
          </div>
        </form>
      </div>
      
      <div class="modal-footer">
          <button type="submit" form="form-cadastrar-sala" id="btn-salvar-cadastrar" class="btn btn-primary">Salvar</button>
          <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal" data-bs-target="#modal-cadastrar-sala" >Cancelar</button>
      </div>
      
      </div>
    </div>
</div>