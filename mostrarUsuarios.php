<?php
  require_once("biblioteca/session.php");
	require_once("biblioteca/user.php");
	require_once("biblioteca/dbconfig.php");

  if(!is_loggedin())
  {
    redirect('login.php');
  }

  $conn = conectarBD();
  $user_id = $_SESSION['user_session'];

  $stmt = runQuery($conn,"SELECT * FROM usuarios WHERE usr_id=:user_id");
  $stmt->execute(array(":user_id"=>$user_id));
  $userRow=$stmt->fetch(PDO::FETCH_ASSOC);

  if (!$userRow['isadmin']) {
    redirect('index.php');
  }

  //seleccionar datos de usuarios
  $sql = "SELECT * FROM usuarios";
  $stmt = runQuery($conn, $sql);
  $stmt->execute();
  $search_results = $stmt->fetchAll();  

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
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav navbar-right">
              <li><a href="index.php"><span class="glyphicon glyphicon-home"></span>&nbsp;INICIO</a></li>
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
  <hr />
      <h2>Lista de usuarios</h2>
  <hr />
</div>

<hr />
<div class="container">  
  <?php 
    if ($search_results) {
      echo "<table class='table table-hover'>";
        echo "<tr>";
          echo "<td> Usuario </td>";
          echo "<td> Nombre </td>";
          echo "<td> Apellido </td>";
          echo "<td> Nacionalidad </td>";
          echo "<td> Es administrador </td>";
        echo "</tr>";

      foreach ($search_results as $row) 
      {
          echo "<tr>";
            echo "<td>".$row['usr_name']."</td>";
            echo "<td>".$row['nombre']."</td>";
            echo "<td>".$row['apellido']."</td>";
            echo "<td>".$row['nacionalidad']."</td>";
            echo "<td>".$row['isadmin']."</td>";
            echo '<td><a href="editarUsuario.php?id='. $row['usr_id'] .'&user_id='."$user_id".'">Editar</a></td>';
            echo '<td><a href="borrarUsuario.php?id='. $row['usr_id'] .'&user_id='."$user_id".'">Borrar</a></td>';
    
          echo "</tr>";
      }
        echo "</table>";

    }
   ?>
</body>
</html>