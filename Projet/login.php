<!--
	@filename  : login.php 
    @projet    : Task Organiser
    @author    : Yassine BOUELKHEIR
    @version   : 1.0
    @created   : 18/06/2024
-->

<?php
	session_start();
	if (isset($_SESSION['dataUsername']))
	{
		header('Location: index.php');
		exit();
	}

	include 'controlleurs/functions.php';

	$error = false;
	if (isset($_POST['dataUsername']) && isset($_POST['dataPassword']))
	{
		$userArray = getUsers(0);
		foreach ($userArray as $data) 
		{
	        if ($data[1] == $_POST['dataUsername'])
	        {
	        	$password = sha1($_POST['dataPassword']);
	        	if ($password == $data[2])
	    		{
	    			$_SESSION['dataUserId'] = $data[0];
	    			$_SESSION['dataUserPermissions'] = $data[3];
	    			$_SESSION['dataUserDateN'] = $data[4];
	    			$_SESSION['dataUserEmail'] = $data[5];
	    			$_SESSION['dataUserTel'] = $data[6];
	    			$_SESSION['dataUserAddr'] = $data[7];
		    		$_SESSION['dataUsername'] = $_POST['dataUsername'];
		    		$_SESSION['LAST_ACTIVITY'] = time();
		    		if ($password == sha1($data[1]))
		    			$_SESSION['warningChangePassword'] = true;

					header('Location: index.php');
					exit();
	    		}
	        }
			$error = true;
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
		<form action="login.php" method="post">
			<section class="vh-100 gradient-custom">
			  	<div class="container py-5 h-100">
			    	<div class="row d-flex justify-content-center align-items-center h-100">
			      		<div class="col-12 col-md-8 col-lg-6 col-xl-5">
			        		<div class="card bg-light text-black" style="border-radius: 1rem;">
			          			<div class="card-body p-5 text-center">
			            			<div class="mb-md-5 mt-md-4 pb-5">
			            				<img src="images/logo.png" width="300"></img>
			              				<h2 class="fw-bold mb-2 text-uppercase">Connexion à <br>ESA Tâches</h2>
			              				<p class="text-black-50 mb-5">Année universitaire 2023-2024</p>
										<div data-mdb-input-init class="form-outline form-white mb-4">
											<label class="form-label" for="dataUsername">Nom d'utilisateur</label>
											<input type="text" id="dataUsername" name="dataUsername" class="form-control form-control-lg" maxlength='24' required="required"/>
										</div>
										<div data-mdb-input-init class="form-outline form-white mb-4">
											<label class="form-label" for="dataPassword">Mot de passe</label>
											<input type="password" id="dataPassword" name="dataPassword" class="form-control form-control-lg" maxlength='128' required="required"/>
										</div>
										<p class="text-danger mb-5">
										<?php 
											if ($error)
												echo "Nom d'utilisateur ou le mot de passe est incorrect.";
										?>
										</p>
			              				<button data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-lg px-5" type="submit">Login</button>
			            			</div>
			          			</div>
			        		</div>
			      		</div>
			    	</div>
			  </div>
			</section>
		</form>
	</body>
</html>