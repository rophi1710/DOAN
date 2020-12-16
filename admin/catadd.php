<?php
	include 'include/header.php';
	include 'include/sidebar.php';
 ?>
 <!-- them-danhmuc -->
<?php 
    if (!isset($_SESSION['login'])) {
        header('location:index.php');
    }
	if (isset($_POST['submit'])) {
		# code...
		$catname = $_POST['name'];
		$get_unique = mysqli_query($mysqli,"SELECT * FROM tbl_category WHERE catName = '$catname'");
		if(mysqli_num_rows($get_unique) > 0){
			$_SESSION['cat_fail'] = 'Already category';
		}else{
            if(empty($catname)){
            $_SESSION['empty'] = 'Category Name is empty';
            }else{
			 $_SESSION['cat_success'] = 'Added Category Successfully!!';
			 $insert = mysqli_query($mysqli,"INSERT INTO tbl_category(catName) values ('$catname')");
		    }
        }
	}
 ?>
 <!-- end-them-danhmuc -->
 
<!--main content start-->
<section id="main-content">
	<section class="wrapper">
		            <div class="row">
                <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Add Category
                            
                        </header>
                        
                        <div class="panel-body">
                            <div class=" form">
                            	<?php
		                        	if(isset($_SESSION['cat_fail'])){
		                        		echo '<div style = "margin-left:110px;margin-bottom:5px;color:red;">'.$_SESSION['cat_fail'].'</div>';
		                        		unset($_SESSION['cat_fail']);
		                        	}
                                    if(isset($_SESSION['cat_success'])){
		                        		echo '<div style = "margin-left:110px;margin-bottom:5px;color:green;">'.$_SESSION['cat_success'].'</div>';
                                        unset($_SESSION['cat_success']);
		                        	}
                                    if(isset($_SESSION['empty'])){
                                        echo '<div style = "margin-left:110px;margin-bottom:5px;color:red;">'.$_SESSION['empty'].'</div>';
                                        unset($_SESSION['empty']);
                                    }
		                         ?>
                                <form class="cmxform form-horizontal " id="commentForm" method="post" action="" novalidate="novalidate">
                                    <div class="form-group ">
                                        <label for="cname" class="control-label col-lg-3">Category Name</label>
                                        <div class="col-lg-6">
                                            <input class=" form-control" id="cname" name="name" type="text" required="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-lg-offset-3 col-lg-6">
                                           <input type="submit" class="btn btn-success" value="Add" name="submit">
                                            
                                        </div>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </section>
                </div>
            </div>
</section>

<?php 
	include 'include/footer.php';
 ?>
 