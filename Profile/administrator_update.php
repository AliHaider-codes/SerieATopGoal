<?php
$title = 'Admin_Update'; 
include("../Common/head.php");
include("../Common/navbar.php");

if(isset($_SESSION['id'])&&$_SESSION['admin'] == 1){
	
	require("../Database/connection.php");

	$sql = "SELECT * FROM users";
    $stmt = $mysqli -> prepare($sql);
    $stmt -> execute();

    $res = $stmt -> get_result();
	
	if ($res) {	?>
		<br>
		<div class="table_div">
		<h1>Administrator Edit</h1>
		<div class="table-responsive">
		<table class="table table-striped table-hover">
			<tr>
			  <th>Id</th>
			 <!-- <th colspan="2">Price</th> -->
			  <th scope="col">Firstname</th>
			  <th scope="col">Lastname</th>
			  <th scope="col">Email</th>
			  <th scope="col">Role</th>
			  <th scope="col">Edit</th>
			</tr>
		  <?php
			$i=0;
			while($row = $res -> fetch_assoc()) {
			?>
				  <tr>
					<td><?php echo $row["id"]; ?></td>
					<td><?php echo $row["FirstName"]; ?></td>
					<td><?php echo $row["LastName"]; ?></td>
					<td><?php echo $row["Email"]; ?></td>
					<td><?php if($row["Admin"]===1)echo"Admin";else echo"User"; ?></td>
					<td><a href="update_profile.php?id=<?php echo $row['id'] ?>">Update</a></td>
				  </tr>
		   <?php
			$i++;
			}
			?>
		</table>
		</div>
	 <!--echo "<h2 align='center'>Numeri di utenti presenti nel Database = $i</h2>";-->
	 </div>
	 <?php
	}else{
		echo "<h1>No result found</h1>";
		echo "<meta http-equiv='refresh' content='3;url=$baseurl/dashboard.php'> ";
		include("../Common/footer.php");
		exit();
	}
include("../Common/footer.php");
}else{
	header("Location: $baseurl/index.php");
	include("../Common/footer.php");
	exit();
}
?>

