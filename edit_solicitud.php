<?php
  $page_title = 'Editar Solicitud';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(5);
?>
<?php
$id = $_GET['id'];
$solicitud = solicitud_info_by_id($id);
$all_tipos = find_by_sql("SELECT * FROM tipos WHERE categoria_id='{$solicitud["categoria_id"]}'");
$grupos_trabajo = find_by_sql("SELECT * FROM usuarios WHERE grupo_id=4"); //Grupos id=4
if(!$solicitud){
  $session->msg("d","Missing solicitud id.");
  redirect('solicitudes.php');
}
?>
<?php
 if(isset($_POST['edit_solicitud'])){

   if(empty($errors)){
     $s_grupo_trabajo_id = remove_junk($db->escape($_POST['grupo_trabajo']));
     $s_necesidad = remove_junk($db->escape($_POST['necesidad']));
     $s_tipo_id = remove_junk($db->escape($_POST['tipo']));
     $s_descripcion = remove_junk($db->escape($_POST['descripcion']));
     $s_cantidad = remove_junk($db->escape($_POST['cantidad']));

       $query   = "UPDATE solicitudes SET";
       $query  .=" grupo_trabajo_id ='{$s_grupo_trabajo_id}', necesidad ='{$s_necesidad}',";
       $query  .=" tipo_id ='{$s_tipo_id}', descripcion ='{$s_descripcion}', cantidad ='{$s_cantidad}' ";
       $query  .=" WHERE id ='{$solicitud['id']}'";
       $result = $db->query($query);
               if($result && $db->affected_rows() === 1){
                 $session->msg('s',"Solicitud ha sido actualizada. ");
                 redirect('solicitudes.php', false);
               } else {
                 $session->msg('d',' Lo siento, actualización falló.');
                 redirect('edit_solicitud.php?id='.$solicitud['id'], false);
               }

   } else{
       $session->msg("d", $errors);
       redirect('edit_solicitud.php?id='.$solicitud['id'], false);
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

      <div class="panel panel-default">
        <!--Pannel Heading-->
        <div class="panel-heading mb-2">
          <strong>
            <span class="glyphicon glyphicon-th"></span>
            <?php if ($solicitud['estado_id']!=1): ?>
              <span>No se puede editar esta solicitud porque ya ha sido aprobada o rechazada.</span>
            <?php endif; ?>
            <?php if ($solicitud['estado_id']==1): ?>
              <span>Editar solicitud #<?php echo $_GET['id']; ?></span>
            <?php endif; ?>
         </strong>
        </div>

        <!--Panel Body-->
        <div class="panel-body">
         <div class="col-md-12">
           <!--*****************************************************FORMULARIO***********************************************************************-->
           <?php if ($solicitud['estado_id'] == 1): ?>

             <form class="form-horizontal bg-dark pt-5 pb-5" action="edit_solicitud.php?id=<?php echo $solicitud["id"]; ?>" method="post" enctype="multipart/form-data">

              <div class="form-group mb-4">
                 <label for="grupo_trabajo" class="col-form-label col-sm-3  text-white font-weight-bold ml-5">Para: </label>
                 <select class="form-control-lg" name="grupo_trabajo">
                   <?php foreach ($grupos_trabajo as $grupo): ?>
                     <option value="<?php echo $grupo['id']; ?>" <?php if($solicitud['grupo_trabajo_id'] === $grupo['id']): echo "selected"; endif; ?>><?php echo $grupo['user'] ?></option>
                   <?php endforeach; ?>
                 </select>
              </div>

              <div class="form-group mb-4">
                 <label for="tipo" class="col-form-label col-sm-3 text-white font-weight-bold ml-5">Tipo de proyecto: </label>
                 <select class="form-control-sm" name="tipo">
                   <?php foreach ($all_tipos as $tipo): ?>
                     <option value="<?php echo $tipo['id']; ?>" <?php if($solicitud['tipo_id'] === $tipo['id']): echo "selected"; endif; ?> ><?php echo $tipo['nombre']; ?></option>
                   <?php endforeach; ?>
                 </select>
              </div>

              <div class="form-group mb-4">
                <label for="necesidad" class="col-form-label col-sm-3 text-white font-weight-bold ml-5">Necesidad detectada: </label>
                <textarea class="col-sm-6 pb-5" type="text" name="necesidad"><?php echo $solicitud['necesidad'] ?></textarea>
              </div>

              <div class="form-group mb-4">
                <label for="descripcion" class="col-form-label col-sm-3  text-white font-weight-bold ml-5">Descripción detallada: </label>
                <textarea class="col-sm-6 pb-5" type="text" name="descripcion"> <?php echo $solicitud['descripcion'] ?> </textarea>
              </div>

              <div class="form-group mb-4">
                <label for="cantidad" class="col-form-label col-sm-3  text-white font-weight-bold ml-5">Cantidad: </label>
                <input class="col-sm-1" type="number" name="cantidad" value="<?php echo $solicitud['cantidad'] ?>">
              </div>

              <input type="hidden" name="categoria" value="<?php echo $categoria['id'] ?>">

              <button class="btn btn-success btn-lg text-center float-right mr-5" type="submit" name="edit_solicitud">EDITAR</button>
              <br>

             </form>
          <?php endif; ?>

           <!--*****************************************************/FORMULARIO***********************************************************************-->
         </div>
        </div>
      </div>

    </div>
  </div>

<?php include_once('layouts/footer.php'); ?>
