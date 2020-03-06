<?php
ob_start();
require('connect-hsbc.php');
session_start();
if(!isset($_SESSION["eng"])){
    header("Location: forbidden.html");
}
else{
	$engid=$_SESSION["eng"];
}


if($conn->connect_error){
  die($conn->error);
}

$shift="";
$sqlshift="SELECT * FROM SHIFT";
$res=$conn->query($sqlshift);
$rowsh=mysqli_fetch_assoc($res);
$shift=$rowsh["SHIFT"];

if(isset($_POST['read'])){
	$today=date("Y-m-d");
	$read=addslashes(trim($_POST["read"]));
	$sqldec="UPDATE C_ENG SET NOTICE_COUNT=NOTICE_COUNT-1 WHERE CEC='$engid';";
	$sqlt="UPDATE T_ENG SET NOTICE_COUNT=NOTICE_COUNT-1 WHERE CEC='$engid' AND DATES='$today';";
	$sqleng="UPDATE NOTICE SET MESSAGE_READ=CONCAT(MESSAGE_READ,'$engid,') WHERE PKID=$read;";
	echo $engid;
	echo $read;
	echo $sqleng;
	if(mysqli_query($conn,$sqldec)){
		if(mysqli_query($conn,$sqleng)){
			if(mysqli_query($conn,$sqlt)){
			echo "Eng worked  ";
		}
	}
		else{
			echo $conn->error;
		}
		echo "Worked.  ";
	}
	else{
		echo $conn->error;
	}


}
if(isset($_POST['content'])){ //delete ajax call
$content=$_POST['content'];
echo $content;

	$sql="SELECT * FROM NOTICE WHERE MESSAGE=$content;";
	$result=mysqli_query($conn,$sql);
	$row=mysqli_fetch_assoc($result);
	$a=array();
	$a=explode(",", $row["MESSAGE_READ"]);



 $str="";
foreach ($a as $key => $value) {
	# code...
	$str=$str."'$value',";
}
$str=substr($str, 0, -1);
	echo $str;

								$sqldec="UPDATE C_ENG SET NOTICE_COUNT=NOTICE_COUNT-1 where NOTICE_COUNT>0 AND CEC NOT IN ($str);";
								$sqlmodal="delete from notice where PKID=$content";
								if(mysqli_query($conn,$sqldec)){
									echo "Done bro";
								}
								else{
										echo $conn->error;

								}
                                mysqli_query($conn,$sqlmodal);

}
ob_end_flush();
?>
