<?php 
	include 'include/header.php';
	//include 'include/slider.php';
	
 ?>
 <?php 
 	if (isset($_POST['check_code'])) {
 		$code = $_POST['code'];
 		$get_code = mysqli_query($mysqli,"SELECT * FROM tbl_voucher WHERE voucherCode = '$code'");
 			if (mysqli_num_rows($get_code) > 0) {
 				foreach ($get_code as $key => $value_ex) {
	 				$today = date("Y-m-d");
	 				$ex = $value_ex['expire'];
	 				if (strtotime($today) > strtotime($ex)) {
	 					$_SESSION['expired'] = 'Voucher Expired!';
	 				}else{
	 					$_SESSION['code_success'] = 'Voucher discount 10%';
	 					if (isset($_SESSION['code_success'])) {
	 						$_SESSION['code'] = $code;
	 					}
	 				}
 				}
 			}else{
 				$_SESSION['code_fail'] = 'Voucher invalid!!';	
 		}
 	}
 	if (isset($_GET['del'])) {
 		$id = $_GET['del'];
 		foreach ($_SESSION['shopping_cart'] as $key => $value_delcart) {
 			if ($value_delcart['item_id'] == $id) {
 				unset($_SESSION['shopping_cart'][$key]);
 			}
 		}
 	}
 	if (isset($_POST['update'])) {
 		$id_update = $_POST['hidden_id_pro'];
 		//echo $id_update;
 		$sql_product_update = mysqli_query($mysqli,"SELECT * FROM tbl_product WHERE productId = '$id_update'");
 		foreach ($sql_product_update as $key => $value_product_updatee) {
 			$get_quantity_pro = $value_product_updatee['quantity'];
 		}
 		
 		if ($_POST['qty_pro'] > $get_quantity_pro) {
 			//$_SESSION['err_cart'] = 'Not enough product '.$value_product_updatee['productName'].' Quantity : '.$value_product_updatee['quantity'];
 			echo '<script>alert("Not enough product '.$value_product_updatee['productName'].' Quantity : '.$value_product_updatee['quantity'].'")</script>';
 			
 		}else{
 		foreach ($_SESSION['shopping_cart'] as $key => $get_cart_pro) {
	 		if ($get_cart_pro['item_id'] == $id_update) {
	 			$get_cart_pro['item_quantity'] = $_POST['qty_pro'];
	 			$get_cart_pro['item_price'] = $_POST['hidden_price_pro'];
	 			$_SESSION['shopping_cart'][$key] = array(
	 				'item_id' => $id_update,
	 				'item_name' => $get_cart_pro['item_name'],
	 				'item_price' => $get_cart_pro['item_price'],
	 				'item_quantity' => $get_cart_pro['item_quantity'],
	 				'item_image' => $get_cart_pro['item_image']
	 			);
	 		}
 		}
 	}
 }
 	if (isset($_POST['order_nolog'])) {
 		echo '<script>alert("Login to continue")</script>';
 	}

 	if (isset($_POST['order'])) {
 		$cusName = $_POST['name'];
 		$cusAdd = $_POST['address'];
 		$cusPhone = $_POST['phone'];
 		$cusEmail = $_POST['email'];
 		$total = $_SESSION['total'];
 		$method = $_POST['payment_method'];
 		if (isset($_SESSION['code'])) {
 			$voucher = $_SESSION['code'];
 		}else{
 			$voucher = '';
 		}
 		$orderId = rand(0,9999);
 		for ($i=0; $i < count($_POST['hidden_id']) ; $i++) { 
 		$name = $_POST['hidden_name'][$i];
 		$id = $_POST['hidden_id'][$i];
 		$quantity = $_POST['hidden_quantity'][$i];
 		$price = $_POST['hidden_price'][$i];		
	 		$query_pro = mysqli_query($mysqli,"SELECT * FROM tbl_product WHERE productId = '$id'");
	 		$get_pro = mysqli_fetch_array($query_pro);
	 		$col_qty = $get_pro['quantity'];
 			$quantity_new = $col_qty - $quantity;
			$update_qty = mysqli_query($mysqli,"UPDATE tbl_product SET quantity = '$quantity_new' WHERE productId = '$id'");
 				
 	    	$insertOrder = mysqli_query($mysqli,"INSERT INTO tbl_order(orderId,email,name,address,phone,total,payment_method,voucherCode) VALUES ('$orderId','$cusEmail','$cusName','$cusAdd','$cusPhone','$total','$method','$voucher')");
 				
 			$insertOrderDetail = mysqli_query($mysqli,"INSERT INTO tbl_orderdetail(orderId,productId,quantity,price) VALUES ('$orderId','$id','$quantity','$price')");
 				
 			$_SESSION['order_code'] = $orderId;
 				unset($_SESSION['code']);
 				header('location:success.php');
 			
 		//}	
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
					<li>Checkout</li>
				</ul>
			</div>
		</div>
	</div>
	<!-- //page -->
	<!-- checkout page -->
	<div class="privacy py-sm-5 py-4">
		<div class="container py-xl-4 py-lg-2">
			<!-- tittle heading -->
			<h3 class="tittle-w3l text-center mb-lg-5 mb-sm-4 mb-3">
				<span>C</span>heckout
			</h3>
			<?php 
			 			if (isset($_SESSION['code_success'])) {
			 				echo '<span style="color:green;font-size:20px">'.$_SESSION['code_success'].'</span>';
			 				
			 			}
			 			if (isset($_SESSION['code_fail'])) {
			 				echo '<span style="color:red;font-size:20px">'.$_SESSION['code_fail'].'</span>';
			 				unset($_SESSION['code_fail']);
			 			}
			 			if (isset($_SESSION['expired'])) {
			 				echo '<span style="color:red;font-size:20px">'.$_SESSION['expired'].'</span>';
			 				unset($_SESSION['expired']);
			 			}
			 			// if (isset($_SESSION['err_cart'])) {
			 			// 	echo '<span style="color:red;font-size:20px">'.$_SESSION['err_cart'].'</span>';
			 			// 	unset($_SESSION['err_cart']);
			 			// }
			 		 ?>
			<!-- //tittle heading -->
			<div class="checkout-right">
				<div class="table-responsive">
					<table class="timetable_sub">
						<thead>
							<tr>
								<th>SL No.</th>
								<th>Product</th>
								<th>Name</th>
								<th>Quantity</th>
								<th>Price</th>
								<th>Remove</th>
							</tr>
						</thead>
						<tbody>
							<?php 
							if (!empty($_SESSION['shopping_cart'])) {
								# code...
								$total = 0;
								$i = 0;
								$get_cart = $_SESSION['shopping_cart'];
								foreach ($get_cart as $key => $value) {
									# code...
								$i++;
								$total = $total + ($value['item_price']*$value['item_quantity']);
							 ?>
							<tr class="rem1">
								<td class="invert"><?php echo $i ?></td>
								<td class="invert">
									<a href="details.php?proid=<?php echo $value['item_id'] ?>">
										<img src="uploads/<?php echo $value['item_image'] ?>" width="100" height="100" alt=" " class="img-responsive">
									</a>
								</td>
								<td class="invert"><?php echo $value['item_name'] ?></td>
								<td class="invert">
									<div class="quantity">
										<div class="quantity-select">
										<form action="" method="post">
											<input type="hidden" name="hidden_id_pro" value="<?php echo $value['item_id'] ?>">
											<input type="hidden" name="hidden_price_pro" value="<?php echo $value['item_price'] ?>">
											<input type="number" value="<?php echo $value['item_quantity'] ?>" name="qty_pro" min="1"><br><br>
											<input type="submit" value="Update" name="update" class="btn btn-default">
										</form>
										</div>
									</div>
								</td>
								
								<td class="invert"><?php echo number_format($value['item_quantity']*$value['item_price']).' VND' ?></td>
								<td class="invert">
									<div class="rem">
										<a href="?del=<?php echo $value['item_id'] ?>"><div class="close1 mr-4"></div></a>
									</div>
								</td>

							</tr>
							
							<?php 
						}
					}
							 ?>
						</tbody>
					</table><br>

					<!-- khach hang vang (voucher) -->

					<?php 
						if (isset($_SESSION['login_cus'])) {
						$mail = $_SESSION['cusEmail'];
						$get_cus_gold = mysqli_query($mysqli,"SELECT * FROM tbl_customer WHERE email = '$mail' AND level = 2");
						if (mysqli_num_rows($get_cus_gold) > 0) {
							foreach ($get_cus_gold as $key => $value_gold) {
							if (isset($_SESSION['code_success'])) {
								
					 ?>
						<table style="float:right;text-align: center;" class="table table-bordered">
						<tr>
							<th width="20%">Ship fee</th>
							<TH width="80%">Total</TH>
						</tr>
						<tr>
						<?php 
						if (isset($total)) {
							# code...
							if ($value_gold['city'] == 'hcm') {
					 			$total_gold = $total - ($total * 0.3) + 10000;
					 		}elseif ($value_gold['city'] == 'hn') {
					 			$total_gold = $total - ($total * 0.3) + 20000;
					 		}else{
					 			$total_gold = $total - ($total * 0.3) + 15000;
					 		}
					 ?>
					 	<td><?php 
					 		if ($value_gold['city'] == 'hcm') {
					 			echo '10,000 VND';
					 		}elseif ($value_gold['city'] == 'hn') {
					 			echo '20,000 VND';
					 		}else{
					 			echo '15,000 VND';
					 		}

					 	 ?></td>
							<td><?php echo number_format($total_gold).' VND';
							$_SESSION['total'] = $total_gold;
							//unset($_SESSION['code_success']);
							 ?></td>
						<?php 
					}else{
						 ?>
						 <td><?php echo '' ?></td>
						 <?php 
						}
						  ?>
						</tr>
						</table>

						<?php 
							}else{
						 ?>

						 	<table style="float:right;text-align: center;" class="table table-bordered">
						<tr>
							<th width="20%">Ship fee</th>
							<TH width="80%">Total</TH>
						</tr>
						<tr>
						<?php 
						if (isset($total)) {
							
							# code...
							if ($value_gold['city'] == 'hcm') {
					 			$total_gold = $total - ($total * 0.2) + 10000;
					 		}elseif ($value_gold['city'] == 'hn') {
					 			$total_gold = $total - ($total * 0.2) + 20000;
					 		}else{
					 			$total_gold = $total - ($total * 0.2) + 15000;
					 		}
					 ?>
					 	<td><?php 
					 		if ($value_gold['city'] == 'hcm') {
					 			echo '10,000 VND';
					 		}elseif ($value_gold['city'] == 'hn') {
					 			echo '20,000 VND';
					 		}else{
					 			echo '15,000 VND';
					 		}
					 	 ?></td>
							<td><?php echo number_format($total_gold).' VND';
							$_SESSION['total'] = $total_gold;
							 ?></td>
						<?php 
					}else{
						 ?>
						 <td><?php echo '' ?></td>
						 <?php 
						}
						  ?>
						</tr>
						</table>

						 <?php 
						 	}
						 	}
						 }
						}
						  ?>
				<!-- end-khach-hang-vang(voucher) -->

		<!-- khach hang bac (voucher) -->
					<?php 
						if (isset($_SESSION['login_cus'])) {
							# code...
						$mail = $_SESSION['cusEmail'];
						$get_cus_silver = mysqli_query($mysqli,"SELECT * FROM tbl_customer WHERE email = '$mail' AND level = 1");
						if (mysqli_num_rows($get_cus_silver) > 0) {
							foreach ($get_cus_silver as $key => $value_silver) {
							if (isset($_SESSION['code_success'])) {
								
					 ?>
						<table style="float:right;text-align: center;" class="table table-bordered">
						<tr>
							<th width="20%">Ship fee</th>
							<TH width="80%">Total</TH>
						</tr>
						<tr>
						<?php 
						if (isset($total)) {
							# code...
							if ($value_silver['city'] == 'hcm') {
					 			$total_silver = $total - ($total * 0.2) + 10000;
					 		}elseif ($value_silver['city'] == 'hn') {
					 			$total_silver = $total - ($total * 0.2) + 20000;
					 		}else{
					 			$total_silver = $total - ($total * 0.2) + 15000;
					 		}
					 ?>
					 	<td><?php 
					 		if ($value_silver['city'] == 'hcm') {
					 			echo '10,000 VND';
					 		}elseif ($value_silver['city'] == 'hn') {
					 			echo '20,000 VND';
					 		}else{
					 			echo '15,000 VND';
					 		}
					 	 ?></td>
							<td><?php echo number_format($total_silver).' VND';
							$_SESSION['total'] = $total_silver;
							//unset($_SESSION['code_success']);
							 ?></td>
						<?php 
					}else{
						 ?>
						 <td><?php echo '' ?></td>
						 <?php 
						}
						  ?>
						</tr>
						</table>

						<?php 
							
						}else{
						 ?>

						 	<table style="float:right;text-align: center;" class="table table-bordered">
						<tr>
							<th width="20%">Ship fee</th>
							<TH width="80%">Total</TH>
						</tr>
						<tr>
						<?php 
						if (isset($total)) {
							# code...
							if ($value_silver['city'] == 'hcm') {
					 			$total_silver = $total - ($total * 0.1) + 10000;
					 		}elseif ($value_silver['city'] == 'hn') {
					 			$total_silver = $total - ($total * 0.1) + 20000;
					 		}else{
					 			$total_silver = $total - ($total * 0.1) + 15000;
					 		}
					 ?>
					 	<td><?php 
					 		if ($value_silver['city'] == 'hcm') {
					 			echo '10,000 VND';
					 		}elseif ($value_silver['city'] == 'hn') {
					 			echo '20,000 VND';
					 		}else{
					 			echo '15,000 VND';
					 		}
					 	 ?></td>
							<td><?php echo number_format($total_silver).' VND';
							$_SESSION['total'] = $total_silver;
							 ?></td>
						<?php 
					}else{
						 ?>
						 <td><?php echo '' ?></td>
						 <?php 
						}
						  ?>
						</tr>
						</table>

						 <?php 
								}
							}
						 }
					 }
						  ?>
				<!-- end-khach-hang-bac(voucher) -->

				<!-- khach-thuong(voucher) -->
					<?php 
						if (isset($_SESSION['login_cus'])) {
						$mail = $_SESSION['cusEmail'];
						$get_cus_silver = mysqli_query($mysqli,"SELECT * FROM tbl_customer WHERE email = '$mail' AND level = 0");
						if (mysqli_num_rows($get_cus_silver) > 0) {
							foreach ($get_cus_silver as $key => $value_normal) {
								# code...
							
						if (isset($_SESSION['code_success'])) {
							# code...
						
					 ?>
					<table style="float:right;text-align: center;" class="table table-bordered">
					<tr>
						<th width="20%">Ship fee</th>
						<TH width="80%">Total</TH>
					</tr>
					<tr>
					 	<?php 
						if (isset($total)) {
							# code...
							if ($value_normal['city'] == 'hcm') {
					 			$total_discount = $total - ($total * 0.1) + 10000;
					 		}elseif ($value_normal['city'] == 'hn') {
					 			$total_discount = $total - ($total * 0.1) + 20000;
					 		}else{
					 			$total_discount = $total - ($total * 0.1) + 15000;
					 		}
					 ?>
					 	<td><?php 
					 		if ($value_normal['city'] == 'hcm') {
					 			echo '10,000 VND';
					 		}elseif ($value_normal['city'] == 'hn') {
					 			echo '20,000 VND';
					 		}else{
					 			echo '15,000 VND';
					 		}
					 	 ?></td>
						<td><?php echo number_format($total_discount).' VND';
						$_SESSION['total'] = $total_discount;
						//unset($_SESSION['code_success']);
						 ?></td>
					<?php 
				}else{
					 ?>
					 <td><?php echo '' ?></td>
					 <?php 
					}
					  ?>
					</tr>
					</table>

					<?php 
						}else{
					 ?>

					 <table style="float:right;text-align: center;" class="table table-bordered">
					<tr>
						<th width="20%">Ship fee</th>
						<TH width ="80%">Total</TH>
					</tr>
					<tr>
					<?php 
						if (isset($total)) {
							# code...
							if ($value_normal['city'] == 'hcm') {
					 			$total = $total + 10000;
					 		}elseif ($value_normal['city'] == 'hn') {
					 			$total = $total + 20000;
					 		}else{
					 			$total = $total + 15000;
					 		}
							
						
					 ?>
					 	<td><?php 
					 		if ($value_normal['city'] == 'hcm') {
					 			echo '10,000 VND';
					 		}elseif ($value_normal['city'] == 'hn') {
					 			echo '20,000 VND';
					 		}else{
					 			echo '15,000 VND';
					 		}
					 	 ?></td>
						<td><?php echo number_format($total).' VND';
						$_SESSION['total'] = $total;
						 ?></td>
					<?php 
				}else{
					 ?>
					 <td><?php echo '' ?></td>
					 <?php 
					}
					  ?>
					</tr>
					</table>
					 <?php 
					 	}
					 }
					}
				 }
					  ?>
				</div>
			</div>
			<!-- end-khach-thuong(voucher) -->
			 <?php 
			 		if (isset($_SESSION['login_cus'])) {
			 			# code...
			 		
			  ?>
			 <div class="checkout-right-basket">
			 		<form action="" method="POST">
								Voucher: <input type="text" name="code" required="">
								<input type="submit" value="Add" name="check_code">
							</form><br>
						<form action="" method="post">
							<?php 
								if (isset($_SESSION['cusEmail'])) {
									$mail_info = $_SESSION['cusEmail'];
								}
								$get_infocus = mysqli_query($mysqli, "SELECT * FROM tbl_customer WHERE email = '$mail_info'");
								foreach ($get_infocus as $key => $value_info) {
							 ?>
							Email: <input type="text" name="email" readonly value="<?php echo $value_info['email'] ?>" class="form-control"><br>
							Name: <input type="text" name="name" value="<?php echo $value_info['name'] ?>" class="form-control"><br>
							Phone: <input type="text" name="phone" value="<?php echo $value_info['phone'] ?>" class="form-control"><br>
							Address: <input type="text" name="address" value="<?php echo $value_info['address'] ?>" class="form-control"><br>
							<?php 
								}
							 ?>
							Payment: <select name="payment_method" class="form-control">
								<option value="0">Cash On Delivery</option>
								<option value="1">ATM</option>
							</select><br><br>
							
							<?php 
								if (isset($_SESSION['shopping_cart'])) {
									# code...
								
						 		foreach ($_SESSION['shopping_cart'] as $key => $value) {
						 			
						 	 ?>
						 	 
							<input type="hidden" name="hidden_id[]" value="<?php echo $value['item_id'] ?>">
							<input type="hidden" name="hidden_name[]" value="<?php echo $value['item_name'] ?>">
							<input type="hidden" name="hidden_price[]" value="<?php echo $value['item_price']*$value['item_quantity'] ?>">
							<input type="hidden" name="hidden_quantity[]" value="<?php echo $value['item_quantity'] ?>">
							
							<?php 
								}
							}
							 ?>
							<div class="d-flex justify-content-center">
								<input type="submit" name="order" value="Order" class="btn btn-success">
							</div>
						</form>
						
				
			</div>
			<?php 
				}else{
			 ?>
			 		<div class="d-flex justify-content-center">
			 			<form action="" method="post">
							<input type="submit" name="order_nolog" value="Order" class="btn btn-success">
						</form>
					</div>
			 <?php 
			 	}
			  ?>
		</div>
	</div>
	<!-- //checkout page -->
<?php 
include 'include/footer.php'
 ?>