<?php
  $page_title = 'Selección de Categoria';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(5);
  $all_categorias = find_all('categorias');
?>
<?php include_once('layouts/header.php'); ?>

<div class="container">
  <ul class="list-group text-center col-md-4">
    <?php foreach ($all_categorias as $categoria): ?>
        <li class="list-group-item text-black">
          <a class="text-black" href="add_solicitud.php?id_cat=<?php echo $categoria["id"];?>"> <?php echo $categoria["nombre"];?> </a>
        </li>
    <?php endforeach; ?>
  </ul>
</div>














<?php include_once('layouts/footer.php'); ?>
