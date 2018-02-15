<?php 
	session_start();
    require_once("biblioteca/user.php");
    require_once("biblioteca/dbconfig.php");

	$conn = conectarBD();
    $usr_id = $_GET['id'];
    $usuario = $_GET['user_id'];

    $user_id = $_SESSION['user_session'];

    $stmt = runQuery($conn,"SELECT * FROM usuarios WHERE usr_id=:user_id");
    $stmt->execute(array(":user_id"=>$user_id));
    $userRow=$stmt->fetch(PDO::FETCH_ASSOC);

    if (!$userRow['isadmin']) {
        redirect('index.php');
    }

    if ($usr_id != $usuario) {

        $sql = "DELETE FROM usuarios WHERE usr_id = :usr_id;";
        $stmt = runQuery($conn, $sql);
        $stmt->bindparam(":usr_id", $usr_id);
        $stmt->execute();

        crearLog("El usuario con id $usuario borro al usuario con id $usr_id.", 'INFO');
        auditoria($conn,'USUARIOS',$usuario,'DELETE');
    }else{
        crearLog("Accion no permitida el usuario con id $usuario intento borrarse a si mismo.", 'WARNING');
        
    }

    redirect('mostrarUsuarios.php');
 ?>