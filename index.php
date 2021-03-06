<?php
session_start();
require_once("biblioteca/user.php");
require_once('biblioteca/dbconfig.php');

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
    <link rel="stylesheet" href="./static/style.css">
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
        <div class="navbar-header">
            <?php 
                /*$url = "http://www.webservicex.net/ConvertComputer.asmx?WSDL";
                $client = new SoapClient($url);
                $res = $client->ChangeComputerUnit(array('ComputerValue' => '1024', 'fromComputerUnit' => 'Megabyte', 'toComputerUnit' => 'Gigabyte'));
                print_r($res);*/
            ?>
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
    <form action="result-busqueda.php" method="get">
        <div class="input-group">
            <input type="text" class="form-control" size="50" placeholder="Tel&eacute;fonos, Autos, Departamentos, etc..." required name="busqueda">
            <div class="input-group-btn">
                <button type="submit" class="btn btn-danger" name="buscar"><span class="glyphicon glyphicon-search"></span>&nbsp;&nbsp;Buscar</button>
            </div>            
            <div class="input-group-btn">
                <a href="crearAnuncio.php"><button type="button" class="btn btn-warning"><span class="glyphicon glyphicon-pencil"></span>&nbsp;&nbsp;Crear Anuncio</button></a>
            </div>
        </div>
        <div class="form-group"  style="text-align: left;">
            <label>Categoria</label>
            <select class="form-control" name="txt_categoria">
                <?php
                    $conn = conectarBD();
                    $stmt = $conn->prepare("SELECT id_categoria, nombre FROM categorias");
                    $stmt->execute();                   
                    while($row=$stmt->fetch(PDO::FETCH_ASSOC)){                                                 
                       echo '<option value="'.$row['id_categoria'].'">'.$row['nombre'].'</option>';
                    }
                ?>
            </select>
        </div>
    </form>
</div>

</body>
</html>

