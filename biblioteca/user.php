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
		error_log($MESSAGE, 3, '/home/ifoundit/logs/error.log');
	}


	function crearAnuncio($conn,$titulo,$descripcion,$categoria,$ciudad,$precio,$telefono,$email,$user_id)
	{
			try
			{
				
				$stmt = $conn->prepare("INSERT INTO anuncios(titulo, descripcion, usr, valor, moneda, categoria, ciudad, telefono, email) 
			                                               VALUES(:titulo, :descripcion, :usr, :valor, 'G', :categoria,:ciudad,  :telefono, :email)");
													  
				$stmt->bindparam(":titulo", $titulo);
				$stmt->bindparam(":descripcion", $descripcion);										  
				$stmt->bindparam(":categoria", $categoria);										  
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

	function crearComentario($conn,$usuario,$anuncio_id,$comentario,$isreport)
	{
			try
			{
				
				$stmt = $conn->prepare("INSERT INTO comentarios(usr_id, anuncio_id, comentario, isreport) 
			                                               VALUES(:usuario, :anuncio_id, :comentario, :isreport)");
													  
				$stmt->bindparam(":usuario", $usuario);
				$stmt->bindparam(":anuncio_id", $anuncio_id);										  
				$stmt->bindparam(":comentario", $comentario);										  
				$stmt->bindparam(":isreport", $isreport);										  
					
				$stmt->execute();

				return $stmt;	
			}
			catch(PDOException $e)
			{
				crearLog($e->getMessage(), 'WARNING');
				echo $e->getMessage();
			}				
	}

	function editarAnuncio($conn,$titulo,$descripcion,$ciudad,$precio,$telefono,$email,$anuncio_id)
	{
			try
			{
				
				$stmt = $conn->prepare("UPDATE anuncios 
					SET titulo=:titulo,
					 descripcion=:descripcion,
					 valor=:precio,
					 ciudad=:ciudad,
					 telefono=:telefono,
					 email=:email
					 WHERE anuncio_id = :anuncio_id;");

				$stmt->bindparam(":titulo", $titulo);
				$stmt->bindparam(":descripcion", $descripcion);										  
				$stmt->bindparam(":ciudad", $ciudad);										  
				$stmt->bindparam(":precio", $precio);										  
				$stmt->bindparam(":telefono", $telefono);										  
				$stmt->bindparam(":email", $email);										  
				$stmt->bindparam(":anuncio_id", $anuncio_id);										  
				$stmt->execute();

				return $stmt;	
			}
			catch(PDOException $e)
			{
				echo $e->getMessage();
			}				
	}
	function editarUsuario($conn,$upass,$nombre,$apellido,$nacionalidad,$usr_id,$admin)
	{
			try
			{
				
				$new_password = md5($upass);
				$stmt = $conn->prepare("UPDATE usuarios 
					SET nombre=:nombre,
					 apellido=:apellido,
					 nacionalidad=:nacionalidad,
					 usr_pswd=:upass,
					 isadmin=:admin
					 WHERE usr_id = :usr_id;");

				$stmt->bindparam(":nombre", $nombre);										  
				$stmt->bindparam(":apellido", $apellido);										  
				$stmt->bindparam(":nacionalidad", $nacionalidad);										  
				$stmt->bindparam(":usr_id", $usr_id);	
				$stmt->bindparam(":upass", $new_password);									  
				$stmt->bindparam(":admin", $admin);									  
				$stmt->execute();

				return $stmt;	
			}
			catch(PDOException $e)
			{
				echo $e->getMessage();
			}				
	}
	function crearCalificacion($conn,$usuario,$anuncio_id,$calificacion)
	{
		try
			{
				
				$stmt = $conn->prepare("INSERT INTO calificaciones(calificacion, anuncio_id, user_id) 
			                                               VALUES(:calificacion, :anuncio_id, :usuario)");
													  
				$stmt->bindparam(":calificacion", $calificacion);
				$stmt->bindparam(":anuncio_id", $anuncio_id);										  
				$stmt->bindparam(":usuario", $usuario);										  
					
				$stmt->execute();

				return $stmt;	
			}
			catch(PDOException $e)
			{
				crearLog($e->getMessage(), 'WARNING');
				echo $e->getMessage();
			}			
	}
	function crearCiudad($conn,$nombre)
	{
		try
			{
				
				$stmt = $conn->prepare("INSERT INTO ciudades(c_name) VALUES(:nombre)");
													  
				$stmt->bindparam(":nombre", $nombre);
					
				$stmt->execute();

				return $stmt;	
			}
			catch(PDOException $e)
			{
				crearLog($e->getMessage(), 'WARNING');
				echo $e->getMessage();
			}			
	}

	function editarCiudad($conn,$nombreCiudad,$ciudad)
	{
			try
			{
				
				$stmt = $conn->prepare("UPDATE ciudades 
					SET c_name=:nombreCiudad
					 WHERE c_id = :ciudad;");

				$stmt->bindparam(":nombreCiudad", $nombreCiudad);										  
				$stmt->bindparam(":ciudad", $ciudad);										  
				$stmt->execute();

				return $stmt;	
			}
			catch(PDOException $e)
			{
				echo $e->getMessage();
			}				
	}
	function crearCategoria($conn,$nombre)
	{
		try
			{
				
				$stmt = $conn->prepare("INSERT INTO categorias(nombre) VALUES(:nombre)");
													  
				$stmt->bindparam(":nombre", $nombre);
					
				$stmt->execute();

				return $stmt;	
			}
			catch(PDOException $e)
			{
				crearLog($e->getMessage(), 'WARNING');
				echo $e->getMessage();
			}			
	}

	function editarCategoria($conn,$nombreCategoria,$id_categoria)
	{
			try
			{
				
				$stmt = $conn->prepare("UPDATE categorias 
					SET nombre=:nombreCategoria
					 WHERE id_categoria = :id_categoria;");

				$stmt->bindparam(":nombreCategoria", $nombreCategoria);										  
				$stmt->bindparam(":id_categoria", $id_categoria);										  
				$stmt->execute();

				return $stmt;	
			}
			catch(PDOException $e)
			{
				echo $e->getMessage();
			}				
	}
	function auditoria($conn,$tabla,$usr_id,$evento)
	{
		try
		{
			$stmt = $conn->prepare("INSERT INTO auditoria(tabla,usr_id,evento) 
		                                               VALUES(:tabla, :usr_id, :evento)");
												  
			$stmt->bindparam(":tabla", $tabla);
			$stmt->bindparam(":usr_id", $usr_id);										  
			$stmt->bindparam(":evento", $evento);										  
				
			$stmt->execute();	
			
			return $stmt;	
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}				
	}