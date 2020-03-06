<?php session_start();
ob_start();
require('connect-hsbc.php');
require('spark.php');
if(!isset($_SESSION["eng"])){
  header("Location:forbidden.html");
}
else{

    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    } else {
    }
  $engcec=$_SESSION["eng"];
date_default_timezone_set('Asia/Kolkata');
//var_dump($_POST);
$shift="";
$sqlshift="SELECT SHIFT FROM CASES WHERE ENG_CEC='$engcec' ORDER BY PKID DESC";
$res=$conn->query($sqlshift);
$rowsh=mysqli_fetch_assoc($res);
$shift=$rowsh["SHIFT"];

if(isset($_POST["Dispatch"])){
    //var_dump($_POST);
    $zone=$_POST["zone"];
    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    } else {
    }
    if($_POST["ho_type"]=="Cold"){
      $type=$_POST["ho_type"];
      $dtdis=$_POST["dtdis"];
      $dtdis=str_replace("T", " " , $dtdis);
      $dtdis=$dtdis.":00";
      $datedis=date_create_from_format('Y-m-d H:i:s', $dtdis);
      if($zone=="IST"){
          $dtdis=$datedis->format('Y-m-d H:i:s');
      }
      else if($zone=="ET"){
          $toadd = new DateInterval('PT10H30M');
          $datedis->add($toadd);
          $dtdis=$datedis->format('Y-m-d H:i:s');
           //echo $dtdis;browser.notifications.clear('reddy_notif');
      }
      else if($zone=="CST"){
          $toadd = new DateInterval('PT11H30M');
          $datedis->add($toadd);
          $dtdis=$datedis->format('Y-m-d H:i:s');
          //echo $dtdis;
      }
      else{
          $toadd = new DateInterval('PT04H30M');
          $datedis->add($toadd);
          $dtdis=$datedis->format('Y-m-d H:i:s');
          //echo $dtdis;
      }

      $distime= date('H:i:s',strtotime($dtdis));
      //echo $distime;
      if($distime>='07:00:00' && $distime<'14:00:00'){
         $next="A";
      }
      else if($distime>='14:00:00' && $distime<'20:00:00'){
         $next="B";
      }
      else if($distime>='20:00:00' || $distime<'02:00:00'){
        $next="C";
      }
      else if($distime>='02:00:00' && $distime<'07:00:00'){
       $next="D";
     }
     //echo $next;

    }
    else{
      $dtdis=date('Y-m-d H:i:s');
      $type=$_POST["ho_type"];
      if($shift=="A"){
        $next="B";
      }
      else if($shift=="B"){
        $next="C";
      }
      else if($shift=="C"){
        $next="D";
      }
      else{
        $next="A";
      }
//var_dump($shift);
//var_dump($next);

    }

    $casenum=$_POST["casen"];
    $customer=$_POST["customer"];
    $priority=$_POST["case_type"];
    $dtsubmit=date('Y-m-d H:i:s');
    $today=date("Y-m-d");
    $summary=$_POST["summary"];
    $curr=$_POST["curr"];
    $nextact=$_POST["next"];
    $previous=$_POST["previous"];
    $descr=$_POST["descr"];
    $reason=$_POST["reason"];
    $ci=$_POST["ci"];
    $incref=$_POST["pkid"];

    $sql = "INSERT INTO HANDOFF VALUES('$incref', '$casenum','$customer','$engcec','$type','$priority','$shift','$next','$descr','$reason','$ci','$dtsubmit','$dtdis','$summary','$previous','$curr','$nextact','');";
    //echo $sql;
    // $sqlcount="UPDATE C_ENG SET DISPATCH=DISPATCH+1 WHERE CEC='$engcec';";
    // $sqlt="UPDATE T_ENG SET DISPATCH=DISPATCH+1 WHERE CEC='$engcec' AND DATES='$today' AND SHIFT='$shift';";

    if ($conn->query($sql)) {
      // if($conn->query($sqlcount)){
      //   if($conn->query($sqlt)){

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
            <span style='display:inline-block; vertical-align: super;margin-left: 10px;'>Dispatched!</span>
        </div>
        ";

         $mes = sparkMessage("Hand Off #: $casenum\nType of Handoff: $type \nPriority: $priority\nCurrent Shift:$shift \nNext Shift: $next\nReason For Handoff: $reason \nAffected Device(Name and IP): $ci\nIssue Description: $descr\nCurrent status Summary: $summary\nSteps Taken in previous shift:$previous\nSteps Taken from Current Shift:$curr\nCMS Next steps:$nextact","roomname");
         var_dump( $mes);
        //header("Location: reject.php");
    // }
    // }
  }
     else {
        echo "<div style='text-align:center;margin-top:10px; padding-bottom:10px; border-bottom:2px solid crimson;'>Error updating record. </div>" . $conn->error;
    }


  }





echo '

<!DOCTYPE html>
<html lang="en">

<head>


	<meta charset="utf-8">
	<title>Handoff &amp; Scheduled Dispatch - TAM Tool &middot; Cisco CMS</title>
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

            .switch {
  position: relative;
  display: block;
  width: 60px;
  height: 34px;
  float:left;
  margin-bottom:40px;
}

.switch input {display:none;}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}

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
              <span>Welcome, '.$engcec.' </span>
              <span>
                  <form method="POST" action="enigneer.php" style="margin: 0; padding-left: 20px; display:inline-block;">
                    <input type="submit" value="Logout &#x21b7;" name="logout" style="border: 0; border-bottom: 1px solid #212121;padding: 0;"/>
                  </form>
              </span>
              <span><a href="about.html" target="_blank" class="button" style="border: 0; border-bottom: 1px solid #212121;padding: 0;margin-left:40px;">Developers &nbsp; 👨‍💻</a></span>
              <span><a href="mailto:amasarda@cisco.com;%20svenkatt@cisco.com;%20gkotapal@cisco.com&cc=tdominic@cisco.com;%20sribabu@cisco.com?subject=Engineer%20Feedback%20on%20the%20TAM%20Tool" class="button" style="border: 0; border-bottom: 1px solid #212121;padding: 0;margin-left:40px;">Give Feedback <span style="font-size:large;">&#x263a;</span></a></span>
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
			<!-- <div class="twelve columns">
				<h4 style="font-weight:bolder;display: inline-block;">Handoff Cases</h4>
                <form action="reject.php" method="POST" style="float:right;display:inline-block;margin:0!important;margin-bottom:15px!important;">
                    <input type="submit" name="delete" class="button removecolor" value="Delete This Case" style="margin:0!important;"/>
                    <input type="hidden" name="pkid" />
                    <input type="hidden"  name="type" />
                                                <input type="hidden"  name="engcec" />
                 </form>
				<hr style="margin-top:0;"> -->

        <div class="twelve columns">
            <h4 style="font-weight:bolder;">Handoff a Case</h4>
            <hr>
        </div>

				<form method="POST" action="dispatch-hsbc.php">

        <!--div id="chepura" class="row u-max-full-width" style="display:inline-block;">
                        <h5 style="display: block;">
                        <span id="chesta"><span style="font-weight:normal">Handoff</span> a Case</span>
                        <label class="switch" style="margin-right: 25px; margin-top: 3px;">

                          <input id="checkpaninga" name="status" type="checkbox">
                          <div class="slider round"></div>

                        </label>

                        </h5>



          </div-->



<div class="row">



                <div style="margin-bottom:1em;">
                    <label for="" style="font-size: 1.2rem;padding: 1.5rem 2rem 0;text-transform: uppercase;color: #999;font-weight: 700;letter-spacing: 1px;">Select a Case Type</label>
                    <input type="radio" id="auto" name="case_type" value="Auto"><span style="padding:0 20px 0 7px;">Auto/ESR</span>
                    <input type="radio" id="man1" name="case_type" value="Manual P1/P2"><span style="padding:0 20px 0 7px;">Manual P1/P2</span>
                    <input type="radio" id="man2" name="case_type" value="Manual P3/P4"><span style="padding:0 20px 0 7px;">Manual P3/P4</span>

                  </div>

                  <div style="margin-bottom:1em;">
                      <label for="" style="font-size: 1.2rem;padding: 1.5rem 2rem 0;text-transform: uppercase;color: #999;font-weight: 700;letter-spacing: 1px;">Select a Handoff Type</label>
                      <input type="radio" id="warm" name="ho_type" value="Warm"><span style="padding:0 20px 0 7px;">Warm</span>
                      <input type="radio" id="hot" name="ho_type" value="Hot"><span style="padding:0 20px 0 7px;">Hot</span>
                      <input type="radio" id="cold" name="ho_type" value="Cold"><span style="padding:0 20px 0 7px;">Cold</span>

                    </div>

					<div class="six columns" style="margin-bottom: 1em;margin-left:0;">
						<label for="" style="font-size: 1.2rem;padding: 1.5rem 2rem 0;text-transform: uppercase;color: #999;font-weight: 700;letter-spacing: 1px;">Map/Customer</label>
						<select class="js-basic-single1" id="customers" name="customer" style="border-radius:0px!important; width:30%;" required>
							<option selected   ></option>
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

          <div id="hidethis" class="six columns" style="display:none;margin-bottom: 1em;">
          <!-- <div class="field tb"> -->
          <label for="" style="font-size: 1.2rem;padding: 1.5rem 2rem 0;text-transform: uppercase;color: #999;font-weight: 700;letter-spacing: 1px;">Date/Time of Scheduled Dispatch</label>

                    <select id="timezones" name="zone" style="border: 1px solid #eee; padding: 4px 5px;">
          <option value="" selected>Select Timezone</option>
          <option value="IST">IST (GMT +5.5)</option>
          <option value="KRK">CEST/KRK (GMT +2)</option>
          <option value="ET">Eastern (GMT -4)</option>
          <option value="CST">Central (GMT -5)</option>
          </select>

          <input type="datetime-local" id="gokota" name="dtdis" style="border: 1px solid #eee; padding: 3px 5px;" disabled>

          <input type="datetime-local" id="krk-time" name="krktime" style="display:none;">
          <input type="datetime-local" id="est-time" name="esttime" style="display:none;">
          <input type="datetime-local" id="cst-time" name="cttime" style="display:none;">




          <!-- </div> -->

<!-- <input type="datetime" required style="display:"> -->
          </div>
          </div>
                    <!-- <div class="field tb">
                        <label for="Case Number/Email Subject">Reason for Handoff/Action Plan</label>
                        <input type="text" id="cNum" name="reason" required />
                    </div> -->

					<div class="field half tb">
						<label for="casen">Case/Incident Number</label>
						<input type="text" id="cNum" name="casen" required />
					</div>

          <div class="field half tb last">
						<label for="refr">Reference PKID</label>
						<input type="text" id="refr" name="pkid" onblur="checkPKID();"/>
					</div>

          <div class="field tnb">
						<label for="descr">Issue Description</label>
						<input type="text" id="descr" name="descr" required />
					</div>

          <div class="field half tnb">
						<label for="reason">Reason for Handoff</label>
						<input type="text" id="reason" name="reason" required />
					</div>

          <div class="field half tnb last">
						<label for="ci">Affected Device/CI - Hostname & IP</label>
						<input type="text" id="ci" name="ci" required />
					</div>

          <div class="field half tnb">
            <label for="eID">Engineer CEC ID</label>
            <input type="text" id="eID" name="engc" value="'.$engcec.'" required />
          </div>

          <div class="field half tnb last">
            <label for="datetime">Current Date &amp; Time (IST)</label>
            <input type="text" id="datetime" name="dt_submit" value="'.date('Y-m-d H:i:s').'" required />
          </div>

          <div class="field tnb">
						<label for="summary">Current Issue Summary</label>
						<textarea style="resize:none;" id="summary" name="summary" placeholder="Please clearly elaborate impact/urgency and work done on the ticket so far" name="summary" ></textarea>
					</div>

          <div class="field tnb">
						<label for="summary">Steps Taken in Previous Shift</label>
						<textarea style="resize:none;" id="previous" name="previous" placeholder="Will be automatically populated if you have used a Reference PKID above" name="previous" ></textarea>
					</div>

          <div class="field tnb">
						<label for="curr">Steps Taken in Current Shift</label>
						<textarea style="resize:none;" placeholder="Please clearly mention all actions carried out in addition to the previous shift\'s work" name="curr" required></textarea>
					</div>

          <div class="field tnb">
						<label for="next">CMS Next Steps</label>
						<textarea style="resize:none;" placeholder="Please clearly document next Action Plan/Course of Action" name="next" required></textarea>
					</div>


					<!-- <div class="field half last tnb">
						<label for="pkid">PKID</label>
						<input type="text" id="pkID"  required readonly />
						<input type="hidden"  name="main_pkid" />
					</div>
                    <input type="hidden" name="pkid" />
                    <input type="hidden"  name="type" /> -->


					<input class="button-primary" type="submit" name="Dispatch" value="Submit">
					<!-- <input class="button" type="submit" name="skip" value="Skip case & Move to Next"> -->

				</form>


			</div>
		</div>
	</div>



</body>

</html>';
}

?>

<script type='text/javascript'>


      $(window).keydown(function(event){
    if((event.which== 13) && ($(event.target)[0]!=$('textarea')[0])) {
      event.preventDefault();
      return false;
    }
  });

</script>
<script>

        $('#checkpaninga').click(function() {
  if ($(this).is(':checked')) {
    $('#chesta').html('<span style=\'font-weight:normal\'>Scheduled Dispatch</span> a Case');
  } else {
    $('#chesta').html('<span style=\'font-weight:normal\'>Handoff</span> a Case');
  }
});
        </script>

         <script>
        $('input:radio').change(function() {
            if($('input#cold').is(':checked')) {
              $('#hidethis').show();
              $('#gokota').attr('required', 'required');
              $('#timezones').attr('required', 'required');
              console.log('Imma checked');
            }
             else {
              $('#hidethis').hide();
              $('#gokota').removeAttr('required');
              console.log('Imma unchecked');
            }
        });


        </script>

<script>
function checkPKID() {
  var refrpkid = $("#refr").val();
  console.log(refrpkid);

  $.ajax({
    type: "GET",
    url: "test.php?gethandoff="+refrpkid,
    success: function(data) {
      //Populate all entries here
      var hand =JSON.parse(data);
      $("#cNum").val(hand["CASE_NUM"]);
      $("#descr").val(hand["DESCRIPTION"]);
      $("#ci").val(hand["DEVICE"]);
      var cur=hand["ACTION"];
      var all=hand["PREVIOUS"]+"\n\n"+cur;
      //console.log(all);
      $("#previous").val(all);
      $("#summary").val(hand["SUMMARY"]);
      if(hand["TYPE"]=="Warm")
      $("#warm").prop("checked","true");
      else if(hand["TYPE"]=="Cold") {
          $("#cold").prop("checked","true");
      }
      else {
          $("#hot").prop("checked","true");
      }
      if(hand["PRIORITY"]=="Auto/ESR")
      $("#auto").prop("checked","true");
      else if(hand["PRIORITY"]=="Manual P1/P2") {
          $("#man1").prop("checked","true");
      }
      else {
          $("#man2").prop("checked","true");
      }
      console.log(hand);
    }
  });
}
</script>

<script>

    $('#timezones').change(function() {
        var timezoneval = $(this).find('option:selected').val();

        if (timezoneval == "") {
            $('#gokota').attr('disabled', 'disabled');
        }
        else {
            $('#gokota').removeAttr('disabled', 'disabled');
        }
    });





//
//$('#timezones, #gokota').on("change", function(){
//    var timezoneval = $(this).find('option:selected').val();
//
//
//    var thedate = $('#gokota').val();
//
//    $('#krk-time, #est-time, #cst-time').val(thedate);
//
//    console.log('Timezone: ', timezoneval);
//    console.log('Date: ', thedate);
//
//
//        if(timezoneval == "IST")
//            {
//                //IST - POST Natively
//                console.log('IST Time:', thedate);
//
//            }
//        else if(timezoneval == "KRK")
//            {
//                //KRK - If selected, subtract time and POST with hidden input krk-time -3.5
//                document.getElementById('krk-time').stepUp(210);
//                console.log('KRK Time in IST:', $('#krk-time').val());
//
//            }
//        else if(timezoneval == "ET")
//            {
//                //Eastern - If selected, subtract time and POST with hidden input est-time -9.5
//                document.getElementById('est-time').stepUp(570);
//                console.log('ET Time in IST:', $('#est-time').val());
//            }
//        else if(timezoneval == "CST")
//            {
//                //Central - If selected, subtract time and POST with hidden input cst-time -10.5
//                document.getElementById('cst-time').stepUp(630);
//                console.log('CT Time in IST:', $('#cst-time').val());
//
//            }
//});

</script>
<?php ob_end_flush(); ?>
