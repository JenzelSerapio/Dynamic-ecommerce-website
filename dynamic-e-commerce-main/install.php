<?php

include('./data_management/connectdb.php');

if (isset($_POST['installdb']))
{
	mysqli_query($link, 'CREATE DATABASE IF NOT EXISTS '.$dbname) or print(mysqli_error($link));
	mysqli_query($link, 'USE '.$dbname) or print(mysqli_error($link));

	$sql = file_get_contents("./data_management/initDB.sql");
	$sql_array = explode(";", $sql);
	foreach ($sql_array as $val)
	{
		if (substr($val, 0, 2) == '--' || $val == '')
    		continue;
		mysqli_query($link, $val) or print('Error performing query \'<strong>' . $val . '\': ' . mysqli_error($link) . '<br /><br />');
	}
	echo '<div class="itmtitle">Install Successful</div>';
}

?>

<html>
<head>
	<link href='//fonts.googleapis.com/css?family=Lato' rel='stylesheet'>
	<meta charset="UTF-8">
	<title>Install TechSwag</title>
	<link rel="stylesheet" type="text/css" href="index.css">
</head>

<body>

	<form action="install.php" method="post" class="delete">
		<input type="submit" class="loginsubm" style="width: 100%;" name="installdb" value="INSTALL DB AND TABLES" />
	</form>

</body>

</html>