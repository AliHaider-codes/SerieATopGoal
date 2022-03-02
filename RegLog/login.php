<?php 
    $title = 'Log-in'; 
    include('../Common/head.php');?>
</head>
<body style="background-color: #001933;">
    <?php
    if (isset($_SESSION['id'])) {
        header("Location: $baseurl/index.php");
    }
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email  = htmlspecialchars(trim($_POST["email"]));
        $pass   = htmlspecialchars(trim($_POST["pass"]));
        require("../Database/connection.php");

        $sql = "SELECT * FROM users WHERE Email = ?";
        $stmt = $mysqli -> prepare($sql);
        $stmt -> bind_param("s", $email);
        $stmt -> execute();

        $res = $stmt -> get_result();
        $row = $res -> fetch_assoc();


        if(!$row || (isset($row["Pass"]) && !password_verify($pass, $row["Pass"])) ){
            echo "<p class='error'>incorrect credentials</p>\n";
            echo "</body></html>";
            header("Refresh:2; url=$baseurl/index.php");
            exit;
        }

        $_SESSION['id'] = $row["id"];
        $_SESSION['firstname'] = $row["FirstName"];
        $_SESSION['lname'] = $row["LastName"];
        $_SESSION['email'] = $row["Email"];
		$_SESSION['img'] = $row['Image'];
		$_SESSION['admin'] = $row['Admin'];

        header("Location: $baseurl/index.php");
    }
    ?>
	<img class="center" src="<?php echo $baseurl;?>/Img/tg.png" alt="logo" width="220px">
	<div class="myDiv">
        <h1>Log-in</h1>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
            E-mail:<br>
            <input type="email" id="email" name="email" required>
            Password:<br>
            <input type="password" id="pass" name="pass" required>
            <input type="submit" value="Submit">
        </form>
        <p>Don’t have an account? <br><a href='registration.php'>Register here</a></p>
        <p>Go back to <a href='../index.php'>Home</a></p>
    </div>
</body>
</html>