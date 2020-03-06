<?php
ob_start();

session_start();
$host = 'ds.cisco.com';
$domain = 'cisco.com';
require '/var/www/html/newmail/PHPMailerAutoload.php';
require '/var/www/html/newmail/class.phpmailer.php';


require("connect.php");
//global $mail;
  //echo ":Sds";
$mail = new PHPMailer();
if (isset($_POST["manager"])){
		$cec=$_POST["mcec"];
		$pass=$_POST["mpass"];

        $mail->IsSMTP();
        $mail->Host = "64.101.220.134";
        //$mail->Host = "66.187.221.212";
        $mail->SMTPAuth = true;
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
        $mail->SMTPSecure = "tls";
        $mail->Port = 587;
        $mail->isHTML(true);
        $mail->Username = $cec;
        $mail->Password = $pass;
        $mail->From=$cec."@".$domain;
        $mail->Sender=$cec."@".$domain;
        $mail->SMTPDebug  = 2;
    //var_dump($mail);
        $_SESSION["mail"]=$mail;
				echo "dasfdf";
        $ad = ldap_connect($host,389);
		echo "successfully connected";
		ldap_set_option($ad, LDAP_OPT_PROTOCOL_VERSION, 3);
		ldap_set_option($ad, LDAP_OPT_REFERRALS, 0);
		if(ldap_bind($ad,$cec."@".$domain,$pass)){
			if(mysqli_num_rows(mysqli_query($conn,"SELECT * FROM REVIEWERS WHERE CEC ='".$cec."';"))>0 || mysqli_num_rows(mysqli_query($conn,"SELECT * FROM REVIEWERS2 WHERE CEC ='".$cec."';"))>0 || mysqli_num_rows(mysqli_query($conn,"SELECT * FROM MANAGER WHERE manager ='".$cec."';"))>0){
				//var_dump(mysqli_query($conn,"SELECT * FROM REVIEWERS WHERE CEC ='".$cec."';"));
              echo " success";
			$_SESSION["manager"]=$cec;
			header("Location:backlog.php");
		}
		else{
			setcookie("failed","auth");
			$_COOKIE["failed"]="auth";

			header("Location:index.php");
		}
		}
		else{
				setcookie("failed","fail");
				$_COOKIE["failed"]="fail";
				header("Location:index.php");

		}
	}
	ob_end_flush();

?>
