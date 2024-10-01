<?php
ob_start();

include('includes/connect.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\MyException;

$id = $_GET['id'];
$createdTime = $_GET['created_time'];


$sql1 = "SELECT  c.first_name AS customer_name, c.email
FROM tbl_orders o
JOIN tbl_customer c ON o.customer_id = c.customer_id
WHERE c.customer_id=$id AND o.created_time='$createdTime'";
$result1 = mysqli_query($conn, $sql1);
$orderData = mysqli_fetch_assoc($result1);



$sql = "UPDATE tbl_orders SET status='Accepted' WHERE customer_id=$id AND created_time='$createdTime' ";
$res = mysqli_query($conn, $sql);

//Load Composer's autoloader
require '../PHPMailer/MyException.php';
require '../PHPMailer/SMTP.php';
require '../PHPMailer/PHPMailer.php';


if ($res) {
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
        $mail->addAddress($orderData['email'], $orderData['customer_name']);

        $mail->isHTML(true);
        $mail->Subject = 'Laundry Order Accepted';
        $mail->Body    = 'Your order has been accepted. Our pickup service will be available soon to pick up the laundry.';

        $mail->send();
        echo 'Message has been sent';
        $_SESSION['accept'] = ' Record Successfully Accepted';
        header('Location:view_order.php');
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
