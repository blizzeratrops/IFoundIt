<?php 
require_once('busqueda.php');
require_once('user.php');

if( isset($_GET['buscar']) )
{
    //be sure to validate and clean your variables
    $texto = htmlentities($_GET['busqueda']);
    //then you can use them in a PHP function. 
	$search_results = search($texto);	
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Theme Made By www.w3schools.com - No Copyright -->
    <title>IFoundIt! how about you?</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../static/style.css">
    <link rel="stylesheet" href="../static/bootstrap.min.css">
</head>
<body id="myPage" data-spy="scroll" data-target=".navbar" data-offset="60">

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
                        echo '<li><a href="biblioteca/profile.php"><span class="glyphicon glyphicon-user"></span>&nbsp;MI CUENTA</a></li>';
                        echo '<li><a href="biblioteca/logout.php?logout=true"><span class="glyphicon glyphicon-log-out"></span>&nbsp;CERRAR SESION</a></li>';
                    } elseif (is_loggedin() == "") {
                        echo '<li><a href="biblioteca/login.php"><span class="glyphicon glyphicon-log-in"></span>&nbsp;INICIAR SESION</a></li>';
                        echo '<li><a href="biblioteca/sign-up.php"><span class="glyphicon glyphicon-plus"></span>&nbsp;REGISTRARSE</a></li>';
                    }

                ?>
            </ul>
        </div>
    </div>
</nav>

<div class="jumbotron text-center">
    <h1>I Found It</h1>
    <p>Anuncios Clasificados</p>
    <form action="#" method="get">
        <div class="input-group">
            <input type="text" class="form-control" size="50" placeholder="Tel&eacute;fonos, Autos, Departamentos, etc..." required name="busqueda">
            <div class="input-group-btn">
                <button type="submit" class="btn btn-danger" name="buscar"><span class="glyphicon glyphicon-search"></span>&nbsp;&nbsp;Buscar</button>
            </div>            
            <div class="input-group-btn">
                <a href="biblioteca/crearAnuncio.php"><button type="button" class="btn btn-warning"><span class="glyphicon glyphicon-pencil"></span>&nbsp;&nbsp;Crear Anuncio</button></a>
            </div>
        </div>
    </form>
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
				echo "</tr>";

			foreach ($search_results as $row) {
				
				echo "<tr>";
					echo "<td>".$row['titulo']."</td>";
					echo "<td>".$row['fecha']."</td>";
					echo "<td>".$row['ciudad']."</td>";
					echo "<td>".$row['descripcion']."</td>";
					echo "<td>".$row['monto']."</td>";
					echo "<td>".$row['usuario']."</td>";
				echo "</tr>";
			}
			echo "</table>";
		}else{
			echo "No se encontraron resultados para su busqueda.";
		}
	 ?>
</div>

</body>
</html>