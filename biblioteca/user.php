<?php

	function runQuery($conn,$sql)
	{
		$conn = conectarBD();
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

?>