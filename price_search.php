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
				echo'<script>alert("Added '.$_POST['hidden_name'].' in Cart")</script>';
				echo "<script>window.location = 'index.php' </script>";  
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
			echo'<script>alert("Added '.$_POST['hidden_name'].' in Cart")</script>';
			echo "<script>window.location = 'index.php' </script>";  
		}
	}
  ?>
<!-- top Products -->
	<div class="ads-grid py-sm-5 py-4">
		<div class="container py-xl-4 py-lg-2">
			<!-- tittle heading -->
			<h3 class="tittle-w3l text-center mb-lg-5 mb-sm-4 mb-3">
				<span><?php 
					if (isset($_GET['from']) && isset($_GET['to'])) {
						$from = $_GET['from'];
						$to = $_GET['to'];
						echo number_format($from).' VND'.' - '.number_format($to). ' VND';
					}elseif(isset($_GET['from']) && !isset($_GET['to'])){
						$from = $_GET['from'];
						echo 'More '.number_format($from).' VND';
					}
				 ?></span>
				</h3>
			<!-- //tittle heading -->
			<div class="row">
				<!-- product left -->
				<div class="agileinfo-ads-display col-lg-12">
					<div class="wrapper">
						<!-- first section -->
						<div class="product-sec1 px-sm-4 px-3 py-sm-5  py-3 mb-4">
							<!-- <h3 class="heading-tittle text-center font-italic">Best Seller</h3> -->
							<div class="row">
								<?php 
								if (isset($_GET['from']) && isset($_GET['to'])) {
									$from = $_GET['from'];
									$to = $_GET['to'];
									$get_pro_best = mysqli_query($mysqli,"SELECT * FROM tbl_product");
									foreach ($get_pro_best as $key => $value_probest) {
									if ($value_probest['price'] >= $from && $value_probest['price'] <= $to) {
										# code...
									
								 ?>
								<div class="col-md-4 product-men mt-5">
									<div class="men-pro-item simpleCart_shelfItem">
										<div class="men-thumb-item text-center">
											<img src="uploads/<?php echo $value_probest['image'] ?>" width = "200px" height="200px">
											<div class="men-cart-pro">
												<div class="inner-men-cart-pro">
													<a href="details.php?proid=<?php echo $value_probest['productId'] ?>" class="link-product-add-cart">Quick View</a>
												</div>
											</div>
										</div>
										<div class="item-info-product text-center border-top mt-4">
											<h4 class="pt-1">
												<a href="details.php?proid=<?php echo $value_probest['productId'] ?>"><?php echo $value_probest['productName'] ?></a>
											</h4>
											<div class="info-product-price my-2">
												<span class="item_price"><?php echo number_format($value_probest['price']).' VND' ?></span>
												
											</div>
											<div class="snipcart-details top_brand_home_details item_add single-item hvr-outline-out">
												<form action="" method="post">
													<fieldset>
														<input type="hidden" name="hidden_image" value="<?php echo $value_probest['image'] ?>">
														<input type="hidden" name="hidden_id" value="<?php echo $value_probest['productId'] ?>">
														<input type="hidden" name="hidden_name" value="<?php echo $value_probest['productName'] ?>" />
														<input type="hidden" name="hidden_quantity" value="1" />
														<input type="hidden" name="hidden_price" value="<?php echo $value_probest['price'] ?>" />
														<input type="submit" name="addtocart" value="Add to cart" class="button btn" />
													</fieldset>
												</form>
											</div>
										</div>
									</div>
								</div>
								<?php 
										}else{
											echo '';
										}
									}
								}elseif(isset($_GET['from']) && !isset($_GET['to'])){
									$from = $_GET['from'];
									$get_more = mysqli_query($mysqli,"SELECT * FROM tbl_product");
									foreach ($get_more as $key => $value_more) {
										# code...
										if ($value_more['price'] >= $from) {
									
								 ?>
								<div class="col-md-4 product-men mt-5">
									<div class="men-pro-item simpleCart_shelfItem">
										<div class="men-thumb-item text-center">
											<img src="uploads/<?php echo $value_more['image'] ?>" width = "200px" height="200px">
											<div class="men-cart-pro">
												<div class="inner-men-cart-pro">
													<a href="details.php?proid=<?php echo $value_more['productId'] ?>" class="link-product-add-cart">Quick View</a>
												</div>
											</div>
										</div>
										<div class="item-info-product text-center border-top mt-4">
											<h4 class="pt-1">
												<a href="details.php?proid=<?php echo $value_more['productId'] ?>"><?php echo $value_more['productName'] ?></a>
											</h4>
											<div class="info-product-price my-2">
												<span class="item_price"><?php echo number_format($value_more['price']).' VND' ?></span>
												
											</div>
											<div class="snipcart-details top_brand_home_details item_add single-item hvr-outline-out">
												<form action="" method="post">
													<fieldset>
														<input type="hidden" name="hidden_image" value="<?php echo $value_more['image'] ?>">
														<input type="hidden" name="hidden_id" value="<?php echo $value_more['productId'] ?>">
														<input type="hidden" name="hidden_name" value="<?php echo $value_more['productName'] ?>" />
														<input type="hidden" name="hidden_quantity" value="1" />
														<input type="hidden" name="hidden_price" value="<?php echo $value_more['price'] ?>" />
														<input type="submit" name="addtocart" value="Add to cart" class="button btn" />
													</fieldset>
												</form>
											</div>
										</div>
									</div>
								</div>

								 <?php 
											}else{
												echo '';
											}
										}
							 		}
								  ?>
							</div>
						</div>
						<!-- //first section -->
						
					</div>
				</div>
				<!-- //product left -->

				
				</div>
			</div>
		</div>
	</div>
	<!-- //top products -->

 <?php 
 	include 'include/footer.php';
  ?>