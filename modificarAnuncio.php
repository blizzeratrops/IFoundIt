<?php 
	session_start();
    require_once("biblioteca/user.php");
    require_once("biblioteca/dbconfig.php");

	$conn = conectarBD();
    $estate = $_GET['estado'];
    $anuncio_id = $_GET['id'];
    $sql = "UPDATE anuncios set estado = :estate where anuncio_id = :anuncio_id;";
    $stmt = runQuery($conn, $sql);
    $stmt->bindparam(":estate", $estate);
    $stmt->bindparam(":anuncio_id", $anuncio_id);
    $stmt->execute();

    redirect('profile.php');


 ?>