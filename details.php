<?php 
	include 'include/header.php';
	//include 'include/slider.php';	
?>
<?php 
	if (isset($_POST['addtocart'])) {
		if (isset($_SESSION['shopping_cart'])) {
			$item_array_id = array_column($_SESSION['shopping_cart'], 'item_id');
			if (!in_array($_POST['hidden_id'], $item_array_id)) {
				$count = count($_SESSION['shopping_cart']);
				$item_array = array(
				'item_id' => $_POST['hidden_id'],
				'item_name' => $_POST['hidden_name'],
				'item_quantity' => $_POST['hidden_quantity'],
				'item_price' => $_POST['hidden_price'],
				'item_image' => $_POST['hidden_image']
			);
				$_SESSION['shopping_cart'][$count] = $item_array;
				header('location:cart.php');
			}else{
				echo '<script>alert("Already Product in cart")</script>';
			}
		}else{
			$item_array = array(
				'item_id' => $_POST['hidden_id'],
				'item_name' => $_POST['hidden_name'],
				'item_quantity' => $_POST['hidden_quantity'],
				'item_price' => $_POST['hidden_price'],
				'item_image' => $_POST['hidden_image']
			);
			$_SESSION['shopping_cart'][0] = $item_array;
			header('location:cart.php');
		}
	}
	if (isset($_POST['feedback'])) {
		$id_fb = $_POST['hidden_id_fb'];
		$mes = $_POST['mess_fb'];
		$email = $_SESSION['cusEmail'];

		$query = mysqli_query($mysqli,"INSERT INTO tbl_feedback(email,productId,feedback) VALUES ('$email','$id_fb','$mes')");
		
		if (!$query) {
			$_SESSION['fb_fail'] = 'You only feedback a product once';
		}else{
			$_SESSION['fb'] = 'Feedback Successfully!!';
		}
	}
 ?>
<!-- page -->
	<div class="services-breadcrumb">
		<div class="agile_inner_breadcrumb">
			<div class="container">
				<ul class="w3_short">
					<li>
						<a href="index.html">Home</a>
						<i>|</i>
					</li>
					<?php 
						$id = $_GET['proid'];
						$get_pro = mysqli_query($mysqli,"SELECT * FROM tbl_product WHERE productId = '$id'");
						$rows_name = mysqli_fetch_array($get_pro);
						echo '<li>'.$rows_name['productName'].'</li>';
					 ?>
					
				</ul>
			</div>
		</div>
	</div>
	<!-- //page -->
	<!-- Single Page -->
	<div class="banner-bootom-w3-agileits py-5">
		<div class="container py-xl-4 py-lg-2">
			<!-- tittle heading -->
			<h3 class="tittle-w3l text-center mb-lg-5 mb-sm-4 mb-3">
				<span>P</span>roduct
				<span>D</span>etails</h3>
			<!-- //tittle heading -->
			<?php 
				foreach ($get_pro as $key => $value) {
					# code...
				
			 ?>
			<div class="row">
				<div class="col-lg-5 col-md-8 single-right-left ">

					<div class="grid images_3_of_2">
						<div class="flexslider">
							<ul class="slides">
								<!-- <li data-thumb="uploads/<?php echo $value['image'] ?>"> -->
									<div class="thumb-image">
										<img src="uploads/<?php echo $value['image'] ?>" data-imagezoom="true" class="img-fluid" alt=""> </div>
								<!-- </li> -->
								<!-- <li data-thumb="images/sii2.jpg">
									<div class="thumb-image">
										<img src="images/sii2.jpg" data-imagezoom="true" class="img-fluid" alt=""> </div>
								</li>
								<li data-thumb="images/sii3.jpg">
									<div class="thumb-image">
										<img src="images/sii3.jpg" data-imagezoom="true" class="img-fluid" alt=""> </div>
								</li> -->
							</ul>
							<div class="clearfix"></div>
						</div>
					</div>
				</div>

				<div class="col-lg-7 single-right-left simpleCart_shelfItem">

						<h3 class="mb-3"><?php echo $value['productName'] ?></h3>
						<p class="mb-3">
						<span class="item_price"><?php echo number_format($value['price']).' VND' ?></span>
						
						<label>Free delivery</label>
					</p>
					<div class="single-infoagile">
						<?php echo $value['productDes'] ?>
					</div>
					<div class="product-single-w3l">
						<p class="my-sm-4 my-3">
								<i class="fa fa-money-bill-alt mr-3"></i>ATM Card / Cash On Delivery
						</p>
					</div>
					<div class="occasion-cart">
						<div class="snipcart-details top_brand_home_details item_add single-item hvr-outline-out">
							<form action="" method="post">
								<fieldset>
									<input type="hidden" name="hidden_id" value="<?php echo $value['productId'] ?>">
									<input type="hidden" name="hidden_name" value="<?php echo $value['productName'] ?>"/>
									<input type="hidden" name="hidden_image" value="<?php echo $value['image'] ?>">
									<input type="number" min="1" name="hidden_quantity" value="1" /><br><br>
									<input type="hidden" name="hidden_price" value="<?php echo $value['price'] ?>" />
									<input type="submit" name="addtocart" value="Add to cart" class="button btn" />
								</fieldset>
							</form>
						</div>

					</div>
					<br><br>
					<?php 
					if (isset($_SESSION['fb'])) {
						echo '<span style="color:green">'.$_SESSION['fb'].'</span>';
						unset($_SESSION['fb']);
					}
					if (isset($_SESSION['fb_fail'])) {
						echo '<span style="color:red">'.$_SESSION['fb_fail'].'</span>';
						unset($_SESSION['fb_fail']);
					}
					if (isset($_SESSION['login_cus'])) {
						# code...
					
				 ?>
					<form action="" method="POST">
						<input type="hidden" name="hidden_id_fb" value="<?php echo $value['productId'] ?>">
						Email: <input type="text" class="form-control" value="<?php echo $_SESSION['cusEmail'] ?>" readonly name="email_fb">
						Feedback : <textarea name="mess_fb" class="form-control" style="resize: none" id="" cols="30" rows="4"></textarea>
						<br><div class="d-flex justify-content-center">
							<input type="submit" value="Feedback" class="btn btn-primary" name="feedback">
						</div>
					</form>
					<?php 
						}
					 ?>
				</div>
			</div>
			<?php 
		}
			 ?>
			 <H4 style="color:blue;text-align: center;">FeedBack</H4><br>
			 <table class="table">
			 	<?php 
			 		$pro = $_GET['proid'];
			 		$fb = mysqli_query($mysqli,"SELECT tbl_feedback.*, tbl_customer.name FROM tbl_feedback JOIN tbl_customer ON tbl_feedback.email = tbl_customer.email WHERE tbl_feedback.productId = '$pro'");
			 		foreach ($fb as $key => $value_fb) {
			 			# code...
			 		
			 	 ?>
			 		<tr>
			 			<td><?php echo $value_fb['name'] ?></td>
			 			<td><?php echo $value_fb['feedback'] ?></td>
			 		</tr>
			 	<?php 
			 		}
			 	 ?>
			 </table>
		</div>
	</div>
	<!-- //Single Page -->
<?php 
	include 'include/footer.php';
 ?>