<?php
ob_start();
//error_reporting(0);
 require('connect-hsbc.php');
if($conn->connect_error){
    die($connect->error);
}
try
{
$host = 'ds.cisco.com';
$domain = 'cisco.com';
session_start();
   // var_dump($_POST);
if (isset($_POST["engineer"])) {
		$cec=$_POST["engcec"];
		$pass=$_POST["engpass"];
// 		$ad = ldap_connect($host,389);
// 		echo"successfully connected";
// 		ldap_set_option($ad, LDAP_OPT_PROTOCOL_VERSION, 3);
// 		ldap_set_option($ad, LDAP_OPT_REFERRALS, 0);
// 		if(ldap_bind($ad,$cec."@".$domain,$pass)){

// //			if(mysqli_num_rows(mysqli_query($conn,"SELECT * FROM C_ENG WHERE CEC ='".$cec."';"))>0 || mysqli_num_rows(mysqli_query($conn,"SELECT * FROM MANAGER WHERE CEC='".$cec."';"))>0 ){
// 			echo "Bound";
// 			$_SESSION["eng"]=$cec;
// 			$_SESSION["login_time"]=date("Y-m-d H:i:s");
// 			header("Location:engineer.php");
// 			if(!isset($_COOKIE["state"])){
// 			setcookie("state","Unavailable");
// 			$_COOKIE["state"]="Unavailable";
// 			setcookie("counter",0);
// 			$_COOKIE["counter"]=0;
// 			setcookie("auth","success");
// 			$_COOKIE["auth"]="success";
// 			//header("Location: index.php");


//             }
// 		}
		if($_POST["engcec"]=="admin" && $_POST["engpass"]=="admin"){
			$_SESSION["eng"]="admin";
			header("Location:engineer.php");

	}
		else{
//
//			echo ldap_error($ad);
//			//response does it
			session_start();
			$_SESSION["auth"] = "failed";
			header("Location:index.php");

		}
	}
	if(isset($_POST["qm"])){
		$cec=$_POST["qmcec"];
		$pass=$_POST["qmpass"];
	// 	$ad = ldap_connect($host,389);
	// 	echo"successfully connected";
	// 	ldap_set_option($ad, LDAP_OPT_PROTOCOL_VERSION, 3);
	// 	ldap_set_option($ad, LDAP_OPT_REFERRALS, 0);

		// if(ldap_bind($ad,$cec."@".$domain,$pass)){
        //     if(mysqli_num_rows(mysqli_query($conn,"SELECT * FROM OP_ENG WHERE CEC ='".$cec."';"))>0){
        //         header("Location:optimize.php");
        //         $_SESSION["qm"]=$cec;
        //     }
        //     else{
		// 	$_SESSION["qm"]=$cec;
		// 	header("Location:case.php");
        //     setcookie("countt",0);
        //     $_COOKIE["countt"]=0;
		// }
        // }

	if($_POST["qmcec"]=="admin" && $_POST["qmpass"]=="admin"){
			$_SESSION["qm"]="admin";
			header("Location:case.php");

	}
		else{
			//echo ldap_error();
			//response does it
			session_start();
			$_SESSION["auth"] = "failed";
			header("Location:index.php");
			}
	}
}
catch(Exception $e)
{
echo "Exception found!";
ob_end_flush();
}
?>
