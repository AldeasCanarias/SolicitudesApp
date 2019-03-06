<?php
  $page_title = 'Todas las solicitudes';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(2);
  $solicitudes = join_solicitudes_table();
?>
<?php include_once('layouts/header.php'); ?>
<?php
  $search_name = "";
  $search_cat = "";
  $search_loc = "";
  if (isset($_POST["search_product"])) {
    $search_name = remove_junk($db->escape($_POST['buscar']));
    $search_cat = remove_junk($db->escape($_POST['category']));
    $search_loc = remove_junk($db->escape($_POST['location']));
    /*if($search_loc != ''){
      echo "Buscando: " . $search_location;
    }*/
    $solicitudes = find_product($search_name, $search_cat, $search_loc);
  }

?>



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
                <th class="text-center" style="width: 50px;">#</th>
                <th class="text-center"> Boceto</th>
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
                <td class="text-center"> <?php /*IMAGEN BOCETO*/ ?></td>
                <td class="text-center"> <?php echo remove_junk($solicitud['descripcion']); ?></td>
                <td class="text-center"> <?php echo remove_junk($solicitud['usuario']); ?> </td>
                <td class="text-center"> <?php echo remove_junk($solicitud['grupo_trabajo']); ?> </td>
                <td class="text-center"> <?php echo remove_junk($solicitud['estado']); ?> </td>
                <td class="text-center">
                  <div class="btn-group">
                    <a href="ver_solicitud.php?id=<?php echo (int)$solicitud['id'];?>" class="bg-transparent btn-lg"  title="Ver" data-toggle="tooltip">
                     <i class="far fa-eye text-white"></i>
                    </a>
                    <a href="edit_solicitud.php?id=<?php echo (int)$solicitud['id'];?>" class="btn bg-transparent btn-lg"  title="Editar" data-toggle="tooltip">
                      <i class="fas fa-edit text-white"></i>
                    </a>
                    <a href="delete_solicitud.php?id=<?php echo (int)$solicitud['id'];?>" class="btn bg-transparent btn-lg"  title="Eliminar" data-toggle="tooltip">
                      <i class="far fa-trash-alt text-white"></i>
                    </a>
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
