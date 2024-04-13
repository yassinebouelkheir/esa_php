<?php
	error_reporting(E_ERROR | E_PARSE);

	$dir = $_GET["dir"];
	$files = 0;
	if (empty($dir) == 1)
		$dir = "/";

	$files = scandir($dir, SCANDIR_SORT_ASCENDING);
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css"/>
		<title>Directory Lister</title>
	</head>
	<body>
		<main class="container">
	  		<hgroup>
				<h2>Directory Lister</h2>
				<p>New way to navigate</p>
			</hgroup>
			<form action="index.php" method="GET">
				<fieldset>
			    	<label>
			     		Directory to view
			    		<input name="dir" placeholder=""/>
			    	</label>
			  	</fieldset>
			  	<input type="submit" value="Search"/>
			  	<?php
			  	if ($files == 0)
			  		echo "<h6 style='color: red;'>No such directory or access denied.</h6>";
			  	?>
			</form>
			<hgroup>
				<h3>Current Directory :</h3>
				<?php 
					if ($files != 0)
						echo "<p>". $dir ."</p>"; 
				?>
			</hgroup>
			<?php
			if ($files != 0) 
				foreach ($files as $file) 
				{
					if (is_dir($file))
				    	echo "<br><a href='index.php?dir=".$file."'>".$file."</a>" ;
				    else
				    	echo "<br><a href='index.php?dir=".$file."' class='secondary'>".$file."</a>";
				}
			?>
		</main>
	</body>
</html>