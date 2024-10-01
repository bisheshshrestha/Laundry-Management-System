<?php
date_default_timezone_set('Asia/Kolkata');
$current_date = date('Y-m-d');
include('connect.php');
$passw = hash('sha256', $_POST['password']);
//$passw = hash('sha256',$p);
//echo $passw;exit;
function createSalt()
{
    return '2123293dsj2hu2nikhiljdsd';
}
$salt = createSalt();
$pass = hash('sha256', $salt . $passw);

extract($_POST);
  $sql="INSERT INTO `customer`(`id`, `fname`, `lname`, `contact`, `address`, `discription`, `pd`, `dd`) VALUES ('$fname','$lname','$contact','$address','$discription','$pd','$dd')";
 if ($conn->query($sql) === TRUE) {
      $_SESSION['success']=' Record Successfully Added';
     ?>
<script type="text/javascript">
window.location="../view_customer.php";
</script>
<?php
} else {
      $_SESSION['error']='Something Went Wrong';
?>
<script type="text/javascript">
window.location="../view_customer.php";
</script>
<?php } ?>