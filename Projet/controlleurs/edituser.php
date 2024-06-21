<!--
	@filename  : edituser.php 
    @projet    : Task Organiser
    @author    : Yassine BOUELKHEIR
    @version   : 1.0
    @created   : 19/06/2024
-->

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

	if ($_SESSION['dataUserPermissions'] < 11)
	{
		header('Location: ../denied.php');
		exit();
	}		
	if (!isset($_POST['dataId']) || !is_numeric($_POST['dataId']))
	{
		if (isset($_POST['dataAction']))
			header('Location: ../users.php');
		else
			header('Location: ../users.php?success=-1');
		exit();
	}

	include 'functions.php';

	$userArray = getUsers(1);
	for ($i = 0; $i < sizeof($userArray); $i++) 
	{	
	    if ($_POST['dataId'] == $userArray[$i][0])
	    {
	    	if (isset($_POST['dataUsername']) && !empty($_POST['dataUsername'])) $userArray[$i][1] = $_POST['dataUsername'];
	    	if (isset($_POST['dataUserLevel']) && !empty($_POST['dataUserLevel'])) $userArray[$i][3] = $_POST['dataUserLevel'];
	    	if (isset($_POST['dataUserDateN']) && !empty($_POST['dataUserDateN'])) $userArray[$i][4] = date('d-m-Y G:i', strtotime($_POST['dataUserDateN']));
	    	if (isset($_POST['dataUserEmail']) && !empty($_POST['dataUserEmail'])) $userArray[$i][5] = $_POST['dataUserEmail'];
	    	if (isset($_POST['dataUserTel']) && !empty($_POST['dataUserTel'])) $userArray[$i][6] = $_POST['dataUserTel'];
	    	if (isset($_POST['dataUserAddr']) && !empty($_POST['dataUserAddr'])) $userArray[$i][7] = $_POST['dataUserAddr'];
	    	break;
	    }
	}
	saveUsers(1, $userArray);
	header('Location: ../users.php?success=2');
	exit();
?>