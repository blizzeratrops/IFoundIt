<!DOCTYPE html>
<html lang="en">
<head>

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
<body id="login" data-spy="scroll" data-target=".navbar" data-offset="60">

<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="demo.php">Logo</a>
        </div>
    </div>
</nav>

<!-- Contenedor del formulario del log in-->
<div id="login_form" class="container-fluid text-center">
    <form action="/login.php">
        <div class="small-container text-center">
            <h4>Iniciar Sesi&oacute;n</h4>
                <!-- TODO: Agregar imagen para el logueo
                <div class="imgcontainer">
                    <img src="" alt="" class="">
                </div>
                -->
            <div class="container">
                <label><b>Correo Electronico</b></label><br/>
                <input type="text" placeholder="Ingrese su correo" name="email" required><br/>

                <label><b>Contrase&ntilde;a</b></label><br/>
                <input type="password" placeholder="Enter Password" name="psw" required><br/>

                <button type="submit">Login</button><br/>
                <input type="checkbox" checked="checked"> Recordar Cuenta
            </div><br/>
        </div>
        <div class="container" style="background-color:#f1f1f1">
            <span class="psw">Forgot <a href="#">password?</a></span><br/>
        </div>
    </form>
</div>
</body>
</html>

