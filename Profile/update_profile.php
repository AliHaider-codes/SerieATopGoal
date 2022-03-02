<?php 
    $title = 'Update'; 
    include("../Common/head.php");
	include("../Common/navbar.php");
	require("../Database/connection.php");
	if (isset($_POST['firstname'])) {
        $firstname = htmlspecialchars($_POST["firstname"]);
		$lastname  = htmlspecialchars($_POST["lastname"]);

		$ok = 'notokyet';
		$u_id = '';
		if(isset($_SESSION['id'])){
			$u_id = $_SESSION['id'];
			if(isset($_GET['id']) && $_GET['id']!=$_SESSION['id'] && $_SESSION['admin'] != 1)
				//se l'id di sessione è diverso dall'id nell'url allora solo chi è admin può modificare l'id associato al profile del get id quindi reindirizzo all'index page
				header("Location: index.php");
			else if(isset($_GET['id']) && $_GET['id'] == $_SESSION['id']){
				$ok = "equals";
				$u_id = $_SESSION['id'];
			}else if (isset($_GET['id']) && (($_GET['id']!=$_SESSION['id'] && $_SESSION['admin'] === 1) || ($_GET['id']==$_SESSION['id'] && $_SESSION['admin'] === 1))){
				$ok = 'ok';
				$u_id = $_GET['id'];
			}
		}else{
			header("Location: $baseurl/index.php");
			exit();
		}
		
        $sql = "UPDATE users SET FirstName = ?, LastName = ? WHERE id = ?";
        $stmt = $mysqli -> prepare($sql);
		$stmt -> bind_param("sss", $firstname, $lastname, $u_id);
		$stmt -> execute();
		
		if($stmt->affected_rows > 0){
			if($ok != 'ok'){
				$_SESSION['firstname'] = $firstname;
				$_SESSION['lname'] = $lastname;
			}
			echo "<div class ='myDiv'>
				<h3>User $u_id succesfully modified in $firstname & $lastname</h3>
				</div>";
			if($ok == 'equals'){
				echo "<meta http-equiv='refresh' content='3;url=$baseurl/Profile/show_profile.php'>";
				exit();
			}
			else{
				echo "<meta http-equiv='refresh' content='3;url=$baseurl/index.php'>";
				exit();
			}
		}else{
			echo "<div class ='myDiv'>
				<h3>Server error\nRedirecting to Administrator Edit in 3..2..1..</h3>
				</div>";
			echo "<meta http-equiv='refresh' content='3;url=$baseurl/Profile/administrator_update.php'>";
			exit();
		}
	}else{
		$ok = 'notokyet';
		$u_id = '';
		if(isset($_SESSION['id'])){
			$u_id = $_SESSION['id'];
			if(isset($_GET['id']) && $_GET['id']!=$_SESSION['id'] && $_SESSION['admin'] != 1)
				//se l'id di sessione è diverso dall'id nell'url allora solo chi è admin può modificare l'id associato al profile del get id
				header("Location: $baseurl/index.php");
			else if(isset($_GET['id']) && $_GET['id'] == $_SESSION['id']){
				$ok = "equals";
				$u_id = $_SESSION['id'];
			}
			else if (isset($_GET['id']) && (($_GET['id']!=$_SESSION['id'] && $_SESSION['admin'] === 1) || ($_GET['id']==$_SESSION['id'] && $_SESSION['admin'] === 1))){
				$ok = 'ok';
				$u_id = $_GET['id'];
				$u_sql = "SELECT * FROM users WHERE id = ?";
				$u_stmt = $mysqli -> prepare($u_sql);
				$u_stmt -> bind_param("s", $u_id);
				$u_stmt -> execute();

				$u_res = $u_stmt -> get_result();
				$u_row = $u_res -> fetch_assoc();
			}
		}else{
			header("Location: $baseurl/index.php");
			exit();
		}
?>
    <div class="myDiv">
	<?php if($ok == 'ok') echo "E-Mail: ". $u_row['Email']; else echo "E-Mail: ".$_SESSION['email'];?><br><br>
        <form action="" method="post" >
			First name:<br>
			<input type="text" id="firstname" name="firstname" value="<?php if($ok == 'ok') echo $u_row['FirstName']; else echo $_SESSION['firstname']; ?>"><br>
			Last name:<br>
			<input type="text" id="lastname" name="lastname" value="<?php if($ok == 'ok') echo $u_row['LastName']; else echo $_SESSION['lname']; ?>"><br><br>
			<input name="submit" type="submit" value="Update">
            <?php if($ok == 'ok'){?>
					<a href="administrator_update.php">
			<?php }else{?>
					<a href="show_profile.php">
			<?php } ?>
			<button type="button" class="btn btn-secondary">Back</button></a>
			<a href="delete.php?id=<?php echo $u_id; ?>"><button type="button" class="btn btn-secondary">Delete</button></a>
		</form>
    </div>
<?php 
	include("../Common/footer.php");
	}
?>