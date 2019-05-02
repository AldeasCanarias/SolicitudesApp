<?php
  $page_title = 'Añadir fecha limite';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(2);
?>

<?php
  $id = $_GET['id'];
  $solicitud = solicitud_info_by_id($id);
?>

<?php
 if(isset($_POST['add_fecha'])){

   if(empty($errors)){
     $fecha = $_POST['fecha_limite'];
     $id_p = $_POST['id'];

     $query   = "UPDATE solicitudes SET ";
     $query  .=" fecha_limite ='{$fecha}' ";
     $query  .=" WHERE id ='{$id_p}' ";

     $result = $db->query($query);
               if($result && $db->affected_rows() === 1){
                 $session->msg('s',"Solicitud ha sido actualizada. ");
                 redirect('validate_solicitudes.php', false);
               } else {
                 $session->msg('d',' Lo siento, actualización falló.');
                 redirect('validate_solicitudes.php', false);
               }

   } else{
       $session->msg("d", $errors);
       redirect('validate_solicitudes.php', false);
   }

 }

?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
  <div class="col-md-12">
    <?php echo display_msg($msg); ?>
  </div>
</div>
  <div class="row">
    <div class="col-md-9">

      <form class="" action="add_fecha_limite.php" method="post">
        <input type="date" name="fecha_limite" value="<?php echo $solicitud['fecha_limite'] ?>">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <button type="sumbit" name="add_fecha" class="btn btn-success">Añadir Fecha Límite</button>
      </form>

    </div>
  </div>

<?php include_once('layouts/footer.php'); ?>
