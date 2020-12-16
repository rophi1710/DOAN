<?php 
	include 'include/header.php';
 ?>
 <?php
 	if (!isset($_SESSION['login_cus'])) {
 	 	header('location:index.php');
 	 } 
 	if (isset($_POST['update'])) {
 	$email = $_SESSION['cusEmail'];
 	$old = md5($_POST['old_password']);
 	$new = md5($_POST['new_password']);
 	$re = md5($_POST['re_password']);
 	$get_cus_true = mysqli_query($mysqli,"SELECT * FROM tbl_customer WHERE email = '$email' AND password = '$old'");
 	if (mysqli_num_rows($get_cus_true) > 0) {
 		if ($new == $re) {
 			$changepass = mysqli_query($mysqli,"UPDATE tbl_customer SET password = '$new' WHERE email = '$email'");
 			$_SESSION['password_success'] = 'Change Password successfully!!!';
 		}else{
 			$_SESSION['re_password_fail'] = 'Re-password not match';
 		}
 	}else{
 		$_SESSION['password_fail'] = 'Password invalid!';
 	}
 }
  ?>
<div class="privacy py-sm-5 py-4">
		<div class="container py-xl-4 py-lg-2">
		<?php 
			if (isset($_SESSION['re_password_fail'])) {
				echo '<span style="color:red">'.$_SESSION['re_password_fail'].'</span>';
				unset($_SESSION['re_password_fail']);
			}
			if (isset($_SESSION['password_fail'])) {
				echo '<span style="color:red">'.$_SESSION['password_fail'].'</span>';
				unset($_SESSION['password_fail']);
			}
			if (isset($_SESSION['password_success'])) {
				echo '<span style="color:green">'.$_SESSION['password_success'].'</span>';
				unset($_SESSION['password_success']);
			}
		 ?>
		<form action="" method="post">
			<table class="table">
				<tr>
					<td>Password</td>
					<td>:</td>
					<td><input type="password" name="old_password"></td>
				</tr>
				<tr>
					<td>New Password</td>
					<td>:</td>
					<td><input type="password" name="new_password"></td>
				</tr>
				<tr>
					<td>Re-Password</td>
					<td>:</td>
					<td><input type="password" name="re_password"></td>
				</tr>
			</table>
			<div class="d-flex justify-content-center">
				<input type="submit" value="Update" name="update">
			</div>
		</form>
	</div>
</div>
 <?php 
 	include 'include/footer.php';
  ?>