<?php  
session_start(); 
session_destroy();

?>
<script>
window.location="signin.php";
</script>
<?php
//to redirect back to "index.php" after logging out
  exit;
?>
