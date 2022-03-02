<?php 
    $title = 'Marketplace'; 
    include('Common/head.php');
	include('Common/navbar.php');
	if(isset($_POST['submit'])){
		$idr=$_POST["price"];
		header("Location: marketplace.php?idr=$idr");
		exit();
	}else{
?>
	<div class="div_marketplace">
	<h2>Marketplace</h2>
	<div class="search">
		<form action="">
		<label for="price">Search a price range: </label>
			<select name="price" id="price">
				<option value="5">less than 5$</option>
				<option value="10">less than 10$</option>
				<option value="15">less than 15$</option>
				<option value="20">less than 20$</option>
			</select>
			<input type="submit" value="Submit">
		</form>
	</div>
	<div class="flex">
	<?php
	require("Database/connection.php");
	
	if(isset($_GET['price'])){
		$sql = "SELECT * FROM video WHERE idOwner IS NULL AND Price <= ?";
		$stmt = $mysqli -> prepare($sql);
		$stmt -> bind_param("s", $_GET['price']);
	}else{
		$sql = "SELECT * FROM video WHERE idOwner IS NULL";
		$stmt = $mysqli -> prepare($sql);
	}
	$stmt -> execute();
	$res = $stmt -> get_result();
	
	
	while($row = $res -> fetch_assoc()){
	?>
    <!--<div class = "marketplace">-->

	<!--<div>-->
	<div class="vid">
    <video class="center" width="100%" playsinline autoplay muted loop>
        <source src="Video/<?php echo $row['Name']; ?>" type="video/mp4">
	</video>

	<p class="center"><?php echo $row['Description']; ?></p>

	<?php 
	if(!isset($_SESSION['id'])) {
		?>
		<a href="RegLog/login.php">
	<?php 
	}else{//aggiungere funzione che aggiunge al carrello e quindi anche aggiungere alla richiesta l'id del video cliccato
	?>
	<a href="Profile/cart.php?action=add&idp=<?php echo $row['id'] ?>">
	<?php 
	} 
	?>
	<button type="submit" class="center btn btn-success"><?php echo $row['Price']; ?></button></a>
    <!--</div>-->
	</div>
	<?php
	}
	?>
	</div>
   </div>
    
    <?php 
	include('Common/footer.php'); 
	}
	?>