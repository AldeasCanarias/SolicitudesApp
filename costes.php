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
  $id = $_GET["id"];
  $costes = find_costes_by_solicitud_id($id);
  $solicitud = solicitud_info_by_id($id);
  //Consulta de Coste Total!!
?>

<?php
  if (isset($_POST['agregar_coste']) && $_POST['concepto'] != '') {
    $concepto = remove_junk($db->escape($_POST['concepto']));
    $cantidad = $_POST['cantidad']?remove_junk($db->escape($_POST['cantidad'])):0;
    $p_unidad = $_POST['precio_unidad']?(float)remove_junk($db->escape($_POST['precio_unidad'])):0;
    $p_total = (float)$cantidad * (float)$p_unidad;

    $sql = "INSERT INTO costes (solicitud_id, concepto, cantidad, precio_unidad, precio_total) VALUES ($id, '$concepto', $cantidad, $p_unidad, $p_total)";
    $result = $db->query($sql);

    if($result && $db->affected_rows() === 1){
      $session->msg('s',"Coste añadido. ");
      redirect('costes.php?id='.$id, false);
    } else {
      $session->msg('d',' Lo siento, actualización falló.');
      redirect('costes.php?id='.$id, false);
    }
  }
?>

<?php
  if(isset($_GET['borrar'])){
      $sql = "DELETE FROM costes WHERE id =".$_GET['borrar'];
      $result = $db->query($sql);
      redirect('costes.php?id='.$id, false);
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
            <?php if ($current_user['user']==$solicitud['grupo_trabajo']): ?>
              <form class="" action="costes.php?id=<?php echo $id ?>" method="post">
                <input type="text" name="concepto" value="" placeholder="Concepto">
                <input type="number" name="cantidad" value=""  placeholder="Cantidad">
                <input type="number" name="precio_unidad" value="" step="0.01" placeholder="Precio/Unidad">

                <input type="submit" class="btn btn-success" name="agregar_coste" value="AÑADIR">
              </form>
            <?php endif; ?>
          </div>
        </div>
        <div class="panel-body">
          <table>
            <thead class="thead-dark">
              <tr>
                <th class="text-center"> Concepto </th>
                <th class="text-center" style="width: 10%;"> Cantidad</th>
                <th class="text-center" style="width: 10%;"> Precio Unidad </th>
                <th class="text-center" style="width: 10%;"> Precio Total </th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($costes as $coste): ?>
                <tr>
                  <td class="text-center"><?php echo $coste['concepto'] ?></td>
                  <td class="text-center"><?php echo $coste['cantidad'] ?></td>
                  <td class="text-center"><?php echo $coste['precio_unidad'] ?> €</td>
                  <td class="text-center"><?php echo $coste['precio_total'] ?> €</td>
                  <?php if ($current_user['user']==$solicitud['grupo_trabajo']): ?>
                    <td class="text-center"><a href="costes.php?id=<?php echo $id ?>&borrar=<?php echo $coste['id'] ?>"><i class="fas fa-times text-danger"></i></a></td>
                  <?php endif; ?>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <?php include_once('layouts/footer.php'); ?>
