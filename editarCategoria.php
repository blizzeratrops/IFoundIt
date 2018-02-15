<?php
	require_once("biblioteca/session.php");
	require_once('biblioteca/user.php');
	require_once('biblioteca/dbconfig.php');


	$usuario = $_GET['user_id'];
	$id_categoria = $_GET['id'];
	$conn = conectarBD();

	$user_id = $_SESSION['user_session'];

	$stmt = runQuery($conn,"SELECT * FROM usuarios WHERE usr_id=:user_id");
	$stmt->execute(array(":user_id"=>$user_id));
	$userRow=$stmt->fetch(PDO::FETCH_ASSOC);

	if (!$userRow['isadmin']) {
		redirect('index.php');
	}

	$sql = "SELECT nombre
			FROM categorias 
			where id_categoria = $id_categoria";
	$stmt = runQuery($conn,$sql);
	$stmt->execute();
	$row=$stmt->fetch(PDO::FETCH_ASSOC);

	$nombreCategoria = $row['nombre'];

	if(isset($_POST['btn-signup']))
	{

		$nombreCategoria = strip_tags($_POST['txt_nombre']);	
		
		if($nombreCategoria=="")	
		{
			$error[] = "Debe proveer el nombre de la categoria!";
		}
		else
		{
			try
			{
					
				if(editarcategoria($conn,$nombreCategoria,$id_categoria)){
					crearLog("El usuario con id $usuario edito la categoria $nombreCategoria","INFO");
					auditoria($conn,'CATEGORIAS',$usuario,'UPDATE');
					redirect('crudCategorias.php');
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
        <p>Editar categoria</p><hr />
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
        	<label style="text-align: left;">Nombre de la categoria</label>        	
        	<input type="text" class="form-control" name="txt_nombre" placeholder="Nombre" value="<?php echo $nombreCategoria;?>" />
        </div>
        <div class="clearfix"></div><hr />
        <div class="form-group">
        	<button type="submit" class="btn btn-default" name="btn-signup">
            	<i class="glyphicon glyphicon-open-file"></i>&nbsp;ACEPTAR
            </button>
            <a href="crudCategorias.php">
	            <button type="button" class="btn btn-default" name="btn-cancelar">
	            	<i class="glyphicon glyphicon-remove"></i>&nbsp;Cancelar
	            </button>            	
            </a> 
        </div>
    </form>
   </div>

</body>
</html>