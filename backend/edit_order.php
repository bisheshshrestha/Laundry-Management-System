<?php
ob_start();
include('includes/head.php');
include('includes/header.php');
include('includes/sidebar.php');
include('includes/connect.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\MyException;

//Load Composer's autoloader
require '../PHPMailer/MyException.php';
require '../PHPMailer/SMTP.php';
require '../PHPMailer/PHPMailer.php';



date_default_timezone_set('Asia/Kathmandu');
$current_date = date('Y-m-d');

$id = $_GET['id'];
$createdTime = $_GET['created_time'];

$sql = "SELECT  o.order_id,o.created_time, c.first_name AS customer_name, c.email, i.item_name AS laundry_type, o.quantity, o.price, o.order_date, o.pickup_date, o.delivery_date, o.location, o.status
FROM tbl_orders o
JOIN tbl_customer c ON o.customer_id = c.customer_id
JOIN tbl_items i ON o.laundry_type = i.item_id
WHERE c.customer_id=$id AND o.created_time='$createdTime'";


$result = mysqli_query($conn, $sql);
$orderData = mysqli_fetch_all($result, MYSQLI_ASSOC);

if (!empty($_POST)) {
  $laundryTypes = $_POST['laundry'];
  $quantities = $_POST['quantity'];
  $pdate = $_POST['pod'];
  $ddate = $_POST['dod'];
  $status = $_POST['status'];


  foreach ($orderData as $index => $order) {
    $orderId = $order['order_id'];
    $laundry = $laundryTypes[$index];
    $quantity = $quantities[$index];

    $sql = "UPDATE tbl_orders SET laundry_type='$laundry', quantity='$quantity', status='$status' WHERE order_id=$orderId";
    $res = mysqli_query($conn, $sql);


    if ($res) {

      // Send email notification based on the selected status
      if ($status === 'Accepted') {
        try {
          $mail = new PHPMailer();
          $mail->isSMTP();
          $mail->Host       = 'smtp.gmail.com';
          $mail->SMTPAuth   = true;
          $mail->Username   = 'bisheshshrestha652@gmail.com';
          $mail->Password   = 'jgskhvceozjmhhci';
          $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
          $mail->Port       = 465;

          $mail->setFrom('bisheshshrestha652@gmail.com', 'Laundry Management System');
          $mail->addAddress($order['email'], $order['customer_name']);

          $mail->isHTML(true);
          $mail->Subject = 'Laundry Order Accepted';
          $mail->Body    = 'Your order has been accepted. Our pickup service will be available soon to pick up the laundry.';

          $mail->send();
          echo 'Message has been sent';
          header('Location:view_order.php');
        } catch (Exception $e) {
          echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
      } elseif ($status === 'Delivered') {
        try {
          $mail = new PHPMailer();
          $mail->isSMTP();
          $mail->Host       = 'smtp.gmail.com';
          $mail->SMTPAuth   = true;
          $mail->Username   = 'bisheshshrestha652@gmail.com';
          $mail->Password   = 'jgskhvceozjmhhci';
          $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
          $mail->Port       = 465;

          $mail->setFrom('bisheshshrestha652@gmail.com', 'Laundry Management System');
          $mail->addAddress($order['email'], $order['customer_name']);

          $mail->isHTML(true);
          $mail->Subject = 'Laundry Order Delivered';
          $mail->Body    = 'Your order has been delivered. We hope you are satisfied with our service.';

          $mail->send();
          echo 'Message has been sent';
          header('Location:view_order.php');
        } catch (Exception $e) {
          echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
      }
    } else {
      echo "Error updating order with ID: $orderId";
      exit;
    }
  }

  header('Location:view_order.php');
  exit;
}
?>

<!-- Page wrapper  -->
<div class="page-wrapper">
  <!-- Bread crumb -->
  <div class="row page-titles">
    <div class="col-md-5 align-self-center">
      <h3 class="text-primary">Order Management</h3>
    </div>
    <div class="col-md-7 align-self-center">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
        <li class="breadcrumb-item active">Add Order Management</li>
      </ol>
    </div>
  </div>
  <!-- End Bread crumb -->
  <!-- Container fluid  -->
  <div class="container-fluid">
    <!-- Start Page Content -->
    <div class="row">
      <div class="col-lg-8" style="margin-left: 10%;">
        <div class="card">
          <div class="card-title"></div>
          <div class="card-body">
            <div class="input-states">
              <form class="form-horizontal" method="POST" enctype="multipart/form-data" name="userform">

                <input type="hidden" name="currnt_date" class="form-control" value="<?= $current_date; ?>">

                <div class="form-group">
                  <div class="row">
                    <label class="col-sm-3 control-label">Customer Name</label>
                    <div class="col-sm-9">
                      <input type="text" name="name" class="form-control" value="<?= $orderData[0]['customer_name']; ?>" readonly>
                    </div>
                  </div>
                </div>

                <?php foreach ($orderData as $index => $order) { ?>
                  <div class="form-group">
                    <div class="row">
                      <label class="col-sm-3 control-label">Laundry Type</label>
                      <div class="col-sm-9">
                        <select name="laundry[]" id="event" class="form-control" required="">
                          <?php
                          $laundryQuery = "SELECT * FROM tbl_items";
                          $laundryResult = mysqli_query($conn, $laundryQuery);

                          while ($laundry = mysqli_fetch_assoc($laundryResult)) {
                            $selected = ($laundry['item_name'] == $order['laundry_type']) ? 'selected' : '';
                            echo '<option value="' . $laundry['item_id'] . '" ' . $selected . '>' . $laundry['item_name'] . '</option>';
                          }
                          ?>
                        </select>
                      </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="row">
                      <label class="col-sm-3 control-label">Quantity</label>
                      <div class="col-sm-9">
                        <input type="number" name="quantity[]" class="form-control" id="quantity" value="<?= $order['quantity']; ?>">
                      </div>
                    </div>
                  </div>
                <?php } ?>

                <div class="form-group">
                  <div class="row">
                    <label class="col-sm-3 control-label">Order Date</label>
                    <div class="col-sm-9">
                      <input type="date" name="ood" class="form-control" value="<?= $orderData[0]['order_date']; ?>" readonly>
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <div class="row">
                    <label class="col-sm-3 control-label">Pickup Date</label>
                    <div class="col-sm-9">
                      <input type="date" name="pod" class="form-control" value="<?= $orderData[0]['pickup_date']; ?>" min="<?= $current_date ?>">
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <div class="row">
                    <label class="col-sm-3 control-label">Delivery Date</label>
                    <div class="col-sm-9">
                      <input type="date" name="dod" class="form-control" placeholder="Delivery Date" value="<?= $orderData[0]['delivery_date']; ?>">
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <div class="row">
                    <label class="col-sm-3 control-label">Location</label>
                    <div class="col-sm-9">
                      <input type="text" name="address" class="form-control" value="<?= $orderData[0]['location']; ?>">
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <div class="row">
                    <label class="col-sm-3 control-label">Status</label>
                    <div class="col-sm-9">
                      <select name="status" id="event" class="form-control">
                        <?php
                        $status = $orderData[0]['status']; // Retrieve the status value from the database

                        // Check the status value and set the selected option accordingly
                        echo '<option value="Accepted" ' . ($status == 'Accepted' ? 'selected' : '') . '>Accepted</option>';
                        echo '<option value="Pending" ' . ($status == 'Pending' ? 'selected' : '') . '>Pending</option>';
                        echo '<option value="Delivered" ' . ($status == 'Delivered' ? 'selected' : '') . '>Delivered</option>';
                        ?>
                      </select>
                    </div>
                  </div>
                </div>

                <button type="submit" name="btn_update" class="btn btn-primary btn-flat m-b-30 m-t-30">Submit</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- End Page Content -->
  </div>

  <?php include('includes/footer.php'); ?>
</div>