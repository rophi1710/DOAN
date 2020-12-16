<?php
	include 'include/header.php';
	include 'include/sidebar.php';
 ?>
<?php 
if (!isset($_SESSION['login'])) {
        header('location:index.php');
    }
//xoa
    if(isset($_GET['delid'])){
      $em = $_GET['delid'];
      $del_cat = mysqli_query($mysqli,"DELETE FROM tbl_customer WHERE email = '$em'");
      if($del_cat){
        $_SESSION['del_cus_success'] = 'Deleted Successfully!';
      }else{
        $_SESSION['del_cus_fail'] = 'Deleted Fail!!';
      }
    }
 //end-xoa   
    if (!empty($_GET['level'])) {
      if (isset($_GET['level']) == 1) {
        $lv = $_GET['level'];
      }else{
        $lv = '';
      }
      $email_lv = $_GET['email'];
      $update_level_silver = mysqli_query($mysqli,"UPDATE tbl_customer SET level = '$lv' WHERE email = '$email_lv'");
    }
    
    if (!empty($_GET['level'])) {
      if (isset($_GET['level']) == 2) {
        $lv = $_GET['level'];
      }else{
       $lv = '';
      }
      $email_lv = $_GET['email'];
      $update_level_silver = mysqli_query($mysqli,"UPDATE tbl_customer SET level = '$lv' WHERE email = '$email_lv'");
    }
 ?>
<!--main content start-->
<section id="main-content">
	<section class="wrapper">
		<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
      Customers
    </div>
    <div class="row w3-res-tb">
      <div class="col-sm-4">
      </div>
      <div class="col-sm-4">
        <form action="" method="get">
        <div class="input-group">
          <input type="text" class="input-sm form-control" placeholder="Search" name="key" style="height: 34px">
          <span class="input-group-btn">
            <input type="submit" value="Go!" name="search" class="btn btn-default">
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
          if (isset($_SESSION['del_cus_success'])) {
            # code...
            echo '<div style = "margin-left:5px;color:green">'.$_SESSION['del_cus_success'].'</div>';
            unset($_SESSION['del_cus_success']);
          }elseif (isset($_SESSION['del_cus_fail'])) {
            # code...
            echo '<div style = "margin-left:5px;color:red">'.$_SESSION['del_cus_fail'].'</div>';
            unset($_SESSION['del_cus_fail']);
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
            <th>Name</th>
            <th>Email</th>
            <th>Address</th>
            <th>Phone</th>
            <th>Level</th>
            <th>Action</th>
            <th style="width:30px;"></th>
          </tr>
        </thead>
        <tbody>
        	<?php 
        		$get_cat = mysqli_query($mysqli,"SELECT * FROM tbl_customer");
        		$i = 0;
        		foreach ($get_cat as $key => $value) {
        			$i++;
        			# code...
        	 ?>
          <tr>
            <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td>
            <td><?php echo $i ?></td>
            <td><?php echo $value['name'] ?></td>
            <td><?php echo $value['email'] ?></td>
            <td><?php echo $value['address'] ?></td>
            <td><?php echo $value['phone'] ?></td>
            <td><?php 
              if ($value['level'] == 0) {
                  echo 'Normal';
                  if ($value['total'] >= 2000000) {
                    echo '<a href="?level=1&email='.$_SESSION['cusEmail'].'">->Silver</a>';
                  }
                }elseif ($value['level'] == 1) {
                  echo 'Silver';
                  if ($value['total'] >= 5000000) {
                    echo '<a href="?level=2&email='.$_SESSION['cusEmail'].'">->Gold</a>';
                  }
                }else{
                  echo 'Gold';
                }
             ?></td>
            <td>
              <a href="?delid=<?php echo $value['email'] ?>" onclick="return confirm('Are you want to Delete?')"><i class="fa fa-times text-danger text"></i></a>
            </td>
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
     <!-- end-listdanhmuc -->

     <!-- search-list-danhmuc -->
      <?php 
        if(isset($_GET['search'])){
          $key = $_GET['key']
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
            <th>Name</th>
            <th>Email</th>
            <th>Address</th>
            <th>Phone</th>
            <th>Level</th>
            <th>Action</th>
            <th style="width:30px;"></th>
          </tr>
        </thead>
        <tbody>
          <?php 
            $get_search = mysqli_query($mysqli,"SELECT * FROM tbl_customer WHERE name LIKE '%$key%'");
            $i = 0;
            foreach ($get_search as $key => $value) {
              $i++;
              # code...
           ?>
          <tr>
            <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td>
            <td><?php echo $i ?></td>
            <td><?php echo $value['name'] ?></td>
            <td><?php echo $value['email'] ?></td>
            <td><?php echo $value['address'] ?></td>
            <td><?php echo $value['phone'] ?></td>
            <td><?php 
                $email = $value['email'];
                $total = 0;
                $total_price = mysqli_query($mysqli,"SELECT tbl_order.total FROM tbl_order JOIN tbl_customer ON tbl_order.email = tbl_customer.email WHERE tbl_order.email = '$email'");
                foreach ($total_price as $key => $value_price) {
                $total = $total + $value_price['total'];
              }            
              $update_price_cus = mysqli_query($mysqli,"UPDATE tbl_customer SET total = '$total' WHERE email = '$email'");
              if ($value['level'] == 0) {
                  echo 'Normal';
                  if ($value['total'] >= 2000000) {
                    echo '<a href="?level=1&email='.$email.'">->Silver</a>';
                  }
                }elseif ($value['level'] == 1) {
                  echo 'Silver';
                  if ($value['total'] >= 5000000) {
                    echo '<a href="?level=2&email='.$email.'">->Gold</a>';
                  }
                }else{
                  echo 'Gold';
                }
             ?></td>
            <td>
              <a href="?delid=<?php echo $value['email'] ?>" onclick="return confirm('Are you want to Delete?')"><i class="fa fa-times text-danger text"></i></a>
            </td>
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
    <!-- end-search-listdanhmuc -->
</div>
</section>

<?php 
	include 'include/footer.php';
 ?>
 