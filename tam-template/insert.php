<?php
ob_start();
require('connect-hsbc.php');
session_start();
$qmid="";
$pkid=0;
$case=$_POST['caseNum'];
$engid=$_POST['engcecid'];
$customer=$_POST['customer'];
$shift="";
$sqlshift="SELECT SHIFT FROM ENGINEER WHERE CEC='$engid'";
$res=$conn->query($sqlshift);
$rowsh=mysqli_fetch_assoc($res);
$shift=$rowsh["SHIFT"];
$type=$_POST['case_type'];
date_default_timezone_set('Asia/Kolkata');

$sql="SELECT MAX(PKID) as pkid FROM CASES";
$result=mysqli_query($conn,$sql);
$row=mysqli_fetch_assoc($result);
$pkid=$row["pkid"];
$pkid=$pkid+1;
if($conn->connect_error){
	die($connect->error);
}
echo $engid;

					//		echo "initial";
					//		var_dump(json_decode($_COOKIE['Eng_queue']));
					//		$arr=json_decode($_COOKIE['Eng_queue']);
					//		$first=array_shift($arr);
					//		array_push($arr,$first);
					//		$enc_array=json_encode($arr);
					//
					//		setcookie('Eng_queue',$enc_array);
					//		$_COOKIE['Eng_queue']=$enc_array;
					//
					//		echo "final";
					//		var_dump(json_decode($_COOKIE['Eng_queue']));


if(isset($_POST["assign"])){
	$sqlcheck="SELECT * FROM engineer;";
	$resultset=$conn->query($sqlcheck);
	$a=array();
	while($row=mysqli_fetch_assoc($resultset)){
		array_push($a,$row["CEC"]);
	}
	if(array_search($engid,$a)!==FALSE){
		$qmid=$_SESSION["qm"];
		$case=addslashes($_POST["caseNum"]);
		$accept=0;
		$sqlstate="SELECT STATE FROM ENGINEER WHERE CEC='".$engid."';";
		$resultstate=$conn->query($sqlstate);
		$row=mysqli_fetch_assoc($resultstate);
		$state=$row["STATE"];
		$sqleng="";
		$sqlc="";
		$today=date("Y-m-d");
		$sql="INSERT INTO CASES VALUES($pkid,'$case','$qmid','$engid','$customer',$accept,'".date( 'Y-m-d H:i:s')."',NULL,NULL,'$shift','$type', '$state')";
        echo $sql;
		if($type=="Auto"){
			$sqleng="UPDATE ENGINEER SET EA=EA+1 WHERE CEC='".$engid."'";
			$sqlt="UPDATE T_ENG SET EA_COUNT=EA_COUNT+1 WHERE CEC='".$engid."' AND DATES='$today';";
			$sqlc="UPDATE C_ENG SET EA_COUNT=EA_COUNT+1 WHERE CEC='".$engid."';";

		}
		else if($type=="Manual P1/P2"){
			$sqleng="UPDATE ENGINEER SET P1P2=P1P2+1 WHERE CEC='".$engid."'";
			$sqlt="UPDATE T_ENG SET P1P2_COUNT=P1P2_COUNT+1 WHERE CEC='".$engid."' AND DATES='$today';";
			$sqlc="UPDATE C_ENG SET P1P2_COUNT=P1P2_COUNT+1 WHERE CEC='".$engid."';";

		}
		else if($type=="Manual P3/P4"){
		$sqleng="UPDATE ENGINEER SET P3P4=P3P4+1 WHERE CEC='".$engid."'";
		$sqlt="UPDATE T_ENG SET P3P4_COUNT=P3P4_COUNT+1 WHERE CEC='".$engid."' AND DATES='$today';";
		$sqlc="UPDATE C_ENG SET P3P4_COUNT=P3P4_COUNT+1 WHERE CEC='".$engid."';";

		}
		if($conn->query($sql)){

		if($conn->query($sqleng)){
			if($conn->query($sqlc)){
				if($conn->query($sqlt))
			echo "Success";
			header('Location: case.php');
		}
		else{
            echo "C-ENG broke";
			echo mysqli_error($conn);
		}
	}
	else{
        echo "Eng Broke";
		echo mysqli_error($conn);
	}
}
		else{
            echo "Insert Broke";
			echo mysqli_error($conn);
		}
	}
	else{
		echo "<script>alert('Add this Engineer to the queue before assigning cases');window.location.href='case.php';</script>";
	}
	}
	else{
		echo "Error";
	}
  ob_end_flush();
	?>
