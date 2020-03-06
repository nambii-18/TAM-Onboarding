<?php
ob_start();
require('connect-hsbc.php');
error_reporting(0);
// ini_set('session.gc_maxlifetime', 60);
// session_set_cookie_params(60);
// var_dump(get_defined_vars());
session_start();
date_default_timezone_set('Asia/Kolkata');
if($_SESSION["eng"]!=NULL){
// $eng_cec=$_SESSION["eng"];
$eng_cec = 'ritaroy';
$added='';

//get the time from the db


if($conn->connect_error){
  die($conn->error);
}
//$sqlinstance="SELECT * FROM INSTANCE;";
//$resultinstance=$conn->query($sqlinstance);
//$row=mysqli_fetch_assoc($resultinstance);
$sql="select Time_Added from engineer where CEC = '$eng_cec'";
// $sql = "select Time_Added from engineer where CEC = ";
// $sql = "show databases";
    $result=mysqli_query($conn,$sql);
    // echo $result;

     if(!$result)
     {
      die("error in insertion!");
     }
     while($row=mysqli_fetch_assoc($result))
     {
       $added = $row['Time_Added'];
      //  echo "Added";
     }

        $string = 'eng';


setcookie("logintime",$added);//unavailable time logged into the cookie locally initially
$_COOKIE['logintime']=$added;

setcookie("state","Unavailable");//unavailable time logged into the cookie locally initially
$_COOKIE['state']="Unavailable";//overridden from the db
//
//set init
$pkid=0;
$case='';
$engid='';
$customer='';
$type="";
$state="";
$shift="";
 $days='';
 $hours='';
 $mins='';
//echo "Welcome, ".$_SESSION["eng"];
$cookie_name = "";
ob_start();
if(isset($_POST["logout"])){
  session_destroy();
  header("Location:index.php");
}


if(!isset($_COOKIE["notif_count"])) {//set if the cookie is not set
$engid1='';
$cookie_name = "notif_count";
$cookie_value = 0;
setcookie($cookie_name, $cookie_value); // make it 86400 = 1 day//
header("Location:engineerv1.0.php");
//var_dump($_COOKIE);
}
$currentTime=0;

if($conn->connect_error){
    die($connect->error);
}

//echo $eng_cec;

$sql_mycount="SELECT COUNT(*) as goutham from cases where ENG_CEC like '%$eng_cec%' and accept=0";
$result_mycount=mysqli_query($conn,$sql_mycount);

if($result_mycount){
while ($row_count=mysqli_fetch_assoc($result_mycount)){
    $case=$row_count["goutham"];

    }

    //echo $case;
    setcookie("num_cases",$case);
    $_COOKIE['num_cases']=$case;

  }

  else
  {
    echo "you have no cases";
  }


//header("Refresh: 60","Location:engineer.php");
if(isset($_POST["accept"])){
  //update the cookie value back to zero

    //OPTIMIZE ACCEPT

    if($_POST["op"]==1){
        $today=date("Y-m-d");
    $sql="UPDATE optimizes SET ACCEPT=1, DT_ACCEPT='".date( 'Y-m-d H:i:s')."', ENG_CEC='$eng_cec' WHERE PKID=".$_POST["pk"].";";
    $sqleng="UPDATE engineer SET P3P4=P3P4+1 WHERE CEC='".$eng_cec."'";
	$sqlt="UPDATE t_eng SET P3P4_COUNT=P3P4_COUNT+1 WHERE CEC='".$eng_cec."' AND DATES='$today';";
	$sqlc="UPDATE c_eng SET P3P4_COUNT=P3P4_COUNT+1 WHERE CEC='".$eng_cec."';";

        if($conn->query($sql)){
            $conn->query($sqleng);
            $conn->query($sqlt);
            $conn->query($sqlc);
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
            <span style='display:inline-block; vertical-align: super;margin-left: 10px;'>Case Accepted!</span>
        </div>


        ";
    }
    else{
        echo mysqli_error($conn);

    }

  }

    //OPERATE ACCEPT
    else{

    $cookie_name = "notif_count";
    $_COOKIE['notif_count']=0;
    setcookie("notif_count", $_COOKIE['notif_count']);
    //var_dump ($_POST['pk']);

    $sql="UPDATE cases SET ACCEPT=1, DT_ACCEPT='".date( 'Y-m-d H:i:s')."' WHERE PKID=".$_POST["pk"].";";
    $sql2="UPDATE cases SET DIFF_MIN=TIMESTAMPDIFF(MINUTE,DT_SUBMIT,DT_ACCEPT) WHERE PKID=".$_POST["pk"].";";
    if($conn->query($sql)){
        $conn->query($sql2);
        //echo "Success";
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
            <span style='display:inline-block; vertical-align: super;margin-left: 10px;'>Case Accepted!</span>
        </div>


        ";
    }
    else{
        echo mysqli_error($conn);

    }
}
}


echo '
<!DOCTYPE html>
<html lang="en">

    <head>


        <meta charset="utf-8">
        <title>Engineer Dashboard - TAM Tool &middot; Cisco CMS</title>
        <!-- <meta name="description" content="Quality Management Tool">
  <meta name="author" content="Cisco CMS"> -->


        <meta name="viewport" content="width=device-width, initial-scale=1">


        <link rel="stylesheet" href="css/normalize.css">
        <link rel="stylesheet" href="css/skeleton.css">
        <link rel="stylesheet" href="css/myfonts.css">

    <script src="js/jquery-min.js"></script>
    <script src="js/jquery.notify-better.min.js"></script>

        <link rel="shortcut icon" id="favicon" href="favicon.png">

    </head>
  ';
  echo "
   <script>

     function notifyMe(engid,num) {
         // Let's check if the browser supports notifications
         if (!(\"Notification\" in window)) {
             alert(\"This browser does not support desktop notification\");
         }

         // Let's check whether notification permissions have already been granted
         else if (Notification.permission === \"granted\") {
             // If it's okay let's create a notification
       console.log(engid);
       // alert('Hello');
             var options = {//object

                 body:engid.toString()+' has '+num+' case(s)',
                 icon: 'images/Cisco_notif.png'
             };
             var notification = new Notification(\"TAM Tool\",options);

             notification.onclick=function () {
                 console.log(this);
         //window.open('http://10.105.0.230:8080/QM/engineer.php','_self');
         window.focus();
             }
         }

         // Otherwise, we need to ask the user for permission
         else if (Notification.permission !== 'denied') {
             Notification.requestPermission(function (permission) {

                 // If the user accepts, let's create a notification
                 if (permission !== \"granted\") {
                 } else {
                     var options = {//object
                         body:engid+'has '+num+' cases',
                         icon: 'img/Cisco.png'
                     };
                     var notification = new Notification(\"TAM Tool\",options);

                     notification.onclick=function () {
                         console.log(this);
             //window.open('http://10.105.0.230:8080/QM/engineer.php','_self');
             window.focus();
                     }
                 }
             });
         }

         // At last, if the user has denied notifications, and you
         // want to be respectful there is no need to bother them any more.
     }

   if (!('autofocus' in document.createElement('input'))) {
    document.getElementById('search').focus();
  }



  var counter=0;
   </script>


";

echo '



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

/*For MODAL*/

.modal {
  position: fixed;
  left: 0;
  top: 0;
  right: 0;
  bottom: 0;
  background-color: rgba(0, 0, 0, 0.65);
  visibility: hidden;
  backface-visibility: hidden;
  opacity: 0;
  transition: opacity .15s ease-in-out;
}
.modal.modal-open {
  visibility: visible;
  backface-visibility: visible;
  opacity: 1;
  z-index: 1;
}
.modal .modal-inner {
  position: relative;
  height: 100%;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
}
.modal .modal-inner .modal-content {
  background-color: white;
  max-width: 50em;
  padding: 4em 5em;
  position: relative;
  margin: 2em;
  box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.35);
}
.modal .modal-inner .modal-content .modal-close-icon {
  position: absolute;
  right: 1.5em;
  top: 0em;
}
.modal .modal-inner .modal-content .modal-content-inner {
  padding-right: 2em;
}
.modal .modal-inner .modal-content .modal-content-inner h1, .modal .modal-inner .modal-content .modal-content-inner h2, .modal .modal-inner .modal-content .modal-content-inner h3, .modal .modal-inner .modal-content .modal-content-inner h4, .modal .modal-inner .modal-content .modal-content-inner h5, .modal .modal-inner .modal-content .modal-content-inner h6 {
  margin-bottom: 0.25em;
}
.modal .modal-inner .modal-content .modal-content-inner p {
  margin-bottom: 1em;
}
.modal .modal-inner .modal-content .modal-buttons-seperator {
  margin: 1.5em 0;
  margin-top: 0;
}
.modal .modal-inner .modal-content .modal-buttons {
  display: flex;
  flex-direction: row;
  justify-content: center;
  align-items: center;
}
.modal .modal-inner .modal-content .modal-buttons button {
  margin-left: 1em;
}
.modal .modal-inner .modal-content .modal-buttons button:first-child {
  margin-left: 0;
}

/* basic positioning */
.legend { list-style: none; }
.legend li { float: left; margin-right: 10px; }
.legend span { border: 1px solid #212121; float: left; width: 12px; height: 12px; margin: 2px; margin-right:7px;}
/* your colors */
.legend .superawesome { background-color: green; }
.legend .awesome { background-color: goldenrod; }
.legend .kindaawesome { background-color: red; }
.legend .notawesome { background-color: #000000; }
.legend .text { line-height: 15px;
    white-space: nowrap;
    margin-right: 35px;
    margin-bottom: 0px;}

/* style input field text */
/*::-webkit-input-placeholder {
  color: #fff;
  opacity: .8;
}*/

/* Input field that looks like a button */
.email-field {
  width: 80px;
  display: inline-block;
  color: #fff;
  background-color: #222;
  padding: .9em 1.8em;
  border: none;
  cursor: pointer;
  outline: none;
  border-radius: 4px;
  -webkit-transition: all .1s linear;
  transition: all .1s linear;
}

.email-field:hover {
  background-color: #333;
}

/* after button is clicked */
.email-field.active {
  width: 200px;
  outline: none;
  color: #efaa9d;
  text-align: left;
  cursor: inherit;
}

#open-modal-notice::before {
    content: "🔔   ";
    text-decoration-color: white;
    }

    #modal-content-notice {
      /*background: #1EAEDB;*/
    }


  @-webkit-keyframes pulse {
 0% {
 -webkit-transform: scale(1, 1);
}
 50% {
 -webkit-transform: scale(1.1, 1.1);
}
 100% {
 -webkit-transform: scale(1, 1);
};
}

@keyframes pulse {
 0% {
 transform: scale(1, 1);
}
 50% {
 transform: scale(1.1, 1.1);
}
 100% {
transform: scale(1, 1);
};
}

    .dingding {
    -webkit-animation: pulse 1s linear infinite;
  animation: pulse 1s linear infinite;
  background: crimson !important;
    border-color: crimson !important;
  }
  .dingding:hover {
  -webkit-animation: none;
  animation:none;
}


      </style>

      <div class="container u-max-full-width">
        <div class="row" style="padding-top:15px;">
          <!--div style="display:inline-block;">
            <span style="margin-top:5px;color:grey;">Made by folks just like you. ;)</span>
          </div-->


          <div class="five columns">

              ';

//make the sql query here
$sql_avail="SELECT * from engineer where CEC='$eng_cec'";
  $result_avail=$conn->query($sql_avail);
  $row=mysqli_fetch_assoc($result_avail);
  $state=$row['STATE'];
      setcookie("state",$state);
      $_COOKIE["state"]=$state;
if(mysqli_num_rows($result_avail)){

     if($row['STATE']=="Available")
     {
echo '

<div class="menu">
                <div class="menu_title">
                  Availability Status
                </div>
    <div class="menu_item tada">
      <input class="toggle" name="menu_group2" id="sneaky_togglea" type="radio" value="1" checked>
      <div class="expander">
        <label for="sneaky_togglea"><i class="menu_icon fa icon-ok-circled"></i> <span class="menu_text">All Cases</span></label>
      </div>
    </div>
    <div class="menu_item tada">
      <input class="toggle" name="menu_group2" id="sneaky_toggleb" type="radio" value="2" >
      <div class="expander">
        <label for="sneaky_toggleb"><i class="menu_icon menu_icon2 fa icon-attention-circled"></i> <span class="menu_text">Except Manual P1/P2</span></label>
      </div>
    </div>
    <div class="menu_item" id="lalaland">
      <input class="toggle" name="menu_group2" id="sneaky_togglec" type="radio" value="3">
      <div class="expander">
        <label for="sneaky_togglec"><i class="menu_icon menu_icon3 fa icon-minus-circled"></i> <span class="menu_text">Unavailable</span></label>
      </div>
    </div>
    <div id="heyu" style="display:none;position:relative;">
      <input type="text" value="" name="reason" class="email-field" id="reason" placeholder="Enter Reason for Unavailability" style="position: absolute;
    margin-top: 63px;
    margin-left: -170px;
    height: 45px;
    width: 285px;
    border-radius: 0;
    font-size: smaller;">

    <input required="required" id="chill" type="submit" name="go" value="Submit" style="    position: absolute;
    right: -119px;
    top: 43px;
    border: 0;
    font-size: smaller;
    color: #fff;
    background-color: #333;
    padding: 3px 13px;
    z-index: 99999999;">
    </div>
<!--     <div id="heyu" style="position: relative;display: none;">
      <input required="required" type="text" name="reason" class="email-field" id="reason" placeholder="Enter Reason for Unavailability" style="position: relative; width: 345px; border-radius: 0;  font-size: smaller; margin: 0; display: inline-block;">
          <input id="chill" type="submit" name="go" value="Submit" style="
    position: relative; font-size: smaller; color: #fff;    margin: 0; display: inline-block;
    border: 0; background: #222;">
    </div> -->
  </div>';
}
else if($row['STATE']=="Except Manual P1/P2")
{

  echo '

<div class="menu">
                <div class="menu_title">
                  Availability Status
                </div>
    <div class="menu_item tada">
      <input class="toggle" name="menu_group2" id="sneaky_togglea" type="radio" value="1" >
      <div class="expander">
        <label for="sneaky_togglea"><i class="menu_icon fa icon-ok-circled"></i> <span class="menu_text">All Cases</span></label>
      </div>
    </div>
    <div class="menu_item tada">
      <input class="toggle" name="menu_group2" id="sneaky_toggleb" type="radio" value="2" checked>
      <div class="expander">
        <label for="sneaky_toggleb"><i class="menu_icon menu_icon2 fa icon-attention-circled"></i> <span class="menu_text">Except Manual P1/P2</span></label>
      </div>
    </div>
    <div class="menu_item" id="lalaland">
      <input class="toggle" name="menu_group2" id="sneaky_togglec" type="radio" value="3">
      <div class="expander">
        <label for="sneaky_togglec"><i class="menu_icon menu_icon3 fa icon-minus-circled"></i> <span class="menu_text">Unavailable</span></label>
      </div>
    </div>
    <div id="heyu" style="display:none;position:relative;">
      <input  required="required" type="text" name="reason" class="email-field" id="reason" placeholder="Enter Reason for Unavailability" style="position: absolute;
    margin-top: 63px;
    margin-left: -170px;
    height: 45px;
    width: 285px;
    border-radius: 0;
    font-size: smaller;">

    <input id="chill" type="submit" name="go" value="Submit" style="       position: absolute;
    right: -119px;
    top: 43px;
    border: 0;
    font-size: smaller;
    color: #fff;
    background-color: #333;
    padding: 3px 13px;
    z-index: 99999999;">
    </div>
    <!-- <div id="heyu" style="position: relative;display: none;">
      <input required="required" type="text" name="reason" class="email-field" id="reason" placeholder="Enter Reason for Unavailability" style="position: relative; width: 345px; border-radius: 0;  font-size: smaller; margin: 0; display: inline-block;">
          <input id="chill" type="submit" name="go" value="Submit" style="
    position: relative; font-size: smaller; color: #fff;    margin: 0; display: inline-block;
    border: 0; background: #222;">
    </div> -->
  </div>';


}
else
{


echo '

<div class="menu">
                <div class="menu_title">
                  Availability Status
                </div>
    <div class="menu_item tada">
      <input class="toggle" name="menu_group2" id="sneaky_togglea" type="radio" value="1" >
      <div class="expander">
        <label for="sneaky_togglea"><i class="menu_icon fa icon-ok-circled"></i> <span class="menu_text">All Cases</span></label>
      </div>
    </div>
    <div class="menu_item tada">
      <input class="toggle" name="menu_group2" id="sneaky_toggleb" type="radio" value="2" >
      <div class="expander">
        <label for="sneaky_toggleb"><i class="menu_icon menu_icon2 fa icon-attention-circled"></i> <span class="menu_text">Except Manual P1/P2</span></label>
      </div>
    </div>
    <div class="menu_item" id="lalaland">
      <input class="toggle" name="menu_group2" id="sneaky_togglec" type="radio" value="3" checked>
      <div class="expander">
        <label for="sneaky_togglec"><i class="menu_icon menu_icon3 fa icon-minus-circled"></i> <span class="menu_text">Unavailable</span></label>
      </div>
    </div>
    <div id="heyu" style="display:none;position:relative;">
      <input required="required" type="text" name="reason" class="email-field" id="reason" placeholder="Enter Reason for Unavailability" style="position: absolute;
    margin-top: 63px;
    margin-left: -170px;
    height: 45px;
    width: 285px;
    border-radius: 0;
    font-size: smaller;">

      <input id="chill" type="submit" name="go" value="Submit" style="       position: absolute;
    right: -119px;
    top: 43px;
    border: 0;
    font-size: smaller;
    color: #fff;
    background-color: #333;
    padding: 3px 13px;
    z-index: 99999999;">
    </div>
<!--     <div id="heyu" style="position: relative;display: none;">
      <input required="required" type="text" name="reason" class="email-field" id="reason" placeholder="Enter Reason for Unavailability" style="position: relative; width: 345px; border-radius: 0;  font-size: smaller; margin: 0; display: inline-block;">
          <input id="chill" type="submit" name="go" value="Submit" style="
    position: relative; font-size: smaller; color: #fff;    margin: 0; display: inline-block;
    border: 0; background: #222;">
    </div> -->
  </div>';


}
}
else{
  echo '<h6 style="border-left: 7px solid crimson; padding-left: 11px; font-weight: normal; margin-top: 20px;">You are <span style="font-weight:bolder;">not</span> a part of the QM\'s Queue for this shift.</h6>';
}
//availability ends here
$sqlcount="SELECT * FROM c_eng WHERE CEC='$eng_cec';";
$result=mysqli_query($conn,$sqlcount);
$row=mysqli_fetch_assoc($result);
$count1=$row["NOTICE_COUNT"];
if($count1<0){
  $count1=0;
}
$shift="";
$sqlshift="SELECT SHIFT FROM engineer WHERE CEC='$eng_cec'";
$res=$conn->query($sqlshift);
$rowsh=mysqli_fetch_assoc($res);
$shift=$rowsh["SHIFT"];
echo'
          </div>
          <div class="seven columns" style="float:right;">
          <div style="float:right;">
              <span>Welcome, '.$eng_cec.'</span>
              <span>
                  <form method="POST" action="engineer.php" style="margin: 0; padding-left: 20px; display:inline-block;">
                    <input type="submit" value="Logout &#x21b7;" name="logout" style="border: 0; border-bottom: 1px solid #212121;padding: 0;"/>
                  </form>
              </span>
              <span><a href="about.html" target="_blank" class="button" style="border: 0; border-bottom: 1px solid #212121;padding: 0;margin-left:40px;">Developers &nbsp; 👨‍💻</a></span>
              <span><a href="mailto:amasarda@cisco.com;%20svenkatt@cisco.com;%20gkotapal@cisco.com&cc=tdominic@cisco.com;%20sribabu@cisco.com?subject=Engineer%20Feedback%20on%20the%20TAM%20Tool" class="button" style="border: 0; border-bottom: 1px solid #212121;padding: 0;margin-left:40px;">Give Feedback <span style="font-size:large;">&#x263a;</span></a></span>
              <button id="open-modal-notice" title="Click to view Notice Board." class="button" style="padding: 0px 15px; margin-left: 40px; background:green; border-color: green; color: white; font-size:large;font-weight: bolder; vertical-align: middle;">&nbsp;&nbsp;'.$count1.'</button>

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
</svg></a>
<!-- form method="POST" action="engineer.php">
<input type="submit" value="Logout" name="logout"/>
</form -->
        <div style="display:inline-block;float:right;vertical-align:middle;">
                    <h4 style="font-weight:normal; margin-bottom: 0px;">Cisco Managed Services</h4>
                    <h5 style="font-weight:lighter;float:right;">Server Time: '.gmdate('h:i').' UTC <span style="font-style:italic;">Shift:'.$shift.' </span></h5>

          <!-- Code for Pending Cases MODAL -->

          <div class="modal modal-close" id="modal-pending">
  <div class="modal-inner" id="modal-inner-pending">
    <div class="modal-content" id="modal-content-pending" style="overflow:auto">
      <div class="modal-close-icon">
        <a href="javascript:void(0)" class="close-modal"><i class="fa fa-times" aria-hidden="true"></i></a>
      </div>
      <div class="modal-content-inner">
<!--         <h4>This is the heading</h4> -->
        <form>
    <div class="field tb">
            <label for="Case Number/Email Subject">Filter By Engineer CEC</label>
            <input type="text" id="search" placeholder="Enter CEC Here" autofocus="autofocus"/>
          </div>
        </form>
        <table id="modaltable">
                        <thead>
                            <tr>
                                <th>Engineer CEC</th>
                                <th># of Pending Cases</th>
                            </tr>
                        </thead>';
            $sql1="SELECT ENG_CEC, COUNT(ENG_CEC) as NUM FROM cases WHERE ACCEPT=0 GROUP BY ENG_CEC;";
            $resultmodal=mysqli_query($conn,$sql1);
            while ($row=mysqli_fetch_assoc($resultmodal)){
              $eng=$row["ENG_CEC"];
              $num=$row["NUM"];
              echo'
                            <tr>
                                <td>'.$eng.'</td>
                                <td>'.$num.'</td>

                            </tr>
                            ';
            }
              echo '

                    </table>
      </div>
      <div class="modal-buttons">
        <button class="button button-primary close-modal" id="close-modal-pending">Close</button>
      </div>
    </div>
  </div>
</div>

          <!-- Code for  Time Spent MODAL -->

          <div class="modal modal-close" id="modal-time">
  <div class="modal-inner" id="modal-inner-time">
    <div class="modal-content" id="modal-content-time" style="overflow:auto;max-width:90em">
      <div class="modal-close-icon">
        <a href="javascript:void(0)" class="close-modal"><i class="fa fa-times" aria-hidden="true"></i></a>
      </div>
      <div class="modal-content-time">
        <h5 style="font-weight:bolder;">Engineer Statistics for Current Shift</h5>
        <hr>

        <table id="laale">
                        <thead>
                            <tr>
                                <th>Engineer CEC</th>
                                <th style="whitespace:nowrap;"># Auto/ESR Cases</th>
                                <th># P1/P2 Cases</th>
                                <th># P3/P4 Cases</th>
                                <th style="whitespace:nowrap;">Time Spent in Available (mins)</th>
                                <th style="whitespace:nowrap;">Time Spent in Except P1/P2 (mins)</th>
                                <th style="whitespace:nowrap;">Time Spent in Unavailable (mins)</th>
                                <th>Current State</th>
                                <th>Unavailable Reason</th>

                            </tr>
                        </thead>
                       ';

                            if($conn->connect_error){
                              die($conn->error);
                            }

                                  $sqlmodal="SELECT * FROM engineer e inner join t_eng t on e.dates=t.dates and t.cec=e.cec where t.DATES='".date("Y-m-d")."' ;";
                                  // echo $sqlmodal;
                                  $result2=mysqli_query($conn,$sqlmodal);
                                  while($row=mysqli_fetch_assoc($result2))
                                  {


                            echo"
                            <tr>
                                <td>".$row["CEC"]."</td>
                                <td>".$row["EA"]."</td>
                                <td>".$row["P1P2"]."</td>
                                <td>".$row["P3P4"]."</td>
                                <td>".$row["S1_TIME"]."</td>
                                <td>".$row["S2_TIME"]."</td>
                                <td>".$row["S3_TIME"]."</td>
                                <td>".$row["STATE"]."</td>
                                <td>".$row["REASON"]."</td>

                            </tr>";
                          }

                  echo '
                    </table>
      </div>
      <div class="modal-buttons">
        <button class="button button-primary close-modal" id="close-modal-time">Close</button>
      </div>
    </div>
  </div>
</div>





          </div>
                    <p>
                        <form>
                            <!-- <div class="field half tb" style="width: 60%;">
                                <label for="Search">Search</label>
                                <input type="text" id="search" required style="padding: .5rem 2rem 0.1rem;" />
                            </div> -->
                            <!-- <input class="button" type="submit" value="Search"> -->
                        </form>
                        <!-- <hr /> -->
                        <div class="nav">

                            <!-- <a href="case.html" style="padding-left:0px;">Open a New Case</a> -->
                            <!-- <br /><br /> Server Time: <span id="servertime"></span> -->
                        </div>
                    </p>
                </div>
        </div>
          <div class="row">
                <div class="four columns">

                    <h4 style="display: inline-block; font-weight:bolder;">Engineer Dashboard</h4>
                    </div>
                    <div class="eight columns">

          <input id="chepura" style="display:inline-block;float:right;margin-left:15px;padding: 7px;border:0; border-bottom: 1px solid #1EAEDB; margin-top: 3px;" type="text" placeholder="Filter By Engineer CEC"/>
<button style="float:right; margin-top: 0;border: 0; border-bottom: 1px solid #212121;padding: 0; margin-right:15px;" class="button" id="open-modal-pending">Pending Cases</button>
<!--button style="float:right; margin-top: 0;border: 0; border-bottom: 1px solid #212121;padding: 0; margin-right:15px;" class="button" id="open-modal-ass">Assigned Cases</button-->
<button style="float:right; margin-top: 0;border: 0; border-bottom: 1px solid #212121;padding: 0; margin-right:15px;" class="button" id="open-modal-time">Shift Statistics</button>

           <a href="caseview.php" target="_blank" class="button" style="float:right;margin-top: 0;border: 0; border-bottom: 1px solid #212121; padding: 0; margin-right:15px;">Historical Cases</a>
           <a href="reporter.php" target="_blank" class="button" style="float:right;margin-top: 0;border: 0; border-bottom: 1px solid #212121; padding: 0; margin-right:15px;">Reporting</a>
           <a href="dispatchlist.php" target="_blank" class="button" style="float:right;margin-top: 0;border: 0; border-bottom: 1px solid #212121; padding: 0; margin-right:15px;">Dispatched Cases</a>
           <a href="dispatch.php" target="_blank" class="button" style="float:right;margin-top: 0;border: 0; border-bottom: 1px solid #212121; padding: 0; margin-right:15px;">Handoff</a>
           <!-- a href="review.php" target="_blank" class="button" style="float:right;margin-top: 0;border: 0; border-bottom: 1px solid #212121; padding: 0; margin-right:15px;">Submit a Case for Review</a -->
                 </div>
                 </div>
                 <div class="row">
               Legend for text colors in the table: &nbsp;
               <ul class="legend" style="display:inline-flex;">
               <!-- Legend for text colors in the table: &nbsp; -->
                        <li><span class="superawesome"></span> <p class="text"> < 15 minutes old</p></li>
                        <li><span class="awesome"></span> <p class="text"> 15 - 30 minutes old</p></li>
                        <li><span class="kindaawesome"></span><p class="text"> > 30 minutes old</p></li>
                        <!-- li><span class="notawesome"></span> Not Awesome</li -->
                    </ul>

          </div>

          <hr style="margin-top:0" />
          <div class="row">
                <div class="twelve columns">
                    <table id="maintable" class="u-full-width">
                        <thead>
                            <tr>
                                <th>PKID</th>
                                <th>Case #/Email Subject</th>
                                <th>Customer</th>
                                <th>Case Type</th>
                                <th>Engg. CEC ID</th>
                                <th title="Engineer\'s state when the case was assigned to them.">State at Assignment</th>
                                <th>Time to Accept</th>
                                <th>Acknowledge</th>
                                <th>Reject</th>
                            </tr>
                        </thead>

            ';                                      $alerts=array();
                                                    $sqlcust="SELECT * FROM customer;";
                                                    $resultcust=mysqli_query($conn,$sqlcust);
                                                    while($rowc=mysqli_fetch_assoc($resultcust)){
                                                      $alerts[$rowc["CUSTOMER"]]=$rowc["ALERTS"];
                                                   }
 //BEGINING OF OPTIMIZE



$sqlo="SELECT * FROM optimizes WHERE ACCEPT=0 ORDER BY DT_SUBMIT DESC;";
$resulto=mysqli_query($conn,$sqlo);
while ($row=mysqli_fetch_assoc($resulto)){
    $case=$row["CASE_NUM"];
    $pkid=$row["PKID"];
    $customer=$row["CUSTOMER"];
    $accept=$row["ACCEPT"];

    $dt=$row["DT_SUBMIT"];
    $type="Manual P3/P4";
    $state="Optimize Case";
    $diff=date_diff(date_create_from_format('Y-m-d H:i:s', $dt),date_create_from_format('Y-m-d H:i:s',date( 'Y-m-d H:i:s') ));
    $dif=$diff->format('%d days %h:%i:%s');
  $day=$diff->d;
  $hour=$diff->h;
  $min=$diff->i;


    echo '
              <tbody>
              <tr class="bgrcolor">
                                <td>'.$pkid.'</td>
                                <td>'.$case.'</td>
                                <td>'.$customer.'</td>
                                <td>'.$type.'</td>
                                <td id="eng_id">'.$engid.'</td>
                                <td>'.$state.'</td>

                   <form action="engineer.php" method="POST" style="margin: 0; padding: 0;">

                   <td>'.$dif.'</td>
                   ';
                  echo '
                   <td><input class="button-primary" type="submit" name="accept" value="Acknowledge" onclick="passcust(this);"></td>
                   <input type="hidden" name="pk" value='.$pkid.'>
                   <input type="hidden" name="op" value="1">

                   </form>
                                      <td><input class="button-primary open-modal" type="button" name="reject" value="Reject" style="background-color:grey; border-color:grey" disabled></td>

                   <input type="hidden" name="pk" value='.$pkid.'>
                   </form></td>';


   if($day == 0)
  {
    if($hour == 0)
    {
      if($min <= 15)
      {
        echo'



        <script>

        document.getElementsByClassName("bgrcolor")[counter++].style.color="green";

        </script>

        ';
      }
      else if($min>15 && $min <=30)
      {

        echo'



        <script>

        document.getElementsByClassName("bgrcolor")[counter++].style.color="goldenrod";

        </script>

        ';

      }
      else{

        echo '

        <script>

        document.getElementsByClassName("bgrcolor")[counter++].style.color="red";


        </script>

        ';
      }
    }
    else
    {

      echo '

      <script>

        document.getElementsByClassName("bgrcolor")[counter++].style.color="red";
        //$("#maintable tbody tr").append("<td>&#11044;</td>");
        </script>

      ';
    }
  }
  else
  {
    echo '

    <script>

        document.getElementsByClassName("bgrcolor")[counter++].style.color="red";

        </script>

    ';
  }



}


// BEGINNING OF OPERATE

$sql="SELECT * FROM cases WHERE ACCEPT=0 ORDER BY DT_SUBMIT DESC;";
$sql1="SELECT ENG_CEC, COUNT(ENG_CEC) as NUM FROM cases WHERE ACCEPT=0 GROUP BY ENG_CEC;";
$resultmodal=mysqli_query($conn,$sql1);
$result=mysqli_query($conn,$sql);
$num=mysqli_num_rows($result);



while ($row=mysqli_fetch_assoc($result)){
    $case=$row["CASE_NUM"];
    $engid=$row["ENG_CEC"];
    $pkid=$row["PKID"];
    $customer=$row["CUSTOMER"];
    $accept=$row["ACCEPT"];
    $diffmin=$row["DIFF_MIN"];
    $dt=$row["DT_SUBMIT"];
    $type=$row["TYPE"];
    $state=$row["STATE"];
    $diff=date_diff(date_create_from_format('Y-m-d H:i:s', $dt),date_create_from_format('Y-m-d H:i:s',date( 'Y-m-d H:i:s') ));
    //ive put it in the beginning
    $dif=$diff->format('%d days %h:%i:%s');

  $day=$diff->d;
  $hour=$diff->h;
  $min=$diff->i;



    echo '
              <tbody>
              <tr class="bgrcolor">
                                <td>'.$pkid.'</td>
                                <td>'.$case.'</td>
                                <td>'.$customer.'</td>
                                <td>'.$type.'</td>
                                <td id="eng_id">'.$engid.'</td>
                                <td>'.$state.'</td>

                   <form action="engineer.php" method="POST" style="margin: 0; padding: 0;">

                   <td>'.$dif.'</td>
                   ';
                   if($engid==$eng_cec){
                  echo '
                   <td><input class="button-primary" type="submit" name="accept" value="Acknowledge" onclick="passcust(this);"></td>
                   <input type="hidden" name="pk" value='.$pkid.'>
                   <input type="hidden" name="op" value="0">
                   </form>
                   <td><form action="rejected.php" method="POST" target="_blank" style="margin: 0; padding: 0;">
                   <input class="button-primary removecolor open-modal" style="margin:20px 5px 1.5rem 0 !important;" type="submit" name="reject" value="Reject">
                   <input type="hidden" name="pk" value='.$pkid.'>
                   </form></td>';
                 }
                 else if($eng_cec=="admin"){
                    echo '
                   <td><input class="button-primary" type="submit" name="accept" value="Acknowledge"></td>
                   <input type="hidden" name="pk" value='.$pkid.'>
                   <input type="hidden" name="op" value="0">
                   </form>
                   <td><form action="rejected.php" method="POST" target="_blank" style="margin: 0; padding: 0;">
                   <input class="button-primary removecolor open-modal" style="margin:20px 5px 1.5rem 0 !important;" type="submit" name="reject" value="Reject">
                   <input type="hidden" name="pk" value='.$pkid.'>
                   </form></td>';
                 }
                 else{
                    echo '
                   <td><input class="button-primary" type="submit" name="accept" value="Acknowledge" style="background-color:grey; border-color:grey" disabled ></td>
                   <input type="hidden" name="pk" value='.$pkid.'>
                   <input type="hidden" name="op" value="0">
                   </form>
                   <form>
                   <td><input class="button-primary open-modal" type="button" name="reject" value="Reject" style="background-color:grey; border-color:grey" disabled></td>
                   <input type="hidden" name="pk" value='.$pkid.'>
                   </form>';
                 }

echo '
                  <div class="modal modal-close modal-rej" id="">
  <div class="modal-inner" id="modal-inner-rej">
    <div class="modal-content" id="modal-content-rej">
      <div class="modal-close-icon">
        <a href="javascript:void(0)" class="close-modal"><i class="fa fa-times" aria-hidden="true"></i></a>
      </div>
      <div class="modal-content-inner">
<!--         <h4>This is the heading</h4> -->

    </div>
  </div>
</div>';


    echo '


                            </tr>
            ';




   if($day == 0)
  {
    if($hour == 0)
    {
      if($min <= 15)
      {
        echo'



        <script>

        document.getElementsByClassName("bgrcolor")[counter++].style.color="green";

        </script>

        ';
      }
      else if($min>15 && $min <=30)
      {

        echo'



        <script>

        document.getElementsByClassName("bgrcolor")[counter++].style.color="goldenrod";

        </script>

        ';

      }
      else{

        echo '

        <script>

        document.getElementsByClassName("bgrcolor")[counter++].style.color="red";


        </script>

        ';
      }
    }
    else
    {

      echo '

      <script>

        document.getElementsByClassName("bgrcolor")[counter++].style.color="red";
        //$("#maintable tbody tr").append("<td>&#11044;</td>");
        </script>

      ';
    }
  }
  else
  {
    echo '

    <script>

        document.getElementsByClassName("bgrcolor")[counter++].style.color="red";

        </script>

    ';
  }






          }


            //cookie = 1
            $resultmodal1=mysqli_query($conn,$sql1);
              if($_COOKIE['notif_count']==1)
                {
                  while($row=mysqli_fetch_assoc($resultmodal1))
                  {
                    $engid1=$row["ENG_CEC"];
                    $num=$row["NUM"];
                    if($engid1==$eng_cec){
                    echo '
                    <script>
                     notifyMe("'.$engid1.'",'.$num.');
                    </script>
                    ';
                  }
                    }
                  ++$_COOKIE['notif_count'];
                  setcookie("notif_count", $_COOKIE['notif_count']);
                }

                if($_COOKIE["notif_count"]<2) {
                  ++$_COOKIE["notif_count"];
                  setcookie("notif_count", $_COOKIE['notif_count']); // make it 86400 = 1 day//

                }
                else
                {

                $_COOKIE['notif_count']=1;
                setcookie("notif_count", $_COOKIE['notif_count']);

                }






echo '
                        </tbody>
                    </table>
                </div>
        </div>
            </div>
        </div>

         <!-- Code for Noticeboard MODAL -->

         <div class="modal modal-close" id="modal-notice">
  <div class="modal-inner" id="modal-inner-notice">
    <div class="modal-content" id="modal-content-notice" style="    overflow: auto;
    width: 100%;
    max-width: 90%;">
      <div class="modal-close-icon">
        <a href="javascript:void(0)" class="button" style="border:0;padding:0;text-decoration: none;" id="close-modal-notice">✖ &nbsp; Close</a>
      </div>
      <div class="modal-content-inner">
      <!-- <h5 style="font-weight:bolder;">Assigned Cases in this Shift</h5>
      <hr> -->
      <div class="row">
';

$sqlnotice="SELECT * FROM notice;";
$resultnotice=mysqli_query($conn,$sqlnotice);
while($row=mysqli_fetch_assoc($resultnotice)){
  $a=$row["MESSAGE_READ"];
  $pk=$row["PKID"];
  if(array_search($eng_cec,explode(",",$a))===false){
echo '     <div class="twelve columns" style="margin-top: 20px;">
          <div style="margin-bottom: 15px; padding: 0px 0px 0px 15px; border-left: 5px solid #1EAEDB;">
            <h5 style="font-weight: normal;">'.trim(stripslashes($row["MESSAGE"])).'</h5>
            <span style="display: block; font-size: 1.2rem;  padding: 0 2rem 0 0; text-transform: uppercase; color: #999; font-weight: 700;letter-spacing: 1px;">'.$row['DATE_ADDED'].' &nbsp; ｜ &nbsp; &nbsp;<a href="#" class="button" style="margin-top:-1px;border:0; padding:0;display:inline-block;font-size: 11px;font-weight: bolder;line-height: 38px;border-bottom:#1EAEDB 1.5px solid" onclick="readit(this)">✔&nbsp; Acknowledge</a><input type="hidden" value="'.$pk.'"></span>

          </div>
          </div>';
        }
        else {
          echo '

          <div class="twelve columns" style="margin-top: 20px; opacity:0.5;cursor:not-allowed;">
          <div style="margin-bottom: 15px; padding: 0px 0px 0px 15px; border-left: 5px solid #1EAEDB;">
            <h5 style="font-weight: normal;">'.trim(stripslashes($row["MESSAGE"])).'</h5>
            <span style="display: block; font-size: 1.2rem;  padding: 0 2rem 0 0; text-transform: uppercase; color: #999; font-weight: 700;letter-spacing: 1px;">'.$row['DATE_ADDED'].' &nbsp; ｜ &nbsp; &nbsp;<a href="#" class="button" style="margin-top:-1px;border:0; padding:0;display:inline-block;font-size: 11px;font-weight: bolder;line-height: 38px;color:green;cursor:not-allowed;margin-bottom:0;">✔&nbsp; Acknowledged</a><input type="hidden" value="'.$pk.'"></span>

          </div>
          </div>'
          ;
        }
      }
          echo '
      </div>
      </div>
      <div class="modal-buttons" style="justify-content: flex-start;">
        <button class="button button-primary close-modal" id="close-modal-notice">Close</button>
      </div>
    </div>
  </div>
</div>



 <!--Modal for Assigned Cases-->

<!-- <div class="modal modal-close" id="modal-ass">
  <div class="modal-inner" id="modal-inner-ass">
    <div class="modal-content" id="modal-content-ass" style="overflow:auto">
      <div class="modal-close-icon">
        <a href="javascript:void(0)" class="close-modal-ass"><i class="fa fa-times" aria-hidden="true"></i></a>
      </div>
      <div class="modal-content-inner">
      <h5 style="font-weight:bolder;">Assigned Cases in this Shift</h5>
      <hr>
               <table>
                              <thead>
                                <tr>
                                  <th>Engg. CEC</th>
                                  <th>Auto/ESR</th>
                                  <th>MP1/P2</th>
                                  <th>MP3/P4</th>
                                  <th style="white-space: nowrap;">Current State</th>
                                  <th style="white-space: nowrap;">Unavailable Reason</th>
                                </tr>
                              </thead>
                              <tbody>';
                              $sql_number="SELECT * FROM engineer";
                            $resultset=mysqli_query($conn,$sql_number);
                            while($row=mysqli_fetch_assoc($resultset)){
                               echo "
                                <tr>
                                  <td>".$row["CEC"]."</td>
                                  <td>".$row["EA"]."</td>
                                  <td>".$row["P1P2"]."</td>
                                  <td>".$row["P3P4"]."</td>
                                  <td>".$row["STATE"]."</td>
                                  <td>".$row["REASON"]."</td>
                                </tr>";
                            }
                              echo '

                              </tbody>
                            </table>
      </div>
      <div class="modal-buttons">
        <button class="button button-primary close-modal" id="close-modal-ass">Close</button>
      </div>
    </div>
  </div>
</div>
 -->



     <script>
 //Modal for Pending Cases
 var modal = document.querySelector("#modal-pending");
var closeButtons = document.querySelectorAll("#close-modal-pending");
// set open modal behaviour
document.querySelector("#open-modal-pending").addEventListener("click", function() {
  modal.classList.toggle("modal-open");
});
// set close modal behaviour
for (i = 0; i < closeButtons.length; ++i) {
  closeButtons[i].addEventListener("click", function() {
    modal.classList.toggle("modal-open");
  });
}
// close modal if clicked outside content area
document.querySelector("#modal-inner-pending").addEventListener("click", function() {
  modal.classList.toggle("modal-open");
});
// prevent modal inner from closing parent when clicked
document.querySelector("#modal-content-pending").addEventListener("click", function(e) {
  e.stopPropagation();
});


// //Modal for Time Spent
 var modal0 = document.querySelector("#modal-time");
var closeButtons0 = document.querySelectorAll("#close-modal-time");
// set open modal behaviour
document.querySelector("#open-modal-time").addEventListener("click", function() {
  modal0.classList.toggle("modal-open");
});
// set close modal behaviour
for (i = 0; i < closeButtons0.length; ++i) {
  closeButtons0[i].addEventListener("click", function() {
    modal0.classList.toggle("modal-open");
  });
}
// close modal if clicked outside content area
document.querySelector("#modal-inner-time").addEventListener("click", function() {
  modal0.classList.toggle("modal-open");
});
// prevent modal inner from closing parent when clicked
document.querySelector("#modal-content-time").addEventListener("click", function(e) {
  e.stopPropagation();
});



//Modal for Assigned cases

// var modal2 = document.querySelector("#modal-ass");
// var closeButtons2 = document.querySelectorAll("#close-modal-ass");
// // set open modal behaviour
// document.querySelector("#open-modal-ass").addEventListener("click", function() {
//   modal2.classList.toggle("modal-open");
// });
// // set close modal behaviour
// for (i = 0; i < closeButtons2.length; ++i) {
//   closeButtons2[i].addEventListener("click", function() {
//     modal2.classList.toggle("modal-open");
//   });
// }
// // close modal if clicked outside content area
// document.querySelector("#modal-inner-ass").addEventListener("click", function() {
//   modal2.classList.toggle("modal-open");
// });
// // prevent modal inner from closing parent when clicked
// document.querySelector("#modal-content-ass").addEventListener("click", function(e) {
//   e.stopPropagation();
// });


//Modal for Noticeboard

  var modal3 = document.querySelector("#modal-notice");
var closeButtons3 = document.querySelectorAll("#close-modal-notice");
// set open modal behaviour
document.querySelector("#open-modal-notice").addEventListener("click", function() {
  modal3.classList.toggle("modal-open");
  console.log("ids");

});
// set close modal behaviour
for (i = 0; i < closeButtons3.length; ++i) {
  closeButtons3[i].addEventListener("click", function() {
    modal3.classList.toggle("modal-open");
    window.location.reload();
  });
}
// close modal if clicked outside content area
document.querySelector("#modal-inner-notice").addEventListener("click", function() {
  modal3.classList.toggle("modal-open");
});
// prevent modal inner from closing parent when clicked
document.querySelector("#modal-content-notice").addEventListener("click", function(e) {
  e.stopPropagation();
});



//Live Search Functionality

$("#search").on("keyup", function() {
    var value = $(this).val();

    $("#modaltable tr").each(function(index) {
        if (index !== 0) {

            $row = $(this);

            var id = $row.find("td:first").text();

            if (id.indexOf(value) !== 0) {
                $row.hide();
            }
            else {
                $row.show();
            }
        }
    });
});

$("#chepura").on("keyup", function() {
    var value = $(this).val();

    $("#maintable tr").each(function(index) {
        if (index !== 0) {

            $row = $(this);

            var id = $row.find("td#eng_id").text();

            if (id.indexOf(value) !== 0) {
                $row.hide();
            }
            else {
                $row.show();
            }
        }
    });
});




 </script>



    </body>

</html>
';
}
else{
  echo "
  <script>alert('Authentication Failed, Redirecting to Login now.');</script>
  ";
  header("Location:forbidden.html");
}
?>

  <script>

 // $("#open-modal-notice").notify_better({
 //  interval: 0, // Interval between each polling in milliseconds. If you want notification to update faster, lower the number or vice versa. Set to 0/false to execute only once on page load. Default is 5000 (5 seconds)
 //  url: "message_count.html", // The URL to retrieve the notification count.
 //  overrideAjax: false, // Allows you to override the whole ajax call to your notification in case you want to customise it. See more under Further Customization.
 //    updateTitle: false, // Dynamically Add notification count to your websites title
 //  updateFavicon: false // Enable you to show notification on top of your favicon dynamically
  //   id: "favicon",  // the ID of your favicon link tag (as shown above)
  //   backgroundColor: "crimson", // Background color of your notification count #1EAEDB
  //   textColor: "#fff", // Text color of your notification count
  //   location: "full", // Position of your notification count. Can be "full", "ne", "se", "sw", "nw". The default is full.
  //     shape: "square" // Shape of the notification counter. Can be circle or square.
  // }
  //done: function() { // A Callback when the function is completed.
    //alert("done!")
  //}
// });

 </script>

 <script>

 $("#notification").notify_better({
  interval: 0, // Interval between each polling in milliseconds. If you want notification to update faster, lower the number or vice versa. Set to 0/false to execute only once on page load. Default is 5000 (5 seconds)
  url: "notif_count.html", // The URL to retrieve the notification count.
  overrideAjax: false, // Allows you to override the whole ajax call to your notification in case you want to customise it. See more under Further Customization.
    updateTitle: true, // Dynamically Add notification count to your websites title
  updateFavicon: { // Enable you to show notification on top of your favicon dynamically
    id: "favicon",  // the ID of your favicon link tag (as shown above)
    backgroundColor: "crimson", // Background color of your notification count #1EAEDB
    textColor: "#fff", // Text color of your notification count
    location: "full", // Position of your notification count. Can be "full", "ne", "se", "sw", "nw". The default is full.
      shape: "square" // Shape of the notification counter. Can be circle or square.
  }
  //done: function() { // A Callback when the function is completed.
    //alert("done!")
  //}
});

 </script>



 <script>

 function readit(element){
    console.log(element);
    $(element).closest("div").css("opacity", "0.5");
    $(element).closest("div").css("cursor", "not-allowed");
    $(element).html('<a href="#" class="button" style="margin-top:-1px;border:0; padding:0;display:inline-block;font-size: 11px;font-weight: bolder;line-height: 38px;color:green;cursor:not-allowed;margin-bottom:0;">✔&nbsp; Acknowledged</a>');


    // var dude = $(element).closest("span").prev("h5").text();
    var dude2 = $(element).closest("div").find("input").val();
    // console.log(dude);
    console.log(dude2);

    $.ajax({
                type: "POST",
                url: "delete.php",
                data: {"read":dude2},
                 success: function (data) {
                    console.log(data);
                }
            });

  };

 </script>

<script type="text/javascript">
  var count = $.trim($("#open-modal-notice").text());
  console.log(count);

if(count > 0) {
  console.log("I'm in.")
  var audio = new Audio('bell_ring.mp3');
  audio.play();
  $("#open-modal-notice").addClass("dingding");
}


</script>

<script type="text/javascript">
//get the state


function getState(name)
{

  var match = document.cookie.match(new RegExp(' ' + name + '=([^;]+)'));
  console.log(match);
  if (match) return match[1];
}

 var cook = getState("state");
 console.log(document.cookie);
 console.log("hi"+cook);// Unavailable initially
 console.log(document.cookie);

$('input[id="sneaky_togglea"]').click(function() {

  var rad_butt_val = $("input[name='menu_group2']:checked").val();
  console.log(rad_butt_val);
console.log("cook="+cook);
  if(this.checked){
          if(cook!="Available")
          {
            document.cookie="state=Available";
            console.log(document.cookie);//entire cookie with available set in it
            $.ajax({
                type: "POST",
                url: "test.php",
                data: {"menu_group2":rad_butt_val,"prev_state":cook,"shift":<?php echo '"'.$shift.'"';?>},
                success: function (data) {
                    console.log(data);
                    cook = getState("state");
                }
            });

          }
       }
  });

$('input[id="sneaky_toggleb"]').click(function() {
    var rad_butt_val = $("input[name='menu_group2']:checked").val();
  console.log(rad_butt_val);
 console.log("cook="+cook);
  if(this.checked){
          if(cook!="Except Manual P1/P2")
          {
            document.cookie="state=Except+Manual+P1%2FP2";
            console.log(document.cookie);
            $.ajax({
                type: "POST",
                url: "test.php",
                data: {"menu_group2":rad_butt_val,"prev_state":cook,"shift":<?php echo '"'.$shift.'"';?>},
                success: function (data) {
                    console.log(data);
                    cook = getState("state");//updated variable from the entire cookie

                }
            });

       }
     }
  });

$('input[id="chill"]').click(function() {
    var rad_butt_val = $("input[name='menu_group2']:checked").val();
    var reason = $("input[name='reason']").val();
    console.log(rad_butt_val);
console.log("cook="+cook);
  var lol = document.getElementById("sneaky_togglec");

  if(lol.checked){
// if(lol.is(':checked')) {


          console.log("Unavailable");
          console.log(cook);
          if(cook!="Unavailable")
          {
            document.cookie="state=Unavailable";
             console.log(document.cookie);
            if (reason == '') {
                alert("Field is empty. Please input a reason for Unavailability.");
                $('#reason').focus();
            }
            else {
            $.ajax({
                type: "POST",
                url: "test.php",
                data: {"menu_group2":rad_butt_val,"reason":reason,"prev_state":cook,"shift":<?php echo '"'.$shift.'"';?>},
                // data: {"menu_group2":rad_butt_val,"reason":reason},
                 success: function (data) {
                    console.log(data);
                    $("#chill").val("✔");
                    cook = getState("state");


                }
            });

          }

       }
     }
  });


</script>

<script>

$('#reason').keypress(function(e){
        if(e.which == 13){//Enter key pressed
            $('#chill').click();//Trigger submit button click event
        }
    });


$(function () {
         $('input[id="sneaky_togglec"]').click(function() {
            // $(this).hide();
            $('#heyu').show();
            $('#reason').focus();
            $("#chill").val("Submit");

        });

  $('.tada').on('click', function() {
            // $(this).hide();
            $('#heyu').hide();
            $("#chill").val("Submit");

       });

    });
</script>

<script>

setInterval(function(){
  console.log('Inside');

  elementList = document.querySelectorAll("div.modal-open");

if( elementList.length == 0 ){
  // window.location.reload(true);
  window.location.href = window.location.href;
}

else {
  console.log('Must be a modal open.'+elementList.length);
  // return false;
}


}, 60000)


</script>

<script>

 function passcust(row)
 {
   // console.log(row);
   var i = row.parentNode.parentNode.rowIndex;
  var modaltable = document.getElementById("maintable");

  var custname = $.trim($("#maintable tr").eq(i).find("td").eq(2).text());
  console.log(custname);
  if(custname == "CHI")
  {
      alert(
    'PLEASE NOTE:\n\n\n'
    + '● ONLY ENTER CASE NOTES, UPDATES, AND STATE CHANGES IN SAPPHIRE!\n\n'
    + '● Assign (and set severity?) all CHI/Sapphire cases to yourself in MAP and in Sapphire.\n\n'
    + '● Verify MAP alarm has cleared (reset alarm if necessary) PRIOR to setting status to IM-RESTORED or IM-CLOSED in Sapphire.\n\n'
    + '● After Sapphire case closure, verify case closure in MAP.\n\n'
    + '● If MAP case is not closed, verify new Sapphire case for the same alarm.\n\n'
  );
      // var form = $(row).parents('form:first')

  }
  else if(custname == "Baxalta")
  {
    alert(
    'PLEASE NOTE:\n\n\n'
    + '● ONLY ENTER CASE NOTES, UPDATES, AND STATE CHANGES IN SAPPHIRE!\n\n'
    + '● Assign (and set severity?) all CHI/Sapphire cases to yourself in MAP and in Sapphire.\n\n'
    + '● Verify MAP alarm has cleared (reset alarm if necessary) PRIOR to setting status to IM-RESTORED or IM-CLOSED in Sapphire.\n\n'
    + '● After Sapphire case closure, verify case closure in MAP.\n\n'
    + '● If MAP case is not closed, verify new Sapphire case for the same alarm.\n\n'
    + '● Before CMS begins any extensive troubleshooting on “MGCP” gateways for inability to make inbound/outbound calls do the following:\n\n'
    + '    - reset MGCP gateway from CUCM GUI\n\n'
    + '    - test/confirm that calls are working as normal\n\n'
    + '    - if not, proceed with normal troubleshooting (log collection, debugs, etc)\n\n'
  );

  }

  }

 </script>

 <?php


ob_end_flush();
//var_dump($_COOKIE);

 ?>
