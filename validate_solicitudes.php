<?php
  $page_title = 'Validar solicitudes';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(3);
  //$solicitudes = join_solicitudes_table();
  $current_user = current_user();
?>
<?php include_once('layouts/header.php'); ?>
<?php
  if (isset($_POST["solo_sin_validar"])) {
    $solicitudes = find_solicitudes_by_estado_id(1);
  } else{
    $solicitudes = join_solicitudes_table();
  }

  if (isset($_GET['id'])) {
    $query   = "UPDATE solicitudes SET ";
    if(isset($_GET['validar'])){
      if($_GET['validar'] == 1){
        $query  .=" estado_id = 2 ";
        add_fechas_validacion($_GET['id'], 'validar');
      } else {
        $query  .=" estado_id = 1 ";
        add_fechas_validacion($_GET['id'], 'desvalidar');
      }
    }
    if(isset($_GET['aprobar'])){
      if ($_GET['aprobar'] == 1) {
        $query  .=" estado_id = 3 ";
        add_fechas_validacion($_GET['id'], 'aprobar');
      } else {
        $query  .=" estado_id = 2 ";
        add_fechas_validacion($_GET['id'], 'desaprobar');
      }
    }
    $query  .=" WHERE id ='{$_GET['id']}'";
    $result = $db->query($query);

    if($result && $db->affected_rows() === 1){
      $session->msg('s',"Solicitud ha sido actualizada. ");
      redirect('validate_solicitudes.php', false);
    } else {
      $session->msg('d',' Lo siento, actualización falló.');
      redirect('validate_solicitudes.php?id='.$solicitud['id'], false);
    }
  }



?>
  <div class="float-right">
    <?php if ($current_user['nivel'] != 4): ?>
      <form class="" action="validate_solicitudes.php" method="post">
        <?php if (!isset($_POST["solo_sin_validar"])): ?>
          <input type="submit" class="btn btn-success" name="solo_sin_validar" value="Mostrar sólo sin validar">
        <?php endif; ?>
        <?php if (isset($_POST["solo_sin_validar"])): ?>
          <input type="submit" class="btn btn-success" name="todo" value="Mostrar todo">
        <?php endif; ?>
      </form>
    <?php endif; ?>
  </div>


  <div class="row">
     <div class="col-md-12">
       <?php echo display_msg($msg); ?>
     </div>

    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading clearfix bg-secondary">
          <!--Hueco de los buscadores-->
          <pre><?php //var_dump($solicitudes) ?></pre>
        </div>
        <div class="panel-body">
          <table class="table table-striped table-dark table-hover">
            <thead class="thead-dark">
              <tr>
                <th class="text-center" style="width: 50px;">ID</th>
                <th class="text-center"> Descripción </th>
                <th class="text-center" style="width: 10%;"> De: </th>
                <th class="text-center" style="width: 10%;"> Para: </th>
                <th class="text-center" style="width: 10%;">Estado </th>
                <th class="text-center" style="width: 100px;">  </th>
              </tr>
            </thead>
            <tbody>
              <?php
              foreach ($solicitudes as $solicitud):?>
              <tr>
                <td class="text-center"> <?php echo remove_junk($solicitud['id']); ?></td>
                <td class="text-center"> <?php echo remove_junk($solicitud['descripcion']); ?></td>
                <td class="text-center"> <?php echo remove_junk($solicitud['usuario']); ?> </td>
                <td class="text-center"> <?php echo remove_junk($solicitud['grupo_trabajo']); ?> </td>
                <?php
                  $color_estado = "";
                  if ($solicitud['estado_id'] == 1) {
                    $color_estado = "text-danger";
                  } else if ($solicitud['estado_id'] == 2) {
                    $color_estado = "text-primary";
                  } else {
                    $color_estado = "text-success";
                  }
                ?>
                <td class="text-center <?php echo $color_estado ?>"> <?php echo remove_junk($solicitud['estado']); ?> </td>
                <td class="text-center">
                  <div class="btn-group">
                    <?php if ($solicitud['estado_id'] == 1): ?>
                      <a class="<?php echo $current_user['nivel'] == 2 ? "dir_terr":""; ?> bg-transparent btn-lg" href="validate_solicitudes.php?id=<?php echo (int)$solicitud['id'];?>&validar=1"  title="Validar" data-toggle="tooltip">
                       <i class="far fa-check-square text-danger"></i>
                      </a>
                    <?php endif; ?>
                    <?php if ($solicitud['estado_id'] == 2): ?>
                      <a href="validate_solicitudes.php?id=<?php echo (int)$solicitud['id'];?>&validar=0" class="bg-transparent btn-lg"  title="Desvalidar" data-toggle="tooltip">
                       <i class="far fa-check-square text-primary"></i>
                      </a>
                    <?php endif; ?>
                    <?php if ($current_user['nivel'] == 2 || $current_user['nivel'] == 1): ?>
                      <?php if ($solicitud['estado_id'] == 2): ?>
                        <a href="validate_solicitudes.php?id=<?php echo (int)$solicitud['id'];?>&aprobar=1" class="bg-transparent btn-lg"  title="Aprobar" data-toggle="tooltip">
                         <i class="fas fa-thumbs-up text-danger"></i>
                        </a>
                      <?php endif; ?>
                      <?php if ($solicitud['estado_id'] == 3): ?>
                        <a href="validate_solicitudes.php?id=<?php echo (int)$solicitud['id'];?>&aprobar=0" class="bg-transparent btn-lg"  title="Desaprobar" data-toggle="tooltip">
                         <i class="fas fa-thumbs-up text-success"></i>
                        </a>
                      <?php endif; ?>
                    <?php endif; ?>
                  </div>
                </td>
              </tr>
             <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <?php include_once('layouts/footer.php'); ?>
