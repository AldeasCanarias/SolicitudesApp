<?php
  $page_title = 'ADMIN Programas';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(5);
  //$solicitudes = join_solicitudes_table();
  $current_user = current_user();
?>
<?php include_once('layouts/header.php'); ?>

<?php
  $usuario = find_by_id('usuario', $current_user['id']);
?>

<div class="row bg-light mt-5 d-flex justify-content-around bg-transparent text-uppercase ">

  <a class="text-white" href="cambiar_password.php?id=<?php echo $current_user['id'] ?>">
    <div class="text-center">
      <i class="fas fa-unlock-alt display-1 mb-3"></i>
      <h5>Cambiar Contraseña</h5>
    </div>
  </a>

</div>

  <?php include_once('layouts/footer.php'); ?>
