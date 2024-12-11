<?php
// HEADER
require view('partials/head.php');
require view('partials/navbar.php');

?>

<body>
    <!-- BOX FILTROS -->
<form class="row g-3 form-consulta " id="form-consultar-salas"  method="get" >
<div style="display: flex; justify-content: space-between; margin-top:0;">
      <h2>Cadastrar Reservas</h2>
      <h2><?php echo getDataAtual() ?></h2>
    </div>


<!-- FILTRO DATA INICIO -->
<div class="col-md-3">
  <label for="inp-consulta-data-inicio" class="form-label">De</label>
  <input type="date" class="form-control inp-data" id="inp-consulta-data-inicio" min="<?php echo dataAtual();?>" value="<?php echo dataAtual();?>" name="data-inicio" required>
</div>


<!-- FILTRO DATA FINAL -->
<div class="col-md-3">
  <label for="inp-consulta-data-fim" class="form-label">Até</label>
  <input type="date" class="form-control inp-data" id="inp-consulta-data-fim" min="<?php echo dataAtual();?>" name="data-fim" disabled required>
<div  class="invalid-feedback">
    A data final não pode ser maior que a data inicial
  </div>
</div>

<!-- NUM ENCONTROS -->
<div class="col-md-3">
<label for="inp-semanas" class="form-label">N.&#xba; de Semanas</label>
<input type="number" class="form-control" id="inp-semanas" min="1" name="semanas" disabled required>
</div>
<div class="col-md-3">
  <label for="inp-semanas" class="form-label">Dias da Semana</label>
  <div class="d-flex" style=" flex-wrap: wrap; align-items:center; column-gap:6px;">
        <div class="form-check ">
          <input class="form-check-input inp-dia-semana" type="checkbox" name="dias-semana[]" value="1" id="inp-segunda" disabled>
          <label class="form-check-label" for="inp-segunda">Seg</label>
        </div>
        <div class="form-check ">
          <input class="form-check-input inp-dia-semana" type="checkbox" name="dias-semana[]" value="2" id="inp-terca" disabled>
          <label class="form-check-label" for="inp-terca">Ter</label>
        </div>
        <div class="form-check ">
          <input class="form-check-input inp-dia-semana" type="checkbox" name="dias-semana[]" value="3" id="inp-quarta" disabled>
          <label class="form-check-label" for="inp-quarta">Qua</label>
        </div>
        <div class="form-check ">
          <input class="form-check-input inp-dia-semana" type="checkbox" name="dias-semana[]" value="4" id="inp-quinta" disabled>
          <label class="form-check-label" for="inp-quinta">Qui</label>
        </div>
        <div class="form-check ">
          <input class="form-check-input inp-dia-semana" type="checkbox" name="dias-semana[]" value="5" id="inp-sexta" disabled>
          <label class="form-check-label" for="inp-sexta">Sex</label>
        </div>
        <div class="form-check ">
          <input class="form-check-input inp-dia-semana" type="checkbox" name="dias-semana[]" value="6" id="inp-sabado" disabled>
          <label class="form-check-label" for="inp-sabado">Sáb</label>
        </div>
        <div class="form-check ">
          <input class="form-check-input inp-dia-semana" type="checkbox" name="dias-semana[]" value="0" id="inp-domingo" disabled>
          <label class="form-check-label" for="inp-domingo">Dom</label>
        </div>
    </div>
  </div>

<!-- FILTRO TIPO DE RESERVA -->
<div class="col-md-3">
<label for="inp-consulta-reserva-tipo" class="form-label">Tipo de Reserva</label>
<select id="inp-consulta-reserva-tipo" class="form-select" name="tipo-reserva">
  <option value="Avulsa">Avulsa</option>
  <option value="Graduação">Graduação</option>
  <option value="Pos-graduacao" >Pós-graduação</option>
  <option value="FIC" >FIC</option>
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
<label for="inp-consulta-sala" class="form-label">N.&#xba; da Sala</label>
<select id="inp-consulta-sala" class="form-select" name="sala">
  <option value="" selected="">Qualquer</option>
  <?php salasOptions("id_sala")?>
</select>
</div>

<!-- FILTRO TIPO DE SALA -->
<div class="col-md-3">
<label for="inp-consulta-sala-tipo" class="form-label">Tipo de Sala</label>
<select id="inp-consulta-sala-tipo" class="form-select" name="sala-tipo">
  <option value="" selected="">Qualquer</option>
  <?php salasOptions("tipo_sala")?>
</select>
</div>

<!-- FILTRO QUANTIDADE LUGARES -->
<div class="col-md-3">
<label for="inp-consulta-lugares-qtd" class="form-label" >N.&#xba; de Lugares</label>
<input type="number" id="inp-consulta-lugares-qtd" class="form-control" min="1" placeholder="Qualquer" name="lugares-qtd">
</div>

<!-- FILTRO QUANTIDADE MAQUINAS -->
<div class="col-md-3">
<label for="inp-consulta-maquinas-qtd" class="form-label" >N.&#xba; de Máquinas</label>
<input type="number" id="inp-consulta-maquinas-qtd" class="form-control" min="0" placeholder="Qualquer" name="maquinas-qtd">
</div>

<!-- FILTRO MAQUINA TIPO --> 

<div class="col-md-3">
<label for="inp-consulta-maquinas-tipo" class="form-label">Tipo de Máquinas</label>
<select id="inp-consulta-maquinas-tipo" class="form-select" name="maquinas-tipo">
  <option value="" selected="">Qualquer</option>
  <?php salasOptions("maquinas_tipo")?>
</select>
</div>


<!-- BOTAO BUSCAR -->
<div class="col-12" style="display: flex; align-items: center; gap:10px;">
<button type="submit" class="btn btn-primary btn-buscar" id="btn-buscar-sala-disponivel" >Buscar</button>
</div>
</form>


<?php 
    // MODAL CADASTRAR RESERVA 
    require view('partials/modals/modal_cadastrar_reserva.php');

    // MODAL ALERTA 
    require view('partials/modals/modal_alerta.php');
    
    
    //MODAL DELETAR TURMA
    require view('partials/modals/modal_deletar_turma.php');
?>
  
  <div class="container-fluid" id="container-tabela"></div>
    
    
</body>
</html>