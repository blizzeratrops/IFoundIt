<?php
	session_start();
	require_once('biblioteca/user.php');
	require_once('biblioteca/dbconfig.php');

	

		$user_id = $_GET['user_id'];
		$anuncio_id = $_GET['id'];
		$conn = conectarBD();

		$sql = "SELECT a.titulo as titulo, a.descripcion as descripcion, a.ciudad as ciudad, a.valor as monto, a.telefono as telefono, a.email as email 
				FROM anuncios a 
				where anuncio_id = $anuncio_id";
		$stmt = runQuery($conn,$sql);
		$stmt->execute();
		$row=$stmt->fetch(PDO::FETCH_ASSOC);

		$titulo = $row['titulo'];
		$descripcion = $row['descripcion'];
		$ciudad = $row['ciudad'];
		$precio = $row['monto'];
		$telefono = $row['telefono'];
		$email = $row['email'];


	if(isset($_POST['btn-publicar']))
	{

		$titulo = strip_tags($_POST['txt_titulo']);
		$descripcion = strip_tags($_POST['txt_descripcion']);
		$ciudad = strip_tags($_POST['txt_ciudad']);	
		$precio = strip_tags($_POST['txt_precio']);	
		$telefono = strip_tags($_POST['txt_telefono']);	
		$email = strip_tags($_POST['txt_email']);

		if(editarAnuncio($conn,$titulo,$descripcion,$ciudad,$precio,$telefono,$email,$anuncio_id)){
			
			$uploaddir = '/home/ifoundit/';
			$uploadfile = $uploaddir . basename($_FILES['imagen']['name']);

			$aux = move_uploaded_file($_FILES['imagen']['tmp_name'], $uploadfile);

			if ($aux) {

				$stmt = $conn->prepare("DELETE FROM imagenes  where id_anuncio = $anuncio_id");
				$stmt->execute();

				$stmt = $conn->prepare("INSERT INTO imagenes(imagen, id_anuncio) 
		                                               VALUES(lo_import('$uploadfile'), $anuncio_id)");
				$stmt->execute();
			}

			crearLog("El usuario con id $user_id edito el anuncio $anuncio_id.", 'INFO');
			redirect('profile.php');
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
        <p>Editar anuncio</p><hr />
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
        <div class="form-group" style="text-align: left;">
        	<label>Titulo</label>
        	<input type="text" class="form-control" name="txt_titulo" placeholder="Titulo" value="<?php echo $titulo ?>" />
        </div>
        <div class="form-group" style="text-align: left;">
        	<label>Descripcion</label>
        	<input type="text" class="form-control" name="txt_descripcion" placeholder="Descripcion" value="<?php echo $descripcion ?>" />
        </div>
        <div class="form-group"  style="text-align: left;">
        	<label>Ciudad</label>
        	<select class="form-control" name="txt_ciudad" value="<?php echo $ciudad ?>">
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
        <div class="form-group" style="text-align: left;">
        	<label>Precio</label>
        	<input type="text" class="form-control" name="txt_precio" placeholder="Precio" value="<?php echo $precio ?>" />
        </div>       
         <div class="form-group" style="text-align: left;">
        	<label>Telefono</label>
        	<input type="text" class="form-control" name="txt_telefono" placeholder="Telefono" value="<?php echo $telefono ?>" />
        </div>        
        <div class="form-group" style="text-align: left;">
        	<label>Email</label>
        	<input type="text" class="form-control" name="txt_email" placeholder="Email" value="<?php echo $email ?>" />
        </div>        
        <div class="form-group">
			<input type="hidden" name="MAX_FILE_SIZE" value="9000000" />Seleccionar imagen: <input name="imagen" type="file" size="25"/>
        </div>

 	    <div class="clearfix"></div><hr />
        <div class="form-group">
        	<button type="submit" class="btn btn-default" name="btn-publicar">
            	<i class="glyphicon glyphicon-open-file"></i>&nbsp;Aceptar
            </button>
            <a href="profile.php">
	            <button type="button" class="btn btn-default" name="btn-cancelar">
	            	<i class="glyphicon glyphicon-remove"></i>&nbsp;Cancelar
	            </button>            	
            </a> 
        	<br />
        </div>
    </form>
   </div>

</body>
</html>