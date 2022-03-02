<?php
	$title = 'Cart'; 
	include("../Common/head.php");
    include("../Common/navbar.php");
    if (isset($_SESSION['id'])) {
	
		require("../Database/connection.php");
		if(isset($_GET['action']) && $_GET['action'] == "add"){
			if(isset($_GET['idp'])){
				//verifica video già posseduto
				$v_sql = "SELECT * FROM video WHERE id = ?";
				$v_stmt = $mysqli -> prepare($v_sql);
				$v_stmt -> bind_param("s", $_GET['idp']);
				$v_stmt -> execute();
				$v_res = $v_stmt -> get_result();
				$v_row = $v_res -> fetch_assoc();
				
				if($v_stmt -> affected_rows > 0){
					if($v_row['idOwner'] != NULL){
							echo "<div class ='myDiv'>
									<h3>Exclusive Video is already owned by someone, redirected to the marketplace in 3..2..1..</h3>
								</div>";
						echo "<meta http-equiv='refresh' content='3;url=$baseurl/marketplace.php'>";
						exit();
					}
				}else{
					echo "<div class ='myDiv'>
					<h3>No videos found with that id, redirect to the marketplace in 3..2..1..</h3>
					</div>";
					echo "<meta http-equiv='refresh' content='3;url=$baseurl/marketplace.php'>";
					exit();
				}

				//verifica video già presente nel carrello
				$sql = "SELECT * FROM cart WHERE idUser = ?";
				$stmt = $mysqli -> prepare($sql);
				$stmt -> bind_param("s", $_SESSION['id']);
				$stmt -> execute();

				$res = $stmt -> get_result();
				while($row = $res -> fetch_assoc()){
					if($_SESSION['id'] == $row['idUser'] && $_GET['idp'] ==  $row['idVideo']){
						echo "<div class ='myDiv'>
								<h3>The exclusive Video is already present in the cart, redirected to the marketplace in 3..2..1..</h3>
							</div>";
					echo "<meta http-equiv='refresh' content='3;url=$baseurl/marketplace.php'>";
					exit();
					}
				}

				$sql2 = "INSERT INTO cart (idUser, idVideo) VALUES (?, ?)";
				$stmt2 = $mysqli -> prepare($sql2);
				$stmt2 -> bind_param("ss", $_SESSION['id'], $_GET['idp']);
				$stmt2 -> execute();
				//$res = $stmt -> get_result();
		
				if($stmt2 -> affected_rows > 0){
					echo "<div class ='myDiv'>
						<h3>Video successfully added to cart, redirect to marketplace in 3..2..1..</h3>
						</div>";
					echo "<meta http-equiv='refresh' content='1;url=$baseurl/marketplace.php'>";
					exit();
				}
				else{
					echo "<div class ='myDiv'>
					<h3>Unable to add video to cart, redirect to marketplace in 3..2..1..</h3>
					</div>";
					echo "<meta http-equiv='refresh' content='3;url=$baseurl/marketplace.php'>";
					exit();
				}	
			}else{
				header("Location: $baseurl/index.php");
				exit();
			}
		}else if(isset($_GET['action']) && $_GET['action'] == "visual"){	
				$sql3 = "SELECT * FROM cart JOIN video ON idVideo=id WHERE idUser = ?";
				$stmt3 = $mysqli -> prepare($sql3);
				$stmt3 -> bind_param("s", $_SESSION['id']);
				$stmt3 -> execute();

				$res3 = $stmt3 -> get_result();
				//$row = $res -> fetch_assoc();
				if($stmt3 -> affected_rows == 0){
					echo "<div class ='myDiv'>
								<h3>The cart is empty, redirect marketplace in 3..2..1..</h3>
							</div>";
					echo "<meta http-equiv='refresh' content='3;url=$baseurl/marketplace.php'>";
					exit();
				}
?>
				<div class="table_div">
					<table class="table table-striped table-hover">
					<h2 class="center">Carrello</h2>
						<tr>
						  <th scope="col" width="44.3%">Video</th>
						  <th scope="col" width="33.3%">Price</th>
						  <th scope="col" width="33.3%">Remove</th>
						</tr>
				<?php 
					$i=0;
					while($row3 = $res3 -> fetch_assoc()) {
						?>
							  <tr>
								<td><?php echo $row3["Name"]; ?></td>
								<td><?php echo $row3["Price"]; ?></td>
								<td><a href="cart.php?action=remove&idp=<?php echo $row3['id']; ?>"><button type="button" class="btn btn-secondary">Delete</button></a></td>
							  </tr>
					<?php
					$i= $i + $row3["Price"];
					}
					?>
					</table>
					<a href="cart.php?action=complete"><button type="button" class="btn btn-primary">Complete</button></a></div>
					<h2 style="color:white;" class="center">Total Price = <?php echo $i ;?> $</h2>
					
		<?php
		}else if(isset($_GET['action']) && $_GET['action'] == "remove"){
			if(!isset($_GET['idp'])){
				header("Location: $baseurl/index.php");
				exit();
			}
			$sql4 = "DELETE FROM cart WHERE idUser = ? AND idVideo = ?";
			$stmt4 = $mysqli -> prepare($sql4);
			$stmt4 -> bind_param("ss", $_SESSION['id'], $_GET['idp']);
			$stmt4 -> execute();
			$res4 = $stmt4 -> get_result();
			if($stmt4->affected_rows > 0){
				echo "<div class ='myDiv'>
						<h3>Video successfully removed from cart, redirect to cart view in 3..2..1..</h3>
					</div>";
				echo "<meta http-equiv='refresh' content='3;url=$baseurl/Profile/cart.php?action=visual'>";
				exit();
			}else{
				echo "<div class ='myDiv'>
							<h3>Failed to delete video from cart, redirect to cart view in 3..2..1..</h3>
					</div>";
				echo "<meta http-equiv='refresh' content='3;url=$baseurl/Profile/cart.php?action=visual'>";
				exit();
			}
		}else if(isset($_GET['action']) && $_GET['action'] == "complete"){
			$sql5 = "SELECT * FROM cart WHERE idUser = ?";
			$stmt5 = $mysqli -> prepare($sql5);
			$stmt5 -> bind_param("s", $_SESSION['id']);
			$stmt5 -> execute();
			$res5 = $stmt5 -> get_result();
			if($stmt5->affected_rows > 0){
				
			}else{
				echo "<div class ='myDiv'>
							<h3>Transaction failed, redirect to cart view in 3..2..1..</h3>
					</div>";
				echo "<meta http-equiv='refresh' content='3;url=$baseurl/Profile/cart.php?action=visual'>";
				exit();
			}
			$sql6 = "SELECT MAX(idTransaction) FROM transactionOK";
			$stmt6 = $mysqli -> prepare($sql6);
			$stmt6 -> execute();
			$res6 = $stmt6 -> get_result();
			$row6 = $res6 -> fetch_assoc();
			$idTransaction = 0;
			if($stmt6->affected_rows > 0){
				if(isset($row6['MAX(idTransaction)']) || $row6['MAX(idTransaction)'] != 0)
					$idTransaction = $row6['MAX(idTransaction)']+1;
			}else{
				echo "<div class ='myDiv'>
							<h3>Transaction failed, redirect to cart view in 3..2..1..</h3>
					</div>";
				echo "<meta http-equiv='refresh' content='3;url=$baseurl/Profile/cart.php?action=visual'> ";
				exit();
			}
			
			while($row5 = $res5 -> fetch_assoc()) {
					$sql7 = "INSERT INTO transactionOK (idTransaction, idUser, IdVideo) VALUES (?, ?, ?)";
					$stmt7 = $mysqli -> prepare($sql7);
					$stmt7 -> bind_param("sss",$idTransaction, $row5['idUser'], $row5['idVideo']);
					$stmt7 -> execute();
					$res7 = $stmt7 -> get_result();
					
					$sql_O = "UPDATE video SET idOwner = ? WHERE id = ?";
					$stmt_O = $mysqli -> prepare($sql_O);
					$stmt_O -> bind_param("ss",$row5['idUser'],$row5['idVideo']);
					$stmt_O -> execute();
					$res_O = $stmt_O -> get_result();
					
					$sql8 = "DELETE FROM cart WHERE idUser = ? AND idVideo = ?";
					$stmt8 = $mysqli -> prepare($sql8);
					$stmt8 -> bind_param("ss", $row5['idUser'], $row5['idVideo']);
					$stmt8 -> execute();
					$res8 = $stmt8 -> get_result();
						
					if($stmt7->affected_rows > 0 && $stmt8->affected_rows > 0 && $stmt_O->affected_rows > 0){
						$err = 'ok';
					}else{
						$err = 'err';
					}
			}
			
			if($err == 'ok'){
						echo "<div class ='myDiv'>
							<h3>Transazione eseguita con successo, reindirizzamento al profilo dove potrai visualizzare i tuoi nuovi acquisti nella tua collezione privata! 3..2..1..</h3>
							</div>";
						echo "<meta http-equiv='refresh' content='4;url=$baseurl/Profile/show_profile.php'>";
						exit();	
			}else{
						echo "<div class ='myDiv'>
							<h3>Transazione fallita, reindirizzamento alla home in 3..2..1..</h3>
							</div>";
						echo "<meta http-equiv='refresh' content='3;url=$baseurl/index.php'>";
						exit();
			}		
		}else{
			echo "<div class ='myDiv'>
							<h3>Unable to recognize the action, return to Home in 3..2..1 ..</h3>
							</div>";
			echo "<meta http-equiv='refresh' content='3;url=$baseurl/index.php'>";
						exit();
		}
    }else{
        header("Location: $baseurl/index.php");
		exit();
    }
include("../Common/footer.php");
?>