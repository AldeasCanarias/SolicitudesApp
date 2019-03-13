<?php
  $page_title = 'Gestor de Solicitudes';

  require_once('includes/load.php');
  $current_user = current_user();

  if (!$session->isUserLoggedIn(true)) { redirect('index.php', false);}
?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
  <div class="col-md-12">
  </div>
 <div class="col-md-12">
    <div class="panel">
      <div class="jumbotron text-center">
         <h1>Gestor de Solicitudes</h1>
      </div>
    </div>
 </div>
</div>

<div class="row bg-light mt-5 d-flex justify-content-around bg-transparent text-uppercase ">

  <a class="text-white" href="solicitudes.php">
    <div class="text-center">
      <i class="fas fa-book-open display-1 mb-3"></i>
      <h5>Todas las Solicitudes</h5>
    </div>
  </a>

  <?php if ($current_user['nivel'] != 4) { ?>
    <a class="text-white" href="select_categoria_solicitud.php">
      <div class="text-center">
        <i class="fas fa-plus display-1 mb-3"></i>
        <h5>Nueva Solicitud</h5>
      </div>
    </a>
  <?php } ?>

  <?php if ($current_user['nivel'] <= 3) { ?>
    <a class="text-white" href="#">
      <div class="text-center">
        <i class="fas fa-check-square display-1 mb-3"></i>
        <h5>Validar Solicitud</h5>
        <h6>(Directores)</h6>
      </div>
    </a>
  <?php } ?>


  <?php if ($current_user['nivel'] <= 2) { ?>
    <a class="text-white" href="#">
      <div class="text-center">
        <i class="fas fa-thumbs-up display-1 mb-3"></i>
        <h5>Aprobar Solicitud</h5>
        <h6>(Dir. Territorial)</h6>
      </div>
    </a>
  <?php } ?>
</div>


<?php if ($current_user['nivel'] == 1) { ?>
  <div class="row bg-light mt-5 d-flex flex-column justify-content-around bg-transparent text-uppercase">
    <div class="text-center">
      <h4 class="mb-4">Area de Administrador</h4>
    </div>
    <div class="d-flex mt-4 justify-content-around">
      <a class="text-white" href="#">
        <div class="text-center">
          <i class="fas fa-user display-1 mb-3"></i>
          <h5>Administrar Usuarios</h5>
        </div>
      </a>

      <a class="text-white" href="#">
        <div class="text-center">
          <i class="fas fa-users display-1 mb-3"></i>
          <h5>Administrar Grupos</h5>
        </div>
      </a>

      <a class="text-white" href="#">
        <div class="text-center">
        <i class="fas fa-building display-1 mb-3"></i>
          <h5>Administrar Programas</h5>
        </div>
      </a>

    </div>
  </div>
<?php } ?>
<?php include_once('layouts/footer.php'); ?>
