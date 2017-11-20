<?php
	session_start();
	require_once('biblioteca/user.php');
	require_once('biblioteca/dbconfig.php');

	if(is_loggedin()!="")
	{
		redirect('index.php');
	}

	if(isset($_POST['btn-signup']))
	{

		$uname = strip_tags($_POST['txt_uname']);
		$upass = strip_tags($_POST['txt_upass']);
		$nombre = strip_tags($_POST['txt_nombre']);	
		$apellido = strip_tags($_POST['txt_apellido']);	
		$nacionalidad = strip_tags($_POST['txt_nacionalidad']);	
		
		if($uname=="")	
		{
			$error[] = "Debe proveer un email!";	
		}
		else if(!filter_var($uname, FILTER_VALIDATE_EMAIL))	
		{
	    	$error[] = 'Ingrese una direccion de correo valida!';
		}
		else if(strlen($nacionalidad) > 3)
		{
			$error[] = "La nacionalidad debe contener solo 3 caracteres!!";	
		}
		else if($upass=="")	
		{
			$error[] = "Debe proveer el password!";
		}else if(strlen($upass) < 6)
		{
			$error[] = "El password debe tener al menos 6 caracteres!!";	
		}
		else
		{
			try
			{
				$conn = conectarBD();
				$stmt = runQuery($conn,"SELECT usr_name FROM usuarios WHERE usr_name=:uname");
				$stmt->execute(array(':uname'=>$uname));
				$row=$stmt->fetch(PDO::FETCH_ASSOC);
					
				if($row['usr_name']==$uname) {
					crearLog("Error al registrar usuario $uname, el nombre ya esta en uso.", 'WARNING');
					$error[] = "El nombre de usuario ya esta en uso!";
				}
				else
				{
					if(register($conn,$uname,$upass,$nombre,$apellido,$nacionalidad)){
						crearLog("Usuario $uname registrado correctamente.", 'INFO');	
						redirect('sign-up.php?joined');
					}
				}
			}
			catch(PDOException $e)
			{
				crearLog($e->getMessage(), 'WARNING');
				echo $e->getMessage();
			}
		}	
	}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>IFoundit : Registrarse</title>
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
    <form method="post" class="form-signin">
        <p>Crear cuenta</p><hr />
        <?php
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
		else if(isset($_GET['joined']))
		{
			 ?>
             <div class="alert alert-info">
                  <i class="glyphicon glyphicon-log-in"></i> &nbsp; Registro Exitoso <a href='login.php'>iniciar sesion</a> aqui
             </div>
             <?php
		}
		?>
        <div class="form-group">
        	<input type="text" class="form-control" name="txt_uname" placeholder="Email" value="<?php if(isset($error)){echo $uname;}?>" />
        </div>
        <div class="form-group">
        	<input type="text" class="form-control" name="txt_nombre" placeholder="Nombre" value="<?php if(isset($error)){echo $nombre;}?>" />
        </div>
        <div class="form-group">
        	<input type="text" class="form-control" name="txt_apellido" placeholder="Apellido" value="<?php if(isset($error)){echo $apellido;}?>" />
        </div>
        <div class="form-group">
        	<input type="text" class="form-control" name="txt_nacionalidad" placeholder="Nacionalidad" value="<?php if(isset($error)){echo $nacionalidad;}?>" />
        </div>

        <div class="form-group">
        	<input type="password" class="form-control" name="txt_upass" placeholder="Password" />
        </div>
        <div class="clearfix"></div><hr />
        <div class="form-group">
        	<button type="submit" class="btn btn-default" name="btn-signup">
            	<i class="glyphicon glyphicon-open-file"></i>&nbsp;REGISTRARSE
            </button>
        	<br />
        	<label>Ya tienes una cuenta? <a href="login.php">Iniciar sesion</a></label>
        </div>
    </form>
   </div>

</body>
</html>