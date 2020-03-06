<?php
ob_start();
require("connect.php");
if($_GET["enggdc"]==1){
	$eng=$_GET["eng"];
	$sql="SELECT * FROM ENGINEER WHERE CEC='$eng';";

	if (!$conn)
	{
    	die("Connection failed: " . mysqli_connect_error());
	}
	$result=mysqli_query($conn,$sql);
	$row=mysqli_fetch_assoc($result);
	echo $row["GDC"];
}
ob_end_flush();

?>
