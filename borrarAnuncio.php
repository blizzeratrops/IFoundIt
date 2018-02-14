<?php 
	session_start();
    require_once("biblioteca/user.php");
    require_once("biblioteca/dbconfig.php");

	$conn = conectarBD();
    $anuncio_id = $_GET['id'];
    $usuario = $_GET['user_id'];

    $user_id = $_SESSION['user_session'];

    $stmt = runQuery($conn,"SELECT * FROM usuarios WHERE usr_id=:user_id");
    $stmt->execute(array(":user_id"=>$user_id));
    $userRow=$stmt->fetch(PDO::FETCH_ASSOC);

    if (!$userRow['isadmin']) {
        redirect('index.php');
    }

    $sql = "DELETE FROM anuncios WHERE anuncio_id = :anuncio_id;";
    $stmt = runQuery($conn, $sql);
    $stmt->bindparam(":anuncio_id", $anuncio_id);
    $stmt->execute();

    crearLog("El usuario con id $usuario borro el anuncio $anuncio_id.", 'INFO');

    redirect('profile.php');
 ?>