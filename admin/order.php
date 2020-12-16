<?php
	include 'include/header.php';
	include 'include/sidebar.php';
 ?>
<?php 
if (!isset($_SESSION['login'])) {
        header('location:index.php');
    }
  //xu-ly-don
 if (isset($_GET['status'])) {
    $get_orderid = $_GET['orderid_status'];
    $status = $_GET['status'];
    $update_status = mysqli_query($mysqli,"UPDATE tbl_order SET status = '$status' WHERE orderid = '$get_orderid'");
    $get_orderd = mysqli_query($mysqli,"SELECT * FROM tbl_orderdetail WHERE orderId = '$get_orderid'");
    foreach ($get_orderd as $key => $value_orderd) {
       $qty_orderd = $value_orderd['quantity'];
       $id_ordered = $value_orderd['productId'];
     $get_product = mysqli_query($mysqli,"SELECT * FROM tbl_product WHERE productId = '$id_ordered'");
     foreach ($get_product as $key => $value_product_or) {
       $qty_pro = $value_product_or['quantity']; 
     $qty_pro_order = $qty_pro + $qty_orderd;
     //$_SESSION['refill'] = $qty_pro_order;
     if (isset($_SESSION['refill_s'])) {
      $count = count($_SESSION['refill_s']);
      $qty_order_total = array('qty'=>$qty_pro_order,'id'=>$id_ordered);
      $_SESSION['refill_s'][$count] = $qty_order_total;
    }else{
     $qty_order_total = array('qty'=>$qty_pro_order,'id'=>$id_ordered);
      $_SESSION['refill_s'][0] = $qty_order_total; 
    }
  }
}
    $_SESSION['accept'] = '';
    $_SESSION['update_status'] = 'Confirmed!!';
}   
   
  if (isset($_GET['idpro'])) {
    $id_pro = $_GET['idpro'];
    foreach ($_SESSION['refill_s'] as $key => $value_refill) {
      if ($value_refill['id'] == $id_pro) {
      $qty_real = $value_refill['qty'];
      $refill = mysqli_query($mysqli, "UPDATE tbl_product SET quantity = '$qty_real' WHERE productId = '$id_pro'");
      }
    }
    //unset($_SESSION['refill']);
}
//end-xu-ly-don
 ?>
<!--main content start-->
<section id="main-content">
	<section class="wrapper">
		<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
      Order List
    </div>
    <div class="row w3-res-tb">
      <div class="col-sm-4">
      </div>
      <div class="col-sm-4">
        <form action="" method="get">
        <div class="input-group">
          <input type="text" class="input-sm form-control" placeholder="Search" name="key" style="height: 34px">
          <span class="input-group-btn">
            <input type="submit" value="Go" name="search" class="btn btn-default">
          </span>
        </div>
      </form>
      </div>
    </div>
  <!--   list-danhmuc -->
    <?php 
        if (!isset($_GET['search'])) {
          # code...
     ?>
     
    <div class="table-responsive">
      <?php 
          if (isset($_SESSION['del_order_success'])) {
            # code...
            echo '<div style = "margin-left:5px;color:green">'.$_SESSION['del_order_success'].'</div>';
            unset($_SESSION['del_order_success']);
          }elseif (isset($_SESSION['del_order_fail'])) {
            # code...
            echo '<div style = "margin-left:5px;color:red">'.$_SESSION['del_order_fail'].'</div>';
            unset($_SESSION['del_order_fail']);
          }
          if (isset($_SESSION['update_status'])) {
            echo '<div style = "margin-left:5px;color:green">'.$_SESSION['update_status'].'</div>';
            unset($_SESSION['update_status']);
          }
       ?>
       
      <table class="table table-striped b-t b-light">
        <thead>
          <tr>
            <th style="width:20px;">
              <label class="i-checks m-b-none">
                <input type="checkbox"><i></i>
              </label>
            </th>
            <th>No</th>
            <th>Code</th>
            <th>Customer</th>
            <th>Total</th>
            <th>Discount</th>
            <th>Date</th>
            <th>Status</th>
            <th>Reason</th>
            <th>Action</th>
            <th style="width:30px;"></th>
          </tr>
        </thead>
        <tbody>
        	<?php 
            $get_order = mysqli_query($mysqli,"SELECT tbl_order.*,tbl_customer.level FROM tbl_order JOIN tbl_customer ON tbl_order.email = tbl_customer.email ORDER BY tbl_order.date desc");
            $i = 0;
            foreach ($get_order as $key => $value) {
              $i++;
              # code...
           ?>
          <tr>
            <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td>
            <td><?php echo $i ?></td>
            <td><?php echo $value['orderId'] ?></td>
            <td><?php echo $value['name'] ?></td>
            <td><?php echo number_format($value['total']).' VND' ?></td>
            <td><?php 
              if ($value['voucherCode'] == "TRUNGDEPTRAI" && $value['level'] == 2) {
                echo '30%';
              }elseif($value['voucherCode'] == "TRUNGDEPTRAI" && $value['level'] == 1){
                echo '20%';
              }elseif($value['voucherCode'] == "TRUNGDEPTRAI" && $value['level'] == 0){
                echo '10%';
              }elseif($value['level'] == 2){
                echo '20%';
              }elseif($value['level'] == 1){
                echo '10%';
              }else{
                echo '';
              }
             ?></td>
            <td><?php echo $value['date'] ?></td>
            <td>
              <?php 
                if ($value['status'] == 0) {
                ?>
                  <a href="?status=1&orderid_status=<?php echo $value['orderId'] ?>">Process</a>
                <?php
                }elseif ($value['status'] == 1) {
                ?>
                  <p>Done</p>
                <?php 
                }elseif($value['status'] == 2){  
                 ?>
                  <p>Cancel</p>
                  <?php 
                  }else{
                   ?>
                   <p>Customer Cancel...</p>
                   <?php 
                 }
                    ?>
            </td>
            <?php 
                if ($value['status'] == 3) {
                  
             ?>
            <td><?php echo $value['reason'] ?></td>
            <?php 
              }else{
             ?>
             <td></td>
             <?php 
              }
              ?>
            <td>
              <a href="?orderid=<?php echo $value['orderId'] ?>" class="active" ui-toggle-class=""><i class="fa fa-eye text-active"></i></a>
              <?php 
                if($value['status'] == 3 || $value['status'] == 0){
               ?>
              | <a href="?status=2&orderid_status=<?php echo $value['orderId'] ?>" onclick="return confirm('Are you want to Delete?')"><i class="fa fa-times text-danger text"></i></a>
              <?php 
                }
               ?>
            </td>
          </tr>
          <?php 
            
            }
           ?>
        </tbody>
      </table>
      
    </div><br><br>
    <?php 
        if (isset($_GET['orderid'])) {
     ?>
      <div class="table-responsive">
      <table class="table table-striped b-t b-light">
        <thead>
          <tr>
            <th style="width:20px;">
              <label class="i-checks m-b-none">
                <input type="checkbox"><i></i>
              </label>
            </th>
            <th>No</th>
            <th>Product</th>
            <th>Name</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php 
            $order = $_GET['orderid'];
            $get_pro = mysqli_query($mysqli,"SELECT tbl_orderdetail.*,tbl_order.status, tbl_product.productName,tbl_product.image FROM tbl_orderdetail JOIN tbl_product ON tbl_orderdetail.productId = tbl_product.productId JOIN tbl_order ON tbl_orderdetail.orderId = tbl_order.orderId WHERE tbl_orderdetail.orderId = '$order'");
            $i = 0;
            foreach ($get_pro as $key => $value_product) {
              $i++;
              # code...
           ?>
          <tr>
            <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td>
            <td><?php echo $i ?></td>
            <td><img src="../uploads/<?php echo $value_product['image'] ?>" width="100" height="100" ></td>
            <td><?php echo $value_product['productName'] ?></td>
            <td><?php echo $value_product['quantity'] ?></td>
            <td><?php echo number_format($value_product['price']). ' VND' ?></td>
            <td>
              <?php 
                if ($value_product['status'] == 2) {
                  // if (isset($_GET['idpro'])) {
                  //   # code...
                  //   $id_pro_off = $_GET['idpro'];
                  //   foreach ($_SESSION['refill_s'] as $key => $value_refills) {
                  //   if ($value_refills['id'] == $id_pro_off) {
                  //   $qty_order_off = $value_refills['qty'];   
                  //   }
                  // }
                  //   $get_pro_off = mysqli_query($mysqli,"SELECT * FROM tbl_product WHERE productId = '$id_pro_off'");
                  //   $fetch_pro_off = mysqli_fetch_array($get_pro_off);
                  //   $qty_pro_off = $fetch_pro_off['quantity'];
                  //   if ($qty_order_off == $qty_pro_off) {
                 ?>
               <a href="?idpro=<?php echo $value_product['productId'] ?>">Refill</a>
               <?php } 
               // echo '<a href="?idpro='.$value_product['productId'].'">Refill</a>';
               ?></td>
          </tr>
          <?php   
            }
           ?>
        </tbody>
      </table>
    </div>
     <?php 
      }
      ?>

    <?php 
        }
     ?>
     <!-- end-listdanhmuc -->

     <!-- search-list-danhmuc -->
      <?php 
        if(isset($_GET['search'])){
          $key = $_GET['key'];
       ?>
       <div class="table-responsive">
      <?php 
          if (isset($_SESSION['del_order_success'])) {
            # code...
            echo '<div style = "margin-left:5px;color:green">'.$_SESSION['del_order_success'].'</div>';
            unset($_SESSION['del_order_success']);
          }elseif (isset($_SESSION['del_order_fail'])) {
            # code...
            echo '<div style = "margin-left:5px;color:red">'.$_SESSION['del_order_fail'].'</div>';
            unset($_SESSION['del_order_fail']);
          }
          if (isset($_SESSION['update_status'])) {
            echo '<div style = "margin-left:5px;color:green">'.$_SESSION['update_status'].'</div>';
            unset($_SESSION['update_status']);
          }
       ?>
       
      <table class="table table-striped b-t b-light">
        <thead>
          <tr>
            <th style="width:20px;">
              <label class="i-checks m-b-none">
                <input type="checkbox"><i></i>
              </label>
            </th>
            <th>No</th>
            <th>Code</th>
            <th>Customer</th>
            <th>Total</th>
            <th>Discount</th>
            <th>Date</th>
            <th>Status</th>
            <th>Reason</th>
            <th>Action</th>
            <th style="width:30px;"></th>
          </tr>
        </thead>
        <tbody>
          <?php 
            $get_order_search = mysqli_query($mysqli,"SELECT tbl_order.*,tbl_customer.level FROM tbl_order JOIN tbl_customer ON tbl_order.email = tbl_customer.email WHERE orderId = '$key' ORDER BY tbl_order.date desc");
            $i = 0;
            foreach ($get_order_search as $key => $value) {
              $i++;
              # code...
           ?>
          <tr>
            <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td>
            <td><?php echo $i ?></td>
            <td><?php echo $value['orderId'] ?></td>
            <td><?php echo $value['name'] ?></td>
            <td><?php echo number_format($value['total']).' VND' ?></td>
            <td><?php 
              if ($value['voucherCode'] == "TRUNGDEPTRAI" && $value['level'] == 2) {
                echo '30%';
              }elseif($value['voucherCode'] == "TRUNGDEPTRAI" && $value['level'] == 1){
                echo '20%';
              }elseif($value['voucherCode'] == "TRUNGDEPTRAI" && $value['level'] == 0){
                echo '10%';
              }elseif($value['level'] == 2){
                echo '20%';
              }elseif($value['level'] == 1){
                echo '10%';
              }else{
                echo '';
              }
             ?></td>
            <td><?php echo $value['date'] ?></td>
            <td>
              <?php 
                if ($value['status'] == 0) {
                ?>
                  <a href="?status=1&orderid_status=<?php echo $value['orderId'] ?>">Process</a>
                <?php
                }elseif ($value['status'] == 1) {
                ?>
                  <p>Done</p>
                <?php 
                }elseif($value['status'] == 2){  
                 ?>
                  <p>Cancel</p>
                  <?php 
                  }else{
                   ?>
                   <p>Customer Cancel...</p>
                   <?php 
                 }
                    ?>
            </td>
            <?php 
                if ($value['status'] == 3) {
                  
             ?>
            <td><?php echo $value['reason'] ?></td>
            <?php 
              }else{
             ?>
             <td></td>
             <?php 
              }
              ?>
            <td>
              <a href="?orderid=<?php echo $value['orderId'] ?>" class="active" ui-toggle-class=""><i class="fa fa-eye text-active"></i></a>
              <?php 
                if($value['status'] == 3 || $value['status'] == 0){
               ?>
              | <a href="?status=2&orderid_status=<?php echo $value['orderId'] ?>" onclick="return confirm('Are you want to Delete?')"><i class="fa fa-times text-danger text"></i></a>
              <?php 
                }
               ?>
            </td>
          </tr>
          <?php 
            
            }
           ?>
        </tbody>
      </table>
      
    </div><br><br>
    <?php
        }
      ?>
    <!-- end-search-listdanhmuc -->
</div>
</section>

<?php 
	include 'include/footer.php';
 ?>
 