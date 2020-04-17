<?php 
	session_start();
	require('../db/db-config.php');
	
	if(isset($_POST['submit'])){
		$error = [];

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

		if(empty($_POST['password'])){
			$error['password'] = "*";
		} else {
			$pword = $_POST['password'];
			$password = md5(mysqli_real_escape_string($db, $pword));
		}

		if(empty($_POST['userType'])){
			$error['userType'] = "Please select a user type";
		}else{
			$userType = $_POST['userType'];
		}

		if(empty($error)){
			if($userType === "Agent"){
					$query = mysqli_query($db, "SELECT * FROM agents
								WHERE email ='".$email."' && password ='".$password."'") 
								or die(mysqli_error($db));

				if(mysqli_num_rows($query) == 1 ){
					$result = mysqli_fetch_array($query);

					$_SESSION['agent_id'] = $result['agent_id'];
					$_SESSION['firstname'] = $result['firstname'];
					$_SESSION['lastname'] = $result['lastname'];
					$_SESSION['sex'] = $result['sex'];
					$_SESSION['email'] = $result['email'];
					$_SESSION['phonenumber'] = $result['phone_number'];
					$_SESSION['date_reg'] = $result['date_reg'];

					header("location:../agent/agents-home.php");
				} else {
					$error_msg = "Invalid email or Password";
				}
			}

			if($userType === "User"){
					$query = mysqli_query($db, "SELECT * FROM reg_users
								WHERE email ='".$email."' && password ='".$password."'") 
								or die(mysqli_error($db));

				if(mysqli_num_rows($query) == 1 ){
					$result = mysqli_fetch_array($query);

					$_SESSION['agent_id'] = $result['agent_id'];
					$_SESSION['firstname'] = $result['firstname'];
					$_SESSION['lastname'] = $result['lastname'];
					$_SESSION['sex'] = $result['sex'];
					$_SESSION['email'] = $result['email'];
					$_SESSION['phonenumber'] = $result['phonenumber'];
					$_SESSION['date_reg'] = $result['date_reg'];

					//header("location:../agent/agents-home.php");
				} else {
					$error_msg = "Invalid email or Password";
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
			<div id="login" class="container col-xl-4 col-lg-5 col-md-6 col-sm-7 col-10 text-center text-light form-group-lg">
				<form action="" method="post" class="form-group">
					<div class="text-danger"><?php if(isset($error_msg)) echo $error_msg; ?></div>
					<div class="form-group">
						<label for="inputEmail">Email address <span class="text-danger"><?php if(isset($error['email'])) echo $error['email'] ?></span>
						</label>
						<input type="email" class="form-control <?php if(isset($error['email'])) echo 'input-error' ?> " id="inputEmail" aria-describedby="emailHelp" placeHolder="Enter email" name="email" value="<?php if(isset($mail)) echo $mail?>" autocomplete>
					</div>
					<div class="form-group">
						<label for="inputPassword">Password <span class="text-danger"><?php if(isset($error['password'])) echo $error['password'] ?></span></label>
						<input type="password" class="form-control <?php if(isset($error['password'])) echo 'input-error' ?>" id="inputPassword" aria-describedby="emailHelp" placeHolder="Enter password" name="password"  value="<?php if(isset($pword)) echo $pword?>"  autocomplete>
					</div>
					<fieldset class="form-group">
						<div class="text-danger">
								<?php if(isset($error['userType'])) echo " ".$error['userType'] ?>
						</div>
						<div class="form-check-inline">
							<input  class="form-check-input" type="radio" name="userType" value="User">
							<label class="form-check-label text-light">User</label>
						</div>
						<div class="form-check-inline">
							<input  class="form-check-input" type="radio" name="userType" value="Agent">
							<label class="form-check-label">Agent </label>
						</div>
					</fieldset>
					<div class="form-group">
						<button type="submit" class="btn btn-outline-light bg-primary text-light " name="submit">Submit</button>
					</div>
					<div class="form-group">
						<label class="form-check-label"><input type="checkbox"> Remember me</label>
					</div>
				</form>
				<div  class="container w-50 d-flex justify-content-center text-center text-light ">
					<div class="form-group">
						<label for="exampleInputPassword1">Not registered? </label>
						<a href="sign-up.php">
							<button class="btn btn-sm btn-outline-light bg-warning text-light my-2 my-sm-0 ">Signup</button>
						</a>
					</div>
				</div>
			</div>
		</div>
		
		
	<!-- </div> -->


	
 	<script src="../jQuery3.2.1/jquery-3.2.1.js"></script>
	<script src="../bootstrap-4.0.0-dist/js/bootstrap.min.js"></script>
 </body>
 </html>