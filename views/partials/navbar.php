<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item" >
          <a class="nav-link <?php activeTab("index")?>" aria-current="page" href="<?php echo 'inicial' ?>">Pagina Inicial</a>
        </li>
        <li class="nav-item" >
          <a class="nav-link <?php activeTab("consultar_reserva")?>" aria-current="page" href=<?php echo ROOT_DIR. 'consulta-reservas'?>>Consultar Reserva</a>
        </li>
        <li class="nav-item" >
          <a class="nav-link <?php activeTab("cadastrar_reserva")?>" aria-current="page" href=<?php echo ROOT_DIR. 'cadastro-reservas'?>>Cadastrar Reserva</a>
        </li>
        <li class="nav-item" >
          <a class="nav-link <?php activeTab("gerenciar_turmas")?>" aria-current="page" href=<?php echo ROOT_DIR. 'gerenciamento-turmas'?>>Gerenciar Turmas</a>
        </li>
        <li class="nav-item" >
          <a class="nav-link <?php activeTab("gerenciar_salas")?>" aria-current="page" href=<?php echo ROOT_DIR. 'gerenciamento-salas'?>>Gerenciar Salas</a>
        </li>
      </ul>
    </div>
  </div>
</nav>