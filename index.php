<?php 
    $title = 'Home'; 
    include('Common/head.php');
	include('Common/navbar.php');?>
    <div class="container">
        <div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#carouselExampleCaptions" data-slide-to="0" class="active"></li>
                <li data-target="#carouselExampleCaptions" data-slide-to="1"></li>
                <li data-target="#carouselExampleCaptions" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="Img/mali.jpg" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item">
                    <img src="Img/zlatan.jpg" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item">
                    <img src="Img/victor.jpg" class="d-block w-100" alt="...">
                </div>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div><br><br>
        <h1>Our Goals</h1><br>
        <p>SerieATopGoal was created for all football fans who want to collect unique moments represented in equally unique videos (inspired by NFT). You can then buy these unique videos in the Marketplace by adding them to the cart from which you can complete the transaction and find the videos purchased in the very personal collection.</p><br>
        <ul>
        <li>Collect the defining actions from the serie a tim season</li>
        <li>Build a collection of actions from the players you love</li>
        <li>Every moment is unique and  individually numbered</li>
        </ul>
        <p>Get Epic moments, complete challanges for rewards, shop the Marketplace & brag about it to your friends</p>
    </div>
    <?php include('Common/footer.php');?>