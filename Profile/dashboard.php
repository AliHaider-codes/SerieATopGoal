<?php 
    $title = 'Dashboard'; 
    include('../Common/head.php');
	include('../Common/navbar.php');
	if(isset($_SESSION["id"])){
?>
	<div class="div_marketplace">
	<h2>Dashboard</h2>
	<div class="flex">
	<?php
	require("../Database/connection.php");
	$sql = "SELECT * FROM video WHERE idOwner = ?";
    $stmt = $mysqli -> prepare($sql);
	$stmt -> bind_param("s", $_SESSION['id']);
    $stmt -> execute();

    $res = $stmt -> get_result();
	
	while($row = $res -> fetch_assoc()){
	?>
	<div class="vid">
    <video class="center" width="100%" playsinline autoplay muted loop>
        <source src="../Video/<?php echo $row['Name']; ?>" type="video/mp4">
	</video>
	</div>
	<?php
	}
	?>
	</div>
   </div>
    
    <?php 
	}else{
		header("Location : $baseurl/index.php");
		include('../Common/footer.php'); 
		exit();
	}
	include('../Common/footer.php'); 
	?>