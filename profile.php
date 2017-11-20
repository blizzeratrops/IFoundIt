<?php

	require_once("biblioteca/session.php");
	
  require_once("biblioteca/user.php");
	require_once("biblioteca/dbconfig.php");
	
  $conn = conectarBD();
	$user_id = $_SESSION['user_session'];
	
	$stmt = runQuery($conn,"SELECT * FROM usuarios WHERE usr_id=:user_id");
	$stmt->execute(array(":user_id"=>$user_id));
	
	$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="biblioteca/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen"> 
<link href="biblioteca/bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen"> 
<script type="text/javascript" src="biblioteca/jquery-1.11.3-jquery.min.js"></script>
<link rel="stylesheet" href="style.css" type="text/css"  />
<title>Bienvenido - <?php print($userRow['usr_name']); ?></title>
</head>

<body>


<nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php">IFoundit</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
			  <span class="glyphicon glyphicon-user"></span>&nbsp;Hola <?php echo $userRow['usr_name']; ?>&nbsp;<span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="#"><span class="glyphicon glyphicon-user"></span>&nbsp;Ver perfil</a></li>
                <li><a href="biblioteca/logout.php?logout=true"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Cerrar sesion</a></li>
              </ul>
            </li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

	<div class="clearfix"></div>
	
    <div class="container-fluid" style="margin-top:80px;">
	
    <div class="container">
    
    	<label class="h5">Bienvenido : <?php print($userRow['usr_name']); ?></label>
        <hr />
        
        <h1>
        <a href="index.php"><span class="glyphicon glyphicon-home"></span> Inicio</a> &nbsp; 
        <a href="profile.php"><span class="glyphicon glyphicon-user"></span> Perfil</a></h1>
        <hr />
        
        <p class="h4">Pagina de perfil</p>    
    </div>

</div>
</body>
</html>