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
	if (isset($_GET['dataType']) && ($_GET['dataType'] < 1 || $_GET['dataType'] > 2))
	{
		header('Location: ../index.php?success=-1');
		exit();
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
		            		<form 
		            			<?php 
		            				if ($_GET['dataType'] == 1)
		            					echo "action='controlleurs/edittask.php'"; 
		            				else if ($_GET['dataType'] == 2)
		            					echo "action='controlleurs/edituser.php'"; 
		            			?> method="POST" id="dataEdit">
		            			<div class="mb-md-5 mt-md-4 pb-5">
		            				<img src="images/logo.png" width="300"></img>
		            				<?php
		            				if ($_GET['dataType'] == 1)
		            				{
		            					echo "<h2 class='fw-bold mb-2 text-uppercase'>MODIFICATION DE TâCHE</h2>
		              					<h6 class='fw-bold mb-2 text-uppercase'>Modification du tâche numéro: ".$_GET['dataId']."</h6>";

		              					echo "
										<div class='mb-3'>
									  		<label for='dataTaskPriority' class='form-label'>Priorité</label>
									  		<input type='number' id='dataTaskPriority' name='dataTaskPriority' form='dataEdit' class='form-control' placeholder='Changer la priorité'>
										</div>
		              					<div class='mb-3'>
									  		<label for='dataTaskText' class='form-label'>Tâche</label>
									  		<input type='text' id='dataTaskText' name='dataTaskText' form='dataEdit' class='form-control' placeholder='Tâche à faire' maxlength='128'>
										</div>
										<div class='mb-3'>
										  	<label for='dateTaskDL' class='form-label'>Date limite</label>
										  	<input type='datetime-local' id='dataTaskDL' name='dataTaskDL' form='dataEdit' class='form-control' min='".date('Y-m-d h:i', time()+86400)."'>
										</div>";
									}
		            				else if ($_GET['dataType'] == 2)
		            				{
		              					echo "<h2 class='fw-bold mb-2 text-uppercase'>MODIFICATION D'UTILISATEUR</h2>
		              					<h6 class='fw-bold mb-2 text-uppercase'>Modification d'utilisateur numéro: ".$_GET['dataId']."</h6>";

			              				echo "<div class='mb-3'>
										  	<label for='dataUsername' class='form-label'>Nom d'utilisateur</label>
										  	<input type='text' id='dataUsername' name='dataUsername' form='dataEdit' class='form-control' placeholder='Utilisateur' maxlength='24'>
										</div>
										<div class='mb-3'>
											<label for='dataUserLevel' class='form-label'>Poste</label>
											<select id='dataUserLevel' name='dataUserLevel' form='dataEdit' class='form-control'>
												<option value='0'>Stagaire</option>
												<option value='1'>Utilisateur</option>
												<option value='11'>Modérateur</option>
												<option value='111'>Chef des modérateurs</option>
												<option value='1111'>Administrateur</option>
												<option value='11111'>Gestionnaire</option>
											</select>
										</div>
										<div class='mb-3'>
										  	<label for='dataUserDateN' class='form-label'>Date de naissance</label>
										  	<input type='datetime-local' id='dataUserDateN' name='dataUserDateN' form='dataEdit' class='form-control' min='".date('Y-m-d h:i', strtotime('-18 year',time()))."'>
										</div>
										<div class='mb-3'>
											<label for='dataUserPhone' class='form-label'>Email</label>
											<input type='email' id='dataUserEmail' name='dataUserEmail' form='dataEdit' class='form-control' placeholder='Email' maxlength='48'>
										</div>
										<div class='mb-3'>
											<label for='dataUserPhone' class='form-label'>Numéro de GSM</label>
											<input type='tel' pattern='04[0-9]{8}' id='dataUserTel' name='dataUserTel' form='dataEdit' class='form-control' placeholder='(04xxxxxxxx)'>
										</div>
										<div class='mb-3'>
										  	<label for='dataUserAddr' class='form-label'>Adresse de résidence</label>
										  	<input type='text' id='dataUserAddr' name='dataUserAddr' form='dataEdit' class='form-control' placeholder='Adresse de résidence' maxlength='128'>
										</div>
										";
									}
		              				?>
		              				<button data-mdb-button-init data-mdb-ripple-init class="btn btn-success btn-lg px-5" id="dataId" name="dataId" form="dataEdit" type="submit" <?php echo "value='".$_GET['dataId']."'" ?>>Modifier</button>
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