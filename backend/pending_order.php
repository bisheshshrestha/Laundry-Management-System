<?php include('includes/head.php'); ?>
<?php include('includes/header.php'); ?>
<?php include('includes/sidebar.php'); ?>

<?php
if (isset($_POST['generate_report'])) {
    // Get the start and end dates from the form
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    // Construct the SQL query to fetch pending orders within the date range
    $sql = "SELECT o.order_id, c.first_name AS customer_name, i.item_name AS laundry_type, o.quantity, o.price, o.order_date, o.pickup_date, o.delivery_date, o.location, o.status 
            FROM tbl_orders o
            JOIN tbl_customer c ON o.customer_id = c.customer_id
            JOIN tbl_items i ON o.laundry_type = i.item_id
            WHERE o.status = 'Pending' AND o.order_date BETWEEN '$start_date' AND '$end_date'";

    $result = mysqli_query($conn, $sql);
} else {
    // If the form is not submitted, initialize result as an empty array
    $result = [];
}
?>

<!-- Page wrapper  -->
<div class="page-wrapper">
    <!-- Bread crumb -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-primary heading"> View pending order</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">View order order</li>
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
                <form method="POST" action="">
                    <label for="start_date">Start Date:</label>
                    <input type="date" id="start_date" name="start_date" required>
                    <label for="end_date">End Date:</label>
                    <input type="date" id="end_date" name="end_date" required>
                    <button type="submit" name="generate_report">Generate Report</button>

                    <!-- Add a print button to the right of the form -->
                    <button type="button" onclick="printTable()">Print Table</button>
                </form>
                <div class="table-responsive m-t-40">
                    <table id="myTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Customer Name</th>
                                <th>Laundry Type</th>
                                <th>Price</th>
                                <th>Pickup Date</th>
                                <th>Delivery Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php foreach ($result as $key => $orderData) { ?>
                                <tr>
                                    <td><?= ++$key ?></td>
                                    <td><?= $orderData['customer_name'] ?></td>
                                    <td><?= $orderData['laundry_type'] ?></td>
                                    <td><?= $orderData['price'] ?></td>
                                    <td><?= $orderData['pickup_date'] ?></td>
                                    <td><?= $orderData['delivery_date'] ?></td>
                                    <td><?= $orderData['status'] ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @media print {
        /* Hide elements you don't want to print */
        .breadcrumb, form, button {
            display: none;
        }

        /* Add your custom print styles */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
    }
</style>

<script>
    function printTable() {
        // Create a new window for printing
        var printWindow = window.open('', '', 'width=1200,height=800');

        // Hide unnecessary elements in the print window
        printWindow.document.write('<html><head><title>Print</title>');
        printWindow.document.write('<style>table {border-collapse: collapse;} th, td {border: 1px solid #000; padding: 8px; text-align: left;}</style>');
        printWindow.document.write('</head><body>');
        printWindow.document.write('<h2>Report of Pending Order from <?= $start_date ?> to <?= $end_date ?></h2>');
        printWindow.document.write(document.getElementById('myTable').outerHTML);
        printWindow.document.write('</body></html>');

        // Print and close the print window
        printWindow.document.close();
        printWindow.print();
        printWindow.close();
    }
</script>

<?php include('includes/footer.php'); ?>
