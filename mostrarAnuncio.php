<?php

	require_once("biblioteca/session.php");
	
  require_once("biblioteca/user.php");
	require_once("biblioteca/dbconfig.php");
	
  $conn = conectarBD();
	$anuncio_id = $_GET['id'];
	
  $sql = "SELECT a.anuncio_id as id,a.titulo as titulo,a.fecha_creacion as fecha,c.c_name as ciudad,
            a.descripcion as descripcion,a.valor as monto,u.usr_name as usuario 
            FROM anuncios a
            JOIN ciudades c on a.ciudad = c.c_id
            JOIN usuarios u on a.usr = u.usr_id
            WHERE a.anuncio_id = :anuncio_id
            ORDER BY fecha DESC;";
  $stmt = runQuery($conn, $sql);
  $stmt->execute(array(":anuncio_id"=>$anuncio_id));
  $search_results = $stmt->fetch(PDO::FETCH_ASSOC);

	
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
            </ul>
      </div>
</nav>

<div class="jumbotron text-center">
    <h1>I Found It</h1>
    <p>Anuncios Clasificados</p>
</div>


<hr />
  <?php 
    if ($search_results) {
      echo "<table class='table table-hover'>";
        echo "<tr>";
          echo "<td> Usuario </td>";
          echo "<td> Titulo </td>";
          echo "<td> Descripcion </td>";
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
          echo "<td>".$search_results['monto']."</td>";
          echo "<td>".$search_results['ciudad']."</td>";
          echo "<td>".$search_results['fecha']."</td>";
          echo "<td>".$search_results['telefono']."</td>";
          echo "<td>".$search_results['email']."</td>";

        echo "</tr>";
      echo "</table>";
    }else{
      echo "No se encontraron resultados para su busqueda.";
    }
   ?>


</body>
</html>