<?php
	require_once("biblioteca/session.php");
	
  require_once("biblioteca/user.php");
	require_once("biblioteca/dbconfig.php");
  
  $conn = conectarBD();
  $user_id = $_SESSION['user_session'];

	$stmt = runQuery($conn,"SELECT * FROM usuarios WHERE usr_id=:user_id");
	$stmt->execute(array(":user_id"=>$user_id));
	$userRow=$stmt->fetch(PDO::FETCH_ASSOC);

  if ($userRow['isadmin']) {

    $sql = "SELECT a.anuncio_id as id,a.titulo as titulo,a.fecha_creacion::timestamp(0) as fecha,c.c_name as ciudad,
              a.descripcion as descripcion,a.valor as monto,u.usr_name as usuario, a.estado as estado 
              FROM anuncios a
              JOIN ciudades c on a.ciudad = c.c_id
              JOIN usuarios u on a.usr = u.usr_id
              ORDER BY fecha DESC;";
    $stmt = runQuery($conn, $sql);
    $stmt->execute();
    $search_results = $stmt->fetchAll();

  } else {

    $sql = "SELECT a.anuncio_id as id,a.titulo as titulo,a.fecha_creacion::timestamp(0) as fecha,c.c_name as ciudad,
          a.descripcion as descripcion,a.valor as monto,u.usr_name as usuario, a.estado as estado 
          FROM anuncios a
          JOIN ciudades c on a.ciudad = c.c_id
          JOIN usuarios u on a.usr = u.usr_id
          WHERE a.usr = :user_id
          ORDER BY fecha DESC;";
    $stmt = runQuery($conn, $sql);
    $stmt->execute(array(":user_id"=>$user_id));
    $search_results = $stmt->fetchAll();

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
<title>Bienvenido - <?php print($userRow['usr_name']); ?></title>
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
<label class="h5">Bienvenido : <?php print($userRow['usr_name']); ?></label>
<hr />
<div class="jumbotron text-center">
  <label class="h5">Bienvenido : <?php print($userRow['usr_name']); ?></label>
  <hr />
      <h2>Tus anuncios</h2>
  <hr />
</div>

<div class="container-fluid text-center">
  <?php 
    if ($search_results) {
      echo "<table class='table table-hover'>";
        echo "<tr>";
          echo "<td> Titulo </td>";
          echo "<td> Fecha </td>";
          echo "<td> Ciudad </td>";
          echo "<td> Descripcion </td>";
          echo "<td> Monto </td>";
          echo "<td> Usuario </td>";
          echo "<td> Estado </td>";
        echo "</tr>";

      foreach ($search_results as $row) {
        
        echo "<tr>";
          echo "<td>".$row['titulo']."</td>";
          echo "<td>".$row['fecha']."</td>";
          echo "<td>".$row['ciudad']."</td>";
          echo "<td>".$row['descripcion']."</td>";
          echo "<td>".$row['monto']."</td>";
          echo "<td>".$row['usuario']."</td>";


          /*dependiendo del estado mostramos activar o desactivar*/

          if ($row['estado']) {
            $estado = 'Activo';
          }else{
            $estado = 'Inactivo';
          }

          echo "<td>".$estado."</td>";

          if ($estado == 'Activo') {
            
            echo '<td><a href="modificarAnuncio.php?id='. $row['id'] .'&estado=0&user_id='."$user_id".'">Desactivar</a></td>';

          }elseif ($estado == 'Inactivo') {
            
            echo '<td><a href="modificarAnuncio.php?id='. $row['id'] .'&estado=1&user_id='."$user_id".'">Activar</a></td>';
          
          }

          echo '<td><a href="editarAnuncio.php?id='. $row['id'] .'&user_id='."$user_id".'">Editar</a></td>';

          if ($userRow['isadmin']) {
            
            echo '<td><a href="borrarAnuncio.php?id='. $row['id'] .'&user_id='."$user_id".'">Borrar</a></td>';
            
          }


          echo '<td><a href="mostrarAnuncio.php?id='. $row['id'] .'">Detalles</a></td>';
        echo "</tr>";
      }
      echo "</table>";
    }else{
      echo "No tienes anuncios publicados.";
    }
   ?>
</div>


</body>
</html>