<?php
session_start();
require_once("biblioteca/user.php");
require_once("biblioteca/dbconfig.php");

if(is_loggedin()!="")
{
	redirect('index.php');
}

if(isset($_POST['btn-login']))
{
    $conn = conectarBD();
	$uname = strip_tags($_POST['txt_uname']);
	$upass = strip_tags($_POST['txt_password']);
		
	if(doLogin($conn,$uname,$upass))
	{
        crearLog("Acceso correcto para el usuario $uname.", 'INFO');
        redirect('index.php');
    }
    else
    {
        crearLog("Error de acceso con el usuario $uname.", 'WARNING');
        $error = "Datos incorrectos!";
	}	
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>IFoundit : Login</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="./static/style.css">
</head>
<body class="jumbotron text-center">
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <div class="collapse navbar-collapse" id="myNavbar">
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="index.php"><span class="glyphicon glyphicon-home"></span>&nbsp;INICIO</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <h1>I Found It</h1>
        
       <form class="form-signin text-center" method="post" id="login-form">
      
            <p>Iniciar sesion</p><hr />
            
            <div id="error">
                <?php
        			if(isset($error))
        			{
        				?>
                        <div class="alert alert-danger">
                           <i class="glyphicon glyphicon-warning-sign"></i> &nbsp; <?php echo $error; ?> !
                        </div>
                        <?php
        			}
        		?>
            </div>
            
            <div class="form-group">
                <input type="text" class="form-control" name="txt_uname" placeholder="Email" required />
                <span id="check-e"></span>
            </div>
            
            <div class="form-group">
                <input type="password" class="form-control" name="txt_password" placeholder="Password" />
            </div>
           
         	<hr />
            
            <div class="form-group">
                <button type="submit" name="btn-login" class="btn btn-default">
                    	<i class="glyphicon glyphicon-log-in"></i> &nbsp; LOGIN
                </button>
            <br />
            <label>No tienes una cuenta? <a href="sign-up.php">Registrate</a></label>
            </div>  
      </form>
</body>
</html>