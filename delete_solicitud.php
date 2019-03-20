<?php
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(5);
?>
<?php
  $solicitud = find_by_id('solicitudes',(int)$_GET['id']);
  if(!$solicitud){
    $session->msg("d","ID vacío");
    redirect('solicitudes.php');
  }
?>
<?php
  //$delete_id = delete_by_id('solicitudes', (int)$solicitud['id']);
  if ($_GET['recover'] === '1') {
    $delete_id = swap_eliminado($_GET['id'],true);
  } else {
    $delete_id = swap_eliminado($_GET['id'],false);
  }

  if($delete_id){
      $session->msg("s","Solicitud eliminada");
      redirect('solicitudes.php');
  } else {
      $session->msg("d","Eliminación falló");
      redirect('solicitudes.php');
  }
?>
