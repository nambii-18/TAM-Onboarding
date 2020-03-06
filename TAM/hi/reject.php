<?php
ob_start();
//var_dump($_POST);
session_start();
require('connect-hsbc.php');
//if(!$_SESSION["qm"]){
//    header("Location: forbidden.html");
//}
if($_SESSION["qm"]){
$conn->query("SELECT * FROM SHIFT");
date_default_timezone_set('Asia/Kolkata');
$qmcec =$_SESSION["qm"];//globals
$engcec = '';
$cust = '';
$date = '';
$casenum = '';
$custn='';
$casen='';
$casename='';
$reason='';
$main_pkid =0;
$num='';
$shift="";
$type="";
$queue=array();
//var_dump($_POST);
    $shift="";
$sqlshift="SELECT * FROM SHIFT";
$res=$conn->query($sqlshift);
$rowsh=mysqli_fetch_assoc($res);
$shift=$rowsh["SHIFT"];
if(!isset($_POST['skip']) && !isset($_POST["Edit"]))
{

    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

    $sql = "SELECT * FROM reject";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        $row = $result->fetch_assoc() ;
                $main_pkid=$row['PKID'];
                $qmcec = $row['QM_CEC'];
                $engcec = $row['ENG_CEC'];
                $cust = $row['CUSTOMER'];
                $casename = $row['CASE_NAME'];
                $type = $row['TYPE'];
                $shift= $row['SHIFT'];
                $date= $row['DATE_REJECT'];
                $reason= $row['REASON'];
                $type=$row['TYPE'];
                array_push($queue, $main_pkid);
    }
    else {
        echo "<div style='text-align:center;margin-top:10px; padding-bottom:10px; border-bottom:2px solid crimson;'>No Rejected Cases</div>";
    }


//push the rest of them into the queue

      while( $row = $result->fetch_assoc()) {
        // output data of each row

                $main_pkid=$row['PKID'];
                $qmcec = $row['QM_CEC'];
                $engcec = $row['ENG_CEC'];
                $cust = $row['CUSTOMER'];
                $casename = $row['CASE_NAME'];
                $type = $row['TYPE'];
                $shift= $row['SHIFT'];
                $date= $row['DATE_REJECT'];
                $reason= $row['REASON'];
                $type=$row['TYPE'];
                array_push($queue, $main_pkid);
    }

    //var_dump($queue);

    //fill the fields in a round robin fashion form the queue
    //fetch the value from the queue

    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
   $rej_pkid = array_shift($queue);

   //echo $rej_pkid;
   $sql = "SELECT * FROM reject where pkid=$rej_pkid";
   array_push($queue, $rej_pkid);
    if($result = $conn->query($sql)){

    if ($result->num_rows > 0) {
        // output data of each row
        $row = $result->fetch_assoc();
                $main_pkid=$row['PKID'];
                $qmcec = $row['QM_CEC'];
                $engcec = $row['ENG_CEC'];
                $cust = $row['CUSTOMER'];
                $casename = $row['CASE_NAME'];
                $type = $row['TYPE'];
                $shift= $row['SHIFT'];
                $date= $row['DATE_REJECT'];
                $reason= $row['REASON'];
                $type=$row['TYPE'];

    }

    setcookie("queue",json_encode($queue));
    $_COOKIE['queue']=json_encode($queue);
    //var_dump($_COOKIE);
}
else{
   // echo "
   //      <div style='text-align:center;margin-top:10px; padding-bottom:10px; border-bottom:2px solid #8EC343;'>
   //        <div class='svg' style='display:inline-block;'>
   //          <svg xmlns='http://www.w3.org/2000/svg' width='26' height='26' viewBox='-263.5 236.5 26 26'>
   //            <g class='svg-success'>
   //              <circle cx='-250.5' cy='249.5' r='12'/>
   //              <path d='M-256.46 249.65l3.9 3.74 8.02-7.8'/>
   //            </g>
   //          </svg>
   //        </div>
   //          <span style='display:inline-block; vertical-align: super;margin-left: 10px;'>No Rejected cases!</span>
   //      </div>
   //      ";
}
}//end of the default if
$shift="";
$sqlshift="SELECT * FROM SHIFT";
$res=$conn->query($sqlshift);
$rowsh=mysqli_fetch_assoc($res);
$shift=$rowsh["SHIFT"];


if(isset($_POST["delete"])){
    $pk=$_POST["pkid"];
    //echo "Hello";
    $engcec=$_POST['engcec'];
    $type=$_POST["type"];

    $sqldelete="DELETE FROM CASES WHERE PKID=".$pk.";";
     $sqldelete2="DELETE FROM reject where PKID=".$pk.";";

     if($conn->query($sqldelete) && $conn->query($sqldelete2)){
          echo "
        <div style='text-align:center;margin-top:10px; padding-bottom:10px; border-bottom:2px solid #8EC343;'>
          <div class='svg' style='display:inline-block;'>
            <svg xmlns='http://www.w3.org/2000/svg' width='26' height='26' viewBox='-263.5 236.5 26 26'>
              <g class='svg-success'>
                <circle cx='-250.5' cy='249.5' r='12'/>
                <path d='M-256.46 249.65l3.9 3.74 8.02-7.8'/>
              </g>
            </svg>
          </div>
            <span style='display:inline-block; vertical-align: super;margin-left: 10px;'>Record Deleted!</span>
        </div>
        ";
        header("Location: reject.php");
     }
    else{

     echo $conn->error();

    }

}

if(isset($_POST["skip"])){

    $queue=json_decode($_COOKIE['queue']);


    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
   $rej_pkid = array_shift($queue);
   //echo $rej_pkid;
   $sql = "SELECT * FROM reject where pkid=$rej_pkid";
   array_push($queue, $rej_pkid);
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        $row = $result->fetch_assoc() ;
                $main_pkid=$row['PKID'];
                $qmcec = $row['QM_CEC'];
                $engcec = $row['ENG_CEC'];
                $cust = $row['CUSTOMER'];
                $casename = $row['CASE_NAME'];
                $type = $row['TYPE'];
                $shift= $row['SHIFT'];
                $date= $row['DATE_REJECT'];
                $reason= $row['REASON'];
                $type=$row['TYPE'];

    }
    setcookie("queue",json_encode($queue));
    $_COOKIE['queue']=json_encode($queue);
    //var_dump($_COOKIE);


}



if(isset($_POST["Edit"])){
   // var_dump($_POST);
    $engc = $_POST['engc'];
	$main_pk=$_POST['main_pkid'];
    $casen=addslashes($_POST['casen']);
    $type=$_POST["type"];

    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    } else {
    }
    $sqlc="";
    $sqlr="SELECT * FROM REJECTED WHERE PKID= ".$main_pk;
    $resultr=mysqli_query($conn,$sqlr);
    $today=date("Y-m-d");
    if($type=="Auto"){
            $sqlc="UPDATE C_ENG SET EA_COUNT=EA_COUNT+1 WHERE CEC='".$engc."';";
            $sqlt="UPDATE T_ENG SET EA_COUNT=EA_COUNT+1 WHERE CEC='".$engc."' AND DATES='$today' AND SHIFT='$shift';";

        }
        else if($type=="Manual P1/P2"){
            $sqlc="UPDATE C_ENG SET P1P2_COUNT=P1P2_COUNT+1 WHERE CEC='".$engc."';";
            $sqlt="UPDATE T_ENG SET P1P2_COUNT=P1P2_COUNT+1 WHERE CEC='".$engc."' AND DATES='$today' AND SHIFT='$shift';";

        }
        else if($type=="Manual P3/P4"){
            $sqlc="UPDATE C_ENG SET P3P4_COUNT=P3P4_COUNT+1 WHERE CEC='".$engc."';";
            $sqlt="UPDATE T_ENG SET P3P4_COUNT=P3P4_COUNT+1 WHERE CEC='".$engc."' AND DATES='$today' AND SHIFT='$shift';";

        }
        if($conn->query($sqlc)){
            echo "";
        }
        else{
            echo $conn->error();
        }
    if($type=="Auto"){
            $sqleng="UPDATE ENGINEER SET EA=EA+1 WHERE CEC='$engc'";

        }
        else if($type=="Manual P1/P2"){
            $sqleng="UPDATE ENGINEER SET P1P2=P1P2+1 WHERE CEC='$engc'";

        }
        else if($type=="Manual P3/P4"){
          $sqleng="UPDATE ENGINEER SET P3P4=P3P4+1 WHERE CEC='$engc'";

        }
        //echo $sqlt;
    $sql = "UPDATE cases SET CASE_NUM='$casen', ENG_CEC='$engc',ACCEPT=0, DT_SUBMIT='".date( 'Y-m-d H:i:s')."' where PKID=".$main_pk.";";
    $sqldelete="DELETE FROM reject where PKID=".$main_pk.";";
    if ($conn->query($sql) && $conn->query($sqldelete) && $conn->query($sqleng) && $conn->query($sqlt)) {
        echo "
        <div style='text-align:center;margin-top:10px; padding-bottom:10px; border-bottom:2px solid #8EC343;'>
          <div class='svg' style='display:inline-block;'>
            <svg xmlns='http://www.w3.org/2000/svg' width='26' height='26' viewBox='-263.5 236.5 26 26'>
              <g class='svg-success'>
                <circle cx='-250.5' cy='249.5' r='12'/>
                <path d='M-256.46 249.65l3.9 3.74 8.02-7.8'/>
              </g>
            </svg>
          </div>
            <span style='display:inline-block; vertical-align: super;margin-left: 10px;'>Record Updated!</span>
        </div>
        ";
        //header("Location: reject.php");
    } else {
        echo "<div style='text-align:center;margin-top:10px; padding-bottom:10px; border-bottom:2px solid crimson;'>Error updating record. </div>" . $conn->error;
    }

    }

    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }




echo '

<!DOCTYPE html>
<html lang="en">

<head>


	<meta charset="utf-8">
	<title>Re-Assign Rejected Cases - TAM Tool &middot; Cisco CMS</title>
	<!-- <meta name="description" content="Quality Management Tool">
  <meta name="author" content="Cisco CMS"> -->

	<meta name="viewport" content="width=device-width, initial-scale=1">


	<link rel="stylesheet" href="css/normalize.css">
	<link rel="stylesheet" href="css/skeleton.css">

    <script src="js/jquery-min.js"></script>
    <link href="css/select2.min.css" rel="stylesheet">
        <script src="js/select2.min.js"></script>


	<link rel="icon" type="image/png" href="favicon.png">

    <script type="text/javascript">
$(document).ready(function() {
  $(".js-basic-single1").select2({
  placeholder: "Select a Customer"
});

$(".js-basic-single").select2();
});

</script>

</head>

<body>

		        <style>
            @-webkit-keyframes loading {
                25% {
                    fill: #c6c7ca;
                }
                50% {
                    fill: #049fd9;
                }
                75% {
                    fill: #c6c7ca;
                }
            }

            @keyframes loading {
                25% {
                    fill: #c6c7ca;
                }
                50% {
                    fill: #049fd9;
                }
                75% {
                    fill: #c6c7ca;
                }
            }

            .logo {
                width: 120px;
                fill: #c6c7ca;
            }

            .logo__mark>path {
                -webkit-animation: loading 1.25s ease-in-out infinite reverse;
                animation: loading 1.25s ease-in-out infinite reverse;
            }

            .logo__mark>path:nth-child(1) {
                -webkit-animation-delay: 0.1s;
                animation-delay: 0.1s;
            }

            .logo__mark>path:nth-child(2) {
                -webkit-animation-delay: 0.2s;
                animation-delay: 0.2s;
            }

            .logo__mark>path:nth-child(3) {
                -webkit-animation-delay: 0.3s;
                animation-delay: 0.3s;
            }

            .logo__mark>path:nth-child(4) {
                -webkit-animation-delay: 0.4s;
                animation-delay: 0.4s;
            }

            .logo__mark>path:nth-child(5) {
                -webkit-animation-delay: 0.5s;
                animation-delay: 0.5s;
            }

            .logo__mark>path:nth-child(6) {
                -webkit-animation-delay: 0.6s;
                animation-delay: 0.6s;
            }

            .logo__mark>path:nth-child(7) {
                -webkit-animation-delay: 0.7s;
                animation-delay: 0.7s;
            }

            .logo__mark>path:nth-child(8) {
                -webkit-animation-delay: 0.8s;
                animation-delay: 0.8s;
            }

            .logo__mark>path:nth-child(9) {
                -webkit-animation-delay: 0.9s;
                animation-delay: 0.9s;
            }

			</style>

                                    <style>

                         .select2-dropdown {
                             border: 1px solid #eee;
                            /*margin-left: 12px;*/
                            margin-bottom: 15px;


                         }
                         .select2-container--default .select2-selection--single {
                            border: 1px solid #eee;
                            /*margin-left: 12px;*/
                            margin-top: 6px;
                            margin-bottom: 15px;
                         }
                            .js-basic-single {
                              border: 0 !important;
                            }



                        .select2-container--default .select2-selection--single .select2-selection__arrow {
                        top: 6px; }

                        .removecolor {
                            background: red !important;
                            color: white !important;
                            border-color: red !important;
                            margin: 5px !important;
                        }
                        </style>

<div class="container u-max-full-width">
        <div class="row" style="padding-top:15px;">
          <!--div style="display:inline-block;">
            <span style="margin-top:5px;color:grey;">Made by folks just like you. ;)</span>
          </div-->
          <div class="four columns">
          <a href="javascript:;" class="button" style="display:inline-block;border: 0; border-bottom: 1px solid #212121; padding: 0;" onclick="window.close();">&#x2716; &nbsp; Close this tab</a>
          </div>
          <div class="eight columns" style="float:right;">
          <div style="float:right;display:inline-block;">
              <span>Welcome, '.$qmcec.'</span>
              <span>
                  <form method="POST" action="case.php" style="margin: 0; padding-left: 20px; display:inline-block;">
                    <input type="submit" value="Logout &#x21b7;" name="logout" style="border: 0; border-bottom: 1px solid #212121;padding: 0;"/>
                  </form>
              </span>
              <span><a href="about.html" target="_blank" class="button" style="border: 0; border-bottom: 1px solid #212121;padding: 0;margin-left:40px;">Developers &nbsp; 👨‍💻</a></span>
              <span><a href="mailto:amasarda@cisco.com;%20svenkatt@cisco.com;%20gkotapal@cisco.com&cc=tdominic@cisco.com;%20sribabu@cisco.com?subject=QM%20Feedback%20on%20the%20TAM%20Tool" class="button" style="border: 0; border-bottom: 1px solid #212121;padding: 0;margin-left:40px;">Give Feedback <span style="font-size:large;">&#x263a;</span></a></span>
          </div>
          </div>
        </div>
      </div>

	<div class="container u-max-full-width">
		<div class="row" style="margin-top: 1%;">
                <div class="twelve columns bg-this">
                    <a href=""><svg class="img-responsive logo" style="max-width: 185px;" x="0px" y="0px" width="200.1px" height="105.4px" viewBox="-305 291.9 200.1 105.4">
  <g class="logo__mark">
    <path d="M-296.2,324.6c0-2.4-2-4.3-4.4-4.3s-4.4,1.9-4.4,4.3v9.1c0,2.4,2,4.4,4.4,4.4s4.4-1.9,4.4-4.4V324.6z"/>
    <path transform="translate(97.7633,748.5409)" d="M-370.1-435.9c0-2.4-2-4.3-4.4-4.3c-2.4,0-4.4,1.9-4.4,4.3v21.1c0,2.4,2,4.3,4.4,4.3c2.4,0,4.4-1.9,4.4-4.3V-435.9z"/>
    <path transform="translate(106.3727,754.4384)" d="M-354.8-458.2c0-2.4-2-4.3-4.4-4.3s-4.4,1.9-4.4,4.3v46.1c0,2.4,2,4.4,4.4,4.4s4.4-1.9,4.4-4.4V-458.2z"/>
    <path transform="translate(114.9821,748.5409)" d="M-339.5-435.9c0-2.4-2-4.3-4.4-4.3c-2.4,0-4.4,1.9-4.4,4.3v21.1c0,2.4,2,4.3,4.4,4.3c2.4,0,4.4-1.9,4.4-4.3V-435.9z"/>
    <path transform="translate(123.5817,744.2304)" d="M-324.2-419.6c0-2.4-1.9-4.3-4.3-4.3c-2.4,0-4.4,1.9-4.4,4.3v9.1c0,2.4,2,4.4,4.4,4.4c2.4,0,4.3-1.9,4.3-4.4V-419.6z"/>
    <path transform="translate(132.195,748.5409)" d="M-308.9-435.9c0-2.4-1.9-4.3-4.3-4.3s-4.3,1.9-4.3,4.3v21.1c0,2.4,1.9,4.3,4.3,4.3s4.3-1.9,4.3-4.3 C-308.9-414.8-308.9-435.9-308.9-435.9z"/>
    <path transform="translate(140.8102,754.4384)" d="M-293.6-458.2c0-2.4-1.9-4.3-4.3-4.3s-4.3,1.9-4.3,4.3v46.1c0,2.4,1.9,4.4,4.3,4.4s4.3-1.9,4.3-4.4V-458.2z"/>
    <path transform="translate(149.4235,748.5409)" d="M-278.3-435.9c0-2.4-1.9-4.3-4.4-4.3c-2.4,0-4.3,1.9-4.3,4.3v21.1c0,2.4,1.9,4.3,4.3,4.3c2.5,0,4.4-1.9,4.4-4.3 C-278.3-414.8-278.3-435.9-278.3-435.9z"/>
    <path transform="translate(158.0192,744.2304)" d="M-263-419.6c0-2.4-1.9-4.3-4.3-4.3s-4.3,1.9-4.3,4.3v9.1c0,2.4,1.9,4.4,4.3,4.4s4.3-1.9,4.3-4.4V-419.6z"/>
  </g>
  <g class="logo__type">
    <path transform="translate(102.0426,727.2001)" d="M-362.5-355.3c-0.4-0.2-3.2-1.9-7.4-1.9c-5.7,0-9.6,3.9-9.6,9.3c0,5.2,3.8,9.3,9.6,9.3c4.1,0,7-1.6,7.4-1.8v9.3 c-1.1,0.3-4.1,1.2-8,1.2c-9.9,0-18.5-6.8-18.5-18c0-10.4,7.8-18,18.5-18c4.1,0,7.2,1,8,1.2V-355.3z"/>
    <path d="M-239.7,396.7h-8.8v-34.8h8.8V396.7z"/>
    <path transform="translate(121.5124,727.9413)" d="M-327.9-358.1c-0.1,0-3.8-1.1-6.9-1.1c-3.5,0-5.4,1.2-5.4,2.8c0,2.1,2.6,2.9,4,3.3l2.4,0.8c5.7,1.8,8.3,5.7,8.3,9.9 c0,8.7-7.7,11.7-14.4,11.7c-4.7,0-9-0.9-9.5-1v-8c0.8,0.2,4.4,1.3,8.3,1.3c4.4,0,6.4-1.3,6.4-3.2c0-1.8-1.7-2.8-3.9-3.5 c-0.5-0.2-1.3-0.4-1.9-0.6c-4.9-1.5-9-4.4-9-10.2c0-6.5,4.9-10.9,12.9-10.9c4.3,0,8.3,1,8.5,1.1v7.6H-327.9z"/>
    <path transform="translate(134.9958,727.2001)" d="M-303.9-355.3c-0.4-0.2-3.2-1.9-7.4-1.9c-5.7,0-9.6,3.9-9.6,9.3c0,5.2,3.8,9.3,9.6,9.3c4.1,0,7-1.6,7.4-1.8v9.3 c-1.1,0.3-4.1,1.2-8,1.2c-9.9,0-18.5-6.8-18.5-18c0-10.4,7.8-18,18.5-18c4.1,0,7.2,1,8,1.2V-355.3z"/>
    <path transform="translate(144.9274,727.8212)" d="M-286.3-357.7c-5.2,0-9.1,4.1-9.1,9.1c0,5.1,3.9,9.1,9.1,9.1s9.1-4.1,9.1-9.1S-281.1-357.7-286.3-357.7 M-267.9-348.5 c0,9.9-7.7,18-18.4,18s-18.4-8.1-18.4-18s7.7-18,18.4-18S-267.9-358.4-267.9-348.5"/>
  </g>
</svg>
</a>
                <div style="display:inline-block;float:right;">
                    <h4 style="font-weight:normal; margin-bottom: 0px;">Cisco Managed Services</h4>
                    <h5 style="font-weight:lighter;float:right;">Server Time: '.gmdate('h:i').' UTC  <span style="font-style:italic;">Shift: '.$shift.' </span></h5>
                </div>
            </div>
        </div>
		<div class="row" style="margin-top:2%">
				<!-- <div class="five columns">
				<p>
				 -->
					<!-- <form method="POST" action="edit.php"> -->
						<!-- <div class="field half tb" style="width: 60%;"> -->
							<!--label for="Search"--><!--/label-->
							<!--input type="text" id="search" name="pkid" required style="padding: .5rem 2rem 0.1rem;" /-->
						<!-- </div><br/></br><br></br> -->
						     <!--input class="button-primary" type="submit" name="search" value="Search"-->
				<!-- 	</form>
					<div class="nav">
 -->
						<!--<a href="case.php" style="padding-left:0px;">Open a New Case</a>
						<a href="index.php" style="border-right: 0px;">Logout</a>
						<br />
						<br /> Server Time: <span id="servertime"></span>
						<br /> Local Time: <span id="localt"></span>-->
<!-- 					</div>
				</p>
 -->
			<!-- </div> -->
			<div class="twelve columns">
				<h4 style="font-weight:bolder;display: inline-block;">Re-Assign Cases</h4>
                <form action="reject.php" method="POST" style="float:right;display:inline-block;margin:0!important;margin-bottom:15px!important;">
                    <input type="submit" name="delete" class="button removecolor" value="Delete This Case" style="margin:0!important;"/>
                    <input type="hidden" name="pkid" value="'.$main_pkid.'"/>
                    <input type="hidden" value="'.$type.'" name="type" />
                                                <input type="hidden" value="'.$engcec.'" name="engcec" />
                 </form>
				<hr />
				<form method="POST" action="reject.php">

					<div class="half" style="margin-bottom: 1em;">
						<label for="" style="font-size: 1.2rem;padding: 1.5rem 2rem 0;text-transform: uppercase;color: #999;font-weight: 700;letter-spacing: 1px;">Map/Customer</label>
						<select class="js-basic-single1" id="customers" name="customer" style="border-radius:0px!important; width:30%;">
							<option selected   value="' . $cust . '" required>'.$cust.'</option>
';
                                                  $sqlcust="SELECT * FROM CUSTOMER;";
                                                    $resultcust=mysqli_query($conn,$sqlcust);

                                                    if(mysqli_num_rows($resultcust)==1){
                                                        $rowc=mysqli_fetch_assoc($resultcust);
                                                        echo "<option value='".$rowc["CUSTOMER"]."' selected>".$rowc["CUSTOMER"]."</option> ";
                                                    }
                                                    else{
                                                    while($rowc=mysqli_fetch_assoc($resultcust)){
                                                      echo "<option value='".$rowc["CUSTOMER"]."'>".$rowc["CUSTOMER"]."</option> ";
                                                   }
                                                    }
                                                    echo '
						</select>
					</div>
                    <div class="field tb">
                        <label for="Case Number/Email Subject">Reason for Rejection</label>
                        <input type="text" id="cNum" name="reason" value="' .stripslashes($reason). '" required readonly />
                    </div>
					<div class="field tnb">
						<label for="Case Number/Email Subject">Case Number/Email Subject</label>
						<input type="text" id="cNum" name="casen" value="' .$casename. '" required />
					</div>
					<div class="field half tnb">
						<label for="name">QM CEC ID</label>
						<input type="text" id="qID" value="' . $qmcec . '" required readonly />
					</div>
					<div class="field half tnb last">

						<label for="eID">Engineer CEC ID</label>
						<input type="text" id="eID" value="' . $engcec . '" name="engc" required />
					</div>
					<div class="field half tnb">
						<label for="datetime">Date &amp; Time of Rejection</label>
						<input type="text" id="datetime" value="' . $date . '" readonly required />

					</div>
					<div class="field half last tnb">
						<label for="pkid">PKID</label>
						<input type="text" id="pkID" value="'.$main_pkid.'" required readonly />
						<input type="hidden" value="'.$main_pkid.'" name="main_pkid" />

					</div>
                    <input type="hidden" name="pkid" value="'.$main_pkid.'"/>
                    <input type="hidden" value="'.$type.'" name="type" />
                                                <input type="hidden" value="'.$engcec.'" name="engcec" />



					<input class="button-primary" type="submit" name="Edit" value="Re-assign & Move to Next">
					<input class="button" type="submit" name="skip" value="Skip case & Move to Next">
				</form>


			</div>
		</div>
	</div>



</body>

</html>';
}
else{
    header("Location: forbidden.html");
}
ob_end_flush();
?>
