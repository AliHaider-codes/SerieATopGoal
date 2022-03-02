<?php 
$title = 'Delete'; 
include("../Common/head.php");
?>
</head>
<body>
<?php
if (!isset($_SESSION['id'])) {
	header("Location : $baseurl/index.php");
	include("../Common/footer.php");
	exit();
}
    require("../Database/connection.php");
	$u_id = $_SESSION['id'];
	if(isset($_GET['id']) && ($_GET['id'] == $_SESSION['id'] || ($_GET['id'] != $_SESSION['id'] && $_SESSION['admin'] === 1)))
		$u_id = $_GET['id'];
	else{
		header("Location: $baseurl/index.php");
		exit();
	}
	
    $sql = "DELETE FROM users WHERE id = ?";
    $stmt = $mysqli -> prepare($sql);
    $stmt -> bind_param("s", $u_id);
    $stmt -> execute();
    $res = $stmt -> get_result();
	
	if($stmt->affected_rows > 0){
		if(isset($_GET['id']) && $_GET['id'] != $_SESSION['id'] && $_SESSION['admin'] === 1){
			//se l'amministratore elimina un account non suo allora non devo distruggere la sessione
			echo "<div class ='myDiv'>
					<h3>User successfully deleted, redirected to home in 3..2..1..</h3>
			</div>";
			echo "<meta http-equiv='refresh' content='3;url=$baseurl/index.php'>";
			exit();
		}else{
			echo "<div class ='myDiv'>
					<h3>User successfully deleted, redirected to home in 3..2..1..</h3>
			</div>";
			session_destroy();
			echo "<meta http-equiv='refresh' content='3;url=$baseurl/index.php'>";
			exit();
		}
	}else{
		echo "<div class ='myDiv'>
					<h3>User deletion failed, redirect to home in 3..2..1..</h3>
			</div>";
		echo "<meta http-equiv='refresh' content='3;url=$baseurl/index.php'>";
		exit();
	}
	include("../Common/footer.php");
?>