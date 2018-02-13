<?php

	function runQuery($conn,$sql)
	{
		//$conn = conectarBD();
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stmt = $conn->prepare($sql);
		return $stmt;
	}
	
	function register($conn,$uname,$upass,$nombre, $apellido, $nacionalidad)
	{
		try
		{
			$new_password = md5($upass);
			
			$stmt = $conn->prepare("INSERT INTO usuarios(usr_name,usr_pswd,nombre,apellido,nacionalidad) 
		                                               VALUES(:uname, :upass, :nombre, :apellido, :nacionalidad)");
												  
			$stmt->bindparam(":uname", $uname);
			$stmt->bindparam(":upass", $new_password);										  
			$stmt->bindparam(":nombre", $nombre);										  
			$stmt->bindparam(":apellido", $apellido);										  
			$stmt->bindparam(":nacionalidad", $nacionalidad);										  
				
			$stmt->execute();	
			
			return $stmt;	
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}				
	}
	
	
	function doLogin($conn,$uname,$upass)
	{
		try
		{
			$md5_upass = md5($upass);
			$stmt = $conn->prepare("SELECT usr_id, usr_name, usr_pswd FROM usuarios WHERE usr_name=:uname ");
			$stmt->execute(array(':uname'=>$uname));
			$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
			if($stmt->rowCount() == 1)
			{
				if($md5_upass == $userRow['usr_pswd'])
				{
					$_SESSION['user_session'] = $userRow['usr_id'];
					return true;
				}
				else
				{
					return false;
				}
			}
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}
	
	function is_loggedin()
	{
		if(isset($_SESSION['user_session']))
		{
			return true;
		}
	}
	
	function redirect($url)
	{
		header("Location: $url");
	}
	
	function doLogout()
	{
		session_destroy();
		unset($_SESSION['user_session']);
		return true;
	}

	function crearLog($mensaje, $nivel)
	{
		$DATE = DATE("Y-M-D H:M:S");
		$FILE = __FILE__;
		$LEVEL = $nivel;

		$MESSAGE = "[{$DATE}] [{$FILE}] [{$LEVEL}] ".$mensaje.PHP_EOL;
		// LOG TO OUR DEFAULT LOCATION
		error_log($MESSAGE, 3, '/tmp/IFoundit/logs/error.log');
	}


function crearAnuncio($conn,$titulo,$descripcion,$ciudad,$precio,$telefono,$email,$user_id)
{
		try
		{
			
			$stmt = $conn->prepare("INSERT INTO anuncios(titulo, descripcion, usr, valor, moneda, ciudad, telefono, email) 
		                                               VALUES(:titulo, :descripcion, :usr, :valor, 'G', :ciudad,  :telefono, :email)");
												  
			$stmt->bindparam(":titulo", $titulo);
			$stmt->bindparam(":descripcion", $descripcion);										  
			$stmt->bindparam(":ciudad", $ciudad);										  
			$stmt->bindparam(":valor", $precio);										  
			$stmt->bindparam(":telefono", $telefono);										  
			$stmt->bindparam(":email", $email);										  
			$stmt->bindparam(":usr", $user_id);										  
				
			$stmt->execute();

			return $stmt;	
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}				
}

function crearComentario($conn,$usuario,$anuncio_id,$comentario)
{
		try
		{
			
			$stmt = $conn->prepare("INSERT INTO comentarios(usr_id, anuncio_id, comentario) 
		                                               VALUES(:usuario, :anuncio_id, :comentario)");
												  
			$stmt->bindparam(":usuario", $usuario);
			$stmt->bindparam(":anuncio_id", $anuncio_id);										  
			$stmt->bindparam(":comentario", $comentario);										  
				
			$stmt->execute();

			return $stmt;	
		}
		catch(PDOException $e)
		{
			crearLog($e->getMessage(), 'WARNING');
			echo $e->getMessage();
		}				
}