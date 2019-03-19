<?php
  $page_title = 'Edit Programas';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(5);

  $current_user = current_user();
?>
<?php include_once('layouts/header.php'); ?>

<?php
  $id = $_GET['id'];
  $usuario = find_by_id('usuarios',$id);
?>

<?php
  if (isset($_POST['cambiar_password']) && !in_array($_POST,'') && $current_user['id'] === $id) {
    $old = sha1(remove_junk($db->escape($_POST['old_password'])));
    $new = sha1(remove_junk($db->escape($_POST['new_password'])));
    $new_r = sha1(remove_junk($db->escape($_POST['new_password_repeat'])));

    if ($old === $usuario['password']) {
      if ($new === $new_r) {
        $sql = "UPDATE usuarios SET password='{$new}' WHERE id = $id";
        $result = $db->query($sql);
      } else{
        $session->msg('d',' Las contraseñas no coinciden.');
        redirect('edit_account.php', false);
      }
    } else{
      $session->msg('d',' Contraseña actual incorrecta.');
      redirect('edit_account.php', false);
    }

    if($result && $db->affected_rows() === 1){
      $session->msg('s',"Contraseña cambiada. ");
      redirect('home.php', false);
    } else {
      $session->msg('d',' Lo siento, actualización falló.');
      redirect('edit_account.php', false);
    }
  }
?>

  <h1>Cambio de Contraseña</h1>
  <div class="row">
     <div class="col-md-5 mt-5 pt-5">
       <?php echo display_msg($msg); ?>
     </div>

     <form class="" action="cambiar_password.php?id=<?php echo $id ?>" method="post">
       <input type="password" name="old_password" value="" placeholder="Contraseña actual">
       <hr/>
       <input type="password" name="new_password" value="" placeholder="Nueva Contraseña">
       <br>
       <input type="password" name="new_password_repeat" value="" placeholder="Repita la nueva contraseña">
       <br>
       <input type="submit" class="btn btn-success mt-5" name="cambiar_password" value="CAMBIAR CONTRASEÑA">
     </form>

  </div>
  <?php include_once('layouts/footer.php'); ?>
