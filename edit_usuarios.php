<?php
  $page_title = 'Edit Programas';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(1);
  //$solicitudes = join_solicitudes_table();
  $current_user = current_user();
?>
<?php include_once('layouts/header.php'); ?>

<?php
  $id = $_GET['id'];
  $usuario = find_by_id('usuarios',$id);
  $all_programas = find_all("programas");
  $all_grupos = find_all("grupos");
?>

<?php
  if (isset($_POST['edit_usuario']) && !in_array($_POST,'')) {
    $user = remove_junk($db->escape($_POST['user']));

    if ($usuario['password'] === $_POST['password'] ) {
      $password = $usuario['password'];
    } else {
      $password = sha1(remove_junk($db->escape($_POST['password'])));
    }

    $grupo_id = remove_junk($db->escape($_POST['grupo_id']));
    $programa_id = remove_junk($db->escape($_POST['programa_id']));

    $sql = "UPDATE usuarios SET user='{$user}', password='{$password}', grupo_id ={$grupo_id}, programa_id={$programa_id} WHERE id = $id";
    $result = $db->query($sql);

    if($result && $db->affected_rows() === 1){
      $session->msg('s',"Usuario editado. ");
      redirect('admin_usuarios.php', false);
    } else {
      $session->msg('d',' Lo siento, actualización falló.');
      redirect('admin_usuarios.php', false);
    }
  }
?>


  <div class="row">
     <div class="col-md-12">
       <?php echo display_msg($msg); ?>
     </div>
     <form class="" action="edit_usuarios.php?id=<?php echo $id ?>" method="post">
       <input type="text" name="user" value="<?php echo $usuario['user'] ?>" >
       <input type="text" name="password" value="<?php echo $usuario['password'] ?>" >

       <label for="grupo_id">Programa</label>
       <select class="" name="programa_id">
         <?php foreach ($all_programas as $programa): ?>
           <option value="<?php echo $programa['id'] ?>" <?php if($programa['id'] === $usuario['programa_id']): echo "selected"; endif; ?>><?php echo $programa['nombre']?></option>
         <?php endforeach; ?>
       </select>

       <label for="grupo_id">Grupo</label>
       <select class="" name="grupo_id">
         <?php foreach ($all_grupos as $grupo): ?>
           <option value="<?php echo $grupo['id'] ?>" <?php if($grupo['id'] === $usuario['grupo_id']): echo "selected"; endif; ?>><?php echo $grupo['nombre'] ?></option>
         <?php endforeach; ?>
       </select>

       <input type="submit" class="btn btn-success" name="edit_usuario" value="EDITAR">
     </form>

  </div>
  <?php include_once('layouts/footer.php'); ?>
