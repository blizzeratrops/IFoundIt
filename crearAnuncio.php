<?php
	session_start();
	require_once('biblioteca/user.php');
	require_once('biblioteca/dbconfig.php');

	if(is_loggedin()=="")
	{
		redirect('login.php');
	}

	if(isset($_POST['btn-publicar']))
	{

		$titulo = strip_tags($_POST['txt_titulo']);
		$descripcion = strip_tags($_POST['txt_descripcion']);
		$ciudad = strip_tags($_POST['txt_ciudad']);	
		$precio = strip_tags($_POST['txt_precio']);	
		$telefono = strip_tags($_POST['txt_telefono']);	
		$email = strip_tags($_POST['txt_email']);	
		
		if($titulo=="")	
		{
			$error[] = "Debe ingresar un titulo";	
		}
		else if(!filter_var($email, FILTER_VALIDATE_EMAIL))	
		{
	    	$error[] = 'Ingrese una direccion de correo valida!';
		}
		else if(!is_numeric($precio))
		{
			$error[] = "El precio debe ser numerico";	
		}
		else if(strlen($precio) < 0)
		{
			$error[] = "No puede ingresar un precio negativo!!";	
		}

	else
		{
			try
			{
				$user_id = $_SESSION['user_session'];
				$conn = conectarBD();
				if(crearAnuncio($conn,$titulo,$descripcion,$ciudad,$precio,$telefono,$email,$user_id)){
					
					$stmt = runQuery($conn,"SELECT anuncio_id FROM anuncios order by anuncio_id desc limit 1");
					$stmt->execute();
					$row=$stmt->fetch(PDO::FETCH_ASSOC);
					$id_anuncio = $row['anuncio_id'];	

					$uploaddir = '/tmp/IFoundit/';
					$uploadfile = $uploaddir . basename($_FILES['imagen']['name']);

					if (move_uploaded_file($_FILES['imagen']['tmp_name'], $uploadfile))
					{   // echo "File is valid, and was successfully uploaded.\n";
					}
					else   {   echo "File size greater than 300kb!\n\n";   }

					$stmt = $conn->prepare("INSERT INTO imagenes(imagen, id_anuncio) 
				                                               VALUES(lo_import('$uploadfile'), $id_anuncio)");
					$stmt->execute();

					crearLog("El usuario con id $user_id creo un anuncio.", 'INFO');	
					redirect('index.php');
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
    <form method="post" class="form-signin" enctype="multipart/form-data">
        <p>Crear anuncio</p><hr />
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
        	<input type="text" class="form-control" name="txt_titulo" placeholder="Titulo" value="<?php if(isset($error)){echo $titulo;}?>" />
        </div>
        <div class="form-group">
        	<input type="text" class="form-control" name="txt_descripcion" placeholder="Descripcion" value="<?php if(isset($error)){echo $descripcion;}?>" />
        </div>
        <div class="form-group"  style="text-align: left;>
        	<label">Ciudad</label>
        	<select class="form-control" name="txt_ciudad">
				<?php
					$conn = conectarBD();
					$stmt = $conn->prepare("SELECT c_id, c_name FROM ciudades");
					$stmt->execute();					
				    while($row=$stmt->fetch(PDO::FETCH_ASSOC)){                                                 
				       echo '<option value="'.$row['c_id'].'">'.$row['c_name'].'</option>';
				    }
				?>
			</select>
        </div>
        <div class="form-group">
        	<input type="text" class="form-control" name="txt_precio" placeholder="Precio" value="<?php if(isset($error)){echo $precio;}?>" />
        </div>       
         <div class="form-group">
        	<input type="text" class="form-control" name="txt_telefono" placeholder="Telefono" value="<?php if(isset($error)){echo $telefono;}?>" />
        </div>        
        <div class="form-group">
        	<input type="text" class="form-control" name="txt_email" placeholder="Email" value="<?php if(isset($error)){echo $email;}?>" />
        </div>        
        <div class="form-group">
			<input type="hidden" name="MAX_FILE_SIZE" value="300000" />Seleccionar imagen: <input name="imagen" type="file" size="25"/>
        </div>

 	    <div class="clearfix"></div><hr />
        <div class="form-group">
        	<button type="submit" class="btn btn-default" name="btn-publicar">
            	<i class="glyphicon glyphicon-open-file"></i>&nbsp;Publicar
            </button>
        	<br />
        </div>
    </form>
   </div>

</body>
</html>