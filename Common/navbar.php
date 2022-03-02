</head>
<body>
    <nav class="navbar sticky-top navbar-expand-lg navbar-dark px-5 py-2">
        <img class="navbar-brand" src="<?php echo $baseurl;?>/Img/tg.png" alt="logo" width="220px">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo $baseurl;?>/index.php">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo $baseurl;?>/marketplace.php">Marketplace</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo $baseurl;?>/contact.php">Contact Us</a>
                </li>
            </ul>
            <div class="mx-4">
                <?php if(!isset($_SESSION['id'])){ ?>
                <a href="<?php echo $baseurl;?>/RegLog/login.php"><button class="btn btn-primary">Login</button></a>
                <a href="<?php echo $baseurl;?>/RegLog/registration.php"><button class="btn btn-primary">SignUp</button></a>
                <?php } else{?>
				<ul class="navbar-nav mr-auto">
                <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <img src="<?php echo $baseurl;?>/Img/<?php echo $_SESSION['img'] ?>"  width="40px"> 
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <p class="dropdown-item"><?php echo $_SESSION['firstname'] ?></p>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="<?php echo $baseurl;?>/Profile/dashboard.php">Dashboard</a>
                            <a class="dropdown-item" href="<?php echo $baseurl;?>/Profile/show_profile.php">Profile</a>
                            <?php if($_SESSION['admin'] === 1){ ?>
                            <a class="dropdown-item" href="<?php echo $baseurl;?>/Profile/administrator_update.php">Admin</a>
                            <?php } ?>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="<?php echo $baseurl;?>/RegLog/logout.php">Logout</a>
                        </div>
                </li>	
				<li><a href="<?php echo $baseurl;?>/Profile/cart.php?action=visual"><button type="submit" class="center btn btn-primary" ><img src="<?php echo $baseurl;?>/Img/cart.jpg" alt="cart" width="28px"></button></a></li>
                </ul>
				<?php } ?>
            </div>
        </div>
    </nav>