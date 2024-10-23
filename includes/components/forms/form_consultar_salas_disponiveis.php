<!-- BOX FILTROS -->
<form class="row g-3 form-consulta" id="form-consultar-salas"  method="get">

    <h2>Consultar Salas Disponiveis</h2>
  
  <!-- FILTRO DATA INICIO -->
  <div class="col-md-3">
    <label for="data-inicio" class="form-label">De</label>
    <input type="date" class="form-control" id="inp-consulta-data-inicio" min="<?php echo dataAtual();?>" value="<?php echo dataAtual();?>" name="data_inicio" required>
  </div>
  
  <!-- FILTRO DATA FINAL -->
  <div class="col-md-3">
    <label for="data-fim" class="form-label">Até</label>
    <input type="date" class="form-control" id="inp-consulta-data-fim" min="<?php echo dataAtual();?>" name="data_fim" disabled required>
  </div>
  
  <!-- FILTRO TIPO DE RESERVA -->
  <div class="col-md-3">
    <label for="inp-consulta-reserva-tipo" class="form-label">Tipo de reserva</label>
    <select id="inp-consulta-reserva-tipo" class="form-select" name="tipo_reserva">
      <option value="Única">Única</option>
      <option value="Semanal" >Semanal</option>
    </select>
  </div>

  <!-- FILTRO TURNO -->
  <div class="col-md-3">
    <label for="inp-consulta-turno" class="form-label">Turno</label>
    <select id="inp-consulta-turno" class="form-select" name="turno">
      <option value="Manhã" >Manhã</option>
      <option value="Tarde" >Tarde</option>
      <option value="Noite" >Noite</option>
    </select>
  </div>
  
  <!-- FILTRO NUMERO SALA -->
  <div class="col-md-3">
    <label for="inp-consulta-sala" class="form-label">N.&#xba; da sala</label>
    <select id="inp-consulta-sala" class="form-select" name="sala">
      <option value="" selected="">Qualquer</option>
      <?php salasOptions("id_sala")?>
    </select>
  </div>

  <!-- FILTRO TIPO DE SALA -->
  <div class="col-md-3">
    <label for="inp-consulta-sala-tipo" class="form-label">Tipo de sala</label>
    <select id="inp-consulta-sala-tipo" class="form-select" name="sala_tipo">
      <option value="" selected="">Qualquer</option>
      <?php salasOptions("tipo_sala")?>
    </select>
  </div>

  <!-- FILTRO QUANTIDADE LUGARES -->
  <div class="col-md-3">
    <label for="inp-consulta-lugares-qtd" class="form-label" >N.&#xba; de lugares</label>
    <input type="number" id="inp-consulta-lugares-qtd" class="form-control" min="1" placeholder="Qualquer" name="lugares_qtd">
  </div>

  <!-- FILTRO QUANTIDADE MAQUINAS -->
  <div class="col-md-3">
    <label for="inp-consulta-maquinas-qtd" class="form-label" >N.&#xba; de maquinas</label>
    <input type="number" id="inp-consulta-maquinas-qtd" class="form-control" min="0" placeholder="Qualquer" name="maquinas_qtd">
  </div>
  
  <!-- FILTRO MAQUINA TIPO --> 

  <div class="col-md-3">
    <label for="inp-consulta-maquinas-tipo" class="form-label">Tipo de maquinas</label>
    <select id="inp-consulta-maquinas-tipo" class="form-select" name="maquinas_tipo">
      <option value="" selected="">Qualquer</option>
      <?php salasOptions("maquinas_tipo")?>
    </select>
  </div>


  <!-- FILTRO REGISTROS -->
  <div class="col-md-3">
    <label for="inp-consulta-registros" class="form-label" >N.&#xba; de registros</label>
    <input type="number" id="inp-consulta-registros" class="form-control" min="1" placeholder="Todos" name="registros">
  </div>

  <!-- BOTAO BUSCAR -->
  <div class="col-12" style="display: flex; align-items: center; gap:10px;">
    <button type="submit" class="btn btn-primary " id="btn-buscar-sala-disponivel" >Buscar</button>
  </div>
</form>