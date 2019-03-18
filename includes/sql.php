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
   /* Function for Finding all request name
   /* JOIN with all related tables
   /*--------------------------------------------------------------*/
  function join_solicitudes_table(){
    global $db;

    $sql =  " SELECT s.id, s.necesidad, s.boceto_url, s.fecha_solicitud, s.fecha_verificacion, s.fecha_aprobacion, s.descripcion, s.fecha_limite, s.fecha_fin, s.estado_id, ";
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

  function find_solicitudes_by_grupo_trabajo($id){
     global $db;

     $sql =  " SELECT s.id, s.grupo_trabajo_id, s.necesidad, s.estado_id, s.boceto_url, s.fecha_solicitud, s.fecha_verificacion, s.fecha_aprobacion, s.descripcion, s.fecha_limite, s.fecha_fin, ";
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

  function solicitud_info_by_id($id){
     global $db;

     $sql =  " SELECT s.id, s.categoria_id, s.estado_id, s.grupo_trabajo_id, s.tipo_id, s.necesidad, s.boceto_url, s.fecha_solicitud, s.fecha_verificacion, s.fecha_aprobacion, s.descripcion, s.fecha_limite, s.fecha_fin, ";
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


  function find_solicitudes_by_estado_id($estado_id){
    global $db;

    $sql =  " SELECT s.id, s.necesidad, s.boceto_url, s.fecha_solicitud, s.fecha_verificacion, s.fecha_aprobacion, s.descripcion, s.fecha_limite, s.fecha_fin, ";
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
   /* Function for Finding all Product info that contains string
   /* on name or matches with the code. Also filters by Category.
   /*--------------------------------------------------------------*/

    function find_solicitudes_by_user_id($user_id){
      global $db;

      $sql =  " SELECT s.id, s.necesidad, s.boceto_url, s.estado_id, s.fecha_solicitud, s.fecha_verificacion, s.fecha_aprobacion, s.descripcion, s.fecha_limite, s.fecha_fin, ";
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



    function find_seguimiento_by_solicitud_id($id) {
      global $db;

      $sql =  " SELECT * FROM seguimiento WHERE solicitud_id='$id' ";
      $result = find_by_sql($sql);
      return $result;
    }

    function find_costes_by_solicitud_id($id) {
      global $db;

      $sql =  " SELECT * FROM costes WHERE solicitud_id='$id' ";
      $result = find_by_sql($sql);
      return $result;
    }



    /*--------------------------------------------------------------*/
    /* Busca todos los datos de producto por ID
    /*--------------------------------------------------------------*/

     function find_product_by_id($id){
       global $db;
       $p_id = remove_junk($db->escape($id));

        $sql = "SELECT p.id,p.name,p.quantity,p.buy_price,p.sale_price,p.media_id,p.date,p.code,c.name AS categorie, l.location_name AS location, s.state_name AS state";
       $sql  .=" FROM products p";
       $sql  .=" LEFT JOIN categories c ON c.id = p.categorie_id";
       $sql  .=" LEFT JOIN location l ON l.id = p.location_id";
       $sql  .=" LEFT JOIN state s ON s.id = p.state_id";
       $sql  .=" WHERE p.id = '$p_id'";
       $sql  .=" ORDER BY p.id ASC";

       $result = $db->query($sql);

       if($result = $db->fetch_assoc($result))
         return $result;
       else
         return null;

       //return find_by_sql($sql);
     }



  /*--------------------------------------------------------------*/
  /* Function for Finding all product name
  /* Request coming from ajax.php for auto suggest
  /*--------------------------------------------------------------*/

   function find_product_by_title($product_name){
     global $db;
     $p_name = remove_junk($db->escape($product_name));
     $sql = "SELECT name FROM products WHERE name like '%$p_name%' LIMIT 5";
     $result = find_by_sql($sql);
     return $result;
   }

  /*--------------------------------------------------------------*/
  /* Function for Finding all product info by product title
  /* Request coming from ajax.php
  /*--------------------------------------------------------------*/
  function find_all_product_info_by_title($title){
    global $db;
    $sql  = "SELECT * FROM products ";
    $sql .= " WHERE name ='{$title}'";
    $sql .=" LIMIT 1";
    return find_by_sql($sql);
  }

  /*--------------------------------------------------------------*/
  /* Function for Update product quantity
  /*--------------------------------------------------------------*/
  function update_product_qty($qty,$p_id){
    global $db;
    $qty = (int) $qty;
    $id  = (int)$p_id;
    $sql = "UPDATE products SET quantity=quantity -'{$qty}' WHERE id = '{$id}'";
    $result = $db->query($sql);
    return($db->affected_rows() === 1 ? true : false);

  }
  /*--------------------------------------------------------------*/
  /* Function for Display Recent product Added
  /*--------------------------------------------------------------*/
 function find_recent_product_added($limit){
   global $db;
   $sql   = " SELECT p.id,p.name,p.sale_price,p.media_id,c.name AS categorie,";
   $sql  .= "m.file_name AS image FROM products p";
   $sql  .= " LEFT JOIN categories c ON c.id = p.categorie_id";
   $sql  .= " LEFT JOIN media m ON m.id = p.media_id";
   $sql  .= " ORDER BY p.id DESC LIMIT ".$db->escape((int)$limit);
   return find_by_sql($sql);
 }
 /*--------------------------------------------------------------*/
 /* Function for Find Highest saleing Product
 /*--------------------------------------------------------------*/
 function find_higest_saleing_product($limit){
   global $db;
   $sql  = "SELECT p.name, COUNT(s.product_id) AS totalSold, SUM(s.qty) AS totalQty";
   $sql .= " FROM sales s";
   $sql .= " LEFT JOIN products p ON p.id = s.product_id ";
   $sql .= " GROUP BY s.product_id";
   $sql .= " ORDER BY SUM(s.qty) DESC LIMIT ".$db->escape((int)$limit);
   return $db->query($sql);
 }
 /*--------------------------------------------------------------*/
 /* Function for find all sales
 /*--------------------------------------------------------------*/
 function find_all_sale(){
   global $db;
   $sql  = "SELECT s.id,s.qty,s.price,s.date,p.name";
   $sql .= " FROM sales s";
   $sql .= " LEFT JOIN products p ON s.product_id = p.id";
   $sql .= " ORDER BY s.date DESC";
   return find_by_sql($sql);
 }
 /*--------------------------------------------------------------*/
 /* Function for Display Recent sale
 /*--------------------------------------------------------------*/
function find_recent_sale_added($limit){
  global $db;
  $sql  = "SELECT s.id,s.qty,s.price,s.date,p.name";
  $sql .= " FROM sales s";
  $sql .= " LEFT JOIN products p ON s.product_id = p.id";
  $sql .= " ORDER BY s.date DESC LIMIT ".$db->escape((int)$limit);
  return find_by_sql($sql);
}
/*--------------------------------------------------------------*/
/* Function for Generate sales report by two dates
/*--------------------------------------------------------------*/
function find_sale_by_dates($start_date,$end_date){
  global $db;
  $start_date  = date("Y-m-d", strtotime($start_date));
  $end_date    = date("Y-m-d", strtotime($end_date));
  $sql  = "SELECT s.date, p.name,p.sale_price,p.buy_price,";
  $sql .= "COUNT(s.product_id) AS total_records,";
  $sql .= "SUM(s.qty) AS total_sales,";
  $sql .= "SUM(p.sale_price * s.qty) AS total_saleing_price,";
  $sql .= "SUM(p.buy_price * s.qty) AS total_buying_price ";
  $sql .= "FROM sales s ";
  $sql .= "LEFT JOIN products p ON s.product_id = p.id";
  $sql .= " WHERE s.date BETWEEN '{$start_date}' AND '{$end_date}'";
  $sql .= " GROUP BY DATE(s.date),p.name";
  $sql .= " ORDER BY DATE(s.date) DESC";
  return $db->query($sql);
}
/*--------------------------------------------------------------*/
/* Function for Generate Daily sales report
/*--------------------------------------------------------------*/
function  dailySales($year,$month){
  global $db;
  $sql  = "SELECT s.qty,";
  $sql .= " DATE_FORMAT(s.date, '%Y-%m-%e') AS date,p.name,";
  $sql .= "SUM(p.sale_price * s.qty) AS total_saleing_price";
  $sql .= " FROM sales s";
  $sql .= " LEFT JOIN products p ON s.product_id = p.id";
  $sql .= " WHERE DATE_FORMAT(s.date, '%Y-%m' ) = '{$year}-{$month}'";
  $sql .= " GROUP BY DATE_FORMAT( s.date,  '%e' ),s.product_id";
  return find_by_sql($sql);
}
/*--------------------------------------------------------------*/
/* Function for Generate Monthly sales report
/*--------------------------------------------------------------*/
function  monthlySales($year){
  global $db;
  $sql  = "SELECT s.qty,";
  $sql .= " DATE_FORMAT(s.date, '%Y-%m-%e') AS date,p.name,";
  $sql .= "SUM(p.sale_price * s.qty) AS total_saleing_price";
  $sql .= " FROM sales s";
  $sql .= " LEFT JOIN products p ON s.product_id = p.id";
  $sql .= " WHERE DATE_FORMAT(s.date, '%Y' ) = '{$year}'";
  $sql .= " GROUP BY DATE_FORMAT( s.date,  '%c' ),s.product_id";
  $sql .= " ORDER BY date_format(s.date, '%c' ) ASC";
  return find_by_sql($sql);
}

function find_media_by_id($id){
  global $db;
  $sql = "SELECT * FROM media WHERE id=" . $id;
  return find_by_sql($sql);
}


?>
