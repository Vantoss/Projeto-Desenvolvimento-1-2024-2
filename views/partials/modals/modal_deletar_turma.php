<div class="modal fade" id="modal-deletar-turma" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5">Deletar Turma</h1>
        </div>
        <form method="get" id="form-deletar-turma">
            <input type="hidden" id="inp-deletar-turma-id" value="" name="id-turma">
        
            <div class="modal-body" id="msg-del-turma"></div>
            
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Deletar</button>
                <button type="reset" id="btn-del-cancelar" class="btn btn-secondary" data-bs-target=".modal-principal" data-bs-toggle="modal">Cancelar</button>
            </div>
        </form>
    </div>
  </div>
</div>