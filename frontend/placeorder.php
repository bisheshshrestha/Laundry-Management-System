<?php
session_start();
include 'assets/header.php';
include 'assets/session.php';
include 'connect.php';

date_default_timezone_set('Asia/Kathmandu');
$current_date = date('Y-m-d');

$cid = $_SESSION['cid'];

$sql1 = "SELECT * FROM tbl_customer WHERE customer_id=$cid";
$res1 = mysqli_query($conn, $sql1);
$customerData = mysqli_fetch_assoc($res1);

$delivery_charge = 100; // Set the delivery charge amount

if (isset($_POST["add_to_cart"])) {
    if (isset($_SESSION["shopping_cart"])) {
        $item_array_id = array_column($_SESSION["shopping_cart"], "item_id");
        if (!in_array($_GET["id"], $item_array_id)) {
            // Generate a unique identifier for each item in the cart
            $item_id = $_GET["id"];
            $item_array = array(
                'item_id'        => $item_id,
                'item_name'      => $_POST["hidden_name"],
                'item_price'     => $_POST["hidden_price"],
                'item_quantity'  => $_POST["quantity"]
            );
            $_SESSION["shopping_cart"][$item_id] = $item_array;
        } else {
            echo '<script>alert("Item Already Added")</script>';
        }
    } else {
        $item_id = $_GET["id"];
        $item_array = array(
            'item_id'        => $item_id,
            'item_name'      => $_POST["hidden_name"],
            'item_price'     => $_POST["hidden_price"],
            'item_quantity'  => $_POST["quantity"]
        );
        $_SESSION["shopping_cart"][$item_id] = $item_array;
    }
}

if (isset($_GET["action"])) {
    if ($_GET["action"] == "delete") {
        foreach ($_SESSION["shopping_cart"] as $key => $values) {
            if ($values["item_id"] == $_GET["id"]) {
                unset($_SESSION["shopping_cart"][$key]);
                echo '<script>alert("Item Removed")</script>';
                echo '<script>window.location="placeorder.php"</script>';
            }
        }
    }
}

?>
<section id="placeorder">
<div class="container mt-100">
<p style="font-weight:bold; font-size:40px;text-align:center">Place Order</p>

    <div class="row">
        <?php
        $query = "SELECT * FROM tbl_items ORDER BY item_id ASC";
        $result = mysqli_query($conn, $query);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_array($result)) {
                ?>
                <div class="col-md-4">
                    <form method="post" action="placeorder.php?action=add&id=<?= $row["item_id"]; ?>">
                        <div style="border:1px solid #333; background-color:#f1f1f1; border-radius:5px; padding:16px;"
                             align="center">
                            <img src="../backend/<?= $row["item_image"]; ?>" class="img-responsive" width="200"
                                 height="200"/>

                            <h4 class="text-info"><?= $row["item_name"]; ?></h4>

                            <h4 class="text-danger">Rs. <?= $row["price"]; ?> per <?= $row["unit"]; ?></h4>

                            <div class="input-group">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="button"
                                            onclick="decrement('quantity<?= $row['item_id']; ?>')">-
                                    </button>
                                </span>
                                <input type="text" name="quantity" class="form-control input-number" value="1" min="1"
                                       max="10" id="quantity<?= $row["item_id"]; ?>" readonly
                                       style="text-align: center;">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="button"
                                            onclick="increment('quantity<?= $row['item_id']; ?>')">+
                                    </button>
                                </span>
                            </div>

                            <input type="hidden" name="hidden_name" value="<?= $row["item_name"]; ?>"/>
                            <input type="hidden" name="hidden_price" value="<?= $row["price"]; ?>"/>

                            <input type="submit" name="add_to_cart" style="margin-top:5px;"
                                   class="btn btn-success" value="Add to Cart"/>
                        </div>
                    </form>
                </div>
                <?php
            }
        }
        ?>
    </div>
   
</div>
</section>

<?php
// Calculate the total order amount
$total = 0;
if (!empty($_SESSION["shopping_cart"])) {
    foreach ($_SESSION["shopping_cart"] as $key => $values) {
        $total += ($values["item_quantity"] * $values["item_price"]);
    }
    // Add delivery charge to the total
    $total += $delivery_charge;
}
?>

<div class="container">
    <h3>Order Details</h3>
    <div class="table-responsive">
        <table class="table table-bordered">
            <tr>
                <th width="40%">Item Name</th>
                <th width="10%">Quantity</th>
                <th width="20%">Price</th>
                <th width="15%">Total</th>
                <th width="5%">Action</th>
            </tr>
            <?php
            if (!empty($_SESSION["shopping_cart"])) {
                foreach ($_SESSION["shopping_cart"] as $key => $values) {
                    ?>
                    <tr>
                        <td><?= $values["item_name"]; ?></td>
                        <td><?= $values["item_quantity"]; ?></td>
                        <td>Rs. <?= $values["item_price"]; ?></td>
                        <td>Rs <?= number_format($values["item_quantity"] * $values["item_price"], 2); ?></td>
                        <td><a href="placeorder.php?action=delete&id=<?= $key; ?>"><span
                                    class="text-danger">Remove</span></a></td>
                    </tr>
                    <?php
                }
                ?>
                <tr>
                    <td colspan="3" align="right">Subtotal</td>
                    <td align="right">Rs. <?= number_format($total - $delivery_charge, 2); ?></td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="3" align="right">Delivery Charge</td>
                    <td align="right">Rs. <?= number_format($delivery_charge, 2); ?></td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="3" align="right">Total</td>
                    <td align="right">Rs. <?= number_format($total, 2); ?></td>
                    <td></td>
                </tr>
                <?php
            }
            ?>
        </table>
        <form method="post" action="cart.php">
            <input type="submit" class="btn btn-primary" value="Proceed to Payment">
        </form>
    </div>
</div>

<script>
    function increment(inputId) {
        var input = document.getElementById(inputId);
        var value = parseInt(input.value, 10);
        if (!isNaN(value) && value < 10) {
            input.value = value + 1;
        }
    }

    function decrement(inputId) {
        var input = document.getElementById(inputId);
        var value = parseInt(input.value, 10);
        if (!isNaN(value) && value > 1) {
            input.value = value - 1;
        }
    }
</script>

<?php include 'assets/footer.php' ?>
