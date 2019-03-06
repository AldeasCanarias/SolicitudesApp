<?php
  $page_title = 'Gestor de Solicitudes';

  require_once('includes/load.php');
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
<?php include_once('layouts/footer.php'); ?>
