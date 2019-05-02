<?php
  $page_title = 'Nueva Solicitud';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(5);
  $current_user = current_user();
  if ($_GET['id_cat']) {
    $categoria = find_by_id('categorias', $_GET['id_cat']);
  } else {
    $categoria = find_by_id('categorias', $_POST['categoria']);
  }
  $all_tipos = find_by_sql("SELECT * FROM tipos WHERE categoria_id='{$categoria["id"]}'");
  $grupos_trabajo = find_by_sql("SELECT * FROM usuarios WHERE grupo_id=4"); //Grupos id=4
  $estado = 1;

 if(isset($_POST['add_solicitud'])){
   //$req_fields = array('usuario_id','grupo_trabajo_id','necesidad','boceto_url', 'categoria_id','tipo_id','fecha_solicitud' ,'descripcion', 'estado_id');
   //validate_fields($req_fields);

   if(empty($errors) && $_POST['descripcion']!='' && $_POST['necesidad']!=''){
     $s_usuario_id = remove_junk($db->escape($current_user['id']));
     $s_grupo_trabajo_id = remove_junk($db->escape($_POST['grupo_trabajo']));
     $s_necesidad = remove_junk($db->escape($_POST['necesidad']));
     $s_boceto_url = remove_junk($db->escape($_FILES['boceto']['name']));
     $s_categoria_id = remove_junk($db->escape($_POST['categoria']));
     $s_tipo_id = remove_junk($db->escape($_POST['tipo']));
     $s_fecha_solicitud = date('Y-m-d');
     $s_descripcion = remove_junk($db->escape($_POST['descripcion']));
     $s_estado_id = remove_junk($db->escape($estado));
     $s_boceto_url = "";
     $s_eliminado = false;

     /*$to = '';
     $subject = 'Nuevas solicitudes que validar';
     $message = 'Tiene nuevas solicitudes para validar: ' . $s_descripcion;

      $photo = new Media();
      $error_subida = $photo->upload($_FILES['boceto']);
      $img_id = $photo->process_media();


      mail ( string $to , string $subject , string $message [, string $additional_headers [, string $additional_parameters ]] )*/

      if($img_id != false){
        $session->msg('s','Imagen subida al servidor.');
        $s_boceto_url = $img_id;
      } else{
        $session->msg('d',join($photo->errors));
        $s_boceto_url = $error_subida;
        $img_id = "Error de insercion";
      }


     $query  = "INSERT INTO solicitudes ";
     $query .= "( usuario_id,grupo_trabajo_id,necesidad,boceto_url,categoria_id,tipo_id,fecha_solicitud,descripcion,estado_id,eliminado ";
     $query .= ") VALUES (";
     $query .= " '{$s_usuario_id}', '{$s_grupo_trabajo_id}', '{$s_necesidad}', '{$s_boceto_url}', '{$s_categoria_id}', '{$s_tipo_id}', '{$s_fecha_solicitud}', '{$s_descripcion}', '{$s_estado_id}', '{$s_eliminado}' ";
     $query .= ")";
     //$query .=" ON DUPLICATE KEY UPDATE name='{$p_name}'";
     if($db->query($query)){
       /*Añadir entrada de seguimiento*/
       $last_id = $db->query("SELECT max(id) FROM solicitudes")->fetch_assoc();
       $r = $db->query("INSERT INTO seguimiento (solicitud_id, progreso_id) VALUES ('{$last_id['max(id)']}', 1)");
       $session->msg('s',"Solicitud añadida exitosamente.");
       redirect("add_solicitud.php?id_cat={$s_categoria_id}", false);
     } else {
       $session->msg('d',' Lo siento, registro falló.');
       redirect('solicitudes.php', false);
     }

   } else{
     $session->msg("d", $errors);
     redirect("add_solicitud.php?id_cat={$s_categoria_id}", false);
   }

 }

?>

<?php include_once('layouts/header.php'); ?>
<div class="row">
  <div class="col-md-12">
    <?php echo display_msg($msg); ?>
  </div>
</div>
  <div class="row">
  <div class="col-md-9">

      <div class="panel panel-default">
        <!--Pannel Heading-->
        <div class="panel-heading mb-2">
          <strong>
            <span class="glyphicon glyphicon-th"></span>
            <span>Nueva Solicitud de <?php echo $categoria['nombre']; ?></span>
         </strong>
        </div>
        <!--Panel Body-->
        <div class="panel-body">
         <div class="col-md-12">
           <!--*****************************************************FORMULARIO***********************************************************************-->
           <form class="form-horizontal bg-dark pt-5 pb-5" action="add_solicitud.php?id_cat=<?php echo $categoria['id']; ?>" method="post" enctype="multipart/form-data">

            <div class="form-group mb-4">
               <label for="grupo_trabajo" class="col-form-label col-sm-3  text-white font-weight-bold ml-5">Para: </label>
               <select class="form-control-lg" name="grupo_trabajo">
                 <?php foreach ($grupos_trabajo as $grupo): ?>
                   <option value="<?php echo $grupo['id']; ?>"><?php echo $grupo['user'] ?></option>
                 <?php endforeach; ?>
               </select>
            </div>

            <div class="form-group mb-4">
               <label for="tipo" class="col-form-label col-sm-3 text-white font-weight-bold ml-5">Tipo de proyecto: </label>
               <select class="form-control-sm" name="tipo">
                 <?php foreach ($all_tipos as $tipo): ?>
                   <option value="<?php echo $tipo['id']; ?>"><?php echo $tipo['nombre']; ?></option>
                 <?php endforeach; ?>
               </select>
            </div>

            <div class="form-group mb-4">
              <label for="necesidad" class="col-form-label col-sm-3 text-white font-weight-bold ml-5">Necesidad detectada: </label>
              <textarea class="col-sm-6 pb-5" type="text" name="necesidad" value=""></textarea>
            </div>

            <div class="form-group mb-4">
              <label for="descripcion" class="col-form-label col-sm-3  text-white font-weight-bold ml-5">Descripción detallada: </label>
              <textarea class="col-sm-6 pb-5" type="text" name="descripcion" value=""></textarea>
            </div>

            <div class="form-group mb-4">
              <label for="boceto" class="col-form-label col-sm-3  text-white font-weight-bold ml-5">Boceto: </label>
              <input class="col-sm-6 bg-light" type="file" name="boceto"/>
            </div>

            <input type="hidden" name="categoria" value="<?php echo $categoria['id'] ?>">

            <button class="btn btn-success btn-lg text-center float-right mr-5" type="submit" name="add_solicitud">ENVIAR</button>
            <br>

           </form>
           <!--*****************************************************/FORMULARIO***********************************************************************-->
         </div>
        </div>
      </div>

    </div>
  </div>

<?php include_once('layouts/footer.php'); ?>
