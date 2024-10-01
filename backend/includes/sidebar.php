<?php
session_start();
include('includes/connect.php');



if(empty($_SESSION['username'])){
    header('Location:login.php');
}
?>
<!-- Left Sidebar  -->
<div class="left-sidebar">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <li class="nav-devider"></li>
                <li class="nav-label"></li>
                <li> <a href="index.php" aria-expanded="false"><i class="fa fa-tachometer"></i>Dashboard</a>
                </li>

                    <li> <a class="has-arrow" href="#" aria-expanded="false"><i class="fa fa-address-book"></i><span class="hide-menu">Customer Management</span></a>
                        <ul aria-expanded="false" class="collapse">
                            <li><a href="add_customer.php">Add Customer</a></li>
                            <li><a href="view_customer.php">View Customer</a></li>
                        </ul>
                    </li>

                    <li> <a class="has-arrow" href="#" aria-expanded="false"><i class="fa fa-inr"></i><span class="hide-menu">Order Management</span></a>
                        <ul aria-expanded="false" class="collapse">
                            <!-- <li><a href="add_order.php">Add order</a></li> -->
                            <li><a href="view_order.php">Manage order</a></li>
                        </ul>
                    </li>

                    <li> <a class="has-arrow" href="#" aria-expanded="false"><i class="fa fa-bandcamp"></i><span class="hide-menu">Laundry Items</span></a>
                        <ul aria-expanded="false" class="collapse">
                            <li><a href="add_items.php">Add Items </a></li>
                            <li><a href="view_items.php">View Items</a></li>
                        </ul>
                    </li>


                    <li> <a class="has-arrow" href="#" aria-expanded="false"><i class="fa fa-table"></i><span class="hide-menu">Reports</span></a>
                        <ul aria-expanded="false" class="collapse">
                            <li><a href="delivery_order.php"> Delivery Orders Report</a></li>
                            <li><a href="pending_order.php">Pending Orders</a></li>
                        </ul>
                    </li>

            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</div>
<!-- End Left Sidebar  -->