<?php
ob_start();
include('includes/head.php');
include('includes/header.php');
include('includes/sidebar.php');
include('includes/connect.php');
date_default_timezone_set('Asia/Kathmandu');
$current_date = date('Y-m-d');

$errors = [
    'item_name' => '',
    'item_image' => '',
    'price' => '',
    'unit' => '',
];

$oldValues = [
    'item_name' => '',
    'price' => '',
    'unit' => '',
];

if (!empty($_POST)) {

    if (empty($_POST['item_name'])) {
        $errors['item_name'] = 'Item name is required';
    }

    if (empty($_FILES['item_image']['name'])) {
        $errors['item_image'] = 'Item image is required';
    } else {
        // Validate file type
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        $fileExtension = strtolower(pathinfo($_FILES['item_image']['name'], PATHINFO_EXTENSION));

        if (!in_array($fileExtension, $allowedExtensions)) {
            $errors['item_image'] = 'Invalid file type. Please upload a valid image (jpg, jpeg, png, gif).';
        }
    }

    if (empty($_POST['price'])) {
        $errors['price'] = 'Item price is required';
    }

    if (empty($_POST['unit'])) {
        $errors['unit'] = 'Item unit is required';
    }

    $oldValues['item_name'] = $_POST['item_name'];
    $oldValues['price'] = $_POST['price'];
    $oldValues['unit'] = $_POST['unit'];

    if (!array_filter($errors)) {
        // Move uploaded image to the "images/" folder
        $targetDir = "images/";
        $targetFile = $targetDir . basename($_FILES["item_image"]["name"]);

        if (move_uploaded_file($_FILES["item_image"]["tmp_name"], $targetFile)) {
            // Image uploaded successfully, proceed with database insertion
            $sql = "INSERT INTO tbl_items (item_name, item_image, price, unit) VALUES ('$oldValues[item_name]', '$targetFile', '$oldValues[price]', '$oldValues[unit]')";
            $result = mysqli_query($conn, $sql);

            if ($result) {
                header('Location:view_items.php');
            } else {
                echo "Error: " . mysqli_error($conn);
            }
        } else {
            $errors['item_image'] = 'Error uploading the file.';
        }
    }
}
?>


<!-- Page wrapper  -->
<div class="page-wrapper">
    <!-- Bread crumb -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-primary heading">Items Details</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="">Home</a></li>
                <li class="breadcrumb-item active">Items Management</li>
            </ol>
        </div>
    </div>
    <!-- End Bread crumb -->
    <!-- Container fluid  -->
    <div class="container-fluid">
        <!-- Start Page Content -->

        <!-- /# row -->
        <div class="row">
            <div class="col-lg-8" style="  margin-left: 10%;">
                <div class="card">
                    <div class="card-title">

                    </div>
                    <div class="card-body">
                        <div class="input-states">
                            <form class="form-horizontal" method="POST" action="" name="userform" enctype="multipart/form-data">

                                <input type="hidden" name="currnt_date" class="form-control" value="<?php echo $current_date; ?>">

                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-sm-3 control-label">Item Name</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="item_name" value="<?= $oldValues['item_name'] ?>" class="form-control" placeholder="Item name">
                                            <span class="help-block"><?= $errors['item_name'] ?></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-sm-3 control-label">Item Image</label>
                                        <div class="col-sm-9">
                                            <input type="file" name="item_image" class="form-control">
                                            <span class="help-block"><?= $errors['item_image'] ?></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-sm-3 control-label">Price</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="price" value="<?= $oldValues['price'] ?>" class="form-control" placeholder="Price">
                                            <span class="help-block"><?= $errors['price'] ?></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-sm-3 control-label">Unit</label>
                                        <div class="col-sm-9">
                                            <select name="unit" id="event" class="form-control">
                                                <option value="">--Select Unit--</option>
                                                <option value="kg" <?= ($oldValues['unit'] === 'kg') ? 'selected' : ''; ?>>kg</option>
                                                <option value="pcs" <?= ($oldValues['unit'] === 'pcs') ? 'selected' : ''; ?>>pcs</option>
                                            </select>
                                            <span class="help-block"><?= $errors['unit'] ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" name="btn_save" class="btn btn-primary btn-flat m-b-30 m-t-30">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <?php include('includes/footer.php'); ?>
