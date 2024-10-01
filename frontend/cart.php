<?php

session_start();

include 'assets/header.php';
include 'assets/session.php';
include 'connect.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
// Load Composer's autoloader
require '../PHPMailer/Exception.php';
require '../PHPMailer/SMTP.php';
require '../PHPMailer/PHPMailer.php';


date_default_timezone_set('Asia/Kathmandu');
$current_date = date('Y-m-d');

$cid = $_SESSION['cid'];
$sql1 = "SELECT * FROM tbl_customer WHERE customer_id=$cid";
$res1 = mysqli_query($conn, $sql1);
$customerData = mysqli_fetch_assoc($res1);

$delivery_charge = 100;

// Initialize the order details array in the session if it doesn't exist
if (!isset($_SESSION["shopping_cart"])) {
    $_SESSION["shopping_cart"] = array();
}

// Handle item removal
if (isset($_GET["action"]) && $_GET["action"] == "remove" && isset($_GET["item_id"])) {
    $item_id = $_GET["item_id"];

    // Check if the item exists in the shopping cart session
    if (isset($_SESSION["shopping_cart"][$item_id])) {
        // Remove the item from the shopping cart
        unset($_SESSION["shopping_cart"][$item_id]);
    }
}
if (empty($_SESSION["shopping_cart"])) {
    echo "<script>alert('Your cart is empty. Add items to your cart before placing an order.');</script>";
    header("location:placeorder.php");
    exit();
}

// Loop through the laundry types in the shopping cart
foreach ($_SESSION["shopping_cart"] as $key => $values) {
    $laundryid = $values["item_id"];
    $laundryType = $values["item_name"];
    $quantity = $values["item_quantity"];
    $price = $values["item_price"] * $quantity;
}
$errors = [
    'email' => '',
    'address' => '',
    'phone' => '',
    'pickup_date' => '',
    'delivery_date' => ''
];
$oldvalue = [
    'email' => '',
    'address' => '',
    'phone' => '',
    'pickup_date' => '',
    'delivery_date' => ''
];

if (!empty($_POST)) {

    if (empty($_POST['email'])) {
        $errors['email'] = 'Email is required';
    }

    if (empty($_POST['address'])) {
        $errors['address'] = 'Address is required';
    }

    if (empty($_POST['phone'])) {
        $errors['phone'] = 'Phone is required';
    }

    if (empty($_POST['pickup_date'])) {
        $errors['pickup_date'] = 'Pickup date is required';
    }
    if (empty($_POST['delivery_date'])) {
        $errors['delivery_date'] = 'Delivery date is required';
    }

    $createdtime = date('Y-m-d H:i:s');
    $email = $_POST['email'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $pickup_date = $_POST["pickup_date"];
    $ddate = $_POST['delivery_date'];



    $oldvalue['email'] = $email;
    $oldvalue['phone'] = $phone;
    $oldvalue['address'] = $address;
    $oldvalue['pickup_date'] = $pickup_date;
    $oldvalue['delivery_date'] = $delivery_date;



    if (!array_filter($errors)) {

        // Insert each laundry type into the database
        $query = "INSERT INTO tbl_orders(customer_id, laundry_type, quantity, price, order_date, created_time, pickup_date, delivery_date, location, status)
                  VALUES('$cid', '$laundryid', '$quantity', '$price', '$current_date', '$createdtime', '$pickup_date', '$ddate', '$address', 'Pending')";
        $result = mysqli_query($conn, $query);

        if ($result) {
            try {

                // Create an instance; passing `true` enables exceptions
                $mail = new PHPMailer(true);

                // Server settings
                $mail->isSMTP(); // Send using SMTP
                $mail->Host = 'smtp.gmail.com'; // Set the SMTP server to send through
                $mail->SMTPAuth = true; // Enable SMTP authentication
                $mail->Username = 'bisheshshrestha652@gmail.com'; // SMTP username
                $mail->Password = 'jgskhvceozjmhhci'; // SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Enable implicit TLS encryption
                $mail->Port = 465; // TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                // Recipients
                $mail->setFrom('bisheshshrestha652@gmail.com', 'Laundry Management System');
                $mail->addAddress($email, $customerData['first_name'] . ' ' . $customerData['last_name']); // Add a recipient
                $mail->addReplyTo('bisheshshrestha652@gmail.com', 'Laundry Management System');

                // Content
                $mail->isHTML(true); // Set email format to HTML
                $mail->Subject = 'Laundry Order Confirmation';
                $mail->Body = 'Hello ' . $customerData['first_name'] . ' ' . $customerData['last_name'] . ',<br><br>';
                $mail->Body .= 'Thank you for placing your laundry order. Here are the details:<br><br>';
                $mail->Body .= 'Order Date: ' . $current_date . '<br>';
                $mail->Body .= 'Pickup Date: ' . $pickup_date . '<br>';
                $mail->Body .= 'Delivery Date: ' . $ddate . '<br>';
                $mail->Body .= 'Address: ' . $address . '<br><br>';
                $mail->Body .= 'Order Details:<br><br>';

                $mail->Body .= '<table style="width:100%; border-collapse: collapse;">';
                $mail->Body .= '<tr><th style="border: 1px solid black; padding: 5px;">Laundry Item</th><th style="border: 1px solid black; padding: 5px;">Quantity</th><th style="border: 1px solid black; padding: 5px;">Price</th></tr>';

                // Loop through the selected laundry items and add them to the email body
                foreach ($_SESSION["shopping_cart"] as $key => $values) {
                    $laundryid = $values["item_id"];
                    $laundryType = $values["item_name"];
                    $quantity = $values["item_quantity"];
                    $price = $values["item_price"];
                    $mail->Body .= '<tr><td style="border: 1px solid black; padding: 5px;">' . $laundryType . '</td><td style="border: 1px solid black; padding: 5px;">' . $quantity . '</td><td style="border: 1px solid black; padding: 5px;">' . $price . '</td></tr>';
                }

                // Calculate the total order amount and 100 delivery charge
                $total = 0;
                foreach ($_SESSION["shopping_cart"] as $key => $values) {
                    $total += ($values["item_quantity"] * $values["item_price"]);
                }
                $totalAmount = $total + $delivery_charge;

                $mail->Body .= '<tr><td colspan="2" style="border: 1px solid black; padding: 5px; text-align: right;"><strong>Sub Total</strong></td><td style="border: 1px solid black; padding: 5px;">' . $total . '</td></tr>';
                $mail->Body .= '<tr><td colspan="2" style="border: 1px solid black; padding: 5px; text-align: right;"><strong>Delivery Charge</strong></td><td style="border: 1px solid black; padding: 5px;">Rs 100</td></tr>';
                $mail->Body .= '<tr><td colspan="2" style="border: 1px solid black; padding: 5px; text-align: right;"><strong>Total Amount</strong></td><td style="border: 1px solid black; padding: 5px;">' . $totalAmount . '</td></tr>';
                $mail->Body .= '</table>';

                $mail->AltBody = 'Thank you for placing your laundry order.';

                $mail->send();

                // Clear the shopping cart after the order is placed
                $_SESSION["shopping_cart"] = array();

                $_SESSION['successmessage'] = "Order placed successfully. Please check your email for order details.";
                header("location:vieworder.php");
            } catch (Exception $e) {
                $_SESSION['error'] = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                header("location:vieworder.php");
            }
        } else {
            echo "Error: " . mysqli_error($conn) . "<br>";
        }
    }
}


?>
<section id="cart">
<!-- Page content here -->
<div class="container mt-100">
    <h3>Order Details</h3>
    <div class="table-responsive">
        <table class="table table-bordered">
            <tr>
                <th width="40%">Item Name</th>
                <th width="10%">Quantity</th>
                <th width="15%">Price</th>
                <th width="15%">Sub-Total</th>
                <th width="15%">Action</th> <!-- Added column for Remove action -->
            </tr>
            <?php
            $total = 0; // Initialize total amount

            // Check if there are items in the shopping cart session
            if (!empty($_SESSION["shopping_cart"])) {
                foreach ($_SESSION["shopping_cart"] as $key => $values) {
                    $itemName = $values["item_name"];
                    $itemPrice = $values["item_price"];
                    $itemQuantity = $values["item_quantity"];

                    // Calculate sub-total for each item
                    $subTotal = $itemQuantity * $itemPrice;
                    $total += $subTotal; // Add to the overall total

                    // Display the item details in the table, including sub-total
                    echo '<tr>
                            <td>' . $itemName . '</td>
                            <td>' . $itemQuantity . '</td>
                            <td>Rs. ' . $itemPrice . '</td>
                            <td>Rs. ' . number_format($subTotal, 2) . '</td>
                            <td><a href="cart.php?action=remove&item_id=' . $key . '">Remove</a></td>
                        </tr>';
                }
            } else {
                // Display a message if there are no order details
                echo '<tr><td colspan="5">No order details found.</td></tr>';
            }
            ?>
            <tr>
                <td colspan="3" align="right">Subtotal</td>
                <td align="right">Rs. <?= number_format($total, 2); ?></td>
                <td></td>
            </tr>
            <tr>
                <td colspan="3" align="right">Delivery Charge</td>
                <td align="right">Rs. <?= number_format($delivery_charge, 2); ?></td>
                <td></td> <!-- Empty column for alignment -->
            </tr>
            <tr>
                <td colspan="3" align="right">Total</td>
                <td align="right">Rs. <?= number_format($total + $delivery_charge, 2); ?></td>
                <td></td> <!-- Empty column for alignment -->
            </tr>
        </table>
    </div>
</div>

<div class="container">
    <h3>Customer Details</h3>
    <div class="row">
        <div class="col-md-6">
            <form method="post" action="">
                <div class="form-group">
                    <label for="full_name">Full Name:</label>
                    <input type="text" class="form-control" id="full_name" name="full_name" value="<?= $customerData['first_name']; ?> <?= $customerData['last_name']; ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?= $customerData['email']; ?>" readonly>
                    <span class="help-block"><?= $errors['email'] ?></span>

                </div>
                <div class="form-group">
                    <label for="address">Address:</label>
                    <input type="text" class="form-control" id="address" name="address" value="<?= $customerData['address']; ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="phone">Phone:</label>
                    <input type="text" class="form-control" id="phone" name="phone" value="<?= $customerData['phone']; ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="pickup_date">Pickup Date:</label>
                    <input type="date" class="form-control" id="pickup_date" name="pickup_date" onchange="setDeliveryDate()" min="<?= $current_date ?>">
                    <span class="help-block"><?= $errors['pickup_date'] ?></span>

                </div>
                <div class="form-group">
                    <label for="delivery_date">Expected Delivery Date:</label>
                    <input type="date" class="form-control" id="delivery_date" name="delivery_date" readonly>
                </div>
                <button type="submit" class="btn btn-primary mt-2">Submit Order</button>

                <div class="form-group">
                    <label for="delivery_date">Note:</label>
                    <p>Delivery is done Inside Valley Only and Delivery is done in 2 days from the order date</p>
                </div>
            </form>
        </div>
    </div>
</div>
</section>
<script>
    function setDeliveryDate() {
        var pickupDateElement = document.getElementById("pickup_date");
        var deliveryDateElement = document.getElementById("delivery_date");

        var pickupDate = new Date(pickupDateElement.value);
        var deliveryDate = new Date(pickupDate);
        deliveryDate.setDate(deliveryDate.getDate() + 2);

        var formattedDeliveryDate = deliveryDate.toISOString().slice(0, 10);

        deliveryDateElement.value = formattedDeliveryDate;
    }
</script>
<!-- Rest of your HTML code -->

<?php include 'assets/footer.php' ?>