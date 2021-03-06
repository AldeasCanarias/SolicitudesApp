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
  $progreso_actual = find_progreso_by_id($seguimiento[0]['progreso_id']);
  $comentarios = find_comentarios_by_solicitud_id($id);

  $atras_validar = 0;
  if(isset($_GET['atras_validar'])){
    $atras_validar = 1;
  }

?>

<?php
  if(isset($_POST['actualizar_progreso'])){
    if ($_POST['progreso'] === '4') {
      add_fecha_fin($id, "finalizar");
    } else {
      add_fecha_fin($id, "no-finalizar");
    }
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

  if(isset($_POST['comentar'])){
    if ($_POST['comentario'] != null) {
      $c_usuario_id = $_POST['usuario_id'];
      $c_solicitud_id = $_POST['solicitud_id'];
      $c_comentario = $_POST['comentario'];

      $query = "INSERT INTO comentarios (usuario_id, solicitud_id, comentario) VALUES ('{$c_usuario_id}', '{$c_solicitud_id}', '{$c_comentario}')";
      $result = $db->query($query);

      if($result && $db->affected_rows() === 1){
          $session->msg('s',"Comentario añadido. ");
          redirect('ver_solicitud.php?id='.$c_solicitud_id, false);
      } else {
          $session->msg('d',' Lo siento, algo falló.');
          redirect('ver_solicitud.php?id='.$c_solicitud_id, false);
      }
    }
  }
?>



<a class="btn bg-transparent btn-lg" href=<?php echo $atras_validar?'validate_solicitudes.php':'solicitudes.php' ?> ><i class="fas fa-chevron-left"></i></a>
<div class="container">
    <div class="row ficha-blanca">
        <div class="col-sm-6">
          <p class="display-4">Solicitud <span class="text-dark">#<?php echo $solicitud["id"]; ?></span></p>
          <p> <span class="font-weight-bold">Descripción:</span>  <span class="text-dark"><?php echo $solicitud['descripcion']; ?></span></p>
          <p> <span class="font-weight-bold"> Necesidad detectada:</span>  <span class="text-dark"><?php echo $solicitud['necesidad']; ?></span></p>
          <p> <span class="font-weight-bold"> Solicitado por</span>  <span class="text-dark"><?php echo $solicitud['usuario']; ?></span></p>
          <p> <span class="font-weight-bold"> Encargado a</span>  <span class="text-dark"><?php echo $solicitud['grupo_trabajo']; ?></span></p>
          <p> <span class="font-weight-bold"> Clasificación:</span>  <span class="text-dark"><?php echo $solicitud['categoria']; ?> (<?php echo $solicitud["tipo"]; ?>)</span></p>
          <p> <span class="font-weight-bold"> Estado:</span>  <span class="text-dark"><?php echo $solicitud['estado']; ?></span></p>
          <p> <span class="font-weight-bold"> Fecha limite:</span>  <span class="<?php echo $solicitud['fecha_limite']?"text-danger":"text-dark"; ?>"><?php echo $solicitud['fecha_limite']?$solicitud['fecha_verificacion']:"Indeterminada"; ?></span></p>
          <br>
          <p> <span class="font-weight-bold"> Solicitado el</span>  <span class="text-dark"><?php echo $solicitud['fecha_solicitud']; ?></p>
          <p> <span class="font-weight-bold"> Verificado el</span>  <span class="text-dark"><?php echo $solicitud['fecha_verificacion']?$solicitud['fecha_verificacion']:"-"; ?></span></p>
          <p> <span class="font-weight-bold"> Aprobado el</span>  <span class="text-dark"><?php echo $solicitud['fecha_aprobacion']?$solicitud['fecha_aprobacion']:"-"; ?></span></p>
          <br>
          <p> <span class="font-weight-bold"> Finalizado el</span>  <span class="text-dark"><?php echo $solicitud['fecha_fin']?$solicitud['fecha_fin']:"-"; ?></span></p>
          <br>
        </div><!--col-->
        <div class="col-sm-6">
            <a href="uploads/images/<?php echo $solicitud['boceto_url'] ?>"> <img class="pt-5 img-fluid" src="uploads/images/<?php echo $solicitud['boceto_url'] ? $solicitud['boceto_url'] : "boceto.jpg"; ?>" alt="Boceto"></a>
        </div>


        <!--**************************************SEGUIMIENTO**********************************************-->
        <div class="d-flex flex-row justify-content-between col-sm-12">
          <div class="seguimiento">
            <?php if ($current_user['id'] === $solicitud['grupo_trabajo_id'] && $solicitud['estado_id'] === '3'): ?>
              <p> <span class="font-weight-bold"> Progreso </span></p>
              <form class="" action="ver_solicitud.php?id=<?php echo $solicitud['id'] ?>" method="post">
                <select class="" name="progreso">
                  <?php foreach ($all_progresos as $progreso): ?>
                    <option value="<?php echo $progreso['id'] ?>" <?php echo $seguimiento[0]['progreso_id'] == $progreso['id']?'selected':''; ?>><?php echo $progreso['nombre'] ?></option>
                  <?php endforeach; ?>
                </select>
                <input type="submit" class="btn btn-primary" name="actualizar_progreso">
              </form>
            <?php endif; ?>
            <?php if ($current_user['id'] != $solicitud['grupo_trabajo_id'] && $solicitud['estado_id'] === '3'): ?>
              <p> <span class="font-weight-bold"> Progreso: </span> <?php echo $progreso_actual[0]['nombre'] ?></p>
            <?php endif; ?>
          </div>

          <div class="costes">
            <?php if ($solicitud['estado_id'] == 3): ?>
              <a href="costes.php?id=<?php echo $solicitud['id']; ?>" class="font-weight-bold"><i class="fas fa-dollar-sign"></i> Tabla de costes</a>
            <?php endif; ?>
          </div>
        </div>

          <!--**************************************COMENTARIOS**********************************************-->
          <div class="lista_comentarios d-flex flex-column justify-content-between col-sm-12 border mb-3">
            <h3>Comentarios:</h3>
            <?php foreach ($comentarios as $comentario): ?>
              <div class="comentario">
                <?php $usuario_coment = find_by_id('usuarios', $comentario['usuario_id']) ?>
                <b class="text-primary"><?php echo $usuario_coment['user']; ?></b>
                <p><?php echo $comentario['comentario']; ?></p>
              </div>
            <?php endforeach; ?>
          </div>

        <?php if ($current_user['nivel'] == 2 || $current_user['nivel'] == 1): ?>
          <div class="d-flex flex-row justify-content-between col-sm-12">
            <div class="comentarios">
              <form class="form" action="ver_solicitud.php" method="post">
                <textarea class="col-sm-12 pb-5" type="text" name="comentario" value=""></textarea>
                <input type="hidden" name="solicitud_id" value="<?php echo $solicitud['id'] ?>">
                <input type="hidden" name="usuario_id" value="<?php echo $current_user['id'] ?>">
                <button type="submit" class="btn btn-primary mt-3" name="comentar">Comentar</button>
              </form>
            </div>
          </div>
        <?php endif; ?>


    </div><!--Row ficha blanca-->
</div><!--Container-->








<?php include_once('layouts/footer.php'); ?>
