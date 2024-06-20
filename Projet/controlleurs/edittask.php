<!--
	@filename  : edittask.php 
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

	if ($_SESSION['dataUserPermissions'] < 11)
	{
		header('Location: ../denied.php');
		exit();
	}		
	if (!isset($_POST['dataId']) || !is_numeric($_POST['dataId']))
	{
		header('Location: ../index.php?success=-1');
		exit();
	}
	
	include 'functions.php';

	$todoArray = getTodos(1);
	for ($i = 0; $i < sizeof($todoArray); $i++) 
	{	
	    if($_POST['dataId'] == $todoArray[$i][0])
	    {
	    	if (isset($_POST['dataTaskText']) && !empty($_POST['dataTaskText'])) $todoArray[$i][4] = $_POST['dataTaskText'];
	    	if (isset($_POST['dataTaskDL']) && !empty($_POST['dataTaskDL'])) $todoArray[$i][5] = date('d-m-Y G:i', strtotime($_POST['dataTaskDL']));
	    	break;
	    }
	}
	saveTodos(1, $todoArray);
	header('Location: ../index.php?success=2');
	exit();
?>