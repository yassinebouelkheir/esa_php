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
	if (!isset($_POST['dataTaskId']) || empty($_POST['dataTaskId']))
	{
		header('Location: ../index.php');
		exit();
	}
	if (isset($_POST['dataTaskDL']) || !empty($_POST['dataTaskDL']))
	{

	}
	if (isset($_POST['dataTaskText']) || !empty($_POST['dataTaskText']))
	{

	}
?>