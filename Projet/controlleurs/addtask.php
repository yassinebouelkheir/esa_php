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
	if (!isset($_POST['dataTaskDL']) || !isset($_POST['dataTaskText'])
		|| empty($_POST['dataTaskDL']) || empty($_POST['dataTaskText']))
	{
		header('Location: ../index.php?success=-1');
		exit();
	}		
	
	include 'functions.php';

	$lastid = -1;
	$todoArray = getTodos(1);
	foreach ($todoArray as $data) 
	{
		if((intval($data[0])-1) != $lastid || ($data[0] == "Id")) 
			break;
		$lastid = intval($data[0]);
	}
	$lastid += 1;
	$unixTime = strtotime($_POST['dataTaskDL']);
	$newDate = date("d-m-Y G:i", $unixTime);

	$dataPush = array(strval($lastid), $_SESSION['dataUserId'], date('d-m-Y G:i'), $_POST['dataTaskUser'], $_POST['dataTaskText'], $newDate, "", 0, 0);
	array_push($todoArray, $dataPush);
	sort($todoArray);
	saveTodos(1, $todoArray);
	header('Location: ../index.php?success=1');
	exit();
?>