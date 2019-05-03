<?php
  require_once('includes/load.php');

/*--------------------------------------------------------------*/
/* Function for find all database table rows by table name
/*--------------------------------------------------------------*/
function find_all($table) {
   global $db;
   if(tableExists($table))
   {
     return find_by_sql("SELECT * FROM ".$db->escape($table));
   }
}




/*--------------------------------------------------------------*/
/* Function for Perform queries
/*--------------------------------------------------------------*/
function find_by_sql($sql)
{
  global $db;
  $result = $db->query($sql);
  $result_set = $db->while_loop($result);
 return $result_set;
}




/*--------------------------------------------------------------*/
/*  Function for Find data from table by id
/*--------------------------------------------------------------*/
function find_by_id($table,$id)
{
  global $db;
  $id = (int)$id;
    if(tableExists($table)){
          $sql = $db->query("SELECT * FROM {$db->escape($table)} WHERE id='{$db->escape($id)}' LIMIT 1");
          if($result = $db->fetch_assoc($sql))
            return $result;
          else
            return null;
     }
}




/*--------------------------------------------------------------*/
/* Function for Delete data from table by id
/*--------------------------------------------------------------*/
function delete_by_id($table,$id)
{
  global $db;
  if(tableExists($table))
   {
    $sql = "DELETE FROM ".$db->escape($table);
    $sql .= " WHERE id=". $db->escape($id);
    $sql .= " LIMIT 1";
    $db->query($sql);
    return ($db->affected_rows() === 1) ? true : false;
   }
}




/*--------------------------------------------------------------*/
/* Function for Count id  By table name
/*--------------------------------------------------------------*/
function count_by_id($table){
  global $db;
  if(tableExists($table))
  {
    $sql    = "SELECT COUNT(id) AS total FROM ".$db->escape($table);
    $result = $db->query($sql);
     return($db->fetch_assoc($result));
  }
}




/*--------------------------------------------------------------*/
/* Determine if database table exists
/*--------------------------------------------------------------*/
function tableExists($table){
  global $db;
  $table_exit = $db->query('SHOW TABLES FROM '.DB_NAME.' LIKE "'.$db->escape($table).'"');
      if($table_exit) {
        if($db->num_rows($table_exit) > 0)
              return true;
         else
              return false;
      }
  }




 /*--------------------------------------------------------------*/
 /* Login with the data provided in $_POST,
 /* coming from the login form.
/*--------------------------------------------------------------*/
  function authenticate($username='', $password='') {
    global $db;
    $username = $db->escape($username);
    $password = $db->escape($password);
    $sql  = sprintf("SELECT id,user,password,grupo_id,programa_id FROM usuarios WHERE user ='%s' LIMIT 1", $username);
    $result = $db->query($sql);
    if($db->num_rows($result)){
      $user = $db->fetch_assoc($result);
      $password_request = sha1($password);
      if($password_request === $user['password'] ){
        return $user['id'];
      }
    }
   return false;
  }




  /*--------------------------------------------------------------*/
  /* Login with the data provided in $_POST,
  /* coming from the login_v2.php form.
  /* If you used this method then remove authenticate function.
 /*--------------------------------------------------------------*/
   function authenticate_v2($username='', $password='') {
     global $db;
     $username = $db->escape($username);
     $password = $db->escape($password);
     $sql  = sprintf("SELECT id,user,password,grupo_id,programa_id FROM usuarios WHERE user ='%s' LIMIT 1", $username);
     $result = $db->query($sql);
     if($db->num_rows($result)){
       $user = $db->fetch_assoc($result);
       $password_request = sha1($password);
       if($password_request === $user['password'] ){
         return $user;
       }
     }
    return false;
   }




   /*--------------------------------------------------------------*/
   /* Find all user info by id
   /*--------------------------------------------------------------*/
   function find_user_by_id($user_id){
     global $db;
     $id = (int)$user_id;
       if(tableExists('usuarios')){
             $sql =  " SELECT u.id, u.user, g.nombre as grupo, u.grupo_id, g.nivel as nivel, p.nombre as programa, p.director as director, p.email_director as email_director ";
             $sql .= " FROM usuarios u ";
             $sql .= " LEFT JOIN programas p ON p.id = u.programa_id ";
             $sql .= " LEFT JOIN grupos g ON g.id = u.grupo_id ";
             $sql .= " WHERE u.id='{$db->escape($id)}' LIMIT 1 ";
             $result = $db->query($sql);
             if($usuario = $db->fetch_assoc($result))
               return $usuario;
             else
               return null;
        }
   }




  /*--------------------------------------------------------------*/
  /* Find current log in user by session id
  /*--------------------------------------------------------------*/
  function current_user(){
      static $current_user;
      global $db;
      if(!$current_user){
         if(isset($_SESSION['user_id'])):
             $user_id = intval($_SESSION['user_id']);
             $current_user = find_user_by_id($user_id);
        endif;
      }
    return $current_user;
  }




  /*--------------------------------------------------------------*/
  /* Find all user by
  /* Joining users table and user gropus table
  /*--------------------------------------------------------------*/
  function find_all_user(){
      global $db;
      $results = array();
      $sql = "SELECT u.id,u.name,u.username,u.user_level,u.status,u.last_login,";
      $sql .="g.group_name ";
      $sql .="FROM users u ";
      $sql .="LEFT JOIN user_groups g ";
      $sql .="ON g.group_level=u.user_level ORDER BY u.name ASC";
      $result = find_by_sql($sql);
      return $result;
  }




  /*--------------------------------------------------------------*/
  /* Function to update the last log in of a user
  /*--------------------------------------------------------------*/
 function updateLastLogIn($user_id)
	{
		global $db;
    $date = make_date();
    $sql = "UPDATE usuarios SET last_login='{$date}' WHERE id ='{$user_id}' LIMIT 1";
    $result = $db->query($sql);
    return ($result && $db->affected_rows() === 1 ? true : false);
	}




  /*--------------------------------------------------------------*/
  /* Find all Group name
  /*--------------------------------------------------------------*/
  function find_by_groupName($val)
  {
    global $db;
    $sql = "SELECT group_name FROM user_groups WHERE group_name = '{$db->escape($val)}' LIMIT 1 ";
    $result = $db->query($sql);
    return($db->num_rows($result) === 0 ? true : false);
  }




  /*--------------------------------------------------------------*/
  /* Find group level
  /*--------------------------------------------------------------*/
  function find_by_groupLevel($level)
  {
    global $db;
    $sql = "SELECT nivel FROM grupos WHERE nivel = '{$db->escape($level)}' LIMIT 1 ";
    $result = $db->query($sql);
    return($db->num_rows($result) === 0 ? true : false);
  }




  /*--------------------------------------------------------------*/
  /* Function for cheaking which user level has access to page
  /*--------------------------------------------------------------*/
   function page_require_level($require_level){
     global $session;
     $current_user = current_user();
     $login_level = find_by_groupLevel($current_user['nivel']);
     //if user not login
     if (!$session->isUserLoggedIn(true)):
            $session->msg('d','Por favor Iniciar sesión...');
            redirect('index.php', false);
      //if Group status Deactive
     elseif($login_level['group_status'] === '0'):
           $session->msg('d','Este nivel de usaurio esta inactivo!');
           redirect('home.php',false);
      //cheackin log in User level and Require level is Less than or equal to
     elseif($current_user['nivel'] <= (int)$require_level):
              return true;
      else:
            $session->msg("d", "¡Lo siento!  no tienes permiso para ver la página.");
            redirect('home.php', false);
        endif;

     }




   /*--------------------------------------------------------------*/
   /* Retorna todos los datos relacionados con todas las SOLICITUDES
   /* JOIN con todas las tablas relacionadas
   /*--------------------------------------------------------------*/
  function join_solicitudes_table(){
    global $db;

    $sql =  " SELECT s.id, s.necesidad, s.boceto_url, s.fecha_solicitud, s.cantidad, s.fecha_verificacion, s.fecha_aprobacion, s.descripcion, s.fecha_limite, s.fecha_fin, s.estado_id, s.eliminado, ";
    $sql  .=" us.user as usuario, gt.user as grupo_trabajo, ";
    $sql  .=" c.nombre as categoria, t.nombre as tipo, e.nombre as estado ";
    $sql  .=" FROM solicitudes s ";
    $sql  .=" LEFT JOIN usuarios us ON us.id = s.usuario_id ";
    $sql  .=" LEFT JOIN usuarios gt ON gt.id = s.grupo_trabajo_id ";
    $sql  .=" LEFT JOIN categorias c ON c.id = s.categoria_id ";
    $sql  .=" LEFT JOIN tipos t ON t.id = s.tipo_id ";
    $sql  .=" LEFT JOIN estado e ON e.id = s.estado_id ";
    $sql  .=" ORDER BY s.id DESC ";

    return find_by_sql($sql);
  }




  /*--------------------------------------------------------------*/
  /* Retorna todos los datos relacionados con todos los USUARIOS
  /* JOIN con todas las tablas relacionadas
  /*--------------------------------------------------------------*/
  function join_usuarios_table(){
    global $db;

    $sql =  " SELECT u.id, u.user, u.programa_id, u.grupo_id, u.password, ";
    $sql  .=" p.nombre as programa, g.nombre as grupo, g.nivel as nivel ";
    $sql  .=" FROM usuarios u ";
    $sql  .=" LEFT JOIN programas p ON p.id = u.programa_id ";
    $sql  .=" LEFT JOIN grupos g ON g.id = u.grupo_id ";
    $sql  .=" ORDER BY u.id DESC ";

    return find_by_sql($sql);
  }




  /*--------------------------------------------------------------*/
  /* Retorna todos los datos relacionados con las SOLICITUDES asociadas
  /* a un GRUPO DE TRABAJO
  /* JOIN con todas las tablas relacionadas
  /*--------------------------------------------------------------*/
  function find_solicitudes_by_grupo_trabajo($id){
     global $db;

     $sql =  " SELECT s.id, s.grupo_trabajo_id, s.necesidad, s.cantidad, s.estado_id, s.boceto_url, s.fecha_solicitud, s.fecha_verificacion, s.fecha_aprobacion, s.descripcion, s.fecha_limite, s.fecha_fin, s.eliminado, ";
     $sql  .=" us.user as usuario, gt.user as grupo_trabajo, ";
     $sql  .=" c.nombre as categoria, t.nombre as tipo, e.nombre as estado ";
     $sql  .=" FROM solicitudes s ";
     $sql  .=" LEFT JOIN usuarios us ON us.id = s.usuario_id ";
     $sql  .=" LEFT JOIN usuarios gt ON gt.id = s.grupo_trabajo_id ";
     $sql  .=" LEFT JOIN categorias c ON c.id = s.categoria_id ";
     $sql  .=" LEFT JOIN tipos t ON t.id = s.tipo_id ";
     $sql  .=" LEFT JOIN estado e ON e.id = s.estado_id ";
     $sql  .=" WHERE s.grupo_trabajo_id='$id' ";
     $sql  .=" ORDER BY s.id DESC ";

     return find_by_sql($sql);
  }




  /*--------------------------------------------------------------*/
  /* Retorna todos los datos relacionados la SOLICITUD con id = $id
  /* JOIN con todas las tablas relacionadas
  /*--------------------------------------------------------------*/
  function solicitud_info_by_id($id){
     global $db;

     $sql =  " SELECT s.id, s.categoria_id, s.estado_id, s.grupo_trabajo_id, s.tipo_id, s.necesidad, s.cantidad, s.boceto_url, s.fecha_solicitud, s.fecha_verificacion, s.fecha_aprobacion, s.descripcion, s.fecha_limite, s.fecha_fin, ";
     $sql  .=" us.user as usuario, gt.user as grupo_trabajo, ";
     $sql  .=" c.nombre as categoria, t.nombre as tipo, e.nombre as estado ";
     $sql  .=" FROM solicitudes s ";
     $sql  .=" LEFT JOIN usuarios us ON us.id = s.usuario_id ";
     $sql  .=" LEFT JOIN usuarios gt ON gt.id = s.grupo_trabajo_id ";
     $sql  .=" LEFT JOIN categorias c ON c.id = s.categoria_id ";
     $sql  .=" LEFT JOIN tipos t ON t.id = s.tipo_id ";
     $sql  .=" LEFT JOIN estado e ON e.id = s.estado_id ";
     $sql  .=" WHERE s.id='$id' ";
     $sql  .=" ORDER BY s.id DESC LIMIT 1";

     $result = $db->query($sql);
     $solicitud = $db->fetch_assoc($result);
     return $solicitud;
    }




  /*--------------------------------------------------------------*/
  /* Retorna todos los datos relacionados con las SOLICITUDES
  /* con un estado = $estado_id
  /* JOIN con todas las tablas relacionadas
  /*--------------------------------------------------------------*/
  function find_solicitudes_by_estado_id($estado_id){
    global $db;

    $sql =  " SELECT s.id, s.necesidad, s.boceto_url, s.fecha_solicitud, s.cantidad, s.fecha_verificacion, s.fecha_aprobacion, s.descripcion, s.fecha_limite, s.fecha_fin, s.estado_id, ";
    $sql  .=" us.user as usuario, gt.user as grupo_trabajo, ";
    $sql  .=" c.nombre as categoria, t.nombre as tipo, e.nombre as estado ";
    $sql  .=" FROM solicitudes s ";
    $sql  .=" LEFT JOIN usuarios us ON us.id = s.usuario_id ";
    $sql  .=" LEFT JOIN usuarios gt ON gt.id = s.grupo_trabajo_id ";
    $sql  .=" LEFT JOIN categorias c ON c.id = s.categoria_id ";
    $sql  .=" LEFT JOIN tipos t ON t.id = s.tipo_id ";
    $sql  .=" LEFT JOIN estado e ON e.id = s.estado_id ";
    $sql  .=" WHERE e.id = '$estado_id' ";
    $sql  .=" ORDER BY s.id DESC ";

    $result = find_by_sql($sql);
    return $result;
  }




    /*--------------------------------------------------------------*/
    /* Retorna todos los datos relacionados con las SOLICITUDES generadas
    /* por un usuario con id = $user_id
    /* JOIN con todas las tablas relacionadas
    /*--------------------------------------------------------------*/
    function find_solicitudes_by_user_id($user_id){
      global $db;

      $sql =  " SELECT s.id, s.necesidad, s.boceto_url, s.estado_id, s.cantidad, s.fecha_solicitud, s.fecha_verificacion, s.fecha_aprobacion, s.descripcion, s.fecha_limite, s.fecha_fin, s.eliminado, ";
      $sql  .=" us.user as usuario, gt.user as grupo_trabajo, ";
      $sql  .=" c.nombre as categoria, t.nombre as tipo, e.nombre as estado ";
      $sql  .=" FROM solicitudes s ";
      $sql  .=" LEFT JOIN usuarios us ON us.id = s.usuario_id ";
      $sql  .=" LEFT JOIN usuarios gt ON gt.id = s.grupo_trabajo_id ";
      $sql  .=" LEFT JOIN categorias c ON c.id = s.categoria_id ";
      $sql  .=" LEFT JOIN tipos t ON t.id = s.tipo_id ";
      $sql  .=" LEFT JOIN estado e ON e.id = s.estado_id ";
      $sql  .=" WHERE us.id = '$user_id' ";
      $sql  .=" ORDER BY s.id DESC ";

      $result = find_by_sql($sql);
      return $result;
    }




    /*--------------------------------------------------------------*/
    /* Retorna los datos de SEGUIMIENTO de la solicitud
    /* con un id = $id
    /*--------------------------------------------------------------*/
    function find_seguimiento_by_solicitud_id($id) {
      global $db;

      $sql =  " SELECT * FROM seguimiento WHERE solicitud_id='$id' ";
      $result = find_by_sql($sql);
      return $result;
    }




    /*--------------------------------------------------------------*/
    /* Retorna los datos de PROGRESO
    /* con un id = $id
    /*--------------------------------------------------------------*/
    function find_progreso_by_id($id){
      global $db;

      $sql =  " SELECT * FROM progreso WHERE id='$id' ";
      $result = find_by_sql($sql);
      return $result;
    }




    /*--------------------------------------------------------------*/
    /* Retorna la TABLA DE COSTES de la solicitud
    /* con un id = $id
    /*--------------------------------------------------------------*/
    function find_costes_by_solicitud_id($id) {
      global $db;

      $sql =  " SELECT * FROM costes WHERE solicitud_id='$id' ";
      $result = find_by_sql($sql);
      return $result;
    }



    /*--------------------------------------------------------------*/
    /* Retorna los COMENTARIOS de la solicitud
    /* con un id = $id
    /*--------------------------------------------------------------*/
    function find_comentarios_by_solicitud_id($id) {
      global $db;

      $sql =  " SELECT * FROM comentarios WHERE solicitud_id='$id' ";
      $result = find_by_sql($sql);
      return $result;
    }



    /*--------------------------------------------------------------*/
    /* Retorna el COSTE TOTAL de la solicitud
    /* con un id = $id
    /*--------------------------------------------------------------*/
    function calcular_coste_total_by_id($id){
      global $db;

      $sql =  " SELECT SUM(precio_total) AS total FROM costes WHERE solicitud_id='$id' ";
      $result = find_by_sql($sql);
      return $result;
    }




    /*--------------------------------------------------------------*/
    /* Inserta las FECHAS de VALIDACION y APROBACION de la solicitud
    /* con un id = $id
    /*--------------------------------------------------------------*/
    function add_fechas_validacion($id, $tipo_validacion){
      global $db;

      $fecha = date('Y-m-d');
      if($tipo_validacion === 'validar'){
        $sql = "UPDATE solicitudes SET fecha_verificacion='{$fecha}' WHERE id=$id";
        $db->query($sql);
      } else if ($tipo_validacion === 'aprobar') {
        $sql = "UPDATE solicitudes SET fecha_aprobacion='{$fecha}' WHERE id=$id";
        $db->query($sql);
      } else if ($tipo_validacion === 'desvalidar'){
        $sql = "UPDATE solicitudes SET fecha_verificacion=NULL WHERE id=$id";
        $db->query($sql);
      } else {
        $sql = "UPDATE solicitudes SET fecha_aprobacion=NULL WHERE id=$id";
        $db->query($sql);
      }
    }




    /*--------------------------------------------------------------*/
    /* Inserta la FECHA de FINALIZACION de la solicitud
    /* con un id = $id
    /*--------------------------------------------------------------*/
    function add_fecha_fin($id, $tipo_validacion){
      global $db;

      $fecha = date('Y-m-d');
      if($tipo_validacion === 'finalizar'){
        $sql = "UPDATE solicitudes SET fecha_fin='{$fecha}' WHERE id=$id";
        $db->query($sql);
      } else {
        $sql = "UPDATE solicitudes SET fecha_fin=NULL WHERE id=$id";
        $db->query($sql);
      }
    }




    /*--------------------------------------------------------------*/
    /* Cambia el valor de ELIMINADO de la solicitud
    /* con un id = $id y un $status (true: eliminado // false: no eliminado)
    /*--------------------------------------------------------------*/
    function swap_eliminado($id, $status){
      global $db;

      $eliminado = $status?0:1;
      $sql = $sql = "UPDATE solicitudes SET eliminado=$eliminado WHERE id=$id";
      $db->query($sql);

      return true;
    }





?>
