<?php include('includes/head.php'); ?>

<?php include('includes/header.php'); ?>
<?php include('includes/sidebar.php'); ?>

<?php
include('includes/connect.php');
date_default_timezone_set('Asia/Kathmandu');
$current_date = date('Y-m-d');

$id = $_GET['id'];

$sql = "SELECT * FROM `tbl_customer` WHERE customer_id ='$id' ";
$res = mysqli_query($conn, $sql);
$customerData = mysqli_fetch_assoc($res);


if (!empty($_POST)) {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $gender = $_POST['gender'];
    $password = $_POST['password'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    $sql = "UPDATE tbl_customer set first_name='$fname',last_name='$lname',email='$email',password='$password',gender='$gender',phone='$phone',address='$address' WHERE customer_id=$id";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        echo "<script>
                alert('Data Updated Successfully')
                window.location='view_customer.php';
                </script>";
    }
}


?>





<!-- Page wrapper  -->
<div class="page-wrapper">
    <!-- Bread crumb -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-primary">customer Management</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Add customer Management</li>
            </ol>
        </div>
    </div>
    <!-- End Bread crumb -->
    <!-- Container fluid  -->
    <div class="container-fluid">
        <!-- Start Page Content -->

        <!-- /# row -->
        <div class="row">
            <div class="col-lg-8" style="margin-left: 10%;">
                <div class="card">
                    <div class="card-title">

                    </div>
                    <div class="card-body">
                        <div class="input-states">
                            <form class="form-horizontal" method="POST" name="userform" enctype="multipart/form-data">


                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-sm-3 control-label">First Name</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="fname" value="<?= $customerData['first_name'] ?>" class="form-control" placeholder="First Name">
                                            <!-- <span class="help-block"><?= $errors['fname'] ?></span> -->
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-sm-3 control-label">Last Name</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="lname" value="<?= $customerData['last_name'] ?>" id="lname" class="form-control" placeholder="Last Name">
                                            <!-- <span class="help-block"><?= $errors['lname'] ?></span> -->

                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-sm-3 control-label">Email</label>
                                        <div class="col-sm-9">
                                            <input type="email" name="email" value="<?= $customerData['email'] ?>" id="email" class="form-control" placeholder="Email">
                                            <!-- <span class="help-block"><?= $errors['email'] ?></span> -->

                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-sm-3 control-label">Password</label>
                                        <div class="col-sm-9">
                                            <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                                            <!-- <span class="help-block"><?= $errors['password'] ?></span> -->

                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-sm-3 control-label">Gender</label>
                                        <div class="col-sm-9">
                                            <select name="gender" id="gender" class="form-control">
                                                <option value="Male" <?= $customerData['gender'] == 'male' ? 'selected' : ''; ?>>Male</option>
                                                <option value="Female" <?= $customerData['gender'] == 'female' ? 'selected' : ''; ?>>Female</option>
                                            </select>
                                            <!-- <span class="help-block"><?= $errors['gender'] ?></span> -->
                                        </div>
                                    </div>
                                </div>



                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-sm-3 control-label">Phone no.</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="phone" value="<?= $customerData['phone'] ?>" class="form-control" placeholder="Phone Number">
                                            <!-- <span class="help-block"><?= $errors['phone'] ?></span> -->

                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-sm-3 control-label">Address</label>
                                        <div class="col-sm-9">
                                            <input type="text" value="<?= $customerData['address'] ?>" class="form-control" name="address" placeholder="Address"></input>
                                            <!-- <span class="help-block"><?= $errors['address'] ?></span> -->

                                        </div>
                                    </div>
                                </div>


                                <button type="submit" name="btn_save" class="btn btn-primary btn-flat m-b-30 m-t-30">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- /# row -->

        <!-- End PAge Content -->


        <?php include('includes/footer.php'); ?>