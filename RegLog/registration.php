<?php 
    $title = 'Sign-up'; 
    include('../Common/head.php');
    ?>
	<script src="script.js"></script>
</head>
<body style="background-color: #001933;">
	<?php
	if (isset($_SESSION['id'])) {
		header("Location: $baseurl/index.php");
	}
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$firstname = htmlspecialchars($_POST["firstname"]);
		$lastname  = htmlspecialchars($_POST["lastname"]);
		$email     = htmlspecialchars(trim($_POST["email"]));
		$pass      = htmlspecialchars(trim($_POST["pass"]));
		$confirm   = htmlspecialchars(trim($_POST["confirm"]));

		if (empty($firstname) || empty($lastname) || empty($email) || empty($pass) || empty($confirm)) {
			echo "<p class='error'>Check input data, some are missing</p>\n";
			echo "</body></html>";
			exit();
		}

		$error = "";

		// check email format
		if (!$email = filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL)) {
			$error .= "<p class='error'>Check e-mail format</p>\n";
		}

		// check if passwords match
		// minimal length
		if ($pass != $confirm) {
			$error .= "<p class='error'>Passwords do not match</p>\n";
		}

		if(strlen($pass) < 5) {
			$error .= "<p class='error'>Your password must be at least 5 characters</p>\n";
		}

		require("../Database/connection.php");

		$sql = "SELECT Email FROM users WHERE Email = ?";
		$stmt = $mysqli -> prepare($sql);
		$stmt -> bind_param("s", $email);
		$stmt -> execute();
		$res = $stmt->get_result();

		$res = $res->fetch_all();

		if (count($res) > 0) {
			$error .= "<p class='error'>Email address already used</p>\n";
		}


		// if problems with input
		if ($error) {
			echo $error;
			echo "</body>\n</html>";
			header("Refresh:3; url=registration.php");
			exit();
		}

		$hash = password_hash($pass, PASSWORD_DEFAULT);

		$sql = "INSERT INTO users (FirstName, LastName, Email, Pass) VALUES (?, ?, ?, ?)";
		$stmt = $mysqli -> prepare($sql);
		$stmt -> bind_param("ssss", $firstname, $lastname, $email, $hash);
		$stmt -> execute();
		$res = $stmt->get_result();

		header("Location: login.php");

		$stmt->close();

		$mysqli -> close();
	}
	?>
	<img class="center" src="<?php echo $baseurl;?>/Img/tg.png" alt="logo" width="220px">
	<div class="myDiv">
		<h1>Sign up</h1>
		<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
			First name:<br>
			<input type="text" id="firstname" name="firstname" placeholder="First name" required><br>
			Last name:<br>
			<input type="text" id="lastname" name="lastname" placeholder="Last name" required><br>
			E-mail:<br>
			<input type="email" id="email" name="email" placeholder="Email" required onchange="checkemail('checkemail.php');"><div id="emailerror" class="error"></div>
			Password:<br>
			<input type="password" id="pass" name="pass" placeholder="Password" required"><div id="passerror" class="error"></div>
			Confirm password:<br>
			<input type="password" id="confirm" name="confirm" placeholder="Confirm password" required><br><br>
			<input type="submit" value="Submit">
		</form>
		<p>Alredy registered? <a href='login.php'>Login Here</a></p>
		<p>Go back to <a href='<?php echo $baseurl;?>/index.php'>Home</a></p>
	</div>
</body>
</html>