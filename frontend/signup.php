<?php include 'assets/header.php' ?>
<?php
include('connect.php');

$errors = [
    'fname' => '',
    'lname' => '',
    'email' => '',
    'password' => '',
    'gender' => '',
    'phone' => '',
    'address' => ''
];
$oldvalue = [
    'fname' => '',
    'lname' => '',
    'email' => '',
    'password' => '',
    'gender' => '',
    'phone' => '',
    'address' => ''
];


if (!empty($_POST)) {

    if (empty($_POST['fname'])) {
        $errors['fname'] = 'First Name is required';
    }


    if (empty($_POST['lname'])) {
        $errors['lname'] = 'Last Name is required';
    }

    if (empty($_POST['email'])) {
        $errors['email'] = 'email is required';
    } else {
        if (!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/i", $_POST['email'])) {
            $errors['email'] = "Error: Invalid email address";
        }
    }

    if (empty($_POST['password'])) {
        $errors['password'] = 'Password is required';
    }
    if (empty($_POST['gender'])) {
        $errors['gender'] = 'Gender is required';
    }

    if (empty($_POST['phone'])) {
        $errors['phone'] = 'Phone number is required';
    } else {
        if (!preg_match('/^[0-9]{10}+$/', $_POST['phone'])) {
            $errors['phone'] = "Phone number should be 10 digits and contain only numbers";
        }
    }
    if (empty($_POST['address'])) {
        $errors['address'] = 'Address field is required';
    }


    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $gender = $_POST['gender'];
    $password = md5($_POST['password']);
    $phone = $_POST['phone'];
    $address = $_POST['address'];


    $oldvalue['fname'] = $fname;
    $oldvalue['lname'] = $lname;
    $oldvalue['email'] = $email;
    $oldvalue['phone'] = $phone;
    $oldvalue['address'] = $address;
    $oldvalue['gender'] = $gender;



    if (!array_filter($errors)) {

        $query = "SELECT email FROM tbl_customer WHERE email='$email'";
        $res = mysqli_query($conn, $query);

        if (mysqli_num_rows($res) > 0) {
            echo "<script>
            alert('Email Already Exist Please signin!!!!!')
            window.location='signin.php';
            </script>";
        } else {
            $sql = "INSERT INTO tbl_customer (first_name,last_name,email,password,gender,phone,address) VALUES('$fname','$lname','$email','$password','$gender','$phone','$address')";

            $result = mysqli_query($conn, $sql);
            if ($result) {
                echo "<script>
                alert('Data inserted successfully')
                window.location='signin.php';
                </script>";
            }
        }
    }
}
?>



<div class="container_form register">
    <div class="wrapper">
        <h2>Registration</h2>
        <form action="" method="post">
            <div class="input-box">
                <input type="text" name="fname" value="<?= $oldvalue['fname'] ?>" placeholder="Enter your First Name">
                <span class="help-block"><?= $errors['fname'] ?></span>
            </div>

            <div class="input-box">
                <input type="text" name="lname" value="<?= $oldvalue['lname'] ?>" placeholder="Enter your Last Name">
                <span class="help-block">
                    <?= $errors['lname'] ?>
                </span>

            </div>

            <div class="input-box">
                <input type="text" name="email" value="<?= $oldvalue['email'] ?>" placeholder="Enter your email">
                <span class="help-block">
                    <?= $errors['email'] ?>
                </span>

            </div>

            <div class="input-box">
                <input type="password" name="password" placeholder="Create password">
                <span class="help-block">
                    <?= $errors['password'] ?>
                </span>

            </div>

            <div class="input-box gender">
                <select name="gender" id="gender" class="form-select">
                    <option value="" selected>Select Gender</option>
                    <option value="Male" <?= $oldvalue['gender'] == 'Male' ? 'selected' : ''; ?>>Male</option>
                    <option value="Female" <?= $oldvalue['gender'] == 'Female' ? 'selected' : ''; ?>>Female</option>
                </select>
                <span class="help-block">
                    <?= $errors['gender'] ?>
                </span>


            </div>


            <div class="input-box">
                <input type="address" name="address" value="<?= $oldvalue['address'] ?>" placeholder="Enter address">
                <span class="help-block">
                    <?= $errors['address'] ?>
                </span>

            </div>

            <div class="input-box">
                <input type="number" name="phone" value="<?= $oldvalue['phone'] ?>" placeholder="Enter Phone number">
                <span class="help-block">
                    <?= $errors['phone'] ?>
                </span>

            </div>

            <div class="input-box button">
                <input type="Submit" value="Register Now">
            </div>
            <div class="text">
                <h3>Already have an account? <a href="signin.php">Login now</a></h3>
            </div>
        </form>
    </div>
</div>

<?php include 'assets/footer.php' ?>