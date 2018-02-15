<?php
  require_once("biblioteca/session.php");
	require_once("biblioteca/user.php");
	require_once("biblioteca/dbconfig.php");

  if(!is_loggedin())
  {
    redirect('login.php');
  }

  $conn = conectarBD();
  $user_id = $_SESSION['user_session'];

  $stmt = runQuery($conn,"SELECT * FROM usuarios WHERE usr_id=:user_id");
  $stmt->execute(array(":user_id"=>$user_id));
  $userRow=$stmt->fetch(PDO::FETCH_ASSOC);

  if (!$userRow['isadmin']) {
    redirect('index.php');
  }

    if(isset($_POST['btn-publicar']))
  {

    $nombre = strip_tags($_POST['txt_nombre']);
    
    if($nombre=="") 
    {
      $error[] = "Debe ingresar el nombre de la ciudad!"; 
    }
    else
    {
      try
      {
        $user_id = $_SESSION['user_session'];
        $conn = conectarBD();
        if(crearCiudad($conn,$nombre)){      
          
          crearLog("El usuario con id $user_id creo una ciudad.", 'INFO');
          auditoria($conn,'CIUDADES',$user_id,'INSERT');

        }
  
      }
      catch(PDOException $e)
      {
        crearLog($e->getMessage(), 'WARNING');
        echo $e->getMessage();
      }
    } 
  }

  //seleccionar datos de ciudades
  $sql = "SELECT * FROM ciudades";
  $stmt = runQuery($conn, $sql);
  $stmt->execute();
  $search_results = $stmt->fetchAll();  

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="./static/style.css">
<title>Anuncio</title>
</head>

<body>


<nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <a class="navbar-brand" href="index.php">IFoundit</a>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="index.php"><span class="glyphicon glyphicon-home"></span>&nbsp;INICIO</a></li>
                <li><a href="biblioteca/logout.php?logout=true"><span class="glyphicon glyphicon-log-out"></span>&nbsp;CERRAR SESION</a></li>

                 <?php 
                  if ($userRow['isadmin']) 
                  {   
                    echo '<li><a href="profile.php"><span class="glyphicon glyphicon-user"></span>&nbsp;MI CUENTA</a></li>';
                    echo '<li class="dropdown">';
                      echo '<a href="#" class="dropdown-toggle" data-toggle="dropdown">ADMINISTRACION <b class="caret"></b></a>'; 
                      echo '<ul class="dropdown-menu" style="background-color: #e5e6e8;">';
                        echo '<li><a href="mostrarUsuarios.php">USUARIOS</a></li>';
                        echo '<li class="divider" style="background-color: #FFF;"></li>';
                        echo '<li><a href="crudCiudades.php">CIUDADES</a></li>';
                        echo '<li class="divider" style="background-color: #FFF;"></li>';
                        echo '<li><a href="crudCategorias.php">CATEGORIAS</a></li>';
                        echo '<li class="divider" style="background-color: #FFF;"></li>';
                        echo '<li><a href="reportes.php?anuncios-por-calificacion">ANUNCIOS POR CALIFICACION</a></li>';
                        echo '<li class="divider" style="background-color: #FFF;"></li>';
                        echo '<li><a href="reportes.php?cant-anun-user">ANUNCIOS POR USUARIO</a></li>';
                      echo '</ul>';
                    echo '</li>';
                  } 
                ?>
            </ul>

      </div>
</nav>

<div class="jumbotron text-center">
  <hr />
      <h2>Lista de ciudades</h2>
  <hr />
</div>

<hr />
<div class="container">  
  <?php 
    if ($search_results) {
      echo "<table class='table table-hover'>";
        echo "<tr>";
          echo "<td> Id Ciudad </td>";
          echo "<td> Nombre </td>";
        echo "</tr>";

      foreach ($search_results as $row) 
      {
          echo "<tr>";
            echo "<td>".$row['c_id']."</td>";
            echo "<td>".$row['c_name']."</td>";
            echo '<td><a href="editarCiudad.php?id='. $row['c_id'] .'&user_id='."$user_id".'">Editar</a></td>';
            echo '<td><a href="borrarCiudad.php?id='. $row['c_id'] .'&user_id='."$user_id".'">Borrar</a></td>';
    
          echo "</tr>";
      }
    }
   ?>
   <form method="post" class="form-signin">
        <p>Agregar ciudad</p><hr />
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
          <input type="text" class="form-control" name="txt_nombre" placeholder="Nombre ciudad" value="<?php if(isset($error)){echo $titulo;}?>" />
        </div>
      <div class="clearfix"></div><hr />
        <div class="form-group">
          <button type="submit" class="btn btn-default" name="btn-publicar">
              <i class="glyphicon glyphicon-plus"></i>&nbsp;Agregar Ciudad
            </button>
          <br />
        </div>
    </form>
  </div>
</body>
</html>