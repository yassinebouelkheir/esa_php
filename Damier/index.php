<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Daimen</title>
	</head>
	<body>
		<table width="600px" height="600px" cellspacing="0px" cellpadding="0px" border="1px">
			<?php
			for($row=1; $row < 8; $row++)
			{
			    echo "<tr>";
			    for($col=1; $col < 8; $col++)
			    {
			        echo "<td height=30px width=30px bgcolor=" . (($row + $col) % 2 == 0 ? "#FFFFFF" : "#000000")  . "></td>";
			    }
			    echo "</tr>";
			}
			?>
		</table>
	</body>
</html>