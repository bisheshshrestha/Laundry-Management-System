<?php
session_start();
ob_start();
include('includes/head.php');
include('includes/connect.php');

$errors = [
  'username' => '',
  'password' => ''
];

if (!empty($_POST)) {

  $username = $_POST['username'];
  $password = md5($_POST['password']);

  if (empty($_POST['username'])) {
    $errors['username'] = '*Email field is required';
  }
  if (empty($_POST['password'])) {
    $errors['password'] = '*Password field is required';
  }

  if (!array_filter($errors)) {

    $query = "SELECT username,password FROM tbl_admin WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $query);

    // Check if the result contains a matching username and password
    if (mysqli_num_rows($result) > 0) {

      $_SESSION['username'] = $username;
      header('Location:index.php');
    } else
      $_SESSION['message'] = "username or password does not exist !!!";
  }
}






?>



<!-- Main wrapper  -->
<div id="main-wrapper">
  <div class="unix-login">

    <div class="container-fluid" style="background-image: url('assests/uploadImage/Logo/background.jpg');
 background-color: #cccccc;padding-top:50px; height:652px">
      <div class="row justify-content-center">
        <div class="col-lg-4">
          <div class="login-content card">
            <div class="login-form">
              <center><img src="assets/uploadImage/Logo/WASHMANDU(1).png ?>" style="width:50%;"></center><br><!-- <h4>Login</h4> -->
              <form method="POST">
                <div class="form-group">
                  <label>Username</label>
                  <input type="text" name="username" class="form-control" placeholder="username">
                  <span class="help-block"><?= $errors['username'] ?></span>
                </div>
                <div class="form-group">
                  <label>Password</label>
                  <input type="password" name="password" class="form-control" placeholder="Password">
                  <span class="help-block"><?= $errors['password'] ?></span>
                </div>
                <div class="checkbox">
                  <label class="pull-left">
                    <a href="forgot_password.php">Forgotten Password?</a>
                  </label>
                </div>
                <button type="submit" name="btn_login" class="btn btn-primary login-btn btn-flat m-b-30 m-t-30 login">Sign in</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>

<!-- End Wrapper -->
<!-- All Jquery -->
<script src="assets/js/lib/jquery/jquery.min.js"></script>
<!-- Bootstrap tether Core JavaScript -->
<script src="assets/js/lib/bootstrap/js/popper.min.js"></script>
<script src="assets/js/lib/bootstrap/js/bootstrap.min.js"></script>
<!-- slimscrollbar scrollbar JavaScript -->
<script src="assets/js/jquery.slimscroll.js"></script>
<!--Menu sidebar -->
<script src="assets/js/sidebarmenu.js"></script>
<!--stickey kit -->
<script src="assets/js/lib/sticky-kit-master/dist/sticky-kit.min.js"></script>
<!--Custom JavaScript -->
<script src="assets/js/custom.min.js"></script>

</body>

</html>