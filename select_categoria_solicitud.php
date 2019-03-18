<?php
  $page_title = 'Selección de Categoria';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(5);
  $all_categorias = find_all('categorias');
?>
<?php include_once('layouts/header.php'); ?>


<div class="container col align-self-center col-md-6">
  <h1 class="text-center mb-5">Selecciona una Categoría de Solicitud</h1>
  <div class="row bg-light mt-5 d-flex justify-content-around bg-transparent text-uppercase ">
    <?php foreach ($all_categorias as $categoria): ?>
          <a class="text-white btn btn-dark mb-5 btn-lg" href="add_solicitud.php?id_cat=<?php echo $categoria["id"];?>"> <?php echo $categoria["nombre"];?> </a>
    <?php endforeach; ?>
  </div>
</div>














<?php include_once('layouts/footer.php'); ?>
