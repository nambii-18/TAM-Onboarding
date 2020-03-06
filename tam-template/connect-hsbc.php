<?php
error_reporting(0);
$conn= new mysqli('localhost','root','','tam_hsbc');
if($conn->connect_error){
  die($conn->error);
}
// $conn1 = mysqli_connect("localhost", "root", "krithu", "crt-hsbc");
// $conn2 = mysqli_connect("localhost", "root", "krithu", "crttester");

?>
