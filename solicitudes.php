<?php
  $page_title = 'Todas las solicitudes';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(5);
  //$solicitudes = join_solicitudes_table();
  $current_user = current_user();
?>
<?php include_once('layouts/header.php'); ?>
<?php
  if (isset($_POST["solo_user"])) {
    $solicitudes = find_solicitudes_by_user_id($current_user['id']);
  } else if ($current_user['nivel'] == 4) {
    $solicitudes = find_solicitudes_by_grupo_trabajo($current_user['id']);
  } else {
    $solicitudes = join_solicitudes_table();
  }

?>


<h1>Solicitudes</h1>
  <div class="row">
     <div class="col-md-12">
       <?php echo display_msg($msg); ?>
     </div>

    <div class="col-md-11">
      <div class="panel panel-default">
        <div class="panel-heading clearfix bg-secondary">
          <!--Hueco de los buscadores-->
          <div class="float-right clearfix row">
            <?php if ($current_user['nivel'] != 4): ?>
              <form class="" action="solicitudes.php" method="post">
                <?php if (!isset($_POST["solo_user"])): ?>
                  <input type="submit" class="btn btn-success" name="solo_user" value="Mostrar solo mis solicitudes">
                <?php endif; ?>
                <?php if (isset($_POST["solo_user"])): ?>
                  <input type="submit" class="btn btn-success" name="todo" value="Mostrar todo">
                <?php endif; ?>
              </form>
            <?php endif; ?>
          </div>
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
                <?php if ($solicitud['eliminado'] == false): ?>
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
                        <a href="ver_solicitud.php?id=<?php echo (int)$solicitud['id'];?>" class="bg-transparent btn-lg"  title="Ver" data-toggle="tooltip">
                         <i class="far fa-eye text-white"></i>
                        </a>
                        <?php if ($solicitud['usuario'] === find_user_by_id($current_user['id'])['user']): ?>
                          <a href="edit_solicitud.php?id=<?php echo (int)$solicitud['id'];?>" class="btn bg-transparent btn-lg"  title="Editar" data-toggle="tooltip">
                            <i class="fas fa-edit text-white"></i>
                          </a>
                          <a href="delete_solicitud.php?id=<?php echo (int)$solicitud['id'];?>" class="btn bg-transparent btn-lg confirm_eliminacion"  title="Eliminar" data-toggle="tooltip">
                            <i class="far fa-trash-alt text-white"></i>
                          </a>
                        <?php endif; ?>
                      </div>
                    </td>
                  </tr>
                <?php endif; ?>
             <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <?php include_once('layouts/footer.php'); ?>
