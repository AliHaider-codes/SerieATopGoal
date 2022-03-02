<?php
mysqli_report(MYSQLI_REPORT_ERROR|MYSQLI_REPORT_STRICT);

$host = "localhost";
$username = "S4811831";
$password = "Freccia21";
$db = "S4811831";

$mysqli = new mysqli($host, $username, $password, $db);

if ($mysqli -> connect_errno) {
	echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
	exit();
}
?>