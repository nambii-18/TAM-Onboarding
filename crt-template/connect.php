<?php
ob_start();
$servername = "localhost";
$username = "root";
$password = "";
$conn = mysqli_connect($servername, $username, $password,"crt_hsbc");
ob_end_flush();
?>
