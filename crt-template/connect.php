<?php
ob_start();
$servername = "localhost";
$username = "root";
$password = "krithu";
$conn = mysqli_connect($servername, $username, $password,"crt-hsbc");
ob_end_flush();
?>
