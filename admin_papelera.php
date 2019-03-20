<?php
  $page_title = 'Papelera';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(1);
  //$solicitudes = join_solicitudes_table();
  $current_user = current_user();
?>
<?php include_once('layouts/header.php'); ?>

<?php
    $solicitudes = join_solicitudes_table();
?>

  <h1>Papelera</h1>
  <div class="row">
     <div class="col-md-12">
       <?php echo display_msg($msg); ?>
     </div>

    <div class="col-md-11">
      <div class="panel panel-default">
        <div class="panel-heading clearfix bg-secondary">
          <!--Hueco de los buscadores-->

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
                <?php if ($solicitud['eliminado'] == true): ?>
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
                          <a href="delete_solicitud.php?id=<?php echo (int)$solicitud['id'];?>&recover=1" class="btn bg-transparent btn-lg confirm_restauracion"  title="Restaurar" data-toggle="tooltip">
                            <i class="fas fa-undo-alt text-white"></i>
                          </a>
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
