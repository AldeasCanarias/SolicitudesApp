<?php
  $page_title = 'Todas las solicitudes';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(2);
  $solicitudes = join_solicitudes_table();
?>
<?php include_once('layouts/header.php'); ?>

<?php
  $id = $_GET["id"];
  $solicitud = solicitud_info_by_id($id);
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
          <p> <span class="font-weight-bold"> Verificado el</span>  <span class="text-white"><?php echo $solicitud['fecha_aprobacion']?$solicitud['fecha_aprobacion']:"-"; ?></span></p>
          <br>
          <p> <span class="font-weight-bold"></span> Finalizado el</span>  <span class="text-white"><?php echo $solicitud['fecha_fin']?$solicitud['fecha_fin']:"-"; ?></span></p>
        </div>
        <div class="col-sm-6">
          <img class="pt-5 img-fluid" src="uploads/images/<?php echo $solicitud["boceto_url"]; ?>" alt="Boceto">
        </div>
    </div>
</div>








<?php include_once('layouts/footer.php'); ?>
