<?php 
	include 'include/header.php';
	//include 'include/slider.php';
	if (!isset($_SESSION['login_cus'])) {
 	 	header('location:index.php');
 	 } 
 ?>
<!-- tittle heading -->
			<h3 class="tittle-w3l text-center mb-lg-5 mb-sm-4 mb-3">
				<span>O</span>rder
				<span>D</span>etails
			</h3>
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
							</tr>
						</thead>
						<tbody>
							<?php 
							$orderCode = $_GET['order_code'];
							$get_order = mysqli_query($mysqli,"SELECT tbl_product.productName,tbl_product.image, tbl_orderdetail.* FROM tbl_orderdetail JOIN tbl_product ON tbl_product.productId = tbl_orderdetail.productId WHERE tbl_orderdetail.orderId = '$orderCode'");
							$i = 0;
							foreach ($get_order as $key => $value) {
								# code...
								$i++;
							 ?>
							<tr class="rem1">
								<td class="invert"><?php echo $i ?></td>
								<td class="invert">
									<a href="single.html">
										<img src="uploads/<?php echo $value['image'] ?>" width="100" height="100" alt=" " class="img-responsive">
									</a>
								</td>
								<td class="invert"><?php echo $value['productName'] ?></td>
									<td class="invert"><?php echo $value['quantity'] ?></td>
								<td class="invert"><?php echo number_format($value['price']).' VND' ?></td>
								

							</tr>
							
							<?php 
						}
					
							 ?>
						</tbody>
					</table>
				</div>
			</div>

 <?php 
 	include 'include/footer.php';
  ?>