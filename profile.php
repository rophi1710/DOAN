<?php 
	include 'include/header.php';
	//include 'include/slider.php';
 ?>
<?php 
if (!isset($_SESSION['login_cus'])) {
 	 	header('location:index.php');
 	 } 
	if (isset($_POST['update'])) {
		$email_cus = $_SESSION['cusEmail'];
		$name = $_POST['name'];
		$address = $_POST['address'];
		$phone = $_POST['phone'];
		$city = $_POST['city'];
		$update_info = mysqli_query($mysqli,"UPDATE tbl_customer SET
			name = '$name',
			address = '$address',
			city = '$city',
			phone = '$phone'
			WHERE email = '$email_cus' 
			");
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
					<li>Profile</li>
				</ul>
			</div>
		</div>
	</div>
	<!-- //page -->
	<!-- checkout page -->
	<div class="privacy py-sm-5 py-4">
		<div class="container py-xl-4 py-lg-2">
			<?php 
				$email = $_SESSION['cusEmail'];
				$get_cus = mysqli_query($mysqli,"SELECT * FROM tbl_customer WHERE email = '$email'");
				foreach ($get_cus as $key => $value) {
			 ?>
			 <form action="" method="post">
			 	<table class="table">
			 		<tr>
			 			<td>Email</td>
			 			<td>:</td>
			 			<td><?php echo $value['email'] ?></td>
			 		</tr>
			 		<tr>
			 			<td>Password</td>
			 			<td>:</td>
			 			<td><input type="password" readonly name="password" value="<?php echo $value['password'] ?>" id=""> 
			 				<a href="changepassword.php">Change Password</a>
			 			</td>
			 			
			 		</tr>
			 		<tr>
			 			<td>Name</td>
			 			<td>:</td>
			 			<td><input type="text" name="name" value="<?php echo $value['name'] ?>" id=""></td>
			 		</tr>
			 		<tr>
			 			<td>Address</td>
			 			<td>:</td>
			 			<td><input type="text" name="address" value="<?php echo $value['address'] ?>" id=""></td>
			 		</tr>
			 		<tr>
			 			<td>City</td>
			 			<td>:</td>
			 			<td><select name="city">
			 				<option
			 					<?php 
			 						if ($value['city'] == 'hcm') {
			 							echo 'selected';
			 						}
			 					 ?>
			 				 value="hcm">Hồ Chí Minh</option>
			 				<option <?php 
			 						if ($value['city'] == 'hn') {
			 							echo 'selected';
			 						}
			 					 ?>
			 				 value="hn">Hà Nội</option>
			 				<option <?php 
			 						if ($value['city'] == 'dn') {
			 							echo 'selected';
			 						}
			 					 ?>
			 				 value="dn">Đà Nẵng</option>
			 			</select></td>
			 		</tr>
			 		<tr>
			 			<td>Phone</td>
			 			<td>:</td>
			 			<td><input type="text" name="phone" value="<?php echo $value['phone'] ?>" id=""></td>
			 		</tr>
			 		<tr>
			 			<td>Level</td>
			 			<td>:</td>
			 			<td><?php 
			 				if ($value['level'] == 0) {
			 					echo 'Normal';
			 				}elseif ($value['level'] == 1) {
			 					echo 'Silver';
			 				}else{
			 					echo 'Gold';
			 				}
			 			 ?></td>
			 		</tr>
			 	</table>
			 	<div class="d-flex justify-content-center">
			 		<input type="submit" value="Update" name="update" class="btn btn-success">
			 	</div>
			 </form>
			 <?php 
		 		}
			  ?>
	</div>
</div>
 <?php 
 	include 'include/footer.php';
  ?>