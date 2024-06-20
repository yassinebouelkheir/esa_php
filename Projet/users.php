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
		<script src="https://kit.fontawesome.com/222ae32bee.js" crossorigin="anonymous"></script>
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
							if (file_exists("images/users/".$_SESSION['dataUserId'].".jpeg"))
              					echo "<img src='images/users/".$_SESSION['dataUserId'].".jpeg?cachermv=".random_int(100, 999)."' style='border-radius: 50%;' class='img-circle special-img' width='30' height='30'>".$_SESSION['dataUsername'];
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
	                <h2>Utilisateurs</h2>
	                <?php 
	             		if (isset($_GET['success']))
						{
							switch ($_GET['success']) {
								case 0:
		                			echo "<h6 style='color: red;'>Opération annulé, ce nom d'utilisateur existe déjà dans la base des données.</h6>";
		                			break;
		                		case 1:
		                			echo "<h6 style='color: green;'>L'utilisateur a été ajouté avec success.</h6>";
		                			break;
		                		case 2:
		                			echo "<h6 style='color: green;'>Les données de L'utilisateur a été modifié avec succes.</h6>";
		                			break;
		                		case 3:
		                			echo "<h6 style='color: green;'>Le compte de l'utilisateur a été supprimé définitivement.</h6>";
		                			break;
		                		default:
		                			echo "<h6 style='color: red;'>Un problème technique est survenu, veuillez réessayer ultérieurement.</h6>";
		                			break;
							}
	                	}
	                ?>
	                <form action='controlleurs/adduser.php' method='POST' id='addUser'>
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
									if ($data[0] == "Id")
										continue;

									if (issetSearch(1, $_POST))
									{
										if (isset($_POST['searchId']) && !empty($_POST['searchId']))
											if ($_POST['searchId'] != $data[0]) continue;

										if (isset($_POST['searchUsername']) && !empty($_POST['searchUsername']))
											if (!str_contains(strval($data[1]), strval($_POST['searchUsername']))) continue;

										if (isset($_POST['searchUserLevel']) && !empty($_POST['searchUserLevel']))
											if ($_POST['searchUserLevel'] != $data[3]) continue;

										if (isset($_POST['searchUserDateN']) && !empty($_POST['searchUserDateN']))
											if ($_POST['searchUserDateN'] != $data[4]) continue;

										if (isset($_POST['searchUserEmail']) && !empty($_POST['searchUserEmail']))
											if (!str_contains(strval($data[5]), strval($_POST['searchUserEmail']))) continue;

										if (isset($_POST['searchUserTel']) && !empty($_POST['searchUserTel']))
											if (!str_contains(strval($data[6]), strval($_POST['searchUserTel']))) continue;

										if (isset($_POST['searchUserAddr']) && !empty($_POST['searchUserAddr']))
											if (!str_contains(strval($data[7]), strval($_POST['searchUserAddr']))) continue;
									}
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
									echo "<td><a href='edit.php?dataId=".$data[0]."&dataType=2'><i class='fas fa-edit'></i></a>&nbsp;&nbsp;<a href='confirmation.php?dataId=".$data[0]."&dataType=2'><i class='fas fa-trash-alt'></i></a></td></tr>";
								}
						  	?>
						  	<tr>
						  		<th scope='row'>x</th>
						  		<td><input type='text' id='dataUsername' name='dataUsername' form='addUser' class='form-control' placeholder="Nom d'utilisateur(e)" required="required"></td>
						  		<td>
						  			<select id="dataUserLevel" name="dataUserLevel" form='addUser' class='form-control' required="required">
										<option value="0">Stagaire</option>
										<option value="1">Utilisateur</option>
										<option value="11">Modérateur</option>
										<option value="111">Chef des modérateurs</option>
										<option value="1111">Administrateur</option>
										<option value="11111">Gestionnaire</option>
									</select>
								</td>
						  		<td>
						  			<input type='date' id='dataUserDateN' name='dataUserDateN' form='addUser' class='form-control' <?php echo "max='".date('Y-m-d', strtotime("-18 year", time()))."'" ?> required="required">
						  		</td>
						  		<td>
						  			<input type='email' id='dataUserEmail' name='dataUserEmail' form='addUser' class='form-control' placeholder="Email" maxlength='48' required="required">
						  		</td>
						  		<td>
						  			<input type='tel' pattern="04[0-9]{8}" id='dataUserPhone' name='dataUserPhone' form='addUser' class='form-control' placeholder="(04xxxxxxxx)" required="required">
						  		</td>
						  		<td>
						  			<input type='text' id='dataUserAddr' name='dataUserAddr' form='addUser' class='form-control' placeholder="Adresse" maxlength='64' required="required">
						  		</td>
						  		<td><button type='submit' form='addUser' class='btn btn-primary' name='dataUserAction'><i class='fas fa-plus'></i></button></td>
						  	</tr>
						  	</form>
						  	<form action='users.php' method='POST' id='searchUser'>
						  	<tr>
						      	<th scope='row'>
						      		<input type='text' id='searchId' name='searchId' form='searchUser' class='form-control' placeholder='Identifiant' maxlength='24'>
						      	</th>
						      	<td>
						      		<input type='text' id='searchUsername' name='searchUsername' form='searchUser' class='form-control' placeholder="Nom d'utilisateur" maxlength='24'>
						      	</td>
							    <td>
						  			<select id="searchUserLevel" name="searchUserLevel" form='searchUser' class='form-control'>
										<option value="0">Stagaire</option>
										<option value="1">Utilisateur</option>
										<option value="11">Modérateur</option>
										<option value="111">Chef des modérateurs</option>
										<option value="1111">Administrateur</option>
										<option value="11111">Gestionnaire</option>
									</select>
							    </td>
							    <td>
							    	<input type='datetime-local' id='searchUserDateN' name='searchUserDateN' form='searchUser' class='form-control'>
							    </td>
							    <td>
							    	<input type='text' id='searchUserEmail' name='searchUserEmail' form='searchUser' class='form-control' placeholder="Email" maxlength='48'>
							    </td>
							    <td>
							    	<input type='tel' pattern="04[0-9]{8}" id='searchUserTel' name='searchUserTel' form='searchUser' class='form-control' placeholder="(04xxxxxxxx)">
						  		</td>
						  		<td>
						  			<input type='text' id='searchUserAddr' name='searchUserAddr' form='searchUser' class='form-control' placeholder="Adresse" maxlength='64'>
						  		</td>
							    <td>
							      	<button type='submit' form='searchUser' class='btn btn-primary' name='searchAction' id='searchAction' value='search'><i class='fas fa-search'></i></button>
							    </td>
						    </tr>
						    </form>
					  	</tbody>
					</table>
	            </div>
	        </div>
	    <div>
	</body>
</html>