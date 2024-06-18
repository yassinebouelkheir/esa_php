<?php
	date_default_timezone_set('Europe/Brussels');
	
	function getTodos()
	{
		$array = array();
		if (($open = fopen("data/todos.csv", "r")) !== false) {
		    while (($data = fgetcsv($open, 1000, ";")) !== false) {
		        $array[] = $data;
		    }
		    fclose($open);
		}
		return $array;
	}

	function saveTodos(array $array)
	{
		$open = fopen('data/todos.csv', 'w+'); 
		foreach ($array as $data)
		{
		   fputcsv($open, $data, ';'); 
		}   
		fclose($open);
	}

	function getUsers()
	{
		if (($open = fopen("data/users.csv", "r")) !== false) {
		    while (($data = fgetcsv($open, 1000, ";")) !== false) {
		        $array[] = $data;
		    }
		    fclose($open);
		}
		return $array;
	}

	function saveUsers(array $array)
	{
		$open = fopen('data/users.csv', 'w+'); 
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
?>