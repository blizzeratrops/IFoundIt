<?php
session_start();
require_once("user.php");
require_once("dbconfig.php");

if(is_loggedin()!="")
{
	redirect('../index.php');
}

if(isset($_POST['btn-login']))
{
    $conn = conectarBD();
	$uname = strip_tags($_POST['txt_uname']);
	$upass = strip_tags($_POST['txt_password']);
		
	if(doLogin($conn,$uname,$upass))
	{
		redirect('../index.php');
	}
	else
	{
		$error = "Datos incorrectos!";
	}	
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Coding Cage : Login</title>
<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
<link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen">
<link rel="stylesheet" href="style.css" type="text/css"  />
</head>
<body>

<div class="signin-form">

	<div class="container">
     
        
       <form class="form-signin" method="post" id="login-form">
      
        <h2 class="form-signin-heading">Iniciar sesion</h2><hr />
        
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
        <input type="text" class="form-control" name="txt_uname" placeholder="Nombre de usuario" required />
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
        </div>  
      	<br />
            <label>No tengo cuenta! <a href="sign-up.php">Registrarse</a></label>
      </form>

    </div>
    
</div>

</body>
</html>