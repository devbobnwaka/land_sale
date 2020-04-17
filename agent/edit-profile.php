<?php 
	session_start();
	require('../db/db-config.php');

	$agent_id = $_SESSION['agent_id'];
	// $firstname1 = $_SESSION['firstname'];
	// $lastname1 = $_SESSION['lastname'];
	// $sex1 = $_SESSION['sex'];
	// $email1 = $_SESSION['email'];
	// $phonenumber1 = $_SESSION['phonenumber'];
	$agent_reg_date = $_SESSION['date_reg'];

	$select_agent_detail = mysqli_query($db, "SELECT a.* FROM agents a 	
					WHERE agent_id = '$agent_id' ");

	$select_agent_logo = mysqli_query($db, "SELECT l.* FROM agent_logos l 
					WHERE agent_id = '$agent_id' ");				 

	$row_details = mysqli_fetch_array($select_agent_detail);
	$firstname = $row_details['firstname'];
	$lastname = $row_details['lastname'];
	$sex = $row_details['sex'];
	$email = $row_details['email'];
	$phone_number = $row_details['phone_number'];
	$password = $row_details['password'];
	$date_reg = $row_details['date_reg'];

	$row_logo = mysqli_fetch_array($select_agent_logo);
	$logo = $row_logo['logo_path'];

	if(isset($_POST['edit'])){
		$error = [];

	//PRODUCT IMAGE
		$max_size = 4000000;
		$extension = array("image/jpg", "image/jpeg","image/png");

		if($logo == ''){
			if($_FILES['image']['size'] > $max_size) {
				$error['image'] = "File too Large, Image should be within 4mb"; 
			} elseif(!in_array($_FILES['image']['type'], $extension)){
				$error['image'] = "File type not supported";
			} else{
				$filename = $_FILES['image']['name'];
				$destination = '../logo_images/'.$filename; 
				$res = move_uploaded_file($_FILES['image']['tmp_name'], $destination);
				$insert = mysqli_query($db,"INSERT INTO agent_logos VALUES(NULL,
													'".$destination."',
													'".$agent_id."')");
			}
		}
		if(!empty($_FILES['image']['name'])){
			
			if($_FILES['image']['size'] > $max_size) {
				$error['image'] = "File too Large, Image should be within 4mb";
			} elseif(!in_array($_FILES['image']['type'], $extension)){
				$error['image'] = "File type not supported";
			} else{
				$filename = $_FILES['image']['name'];
				$destination = '../logo_images/'.$filename; 
				$res = move_uploaded_file($_FILES['image']['tmp_name'], $destination);
				$update = mysqli_query($db, "UPDATE agent_logos SET logo_path = '".$destination."' WHERE agent_id = '$agent_id' ");
			}
		}

		if(empty($_POST['firstname'])){
			$error['firstname'] = "*This field cannot be empty";
		} else {
			$firstname = mysqli_real_escape_string($db, trim($_POST['firstname']));
			$update = mysqli_query($db, "UPDATE agents SET firstname = '".$firstname."' WHERE agent_id = '$agent_id'  ");
		}
		if(empty($_POST['lastname'])){
			$error['lastname'] = "*This field cannot be empty";
		} else {
			$lastname = mysqli_real_escape_string($db, trim($_POST['lastname']));
			$update = mysqli_query($db, "UPDATE agents SET lastname = '".$lastname."' WHERE agent_id = '$agent_id'  ");
		}

		if(empty($_POST['sex'])){
			$error['sex'] = "*Select your gender";
		} else {
			$sex = mysqli_real_escape_string($db, trim($_POST['sex']));
			$update = mysqli_query($db, "UPDATE agents SET sex = '".$sex."' WHERE agent_id = '$agent_id'  ");
		}

		if(empty($_POST['email'])){
			$error['email'] = "*The field cannot be empty";
		} else {
			$email = mysqli_real_escape_string($db, trim($_POST['email']));
			$update = mysqli_query($db, "UPDATE agents SET email = '".$email."' WHERE agent_id = '$agent_id'  ");
		}

		if(empty($_POST['phone_number'])){
			$error['phone_number'] = "*The field cannot be empty";
		} else {
			$phone_number = mysqli_real_escape_string($db, trim($_POST['phone_number']));
			$update = mysqli_query($db, "UPDATE agents SET phone_number = '".$phone_number."' WHERE agent_id = '$agent_id'  ");
		}

		header("Refresh:0");
	}

	if(isset($_POST['change'])){
		$error = [];

		if(empty($_POST['old_password'])){
			$error['old_password'] = "Please enter old password";
		} else {
			$old_password = md5(mysqli_real_escape_string($db, trim($_POST['old_password'] )));
		}

		if(empty($_POST['new_password'])){
			$error['new_password'] = "Please enter new password";
		} else {
			$new_password = md5(mysqli_real_escape_string($db, trim($_POST['new_password'] )));
		}

		if(empty($_POST['confirm_password'])){
			$error['confirm_password'] = "Confirm password";
		} else {
			$confirm_password = md5(mysqli_real_escape_string($db, trim($_POST['confirm_password'] )));
		}

		//COMPARING OLD PASSWORD WITH EXISTING PASSWORD
		if($password != md5($_POST['old_password'])){
			$error['w_password'] = "This is not your current password";
		}

		if($_POST['new_password'] != $_POST['confirm_password']){
			$error['d_match'] = "New Password and Confirm Password doesn't match";
		}
		
		if(empty($error)){
			$update = mysqli_query($db,"UPDATE agents
								SET password ='".$confirm_password."' 
								WHERE agent_id = '$agent_id' ")
			or die(mysqli_error($db));
			$p_msg = "Password Changed Successfully!!!";
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
		</div>
	</nav>
	<section class="jumbotron jum">
		<div class="form-jum col-xl-5 col-lg-6 col-md-7 col-sm-8 col-xs-9 bg-light p-5">
			<form action="" method="post" enctype="multipart/form-data" class=" needs-validation" novalidate> 
				<h2 class="text-center p-4 m-bottom">Edit profile</h2>
			<div >
				<div class="h5 text-info"><?php if(isset($p_msg)) echo $p_msg ?></div>
				<div class="">
					<img src="<?php echo $logo ?>" alt="Logo" class="card-img-top logo-img">
					<p class="form-group ">
						<span class="field-empty-msg">
							<?php if(isset($error['img'])) echo $error['img'] ?>
						</span>
						<label for="landImage " class="text-center  h5">Update logo</label>
						<input type="file" class="" name="image" />
					</p>
				</div>

				<div>
					<div class="text-danger">
							<?php if(isset($error['firstname'])) echo " ".$error['firstname'] ?>
					</div>
					<label for="validationCustom01" class="h5">First Name</label>
					<input type="text" id="validationCustom01" class="form-control" placeholder="First Name" name="firstname" value="<?php if(isset($firstname)) echo $firstname?>"  required>
					<div class="valid-feedback">
						<!-- Looks good! -->
					</div>
				</div>
				<div>
					<div class="text-danger">
							<?php if(isset($error['lastname'])) echo " ".$error['lastname'] ?>
					</div>
					<label for="validationCustom02" class="h5">Last Name</label>
					<input type="text" id="validationCustom02" class="form-control" placeholder="Last Name" name="lastname" value="<?php if(isset($lastname)) echo $lastname?>"  required>
					<div class="valid-feedback">
						<!-- Looks good! -->
					</div>
				</div>
				<fieldset class="form-group text-dark">
					<label for="validationCustom02" ></label>
					<div class="text-danger">
							<?php if(isset($error['sex'])) echo " ".$error['sex'] ?>
					</div>
					<div class="form-check-inline">
						<input  class="form-check-input" type="radio" name="sex" value="M" <?php if(isset($sex) && $sex == "M") echo 'checked'?> />
						<label class="form-check-label " class="h6">Male</label>
					</div>
					<div class="form-check-inline">
						<input  class="form-check-input" type="radio" name="sex" value="F" 
						<?php if(isset($sex) && $sex == "F") echo 'checked'?> />
						<label class="form-check-label " class="h6">Female</label>
					</div>
				</fieldset>
			</div> 
			<div>
				<div>
					<div class="text-danger">
							<?php if(isset($error['email'])) echo " ".$error['email'] ?>
					</div>
					<label for="validationCustom03" class="h5">Email</label>
					<input type="email" id="validationCustom03" class="form-control" placeholder="Email (example: nwakachibueze@gmail.com)" name="email" value="<?php if(isset($email)) echo $email?>" required>
					<div class="valid-feedback ">
						<!-- <div class="invalid-feedback "> WE HAVE INVALID FEEDBACK TOO-->
						<!-- Please provide a valid Email. -->
					</div>
				</div>
				<div class="form-group">
					<div class="text-danger">
						<?php if(isset($error['phone_number'])) echo " ".$error['phone_number'] ?>
					</div>
					<label for="validationCustom04" class="h5">Phone number</label>
					<input type="number" id="validationCustom04" class="form-control" placeholder="Phonenumber (example: 080395508060)" name="phone_number" 
					value="<?php if(isset($phone_number)) echo $phone_number ?>" required>
					<div class="valid-feedback">
						<!-- Please provide a valid Number. -->
					</div>
				</div>
				
				
			</div>

			<div class="form-group">
				<button class="btn btn-primary" type="submit" name="edit">Submit form</button>	
			</div>
			
		</form>

		<p>
		  <button class="btn btn-warning" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
		    Change password
		  </button>
		</p>
		<div class="h6 text-info"><?php if(isset($p_msg)) echo $p_msg ?></div>
		<form action="" method="post" class="collapse" id="collapseExample" >
		  <div class="card card-body">
		   <div class="form-group">
				<div>
					<div class="text-danger">Please enter a difficult to guess password</div>
					<div class="text-danger">
						<?php if(isset($error['old_password'])) echo " ".$error['old_password'] ?>
					</div>
					<label for="validationCustom05"> Enter old password</label>
					<input type="password" id="validationCustom05" class="form-control" placeholder="Password" name="old_password" required>
					<!-- <div class="valid-feedback">
						Looks good!
					</div> -->
				</div>
				<div>
					<div class="text-danger">
						<?php if(isset($error['new_password'])) echo " ".$error['new_password'] ?>
					</div>
					<label for="validationCustom05">Enter new password</label>
					<input type="password" id="validationCustom05" class="form-control" placeholder="Enter new Password" name="new_password" required>
					<!-- <div class="valid-feedback">
						Looks good!
					</div> -->
				</div>
				<div class="form-group">
					<div class="text-danger">
						<?php if(isset($error['confirm_password'])) echo " ".$error['confirm_password'] ?>
					</div>
					<label for="validationCustom05">Confirm new password</label>
					<input type="password" id="validationCustom05" class="form-control" placeholder="Confirm Password" name="confirm_password" required>
					<!-- <div class="valid-feedback">
						Looks good!
					</div> -->
				</div>
				<button class="btn btn-danger" type="submit" name="change">Change password</button>
			</div>
		  </div>
		</form>
	</div>
	</section>

 	<script src="../jQuery3.2.1/jquery-3.2.1.js"></script>
 	<script src="../bootstrap-4.0.0-dist/js/bootstrap.min.js"></script>
 	<?php 
 			if(isset($p_msg)){
 				echo $p_msg;
 			}
 	 ?>
 </body>
 </html>