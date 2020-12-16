<?php 
	include 'include/header.php';
	//include 'include/slider.php';
 ?>
<?php 
	if (!isset($_SESSION['login_cus'])) {
 	 	header('location:index.php');
 	 } 
	if (isset($_POST['send'])) {
		$reason = $_POST['reason'];
		$status = $_POST['hidden_status'];
		$ord = $_POST['hidden_order'];
		$cancel = mysqli_query($mysqli,"UPDATE tbl_order SET reason = '$reason',status = '$status' WHERE orderId = '$ord'");
		if ($cancel) {
			$_SESSION['cancel'] = 'Your request In-Processing';
		}else{
			$_SESSION['cancel'] = 'Error';
		}
		
	}
 ?>
<!-- tittle heading -->
			<h3 class="tittle-w3l text-center mb-lg-5 mb-sm-4 mb-3">
				<span>O</span>rdered
			</h3>
			<div class="col-sm-4" style="float: right;">
        <form action="" method="get">
        <div class="input-group">
          <input type="text" class="input-sm form-control" placeholder="Code..." name="key" style="height: 37px;"><br><br>
          <span class="input-group-btn">
            <input type="submit" value="Go!" name="search" class="btn btn-default">
          </span>
        </div>
      </form>
      </div>
      	<?php 
      		if (!isset($_GET['search'])) {
      			
      	 ?>
			<!-- //tittle heading -->
			<div class="checkout-right">
				<?php 
					if (isset($_SESSION['del_order_cus'])) {
						# code...
						echo '<span style="color:green">'.$_SESSION['del_order_cus'].'</span>';
						unset($_SESSION['del_order_cus']);
					}
					if (isset($_SESSION['del_order_cus_fail'])) {
						# code...
						echo '<span style="color:red">'.$_SESSION['del_order_cus_fail'].'</span>';
						unset($_SESSION['del_order_cus_fail']);
					}
					if (isset($_SESSION['cancel'])) {
						# code...
						echo '<span style="color:green">'.$_SESSION['cancel'].'</span>';
						unset($_SESSION['cancel']);
					}
				 ?>
				<div class="table-responsive">
					<table class="timetable_sub">
						<thead>
							<tr>
								<th>SL No.</th>
								<th>Code</th>
								<th>Product</th>
								<th>Name</th>
								<th>Quantity</th>
								<th>Price</th>
								<th>Status</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php 
							$email = $_SESSION['cusEmail'];
							$get_order = mysqli_query($mysqli,"SELECT tbl_product.productName,tbl_product.image,tbl_order.status , tbl_orderdetail.* FROM tbl_orderdetail JOIN tbl_product ON tbl_product.productId = tbl_orderdetail.productId JOIN tbl_order ON tbl_orderdetail.orderId = tbl_order.orderId WHERE tbl_order.email = '$email' ORDER BY tbl_order.orderId");
							$i = 0;
							foreach ($get_order as $key => $value) {
								# code...
								$i++;
							 ?>
							<tr class="rem1">
								<td class="invert"><?php echo $i ?></td>
								<td class="invert"><?php echo $value['orderId'] ?></td>
								<td class="invert">
									<a href="single.html">
										<img src="uploads/<?php echo $value['image'] ?>" width="100" height="100" alt=" " class="img-responsive">
									</a>
								</td>
								<td class="invert"><?php echo $value['productName'] ?></td>
								<td class="invert"><?php echo $value['quantity'] ?></td>
								<td class="invert"><?php echo number_format($value['price']).' VND' ?></td>
								<td class="invert"><?php 
									if ($value['status'] == 0) {
										echo 'Pending';
									}elseif ($value['status'] == 1) {
										echo 'Shipped';
									}elseif ($value['status'] == 2) {
										echo 'Cancel';
									}else{
										echo 'In-Process';
									}
								 ?></td>
								 <td class="invert">
									<div class="rem">
										<?php 
											if ($value['status'] == 0) {
												# code...
											
										 ?>
										<a href="?del=<?php echo $value['orderId'] ?>&status=3"><div class="close1 mr-4"></div></a>
										<?php 
											}else{
										 ?>
										 <?php 
										 echo '';
										  }?>
									</div>
								</td>
							</tr>
							<?php 
								}
							 ?>
						</tbody>
					</table>
					<?php 
						if (isset($_GET['del'])) {
							$id = $_GET['del'];
							$status = $_GET['status'];
						
					 ?>
					 	<form action="ordered.php" method="POST">
					 		<input type="hidden" name="hidden_order" value="<?php echo $id ?>">
					 		<input type="hidden" name="hidden_status" value="<?php echo $status ?>">
					 		Reason : <input type="text" name="reason" class="form-control"><br>
					 		<input type="submit" value="Send" name="send">
					 	</form>
					 <?php 
					 	}
					 
					  ?>
				</div>
			</div>
			<?php 
		}
			 ?>

			<?php 
			if (isset($_GET['search'])) {
				$key = $_GET['key'];
					
 			?>
 			<div class="checkout-right">
				<div class="table-responsive">
					<table class="timetable_sub">
						<thead>
							<tr>
								<th>SL No.</th>
								<th>Code</th>
								<th>Product</th>
								<th>Name</th>
								<th>Quantity</th>
								<th>Price</th>
								<th>Status</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php 
							$query_search = mysqli_query($mysqli,"SELECT tbl_product.productName,tbl_product.image,tbl_order.status , tbl_orderdetail.* FROM tbl_orderdetail JOIN tbl_product ON tbl_product.productId = tbl_orderdetail.productId JOIN tbl_order ON tbl_orderdetail.orderId = tbl_order.orderId WHERE tbl_order.orderId = '$key'");
							$i = 0;
							foreach ($query_search as $key => $value_search) {
								# code...
								$i++;
							 ?>
							<tr class="rem1">
								<td class="invert"><?php echo $i ?></td>
								<td class="invert"><?php echo $value_search['orderId'] ?></td>
								<td class="invert">
									<a href="single.html">
										<img src="uploads/<?php echo $value_search['image'] ?>" width="100" height="100" alt=" " class="img-responsive">
									</a>
								</td>
								<td class="invert"><?php echo $value_search['productName'] ?></td>
									<td class="invert"><?php echo $value_search['quantity'] ?></td>
								<td class="invert"><?php echo number_format($value_search['price']).' VND' ?></td>
								<td class="invert"><?php 
									if ($value_search['status'] == 0) {
										echo 'Pending';
									}elseif ($value_search['status'] == 1) {
										echo 'Shipped';
									}elseif ($value_search['status'] == 2) {
										echo 'Cancel';
									}else{
										echo 'In-Process';
									}
								 ?></td>
								 <td class="invert">
									<div class="rem">
										<?php 
											if ($value_search['status'] == 0) {
												# code...
											
										 ?>
										<a href="?del=<?php echo $value_search['orderId'] ?>&status=3"><div class="close1 mr-4"></div></a>
										<?php 
											}else{
										 ?>
										 <?php 
										 echo '';
										  }?>
									</div>
								</td>
							</tr>
							<?php 
								}
							 ?>
						</tbody>
					</table>
					<?php 
						if (isset($_GET['del'])) {
							$id = $_GET['del'];
							$status = $_GET['status'];
						
					 ?>
					 	<form action="" method="POST">
					 		<input type="hidden" name="hidden_order" value="<?php echo $id ?>">
					 		<input type="hidden" name="hidden_status" value="<?php echo $status ?>">
					 		Reason : <input type="text" name="reason" class="form-control"><br>
					 		<input type="submit" value="Send" name="send">
					 	</form>
					 <?php 
					 	}
					 
					  ?>
				</div>
			</div>
 			<?php 
 			}
 			 ?>

 <?php 
 	include 'include/footer.php';
  ?>