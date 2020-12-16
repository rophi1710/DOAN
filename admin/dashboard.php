<?php
	include 'include/header.php';
	include 'include/sidebar.php';
	if (!isset($_SESSION['login'])) {
        header('location:index.php');
    }
 ?>

<!--main content start-->
<section id="main-content">
	<section class="wrapper">
		<div>
            <h2>Welcome to Admin</h2><br>
            <table class="table table-bordered">
                <tr>
                    <th>Order in pending</th>
                    <th>Ordered</th>
                    <th>Total price</th>
                </tr>
                <tr>
                    <td><?php 
                        $order_pending = mysqli_query($mysqli, "SELECT * FROM tbl_order WHERE status = 0");
                        $count_order_pending = mysqli_num_rows($order_pending);
                        echo '<a href="order.php">'.$count_order_pending.'</a>';
                     ?></td>
                     <td>
                         <?php 
                        $order_pending = mysqli_query($mysqli, "SELECT * FROM tbl_order WHERE status = 1");
                        $count_order_pending = mysqli_num_rows($order_pending);
                        echo $count_order_pending;
                     ?>
                     </td>  
                     <td><?php 
                        $total = 0;
                        $get_total = mysqli_query($mysqli, "SELECT * FROM tbl_customer");
                        foreach ($get_total as $key => $value) {
                            $total = $total + $value['total'];
                        }
                        echo number_format($total).' VND';
                    ?></td>
                </tr>
            </table>
            
        </div>
</section>

<?php 
	include 'include/footer.php';
 ?>
 