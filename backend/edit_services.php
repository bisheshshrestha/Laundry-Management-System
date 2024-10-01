<?php
ob_start();
include('includes/head.php');
include('includes/header.php');
include('includes/sidebar.php');
include('includes/connect.php');

$id = $_GET['id'];
$sql = "SELECT * FROM tbl_items WHERE item_id=$id";
$result = mysqli_query($conn, $sql);
$itemData = mysqli_fetch_assoc($result);

if (!empty($_POST)) {
    $item_name = $_POST['item_name'];
    $price = $_POST['price'];
    $image = $_FILES["item_image"];
    $unit=$_POST['unit'];

    // Delete previous image from "images/" folder
    $prevImage = $itemData['item_image'];
    if (file_exists($prevImage)) {
        unlink($prevImage);
    }

    // Move uploaded image to the "images/" folder
    $targetDir = "images/";
    $targetFile = $targetDir . basename($image["name"]);
    move_uploaded_file($image["tmp_name"], $targetFile);

    $sql = "UPDATE tbl_items SET item_name='$item_name', item_image='$targetFile', price='$price',unit='$unit' WHERE item_id=$id";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        header('Location:view_items.php');
    }
}
?>

<!-- Page wrapper  -->
<div class="page-wrapper">
    <!-- Bread crumb -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-primary">Items Details</h3>
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
        <div class="row">
            <div class="col-lg-8" style="margin-left: 10%;">
                <div class="card">
                    <div class="card-title"></div>
                    <div class="card-body">
                        <div class="input-states">
                            <form class="form-horizontal" method="POST" action="" name="userform" enctype="multipart/form-data">
                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-sm-3 control-label">Item Name</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="item_name" class="form-control" value="<?= $itemData['item_name'] ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-sm-3 control-label">Item Image</label>
                                        <div class="col-sm-9">
                                            <img id="preview-image" src="<?= $itemData['item_image'] ?>" alt="Item Image" style="width: 100px; height: 100px;">
                                            <input type="file" name="item_image" class="form-control" onchange="previewImage(event)">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-sm-3 control-label">Price</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="price" class="form-control" value="<?= $itemData['price'] ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-sm-3 control-label">Laundry Unit</label>
                                        <div class="col-sm-9">
                                            <select name="unit" id="unit" class="form-control">
                                                <option value="kg" <?= $itemData['unit'] == 'kg' ? 'selected' : '' ?>>kg</option>
                                                <option value="pcs" <?= $itemData['unit'] == 'pcs' ? 'selected' : '' ?>>pcs</option>
                                            </select>
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
    </div>
</div>

<?php include('includes/footer.php'); ?>

<script>
    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function() {
            var output = document.getElementById('preview-image');
            output.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>