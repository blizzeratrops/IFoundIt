<?php
	session_start();
	require_once('user.php');
	require_once('dbconfig.php');

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
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>IFoundit : Registrarse</title>
<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
<link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen">
<link rel="stylesheet" href="style.css" type="text/css"  />
</head>
<body>

<div class="signin-form">

<div class="container">
    	
        <form method="post" class="form-signin">
            <h2 class="form-signin-heading">Sign up.</h2><hr />
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
            	<button type="submit" class="btn btn-primary" name="btn-signup">
                	<i class="glyphicon glyphicon-open-file"></i>&nbsp;REGISTRARSE
                </button>
            </div>
            <br />
            <label>Ya tengo una cuenta! <a href="login.php">Loguearse</a></label>
        </form>
       </div>
</div>

</div>

</body>
</html>