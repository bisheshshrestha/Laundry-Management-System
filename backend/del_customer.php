<?php
include 'includes/connect.php';
session_start();

$id=$_GET['id'];
$sql = "DELETE FROM tbl_customer WHERE customer_id=$id";
$res = mysqli_query($conn,$sql);
 $_SESSION['success']=' Record Successfully Deleted';
?>
<script>
//alert("Delete Successfully");
window.location = "view_customer.php";
</script>

