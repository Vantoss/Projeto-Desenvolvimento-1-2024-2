<!-- BOX FILTROS -->

<form class="row g-3" id="form-consultar-salas-disponiveis"  method="post">

    <h2>Cadastrar Reservas</h2>
  
  <!-- FILTRO DATA INICIO -->
  <div class="col-md-3">
    <label for="data-inicio" class="form-label">De</label>
    <input type="date" class="form-control" id="data-inicio" name="data-inicio" required>
  </div>
  
  
  <!-- FILTRO DATA FINAL -->
  <div class="col-md-3">
    <label for="data-fim" class="form-label">Até</label>
    <input type="date" class="form-control" id="data-fim" name="data-fim" disabled required>
  </div>
  
  <!-- FILTRO TIPO DE RESERVA -->
  <div class="col-md-3">
    <label for="reserva-tipo" class="form-label">Tipo de reserva</label>
    <select id="reserva-tipo" class="form-select" name="reserva-tipo" onchange="disableData_fim(this)">
      <option value="única">Única</option>
      <option value="diária">Diária</option>
      <option value="semanal" >Semanal</option>
    </select>
  </div>

  <!-- FILTRO TURNO -->
  <div class="col-md-3">
    <label for="turno" class="form-label">Turno</label>
    <select id="turno" class="form-select" name="turno">
      <option value="Manhã" >Manhã</option>
      <option value="Tarde" >Tarde</option>
      <option value="Noite" >Noite</option>
    </select>
  </div>
  
  <!-- FILTRO NUMERO SALA -->
  <div class="col-md-3">
    <label for="sala" class="form-label">N.&#xba; da sala</label>
    <select id="sala" class="form-select" name="sala">
      <option value="" selected="">Qualquer</option>
      <?php
      require_once "../data/salas.php";
      foreach ($salas as $sala) {?>
          <option value="<?php echo $sala?>" ><?php echo $sala ?></option>
      <?php } ?>
    </select>
  </div>

  <!-- FILTRO TIPO DE SALA -->
  <div class="col-md-3">
    <label for="sala-tipo" class="form-label">Tipo de sala</label>
    <select id="sala-tipo" class="form-select" name="sala-tipo">
      <option value="" selected="">Qualquer</option>
      <?php
      require_once "../data/salas.php";
      foreach ($sala_tipos as $sala) {?>
          <option value="<?php echo $sala?>" ><?php echo ucfirst(mb_strtolower($sala))?></option>
      <?php } ?>
    </select>
  </div>

  <!-- FILTRO QUANTIDADE LUGARES -->
  <div class="col-md-3">
    <label for="lugares-qtd" class="form-label" >N.&#xba; de lugares</label>
    <input type="number" id="lugares-qtd" class="form-control" min="1" placeholder="Qualquer" name="lugares-qtd">
  </div>

  <!-- FILTRO QUANTIDADE MAQUINAS -->
  <div class="col-md-3">
    <label for="maquinas-qtd" class="form-label" >N.&#xba; de maquinas</label>
    <input type="number" id="maquinas-qtd" class="form-control" min="1" placeholder="Qualquer" name="maquinas-qtd">
  </div>
  
  <!-- FILTRO MAQUINA TIPO -->
  <div class="col-md-3">
    <label for="maquinas-tipo" class="form-label" >Tipo de maquinas</label>
    <input type="text" id="maquinas-tipo" class="form-control" placeholder="Qualquer" name="maquinas-tipo">
  </div>

  

  <!-- FILTRO REGISTROS -->
  <div class="col-md-3">
    <label for="registros" class="form-label" >N.&#xba; de registros</label>
    <input type="number" id="registros" class="form-control" min="1" placeholder="Todos" name="registros">
  </div>

  <!-- BOTAO BUSCAR -->
  <div class="col-12">
    <button type="submit" class="btn btn-primary btn-lg" id="btn-buscar-sala-disponivel">Buscar</button>
  </div>
</form>