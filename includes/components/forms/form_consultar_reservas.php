<?php define(ROOT_DIR, "./") ?>

<!-- BOX FILTROS -->

<form class="row g-3 form-consulta" id="form-consultar-reservas" method="get">
  
    <h2>Consultar Reservas</h2>

  <!-- FILTRO turma -->
  <div class="col-md-6">
    <label for="turma" class="form-label">Turma</label>
    <input type="text" class="form-control" id="turma" name="turma">
  </div>

  <!-- FILTRO DOCENTE -->
  <div class="col-md-6">
    <label for="docente" class="form-label">Docente</label>
    <input type="text" class="form-control" id="docente" name="docente">
  </div>

  <!-- FILTRO CURSO -->
  <div class="col-md-3">
    <label for="curso" class="form-label">Curso</label>
    <input type="text" class="form-control" id="curso" name="curso">
  </div>
  
  <!-- FILTRO DATA INICIO -->
  <div class="col-md-3">
    <label for="data-inicio" class="form-label">De</label>
    <input type="date" class="form-control" id="data-inicio" name="data_inicio">
  </div>
  
  <!-- FILTRO DATA FIM -->
  <div class="col-md-3">
    <label for="data-fim" class="form-label">Até</label>
    <input type="date" class="form-control" id="data-fim" name="data_fim">
  </div>

  <!-- FILTRO SALA -->
  <div class="col-md-3">
    <label for="sala" class="form-label"> N.&#xba; da sala</label>
    <select id="sala" class="form-select" name="sala">
      <option value="" selected="">Qualquer</option>
      <?php
      require_once ROOT_DIR . "data/salas.php";
      foreach ($salas as $sala) {?>
          <option value="<?php echo $sala?>" ><?php echo $sala?></option>
      <?php } ?>
    </select>
  </div>
  
  <!-- FILTRO TURNO -->
  <div class="col-md-3">
    <label for="turno" class="form-label">Turno</label>
    <select id="turno" class="form-select" name="turno">
      <option value="" selected="">Qualquer</option>
      <option value="Manhã">Manhã</option>
      <option value="Tarde">Tarde</option>
      <option value="Noite">Noite</option>
    </select>
  </div>

  <!-- FILTRO TIPO DE RESERVA -->
  <div class="col-md-3">
    <label for="sala-tipo" class="form-label">Tipo de reserva</label>
    <select id="sala-tipo" class="form-select" name="reserva_tipo">
      <option value="" selected="">Qualquer</option>
      <option value="unica">Única</option>
      <option value="semanal" >Semanal</option>
      <option value="diaria" >Diária</option>
    </select>
  </div>
  
  <!-- FILTRO REGISTROS -->
  <div class="col-md-3">
    <label for="registros" class="form-label" >N.&#xba; de registros</label>
    <input type="number" id="registros" class="form-control" min="1" placeholder="Todos" name="registros">
  </div>
  <!-- BOTAO BUSCAR -->
  <div class="col-12">
    <button type="submit" class="btn btn-primary" value="consultar-reservas" id="btn-buscar">Buscar</button>
  </div>
</form>