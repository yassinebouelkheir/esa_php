<!--
	@filename  : functions.php 
    @projet    : Task Organiser
    @author    : Yassine BOUELKHEIR
    @version   : 1.0
    @created   : 18/06/2024
-->

<?php
	date_default_timezone_set('Europe/Brussels');
	
	function getTodos()
	{
		$array = array();
		if (($open = fopen("./data/todos.csv", "r")) !== false) {
		    while (($data = fgetcsv($open, 1000, ";")) !== false) {
		        $array[] = $data;
		    }
		    fclose($open);
		}
		return $array;
	}

	function saveTodos(array $array)
	{
		$open = fopen('./data/todos.csv', 'w+'); 
		foreach ($array as $data)
		{
		   fputcsv($open, $data, ';'); 
		}   
		fclose($open);
	}

	function getUsers()
	{
		if (($open = fopen("./data/users.csv", "r")) !== false) {
		    while (($data = fgetcsv($open, 1000, ";")) !== false) {
		        $array[] = $data;
		    }
		    fclose($open);
		}
		return $array;
	}

	function saveUsers(array $array)
	{
		$open = fopen('./data/users.csv', 'w+'); 
		foreach ($array as $data)
		{
		   fputcsv($open, $data, ';'); 
		}   
		fclose($open);
	}

	function getUsername($userId)
	{
		$userArray = getUsers();
		foreach ($userArray as $data) 
        	if($userId == $data[0])
	    		return $data[1];
	}

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
?>