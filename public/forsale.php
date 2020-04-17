<?php
	session_start();
	include('../connect_db/db_config.php');

	

	//FOR PAGINATION ---- GET CURRENT PAGE NUMBER
		if(isset($_GET['page_no']) && $_GET['page_no'] != ""){
			$page_no = $_GET['page_no'];
		}	else {
			$page_no = 1;
		}

		//SET TOTAL RECORDS PER PAGE
		$total_records_per_page = 6;

		//CALCULATE OFFSET VALUE AND SET OTHER VARIABLES
		$offset = ($page_no - 1) * $total_records_per_page;
		$previous_page = $page_no - 1;
		$next_page = $page_no + 1;
		// $adjacents = "2";

		//GET THE TOTAL NUMBER OF PAGES FOR PAGINATION
		$result_count = mysqli_query($db, "SELECT COUNT(*) AS total_records FROM agents WHERE land_avalability = 'sale' ") or die(mysqli_error($db));

		$total_records = mysqli_fetch_array($result_count);
	
		$total_records = $total_records['total_records'];
		$total_no_of_pages = ceil($total_records / $total_records_per_page);
		$second_last = $total_no_of_pages;

		//SQL QUERY FOR FETCHING LIMITED RECORDS USING LIMIT CLAUSE AND OFFSET
		$select = mysqli_query($db, "SELECT * FROM agents ORDER BY created_time DESC LIMIT $offset, $total_records_per_page ")
			or die(mysqli_error($db));

		mysqli_close($db);


?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="../css/style.css">
	<style type="text/css">

	.pagination{
		/*width: 100%;*/
			margin-left: 40%;
	}
		.pagination li{
			border: 1px solid #09f;
			width: 90px;
			padding: 6px;
			display: inline-block;
			border-radius: 5px;
			text-align: center;
			text-decoration: none;
		}
	</style>
</head>
<body>

	<div class="">
		<header>
			
			<div class="h-logo-img">
				<h2>Logo</h2>
			</div>
			<div class="h-site-name">
				<h2>Site Name</h2>
			</div>
			<nav>
				<a href="index.php">Home</a>
				<a href="../agent/agent_login.php">Agents</a>
			</nav>
		</header>

		<div class="second-container properties">
			<!-- <section class="side-bar">
				<div id="agent">
					<h2><a href="../agent/agent_login.php">AGENTS</a></h2>
				</div>
				<div id="ads">
					<h2>Ads</h2>
				</div>
			</section>
 -->		
 			
			<section>
				
				<?php while ($listings = mysqli_fetch_array($select)){ ?>
				<figure>
					<figcaption>
						<strong><?php echo $listings['description']; ?></strong>
					</figcaption>
					<img src="<?php echo $listings['image_path']; ?>" width="300" height="210" alt="property">
					<div id="detail">
						<h3>Heading </h3>
						<p>Price: <?php echo $listings['price']; ?></p>
						<p>Location: <?php echo $listings['location']; ?> </p>
						<p>Updated date: <?php echo $listings['created_time']; ?></p>
					</div>
				</figure>
				<?php } ?>




				
			</section>

		</div>
		<div >
			
		</div>
		<ul class="pagination">
			<li><?php echo $page_no ." of ". $total_no_of_pages ?></li>
			<?php if($page_no > 1) echo "<li><a href='?page_no = 1'>First page</a></li>"; ?>
			<li><a <?php if($page_no > 1 ) echo "href='?page_no=$previous_page'"; ?>>Previous</a></li>
			<li><a <?php if($page_no < $total_no_of_pages ) echo "href='?page_no=$next_page'"; ?>>Next</a></li>
		</ul>
		<footer>
			<div>
				<p>&copy; My Company, 2015. My company is a registered trademark of His Company</p>
			</div>
			<address>
				
			</address>
		</footer>
	</div>
	
</body>
</html>