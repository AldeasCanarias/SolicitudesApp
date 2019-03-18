<?php
  $page_title = 'Ver solicitud';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(5);
   $current_user = current_user();
   $all_progresos = find_all('progreso');
?>
<?php include_once('layouts/header.php'); ?>

<?php
  $id = $_GET["id"];
  $solicitud = solicitud_info_by_id($id);
  $seguimiento = find_seguimiento_by_solicitud_id($id);
?>

<?php
  if(isset($_POST['actualizar_progreso'])){
    $query   = "UPDATE seguimiento SET";
    $query  .=" progreso_id ='{$_POST['progreso']}' ";
    $query  .=" WHERE solicitud_id ='{$solicitud['id']}'";
    $result = $db->query($query);
            if($result && $db->affected_rows() === 1){
              $session->msg('s',"Solicitud ha sido actualizada. ");
              redirect('ver_solicitud.php?id='.$solicitud['id'], false);
            } else {
              $session->msg('d',' Lo siento, actualización falló.');
              redirect('ver_solicitud.php?id='.$solicitud['id'], false);
            }
  }
?>


<a class="btn bg-transparent btn-lg" href="solicitudes.php"><i class="fas fa-chevron-left"></i></a>
<div class="container">
    <div class="row">
        <div class="col-sm-6">
          <p class="display-4">Solicitud <span class="text-white">#<?php echo $solicitud["id"]; ?></span></p>
          <p> <span class="font-weight-bold">Descripción</span>  <span class="text-white"><?php echo $solicitud['descripcion']; ?></span></p>
          <p> <span class="font-weight-bold"> Necesidad detectada</span>  <span class="text-white"><?php echo $solicitud['necesidad']; ?></span></p>
          <p> <span class="font-weight-bold"> Solicitado por</span>  <span class="text-white"><?php echo $solicitud['usuario']; ?></span></p>
          <p> <span class="font-weight-bold"> Encargado a</span>  <span class="text-white"><?php echo $solicitud['grupo_trabajo']; ?></span></p>
          <p> <span class="font-weight-bold"> Clasificación</span>  <span class="text-white"><?php echo $solicitud['categoria']; ?> (<?php echo $solicitud["tipo"]; ?>)</span></p>
          <p> <span class="font-weight-bold"> Estado</span>  <span class="text-white"><?php echo $solicitud['estado']; ?></span></p>
          <p> <span class="font-weight-bold"> Fecha limite</span>  <span class="text-white"><?php echo $solicitud['fecha_limite']?$solicitud['fecha_verificacion']:"Indeterminada"; ?></span></p>
          <br>
          <p> <span class="font-weight-bold"> Solicitado el</span>  <span class="text-white"><?php echo $solicitud['fecha_solicitud']; ?></p>
          <p> <span class="font-weight-bold"> Verificado el</span>  <span class="text-white"><?php echo $solicitud['fecha_verificacion']?$solicitud['fecha_verificacion']:"-"; ?></span></p>
          <p> <span class="font-weight-bold"> Aprobado el</span>  <span class="text-white"><?php echo $solicitud['fecha_aprobacion']?$solicitud['fecha_aprobacion']:"-"; ?></span></p>
          <br>
          <p> <span class="font-weight-bold"></span> Finalizado el</span>  <span class="text-white"><?php echo $solicitud['fecha_fin']?$solicitud['fecha_fin']:"-"; ?></span></p>
        </div>
        <div class="col-sm-6">
          <img class="pt-5 img-fluid" src="uploads/images/<?php echo $solicitud['boceto_url'] ? $solicitud['boceto_url'] : "boceto.jpg"; ?>" alt="Boceto">
        </div>


        <!--**************************************SEGUIMIENTO**********************************************-->
        <div class="seguimiento d-inline-block">
          <p> <span class="font-weight-bold"> Progreso </span></p>
          <?php if ($current_user['id'] === $solicitud['grupo_trabajo_id'] && $solicitud['estado_id'] == 3): ?>
            <form class="" action="ver_solicitud.php?id=<?php echo $solicitud['id'] ?>" method="post">
              <select class="" name="progreso">
                <?php foreach ($all_progresos as $progreso): ?>
                  <option value="<?php echo $progreso['id'] ?>" <?php echo $seguimiento[0]['progreso_id'] == $progreso['id']?'selected':''; ?>><?php echo $progreso['nombre'] ?></option>
                <?php endforeach; ?>
              </select>
              <input type="submit" class="btn btn-primary" name="actualizar_progreso">
            </form>
          <?php endif; ?>
        </div>

        <div class="costes">
          <a href="costes.php?id=<?php echo $solicitud['id']; ?>">Tabla de costes</a>
        </div>
    </div>

</div>








<?php include_once('layouts/footer.php'); ?>
