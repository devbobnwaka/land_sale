<?php 
	require('../db/db-config.php');

	if(isset($_POST['sign-up'])){
		$error = [];

		if(empty($_POST['firstname'])){
			$error['firstname'] = "*";
		} else {
			$firstname = mysqli_real_escape_string($db, trim($_POST['firstname']));
		}

		if(empty($_POST['lastname'])){
			$error['lastname'] = "*";
		} else {
			$lastname = mysqli_real_escape_string($db, trim($_POST['lastname']));
		}
		if(empty($_POST['user_type'])){
			$error['user_type'] = "Please select the user type";
		} else {
			$user_type = mysqli_real_escape_string($db, trim($_POST['user_type']));
		}
		if(empty($_POST['sex'])){
			$error['sex'] = "please select your gender";
		} else {
			$sex = mysqli_real_escape_string($db, trim($_POST['sex']));
		}
		if(empty($_POST['email'])){
			$error['email'] = "*";
		} else {
			$mail = $_POST['email'];
			if(!preg_match("^[_a-z0-9-]+(\.[_a-z0-9]+)*@[a-z0-9]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^", $mail)) {
				$error['email'] = "*";
			} else{
				$email = mysqli_real_escape_string($db, trim($_POST['email']));
			}	
		}
		if(empty($_POST['number'])){
			$error['number'] = "*";
		} else{
			if(!is_numeric($_POST['number']) || strlen($_POST['number']) != 11 ){
				$error['number'] = "Invalid Phonenumber";
			} else{
				$number =  mysqli_real_escape_string($db, trim($_POST['number']));
			}
		}

		if(empty($_POST['password1'])){
			$error['password1'] = "*";
		} else {
			$password1 = mysqli_real_escape_string($db, trim($_POST['password1']));
		}

		if(empty($_POST['password2'])){
			$error['password2'] = "*";
		} else {
			$password2 = mysqli_real_escape_string($db, trim($_POST['password2']));
		}

		//COMPARING OLD PASSWORD WITH EXISTING PASSWORD
		if($password1 != $password2){
			$error['d_match'] = "Your password doesn't match";
		}

		if(empty($error)){
			if($user_type == "Agent"){
				$insert_agent = "INSERT INTO agents VALUES(NULL,'".$firstname."','".$lastname."','".$sex."','".$email."','".$number."','".md5($password2)."',NOW())";

				if(mysqli_query($db, $insert_agent )) { 
					echo "success";
				} else {
					$failed_msg = "Email is used by another agent!!!";
				}
			}	
			if($user_type == "User"){
				$insert_user = "INSERT INTO reg_users VALUES(NULL,'".$firstname."','".$lastname."','".$sex."','".$email."','".$number."','".md5($password2)."',NOW())";

				if(mysqli_query($db, $insert_user )) { 
					echo "success";
				} else {
					$failed_msg = "Email is used by another user!!!";
				}
			}
			
		}
	}
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
		</div>
	</nav>
	<div class="row">
		<div id="sign-up" class="container text-light col-xl-4 col-lg-5 col-md-6 col-sm-7 col-10">
			<form action="" method="post" class="needs-validation" novalidate>
				<div >
					<h2 class="text-danger"><?php if(isset($failed_msg)) echo $failed_msg; ?></h2>
					<div>
						<label for="validationCustom01">First Name</label>
						<input type="text" id="validationCustom01" class="form-control" placeholder="First Name" name="firstname" value="<?php if(isset($firstname)) echo $firstname?>"  required>
						<div class="valid-feedback">
							<!-- Looks good! -->
						</div>
					</div>
					<div>
						<label for="validationCustom02">Last Name</label>
						<input type="text" id="validationCustom02" class="form-control" placeholder="Last Name" name="lastname" value="<?php if(isset($lastname)) echo $lastname?>"  required>
						<div class="valid-feedback">
							<!-- Looks good! -->
						</div>
					</div>
					<fieldset class="form-group">
						<label for="validationCustom02"></label>
						<div class="text-danger">
								<?php if(isset($error['sex'])) echo " ".$error['sex'] ?>
						</div>
						<div class="form-check-inline">
							<input  class="form-check-input" type="radio" name="sex" value="M" <?php if(isset($sex) && $sex == "M") echo 'checked'?> />
							<label class="form-check-label text-light">Male</label>
						</div>
						<div class="form-check-inline">
							<input  class="form-check-input" type="radio" name="sex" value="F" 
							<?php if(isset($sex) && $sex == "F") echo 'checked'?> />
							<label class="form-check-label text-light">Female</label>
						</div>
					</fieldset>
					<fieldset class="form-group">
						<label for="validationCustom02"></label>
						<div class="text-danger">
								<?php if(isset($error['user_type'])) echo " ".$error['user_type'] ?>
						</div>
						<div class="form-check-inline">
							<input  class="form-check-input" type="radio" name="user_type" value="Agent" <?php if(isset($user_type) && $user_type == "Agent") echo 'checked'?> />
							<label class="form-check-label text-light">Agent</label>
						</div>
						<div class="form-check-inline">
							<input  class="form-check-input" type="radio" name="user_type" value="User" 
							<?php if(isset($user_type) && $user_type == "User") echo 'checked'?> />
							<label class="form-check-label text-light">User</label>
						</div>
					</fieldset>
					<!-- <div>
						<label for="validationCustomUsername">Username</label>
						<div class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text" id="inputGroupPrepend">@</span>
							</div>
							<input type="text" class="form-control" id="validationCustomUsername" placeholder="Username" aria-describedby="inputGroupPrepend" required>
							<div class="invalid-feedback">
								Please choose a username
							</div>
						</div>
					</div> -->
				</div> 
				<div>
					<div>
						<label for="validationCustom03">Email</label>
						<input type="email" id="validationCustom03" class="form-control" placeholder="Email (example: nwakachibueze@gmail.com)" name="email" value="<?php if(isset($mail)) echo $mail?>" required>
						<div class="valid-feedback ">
							<!-- <div class="invalid-feedback "> WE HAVE INVALID FEEDBACK TOO-->
							<!-- Please provide a valid Email. -->
						</div>
					</div>
					<div>
						<label for="validationCustom04">Number</label>
						<input type="number" id="validationCustom04" class="form-control" placeholder="Phonenumber (example: 080395508060)" name="number" value="<?php if(isset($number)) echo $number?>" required>
						<div class="valid-feedback">
							<!-- Please provide a valid Number. -->
						</div>
					</div>
					<div class="form-group">
						<div>
							<div class="text-danger">Please enter a difficult to guess password</div>
							<label for="validationCustom05">Password</label>
							<input type="password" id="validationCustom05" class="form-control" placeholder="Password" name="password1" value="<?php if(isset($password1)) echo $password1?>" required>
							<!-- <div class="valid-feedback">
								Looks good!
							</div> -->
						</div>
						<div>
							<label for="validationCustom05">Confirm Password</label>
							<input type="password" id="validationCustom05" class="form-control" placeholder="Confirm Password" name="password2" value="<?php if(isset($password2)) echo $password2?>" required>
							<!-- <div class="valid-feedback">
								Looks good!
							</div> -->
						</div>
					</div>
					
				</div>
				<!-- <div class="form-group">
					<div class="form-check">
						<input class="form-check-input" type="checkbox" value="" id="invalidCheck" required>
						<label class="form-check-label" for="invalidCheck"></label>
							Agree to terms and conditions
						</label>
						<div class="invalid-feedback">
							You must agree before submitting.
						</div>
					</div>
				</div> -->
				<button class="btn btn-primary" type="submit" name="sign-up">Submit form</button>
			</form>
		</div>
	</div>

	<script src="../js/custom.js"></script>
 	<script src="../jQuery3.2.1/jquery-3.2.1.js"></script>
 	<script src="../bootstrap-4.0.0-dist/js/bootstrap.min.js"></script>
 </body>
 </html>