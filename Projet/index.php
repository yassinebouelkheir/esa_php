<!--
	@filename  : index.php 
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

	include 'controlleurs/functions.php';

	$dataUsername = $_SESSION['dataUsername'];
	$dataUserId = $_SESSION['dataUserId'];

	$userArray = getUsers(0);
	$todoArray = getTodos(0);

	if (isset($_POST['dataUserId']))
	{
		if ($_POST['dataUserId'] == -1)
		{
    		$dataUsername = "Tout le monde";
    		$dataUserId = -1;
		}
		else
		{
			foreach ($userArray as $data) 
			{
	        	if ($_POST['dataUserId'] == $data[0])
	    		{
		    		$dataUsername = $data[1];
		    		$dataUserId = $data[0];
		    		break;
	    		}
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
		<script src="https://kit.fontawesome.com/222ae32bee.js" crossorigin="anonymous"></script>
		<link rel="stylesheet" href="css/styles.css">
	</head>
	<body style="background-image: none;">
		<nav class="navbar navbar-expand-lg navbar-light bg-light">
			<div class="container-fluid">
				<a class="navbar-brand" href="index.php"><img src="/images/slogo.png" alt="esa" width="60" height="55"></a>
				<div class="collapse navbar-collapse" id="navbarNavAltMarkup">
					<div class="navbar-nav">
						<a class="nav-link active" aria-current="page" href="index.php">Accueil</a>
						<?php 
							if ($_SESSION['dataUserPermissions'] > 1111)
								echo "<a class='nav-link' href='users.php'>Utilisateurs</a>";
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
		<?php 
			if ($_SESSION['dataUserPermissions'] > 111) 
			{
		        echo "<div class='row'>
		            <div class='col-lg-12'>
		            	<h5>Utilisateur sélectionné:</h5>
		            	<div class='input-group flex-nowrap'>
		            		<form action='index.php' method='POST' id='userSelect'>
							  	<select name='dataUserId' class='form-control' style='width: 280px;' form='userSelect'>";

						  		if ($dataUserId != -1) echo "<option value='-1' name='dataUserId'>-1 : Tout le monde</option>";
								echo "<option value='".$dataUserId."' selected>".$dataUserId." : ".$dataUsername."</option>";
								foreach ($userArray as $data) 
								{
								    if ($dataUserId != $data[0] && $data[1] != "Username")
									{
									    echo "<option value='".$data[0]."'>".$data[0]." : ".$data[1]."</option>";
								    }
							    }

							  	echo "</select>
							  	<button class='btn btn-primary' form='userSelect' type='submit'>Sélectionner</button>
							</form>
						</div>
		            </div>
		        </div>
		        <div class='row customrow'>";
	    	}
	        else 
	        	echo "<div class='row'>";
	    ?>
	            <div class="col-lg-12">
	                <h2>Tâches</h2>
	               	<?php 
	             		if (isset($_GET['success']))
						{
							switch ($_GET['success']) {
		                		case 1:
		                			echo "<h6 style='color: green;'>La tâche a été ajouté avec success pour l'utilisateur sélectionné.</h6>";
		                			break;
		                		case 2:
		                			echo "<h6 style='color: green;'>La tâche a été modifié et publié avec succes.</h6>";
		                			break;
		                		case 3:
		                			echo "<h6 style='color: green;'>La tâche a été supprimé définitivement du système.</h6>";
		                			break;
		                		case 4:
		                			echo "<h6 style='color: green;'>Le status du tâche a été modifié avec succes.</h6>";
		                			break;
		                		default:
		                			echo "<h6 style='color: red;'>Un problème technique est survenu, veuillez réessayer ultérieurement.</h6>";
		                			break;
							}
	                	}
	                ?>
	                
		                <table class="table table-bordered">
						  	<thead>
						    <tr>
						      <th scope="col">ID</th>
						      <th scope="col">Priorité</th>
						      <th scope="col">Tâche</th>
						      <th scope="col">Date de création</th>
						      <th scope="col">Date limite</th>
						      <th scope="col"></th>
						    </tr>
						  	</thead>
						  	<tbody>
						  	<?php
								foreach ($todoArray as $data) 
								{
							        if (($data[3] == $dataUserId || $data[3] == -1) && ($data[7] == 0))
							        {
							        	if (issetSearch(2, $_POST))
										{
											if (isset($_POST['searchTaskId']) && ($_POST['searchTaskId'] >= 0))
												if ($_POST['searchTaskId'] != $data[0]) continue;

											if (isset($_POST['searchTaskPriority']) && !empty($_POST['searchTaskPriority']))
												if ($_POST['searchTaskPriority'] != $data[9]) continue;

											if (isset($_POST['searchTaskText']) && !empty($_POST['searchTaskText']))
												if (!stristr(strval($data[4]), strval($_POST['searchTaskText']))) continue;

											if (isset($_POST['searchTaskDC']) && !empty($_POST['searchTaskDC']))
												if (!timeRange(strtotime($data[2]), strtotime($_POST['searchTaskDC']))) continue;

											if (isset($_POST['searchTaskDL']) && !empty($_POST['searchTaskDL']))
												if (!timeRange(strval($data[5]), strval($_POST['searchTaskDL']))) continue;
										}
									    echo "<tr>";
									    echo "<th scope='row'>".$data[0]."</th>";
									    echo "<td>".$data[9]."</td>";
									    echo "<td>".$data[4]."</td>";
									    echo "<td>".$data[2]."</td>";
									    if ((strtotime($data[5]) - time()) <= 86400)
									    	echo "<td style='color: red; font-weight: bold;'>";
									    else if ((strtotime($data[5]) - time()) <= 259200)
									    	echo "<td style='color: orange; font-weight: bold;'>";
									    else
									    	echo "<td>";

									    echo $data[5]."</td>";
									    echo "<td>";
									    if ($_SESSION['dataUserPermissions'] > 0)
									    	echo "<a href='controlleurs/toggletask.php?taskid=".$data[0]."'><i class='fas fa-calendar-check'></i></a>&nbsp;&nbsp;";
									    if ($_SESSION['dataUserPermissions'] > 1)
											echo "<a href='edit.php?dataId=".$data[0]."&dataType=1'><i class='fas fa-edit'></i></a>&nbsp;&nbsp;";
										if ($_SESSION['dataUserPermissions'] > 11)
											echo "<a href='confirmation.php?dataId=".$data[0]."&dataType=1'><i class='fas fa-trash-alt'></i></a>";
									    echo "</td></tr>";
							        }
								}
							  	if ($_SESSION['dataUserPermissions'] > 111) 
							  	{
			        				echo "
								  	<form action='controlleurs/addtask.php' method='POST' id='addTask'>
									  	<tr>
									      	<th scope='row'>x</th>
									      	<td>
										    	<input type='number' id='dataTaskPriority' name='dataTaskPriority' form='addTask' class='form-control' placeholder='Priorité' maxlength='24' required='required'>
										    </td>
										    <td>
										    	<input type='text' id='dataTaskText' name='dataTaskText' form='addTask' class='form-control' placeholder='Tâche à faire' maxlength='256' required='required'>
										    </td>
										    <td>x</td>
										    <td>
										      	<input type='datetime-local' id='dataTaskDL' name='dataTaskDL' form='addTask' class='form-control' min='".date('Y-m-d h:i', time()+86400)."' required='required'>
										    </td>
										    <td>
										      	<button type='submit' form='addTask' class='btn btn-primary' name='dataTaskUser' value='".$dataUserId."'><i class='fas fa-plus'></i></button>
										    </td>
									    </tr>
								    </form>";
							    }
						    ?>
						    <form action='index.php' method='POST' id='searchTask'>
							  	<tr>
							      	<th scope='row'>
							      		<input type='text' id='searchTaskId' name='searchTaskId' form='searchTask' class='form-control' placeholder='Identifiant' maxlength='24'>
							      	</th>
							      	<td>
								    	<input type='number' id='searchTaskPriority' name='searchTaskPriority' form='searchTask' class='form-control' placeholder='Priorité' maxlength='24'>
								    </td>
								    <td>
								    	<input type='text' id='searchTaskText' name='searchTaskText' form='searchTask' class='form-control' placeholder='Tâche' maxlength='256'>
								    </td>
								    <td>
								    	<input type='date' id='searchTaskDC' name='searchTaskDC' form='searchTask' class='form-control'>
								    </td>
								    <td>
								      	<input type='date' id='searchTaskDL' name='searchTaskDL' form='searchTask' class='form-control'>
								    </td>
								    <td>
								      	<button type='submit' form='searchTask' class='btn btn-primary' name='dataUserId' <?php echo "value='".$dataUserId."'"; ?>><i class='fas fa-search'></i></button>
								    </td>
							    </tr>
						    </form>
					  	</tbody>
					</table>
	            </div>
	        </div>
	        <div class="row customrow">
	        	<div class="col-lg-12">
	                <h2>Tâches validé</h2>
	                <table class="table table-bordered">
					  <thead>
					    <tr>
					      <th scope="col">ID</th>
					      <th scope="col">Priorité</th>
					      <th scope="col">Tâche</th>
					      <th scope="col">Date de création</th>
					      <th scope="col">Date limite</th>
					      <th scope="col">Date de validation</th>
					      <th scope="col">Validé par</th>
					      <th scope="col"></th>
					    </tr>
					  </thead>
					  <tbody>
					  	<?php
						foreach ($todoArray as $data) 
						{
					        if ($data[8] == $dataUserId && $data[7] == 1)
					        {
					        	$username = getUsername(0, $data[8]);
					 			if (issetSearch(3, $_POST))
								{
									if (isset($_POST['searchVTaskId']) && ($_POST['searchVTaskId'] >= 0))
										if ($_POST['searchTaskId'] != $data[0]) continue;

									if (isset($_POST['searchVTaskP']) && !empty($_POST['searchVTaskP']))
										if ($_POST['searchVTaskP'] != $data[9]) continue;

									if (isset($_POST['searchVTaskText']) && !empty($_POST['searchVTaskText']))
										if (!stristr(strval($data[4]), strval($_POST['searchVTaskText']))) continue;

									if (isset($_POST['searchVTaskDC']) && !empty($_POST['searchVTaskDC']))
										if (!timeRange(strtotime($data[2]), strtotime($_POST['searchVTaskDC']))) continue;

									if (isset($_POST['searchVTaskDL']) && !empty($_POST['searchVTaskDL']))
										if (!timeRange(strtotime($data[5]), strtotime($_POST['searchVTaskDL']))) continue;

									if (isset($_POST['searchVTaskDV']) && !empty($_POST['searchVTaskDV']))
										if (!timeRange(strtotime($data[6]), strtotime($_POST['searchVTaskDV']))) continue;

									if (isset($_POST['searchVUserTask']) && !empty($_POST['searchVUserTask']))
										if (!stristr(strval($username), strval($_POST['searchVUserTask']))) continue;
								}

							    echo "<tr>";
							    echo "<th scope='row'>".$data[0]."</th>";
							    echo "<td>".$data[9]."</td>";
							    echo "<td>".$data[4]."</td>";
							    echo "<td>".$data[2]."</td>";
							    echo "<td>".$data[5]."</td>";
							    echo "<td>".$data[6]."</td>";
							    echo "<td>".$username."</td>";
							    if ($_SESSION['dataUserPermissions'] > 0)
							    	echo "<td><a href='controlleurs/toggletask.php?taskid=".$data[0]."'><i class='fas fa-calendar-times'></i></a>&nbsp;&nbsp;";
							    if ($_SESSION['dataUserPermissions'] > 11)
							    	echo "<a href='confirmation.php?dataId=".$data[0]."&dataType=1'><i class='fas fa-trash-alt'></i></a>";
							    echo "</td></tr>";
					        }
						}
					  	?>
					  	<form action='index.php' method='POST' id='searchVTask'>
						  	<tr>
						      	<th scope='row'>
						      		<input type='text' id='searchVTaskId' name='searchVTaskId' form='searchVTask' class='form-control' placeholder='Identifiant' maxlength='24'>
						      	</th>
							    <td>
							    	<input type='number' id='searchVTaskP' name='searchVTaskP' form='searchVTask' class='form-control' placeholder='Tâche' maxlength='256'>
							    </td>
							    <td>
							    	<input type='text' id='searchVTaskText' name='searchVTaskText' form='searchVTask' class='form-control' placeholder='Tâche' maxlength='256'>
							    </td>
							    <td>
							    	<input type='date' id='searchVTaskDC' name='searchVTaskDC' form='searchVTask' class='form-control'>
							    </td>
							    <td>
							      	<input type='date' id='searchVTaskDL' name='searchVTaskDL' form='searchVTask' class='form-control'>
							    </td>
							    <td>
							      	<input type='date' id='searchVTaskDV' name='searchVTaskDV' form='searchVTask' class='form-control'>
							    </td>
							    <td>
							    	<input type='text' id='searchVUserTask' name='searchVUserTask' form='searchVTask' class='form-control' placeholder="Nom d'utilisateur" maxlength='24'>
							    </td>
							    <td>
							      	<button type='submit' form='searchVTask' class='btn btn-primary' name='dataUserId' <?php echo "value='".$dataUserId."'"; ?>><i class='fas fa-search'></i></button>
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