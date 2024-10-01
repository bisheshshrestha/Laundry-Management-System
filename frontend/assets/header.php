<?php
include 'connect.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laundry Management System</title>
    <link rel="icon" href="./images/icon1.png" type="image/icon type">
    <link rel="stylesheet" href="./fontawesome/css/all.min.css">
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css">
</head>

<body>

    <!-- =============== Header Section===================================-->
    <header>
        <a href="index.php"><img src="./images/washmandu.png" alt="Laundry"></a>


        <div class="menuToggle" onclick="toggleMenu();"></div>
        <!-- =============== Navbar Section===================================-->

        <nav class="navigation">

            <?php
             if (isset($_SESSION['email'])) {  
                ?>
                <li><a href="placeorder.php#placeorder" onclick="toggleMenu();">Place Order</a></li>
                <li><a href="cart.php#cart" onclick="toggleMenu();">My Cart</a></li>
                <li><a href="vieworder.php#vieworder" onclick="toggleMenu();">View Order</a></li>
                <li><a href="profile.php#profile" onclick="toggleMenu();">Profile</a></li>
                <li><a href="logout.php" onclick="toggleMenu();">Logout</a></li>
            <?php } else { ?>

                <li><a href="index.php#banner" onclick="toggleMenu();" class="active">Home</a></li>
                <li><a href="index.php#about" onclick="toggleMenu();">About</a></li>
                <!-- <li><a href="#system" onclick="toggleMenu();">System</a></li> -->
                <li><a href="index.php#service" onclick="toggleMenu();">Service</a></li>
                <li><a href="index.php#price" onclick="toggleMenu();">Pricing</a></li>
                <li><a href="index.php#testimonials" onclick="toggleMenu();">Testimonials</a></li>
                <li><a href="index.php#contact" onclick="toggleMenu();">Contact</a></li>
                <li><a href="signin.php" onclick="toggleMenu();">Sign In/Sign Up</a></li>

            <?php } ?>

        </nav>
        <!-- =============== Navabar Section End===================================-->
    </header>
    <!-- =============== Header Section End===================================-->