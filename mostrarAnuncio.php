<?php
  session_start();
	require_once("biblioteca/user.php");
	require_once("biblioteca/dbconfig.php");


  $conn = conectarBD();
  $anuncio_id = $_GET['id'];

  //seleccionar datos del anuncio
  $_SESSION['anuncio_id'] = $anuncio_id;
  $sql = "SELECT a.anuncio_id as id,a.titulo as titulo,a.fecha_creacion as fecha,c.c_name as ciudad,
            a.descripcion as descripcion,a.valor as monto,u.usr_name as usuario, a.telefono as telefono, a.email as email, a.moneda as moneda 
            FROM anuncios a
            JOIN ciudades c on a.ciudad = c.c_id
            JOIN usuarios u on a.usr = u.usr_id
            WHERE a.anuncio_id = :anuncio_id
            ORDER BY fecha DESC;";
  $stmt = runQuery($conn, $sql);
  $stmt->execute(array(":anuncio_id"=>$anuncio_id));
  $search_results = $stmt->fetch(PDO::FETCH_ASSOC);


//seleccionar imagenes del anuncio

  $temp = '/home/ifoundit/tmp.jpg';
  $query = "select lo_export(imagen, '$temp') from imagenes where id_anuncio = :anuncio_id";
  $stmt = runQuery($conn, $query);
  $stmt->execute(array(":anuncio_id"=>$anuncio_id));
  $result = $stmt->fetch(PDO::FETCH_ASSOC);


  if(isset($_POST['btn-comentar']))
  {
    $usuario = $_SESSION['user_session'];
    $comentario = strip_tags($_POST['txt_comentario']);
    $anuncio_id = strip_tags($_POST['anuncio_id']);
    
    if(!$comentario || trim($comentario)=="")  
    {
      $error[] = "Debe ingresar un comentario!";  
    }else
      {

        try
          {
            //$conn = conectarBD();
            if(crearComentario($conn,$usuario,$anuncio_id,$comentario))
            {
              
              crearLog("El usuario con id $usuario publico un comentario en el anuncio $anuncio_id.", 'INFO');
              //unset($_SESSION['anuncio_id']);
              //redirect('profile.php');
            }
          }catch(PDOException $e)
          {
          
            crearLog($e->getMessage(), 'WARNING');
            echo $e->getMessage();
          }
      }
  }     
  //seleccionar ocmentarios del anuncio
  $sql = "SELECT u.nombre || ' ' || u.apellido as usuario ,c.comentario as comentario, c.fecha_comentario as fecha 
              FROM comentarios c
              JOIN usuarios u on c.usr_id = u.usr_id
              JOIN anuncios a on c.anuncio_id = a.anuncio_id
              WHERE a.anuncio_id = :anuncio_id
              ORDER BY fecha DESC;";
  $stmt = runQuery($conn, $sql);
  $stmt->execute(array(":anuncio_id"=>$anuncio_id));
  $comment_result = $stmt->fetchAll();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="./static/style.css">
<title>Anuncio</title>
</head>

<body>


<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav navbar-right">
                <?php
                    if (is_loggedin()!="") {
                        echo '<li><a href="profile.php"><span class="glyphicon glyphicon-user"></span>&nbsp;MI CUENTA</a></li>';
                        echo '<li><a href="biblioteca/logout.php?logout=true"><span class="glyphicon glyphicon-log-out"></span>&nbsp;CERRAR SESION</a></li>';
                    } elseif (is_loggedin() == "") {
                        echo '<li><a href="login.php"><span class="glyphicon glyphicon-log-in"></span>&nbsp;INICIAR SESION</a></li>';
                        echo '<li><a href="sign-up.php"><span class="glyphicon glyphicon-plus"></span>&nbsp;REGISTRARSE</a></li>';
                    }

                ?>
            </ul>
        </div>
    </div>
</nav>

<div class="jumbotron text-center">
    <h1>I Found It</h1>
    <p>Anuncios Clasificados</p>
</div>


<hr />
<div class="container">
  
  <?php 
    if ($search_results) {
      echo "<table class='table table-hover'>";
        echo "<tr>";
          echo "<td> Usuario </td>";
          echo "<td> Titulo </td>";
          echo "<td> Descripcion </td>";
          echo "<td> Moneda </td>";
          echo "<td> Monto </td>";
          echo "<td> Ciudad </td>";
          echo "<td> Fecha </td>";
          echo "<td> Telefono </td>";
          echo "<td> Email </td>";
        echo "</tr>";

        
        echo "<tr>";
          echo "<td>".$search_results['usuario']."</td>";
          echo "<td>".$search_results['titulo']."</td>";
          echo "<td>".$search_results['descripcion']."</td>";
          echo "<td>".$search_results['moneda']."</td>";
          echo "<td>".$search_results['monto']."</td>";
          echo "<td>".$search_results['ciudad']."</td>";
          echo "<td>".$search_results['fecha']."</td>";
          echo "<td>".$search_results['telefono']."</td>";
          echo "<td>".$search_results['email']."</td>";

        echo "</tr>";
      echo "</table>";

      if($result)
      {          
        //$ctobj = $result["imagen"];
        echo "<IMG SRC=biblioteca/show.php width='500' height='300'>";
      }

    }
   ?>
</div><br><br>
<hr />
<div class="container text-center">
  <h3>Comentarios</h3>
</div>


<div class="container">
<?php 

if ($comment_result) {
  echo "<table class='table table-hover'>";
    echo "<tr>";
      echo "<td> Usuario </td>";
      echo "<td> Comentario </td>";
      echo "<td> Fecha </td>";
    echo "</tr>";

    foreach ($comment_result as $row) 
    {
      echo "<tr>";
        echo "<td>".$row['usuario']."</td>";
        echo "<td>".$row['comentario']."</td>";
        echo "<td>".$row['fecha']."</td>";
      echo "</tr>";
  }
  echo "</table>";
}

 ?>
</div>
<div class="container text-center">
<?php 

  if(is_loggedin()!="")
    {
      if(isset($error))
      {
        foreach($error as $error)
        {
           ?>
                   <div class="alert alert-danger">
                      <i class="glyphicon glyphicon-warning-sign"></i> &nbsp; <?php echo $error; ?>
                   </div>
                   <?php
        }
      }
      echo'<div class="container">';
        echo'<form method="post" class="form-signin">';
          echo'<div class="form-group">';
          echo'<input type="text" class="form-control" name="txt_comentario" placeholder="Comentario" />';
          echo'</div>';
          echo '<input type="hidden" value="'.$anuncio_id.'" name="anuncio_id" />';
          echo'<div class="clearfix"></div><hr />';
          echo'<div class="form-group">';
            echo'<button type="submit" class="btn btn-default" name="btn-comentar">';
                echo'<i class="glyphicon glyphicon-open-file"></i>&nbsp;Comentar';
              echo'</button>';
            echo'<br />';
          echo'</div>';
        echo'</form>';
      echo'</div>';
    }

 ?>
</div>
</body>
</html>