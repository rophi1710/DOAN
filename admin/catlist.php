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
      $id = $_GET['delid'];
      $del_cat = mysqli_query($mysqli,"DELETE FROM tbl_category WHERE catId = '$id'");
      if($del_cat){
        $_SESSION['del_success'] = 'Deleted Category Successfully!';
      }else{
        $_SESSION['del_fail'] = 'Deleted Category Fail!!';
      }
    }
 //end-xoa   
 ?>
<!--main content start-->
<section id="main-content">
	<section class="wrapper">
		<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
      Category List
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
            <th>Category Name</th>
            <th>Action</th>
            <th style="width:30px;"></th>
          </tr>
        </thead>
        <tbody>
        	<?php 
        		$get_cat = mysqli_query($mysqli,"SELECT * FROM tbl_category ORDER BY catId desc");
        		$i = 0;
        		foreach ($get_cat as $key => $value) {
        			$i++;
        			# code...
        	 ?>
          <tr>
            <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td>
            <td><?php echo $i ?></td>
            <td><?php echo $value['catName'] ?></td>
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
            <th>Category Name</th>
            <th>Action</th>
            <th style="width:30px;"></th>
          </tr>
        </thead>
        <tbody>
            <?php 
                $key = $_GET['key'];
                $i = 0;
                $search_cat = mysqli_query($mysqli,"SELECT * FROM tbl_category WHERE catName LIKE '%$key%'");
              foreach ($search_cat as $key => $value_search) {
                # code...
                $i++;
             ?>
          <tr>
            <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td>
            <td><?php echo $i ?></td>
            <td><?php echo $value_search['catName'] ?></td>
            <td>
              <a href="catedit.php?catid=<?php echo $value_search['catId'] ?>" class="active" ui-toggle-class=""><i class="fa fa-edit text-active"></i></a><a href="?delid=<?php echo $value_search['catId'] ?>" onclick="return confirm('Are you want to Delete?')"><i class="fa fa-times text-danger text"></i></a>
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
 