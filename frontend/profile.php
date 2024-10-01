<?php

session_start();
include 'assets/header.php';
include 'assets/session.php';
include 'connect.php';

$cid = $_SESSION['cid'];

$sql = "SELECT * FROM tbl_customer WHERE customer_id = '$cid'";
$result = mysqli_query($conn, $sql);



?>

<main id="main" class="main">

  <section class="section profile" id="profile">
    <div class="row">

      <div class="col-xl-8">

        <div class="card">
          <div class="card-body pt-3">
            <!-- Bordered Tabs -->
            <ul class="nav nav-tabs nav-tabs-bordered">

              <li class="nav-item">
                <a href="profile.php" class="nav-link active">Overview</a>
              </li>

              <li class="nav-item">
                <a href="editprofile.php" class="nav-link">Edit Profile</a>
              </li>
            </ul>
            <div class="tab-content pt-2">

              <div class="tab-pane fade show active profile-overview" id="profile-overview">

                <h5 class="card-title mb-3">Profile Details</h5>

                <?php if ($customer = mysqli_fetch_assoc($result)) {
                ?>

                  <div class="row mb-2 mb-2">
                    <div class="col-lg-3 col-md-4 label ">First Name</div>
                    <div class="col-lg-9 col-md-8"><?= $customer['first_name'] ?></div>
                  </div>

                  <div class="row mb-2">
                    <div class="col-lg-3 col-md-4 label ">Last Name</div>
                    <div class="col-lg-9 col-md-8"><?= $customer['last_name'] ?></div>
                  </div>

                  <div class="row mb-2">
                    <div class="col-lg-3 col-md-4 label">Gender</div>
                    <div class="col-lg-9 col-md-8"><?= $customer['gender']; ?></div>
                  </div>

                  <div class="row mb-2">
                    <div class="col-lg-3 col-md-4 label">Address</div>
                    <div class="col-lg-9 col-md-8"><?= $customer['address']; ?></div>
                  </div>

                  <div class="row mb-2">
                    <div class="col-lg-3 col-md-4 label">Phone</div>
                    <div class="col-lg-9 col-md-8"><?= $customer['phone']; ?></div>
                  </div>

                  <div class="row mb-2">
                    <div class="col-lg-3 col-md-4 label">Email</div>
                    <div class="col-lg-9 col-md-8"><?= $customer['email']; ?></div>
                  </div>

              </div>
            <?php } ?>

          </div>
        </div>

      </div>
    </div>
  </section>

</main><!-- End #main -->

<?php include 'assets/footer.php' ?>