<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Connect</title>
</head>
<body>
	<?php
		mysql_connect("209.129.8.5","48075","48075cis");
		mysql_connect("48075");
		$query="SELECT * FROM '48075'.entity_assignment";
		$rs = mysql_query($query);
		while($record=mysql_fetch_array($rs)){
			echo "<tr>";
			echo "<td>".$record['name']."</td>";
			echo "<td>".$record['points_possible']."</td>";
			echo "<td>".$record['wieght']."</td>";
			echo "<td>".$record['score']."</td>";
			echo "</tr>";
		}
	?>
</body>
</html>