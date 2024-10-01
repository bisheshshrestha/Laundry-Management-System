<?php include('includes/head.php'); ?>

<?php include('includes/header.php'); ?>
<?php include('includes/sidebar.php'); ?>

<?php
include('includes/connect.php');

$errors = [
    'fname' => '',
    'lname' => '',
    'email' => '',
    'password' => '',
    'gender' => '',
    'phone' => '',
    'address' => ''
];
$oldvalue = [
    'fname' => '',
    'lname' => '',
    'email' => '',
    'password' => '',
    'gender' => '',
    'phone' => '',
    'address' => ''
];


if (!empty($_POST)) {

    if (empty($_POST['fname'])) {
        $errors['fname'] = 'First Name is required';
    }


    if (empty($_POST['lname'])) {
        $errors['lname'] = 'Last Name is required';
    }

    if (empty($_POST['email'])) {
        $errors['email'] = 'email is required';
    } else {
        if (!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/i", $_POST['email'])) {
            $errors['email'] = "Error: Invalid email address";
        }
    }

    if (empty($_POST['password'])) {
        $errors['password'] = 'Password is required';
    }
    if (empty($_POST['gender'])) {
        $errors['gender'] = 'Gender is required';
    }

    if (empty($_POST['phone'])) {
        $errors['phone'] = 'Phone number is required';
    } else {
        if (!preg_match('/^[0-9]{10}+$/', $_POST['phone'])) {
            $errors['phone'] = "Phone number should be 10 digits and contain only numbers";
        }
    }
    if (empty($_POST['address'])) {
        $errors['address'] = 'Address field is required';
    }


    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $gender = $_POST['gender'];
    $password=$_POST['password'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];


    $oldvalue['fname'] = $fname;
    $oldvalue['lname'] = $lname;
    $oldvalue['email'] = $email;
    $oldvalue['phone'] = $phone;
    $oldvalue['address'] = $address;
    $oldvalue['gender'] = $gender;

    if (!array_filter($errors)) {

        $query = "SELECT email FROM tbl_customer WHERE email='$email'";
        $res = mysqli_query($conn, $query);

        if (mysqli_num_rows($res) > 0) {
            echo "<script>
            alert('Email Already Exist !!!!!')
            window.location='add_customer.php';
            </script>";
        } else {
            $sql = "INSERT INTO tbl_customer (first_name,last_name,email,password,gender,phone,address) VALUES('$fname','$lname','$email','$password','$gender','$phone','$address')";

            $result = mysqli_query($conn, $sql);
            if ($result) {
                echo "<script>
                alert('Data inserted successfully')
                window.location='view_customer.php';
                </script>";
            }
        }
    }
}
?>





<!-- Page wrapper  -->
<div class="page-wrapper">
    <!-- Bread crumb -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-primary heading">Customer Details</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Customer Management</li>
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
                                            <input type="text" name="fname" value="<?= $oldvalue['fname'] ?>" class="form-control" placeholder="First Name">
                                            <span class="help-block"><?= $errors['fname'] ?></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-sm-3 control-label">Last Name</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="lname" value="<?= $oldvalue['lname'] ?>" id="lname" class="form-control" placeholder="Last Name">
                                            <span class="help-block"><?= $errors['lname'] ?></span>

                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-sm-3 control-label">Email</label>
                                        <div class="col-sm-9">
                                            <input type="email" name="email" value="<?= $oldvalue['email'] ?>" id="email" class="form-control" placeholder="Email">
                                            <span class="help-block"><?= $errors['email'] ?></span>

                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-sm-3 control-label">Password</label>
                                        <div class="col-sm-9">
                                            <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                                            <span class="help-block"><?= $errors['password'] ?></span>

                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-sm-3 control-label">Gender</label>
                                        <div class="col-sm-9">
                                            <select name="gender" id="gender" class="form-control">
                                                <option value="">--Select Gender--</option>
                                                <option value="Male" <?= $oldvalue['gender'] == 'Male' ? 'selected' : ''; ?>>Male</option>
                                                <option value="Female" <?= $oldvalue['gender'] == 'Female' ? 'selected' : ''; ?>>Female</option>
                                            </select>
                                            <span class="help-block"><?= $errors['gender'] ?></span>
                                        </div>
                                    </div>

                                </div>


                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-sm-3 control-label">Phone no.</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="phone" value="<?= $oldvalue['phone'] ?>" class="form-control" placeholder="Phone Number">
                                            <span class="help-block"><?= $errors['phone'] ?></span>

                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-sm-3 control-label">Address</label>
                                        <div class="col-sm-9">
                                            <input type="text" value="<?= $oldvalue['address'] ?>" class="form-control" name="address" placeholder="Address"></input>
                                            <span class="help-block"><?= $errors['address'] ?></span>

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

        <?php include('includes/footer.php'); ?>