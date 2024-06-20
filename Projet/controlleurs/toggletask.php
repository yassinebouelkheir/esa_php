<!--
	@filename  : toggletask.php 
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
	if ($_SESSION['dataUserPermissions'] < 1)
	{
		header('Location: ../denied.php');
		exit();
	}		

	include 'functions.php';

	if (!isset($_GET['taskid']) || !is_numeric($_GET['taskid']))
	{
		header('Location: ../index.php?success=-1');
		exit();
	}
	
	$todoArray = getTodos(1);
	for ($i = 0; $i < sizeof($todoArray); $i++) 
	{	
	    if ($_GET['taskid'] == $todoArray[$i][0])
	    {
	    	$todoArray[$i][7] = ($todoArray[$i][7] ? 0 : 1);
	    	if ($todoArray[$i][7] == 0)
	    	{
	    		$todoArray[$i][6] = "";
	    		$todoArray[$i][8] = -1;
	    	}
	    	else
	    	{
	    		$todoArray[$i][6] = date('d-m-Y G:i');
	    		$todoArray[$i][8] = $_SESSION['dataUserId'];
	    	}
	    	break;
	    }
	}
	saveTodos(1, $todoArray);
	header('Location: ../index.php?success=4');
	exit();
?>