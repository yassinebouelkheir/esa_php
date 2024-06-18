<!--
	@filename  : logout.php 
    @projet    : Task Organiser
    @author    : Yassine BOUELKHEIR
    @version   : 1.0
    @created   : 18/06/2024
-->

<?php
	session_start();
	if (!isset($_SESSION['dataUsername']))
	{
		header('Location: login.php');
	}
	else
	{
		session_unset();
		session_destroy();
		header('Location: login.php');
	}
	exit();
?>