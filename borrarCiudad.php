<?php 
	session_start();
    require_once("biblioteca/user.php");
    require_once("biblioteca/dbconfig.php");

	$conn = conectarBD();
    $c_id = $_GET['id'];
    $usuario = $_GET['user_id'];

    $user_id = $_SESSION['user_session'];

    $stmt = runQuery($conn,"SELECT * FROM usuarios WHERE usr_id=:user_id");
    $stmt->execute(array(":user_id"=>$user_id));
    $userRow=$stmt->fetch(PDO::FETCH_ASSOC);

    if (!$userRow['isadmin']) {
        redirect('index.php');
    }
    

    $sql = "DELETE FROM ciudades WHERE c_id = :c_id;";
    $stmt = runQuery($conn, $sql);
    $stmt->bindparam(":c_id", $c_id);
    $stmt->execute();

    crearLog("El usuario con id $usuario borro la ciudad con id $c_id.", 'INFO');
    auditoria($conn,'CIUDADES',$usuario,'DELETE');


    redirect('crudCiudades.php');
 ?>