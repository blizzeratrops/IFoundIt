<?php
	require_once("biblioteca/session.php");
	require_once('biblioteca/user.php');
	require_once('biblioteca/dbconfig.php');


	$usuario = $_GET['user_id'];
	$usr_id = $_GET['id'];
	$conn = conectarBD();

	$user_id = $_SESSION['user_session'];

	$stmt = runQuery($conn,"SELECT * FROM usuarios WHERE usr_id=:user_id");
	$stmt->execute(array(":user_id"=>$user_id));
	$userRow=$stmt->fetch(PDO::FETCH_ASSOC);

	if (!$userRow['isadmin']) {
		redirect('index.php');
	}

	$sql = "SELECT * 
			FROM usuarios 
			where usr_id = $usr_id";
	$stmt = runQuery($conn,$sql);
	$stmt->execute();
	$row=$stmt->fetch(PDO::FETCH_ASSOC);

	$uname = $row['usr_name'];
	$nombre = $row['nombre'];
	$apellido = $row['apellido'];
	$nacionalidad = $row['nacionalidad'];
	$selected = $row['isadmin'];

	if(isset($_POST['btn-signup']))
	{

		$upass = strip_tags($_POST['txt_upass']);
		$upass2 = strip_tags($_POST['txt_upass2']);
		$nombre = strip_tags($_POST['txt_nombre']);	
		$apellido = strip_tags($_POST['txt_apellido']);	
		$nacionalidad = strip_tags($_POST['txt_nacionalidad']);	
		$admin = strip_tags($_POST['admin']);	
		
		if($upass=="")	
		{
			$error[] = "Debe proveer el password!";
		}else if(strlen($upass) < 6)
		{
			$error[] = "El password debe tener al menos 6 caracteres!!";	
		}else if($upass2 != $upass)
		{
			$error[] = "Las contraseñas no coinciden";	
		}
		else
		{
			try
			{
				$stmt = runQuery($conn,"SELECT usr_name FROM usuarios WHERE usr_name=:uname");
				$stmt->execute(array(':uname'=>$uname));
				$row=$stmt->fetch(PDO::FETCH_ASSOC);
					
				if(editarUsuario($conn,$upass,$nombre,$apellido,$nacionalidad,$usr_id,$admin)){
					crearLog("El usuario con id $user_id edito al usuario $usr_id","INFO");
					auditoria($conn,'USUARIOS',$user_id,'UPDATE');
					redirect('mostrarUsuarios.php');
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
	<title>IFoundit : Editar usuario</title>
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
        <p>Editar usuario</p><hr />
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
        <div class="form-group" style="text-align: left;">
        	<label>Usuario:</label>
        	<label><?php echo $uname;?></label>
        </div>
        <div class="form-group" style="text-align: left;">
        	<label>Nombre</label>
        	<input type="text" class="form-control" name="txt_nombre" placeholder="Nombre" value="<?php echo $nombre;?>" />
        </div>
        <div class="form-group" style="text-align: left;">
        	<label>Apellido</label>
        	<input type="text" class="form-control" name="txt_apellido" placeholder="Apellido" value="<?php echo $apellido;?>" />
        </div>
        <div class="form-group" style="text-align: left;">
        	<label>Nacionalidad</label>
        	<input type="text" class="form-control" name="txt_nacionalidad" placeholder="Nacionalidad" value="<?php echo $nacionalidad;?>" />
        </div>

        <div class="form-group">
        	<input type="password" class="form-control" name="txt_upass" placeholder="Password" />
        </div>        
        <div class="form-group">
        	<input type="password" class="form-control" name="txt_upass2" placeholder="Repetir Password" />
        </div>
        <div class="form-group" style="text-align: left;">
        	<label>Es administrador</label>
	        <select class="form-control" name="admin">
			  <option value="1" <?php if($selected){echo("selected");}?>>Si</option>
			  <option value="0" <?php if(!$selected){echo("selected");}?>>No</option>
			</select>
		</div>
        <div class="clearfix"></div><hr />
        <div class="form-group">
        	<button type="submit" class="btn btn-default" name="btn-signup">
            	<i class="glyphicon glyphicon-open-file"></i>&nbsp;ACEPTAR
            </button>
            <a href="mostrarUsuarios.php">
	            <button type="button" class="btn btn-default" name="btn-cancelar">
	            	<i class="glyphicon glyphicon-remove"></i>&nbsp;Cancelar
	            </button>            	
            </a> 
        </div>
    </form>
   </div>

</body>
</html>