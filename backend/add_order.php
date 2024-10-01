  <?php
  include('includes/head.php');
  include('includes/header.php');
  include('includes/sidebar.php');
  include('includes/connect.php');
  date_default_timezone_set('Asia/Kathmandu');
  $current_date = date('Y-m-d');

  if (!empty($_POST)) {

    $customer_id = $_POST['first_name'];
    $description = $_POST['description'];
    $pickup_date = $_POST['pod'];
    $delivery_date = $_POST['dod'];
    $todays_date = $_POST['todays_date'];
    $image = $_POST['itemtypeId'];



    // Prepare and execute the SQL query
    $query = "INSERT INTO tbl_orders (customer_id, description, pickup_date, delivery_date, todays_date) 
              VALUES ('$customer_id', '$description', '$pickup_date', '$delivery_date', '$todays_date')";
    $result = mysqli_query($conn, $query);

    if ($result) {


      // Order saved successfully
      echo "Order saved successfully.";
    } else {
      // Failed to save order
      echo "Failed to save order. Please try again.";
    }
  }



  //   
  ?>





  <!-- Page wrapper  -->
  <div class="page-wrapper">
    <!-- Bread crumb -->
    <div class="row page-titles">
      <div class="col-md-5 align-self-center">
        <h3 class="text-primary">Order Details</h3>
      </div>
      <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
          <li class="breadcrumb-item active">order Management</li>
        </ol>
      </div>
    </div>
    <!-- End Bread crumb -->
    <!-- Container fluid  -->
    <div class="container-fluid">
      <!-- Start Page Content -->

      <!-- /# row -->
      <div class="row">
        <div class="col-lg-8" style="    margin-left: 10%;">
          <div class="card">
            <div class="card-title">

            </div>
            <div class="card-body">
              <div class="input-states">
                <form class="form-horizontal" method="POST" action="" enctype="multipart/form-data">

                  <input type="hidden" name="currnt_date" class="form-control" value="<?php echo $currnt_date; ?>">

                  <div class="form-group">
                    <div class="row">
                      <label class="col-sm-3 control-label">Customer Name</label>
                      <div class="col-sm-9">
                        <select name="fname" id="event" class="form-control" required="">



                          <option value=" ">--Select customer--</option>
                          <?php
                          $sql2 = "SELECT * FROM tbl_customer where customer_id!=1";
                          $result2 = $conn->query($sql2);
                          while ($row2 = mysqli_fetch_array($result2)) {
                          ?>
                            <option value="<?php echo $row2['customer_id']; ?>"><?php echo $row2['first_name'] . ' ' . $row2['last_name']; ?> </option>
                          <?php
                          } ?>
                        </select>


                      </div>
                    </div>
                  </div>

                  <?php
                  $sql2 = "SELECT * FROM tbl_items";
                  $result2 = $conn->query($sql2);
                  while ($row2 = mysqli_fetch_array($result2)) {
                  ?>
                    <div class="form-group">
                      <div class="row">
                        <label class="col-sm-3 "><?= $row2['item_type'] ?></label>
                        <input type="hidden" name="itemtypeId[]" value="<?= $row2['item_id'] ?>">
                        <div class="col-sm-9">
                          <input type="number" name="<?= $row2['item_type'] ?>" class="form-control">
                        </div>
                      </div>
                    </div>
                  <?php
                  } ?>

                  <div class="form-group">
                    <div class="row">
                      <label class="col-sm-3 control-label">Description</label>
                      <div class="col-sm-9">
                        <textarea class="form-control" rows="4" name="description" placeholder="Description" style="height: 80px;"></textarea>
                      </div>
                    </div>
                  </div>


              </div>
            </div>


            <div class="form-group">
              <div class="row">
                <label class="col-sm-3 control-label">Pickup Date</label>
                <div class="col-sm-9">
                  <input type="date" name="pod" class="form-control" placeholder="Pickup Date" min="<?= $current_date ?>">
                </div>
              </div>
            </div>


            <div class="form-group">
              <div class="row">
                <label class="col-sm-3 control-label">Delivery Date</label>
                <div class="col-sm-9">
                  <input type="date" name="dod" class="form-control" placeholder="Delivery Date" min="<?= $current_date ?>">
                </div>
              </div>
            </div>


            <div class="form-group">
              <div class="row">
                <label class="col-sm-3 control-label">Todays Date</label>
                <div class="col-sm-9">
                  <input name="todays_date" class="form-control" value="<?php echo date('y/m/d'); ?>" readonly>
                </div>
              </div>
            </div>





            <button type="submit" name="btn_save" class="btn btn-primary btn-flat m-b-30 m-t-30">Submit</button>

          </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  </div>

  </div>




  <?php include('includes/footer.php'); ?>

  <!-- <script>
    function s() {
      var sname = $('#sname').val();
      var price = sname.split(',');
      $('#prizes').val(price[1]);
    }
  </script> -->