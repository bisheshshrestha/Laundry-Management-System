<?php
session_start();
include 'assets/header.php';
include 'assets/session.php';
include 'connect.php';

$cid = $_SESSION['cid'];

$sql = "SELECT * FROM tbl_customer WHERE customer_id = '$cid'";
$result = mysqli_query($conn, $sql);
$customerData = mysqli_fetch_assoc($result);


if (isset($_POST['updateCustomer'])) {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $gender = $_POST['gender'];

    $updateCustomerQuery = "UPDATE tbl_customer SET first_name='$fname', last_name='$lname', email='$email', phone='$phone', address='$address', gender='$gender' WHERE customer_id='$cid'";

    $updateResult = mysqli_query($conn, $updateCustomerQuery);

    if ($updateResult) {
        header('Location:profile.php');
    }
}

?>

<main id="main" class="main">


    <section class="section profile">
        <div class="row">

            <div class="col-xl-8">

                <div class="card">
                    <div class="card-body pt-3">
                        <!-- Bordered Tabs -->
                        <ul class="nav nav-tabs nav-tabs-bordered">

                            <li class="nav-item">
                                <a href="profile.php" class="nav-link">Overview</a>
                            </li>

                            <li class="nav-item">
                                <a href="edit_profile.php" class="nav-link active">Edit Profile</a>
                            </li>
                        </ul>
                        <div class="tab-content pt-2">
                            <form action="" method="post">
                                <div class="tab-pane fade show active profile-overview" id="profile-overview">
                                    <div class="row mb-3">
                                        <label for="fname" class="col-md-4 col-lg-3 col-form-label">First Name</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="fname" type="text" class="form-control" id="fname" value="<?= $customerData['first_name']; ?>">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="lname" class="col-md-4 col-lg-3 col-form-label">Last Name</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="lname" type="text" class="form-control" id="lname" value="<?= $customerData['last_name']; ?>">
                                        </div>
                                    </div>


                                    <div class="row mb-3">
                                        <label for="gender" class="col-md-4 col-lg-3 col-form-label">Gender</label>
                                        <div class="col-md-8 col-lg-9">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="gender" value="male" <?= $customerData['gender'] == 'Male' ? 'checked' : '' ?>>
                                                <label class="form-check-label">
                                                    Male
                                                </label>
                                            </div>
                                        </div>

                                        <label for="gender" class="col-md-4 col-lg-3 col-form-label"></label>
                                        <div class="col-md-8 col-lg-9">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="gender" value="female" <?= $customerData['gender'] == 'Female' ? 'checked' : '' ?>>
                                                <label class="form-check-label">
                                                    Female
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="address" class="col-md-4 col-lg-3 col-form-label">Address</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="address" type="text" class="form-control" id="address" value="<?= $customerData['address']; ?>">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="phone" class="col-md-4 col-lg-3 col-form-label">Phone</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="phone" type="text" class="form-control" id="phone" value="<?= $customerData['phone']; ?>">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="email" class="col-md-4 col-lg-3 col-form-label">Email</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="email" type="text" class="form-control" id="email" value="<?= $customerData['email']; ?>">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-sm-10">
                                            <button type="submit" class="btn btn-primary" name="updateCustomer">Update Profile</button>
                                        </div>
                                    </div>

                                </div><!-- End Bordered Tabs -->

                            </form>

                        </div>
                    </div>

                </div>
            </div>
    </section>

</main><!-- End #main -->

<?php include 'assets/footer.php' ?>