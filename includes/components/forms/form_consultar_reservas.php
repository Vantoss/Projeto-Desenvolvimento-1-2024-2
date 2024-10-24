<!-- BOX FILTROS -->

<form class="row g-3 form-consulta" id="form-consultar-reservas" method="get">
  
    <h2>Consultar Reservas</h2>

  <!-- FILTRO turma -->
  <div class="col-md-6">
    <label for="inp-consulta-turma" class="form-label">Turma</label>
    <input type="text" class="form-control" id="inp-consulta-turma" name="turma">
  </div>

  <!-- FILTRO DOCENTE -->
  <div class="col-md-6">
    <label for="inp-consulta-docente" class="form-label">Docente</label>
    <input type="text" class="form-control" id="inp-consulta-docente" name="docente">
  </div>

  <!-- FILTRO CURSO -->
  <div class="col-md-3">
    <label for="inp-consulta-curso" class="form-label">Curso</label>
    <input type="text" class="form-control" id="inp-consulta-curso" name="curso">
  </div>
  
  <!-- FILTRO DATA INICIO -->
  <div class="col-md-3">
    <label for="inp-consulta-data-inicio" class="form-label">De</label>
    <input type="date" class="form-control" id="inp-consulta-data-inicio" name="data_inicio">
  </div>
  
  <!-- FILTRO DATA FIM -->
  <div class="col-md-3">
    <label for="inp-consulta-data-fim" class="form-label">Até</label>
    <input type="date"id="inp-consulta-data-fim" class="form-control"  name="data_fim">
  </div>

  <!-- FILTRO SALA -->
  <div class="col-md-3">
    <label for="inp-consulta-sala" class="form-label"> N.&#xba; da sala</label>
    <select id="inp-consulta-sala" class="form-select" name="sala">
      <option value="" selected="">Qualquer</option>
      <?php salasOptions("id_sala") ?>
    </select>
  </div>
  
  <!-- FILTRO TURNO -->
  <div class="col-md-3">
    <label for="inp-consulta-turno" class="form-label">Turno</label>
    <select id="inp-consulta-turno" class="form-select" name="turno">
      <option value="" selected="">Qualquer</option>
      <option value="Manhã">Manhã</option>
      <option value="Tarde">Tarde</option>
      <option value="Noite">Noite</option>
    </select>
  </div>

  <!-- FILTRO TIPO DE RESERVA -->
  <div class="col-md-3">
    <label for="inp-consulta-sala-tipo" class="form-label">Tipo de reserva</label>
    <select id="inp-consulta-sala-tipo" class="form-select" name="tipo_reserva">
      <option value="" selected="">Qualquer</option>
      <option value="unica">Única</option>
      <option value="semanal" >Semanal</option>
    </select>
  </div>

  <!-- RESERVA STATUS -->
  
  <div class="col-md-3">
    <label for="inp-reserva-status" class="form-label">Reservas status</label>
    <select id="inp-reserva-status" class="form-select" name="reserva_status">
      <option value="Ativa" selected="">Ativa</option>
      <option value="Inativa" >Inativa</option>
    </select>
  </div>
  
  <!-- FILTRO REGISTROS -->
  <div class="col-md-3">
    <label for="inp-consulta-registros" class="form-label" >N.&#xba; de registros</label>
    <input type="number" id="inp-consulta-registros" class="form-control" min="1" placeholder="Todos" name="registros">
  </div>
  <!-- BOTAO BUSCAR -->
  <div class="col-12" style="display: flex; align-items: center; gap:10px;">
    <button type="submit" class="btn btn-primary" value="consultar-reservas" id="btn-buscar">Buscar</button>
  </div>
</form>