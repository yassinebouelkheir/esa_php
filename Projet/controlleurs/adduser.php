<!--
	@filename  : adduser.php 
    @projet    : Task Organiser
    @author    : Yassine BOUELKHEIR
    @version   : 1.0
    @created   : 18/06/2024
-->

<?php
	session_start();
	if (!isset($_SESSION['dataUsername']))
	{
		header('Location: ./login.php');
		exit();
	}
	if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
	    session_unset();
	    session_destroy();
	    header('Location: ./login.php');
		exit();
	}
	$_SESSION['LAST_ACTIVITY'] = time();

	if ($_SESSION['dataUserPermissions'] < 1111)
	{
		header('Location: ./denied.php');
		exit();
	}

	if (!isset($_POST['dataUsername']) || !isset($_POST['dataUsername']))
	{
		header('Location: ./index.php');
		exit();
	}		
	
	include 'functions.php';

	$lastid = -1;
	$userArray = getUsers();

	if(in_array_r($_POST['dataUsername'], $userArray) == false)
	{
		foreach ($userArray as $data) 
		{
			if((intval($data[0])-1) != $lastid || ($data[0] == "Id")) 
				break;
			$lastid = intval($data[0]);
		}

		$lastid += 1;
		$unixTime = strtotime($_POST['dataUserDateN']);
		$newDate = date("d/m/Y", $unixTime);
		$password = randomPassword();
		$password = sha1($password);

		$dataPush = array(strval($lastid), $_POST['dataUsername'], $password, $_POST['dataUserLevel'], $newDate, $_POST['dataUserEmail'], $_POST['dataUserPhone'], $_POST['dataUserAddr']);
		
		array_push($userArray, $dataPush);
		sort($userArray);
		saveUsers($userArray);
		header('Location: ./users.php?success=1');
		exit();
	}
	else
	{
		header('Location: ./users.php?success=0');
		exit();
	}
?>