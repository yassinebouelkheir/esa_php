<?php
	session_start();
	if (!isset($_SESSION['dataUsername']))
	{
		header('Location: ../login.php');
		exit();
	}
	if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
	    session_unset();
	    session_destroy();
	    header('Location: ../login.php');
		exit();
	}
	$_SESSION['LAST_ACTIVITY'] = time();
	if ($_SESSION['dataUserPermissions'] < 11111)
	{
		header('Location: ../denied.php');
		exit();
	}		

	include 'functions.php';

	if (isset($_GET['userid']))
	{
		if (is_numeric($_GET['userid']))
		{
			$usersArray = getUsers();
			for ($i = 0; $i < sizeof($usersArray); $i++)
			{	
			    if(($_GET['userid'] == $usersArray[$i][0]) && ($_GET['userid'] != $_SESSION['dataUserId']))
			    {
			        unset($usersArray[$i]);
			        break;
			    }
			}
			saveUsers($usersArray);
			header('Location: ../users.php');
			exit();	
		}
		else
		{
			header('Location: ../users.php');
			exit();
		}
	}
?>