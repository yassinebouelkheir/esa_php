<!--
	@filename  : deletetask.php 
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
	if ($_SESSION['dataUserPermissions'] < 111)
	{
		header('Location: ../denied.php');
		exit();
	}		

	include 'functions.php';

	if (isset($_POST['dataAction']))
	{
		if (is_numeric($_POST['dataAction']))
		{
			$todoArray = getTodos(1);
			for ($i = 0; $i < sizeof($todoArray); $i++)
			{	
			    if($_POST['dataAction'] == $todoArray[$i][0])
			    {
			        unset($todoArray[$i]);
			        break;
			    }
			}
			saveTodos(1, $todoArray);
			header('Location: ../index.php');
			exit();	
		}
		else
		{
			header('Location: ../index.php');
			exit();
		}
	}
?>