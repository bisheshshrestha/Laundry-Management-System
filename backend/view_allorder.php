<?php include('includes/head.php'); ?>
<?php include('includes/header.php'); ?>
<?php include('includes/sidebar.php');
include 'includes/connect.php';

$id=$_GET['id'];
$createdTime = $_GET['created_time'];
$sql = "SELECT  o.order_id, c.first_name AS customer_name, i.item_name AS laundry_type, o.quantity, o.price, o.order_date, o.pickup_date, o.delivery_date, o.location, o.status
FROM tbl_orders o
JOIN tbl_customer c ON o.customer_id = c.customer_id
JOIN tbl_items i ON o.laundry_type = i.item_id
WHERE c.customer_id=$id AND created_time='$createdTime'";
$result = mysqli_query($conn, $sql);
$orderData=mysqli_fetch_assoc($result);

?>



<!-- Page wrapper  -->
<div class="page-wrapper">
    <!-- Bread crumb -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-primary"> View order</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">View order</li>
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

                <div class="table-responsive m-t-40">
                    <table id="myTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>Customer Name</th>
                                <th>Laundry name</th>
                                <th>Quantity</th>
                                <!-- <th>Description</th> -->
                                <th>Price</th>
                                <th>Order Date</th>
                                <th>Pickup Date</th>
                                <th>Delivery date</th>
                                <th>Address</th>
                                <th>Status</th>
                               
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($result as $key=> $orderData){ ?>
                            <tr>
                                <td><?=++$key?></td>
                                <td><?=$orderData['customer_name']?></td>
                                <td><?=$orderData['laundry_type']?></td>
                                <td><?=$orderData['quantity']?></td>
                                <td><?=$orderData['price']?></td>
                                <td><?=$orderData['order_date']?></td>
                                <td><?=$orderData['pickup_date']?></td>
                                <td><?=$orderData['delivery_date']?></td>
                                <td><?=$orderData['location']?></td>
                                <td><?=$orderData['status']?></td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <?php include('includes/footer.php'); ?>


        <link rel="stylesheet" href="popup_style.css">
        <?php if (!empty($_SESSION['success'])) {  ?>
            <div class="popup popup--icon -success js_success-popup popup--visible">
                <div class="popup__background"></div>
                <div class="popup__content">
                    <h3 class="popup__content__title">
                        Success
                        </h1>
                        <p><?php echo $_SESSION['success']; ?></p>
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
                        <p><?php echo $_SESSION['error']; ?></p>
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