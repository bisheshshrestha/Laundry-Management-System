<?php
session_start();
include 'assets/header.php';
include 'assets/session.php';
include 'connect.php';

$cid = $_SESSION['cid'];
$createdTime = $_GET['created_time'];

$sql = "SELECT o.order_id, i.item_name, o.quantity, i.price, o.delivery_date, o.status, o.created_time
        FROM tbl_orders o
        JOIN tbl_items i ON o.laundry_type = i.item_id
        WHERE o.customer_id = $cid AND o.created_time = '$createdTime'
        ORDER BY o.created_time DESC";
$res = mysqli_query($conn, $sql);
$sqlData=mysqli_fetch_assoc($res);

$customerName = "";
$customerEmail = "";
$customerPhone = "";

$sql1 = "SELECT * FROM tbl_customer WHERE customer_id = $cid";
$res1 = mysqli_query($conn, $sql1);
if ($res1 && mysqli_num_rows($res1) > 0) {
    $customerData = mysqli_fetch_assoc($res1);
    $customerName = $customerData['first_name'] . ' ' . $customerData['last_name'];
    $customerEmail = $customerData['email'];
    $customerPhone = $customerData['phone'];
}
?>

<div class="container" style="margin-top: 150px;">
    <h3>Order Summary</h3>

    <h4>Customer Information</h4>
    <p><strong>Name:</strong> <?= $customerName; ?></p>
    <p><strong>Email:</strong> <?= $customerEmail; ?></p>
    <p><strong>Phone:</strong> <?= $customerPhone; ?></p>
    <p><strong>Status:</strong> <?= $sqlData['status']; ?></p>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th scope="col">S.no</th>
                <th scope="col">Laundry Type</th>
                <th scope="col">Quantity</th>
                <th scope="col">Price</th>
                <th scope="col">Total</th> <!-- New column for Total -->
                <th scope="col">Delivery Date</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $totalAmount = 0;
            $orderId = 1;
            foreach ($res as $row) {
                $price = $row['price'];
                $subTotal = $price * $row['quantity']; // Calculate subtotal for each item
                $totalAmount += $subTotal; // Add to the overall total
            ?>
                <tr>
                    <td><?= $orderId; ?></td>
                    <td><?= $row['item_name']; ?></td>
                    <td><?= $row['quantity']; ?></td>
                    <td>Rs.<?= $price; ?></td>
                    <td>Rs.<?= $subTotal; ?></td> <!-- Display subtotal for the item -->
                    <td><?= $row['delivery_date']; ?></td>
                </tr>
            <?php $orderId++;
            } ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4" class="text-end"><strong>Delivery Charge:</strong></td>
                <td>Rs.100</td>
            </tr>
            <tr>
                <td colspan="4" class="text-end"><strong>Total Amount:</strong></td>
                <td>Rs.<?= $totalAmount + 100; ?></td>
            </tr>
        </tfoot>
    </table>
</div>

<?php include 'assets/footer.php'; ?>
