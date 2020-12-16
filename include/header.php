<?php 
	ob_start();
	include_once 'db/connect.php';
	session_start();
 ?>
<?php 
	// dang-ky
	if (isset($_POST['signin'])) {
		$name = $_POST['name'];
		$email = $_POST['email'];
		$pass = md5($_POST['password']);
		$address = $_POST['address'];
		$city = $_POST['city'];
		$phone = $_POST['phone'];
		$level = $_POST['level'];

		$check_email = mysqli_query($mysqli,"SELECT * FROM tbl_customer WHERE email = '$email'");
		if (mysqli_num_rows($check_email) > 0) {
			$_SESSION['email_err'] = 'Email exist !';
		}else{
			$insert_cus = mysqli_query($mysqli,"INSERT INTO tbl_customer(name,email,password,address,city,phone,level) values ('$name','$email','$pass','$address','$city','$phone','$level')");
		}
	}
	// end-dang-ky

	// dang-nhap
	if (isset($_POST['login'])) {
		$email = $_POST['email'];
		$pass = md5($_POST['password']);

		$check_login = mysqli_query($mysqli,"SELECT * FROM tbl_customer WHERE email = '$email' AND password = '$pass'");
		$get_account = mysqli_fetch_array($check_login);
		if (mysqli_num_rows($check_login) > 0) {
			$_SESSION['login_cus'] = $get_account['name'];
			$_SESSION['cusAdd'] = $get_account['address'];
			$_SESSION['cusPhone'] = $get_account['phone'];
			$_SESSION['cusEmail'] = $get_account['email'];
			header('location:index.php');
			ob_enf_flunch();
		}else{
			$_SESSION['login_fail'] = 'Error';
		}
	}
	// end-dang-nhap

	// dang-xuat
	if (isset($_GET['logout'])) {
		unset($_SESSION['login_cus']);
		unset($_SESSION['shopping_cart']);
	}
	// end-dang-xuat
 ?>
<!--
Author: W3layouts
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<!DOCTYPE html>
<html lang="zxx">

<head>
	<title>Phj Phj Store's</title>
	<!-- Meta tag Keywords -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="UTF-8" />
	<meta name="keywords" content="Electro Store Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design"
	/>
	<script>
		addEventListener("load", function () {
			setTimeout(hideURLbar, 0);
		}, false);

		function hideURLbar() {
			window.scrollTo(0, 1);
		}
	</script>
	<!-- //Meta tag Keywords -->

	<!-- Custom-Files -->
	<link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
	<!-- Bootstrap css -->
	<link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
	<!-- Main css -->
	<link rel="stylesheet" href="css/fontawesome-all.css">
	<!-- Font-Awesome-Icons-CSS -->
	<link href="css/popuo-box.css" rel="stylesheet" type="text/css" media="all" />
	<!-- pop-up-box -->
	<link href="css/menu.css" rel="stylesheet" type="text/css" media="all" />
	<!-- menu style -->
	<!-- //Custom-Files -->

	<!-- web fonts -->
	<link href="//fonts.googleapis.com/css?family=Lato:100,100i,300,300i,400,400i,700,700i,900,900i&amp;subset=latin-ext" rel="stylesheet">
	<link href="//fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i&amp;subset=cyrillic,cyrillic-ext,greek,greek-ext,latin-ext,vietnamese"
	    rel="stylesheet">
	<!-- //web fonts -->

</head>

<body>
	<!-- top-header -->
	<div class="agile-main-top">
		<div class="container-fluid">
			<div class="row main-top-w3l py-2">
				<div class="col-lg-4 header-most-top">
					<p class="text-white text-lg-left text-center">Offer Zone Top Deals & Discounts
						<i class="fas fa-shopping-cart ml-1"></i>
					</p>
				</div>
				<div class="col-lg-8 header-right mt-lg-0 mt-2">
					<!-- header lists -->
					<ul>
						<li class="text-center border-right text-white">
							<a class="play-icon popup-with-zoom-anim text-white" href="#small-dialog1">
								<i class="fas fa-map-marker mr-2"></i>Select Location</a>
						</li>
						<li class="text-center border-right text-white">
							<a href="#" data-toggle="modal" data-target="#exampleModal" class="text-white">
								<i class="fas fa-truck mr-2"></i>Track Order</a>
						</li>
						<li class="text-center border-right text-white">
							<i class="fas fa-phone mr-2"></i> 001 234 5678
						</li>
						<?php 
							if (!isset($_SESSION['login_cus'])) {
								# code...
							
						 ?>
						<li class="text-center border-right text-white">
							<a href="#" data-toggle="modal" data-target="#exampleModal" class="text-white">
								<i class="fas fa-sign-in-alt mr-2"></i> Log In </a>
						</li>
						<li class="text-center text-white">
							<a href="#" data-toggle="modal" data-target="#exampleModal2" class="text-white">
								<i class="fas fa-sign-out-alt mr-2"></i>Register </a>
						</li>
						<?php 
							}else{
						 ?>
						 <li class="text-center border-right text-white">
							<a href="?logout" class="text-white">
								<i class="fas fa-sign-in-alt mr-2"></i> Log Out </a>
						</li>
						<li class="text-center ml-3 text-white">
							 Hello <?php echo $_SESSION['login_cus'] ?> </a>
						</li>
						 <?php 
						 	}
						  ?>
					</ul>
					<!-- //header lists -->
				</div>
			</div>
		</div>
	</div>

	<!-- Button trigger modal(select-location) -->
	<div id="small-dialog1" class="mfp-hide">
		<div class="select-city">
			<h3>
				<i class="fas fa-map-marker"></i> Please Select Your Location</h3>
			<select class="list_of_cities">
				
					<option selected style="display:none;color:#eee;">Select City</option>
					<option>Ho Chi Minh City</option>
					<option>Hanoi</option>
					<option>DaNang</option>
				
			</select>
			<div class="clearfix"></div>
		</div>
	</div>
	<!-- //shop locator (popup) -->

	<!-- modals -->
	<!-- log in -->
	<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title text-center">Log In</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form action="" method="post">
						<?php 
							if (isset($_SESSION['login_fail'])) {
								echo '<script>alert("Email or password incorrect!")</script>';
								unset($_SESSION['login_fail']);
							}
						 ?>
						<div class="form-group">
							<label class="col-form-label">Email</label>
							<input type="text" class="form-control" placeholder="Email... " name="email" required="">
						</div>
						<div class="form-group">
							<label class="col-form-label">Password</label>
							<input type="password" class="form-control" placeholder="Password... " name="password" required="">
						</div>
						<div class="right-w3l">
							<input type="submit" class="form-control" name="login" value="Log in">
						</div>
						<div class="sub-w3l">
							<div class="custom-control custom-checkbox mr-sm-2">
								<input type="checkbox" class="custom-control-input" id="customControlAutosizing">
								<label class="custom-control-label" for="customControlAutosizing">Remember me?</label>
							</div>
						</div>
						<p class="text-center dont-do mt-3">Don't have an account?
							<a href="#" data-toggle="modal" data-target="#exampleModal2">
								Register Now</a>
						</p>
					</form>
				</div>
			</div>
		</div>
	</div>
	<!-- register -->
	<div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Register</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form action="" method="post">
						<?php 
							if (isset($_SESSION['email_err'])) {
								echo '<script>alert("Email exist!")</script>';
								unset($_SESSION['email_err']);
							}
						 ?>
						<div class="form-group">
							<label class="col-form-label">Your Name</label>
							<input type="text" class="form-control" placeholder="Name.. " name="name" required="">
						</div>
						<div class="form-group">
							<label class="col-form-label">Email</label>
							<input type="email" class="form-control" placeholder="Email... " name="email" required="">
						</div>
						<div class="form-group">
							<label class="col-form-label">Password</label>
							<input type="password" class="form-control" placeholder="Password... " name="password" id="password1" required="">
						</div>
						<div class="form-group">
							<label class="col-form-label">Address</label>
							<input type="text" class="form-control" placeholder="Address... " name="address" required="">
						</div>
						<div class="form-group">
							<label class="col-form-label">City</label><br>
							<select name="city">
								<option selected value="hcm">Hồ Chí Minh</option>
								<option value="hn">Hà Nội</option>
								<option value="dn">Đà Nẵng</option>
							</select>
						</div>
						<div class="form-group">
							<label class="col-form-label">Phone</label>
							<input type="text" class="form-control" placeholder="Phone... " name="phone" required="">
						</div>
						<div class="form-group">
							<label class="col-form-label">Level</label>
							<select name="level">
								<option value="0">Normal</option>
							</select>
						</div>
						<div class="right-w3l">
							<input type="submit" class="form-control" name="signin" value="Register">
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<!-- //modal -->
	<!-- //top-header -->

	<!-- header-bottom-->
	<div class="header-bot">
		<div class="container">
			<div class="row header-bot_inner_wthreeinfo_header_mid">
				<!-- logo -->
				<div class="col-md-3 logo_agile">
					<h1 class="text-center">
						<a href="index.php" class="font-weight-bold font-italic">
							<!-- <img src="images/logo2.png" alt=" " class="img-fluid"> -->PjPj Store
						</a>
					</h1>
				</div>
				<!-- //logo -->
				<!-- header-bot -->
				<div class="col-md-9 header mt-4 mb-md-0 mb-4 ">
					<div class="row">
						<!-- search -->
						<div class="col-10 agileits_search">
							<form class="form-inline" action="search.php" method="get">
								<input class="form-control mr-sm-2" type="search" name="key" placeholder="Search" aria-label="Search" required>
								<button class="btn my-2 my-sm-0" name="search" type="submit">Search</button>
							</form>
						</div>
						<!-- //search -->
						<!-- cart details -->
						<!-- <div class="col-2 top_nav_right text-center mt-sm-0 mt-2">
							<div class="wthreecartaits wthreecartaits2 cart cart box_1">
								<form action="#" method="post" class="last">
									<input type="hidden" name="cmd" value="_cart">
									<input type="hidden" name="display" value="1">
									<button class="btn w3view-cart" type="submit" name="submit" value="">
										<i class="fas fa-cart-arrow-down"></i>
									</button>
								</form>
							</div>
						</div> -->
						<!-- //cart details -->
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- shop locator (popup) -->
	<!-- //header-bottom -->
	<!-- navigation -->
	<div class="navbar-inner">
		<div class="container">
			<nav class="navbar navbar-expand-lg navbar-light bg-light">
				
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
				    aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbarSupportedContent">
					<ul class="navbar-nav mr-auto text-center ml-xl-5">
						<li class="nav-item active ml-lg-2 mr-lg-4 mb-lg-0 mb-2">
							<a class="nav-link" href="index.php">Home
								<span class="sr-only">(current)</span>
							</a>
						</li>
						<?php 
							$get_cat = mysqli_query($mysqli,"SELECT * FROM tbl_category");
							foreach ($get_cat as $key => $value) {
								# code...
						 ?>	
						<li class="nav-item ml-lg-3 mr-lg-3 mb-lg-0 mb-2">
							<a class="nav-link" href="cat_search.php?catid=<?php echo $value['catId'] ?>"><?php echo $value['catName'] ?></a>
						</li>	
						<?php 
							}
						 ?>	
						 <?php 
						 		if (isset($_SESSION['shopping_cart'])) {
						 			# code...
						 		
						  ?>	
						  <li class="nav-item ml-lg-3 mr-lg-3 mb-lg-0 mb-2">
							<a class="nav-link" href="cart.php">Cart</a>
						</li>
						<?php 
							}
						 ?>		
						 	
						 <?php 
						 		if (isset($_SESSION['login_cus'])) {
						 			# code...
						 		
						  ?>	
						 
						  <li class="nav-item ml-lg-3 mr-lg-3 mb-lg-0 mb-2">
							<a class="nav-link" href="ordered.php">Ordered</a>
						</li>
						
						<li class="nav-item ml-lg-3 mr-lg-3 mb-lg-0 mb-2">
							<a class="nav-link" href="profile.php">Profile</a>
						</li>
						<?php 
							}
						 ?>	
						<li class="nav-item ml-lg-3 mr-lg-3 mb-lg-0 mb-2">
							<a class="nav-link" href="#">About Us</a>
						</li>
						
						
						<li class="nav-item">
							<a class="nav-link" href="#">Contact Us</a>
						</li>
					</ul>
				</div>
			</nav>
		</div>
	</div>
	<!-- //navigation -->