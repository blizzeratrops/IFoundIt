<?php
	require_once('session.php');
	require_once('user.php');
	if(is_loggedin()!="")
	{
		redirect('../index.php');
	}
	if(isset($_GET['logout']) && $_GET['logout']=="true")
	{
		crearLog("El usuario con ID:".$_SESSION['user_session']. " cerro sesion.", 'INFO');
		doLogout();
		redirect('../index.php');
	}
