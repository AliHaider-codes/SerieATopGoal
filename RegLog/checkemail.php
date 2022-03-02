<?php
require("../Database/connection.php");
$email = trim($_POST["email"]);
$sql   = "SELECT Email FROM users WHERE Email = ?";

$stmt = $mysqli -> prepare($sql);
$stmt -> bind_param("s", $email);
$stmt -> execute();
$res = $stmt->get_result();
$res = $res->fetch_all();

if (!$email = filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL)) {
	echo "Check e-mail format";
}

if (count($res) > 0) {
	echo "E-mail already used, try a different one";
}
?>