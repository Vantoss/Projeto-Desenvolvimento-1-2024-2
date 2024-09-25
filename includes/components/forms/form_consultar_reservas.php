<!-- BOX FILTROS -->

<form class="row g-3" id="form-consulta" method="post">
  
    <h2>Consultar Reservas</h2>

  <!-- FILTRO DICIPLINA -->
  <div class="col-md-6">
    <label for="diciplina" class="form-label">Diciplina</label>
    <input type="text" class="form-control" id="diciplina" name="diciplina">
  </div>

  <!-- FILTRO DOCENTE -->
  <div class="col-md-6">
    <label for="docente" class="form-label">Docente</label>
    <input type="text" class="form-control" id="docente" name="docente">
  </div>
  
  <!-- FILTRO DATA INICIO -->
  <div class="col-md-3">
    <label for="data-inicio" class="form-label">De</label>
    <input type="date" class="form-control" id="data-inicio" name="data-inicio">
  </div>
  
  <!-- FILTRO DATA FIM -->
  <div class="col-md-3">
    <label for="data-fim" class="form-label">Até</label>
    <input type="date" class="form-control" id="data-fim" name="data-fim">
  </div>

  <!-- FILTRO SALA -->
  <div class="col-md-3">
    <label for="sala" class="form-label">Sala</label>
    <select id="sala" class="form-select" name="sala">
      <option value="" selected="">Qualquer</option>
      <?php
      require_once "../data/salas.php";
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
    <select id="sala-tipo" class="form-select" name="reserva-tipo">
      <option value="" selected="">Qualquer</option>
      <option value="unica">Única</option>
      <option value="semanal" >Semanal</option>
      <option value="diaria" >Diária</option>
    </select>
  </div>
  
  <!-- FILTRO REGISTROS -->
  <div class="col-md-3">
    <label for="registros" class="form-label" >Registros</label>
    <input type="number" id="registros" class="form-control" min="1" placeholder="Todos" name="registros">
  </div>

  <div class="col-12">
    <button type="submit" class="btn btn-primary btn-lg" value="consultar-reservas" id="btn-buscar">Buscar</button>
  </div>
</form>