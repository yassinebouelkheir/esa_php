<?php
	session_start();
	if (!isset($_SESSION['dataUsername']))
	{
		header('Location: login.php');
		exit();
	}
	if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
	    session_unset();
	    session_destroy();
	    header('Location: login.php');
		exit();
	}
	$_SESSION['LAST_ACTIVITY'] = time();
	if ($_SESSION['dataUserPermissions'] < 1111)
	{
		header('Location: denied.php');
		exit();
	}
	if (!isset($_POST['dataUsername']) || !isset($_POST['dataUsername']))
	{
		header('Location: index.php');
		exit();
	}		
	
	include 'functions.php';

	function randomPassword() // source: https://stackoverflow.com/questions/6101956/generating-a-random-password-in-php
	{
	    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
	    $pass = array(); //remember to declare $pass as an array
	    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
	    for ($i = 0; $i < 8; $i++) {
	        $n = rand(0, $alphaLength);
	        $pass[] = $alphabet[$n];
	    }
	    return implode($pass); //turn the array into a string
	}

	function in_array_r($needle, $haystack) // source: https://stackoverflow.com/questions/47845852/check-if-particular-value-exists-in-multidimensional-array
	{
	    foreach ($haystack as $key => $subArr) 
	    {
	        if (in_array($needle, $subArr)) 
	        {
	            return $key;
	        }
	    }
    return false;
}

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
		header('Location: users.php?success=1');
		exit();
	}
	else
	{
		header('Location: users.php?success=0');
		exit();
	}
?>