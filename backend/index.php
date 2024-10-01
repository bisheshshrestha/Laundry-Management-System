<?php
ob_start();
include('includes/head.php');
include('includes/header.php');
include('includes/connect.php');
include('includes/sidebar.php');
//echo  $_SESSION["email"];
date_default_timezone_set('Asia/Kathmandu');
$current_date = date('Y-m-d');

if(empty($_SESSION['username'])){
    header('Location:login.php');
    exit();
}

$sql = "SELECT  o.order_id, c.first_name AS customer_name, i.item_name AS laundry_type, o.quantity, o.price, o.order_date, o.pickup_date, o.delivery_date, o.location, o.status
FROM tbl_orders o
JOIN tbl_customer c ON o.customer_id = c.customer_id
JOIN tbl_items i ON o.laundry_type = i.item_id";
$result = mysqli_query($conn, $sql);



?>
<!-- Page wrapper  -->
<div class="page-wrapper">
    <?php include 'social_link.php'; ?>
    <!-- Bread crumb -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-primary heading">Owner Dashboard</h3>

        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <marquee scrollamount=4><b>Welcome to our Laundry Management System. Feel free to order</b></marquee>
            </ol>
        </div>
    </div>
    <!-- End Bread crumb -->
    <!-- Container fluid  -->
    <div class="container-fluid">
        <!-- Start Page Content -->


        <div class="row">
            <div class="col-md-4">
                <div class="card bg-primary left p-20">
                    <div class="media widget-ten">
                        <div class="media-left meida media-middle">
                            <span><i class="ti-bag f-s-40"></i></span>
                        </div>
                        <div class="media-body media-text-right">
                            <?php

                            $sql = "select * from `tbl_orders` where `order_date`= '" . date('Y-m-d') . "' GROUP BY created_time";
                            $res = $conn->query($sql);
                            $num_rows = mysqli_num_rows($res);
                            ?>

                            <h2 class="color-white">
                                <?php

                                echo $num_rows
                                ?>

                            </h2>
                            <p class="m-b-0">New orders</p>
                        </div>
                    </div>
                </div>
            </div>





            <div class="col-md-4">
                <div class="card bg-pink middle p-20 ">
                    <div class="media widget-ten">
                        <div class="media-left meida media-middle">
                            <span><i class="ti-comment f-s-40"></i></span>
                        </div>
                        <div class="media-body media-text-right">

                            <?php
                            $sql = "select * from `tbl_orders` where `status`='Pending' GROUP BY created_time";
                            $res = $conn->query($sql);
                            $num_rows = mysqli_num_rows($res);
                            ?>


                            <h2 class="color-white">
                                <?php

                                echo $num_rows

                                ?>

                            </h2>
                            <p class="m-b-0">Inprogress</p>
                        </div>
                    </div>
                </div>
            </div>






            <div class="col-md-4">
                <div class="card bg-danger right p-20">
                    <div class="media widget-ten">
                        <div class="media-left meida media-middle">
                            <span><i class="ti-vector f-s-40"></i></span>
                        </div>
                        <div class="media-body media-text-right">
                            <?php
                            $sql = "select * from `tbl_orders` WHERE `status`='Delivered' GROUP BY created_time";
                            $res = $conn->query($sql);
                            $num_rows = mysqli_num_rows($res);
                            ?>


                            <h2 class="color-white">
                                <?php

                                echo $num_rows

                                ?>



                            </h2>
                            <p class="m-b-0">Completed</p>
                        </div>
                    </div>
                </div>
            </div>


        </div>

    </div>
    <div class="card">
        <div class="card-body">
            <div class="col-md-5 align-self-center">
                <h3 class="text-primary heading">Orders Status</h3>
            </div>
            <div class="table-responsive m-t-40">
                <table id="myTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>Customer Name</th>
                            <th>Item Type</th>
                            <th>Price</th>
                            <th>Pickup date</th>
                            <th>Delivery Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($result as $key=> $orderData) { ?>
                        <tr>
                            <td><?=++$key?></td>
                            <td><?=$orderData['customer_name']?></td>
                            <td><?=$orderData['laundry_type']?></td>
                            <td><?=$orderData['price']?></td>
                            <td><?=$orderData['pickup_date']?></td>
                            <td><?=$orderData['delivery_date']?></td>
                            <td>pending</td>
                        </tr>
                            <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- End Container fluid  -->
    <?php include('includes/footer.php'); ?>