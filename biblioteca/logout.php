<?php
	require_once('session.php');
	require_once('user.php');
	
	if(is_loggedin()!="")
	{
		redirect('../index.php');
	}
	if(isset($_GET['logout']) && $_GET['logout']=="true")
	{
		doLogout();
		redirect('../index.php');
	}
