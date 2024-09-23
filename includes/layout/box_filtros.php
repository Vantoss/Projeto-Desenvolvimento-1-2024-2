<!-- BOX FILTROS -->

<div class="row g-3">

    <h2>Consultar Reservas</h2>

  <!-- FILTRO DICIPLINA -->
  <div class="col-md-6">
    <label for="filtro-diciplina" class="form-label">Diciplina</label>
    <input type="text" class="form-control" id="filtro-diciplina">
  </div>
  <!-- FILTRO DOCENTE -->
  <div class="col-md-6">
    <label for="filtro-docente" class="form-label">Docente</label>
    <input type="text" class="form-control" id="filtro-docente">
  </div>
  
  <!-- FILTRO DATA INICIO -->
  <div class="col-md-3">
    <label for="filtro-data-inicio" class="form-label">De</label>
    <input type="date" class="form-control" id="filtro-data-inicio">
  </div>
  
  <!-- FILTRO DATA FIM -->
  <div class="col-md-3">
    <label for="filtro-data-fim" class="form-label">Até</label>
    <input type="date" class="form-control" id="filtro-data-fim">
  </div>

  <!-- FILTRO SALA -->
  <div class="col-md-3">
    <label for="filtro-sala" class="form-label">Sala</label>
    <select id="filtro-sala" class="form-select">
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
    <label for="filtro-turno" class="form-label">Turno</label>
    <select id="filtro-turno" class="form-select">
      <option value="" selected="">Qualquer</option>
      <option value="Manhã">Manhã</option>
      <option value="Tarde">Tarde</option>
      <option value="Noite">Noite</option>
    </select>
  </div>
  
  <!-- FILTRO REGISTROS -->
  <div class="col-md-3">
    <label for="filtros-registros" class="form-label" >Registros</label>
    <input type="number" id="filtro-registros" class="form-control" min="1" placeholder="Todos">
  </div>

  <div class="col-12">
    <button type="submit" class="btn btn-primary" id="btn-buscar">Buscar</button>
  </div>
</div>