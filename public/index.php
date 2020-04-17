<?php 
	require('../db/db-config.php');
 ?>
 <!DOCTYPE html>
 <html>
 <head>
 	<title>Brand Name</title>
 	<link rel="stylesheet" type="text/css" href="../bootstrap-4.0.0-dist/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../fontawesome-free-5.13.0-web/fontawesome-free-5.13.0-web/css/all.css">
	<link rel="stylesheet" type="text/css" href="../css/styles">
 </head>
 <body>
	<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
		<a class="navbar-brand" href="index.php">COMPANY NAME</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		
		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="navbar-nav mr-auto">
				<li class="nav-item active">
					<a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
				</li>
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						Lands
					</a>
					<div class="dropdown-menu aria-labelledby="navbarDropdown">
						<a class="dropdown-item" href="forsale.php">For Sale</a>
						<a class="dropdown-item" href="forrent.php">For Rent</a>
					</div>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#">Agents </a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#">About us </a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#">Contact us </a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="agent-login.php">Upload Property </a>
				</li>
			</ul>
			<div class="mr-5">
				<a href="login-verification.php"><button class="btn btn-outline-light bg-info text-light my-2 my-sm-0 ">Login</button></a>
				<a href="sign-up.php"><button class="btn btn-outline-light bg-warning text-light my-2 my-sm-0 ">Signup</button></a>
			</div>
			<!-- <form class="form-inline my-2 my-lg-0 mr-5">
				<input class="form-control mr--sm-2" type="search" placeholder="Search" aria-label="Search">
				<button class="btn btn-outline-light bg-info text-light my-2 my-sm-0">Search</button>
			</form> -->
		</div>
	</nav>
	<!-- <div class="container-fluid"> -->
	
		<div id="home-pg" class="d-flex justify-content-center text-center text-light ">
			<div class="card  bg-transparent home-card">
				<div class="card-body">
					<h1 class="card-title ">
						FIND YOUR NEXT LAND
					</h1>
					<p>Search Lands for sale and for rents in Nigeria</p>
				</div>
			</div>
		</div>	
	<!-- </div> -->



 	<script src="../jQuery3.2.1/jquery-3.2.1.js"></script>
 	<script src="../bootstrap-4.0.0-dist/js/bootstrap.min.js"></script>
 </body>
 </html>