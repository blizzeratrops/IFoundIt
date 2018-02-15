<?php 
    session_start();
    require_once("biblioteca/user.php");
    require_once("biblioteca/dbconfig.php");

    $conn = conectarBD();
    $id_categoria = $_GET['id'];
    $usuario = $_GET['user_id'];

    $user_id = $_SESSION['user_session'];

    $stmt = runQuery($conn,"SELECT * FROM usuarios WHERE usr_id=:user_id");
    $stmt->execute(array(":user_id"=>$user_id));
    $userRow=$stmt->fetch(PDO::FETCH_ASSOC);

    if (!$userRow['isadmin']) {
        redirect('index.php');
    }
    

    $sql = "DELETE FROM categorias WHERE id_categoria = :id_categoria;";
    $stmt = runQuery($conn, $sql);
    $stmt->bindparam(":id_categoria", $id_categoria);
    $stmt->execute();

    crearLog("El usuario con id $usuario borro la ciudad con id $id_categoria.", 'INFO');
    auditoria($conn,'CATEGORIAS',$usuario,'DELETE');

    redirect('crudCategorias.php');
 ?>