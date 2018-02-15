<?php 
	session_start();
    require_once("biblioteca/user.php");
    require_once("biblioteca/dbconfig.php");

	$conn = conectarBD();
    $estate = $_GET['estado'];
    $anuncio_id = $_GET['id'];
    $usuario = $_GET['user_id'];

    $sql = "UPDATE anuncios set estado = :estate where anuncio_id = :anuncio_id;";
    $stmt = runQuery($conn, $sql);
    $stmt->bindparam(":estate", $estate);
    $stmt->bindparam(":anuncio_id", $anuncio_id);
    $stmt->execute();

    crearLog("El usuario con id $usuario modifico el anuncio $anuncio_id y puso su estado a $estate.", 'INFO');
    auditoria($conn,'ANUNCIOS',$usuario,'UPDATE');

    redirect('profile.php');


 ?>