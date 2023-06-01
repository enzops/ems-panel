<?php
session_start();
// Check if the user is logged in, and have the right
if($_SESSION["UserAdmin"] !== "1"){
    header("location: welcome.php");
    exit;
}
?>