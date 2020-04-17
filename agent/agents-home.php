<?php 
	session_start();
	require('../db/db-config.php');
	$agent_id = $_SESSION['agent_id'];
	$firstname = $_SESSION['firstname'];
	$lastname = $_SESSION['lastname'];
	$sex = $_SESSION['sex'];
	$email = $_SESSION['email'];
	$phonenumber = $_SESSION['phonenumber'];
	$agent_reg_date = $_SESSION['date_reg'];

	$select_agent_logo = mysqli_query($db, "SELECT l.* FROM agent_logos l 
					WHERE agent_id = '$agent_id' ");
	$row_logo = mysqli_fetch_array($select_agent_logo);	
	$logo = $row_logo['logo_path'];
	

	if(isset($_POST['upload'])){
		$error = [];
		$max_size = 4000000;
		 $extension = array("image/jpg", "image/jpeg","image/png");
 

		if(empty($_FILES['img']['name'])){	
			$error['img'] = "*This field cannot be empty";
		} elseif($_FILES['img']['size'] > $max_size) {
			$error['img'] = "*File too Large, Image should be within 4mb";
		} elseif(!in_array($_FILES['img']['type'], $extension)){
			$error['img'] = "*File type not supported";
		} else {
			$filename = $_FILES['img']['name'];
			$destination = '../land_images/'.$filename; 
			//move_uploaded_file($_FILES['img']['tmp_name'], $destination);
		}

		if(empty($_POST['purpose'])){
			$error['purpose'] = "*Select the land availability";
		} else {
			$purpose = $_POST['purpose'];
		}

		if(empty($_POST['price'])){
			$error['price'] = "*Enter the Price";
		} else {
			if(!is_numeric($_POST['price'])){
				$error['number'] = "*Numbers only";
			} else {
				$price = mysqli_real_escape_string($db, trim($_POST['price']));
			}
		}

		if(empty($_POST['size'])){
			$error['size'] = "*Enter Land Size";
		} else {
			$size = mysqli_real_escape_string($db, trim($_POST['size']));
		}

		if(empty($_POST['location'])){
			$error['location'] = "*Enter Land Location";
		} else {
			$location = mysqli_real_escape_string($db, trim($_POST['location']));
		}

		if(!empty($_POST['description'])){
			$description = mysqli_real_escape_string($db, trim($_POST['description']));
		}

		if(empty($error)){
			move_uploaded_file($_FILES['img']['tmp_name'], $destination);
			$insert_upload = "INSERT INTO land_listings VALUES(NULL,
													'".$destination."',
													'".$purpose."',
													'".$location."',
													'".$price."',
													'".$size."',
													'".$description."',
													NOW(),
													'".$agent_id."')";
			if(mysqli_query($db, "$insert_upload")) { 
				$success_msg = "Upload Succesful!!!";
			} else {
				$failed_msg = "Upload Failed!!!";
			}	
			// $success_msg = "Upload Succesful!!!";
		}
    
	}
 ?>
 <!DOCTYPE html>
 <html>
 <head>
 	<title>Brand Name</title>
 	<link rel="stylesheet" type="text/css" href="../bootstrap-4.0.0-dist/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../fontawesome-free-5.13.0-web/fontawesome-free-5.13.0-web/css/all.css">
	<link rel="stylesheet" type="text/css" href="../css/styles.css">
 </head>
 <body>
	<nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
		<a class="navbar-brand" href="../public/index.php">COMPANY NAME</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		
		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="navbar-nav mr-auto">
				<li class="nav-item active">
					<a class="nav-link" href="agents-home.php">
						<img src="<?php echo $logo ?>" alt="Logo" class="card-img-top logo-img-2"> Dashboard<span class="sr-only">(current)
						</span>
					</a>
				</li>
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						My properties
					</a>
					<div class="dropdown-menu aria-labelledby="navbarDropdown">
						<a class="dropdown-item" href="agent-forsale.php">For Sale</a>
						<a class="dropdown-item" href="agent-forrent.php">For Rent</a>
					</div>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#">About us </a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#">Contact us </a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="edit-profile.php">Edit Profile </a>
				</li>
			</ul>
			<a href="agent-logout.php"><button class="btn btn-warning">Logout</button></a>
			<!-- <form class="form-inline my-2 my-lg-0 mr-5">
				<input class="form-control mr--sm-2" type="search" placeholder="Search" aria-label="Search">
				<button class="btn btn-outline-light bg-info text-light my-2 my-sm-0">Search</button>
			</form> -->
		</div>
	</nav>
	<section class="jumbotron jum">
		<form action="" method="post" enctype="multipart/form-data" class="form-jum col-xl-5 col-lg-6 col-md-7 col-sm-8 col-xs-9 bg-light p-5"> 
			<div class="text-success h4"><?php if(isset($success_msg)) echo $success_msg; ?></div>
			<div class="text-success h4"><?php if(isset($failed_msg)) echo $failed_msg; ?></div>
				<h2 class="text-center mb-2 m-bottom p-4">Upload New Land</h2>
					<!-- IMAGE -->
					<div>
						<p class="form-group row">
							<span class="field-empty-msg">
								<?php if(isset($error['img'])) echo $error['img'] ?>
							</span>
							<label for="landImage " class="left-a w-50 h5">Upload Image</label>
							<input type="file" class="" name="img" />
						</p>
					</div>
					<!-- AVALABILITY -->
					<h5 class="left-a">Land Avalability</h5>
					<div class="form-group">
						<span class="field-empty-msg">
							<?php if(isset($error['purpose'])) echo $error['purpose'] ?>
						</span>
						<div class="form-check left-a">
							<input class="form-check-input" type="radio" name="purpose" value="sale"
								<?php if(isset($purpose) && $purpose == "sale") echo 'checked'?>
							/>
							<label class="form-check-label" for="Radios1">
								For sale
							</label>
						</div>
						<div class="form-check left-a">
							<input class="form-check-input" type="radio" name="purpose" value="rent"
								<?php if(isset($purpose) && $purpose == "rent") echo 'checked'?>
							/>
							<label class="form-check-label" for="Radios2">
								For rent
							</label>
						</div>
					</div>
					<!-- PRICE -->
					<div>
						<p class="form-group row">
						<span class="field-empty-msg">
							<?php if(isset($error['price'])) echo $error['price'] ?>
						</span>
							<label for="Price" class="h5">Property Price</label>
							<p class="input-group-prepend ml-0">
						          <span class="input-group-text ">N</span>
						          <input type="number"  name="price" class="form-control"
								value="<?php if(isset($price)) echo $price ?>" placeholder="Price in Naira"/>
						     </p>
						</p>
					</div>
					<!-- LAND SIZE -->
					<div>
						<span class="field-empty-msg">
							<?php if(isset($error['size'])) echo $error['size'] ?>
						</span>
						<p class="form-group row">
							<label for="landSize" class="h5">Land Size</label> 
							<input type="text" name="size" class="form-control"
							value="<?php if(isset($size)) echo $size ?>"/>
						</p>
					</div>
					<!-- LAND LOCATION -->
					<div >
						<span class="field-empty-msg">
							<?php if(isset($error['location'])) echo $error['location'] ?>
						</span>
						<p class="form-group row">
							<label for="landImage" class="h5">Property Location</label> 
							<input type="text" name="location" class="form-control"
							value="<?php if(isset($location)) echo $location ?>"/>
						</p>
					</div>
					<!-- DESCRIPTION -->
					<div >
						<p class="form-group row">
							<label for="landImage" class="h5">Property Description</label> 
							<textarea name="description" class="form-control"><?php if(isset($description)) echo $description ?></textarea>
						</p>
					</div>
					<button class="btn btn-primary" type="submit" name="upload">Upload</button>
				</form>
	</section>

 	<script src="../jQuery3.2.1/jquery-3.2.1.js"></script>
 	<script src="../bootstrap-4.0.0-dist/js/bootstrap.min.js"></script>
 </body>
 </html>