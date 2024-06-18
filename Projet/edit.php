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
	if ($_SESSION['dataUserPermissions'] < 11)
	{
		header('Location: denied.php');
		exit();
	}		
	if (isset($_GET['taskid']))
	{

	}
	else
	{
		if (!isset($_POST['dataTaskId']) || empty($_POST['dataTaskId']))
		{
			header('Location: index.php');
			exit();
		}
		if (isset($_POST['dataTaskDL']) || !empty($_POST['dataTaskDL']))
		{

		}
		if (isset($_POST['dataTaskText']) || !empty($_POST['dataTaskText']))
		{

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
		<form action="edit.php" method="post" id="dataEdit">
			<section class="vh-100 gradient-custom">
			  	<div class="container py-5 h-100">
			    	<div class="row d-flex justify-content-center align-items-center h-100">
			      		<div class="col-12 col-md-8 col-lg-6 col-xl-5">
			        		<div class="card bg-light text-black" style="border-radius: 1rem;">
			          			<div class="card-body p-5 text-center">
			            			<div class="mb-md-5 mt-md-4 pb-5">
			            				<img src="images/logo.png" width="300"></img>
			              				<h2 class="fw-bold mb-2 text-uppercase">MODIFICATION DE TâCHE</h2>
			              				<h6 class="fw-bold mb-2 text-uppercase">Modification du tâche numéro: <?php echo $_GET['taskid']; ?></h6>
			              				<div class='mb-3'>
										  	<label for='dataTaskText' class='form-label'>Tâche</label>
										  	<input type='text' id='dataTaskText' name='dataTaskText' form='dataEdit' class='form-control' placeholder='Tâche à faire' maxlength='128'>
										</div>
										<div class='mb-3'>
										  	<label for='dateTaskDL' class='form-label'>Date limite</label>
										  	<?php echo "<input type='datetime-local' id='dataTaskDL' name='dataTaskDL' form='dataEdit' class='form-control' min='".date('Y-m-d h:i')."'>"; ?>
										</div>
			              				<button data-mdb-button-init data-mdb-ripple-init class="btn btn-success btn-lg px-5" id="dataTaskId" name="dataTaskId" form="dataEdit" type="submit" <?php echo "value='".$_GET['taskid']."'" ?>>Modifier</button>
			            				<br><br><button data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-lg px-5" name="dataAction" form="dataEdit" type="submit" value="GoBack">Revenir en arrière</button>
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