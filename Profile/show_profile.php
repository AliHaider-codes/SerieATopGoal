<?php
	$title = 'Profile'; 
	include("../Common/head.php");
    if (isset($_SESSION['id'])) {	
		include("../Common/navbar.php");
		require("../Database/connection.php");
?>
<div class="myDiv">
    <h1>Profile</h1><br>
    <p>E-mail: <?php echo $_SESSION['email']; ?></p><br>
    <p>First name: <?php echo $_SESSION['firstname']; ?></p><br>
	<p>Last name: <?php  echo $_SESSION['lname']; ?></p><br>
    <a href="update_profile.php"><button class="btn btn-primary">Edit</button></a>
    <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#exampleModal">Delete</button>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delete Account</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete your account? This wil permanently erase your account.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <a href="delete.php?id=<?php echo $_SESSION['id']; ?>"><button type="button" class="btn btn-primary">Delete</button></a>
            </div>
        </div>
    </div>
</div>
<?php 
    include("../Common/footer.php");
    }else{
		echo "</head><body>";
        header("Location: $baseurl/index.php");
		include("../Common/footer.php");		
		exit();
    }
?>