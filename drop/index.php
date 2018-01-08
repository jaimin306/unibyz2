<?php
if(isset($_REQUEST["btn_submit"])){
	$localhost = "localhost";
	$username = "repairshop_admin";
	$password = "iwant$100";
	$db_name = "repairshop_nw";
	$link = mysql_connect($localhost, $username, $password);
	if (!$link) {
	    die('Could not connect: ' . mysql_error());
	}

	$sql = 'DROP DATABASE '.$db_name;
	if (mysql_query($sql, $link)) {
	    echo "Database ".$db_name." was successfully dropped\n";
	    echo '<a href="index.php"><input type="button" value="Back" /></a>';
	    die;
	} else {
	    echo 'Error dropping database: ' . mysql_error() . "\n";
	    echo '<a href="index.php"><input type="button" value="Back" /></a>';
	}	
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Drop Database</title>
</head>
<body>
<form method="post">
<input type="submit" value="Delete The Database" name="btn_submit">
</form>
</body>
</html>