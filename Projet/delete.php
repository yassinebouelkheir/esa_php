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
	if ($_SESSION['dataUserPermissions'] < 111)
	{
		header('Location: denied.php');
		exit();
	}		

	include 'functions.php';

	if (isset($_POST['dataAction']))
	{
		if (is_numeric($_POST['dataAction']))
		{
			$todoArray = getTodos();
			for ($i = 0; $i < sizeof($todoArray); $i++)
			{	
			    if($_POST['dataAction'] == $todoArray[$i][0])
			    {
			        unset($todoArray[$i]);
			        break;
			    }
			}
			saveTodos($todoArray);
			header('Location: index.php');
			exit();	
		}
		else
		{
			header('Location: index.php');
			exit();
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
		<form action="delete.php" method="post" id="dataDelete">
			<section class="vh-100 gradient-custom">
			  	<div class="container py-5 h-100">
			    	<div class="row d-flex justify-content-center align-items-center h-100">
			      		<div class="col-12 col-md-8 col-lg-6 col-xl-5">
			        		<div class="card bg-light text-black" style="border-radius: 1rem;">
			          			<div class="card-body p-5 text-center">
			            			<div class="mb-md-5 mt-md-4 pb-5">
			            				<img src="images/logo.png" width="300"></img>
			              				<h2 class="fw-bold mb-2 text-uppercase">CONFIRMATION DE SUPPRESSION</h2>
			              				<h6 class="fw-bold mb-2 text-uppercase">Suppression du tâche numéro: <?php echo $_GET['taskid']; ?></h6>
			              				<p class="text-black-50 mb-5">Cette action est irréversible, vous voulez vraiment continuer?</p>
			              				<button data-mdb-button-init data-mdb-ripple-init class="btn btn-danger btn-lg px-5" name="dataAction" form="dataDelete" type="submit" <?php echo "value='".$_GET['taskid']."'" ?>>Supprimer</button>
			            				<br><br><button data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-lg px-5" name="dataAction" form="dataDelete" type="submit" value="GoBack">Revenir en arrière</button>
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