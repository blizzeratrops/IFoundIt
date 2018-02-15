<?php
	require_once("biblioteca/session.php");
	require_once('biblioteca/user.php');
	require_once('biblioteca/dbconfig.php');


	$usuario = $_GET['user_id'];
	$ciudad = $_GET['id'];
	$conn = conectarBD();

	$user_id = $_SESSION['user_session'];

	$stmt = runQuery($conn,"SELECT * FROM usuarios WHERE usr_id=:user_id");
	$stmt->execute(array(":user_id"=>$user_id));
	$userRow=$stmt->fetch(PDO::FETCH_ASSOC);

	if (!$userRow['isadmin']) {
		redirect('index.php');
	}

	$sql = "SELECT c_name
			FROM ciudades 
			where c_id = $ciudad";
	$stmt = runQuery($conn,$sql);
	$stmt->execute();
	$row=$stmt->fetch(PDO::FETCH_ASSOC);

	$nombreCiudad = $row['c_name'];

	if(isset($_POST['btn-signup']))
	{

		$nombreCiudad = strip_tags($_POST['txt_nombre']);	
		
		if($nombreCiudad=="")	
		{
			$error[] = "Debe proveer el nombre de la ciudad!";
		}
		else
		{
			try
			{
					
				if(editarCiudad($conn,$nombreCiudad,$ciudad)){
					crearLog("El usuario con id $usuario edito la ciudad $nombreCiudad","INFO");
					auditoria($conn,'CIUDADES',$usuario,'UPDATE');
					redirect('crudCiudades.php');
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
        <p>Editar ciudad</p><hr />
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
		?>

        <div class="form-group">
        	<label style="text-align: left;">Nombre de la ciudad</label>        	
        	<input type="text" class="form-control" name="txt_nombre" placeholder="Nombre" value="<?php echo $nombreCiudad;?>" />
        </div>
        <div class="clearfix"></div><hr />
        <div class="form-group">
        	<button type="submit" class="btn btn-default" name="btn-signup">
            	<i class="glyphicon glyphicon-open-file"></i>&nbsp;ACEPTAR
            </button>
            <a href="crudCiudades.php">
	            <button type="button" class="btn btn-default" name="btn-cancelar">
	            	<i class="glyphicon glyphicon-remove"></i>&nbsp;Cancelar
	            </button>            	
            </a> 
        </div>
    </form>
   </div>

</body>
</html>