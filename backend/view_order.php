<?php

include('includes/head.php');
include('includes/header.php');
include('includes/sidebar.php');
include 'includes/connect.php';

$sql = "SELECT  o.order_id, c.customer_id, c.first_name AS customer_name, i.item_name AS laundry_type, o.quantity, o.price, o.order_date,o.created_time, o.pickup_date, o.delivery_date, o.location, o.status
FROM tbl_orders o
JOIN tbl_customer c ON o.customer_id = c.customer_id
JOIN tbl_items i ON o.laundry_type = i.item_id
GROUP BY o.created_time";
$result = mysqli_query($conn, $sql);
$orderData = mysqli_fetch_assoc($result);

?>



<!-- Page wrapper  -->
<div class="page-wrapper">
    <!-- Bread crumb -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-primary heading"> View order</h3>
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
                <?php if (isset($_SESSION['accept'])) {
                    echo '<p>' . $_SESSION['accept'] . '</p>';
                    unset($_SESSION['accept']);
                }
                ?>
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
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($result as $key => $orderData) { ?>
                                <tr>
                                    <td><?= ++$key ?></td>
                                    <td><?= $orderData['customer_name'] ?></td>
                                    <td><?= $orderData['laundry_type'] ?></td>
                                    <td><?= $orderData['quantity'] ?></td>
                                    <td><?= $orderData['price'] ?></td>
                                    <td><?= $orderData['order_date'] ?></td>
                                    <td><?= $orderData['pickup_date'] ?></td>
                                    <td><?= $orderData['delivery_date'] ?></td>
                                    <td><?= $orderData['location'] ?></td>
                                    <td><?= $orderData['status'] ?></td>
                                    
                                    <td style="width: 15px;">
                                        <div class="btn-group" role="group">
                                            <a href="view_allorder.php?id=<?= $orderData['customer_id'] ?>&created_time=<?= $orderData['created_time'] ?>"><button type="button" class="btn btn-xs btn-primary mr-2"><i class="fa fa-eye"></i></button></a>
                                            <?php if ($orderData['status'] == 'Accepted') { ?>
                                                <a onclick="return confirm('Are you sure you want to Deliver?');" href="order_deliver.php?id=<?= $orderData['customer_id'] ?>&created_time=<?= $orderData['created_time'] ?>">
                                                    <button type="button" class="btn btn-xs btn-primary mr-2"><i class="fa fa-pencil"></i>Deliver</button>
                                                </a>
                                            <?php } ?>
                                            <?php if ($orderData['status'] == 'Pending') { ?>
                                                <a onclick="return confirm('Are you sure you want to Accept?');" href="order_accept.php?id=<?= $orderData['customer_id'] ?>&created_time=<?= $orderData['created_time'] ?>">
                                                    <button type="button" class="btn btn-xs btn-primary mr-2"><i class="fa fa-pencil"></i>Accept</button>
                                                </a>
                                            <?php } ?>
                                            <a onclick="return confirm('Are you sure you want to Delete?');" href="order_delete.php?id=<?= $orderData['customer_id'] ?>&created_time=<?= $orderData['created_time'] ?>"><button type="button" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></button></a>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <?php include('includes/footer.php'); ?>

