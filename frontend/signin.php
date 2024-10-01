<?php
session_start();

if (isset($_SESSION['email'])) {
    header('Location: placeorder.php');
    exit();
}
include 'assets/header.php';
include 'connect.php';

$errors=[
    'email'=>'',
    'password'=>''
];

$oldvalue = [
    'email' => ''
];

if(!empty($_POST)){

    $email=$_POST['email'];
    $password=md5($_POST['password']);

    if (empty($_POST['email'])) {
        $errors['email'] = '*Email field is required';
    }
    if (empty($_POST['password'])) {
        $errors['password'] = '*Password field is required';
    }

    $oldvalue['email'] = $email;
    if (!array_filter($errors)) {

        $query="SELECT * FROM tbl_customer WHERE email='$email' AND password='$password'";
        $result = mysqli_query($conn, $query);

        // Check if the result contains a matching email number and password
        if (mysqli_num_rows($result) > 0) {
            $cRow=mysqli_fetch_assoc($result);
            echo "<script>alert('Login Successfull');</script>";
            $_SESSION['email'] = $cRow['email'];
            $_SESSION['cid']= $cRow['customer_id'];

            header('Location:placeorder.php');

        } else
            $_SESSION['message'] = "Email or password does not exist !!!";
            $oldvalue = [
                'email' => ''
            ];
    }


}




?>






        <div class="container_form">
        <div class="wrapper">
            <h2>Login</h2>

            <div class="alert">
                <?php 
                 if (isset($_SESSION['message'])) {
                    echo "<p>" . $_SESSION['message'] . "</p>";
                    
                     unset($_SESSION['message']);
                 }
                 ?>
            </div>
            <form action="" method="post">
                
                <div class="input-box">
                    <input type="text" name="email" value="<?= $oldvalue['email'] ?>" placeholder="Enter your email">
                    <span class="help-block"><?= $errors['email'] ?></span>
                </div>

                <div class="input-box">
                    <input type="password" name="password" placeholder="Enter your password">
                    <span class="help-block"><?= $errors['password'] ?></span>
                </div>
                <div class="input-box button">
                    <input type="Submit" value="Sign In">
                </div>
                <!-- <div class="text">
                    <h3>Forgot Password <a href="signup.php'">Reset</a></h3>
                </div> -->
                <div class="text">
                    <h3>Create a new account? <a href="signup.php">Signup now</a></h3>
                </div>
            </form>
        </div>
    </div>

    <?php include 'assets/footer.php'?>