<?php
  session_start();
	require_once("biblioteca/user.php");
	require_once("biblioteca/dbconfig.php");


  if (isset($_GET['anuncios-por-calificacion'])) {
    $conn = conectarBD();
    $user_id = $_SESSION['user_session'];

    $stmt = runQuery($conn,"SELECT * FROM usuarios WHERE usr_id=:user_id");
    $stmt->execute(array(":user_id"=>$user_id));
    $userRow=$stmt->fetch(PDO::FETCH_ASSOC);

    if ($userRow['isadmin']) 
    {

        /*seleccionamos el promedio de calificaciones*/
        $sql = "SELECT a.titulo as titulo , a.descripcion as descripcion, round( CAST(avg(c.calificacion) as numeric), 2) as calificacion 
                FROM calificaciones c
                JOIN anuncios a 
                ON  a.anuncio_id = c.anuncio_id
                group by a.anuncio_id
                order by calificacion desc";
        $stmt = runQuery($conn, $sql);
        $stmt->execute();
        $result_reporte = $stmt->fetchall();

    }else 
    {
      redirect('index.php');
    }
  }else if (isset($_GET['cant-anun-user'])) {
    $conn = conectarBD();
    $user_id = $_SESSION['user_session'];

    $stmt = runQuery($conn,"SELECT * FROM usuarios WHERE usr_id=:user_id");
    $stmt->execute(array(":user_id"=>$user_id));
    $userRow=$stmt->fetch(PDO::FETCH_ASSOC);

    if ($userRow['isadmin']) 
    {

        /*seleccionamos el promedio de calificaciones*/
        $sql = "SELECT u.usr_name as usuario , count(a.anuncio_id) as cantidad_anuncios 
                FROM anuncios a
                JOIN usuarios u ON  a.usr = u.usr_id
                group by u.usr_name
                order by cantidad_anuncios desc";
        $stmt = runQuery($conn, $sql);
        $stmt->execute();
        $result_reporte = $stmt->fetchall();

    }else 
    {
      redirect('index.php');
    }
  } else 
  {
    redirect('index.php');
  }

   

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
            <a class="navbar-brand" href="index.php">IFoundit</a>
          </div>
          <div class="collapse navbar-collapse" id="myNavbar">
              <ul class="nav navbar-nav navbar-right">
                  <li><a href="index.php"><span class="glyphicon glyphicon-home"></span>&nbsp;INICIO</a></li>
                  <li><a href="biblioteca/logout.php?logout=true"><span class="glyphicon glyphicon-log-out"></span>&nbsp;CERRAR SESION</a></li>

                   <?php 
                    if ($userRow['isadmin']) 
                    {   
                      echo '<li><a href="profile.php"><span class="glyphicon glyphicon-user"></span>&nbsp;MI CUENTA</a></li>';
                    echo '<li class="dropdown">';
                      echo '<a href="#" class="dropdown-toggle" data-toggle="dropdown">ADMINISTRACION <b class="caret"></b></a>'; 
                      echo '<ul class="dropdown-menu" style="background-color: #e5e6e8;">';
                        echo '<li><a href="mostrarUsuarios.php">USUARIOS</a></li>';
                        echo '<li class="divider" style="background-color: #FFF;"></li>';
                        echo '<li><a href="crudCiudades.php">CIUDADES</a></li>';
                        echo '<li class="divider" style="background-color: #FFF;"></li>';
                        echo '<li><a href="crudCategorias.php">CATEGORIAS</a></li>';
                        echo '<li class="divider" style="background-color: #FFF;"></li>';
                        echo '<li><a href="reportes.php?anuncios-por-calificacion">ANUNCIOS POR CALIFICACION</a></li>';
                        echo '<li class="divider" style="background-color: #FFF;"></li>';
                        echo '<li><a href="reportes.php?cant-anun-user">ANUNCIOS POR USUARIO</a></li>';
                      echo '</ul>';
                    echo '</li>';
                    } 
                  ?>
              </ul>

        </div>
  </nav>



<div class="jumbotron text-center">
  <hr />
    <?php 

      if (isset($_GET['anuncios-por-calificacion'])) 
      {

        echo "<h2>Anuncios por calificacion</h2>";

      }else if (isset($_GET['cant-anun-user'])) 
      {

        echo "<h2>Anuncios por usuario</h2>";


      }


    ?>
      
  <hr />
</div>

<hr />
<div class="container">  
  <?php 
    if (isset($_GET['anuncios-por-calificacion'])) 
    {
      if ($result_reporte) 
      {
        echo "<table class='table table-hover'>";
          echo "<tr>";
            echo "<td> Titulo </td>";
            echo "<td> Descripcion </td>";
            echo "<td> Calificacion </td>";
          echo "</tr>";

        foreach ($result_reporte as $row) 
        {
            echo "<tr>";
              echo "<td>".$row['titulo']."</td>";
              echo "<td>".$row['descripcion']."</td>";
              echo "<td>".$row['calificacion']."</td>";
            echo "</tr>";
        }
          echo "</table>";
      }
    }else if (isset($_GET['cant-anun-user'])) 
      {

        if ($result_reporte) {
        echo "<table class='table table-hover'>";
          echo "<tr>";
            echo "<td> Usuario </td>";
            echo "<td> Cantidad de anuncios </td>";
          echo "</tr>";

        foreach ($result_reporte as $row) 
        {
            echo "<tr>";
              echo "<td>".$row['usuario']."</td>";
              echo "<td>".$row['cantidad_anuncios']."</td>";
            echo "</tr>";
        }
          echo "</table>";
      }
      }
   ?>
 </div>    
</body>
</html>