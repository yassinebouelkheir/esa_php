<!--
	@filename  : functions.php 
    @projet    : Task Organiser
    @author    : Yassine BOUELKHEIR
    @version   : 1.0
    @created   : 18/06/2024
-->

<?php
	date_default_timezone_set('Europe/Brussels');
	
	function getTodos($folderindex)
	{
		$array = array();
		if ($folderindex == 0)
			$open = fopen('data/todos.csv', 'r');
		else 
			$open = fopen('../data/todos.csv', 'r');

		if ($open !== false) {
		    while (($data = fgetcsv($open, 1000, ";")) !== false) {
		        $array[] = $data;
		    }
		    fclose($open);
		}
		return $array;
	}

	function saveTodos($folderindex, array $array)
	{
		if ($folderindex == 0)
			$open = fopen('data/todos.csv', 'w+'); 
		else 
			$open = fopen('../data/todos.csv', 'w+');

		foreach ($array as $data)
		{
		   fputcsv($open, $data, ';'); 
		}   
		fclose($open);
	}

	function getUsers($folderindex)
	{
		$array = array();
		if ($folderindex == 0)
			$open = fopen('data/users.csv', 'r'); 
		else 
			$open = fopen('../data/users.csv', 'r');

		if ($open !== false) {
		    while (($data = fgetcsv($open, 1000, ";")) !== false) {
		        $array[] = $data;
		    }
		    fclose($open);
		}
		return $array;
	}

	function saveUsers($folderindex, array $array)
	{	
		if ($folderindex == 0)
			$open = fopen('data/users.csv', 'w+'); 
		else 
			$open = fopen('../data/users.csv', 'w+');

		foreach ($array as $data)
		{
		   fputcsv($open, $data, ';'); 
		}   
		fclose($open);
	}

	function getUsername($folderindex, $userId)
	{
		$userArray = getUsers($folderindex);
		foreach ($userArray as $data) 
        	if ($userId == $data[0])
	    		return $data[1];
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

	function issetSearch($resquestType, $postArray)
	{
		if ($resquestType == 1)
		{
			if ((isset($postArray['searchId']) || isset($postArray['searchUsername']) || isset($postArray['searchUserLevel']) || 
				isset($postArray['searchUserDateN']) || isset($postArray['searchUserEmail']) || isset($postArray['searchUserTel']) ||
				isset($postArray['searchUserAddr'])) && isset($postArray['searchAction']))
				return true;
		}
		else if ($resquestType == 2)
		{
			if ((isset($postArray['searchTaskId']) || isset($postArray['searchTaskPriority']) || isset($postArray['searchTaskText']) || 
				isset($postArray['searchTaskDC']) || isset($postArray['searchTaskDL'])) && isset($postArray['dataUserId']))
				return true;
		}
		else if ($resquestType == 3)
		{
			if ((isset($postArray['searchVTaskId']) || isset($postArray['searchVTaskP']) || isset($postArray['searchVTaskText']) || 
				isset($postArray['searchVTaskDC']) || isset($postArray['searchVTaskDV']) || isset($postArray['searchVUserTask'])) && isset($postArray['dataUserId']))
				return true;
		}
		else return false;
	}	

	function timeRange($unixTimeSource, $unixTimeCompare)
	{
		if(abs($unixTimeSource - $unixTimeCompare) <= 86400)
			return true;
		else
	    	return false;
    }



















?>