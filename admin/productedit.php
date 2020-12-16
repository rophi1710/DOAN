<?php
    include 'include/header.php';
    include 'include/sidebar.php';
    if (!isset($_SESSION['login'])) {
        header('location:index.php');
    }
    if (!isset($_GET['proid'])) {
        header('location:404.html');
    }
 ?>
<!-- them-sanpham -->
<?php 
    if (isset($_POST['submit'])) {
        # code...
        $id = $_POST['product_id'];
        $name = $_POST['productName'];
        $price = $_POST['price'];
        $quantity = $_POST['quantity'];
        $des = $_POST['productDes'];
        $cat = $_POST['category'];
        $color = $_POST['color'];

        $permited = array('jpg','png','jpeg');
        $file_name = $_FILES['image']['name'];
        $file_size = $_FILES['image']['size'];
        $file_temp = $_FILES['image']['tmp_name'];

        $div = explode('.', $file_name);
        $file_ext = strtolower(end($div));
        $unique_image = substr(md5(time()), 0,10).'.'.$file_ext;
        $uploaded_image = "../uploads/".$unique_image;

        if (!empty($file_name)) {
            if (in_array($file_ext, $permited) == false) {
            # code...
            $_SESSION['ext_img'] = 'You only use .jpg, .jpeg, .png';
            }else{
            # code...
            move_uploaded_file($file_temp, $uploaded_image);
            $insert_pro = mysqli_query($mysqli,"UPDATE tbl_product SET
                productName = '$name',
                price = '$price',
                quantity = '$quantity',
                productDes = '$des',
                catId = '$cat',
                color = '$color',
                image = '$unique_image'
                WHERE productId = '$id'
                ");
            $_SESSION['pro_success_update'] = 'Updated Product Successfully!!';
            }
        }elseif($price < 0){
            $_SESSION['price_error'] = 'Price is positive value';
        }elseif(empty($name) || empty($price) || empty($quantity) || empty($des)){
             $_SESSION['empty'] = 'Information is empty! Please fill in full information';
        }else{
            $insert_pro_noimg = mysqli_query($mysqli,"UPDATE tbl_product SET
                productName = '$name',
                price = '$price',
                quantity = '$quantity',
                productDes = '$des',
                catId = '$cat',
                color = '$color'
                WHERE productId = '$id'
                ");
            $_SESSION['pro_success_update'] = 'Updated Product Successfully!!';

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
                            Edit Product
                            
                        </header>
                        <div class="panel-body">
                            <div class="form">
                                <?php
                                    if(isset($_SESSION['pro_success_update'])){
                                        echo '<div style = "margin-left:110px;margin-bottom:5px;color:green;">'.$_SESSION['pro_success_update'].'</div>';
                                        unset($_SESSION['pro_success_update']);
                                        header('location:productlist.php');
                                    }
                                    if (isset($_SESSION['ext_img'])) {
                                        echo '<div style = "margin-left:110px;margin-bottom:5px;color:red;">'.$_SESSION['ext_img'].'</div>';
                                        unset($_SESSION['ext_img']);
                                    }
                                    if (isset($_SESSION['price_error'])) {
                                        echo '<div style = "margin-left:110px;margin-bottom:5px;color:red;">'.$_SESSION['price_error'].'</div>';
                                        unset($_SESSION['price_error']);
                                    }
                                     if (isset($_SESSION['empty'])) {
                                        echo '<div style = "margin-left:110px;margin-bottom:5px;color:red;">'.$_SESSION['empty'].'</div>';
                                        unset($_SESSION['empty']);
                                    }
                                 ?>
                                 <?php 
                                   if (isset($_GET['proid'])) {
                                        $id = $_GET['proid'];
                                    $get_product = mysqli_query($mysqli,"SELECT tbl_category.catName,tbl_product.* FROM tbl_product JOIN tbl_category ON tbl_product.catId = tbl_category.catId WHERE tbl_product.productId = '$id' ");
                                    foreach ($get_product as $key => $value) {
                                        # code...
                                    
                                  ?>
                                <form class="cmxform form-horizontal " method="post" action="" enctype="multipart/form-data">
                                    <input type="hidden" name="product_id" value="<?php echo $value['productId'] ?>">
                                    <div class="form-group ">
                                        <label for="firstname" class="control-label col-lg-3">Name</label>
                                        <div class="col-lg-6">
                                            <input class=" form-control" id="firstname" name="productName" value="<?php echo $value['productName'] ?>" type="text">
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="email" class="control-label col-lg-3">Price</label>
                                        <div class="col-lg-6">
                                            <input class="form-control " name="price" value="<?php echo $value['price'] ?>" type="text">
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="confirm_password" class="control-label col-lg-3">Quantity</label>
                                        <div class="col-lg-6">
                                            <input class="form-control "name="quantity" value="<?php echo $value['quantity'] ?>" type="number" min="1">
                                        </div>
                                    </div>
                                     <div class="form-group ">
                                        <label for="email" class="control-label col-lg-3">Description</label>
                                        <div class="col-lg-6">
                                            <textarea name="productDes" style="resize: none" rows="5" class="form-control tinymce"><?php echo $value['productDes'] ?></textarea>
                                        </div>
                                    </div>
                                      <div class="form-group ">
                                        <label for="lastname" class="control-label col-lg-3">Image</label>
                                        <div class="col-lg-6">
                                            <img src="../uploads/<?php echo $value['image'] ?>" width="100" height="100">
                                            <input class=" form-control" id="lastname" name="image" type="file">
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="username" class="control-label col-lg-3">Category</label>
                                        <div class="col-lg-6">
                                            <select name="category">
                                                <?php 
                                                $get_cat = mysqli_query($mysqli,"SELECT * FROM tbl_category");
                                                foreach ($get_cat as $key => $value_cat) {
                                                    # code...
                                             ?>
                                                <option
                                                <?php 
                                                    if ($value['catId'] == $value_cat['catId']) {
                                                        echo 'selected';
                                                    }
                                                 ?> 
                                                value="<?php echo $value_cat['catId'] ?>"><?php echo $value_cat['catName'] ?></option>
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
                                                <option
                                                <?php 
                                                    if ($value['color'] == 1) {
                                                        echo 'selected';
                                                    }
                                                 ?>
                                                 value="1">White</option>
                                                <option
                                                <?php 
                                                    if ($value['color'] == 2) {
                                                        echo 'selected';
                                                    }
                                                 ?>
                                                 value="2">Black</option>
                                                <option
                                                <?php 
                                                    if ($value['color'] == 3) {
                                                        echo 'selected';
                                                    }
                                                 ?>
                                                 value="3">Red</option>
                                                <option
                                                <?php 
                                                    if ($value['color'] == 4) {
                                                        echo 'selected';
                                                    }
                                                 ?>
                                                 value="4">Green</option>
                                                <option
                                                <?php 
                                                    if ($value['color'] == 5) {
                                                        echo 'selected';
                                                    }
                                                 ?>
                                                 value="5">Yellow</option>
                                                <option
                                                <?php 
                                                    if ($value['color'] == 6) {
                                                        echo 'selected';
                                                    }
                                                 ?>
                                                 value="6">Blue</option>
                                                <option
                                                <?php 
                                                    if ($value['color'] == 0) {
                                                        echo 'selected';
                                                    }
                                                 ?>
                                                 value="0">All color</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-lg-offset-3 col-lg-6">
                                            <input type="submit" class="btn btn-success" value="Update" name="submit">
                                        </div>
                                    </div>
                                </form>
                                <?php 
                                    }
                                }
                                 ?>
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
