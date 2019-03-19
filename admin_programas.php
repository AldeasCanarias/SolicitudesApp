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
  $all_programas = find_all('programas');

?>

<?php
  if (isset($_POST['agregar_programa']) && !in_array($_POST,'')) {
    $nombre = remove_junk($db->escape($_POST['nombre']));
    $director = remove_junk($db->escape($_POST['director']));
    $e_director = remove_junk($db->escape($_POST['email_director']));

    $sql = "INSERT INTO programas (nombre, director, email_director) VALUES ('$nombre', '$director', '$e_director')";
    $result = $db->query($sql);

    if($result && $db->affected_rows() === 1){
      $session->msg('s',"Programa añadido. ");
      redirect('admin_programas.php', false);
    } else {
      $session->msg('d',' Lo siento, actualización falló.');
      redirect('admin_programas.php', false);
    }
  }
?>

<?php
  if(isset($_GET['borrar'])){
      $sql = "DELETE FROM programas WHERE id =".$_GET['id'];
      $result = $db->query($sql);
      redirect('admin_programas.php', false);
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
              <form class="" action="admin_programas.php" method="post">
                <input type="text" name="nombre" value="" placeholder="Nombre de Programa">
                <input type="text" name="director" value=""  placeholder="Director de Programa">
                <input type="email" name="email_director" value="" step="0.01" placeholder="Contacto Director (email)">
                <input type="submit" class="btn btn-success" name="agregar_programa" value="AÑADIR">
              </form>
          </div>
        </div>
        <div class="panel-body">
          <table>
            <thead class="thead-dark">
              <tr>
                <th class="text-center"> Programa </th>
                <th class="text-center" style="width: 10%;"> Director </th>
                <th class="text-center" style="width: 10%;"> Contacto director </th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($all_programas as $programa): ?>
                <tr>
                  <td class="text-center"><?php echo $programa['nombre'] ?></td>
                  <td class="text-center"><?php echo $programa['director'] ?></td>
                  <td class="text-center"><?php echo $programa['email_director'] ?></td>
                  <td class="text-center confirm_eliminacion"><a href="admin_programas.php?id=<?php echo $programa['id'] ?>&borrar=1"><i class="fas fa-times text-danger"></i></a></td>
                  <td class="text-center"><a href="edit_programas.php?id=<?php echo $programa['id'] ?>"><i class="fas fa-edit text-primary"></i></a></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <?php include_once('layouts/footer.php'); ?>
