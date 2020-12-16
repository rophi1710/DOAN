<?php 
	include 'include/header.php';
	//include 'include/slider.php';
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    require_once 'PHPMailer/Exception.php';
    require_once 'PHPMailer/PHPMailer.php';
    require_once 'PHPMailer/SMTP.php';
 ?>

 <?php 
 if (isset($_POST['end'])) {
        #
        //mail
        $mail = new PHPMailer();
        $mailName = $_POST['mailName'];
        $mailfrom = $_POST['mailfrom'];
        $mailSubject = $_POST['mailSubject'];
        $mailMess = $_POST['mailMess'];

        try{
            $mail ->isSMTP();
            $mail ->Host ='smtp.gmail.com';
            $mail ->SMTPAuth = true;
            $mail ->Username = 'testemailwebclothing@gmail.com';
            $mail ->Password = '1!2@3#4$5%';
            $mail ->SMTPSecure = 'ssl'; 
            $mail ->Port = 465;

            $mail ->setFrom('testemailwebclothing@gmail.com',$mailName);
            $mail ->addAddress($_SESSION['cusEmail']);

            $mail ->isHTML(true);
            $mail ->Subject = $mailSubject;
            $mail ->Body = $mailMess;

            $mail ->send();
            
        }catch(Exception $e){
            
        }
        $email = $_SESSION['cusEmail'];
                $total = 0;
                $total_price = mysqli_query($mysqli,"SELECT tbl_order.total FROM tbl_order JOIN tbl_customer ON tbl_order.email = tbl_customer.email WHERE tbl_order.email = '$email'");
                foreach ($total_price as $key => $value_price) {
                $total = $total + $value_price['total'];
              }      
        $update_price_customer = mysqli_query($mysqli,"UPDATE tbl_customer SET total = '$total' WHERE email = '$email'");
        unset($_SESSION['code_success']);
        unset($_SESSION['shopping_cart']);
        header('location:index.php');
    }
        //end-mail
  ?>
 <style type="text/css">
 .success{
		padding: 5px 20px;
		text-align: center;
	
		font-size: 25px;
		color: red;
	}
	.success-notif{
		text-align: center;
		padding: 10px;
	}
</style>

 <div class="main">
    <div class="content">
    	<div class="section group">
    		<div class="success">ORDER</div>
    		<?php 
                $email = $_SESSION['cusEmail'];
             ?>
    		<!-- <p class="success-notif">Total Price : <?php 
    		if (isset($_SESSION['total_discount'])) {
    				echo number_format($_SESSION['total_discount']).' VND';
    			  }else{
    			  	echo number_format($_SESSION['total']).' VND';
    			  }
    		
    			unset($_SESSION['code_success']);
    		 ?> </p> -->
             <p  class="success-notif">Your Order waiting for process!<!--  Can you check <a href="ordered.php?email=<?php echo $email ?>">Ordered</a> --></p>
    		<!-- <p  class="success-notif">Your Order Details : <a href="orderdetail.php?order_code=<?php echo $_SESSION['order_code'] ?>">Click here</a></p> -->
            <p class="success-notif">Press FINISH to confirm order!</p>
            <div class="d-flex justify-content-center">
                <form action="" method="POST">
                <input type="hidden" name="mailName" value="PjPj Store">
                                <input type="hidden" name="mailfrom" value="pjpjstore@gmail.com">
                                <input type="hidden" name="mailSubject" value="Order">
                                <div style="display: none">
                                    <textarea name="mailMess"cols="20" rows="10">Thanks for support! Your Order Details:<br>
                                    <?php 
                                        $orderId_mail = $_SESSION['order_code'];
                                        $get_orderdetail = mysqli_query($mysqli,"SELECT tbl_orderdetail.*,tbl_order.total,tbl_product.productName FROM tbl_orderdetail JOIN tbl_product ON tbl_orderdetail.productId = tbl_product.productId JOIN tbl_order ON tbl_orderdetail.orderId = tbl_order.orderId WHERE tbl_orderdetail.orderId = '$orderId_mail'");
                                        foreach ($get_orderdetail as $key => $value_mail) {
                                            echo "<br>".$value_mail['productName'].' x '.$value_mail['quantity'];
                                        }
                                        echo "<br><span style='border-top: 2px solid black'>Total: ".number_format($_SESSION['total']).' VND'.'</span>';
                                     ?>
                                     <p>Your order will delivery during in 2-3 days. Please waiting for call from shipper! </p>
                                     </textarea>
                                 </div>
                <input type="submit" value="Finish" name="end" class="btn btn-success">
            </form>
            </div>
 		</div>
 		
 	</div>
 <?php 
 	include 'include/footer.php';
  ?>