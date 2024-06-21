<!--
	@filename  : edit.php 
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
		exit();
	}
	if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
	    session_unset();
	    session_destroy();
	    header('Location: login.php');
		exit();
	}
	$_SESSION['LAST_ACTIVITY'] = time();

	if ($_SESSION['dataUserPermissions'] < 11 || !isset($_GET['dataId']) || !isset($_GET['dataType']))
	{
		header('Location: denied.php');
		exit();
	}		
	if (isset($_POST['dataAction']) && !isset($_POST['dataId']))
	{
		header('Location: ../index.php');
		exit();
	}	

	include 'controlleurs/functions.php';

	$error = "";
	
	if (isset($_POST['dataId']))
	{
		if ($_POST['dataPasswordEntry'] != $_POST['dataPasswordConfirmation'])
			$error = 1;
		else
		{
			$userArray = getUsers(0);
			$password = sha1($_POST['dataPassword']);
			for ($i = 0; $i < sizeof($userArray); $i++) 
			{
		        if ($userArray[$i][0] != $_SESSION['dataUserId']) continue;
	        	if ($userArray[$i][2] != $password)
	        	{
	        		$error = 2;
	        		break;
	        	}
	        	$userArray[$i][2] = $password;
	        	saveUsers(0, $userArray);
				header('Location: ../logout.php');
				exit();
			}
		}
	}	
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title></title>
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
		<link rel="stylesheet" href="css/styles.css">
	</head>
	<body>
		<section class="vh-100 gradient-custom">
		  	<div class="container py-5 h-100">
		    	<div class="row d-flex justify-content-center align-items-center h-100">
		      		<div class="col-12 col-md-8 col-lg-6 col-xl-5">
		        		<div class="card bg-light text-black" style="border-radius: 1rem;">
		          			<div class="card-body p-5 text-center">
		            		<form action='password.php' method="POST" id="dataEdit">
		            			<div class="mb-md-5 mt-md-4 pb-5">
		            				<img src="images/logo.png" width="300"></img>
									<h2 class='fw-bold mb-2 text-uppercase'>MODIFICATION DU MOT DE PASSE</h2>
									<div class='mb-3'>
								  		<label for='dataPassword' class='form-label'>Entrer le mot de passe actuel</label>
								  		<input type='password' id='dataPassword' name='dataPassword' form='dataEdit' class='form-control' placeholder='Changer la priorité'>
									</div>
									<div class='mb-3'>
								  		<label for='dataPasswordEntry' class='form-label'>Entrer le nouveau mot de passe</label>
								  		<input type='password' id='dataPasswordEntry' name='dataPasswordEntry' form='dataEdit' class='form-control' placeholder='Changer la priorité'>
									</div>
	              					<div class='mb-3'>
								  		<label for='dataPasswordConfirmation' class='form-label'>Re-entrer le nouveau mot de passe</label>
								  		<input type='password' id='dataPasswordConfirmation' name='dataPasswordConfirmation' form='dataEdit' class='form-control' placeholder='Tâche à faire' maxlength='128'>
									</div>
									<p class="text-danger mb-5">
										<?php 
											if ($error == 1)
												echo "Les deux nouveaux mot de passes ne sont pas identique.";
											else if ($error == 2)
												echo "Le mot de passe actuel n'est pas correct.";
										?>
									</p>
		              				<button data-mdb-button-init data-mdb-ripple-init class="btn btn-success btn-lg px-5" id="dataId" name="dataId" form="dataEdit" type="submit">Modifier</button>
		            				<br><br><button data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-lg px-5" name="dataAction" name="dataAction" form="dataEdit" type="submit" value="GoBack">Revenir en arrière</button>
		            			</div>
		            		</form>
		          			</div>
		        		</div>
		      		</div>
		    	</div>
		  	</div>
		</section>
	</body>
</html>