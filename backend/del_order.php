<?php
include 'includes/connect.php';
session_start();

$id = $_GET['id'];
$createdTime = $_GET['created_time'];

$sql = "DELETE FROM `tbl_orders` WHERE customer_id=$id AND created_time='$createdTime'";
$res = $conn->query($sql) ;
 $_SESSION['success']=' Record Successfully Deleted';
?>
<script>
//alert("Delete Successfully");
window.location = "view_order.php";
</script>

