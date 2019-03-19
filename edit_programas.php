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
  $programa = find_by_id('programas',$id);

?>

<?php
  if (isset($_POST['edit_programa']) && !in_array($_POST,'')) {
    $nombre = remove_junk($db->escape($_POST['nombre']));
    $director = remove_junk($db->escape($_POST['director']));
    $e_director = remove_junk($db->escape($_POST['email_director']));

    $sql = "UPDATE programas SET nombre='{$nombre}', director='{$director}', email_director ='{$e_director}' WHERE id = $id";
    $result = $db->query($sql);

    if($result && $db->affected_rows() === 1){
      $session->msg('s',"Programa editado. ");
      redirect('admin_programas.php', false);
    } else {
      $session->msg('d',' Lo siento, actualización falló.');
      redirect('admin_programas.php', false);
    }
  }
?>




  <div class="row">
     <div class="col-md-12">
       <?php echo display_msg($msg); ?>
     </div>

    <form class="" action="edit_programas.php?id=<?php echo $programa['id'] ?>" method="post">
      <input type="text" name="nombre" value="<?php echo $programa['nombre'] ?>" placeholder="Nombre de Programa">
      <input type="text" name="director" value="<?php echo $programa['director'] ?>"  placeholder="Director de Programa">
      <input type="email" name="email_director" value="<?php echo $programa['email_director'] ?>" placeholder="Contacto Director (email)">
      <input type="submit" class="btn btn-success" name="edit_programa" value="Editar">
    </form>

  </div>
  <?php include_once('layouts/footer.php'); ?>
