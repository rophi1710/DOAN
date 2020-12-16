<?php
    include 'include/header.php';
    include 'include/sidebar.php';
    if (!isset($_SESSION['login'])) {
        header('location:index.php');
    }
 ?>
<!-- them-sanpham -->
<?php 
    if (isset($_POST['submit'])) {
        # code...
        $name = $_POST['productName'];
        $price = $_POST['price'];
        $quantity = $_POST['quantity'];
        $des = $_POST['productDes'];
        $cat = $_POST['category'];
        $color = $_POST['color'];
        $status = $_POST['status'];

        $permited = array('jpg','png','jpeg');
        $file_name = $_FILES['image']['name'];
        $file_size = $_FILES['image']['size'];
        $file_temp = $_FILES['image']['tmp_name'];

        $div = explode('.', $file_name);
        $file_ext = strtolower(end($div));
        $unique_image = substr(md5(time()), 0,10).'.'.$file_ext;
        $uploaded_image = "../uploads/".$unique_image;
        $check_unique = mysqli_query($mysqli,"SELECT * FROM tbl_product WHERE productName = '$name'");
        if (mysqli_num_rows($check_unique) > 0) {
            # code...
            $_SESSION['add_namepro_fail'] = 'Already Product';
        }elseif (in_array($file_ext, $permited) == false) {
            # code...
            $_SESSION['ext_img'] = 'You only use .jpg, .jpeg, .png';
        }elseif(empty($name) || empty($price) || empty($quantity) || empty($des)){
             $_SESSION['empty'] = 'Information is empty! Please fill in full information';
        }elseif($price < 0){
            $_SESSION['price_error'] = 'Price is positive value';
        }else{
            move_uploaded_file($file_temp, $uploaded_image);
            $insert_pro = mysqli_query($mysqli,"INSERT INTO tbl_product(productName,price,quantity,productDes,catId,color,status,image) values ('$name','$price','$quantity','$des','$cat','$color','$status','$unique_image')");
            $_SESSION['pro_success'] = 'Added Product Successfully!!';
        }
    }

 ?>
<!--main content start-->
<section id="main-content">
    <section class="wrapper">
        <div class="row">
                <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Add Product
                            
                        </header>
                        <div class="panel-body">
                            <div class="form">
                                <?php
                                    if(isset($_SESSION['pro_success'])){
                                        echo '<div style = "margin-left:110px;margin-bottom:5px;color:green;">'.$_SESSION['pro_success'].'</div>';
                                        unset($_SESSION['pro_success']);
                                    }
                                    if (isset($_SESSION['ext_img'])) {
                                        echo '<div style = "margin-left:110px;margin-bottom:5px;color:red;">'.$_SESSION['ext_img'].'</div>';
                                        unset($_SESSION['ext_img']);
                                    }
                                    if (isset($_SESSION['empty'])) {
                                        echo '<div style = "margin-left:110px;margin-bottom:5px;color:red;">'.$_SESSION['empty'].'</div>';
                                        unset($_SESSION['empty']);
                                    }
                                    if (isset($_SESSION['price_error'])) {
                                        echo '<div style = "margin-left:110px;margin-bottom:5px;color:red;">'.$_SESSION['price_error'].'</div>';
                                        unset($_SESSION['price_error']);
                                    }
                                 ?>
                                <form class="cmxform form-horizontal " method="post" action="" enctype="multipart/form-data">
                                    <div class="form-group ">
                                        <label for="firstname" class="control-label col-lg-3">Name</label>
                                        <div class="col-lg-6">
                                            <input class=" form-control" id="firstname" name="productName" type="text">
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="email" class="control-label col-lg-3">Price</label>
                                        <div class="col-lg-6">
                                            <input class="form-control " name="price" type="text">
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="confirm_password" class="control-label col-lg-3">Quantity</label>
                                        <div class="col-lg-6">
                                            <input class="form-control "name="quantity" type="number" min="1">
                                        </div>
                                    </div>
                                     <div class="form-group ">
                                        <label for="email" class="control-label col-lg-3">Description</label>
                                        <div class="col-lg-6">
                                            <textarea name="productDes" style="resize: none" rows="5" class="form-control tinymce"></textarea>
                                        </div>
                                    </div>
                                      <div class="form-group ">
                                        <label for="lastname" class="control-label col-lg-3">Image</label>
                                        <div class="col-lg-6">
                                            <input class=" form-control" id="lastname" name="image" type="file">
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="username" class="control-label col-lg-3">Category</label>
                                        <div class="col-lg-6">
                                            <select name="category">
                                                <?php 
                                                $get_cat = mysqli_query($mysqli,"SELECT * FROM tbl_category");
                                                foreach ($get_cat as $key => $value) {
                                                    # code...
                                             ?>
                                                <option value="<?php echo $value['catId'] ?>"><?php echo $value['catName'] ?></option>
                                                 <?php 
                                                }
                                             ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="password" class="control-label col-lg-3">Color</label>
                                        <div class="col-lg-6">
                                           <select name="color">
                                                <option value="1">White</option>
                                                <option value="2">Black</option>
                                                <option value="3">Red</option>
                                                <option value="4">Green</option>
                                                <option value="5">Yellow</option>
                                                <option value="6">Blue</option>
                                                <option value="0">All color</option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group ">
                                        <label for="email" class="control-label col-lg-3">Status</label>
                                        <div class="col-lg-6">
                                            <select name="status">
                                                <option value="0">On</option>
                                                <option value="1">Off</option>
                                            </select>
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
            <!-- page end-->
</section>

<?php 
    include 'include/footer.php';
 ?>
