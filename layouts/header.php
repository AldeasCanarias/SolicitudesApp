<?php $user = current_user(); ?>
<!DOCTYPE html>
  <html lang="es">
    <head>
    <meta charset="utf-8">
    <title><?php if (!empty($page_title))
           echo remove_junk($page_title);
            elseif(!empty($user))
           echo ucfirst($user['name']);
            else echo "Gestor de Solicitudes";?>
    </title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker3.min.css" />
    <link rel="stylesheet" href="libs/css/main.css" />
    <link href="css/bootstrap-datetimepicker.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Abril+Fatface" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <script src="js/bootstrap-datetimepicker.min.js"></script>
  </head>
  <body class="bg-secondary">
  <?php  if ($session->isUserLoggedIn(true)): ?>
    <header class="bg-dark" id="header">
      <a href="home.php"> <div class="logo float-left bg-dark text-light font-weight-bold pl-5"><i class="fas fa-file-signature mr-2"></i> GESTOR DE SOLICITUDES</div></a>
<!--  <div class="botones d-flex flex-display-row justify-content-around">
        <a href="solicitudes.php" class="boton-top">Todas las solicitudes</a>
        <a href="select_categoria_solicitud.php" class="boton-top">Nueva Solicitud</a>
        <a href="validate_solicitudes.php" class="boton-top">Validar o Aprobar</a>
      </div>       -->

      <div class="header-content">
      <div class="float-right clearfix">
        <ul class="info-menu list-inline list-unstyled">
          <li class="profile">
            <a href="#" data-toggle="dropdown" class="toggle" aria-expanded="false">
              <img src="libs/images/user_image.png" alt="user-image" class="img-circle img-inline">
              <span><?php echo remove_junk(ucfirst($user['user'])); ?> <i class="caret"></i></span>
            </a>
            <ul class="dropdown-menu">
             <li>
                 <a href="edit_account.php" title="edit account">
                     <i class="glyphicon glyphicon-cog"></i>
                     Configuración
                 </a>
             </li>
             <li class="last">
                 <a href="logout.php">
                     <i class="glyphicon glyphicon-off"></i>
                     Salir
                 </a>
             </li>
           </ul>
          </li>
        </ul>
      </div>
     </div>
    </header>

<?php endif;?>

<div class="page">
  <div class="container-fluid">
