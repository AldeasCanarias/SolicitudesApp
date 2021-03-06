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
  $coste_total = calcular_coste_total_by_id($id);
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


<h1>Costes</h1>
  <div class="row">
     <div class="col-md-12">
       <?php echo display_msg($msg); ?>
     </div>
    <a class="btn bg-transparent btn-lg" href="ver_solicitud.php?id=<?php echo $id ?>"><i class="fas fa-chevron-left"></i></a>
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
        <div class="panel-body div-costes">
          <table class="table table-borderless">
            <thead class="thead-dark mb-5">
              <tr>
                <th class="text-center"> Concepto </th>
                <th class="text-right pr-3" style="width: 10%;"> Cantidad</th>
                <th class="text-right pr-3" style="width: 10%;"> Precio Unidad </th>
                <th class="text-right pr-3" style="width: 10%;"> Precio Total </th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($costes as $coste): ?>
                <tr>
                  <td class="text-center"><?php echo $coste['concepto'] ?></td>
                  <td class="text-right pr-3"><?php echo $coste['cantidad'] ?></td>
                  <td class="text-right pr-3"><?php echo $coste['precio_unidad'] ?> €</td>
                  <td class="text-right pr-3"><?php echo $coste['precio_total'] ?> €</td>
                  <?php if ($current_user['user']==$solicitud['grupo_trabajo']): ?>
                    <td class="text-center confirm_eliminacion"><a href="costes.php?id=<?php echo $id ?>&borrar=<?php echo $coste['id'] ?>"><i class="fas fa-times text-danger"></i></a></td>
                  <?php endif; ?>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
          <div class="float-right">
            <hr/>
            <p>Total: <?php echo number_format($coste_total[0]['total'], 2, ',', ' '); ?> €</p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php include_once('layouts/footer.php'); ?>
