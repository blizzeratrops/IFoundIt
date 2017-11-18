<?php
session_start();
require_once("user.php");
require_once("dbconfig.php");

if (is_loggedin()==""){
	redirect('login.php');
}

echo "Crear anuncio.";

?>
