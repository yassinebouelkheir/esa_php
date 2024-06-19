<!--
	@filename  : users.php 
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

	if ($_SESSION['dataUserPermissions'] < 11111)
	{
		header('Location: denied.php');
		exit();
	}	

	include 'controlleurs/functions.php';

	$result = "";
	$userArray = getUsers(0);
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
	<body style="background-image: none;">
		<nav class="navbar navbar-expand-lg navbar-light bg-light">
			<div class="container-fluid">
				<a class="navbar-brand" href="index.php"><img src="/images/slogo.png" alt="esa" width="60" height="55"></a>
				<div class="collapse navbar-collapse" id="navbarNavAltMarkup">
					<div class="navbar-nav">
						<a class="nav-link" aria-current="page" href="index.php">Accueil</a>
						<?php 
							if ($_SESSION['dataUserPermissions'] > 1111) {
								echo "<a class='nav-link active' href='users.php'>Utilisateurs</a>";
							}
						?>
					</div>
					<div class="navbar-nav ml-auto">
						<a class="nav-link" style="float: right;" href="profile.php">
							<?php
							if (file_exists('images/users/'.$_SESSION['dataUserId'].'.jpeg'))
              					echo "<img src='images/users/".$_SESSION['dataUserId'].".jpeg' style='border-radius: 50%;' class='img-circle special-img' width='30'>".$_SESSION['dataUsername'];
              				else 
              					echo "<img src='images/profile.png' class='img-circle special-img' width='30'>".$_SESSION['dataUsername'];
              				?>
						</a>
						<a class="nav-link" href="logout.php">Déconnexion</a>
					</div>
				</div>
			</div>
		</nav>
		<div class="container containerspecial">
	        <div class="row customrow">
	        	<div class="col-lg-12">
	                <h1>Utilisateurs</h1>
	                <?php 
	             		if (isset($_GET['success']))
						{
		                	if ($_GET['success'])
		                		echo "<h6 style='color: green;'>L'utilisateur a été ajouté avec success.<h6>";
		                	else 
		                		echo "<h6 style='color: red;'>Opération annulé, ce nom d'utilisateur existe déjà dans la base des données.<h6>";
	                	}
	                ?>
	                <table class="table table-bordered">
					  <thead>
					    <tr>
					      <th scope="col">ID</th>
					      <th scope="col">Nom d'utilisateur</th>
					      <th scope="col">Poste</th>
					      <th scope="col">Date de naissance</th>
					      <th scope="col">Email</th>
					      <th scope="col">Tél</th>
					      <th scope="col">Adresse</th>
					      <th scope="col"></th>
					    </tr>
					  </thead>
					  <tbody>
					  	<?php
							foreach ($userArray as $data) 
							{
								if($data[0] == "Id")
									continue;
								echo "<tr>";
								echo "<th scope='row'>".$data[0]."</th>";
								echo "<td>".$data[1]."</td>";
								$userlevel = "";
							    if ($data[3] == 0) $userlevel = "Stagaire";
		      					if ($data[3] == 1) $userlevel = "Utilisateur";
		      					if ($data[3] == 11) $userlevel = "Modérateur";
		      					if ($data[3] == 111) $userlevel = "Chef des modérateurs";
		      					if ($data[3] == 1111) $userlevel = "Administrateur";
		      					if ($data[3] == 11111) $userlevel = "Gestionnaire";
								echo "<td>".$userlevel."</td>";
								echo "<td>".$data[4]."</td>";
								echo "<td>".$data[5]."</td>";
								echo "<td>".$data[6]."</td>";
								echo "<td>".$data[7]."</td>";
								echo "<td><a class='nav-link' href='controlleurs/modifyuser.php?userid=".$data[0]."'>Modifier</a><a class='nav-link' href='confirmation.php?dataId=".$data[0]."&dataType=2'>Supprimer</a></td></tr>";
							}
					  	?>
					  </tbody>
					</table>
	            </div>
	        </div>
	        <div class='row customrowlast'>
	        	<div class='col-lg-12'>
	                <h1>Ajouter un nouvel utilisateur</h1>
	                <form action='controlleurs/adduser.php' method='POST' id='addUser'>
						<fieldset>
							<div class='mb-3'>
							  	<label for='dataUsername' class='form-label'>Nom d'utilisateur</label>
							  	<input type='text' id='dataUsername' name='dataUsername' form='addUser' class='form-control' placeholder="Entrer le nom d'utilisateur(e)" required="required">
							</div>
							<div class='mb-3'>
							  	<label for='dataUserLevel' class='form-label'>Poste</label>
							  	<select id="dataUserLevel" name="dataUserLevel" form='addUser' class='form-control' required="required">
									<option value="0">Stagaire</option>
									<option value="1">Utilisateur</option>
									<option value="11">Modérateur</option>
									<option value="111">Chef des modérateurs</option>
									<option value="1111">Administrateur</option>
									<option value="11111">Gestionnaire</option>
								</select>
							</div>
							<div class='mb-3'>
							  	<label for='dataUserDateN' class='form-label'>Date de naissance</label>
							  	<input type='date' id='dataUserDateN' name='dataUserDateN' form='addUser' class='form-control' min=".date('Y-m-d')." required="required">
							</div>
							<div class='mb-3'>
							  	<label for='dataUserEmail' class='form-label'>Email</label>
							  	<input type='email' id='dataUserEmail' name='dataUserEmail' form='addUser' class='form-control' placeholder="Entrer l'email" required="required">
							</div>
							<div class='mb-3'>
							  	<label for='dataUserPhone' class='form-label'>Numéro de tel</label>
							  	<input type='text' id='dataUserPhone' name='dataUserPhone' form='addUser' class='form-control' placeholder="Entrer le numéro de gsm" required="required">
							</div>
							<div class='mb-3'>
							  	<label for='dataUserAddr' class='form-label'>Adresse</label>
							  	<input type='text' id='dataUserAddr' name='dataUserAddr' form='addUser' class='form-control' placeholder="Entrer l'adresse de résidence" required="required">
							</div>
							<button type='submit' form='addUser' class='btn btn-primary' name='dataUserAction'>Ajouter et envoyer le mot de passe</button>
						</fieldset>
					</form>
	            </div>
	        </div>
	    <div>
	</body>
</html>