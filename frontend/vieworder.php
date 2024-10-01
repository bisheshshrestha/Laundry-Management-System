<?php
session_start();
include 'assets/header.php';
include 'assets/session.php';
include 'connect.php';

$cid = $_SESSION['cid'];

$sql = "SELECT  o.order_id, c.customer_id, c.first_name AS customer_name, i.item_name AS laundry_type, o.quantity, o.order_date, o.created_time,o.pickup_date, o.delivery_date, o.location, o.status
FROM tbl_orders o
JOIN tbl_customer c ON o.customer_id = c.customer_id
JOIN tbl_items i ON o.laundry_type = i.item_id
WHERE c.customer_id = $cid
GROUP BY o.created_time
ORDER BY o.created_time DESC";
$result = mysqli_query($conn, $sql);

?>

<!-- Page wrapper  -->
<div class="banner">
<section id="vieworder">
    <!-- Container fluid  -->
    <div class="container">
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
                                    <td><?= $orderData['order_date'] ?></td>
                                    <td><?= $orderData['pickup_date'] ?></td>
                                    <td><?= $orderData['delivery_date'] ?></td>
                                    <td><?= $orderData['location'] ?></td>
                                    <td><?= $orderData['status'] ?></td>
                                    <td>
                                        <a href="viewallorders.php?created_time=<?= $orderData['created_time'] ?>"><button type="button" class="btn btn-xs btn-primary"><i class="fa fa-eye"></i></button></a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>  
</div>

<?php include 'assets/footer.php' ?>
