<?php
	include 'include/header.php';
	include 'include/sidebar.php';
  if (!isset($_SESSION['login'])) {
        header('location:index.php');
    }
 ?>
<?php 
//xoa
    if(isset($_GET['delid'])){
      $id = $_GET['delid'];
      $del_cat = mysqli_query($mysqli,"DELETE FROM tbl_product WHERE productId = '$id'");
      if($del_cat){
        $_SESSION['del_success'] = 'Deleted Product Successfully!';
      }else{
        $_SESSION['del_fail'] = 'Deleted Product Fail!!';
      }
    }
 //end-xoa 
    if (isset($_GET['status'])) {
        $get_status = $_GET['status'];
        $id_status = $_GET['proid'];
        $update_status = mysqli_query($mysqli,"UPDATE tbl_product SET status = '$get_status' WHERE productId = '$id_status'");
      }  
 ?>
<!--main content start-->
<section id="main-content">
	<section class="wrapper">
		<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
      Product List
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
          if (isset($_SESSION['del_success'])) {
            # code...
            echo '<div style = "margin-left:5px;color:green">'.$_SESSION['del_success'].'</div>';
            unset($_SESSION['del_success']);
          }elseif (isset($_SESSION['del_fail'])) {
            # code...
            echo '<div style = "margin-left:5px;color:red">'.$_SESSION['del_fail'].'</div>';
            unset($_SESSION['del_fail']);
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
            <th>Product</th>
            <th>Image</th>
            <th>Description</th>
            <th>Category</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Color</th>
            <th>Status</th>
            <th>Action</th>
            <th style="width:30px;"></th>
          </tr>
        </thead>
        <tbody>
        	<?php 
        		$get_product = mysqli_query($mysqli,"SELECT tbl_category.catName,tbl_product.* FROM tbl_product JOIN tbl_category ON tbl_product.catId = tbl_category.catId ORDER BY tbl_product.productId desc");
        		$i = 0;
        		foreach ($get_product as $key => $value) {
        			$i++;
        			# code...
        	 ?>
          <tr>
            <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td>
            <td><?php echo $i ?></td>
            <td><?php echo $value['productName'] ?></td>
            <td><img src="../uploads/<?php echo $value['image'] ?>" width="100px" height="100px"></td>
            <td><?php echo $value['productDes'] ?></td>
            <td><?php echo $value['catName'] ?></td>
            <td><?php echo $value['quantity'] ?></td>
            <td><?php echo number_format($value['price']).' VND' ?></td>
            <td><?php 
                $color = $value['color'];
                if ($color == 0) {
                  echo 'All color';
                }elseif ($color == 1) {
                  echo 'White';
                }elseif ($color == 2) {
                  echo 'Black';
                }elseif ($color == 3) {
                  echo 'Red';
                }elseif ($color == 4) {
                  echo 'Green';
                }elseif ($color == 5) {
                  echo 'Yellow';
                }elseif ($color == 6) {
                  echo 'Blue';
                }
             ?></td>
             <td><?php 
                if ($value['status'] == 0) { 
              ?>
              <a href="?status=1&proid=<?php echo $value['productId'] ?>">On</a>
                <?php 
              }else{
                 ?>
              <a href="?status=0&proid=<?php echo $value['productId'] ?>">Off</a>
                 <?php 
               }
                  ?>
              </td>
            <td>
              <a href="productedit.php?proid=<?php echo $value['productId'] ?>" class="active" ui-toggle-class=""><i class="fa fa-edit text-active"></i></a><a href="?delid=<?php echo $value['productId'] ?>" onclick="return confirm('Are you want to Delete?')"><i class="fa fa-times text-danger text"></i></a>
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
            <th>Image</th>
            <th>Description</th>
            <th>Category</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Color</th>
            <th>Status</th>
            <th>Action</th>
            <th style="width:30px;"></th>
          </tr>
        </thead>
        <tbody>
          <?php 
            $key = $_GET['key'];
            $get_product = mysqli_query($mysqli,"SELECT tbl_category.catName,tbl_product.* FROM tbl_product JOIN tbl_category ON tbl_product.catId = tbl_category.catId WHERE productName LIKE '%$key%' ORDER BY tbl_product.productId desc");
            $i = 0;
            foreach ($get_product as $key => $value) {
              $i++;
              # code...
           ?>
          <tr>
            <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td>
            <td><?php echo $i ?></td>
            <td><?php echo $value['productName'] ?></td>
            <td><img src="../uploads/<?php echo $value['image'] ?>" width="100px" height="100px"></td>
            <td><?php echo $value['productDes'] ?></td>
            <td><?php echo $value['catName'] ?></td>
            <td><?php echo $value['quantity'] ?></td>
            <td><?php echo number_format($value['price']).' VND' ?></td>
            <td><?php 
                $color = $value['color'];
                if ($color == 0) {
                  echo 'All color';
                }elseif ($color == 1) {
                  echo 'White';
                }elseif ($color == 2) {
                  echo 'Black';
                }elseif ($color == 3) {
                  echo 'Red';
                }elseif ($color == 4) {
                  echo 'Green';
                }elseif ($color == 5) {
                  echo 'Yellow';
                }elseif ($color == 6) {
                  echo 'Blue';
                }
             ?></td>
             <td><?php 
                if ($value['status'] == 0) { 
              ?>
              <a href="?status=1&proid=<?php echo $value['productId'] ?>">On</a>
                <?php 
              }else{
                 ?>
              <a href="?status=0&proid=<?php echo $value['productId'] ?>">Off</a>
                 <?php 
               }
                  ?>
              </td>
            <td>
              <a href="catedit.php?catid=<?php echo $value['catId'] ?>" class="active" ui-toggle-class=""><i class="fa fa-edit text-active"></i></a><a href="?delid=<?php echo $value['catId'] ?>" onclick="return confirm('Are you want to Delete?')"><i class="fa fa-times text-danger text"></i></a>
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
 