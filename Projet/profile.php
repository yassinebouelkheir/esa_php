<!--
	@filename  : profile.php 
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
	
	if (isset($_POST['dataReturn']))
	{
		header('Location: index.php');
		exit();
	}

	$error="";
	if (isset($_POST['dataUpload']) && $_POST['dataFile'] == 'Upload the File')
	{
  		if (isset($_FILES['dataFile']) && $_FILES['dataFile']['error'] === UPLOAD_ERR_OK)
  		{
			$fileTmpPath = $_FILES['dataFile']['tmp_name'];
			$fileName = $_FILES['dataFile']['name'];
			$fileSize = $_FILES['dataFile']['size'];
			$fileType = $_FILES['dataFile']['type'];
			$fileNameCmps = explode(".", $fileName);
			$fileExtension = strtolower(end($fileNameCmps));
    		$newFileName = $_SESSION['dataUserId'] . '.' . $fileExtension;

  			$uploadFileDir = 'images/user/';
  			$dest_path = $uploadFileDir . $newFileName;
  			
	      	if(move_uploaded_file($fileTmpPath, $dest_path) == false) 
	      	{
	        	$error = 'Veuillez réssayez plus tard.';
	      	}
    	}
    	else
	  	{
	    	$error .= 'Error:' . $_FILES['dataFile']['error'];
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
		<form action="profile.php" method="post" id="dataProfile" enctype="multipart/form-data">
			<section class="vh-100 gradient-custom">
			  	<div class="container py-5 h-100">
			    	<div class="row d-flex justify-content-center align-items-center h-100">
			      		<div class="col-12 col-md-8 col-lg-6 col-xl-5">
			        		<div class="card bg-light text-black" style="border-radius: 1rem;">
			          			<div class="card-body p-5 text-center">
			            			<div class="mb-md-5 mt-md-4 pb-5">
			            				<img src="images/logo.png" width="300"></img>
			              				<?php 
				              				if (file_exists('images/users/'.$_SESSION['dataUserId'].'.jpeg'))
				              					echo "<img src='images/users/".$_SESSION['dataUserId'].".jpeg' style='border-radius: 50%;' width='150'></img>";
				              				else 
				              					echo "<img src='images/profile.png' width='150'></img>";

			              					$userlevel = "";
			              					if ($_SESSION['dataUserPermissions'] == 0) $userlevel = "Stagaire";
			              					if ($_SESSION['dataUserPermissions'] == 1) $userlevel = "Utilisateur";
			              					if ($_SESSION['dataUserPermissions'] == 11) $userlevel = "Modérateur";
			              					if ($_SESSION['dataUserPermissions'] == 111) $userlevel = "Chef des modérateur";
			              					if ($_SESSION['dataUserPermissions'] == 1111) $userlevel = "Administrateur";
			              					if ($_SESSION['dataUserPermissions'] == 11111) $userlevel = "Gestionnaire";

			              					echo "<h2 class='fw-bold mb-2 text-uppercase'>".$_SESSION['dataUsername']."</h2>";
			              					echo "<h4 class='text-black-50 fw-bold mb-2 text-uppercase'>".$userlevel."</h4>";
			              					echo "<h5 class='text-black-60 mb-3'>Date de naissance: <br>".$_SESSION['dataUserDateN']."</h5>";
			              					echo "<h5 class='text-black-60 mb-3'>Email: <br>".$_SESSION['dataUserEmail']."</h5>";
			              					echo "<h5 class='text-black-60 mb-3'>Tel: <br>".$_SESSION['dataUserTel']."</h5>";
			              					echo "<h5 class='text-black-60 mb-3'>Adresse: <br>".$_SESSION['dataUserAddr']."</h5>";
			              				?>
			            			</div>
			            			<input type="file" name="dataFile" form="dataProfile" accept=".jpeg"/>
			            			<button data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-lg px-5" name="dataUpload" form="dataProfile" type="submit" value="UploadFile">Changer la photo de profile</button><br><br>
			            			<button data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-lg px-5" name="dataReturn" form="dataProfile" type="submit" value="GoBack">Revenir à l'accueil</button>
			          			</div>
			        		</div>
			      		</div>
			    	</div>
			  </div>
			</section>
		</form>
	</body>
</html>