<!--
	@filename  : addtask.php 
    @projet    : Task Organiser
    @author    : Yassine BOUELKHEIR
    @version   : 1.0
    @created   : 18/06/2024
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
	if ($_SESSION['dataUserPermissions'] < 1111)
	{
		header('Location: ../denied.php');
		exit();
	}
	if (!isset($_POST['dataTaskDL']) || !isset($_POST['dataTaskText']) || !isset($_POST['dataTaskUser']) 
		|| !isset($_POST['dataTaskPriority']) || empty($_POST['dataTaskDL']) || empty($_POST['dataTaskText'])  
		|| empty($_POST['dataTaskPriority']))
	{
		header('Location: ../index.php?success=-1');
		exit();
	}		
	
	include 'functions.php';

	$lastid = -1;
	$todoArray = getTodos(1);
	foreach ($todoArray as $data) 
	{
		if ($data[0] != "Id")
		{
			$lastid += 1;
			$idexists = false; 
			foreach ($todoArray as $doublecheck) 
			{
				if ($doublecheck[0] == $lastid)
					$idexists = true;
			}
			if ($idexists == false) break;
		}
	}
	$unixTime = strtotime($_POST['dataTaskDL']);
	$newDate = date("d-m-Y G:i", $unixTime);

	$dataPush = array(strval($lastid+1), $_SESSION['dataUserId'], date('d-m-Y G:i'), $_POST['dataTaskUser'], $_POST['dataTaskText'], $newDate, "", 0, 0, $_POST['dataTaskPriority']);
	array_push($todoArray, $dataPush);
	usort($todoArray, function ($a, $b) {return $a['9'] > $b['9'];}); // source: https://stackoverflow.com/questions/50636675/php-sort-array-by-array-key
	saveTodos(1, $todoArray);
	header('Location: ../index.php?success=1');
	exit();
?>