<?php
  $page_title = 'ADMIN Programas';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(1);
  //$solicitudes = join_solicitudes_table();
  $current_user = current_user();
?>
<?php include_once('layouts/header.php'); ?>

<?php
  $all_usuarios = join_usuarios_table();
  $all_programas = find_all("programas");
  $all_grupos = find_all("grupos");
?>

<?php
  if (isset($_POST['agregar_usuario']) && !in_array($_POST,'')) {
    $user = remove_junk($db->escape($_POST['user']));
    $password = sha1(remove_junk($db->escape($_POST['password'])));
    $grupo_id = remove_junk($db->escape($_POST['grupo_id']));
    $programa_id = remove_junk($db->escape($_POST['programa_id']));

    $sql = "INSERT INTO usuarios (user, password, grupo_id, programa_id) VALUES ('$user', '$password', '$grupo_id', '$programa_id')";
    $result = $db->query($sql);

    if($result && $db->affected_rows() === 1){
      $session->msg('s',"Usuario añadido. ");
      redirect('admin_usuarios.php', false);
    } else {
      $session->msg('d',' Lo siento, actualización falló.');
      redirect('admin_usuarios.php', false);
    }
  }
?>

<?php
  if(isset($_GET['borrar'])){
      $sql = "DELETE FROM usuarios WHERE id =".$_GET['id'];
      $result = $db->query($sql);
      redirect('admin_usuarios.php', false);
  }
?>



  <div class="row">
     <div class="col-md-12">
       <?php echo display_msg($msg); ?>
     </div>

    <div class="col-md-11">
      <div class="panel panel-default">
        <div class="panel-heading clearfix bg-secondary">
          <!--Hueco de los buscadores-->
          <div class="float-right clearfix row">
              <form class="" action="admin_usuarios.php" method="post">
                <input type="text" name="user" value="" placeholder="Nombre de Usuario">
                <input type="password" name="password" value=""  placeholder="Contraseña">

                <label for="grupo_id">Programa</label>
                <select class="" name="programa_id">
                  <?php foreach ($all_programas as $programa): ?>
                    <option value="<?php echo $programa['id'] ?>"><?php echo $programa['nombre'] ?></option>
                  <?php endforeach; ?>
                </select>

                <label for="grupo_id">Grupo</label>
                <select class="" name="grupo_id">
                  <?php foreach ($all_grupos as $grupo): ?>
                    <option value="<?php echo $grupo['id'] ?>"><?php echo $grupo['nombre'] ?></option>
                  <?php endforeach; ?>
                </select>

                <input type="submit" class="btn btn-success" name="agregar_usuario" value="AÑADIR">
              </form>
          </div>
        </div>
        <div class="panel-body">
          <table>
            <thead class="thead-dark">
              <tr>
                <th class="text-center"> Nombre de Usuario </th>
                <th class="text-center" style="width: 10%;"> Programa </th>
                <th class="text-center" style="width: 10%;"> Grupo </th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($all_usuarios as $usuario): ?>
                <tr>
                  <td class="text-center"><?php echo $usuario['user'] ?></td>
                  <td class="text-center"><?php echo $usuario['programa'] ?></td>
                  <td class="text-center"><?php echo $usuario['grupo'] ?></td>
                  <td class="text-center confirm_eliminacion"><a href="admin_usuarios.php?id=<?php echo $usuario['id'] ?>&borrar=1"><i class="fas fa-times text-danger"></i></a></td>
                  <td class="text-center"><a href="edit_usuarios.php?id=<?php echo $usuario['id'] ?>"><i class="fas fa-edit text-primary"></i></a></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <?php include_once('layouts/footer.php'); ?>
