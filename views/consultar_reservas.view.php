<?php
    // HEADER
require view('partials/head.php');
require view('partials/navbar.php');
?>
        
<body>
    
<!-- BOX FILTROS -->

<form class="row g-3 form-consulta" id="form-consultar-reservas" method="get">
    <div style="display: flex; justify-content: space-between; margin-top:0;">
      <h2>Consultar Reservas</h2>
      <h2><?php echo getDataAtual() ?></h2>
    </div>
      
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
    <input type="date" class="form-control inp-data" id="inp-consulta-data-inicio" name="data-inicio" value="<?php echo dataAtual() ?>">
  </div>
  
  <!-- FILTRO DATA FIM -->
  <div class="col-md-3">
    <label for="inp-consulta-data-fim" class="form-label">Até</label>
    <input type="date" class="form-control inp-data" id="inp-consulta-data-fim" name="data-fim" value="<?php echo dataAtual() ?>">
    <div  class="invalid-feedback">
        A data final não pode ser maior que a data inicial
      </div>
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

  <!-- FILTRO SEMESTRE -->
  <div class="col-md-3">
    <label for="inp-consulta-semestre" class="form-label">Semestre</label>
    <select id="inp-consulta-semestre" class="form-select" name="semestre">
    <option value="" selected="">Qualquer</option>
    <?php turmasOptions() ?>
    </select>
  </div>

<!-- FILTRO TIPO DE RESERVA -->
<div class="col-md-3">
    <label for="inp-consulta-reserva-tipo" class="form-label">Tipo de reserva</label>
    <select id="inp-consulta-reserva-tipo" class="form-select" name="tipo-reserva">
      <option selected="" value="">Qualquer</option>
      <option value="Avulsa">Avulsa</option>
      <option value="Graduação">Graduação</option>
      <option value="Pos-graducao" >Pós-graduação</option>
      <option value="FIC" >FIC</option>
    </select>
  </div>

  <!-- RESERVA STATUS -->
  
  <div class="col-md-3">
    <label for="inp-reserva-status" class="form-label">Reservas status</label>
    <select id="inp-reserva-status" class="form-select" name="reserva-status">
      <option value="Ativa" selected="">Ativa</option>
      <option value="Inativa" >Inativa</option>
    </select>
  </div>
  
  <!-- BOTAO BUSCAR -->
  <div class="col-12" style="display: flex; align-items: center; gap:10px;">
    <button type="submit" class="btn btn-primary btn-buscar" value="consultar-reservas" id="btn-buscar">Buscar</button>
  </div>
</form>



<?php
    // MODAIS DELETAR RESERVA
    require view('partials/modals/modal_deletar_reserva.php');
    
    // MODAL EDITAR RESERVA
    require view('partials/modals/modal_editar_reserva.php');

    // MODAL ALERTA 
    require view('partials/modals/modal_alerta.php');

    //MODAL DELETAR TURMA
    require view('partials/modals/modal_deletar_turma.php');
?>

    <div class="container-fluid" id="container-tabela"></div>
    
</body>
</html>