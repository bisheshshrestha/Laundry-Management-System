<?php include('includes/head.php'); ?>
<?php include('includes/header.php'); ?>
<?php include('includes/sidebar.php');

if (isset($_GET['id'])) { ?>
  <div class="popup popup--icon -question js_question-popup popup--visible">
    <div class="popup__background"></div>
    <div class="popup__content">
      <h3 class="popup__content__title">
        Sure
        </h1>
        <p>Are You Sure To Delete This Record?</p>
        <p>
          <a href="del_customer.php?id=<?= $_GET['id']; ?>" class="button button--success" data-for="js_success-popup">Yes</a>
          <a href="view_customer.php" class="button button--error" data-for="js_success-popup">No</a>
        </p>
    </div>
  </div>
<?php } ?>



<!-- Page wrapper  -->
<div class="page-wrapper">
  <!-- Bread crumb -->
  <div class="row page-titles">
    <div class="col-md-5 align-self-center">
      <h3 class="text-primary heading"> View Customer</h3>
    </div>
    <div class="col-md-7 align-self-center">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
        <li class="breadcrumb-item active">View Customer</li>
      </ol>
    </div>
  </div>
  <!-- End Bread crumb -->
  <!-- Container fluid  -->
  <div class="container-fluid">
    <!-- Start Page Content -->

    <!-- /# row -->
    <div class="card">
      <div class="card-body">

            <a href="add_customer.php"><button class="btn btn-primary">Add Customer</button></a>

        <div class="table-responsive m-t-40">
          <table id="myTable" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>id</th>
                <th>First Name</th>
                <th>Last Name</th>
                 <th>Email</th>
                <th>Gender</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Action</th>

              </tr>
            </thead>
            <tbody>
              <?php
              include 'includes/connect.php';
              $sql = "SELECT * FROM tbl_customer";
              $result = $conn->query($sql);

              while ($row = $result->fetch_assoc()) {
              ?>
                <tr>
                  <td><?= $row['customer_id']; ?></td>
                  <td><?= $row['first_name']; ?></td>
                  <td><?= $row['last_name']; ?></td>
                  <td><?= $row['email']; ?></td>
                  <td><?= $row['gender']; ?></td>
                  <td><?= $row['phone']; ?></td>

                  <td><?= $row['address']; ?></td>

                  <td>
                        <a href="edit_customer.php?id=<?= $row['customer_id']; ?>"><button type="button" class="btn btn-xs btn-primary"><i class="fa fa-pencil"></i></button></a>

                        <a href="view_customer.php?id=<?= $row['customer_id']; ?>"><button type="button" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></button></a>
                  </td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- /# row -->

    <!-- End PAge Content -->


    <?php include('includes/footer.php'); ?>


    <link rel="stylesheet" href="popup_style.css">
    <?php if (!empty($_SESSION['success'])) {  ?>
      <div class="popup popup--icon -success js_success-popup popup--visible">
        <div class="popup__background"></div>
        <div class="popup__content">
          <h3 class="popup__content__title">
            Success
            </h1>
            <p><?= $_SESSION['success']; ?></p>
            <p>
              <button class="button button--success" data-for="js_success-popup">Close</button>
            </p>
        </div>
      </div>
    <?php unset($_SESSION["success"]);
    } ?>
    <?php if (!empty($_SESSION['error'])) {  ?>
      <div class="popup popup--icon -error js_error-popup popup--visible">
        <div class="popup__background"></div>
        <div class="popup__content">
          <h3 class="popup__content__title">
            Error
            </h1>
            <p><?= $_SESSION['error']; ?></p>
            <p>
              <button class="button button--error" data-for="js_error-popup">Close</button>
            </p>
        </div>
      </div>
    <?php unset($_SESSION["error"]);
    } ?>
    <script>
      var addButtonTrigger = function addButtonTrigger(el) {
        el.addEventListener('click', function() {
          var popupEl = document.querySelector('.' + el.dataset.for);
          popupEl.classList.toggle('popup--visible');
        });
      };

      Array.from(document.querySelectorAll('button[data-for]')).
      forEach(addButtonTrigger);
    </script>