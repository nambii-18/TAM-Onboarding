<?php
ob_start();
require '/var/www/html/newmail/PHPMailerAutoload.php';
require '/var/www/html/newmail/class.phpmailer.php';
session_start();
require("connect.php");
if($_SESSION["manager"]!=NULL){
$mcec=$_SESSION["manager"];
$customer="";
$tnum="";
$status="Closed";
$priority="";
$createdate="";
$towner="";
$gdc="";
$pkid=0;
$mail=$_SESSION["mail"];
$mail=json_encode($mail);

// if(isset($_POST["status"])){
//   $status=$_POST["status"];
//   echo $status;

// }
// if(isset($_POST["review"])){
//  $sql="SELECT * FROM BACKLOG where PKID=".$_POST["pkid"].";";
// $pkid=$_POST["pkid"];
//     if($result=$conn->query($sql))
//     {
//      $row=mysqli_fetch_assoc($result);
//       $customer=$row["CUSTOMER"];
//       $tnum=$row["TNUM"];
//       $status=$row["STATUS"];
//       $priority=$row["PRIORITY"];
//       $createdate=$row["CREATE_DATE"];
//       $towner=$row["TOWNER"];
//       $gdc=$row["GDC"];
//     }
//     else "Error";
// }
$sqleng="SELECT * FROM Engineer";
$result=mysqli_query($conn,$sqleng);
$engarr=array();
while($row=mysqli_fetch_assoc($result)){
  array_push($engarr,$row["CEC"]);
}
if(isset($_COOKIE["bro"])){
  if($_COOKIE["bro"]==1){
      echo "<div style='text-align:center;margin-top:10px; padding-bottom:10px; border-bottom:2px solid #8EC343;'>
          <div class='svg' style='display:inline-block;'>
            <svg xmlns='http://www.w3.org/2000/svg' width='26' height='26' viewBox='-263.5 236.5 26 26'>
              <g class='svg-success'>
                <circle cx='-250.5' cy='249.5' r='12'/>
                <path d='M-256.46 249.65l3.9 3.74 8.02-7.8'/>
              </g>
            </svg>
          </div>
            <span style='display:inline-block; vertical-align: super;margin-left: 10px;'>Review has been recorded!</span>
        </div>
";
  setcookie("bro",0);
  $_COOKIE["bro"]=0;
  }

}
  $sqlpk="SELECT MIN(PKID) AS NUM FROM BACKLOG";
  $result=mysqli_query($conn,$sqlpk);
  $row=mysqli_fetch_assoc($result);
  $a=$row["NUM"];
  $pkid=$a-1;
echo "
<!DOCTYPE html>
<html lang='en'>

    <head>

        <meta charset='utf-8'>
        <title>Adhoc Review - CRT &middot; Cisco CMS</title>
        <!-- <meta name='description' content='Quality Management Tool'>
  <meta name='author' content='Cisco CMS'> -->


        <meta name='viewport' content='width=device-width, initial-scale=1'>


        <link rel='stylesheet' href='css/normalize.css'>
        <link rel='stylesheet' href='css/skeleton.css'>
        <link rel='stylesheet' href='css/fullpage.css'>

    <script src='js/jquery-min.js'></script>
        <script src='js/jquery.fullPage.min.js'></script>
        <script src='js/autocomplete.js'></script>

    <!-- <link href='css/select2.min.css' rel='stylesheet'/>
    <script src='js/select2.min.js'></script> -->


        <link rel='icon' type='image/png' href='favicon.png'>

</head>
<style>

.autocomplete-suggestions { border: 1px solid #999; background: #FFF; overflow: auto; }
.autocomplete-suggestion { padding: 2px 5px; white-space: nowrap; overflow: hidden; }
.autocomplete-selected { background: #F0F0F0; }
.autocomplete-suggestions strong { font-weight: normal; color: #3399FF; }
.autocomplete-group { padding: 2px 5px; }
.autocomplete-group strong { display: block; border-bottom: 1px solid #000; }

.fp-tooltip {
               color:#212121 !important;
               font-family: Segoe UI;
            }

            #fp-nav ul li .fp-tooltip {
                top: -5px !important;
            }
            td input {
                                margin-top: 17px;
                                vertical-align: middle;
                        }
                        th, td {
                            /*padding: 5px 15px;*/
                                //padding: 3px 100px;
    padding: 5px 3px;
                        }

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
  content: '';
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
</style>
    <body>


    <div class='container u-max-full-width' style='z-index:99999;'>
        <div class='row' style='padding-top:15px;'>
          <!--div style='display:inline-block;'>
            <span style='margin-top:5px;color:grey;'>Made by folks just like you. ;)</span>
          </div-->

           <div class='one columns'>
          <a href='backlog.php' class='button' style='display:inline-block;border: 0; border-bottom: 1px solid #212121; padding: 0;'>◀ &nbsp; Back to Backlog</a>
          </div>

          <div class='eleven columns' style='float:right;'>
          <div style='display:inline-block;float: right;'>
              <span>Welcome, ".$mcec."</span>
              <span>
                  <form method='POST' action='backlog.php' style='margin: 0; padding-left: 20px; display:inline-block;'>
                    <input type='submit' value='Logout &#x21b7;' name='logout' style='border: 0; border-bottom: 1px solid #212121;padding: 0;'/>
                  </form>
              </span>
              <span><a href='backlog.php' class='button' style='border: 0; border-bottom: 1px solid #212121;padding: 0;margin-left:20px;'>Backlog</a></span>
              <span><a href='adhoc.php' class='button' style='border: 0; border-bottom: 1px solid #212121;padding: 0;margin-left:20px;'>New Adhoc Review</a></span>
              <span><a href='reporter.php' target='_blank' class='button' style='border: 0; border-bottom: 1px solid #212121;padding: 0;margin-left:20px;'>Reporting</a></span>
               <span><form method='POST' action='statistics.php' target='_blank' style='margin:0;padding:0;display: inline-block;'><input type='submit' class='button' name='report' value='Statistics' style='border: 0; border-bottom: 1px solid #212121;padding: 0;margin-left:20px;'></form></span>

              ";
              if(mysqli_num_rows(mysqli_query($conn,"SELECT * FROM REVIEWERS WHERE CEC ='".$mcec."';"))>0 || mysqli_num_rows(mysqli_query($conn,"SELECT * FROM MANAGER WHERE manager ='".$mcec."';"))>0){

              echo "<span><a href='upload.php' target='_blank' class='button' style='border: 0; border-bottom: 1px solid #212121;padding: 0;margin-left:20px;'>Upload Cases For Review</a></span>";

              }
              echo "

              <span><a href='mailto:cms-crt@cisco.com?subject=Feedback%20on%20the%20CRT%20Tool' class='button' style='border: 0; border-bottom: 1px solid #212121;padding: 0;margin-left:20px;'>Give Feedback <span style='font-size:large;'>&#x263a;</span></a></span>

          </div>
        </div>
      </div>
      </div>

        <div class='container u-max-full-width'>
            <div class='row' style='margin-top:1%;z-index:99999;'>
                <div class='twelve columns bg-this'>
                    <a href='adhoc.php'><svg class='img-responsive logo' style='max-width: 185px;width:120px;' x='0px' y='0px' width='200.1px' height='105.4px' viewBox='-305 291.9 200.1 105.4'>
  <g class='logo__mark'>
    <path d='M-296.2,324.6c0-2.4-2-4.3-4.4-4.3s-4.4,1.9-4.4,4.3v9.1c0,2.4,2,4.4,4.4,4.4s4.4-1.9,4.4-4.4V324.6z'/>
    <path transform='translate(97.7633,748.5409)' d='M-370.1-435.9c0-2.4-2-4.3-4.4-4.3c-2.4,0-4.4,1.9-4.4,4.3v21.1c0,2.4,2,4.3,4.4,4.3c2.4,0,4.4-1.9,4.4-4.3V-435.9z'/>
    <path transform='translate(106.3727,754.4384)' d='M-354.8-458.2c0-2.4-2-4.3-4.4-4.3s-4.4,1.9-4.4,4.3v46.1c0,2.4,2,4.4,4.4,4.4s4.4-1.9,4.4-4.4V-458.2z'/>
    <path transform='translate(114.9821,748.5409)' d='M-339.5-435.9c0-2.4-2-4.3-4.4-4.3c-2.4,0-4.4,1.9-4.4,4.3v21.1c0,2.4,2,4.3,4.4,4.3c2.4,0,4.4-1.9,4.4-4.3V-435.9z'/>
    <path transform='translate(123.5817,744.2304)' d='M-324.2-419.6c0-2.4-1.9-4.3-4.3-4.3c-2.4,0-4.4,1.9-4.4,4.3v9.1c0,2.4,2,4.4,4.4,4.4c2.4,0,4.3-1.9,4.3-4.4V-419.6z'/>
    <path transform='translate(132.195,748.5409)' d='M-308.9-435.9c0-2.4-1.9-4.3-4.3-4.3s-4.3,1.9-4.3,4.3v21.1c0,2.4,1.9,4.3,4.3,4.3s4.3-1.9,4.3-4.3 C-308.9-414.8-308.9-435.9-308.9-435.9z'/>
    <path transform='translate(140.8102,754.4384)' d='M-293.6-458.2c0-2.4-1.9-4.3-4.3-4.3s-4.3,1.9-4.3,4.3v46.1c0,2.4,1.9,4.4,4.3,4.4s4.3-1.9,4.3-4.4V-458.2z'/>
    <path transform='translate(149.4235,748.5409)' d='M-278.3-435.9c0-2.4-1.9-4.3-4.4-4.3c-2.4,0-4.3,1.9-4.3,4.3v21.1c0,2.4,1.9,4.3,4.3,4.3c2.5,0,4.4-1.9,4.4-4.3 C-278.3-414.8-278.3-435.9-278.3-435.9z'/>
    <path transform='translate(158.0192,744.2304)' d='M-263-419.6c0-2.4-1.9-4.3-4.3-4.3s-4.3,1.9-4.3,4.3v9.1c0,2.4,1.9,4.4,4.3,4.4s4.3-1.9,4.3-4.4V-419.6z'/>
  </g>
  <g class='logo__type'>
    <path transform='translate(102.0426,727.2001)' d='M-362.5-355.3c-0.4-0.2-3.2-1.9-7.4-1.9c-5.7,0-9.6,3.9-9.6,9.3c0,5.2,3.8,9.3,9.6,9.3c4.1,0,7-1.6,7.4-1.8v9.3 c-1.1,0.3-4.1,1.2-8,1.2c-9.9,0-18.5-6.8-18.5-18c0-10.4,7.8-18,18.5-18c4.1,0,7.2,1,8,1.2V-355.3z'/>
    <path d='M-239.7,396.7h-8.8v-34.8h8.8V396.7z'/>
    <path transform='translate(121.5124,727.9413)' d='M-327.9-358.1c-0.1,0-3.8-1.1-6.9-1.1c-3.5,0-5.4,1.2-5.4,2.8c0,2.1,2.6,2.9,4,3.3l2.4,0.8c5.7,1.8,8.3,5.7,8.3,9.9 c0,8.7-7.7,11.7-14.4,11.7c-4.7,0-9-0.9-9.5-1v-8c0.8,0.2,4.4,1.3,8.3,1.3c4.4,0,6.4-1.3,6.4-3.2c0-1.8-1.7-2.8-3.9-3.5 c-0.5-0.2-1.3-0.4-1.9-0.6c-4.9-1.5-9-4.4-9-10.2c0-6.5,4.9-10.9,12.9-10.9c4.3,0,8.3,1,8.5,1.1v7.6H-327.9z'/>
    <path transform='translate(134.9958,727.2001)' d='M-303.9-355.3c-0.4-0.2-3.2-1.9-7.4-1.9c-5.7,0-9.6,3.9-9.6,9.3c0,5.2,3.8,9.3,9.6,9.3c4.1,0,7-1.6,7.4-1.8v9.3 c-1.1,0.3-4.1,1.2-8,1.2c-9.9,0-18.5-6.8-18.5-18c0-10.4,7.8-18,18.5-18c4.1,0,7.2,1,8,1.2V-355.3z'/>
    <path transform='translate(144.9274,727.8212)' d='M-286.3-357.7c-5.2,0-9.1,4.1-9.1,9.1c0,5.1,3.9,9.1,9.1,9.1s9.1-4.1,9.1-9.1S-281.1-357.7-286.3-357.7 M-267.9-348.5 c0,9.9-7.7,18-18.4,18s-18.4-8.1-18.4-18s7.7-18,18.4-18S-267.9-358.4-267.9-348.5'/>
  </g>
</svg>
</a>
                <div style='display:inline-block;float:right;'>
                    <h4 style='font-weight:normal; margin-bottom: 0px;'>Cisco Managed Services</h4>
                    <h5 style='font-weight:lighter;float:right;'>Case Review Tool <span style='font-weight:bolder;'>v6.0</span></h5>
                </div>
            </div>
        </div>


<div class='row' style='margin-top: 1%;'>
<form method='POST' id='adhocform' action='send.php' style='height:auto;margin-top:40px;'>
    <div id='fullpage' class='twelve columns' style='height:100%'>
    <div class='section' style='height: auto'>
    <!-- <h2>Click Here to Upload</h2> -->
    <!-- <h5 style='font-weight:bold;display:inline-block;'>Auto Review &amp; Ratings</h5> -->
<!-- <hr> -->


<!--Display this when case is closed-->
                       <!--  <div id='chepura' class='row u-max-full-width'>
                        <h5 style='display: block;'>
                        <span id='chesta'>Review a <span style='font-weight:normal'>closed</span> case.</span>
                        <label class='switch' style='margin-bottom: 35px; margin-right: 25px; margin-top: 3px;'>

                          <input id='checkpaninga' name='status' type='checkbox'>
                          <div class='slider round'</div>

                        </label>

                        </h5>



                        </div> -->

                        <div class='row'>
        <h5 style='font-weight:bold;display:inline-block;'>Ticket Information</h5>
        <!-- <span style='float:right;margin-top: 9px;margin-right: 20px;'>Total Presented Score (out of 100): <span id='shovehere' style='font-weight:bolder;'>100</span></span> -->
        <p style='margin-bottom:0; border-left: goldenrod 5px solid; padding-left: 15px;'>Please be aware that this review is shared with the Engineer and their Ops Manager.</p>

        </div>
        <hr>


                        <div class='field half tb'>
                        <label for='name'>Customer</label>
                            <!-- <input required='required' type='text' id='' name='customer' > -->
                            <select class='js-basic-single1' id='' name='customer' style='border:0; margin-left:15px; margin-top: 7px;margin-bottom: 20px;border-radius:0px!important;' required>
                                                    <Option value=''>Select a Customer</option>
<Option value='HSBC'>HSBC</option>



                                                  </select>
                        </div>
                        <div class='field half tb last'>
                            <label for='name'>Ticket Grader</label>
                            <input required='required' type='text' id='' name='reviewer' value='$mcec' >
                            <!-- To be Autofilled for a user's session -->
                        </div>
                        <div class='field half tnb'>
                            <label for='name'>Ticket Owner</label>
                            <input required='required' type='text' id='tickowner' name='towner' onblur='checkGDC();'>
                            <!-- To be Autofilled for a user's session -->
                        </div>
                        <div class='field half tnb last'>
                            <label for='name'>Ticket Number</label>
                            <input required='required' type='text' id='' name='tnum' >
                            <!-- To be Autofilled for a user's session -->
                        </div>
                        <div class='field half tnb'>
                        <label for='name'>Ticket Create Date</label>
                            <input required='required' type='date' id='' name='createdate' >
                        </div>
                        <div class='field half tnb last'>
                            <label for='name'>Ticket Review Date</label>
                            <input required='required' type='date' id='' name='reviewdate' value=".gmdate('Y-m-d')." >
                            <!-- To be Autofilled for a user's session -->
                        </div>
                        <div class='field half tnb'>
                        <label for='name'>Global Delivery Center</label>
                            <input required='required' type='text' id='gdc' name='gdc' >
                            <!-- <select class='js-basic-single1' id='gdc' name='gdc' style='border:0; margin-left:15px; margin-top: 7px;margin-bottom: 20px;border-radius:0px!important;' required>
                                                    <Option value=''>Select GDC</option>
<Option value='Bangalore'>Bangalore</option>
<Option value='RTP'>RTP</option>
<Option value='Krakow'>Krakow</option>
<Option value='Noida'>Noida</option>
</select>
                   -->
                    </div>
                        <div class='field half tnb last'>
                        <label for='name'>Ticket Priority</label>
                            <!-- <input required='required' type='text' id='' name='priority'> -->
                            <select class='js-basic-single1' id='' name='priority' style='border:0; margin-left:15px; margin-top: 7px;margin-bottom: 20px;border-radius:0px!important;' required>
                                                    <Option value=''>Select Priority</option>
<Option value='1'>1</option>
<Option value='2'>2</option>
<Option value='3'>3</option>
<Option value='4'>4</option>
</select>
                        </div>
                        <div class='field' style='border: 0;'>
                            <input type='hidden' name='mail' value='$mail' />
                        <a href='#review' class='button' style='margin-top:30px;color:#fff; background-color: #33C3F0;border-color: #33C3F0;'>Next &#x2193;</a>
                        </div>
                        <!-- <input class='button' type='button' value='Reload Page' onclick='window.location.reload();'> -->

        <!-- </form> -->
        </div>
        <div class='section'>
        <div class='row'>

        <!-- <h5 style='font-weight:bold;display:inline-block;'>Ticket Review</h5> -->
         <div id='chepura' class='row u-max-full-width' style='display:inline-block;'>
                        <h5 style='display: block;'>
                        <span id='chesta'>Review a <span style='font-weight:normal'>closed</span> case</span>
                        <label class='switch' style='margin-right: 25px; margin-top: 3px;'>

                          <input id='checkpaninga' name='status' type='checkbox'>
                          <div class='slider round'></div>

                        </label>

                        </h5>



          </div>
        <span style='float:right;margin-top: 9px;margin-right: 20px;'>Total Presented Score (out of 100): <span id='shovehere' style='font-weight:bolder;'>100</span></span>

        </div>
        <hr style='margin: 0;'>
        <!-- <form method='' action=''> -->

        <!-- Multi Selection -->


                <table class='u-full-width' style='margin-top: 1%'>


        <tbody>

        <tr>
        <td title='Quality of Documentation and Communication with Customer' style='font-weight:bold;border-bottom:0;padding-bottom:0;'>Documentation &amp; Communication</td>
                                  </tr>
                                  <tr>
        <td><input type='checkbox' id='group_dc1' name='dc1' class='ratings group_dc' value='-10' ><label style='    margin-left: 7px;
    vertical-align: middle;
    color: dimgray;
    font-size: small;'>Case update template missing (-10)</label></td>

        <td><input type='checkbox' id='group_dc2' name='dc2' class='ratings group_dc' value='-10'><label style='    margin-left: 7px;
    vertical-align: middle;
    color: dimgray;
    font-size: small;'>Poor Customer Communication (-10)</label></td>
        <td><input type='checkbox' id='group_dc3' name='dc3' class='ratings group_dc' value='-10'><label style='    margin-left: 7px;
    vertical-align: middle;
    color: dimgray;
    font-size: small;'>Ticket Not Updated Frequently Enough (-10)</label></td>
        <td></td>
                                  <td></td>
        </tr>



        <tr>
        <td title='Troubleshooting/Isolating the Issue' style='font-weight:bold;border-bottom:0;padding-bottom:0;'>Initial Triage/Troubleshooting</td>
                                  </tr>
                                  <tr>
        <td><input type='checkbox' id='group_trouble1' name='t1' class='ratings group_trouble' value='-7' ><label style='    margin-left: 7px;
    vertical-align: middle;
    color: dimgray;
    font-size: small;'>Initial Triage/Troubleshooting Approach Inadequate (-7)</label></td>
        <td><input type='checkbox' id='group_trouble2' name='t2' class='ratings group_trouble' value='-10'><label style='    margin-left: 7px;
    vertical-align: middle;
    color: dimgray;
    font-size: small;'>Initial Triage/Troubleshooting Approach Incorrect (-10)</label></td>
        <td><input type='checkbox' id='group_trouble3' name='t3' class='ratings group_trouble' value='-7'><label style='    margin-left: 7px;
    vertical-align: middle;
    color: dimgray;
    font-size: small;'>Quality of Troubleshooting Inadequate (-7)</label></td>
        <td><input type='checkbox' id='group_trouble4' name='t4' class='ratings group_trouble' value='-10'><label style='    margin-left: 7px;
    vertical-align: middle;
    color: dimgray;
    font-size: small;'>Quality of Troubleshooting Incorrect (-10)</label></td>
                                  <td></td>
        </tr>

        <tr>
        <td title='Correct Status, Categorization, and Impact' style='font-weight:bold;border-bottom:0;padding-bottom:0;'>Case Classification</td>
                                  </tr>
                                  <tr>
        <td><input type='checkbox' id='group_cc1' name='cc1' class='ratings group_cc' value='-10' ><label style='    margin-left: 7px;
    vertical-align: middle;
    color: dimgray;
    font-size: small;'>Timers (Pending/States/Status) Not Used Correctly (-10)</label></td>
        <td><input type='checkbox' id='group_cc2' name='cc2' class='ratings group_cc' value='-10'><label style='    margin-left: 7px;
    vertical-align: middle;
    color: dimgray;
    font-size: small;'>Priority Incorrect (-10)</label></td>
        <td><input type='checkbox' id='group_cc3' name='cc3' class='ratings group_cc' value='-7'><label style='margin-left: 7px;
    vertical-align: middle;
    color: dimgray;
    font-size: small;'>Customer Impact Incorrect or Unclear (-7)</label></td>
        <td><input type='checkbox' id='group_cc4' name='cc4' class='ratings group_cc' value='-10'><label style='    margin-left: 7px;
    vertical-align: middle;
    color: dimgray;
    font-size: small;'>Customer Impact Not Stated (-10)</label></td>
                                  <td></td>
        </tr>

        <tr>
        <td title='Escalations & Vendor Engagements' style='font-weight:bold;border-bottom:0;padding-bottom:0;'>Escalations & Vendor Engagements</td>
                                  </tr>
                                  <tr>
        <td><input type='checkbox' id='group_evs1' name='eve1' class='ratings group_evs' value='-5' ><label style='    margin-left: 7px;
    vertical-align: middle;
    color: dimgray;
    font-size: small;'>Case Not Escalated in a Timely Manner (-5)</label></td>
        <td><input type='checkbox' id='group_evs2' name='eve2' class='ratings group_evs' value='-3' ><label style='    margin-left: 7px;
    vertical-align: middle;
    color: dimgray;
    font-size: small;'>Escalation Details Inadequate (-3)</label></td>
        <td><input type='checkbox' id='group_evs3' name='eve3' class='ratings group_evs' value='-5' ><label style='    margin-left: 7px;
    vertical-align: middle;
    color: dimgray;
    font-size: small;'>Escalation Details Missing (-5)</label></td>
        <td><input type='checkbox' id='group_evs4' name='eve4' class='ratings group_evs' value='-5' ><label style='    margin-left: 7px;
    vertical-align: middle;
    color: dimgray;
    font-size: small;'>3rd Party Documentation Missing (-5)</label></td>
                                  <td></td>
        </tr>

        <tr class='closedcaseonly'>
        <td title='Correct Resolution codes and Responsible Party' style='font-weight:bold;border-bottom:0;padding-bottom:0;'>Closing Details</td>
                                  </tr>
                                  <tr class='closedcaseonly'>
        <td><input type='checkbox' id='group_cd1' name='cd1' class='ratings group_cd' value='-10' ><label style='    margin-left: 7px;
    vertical-align: middle;
    color: dimgray;
    font-size: small;'>Resolution/Cause Code Incorrect (-10)</label></td>
        <td><input type='checkbox' id='group_cd2' name='cd2' class='ratings group_cd' value='-10'><label style='    margin-left: 7px;
    vertical-align: middle;
    color: dimgray;
    font-size: small;'>Responsible Party Incorrect (-10)</label></td>
        <td><input type='checkbox' id='group_cd3' name='cd3' class='ratings group_cd' value='-7'><label style='    margin-left: 7px;
    vertical-align: middle;
    color: dimgray;
    font-size: small;'>Resolution Summary Inadequate (-7)</label></td>
        <td><input type='checkbox' id='group_cd4' name='cd4' class='ratings group_cd' value='-10'><label style='    margin-left: 7px;
    vertical-align: middle;
    color: dimgray;
    font-size: small;'>Resolution Summary Missing (-10)</label></td>
        </tr>

        <!-- <input type='hidden' name='group_cd' value='0'/>
        <input type='hidden' name='group_cd' value='0'/> -->

        </tbody>
        </table>

        <div class='field' style='margin-top:20px;'>
                        <label for='name' style='display:inline-block;'>Overall Comments - Please enter detailed reasoning for all 'unacceptable’</label>
                        <!-- input name='comment' type='text' required' -->
                             <textarea name='comment' style='resize:none;min-height: 40px;' required></textarea>
                             <!--textarea style='resize:none;min-height: 30px;' placeholder='Enter Comments Here..'></textarea -->
                    </div>
                    <input type='hidden' name='pkid' value='$pkid'/>
                    <!-- input type='hidden' id='meanie' name='avg' -->


                        <!-- All score parameters as hidden values -->
                                   <input type='hidden' id='dcrs-hidden' name='dcrs' value='20' />
                                   <input type='hidden' id='dcps-hidden' name='dcps' value='20' />
                                   <input type='hidden' id='trs-hidden' name='trs' value='20' />
                                   <input type='hidden' id='tps-hidden' name='tps' value='20' />
                                   <input type='hidden' id='ccrs-hidden' name='ccrs' value='25' />
                                   <input type='hidden' id='ccps-hidden' name='ccps' value='25' />
                                   <input type='hidden' id='evrs-hidden' name='evrs' value='10' />
                                   <input type='hidden' id='evps-hidden' name='evps' value='10' />
                                   <input type='hidden' id='cdrs-hidden' name='cdrs' value='25' />
                                   <input type='hidden' id='cdps-hidden' name='cdps' value='25' />

                                   <input type='hidden' id='ttrs-hidden' name='frs' value='100' />
                                   <input type='hidden' id='ttps-hidden' name='fps' value='100' />



                    <div style='display:inline-block;'>
                <input class='button-primary' type='submit' name='assignadhoc' value='Submit'>
                <a class='button' href='#info'>Previous &#x2191;</a>
                        <!-- <input class='button' type='button' value='Reload Page' onclick='window.location.reload();'> -->
</div>

        </div>
    </div>
</div>
</form>
<div class='row'>


</div>

        </div> <!--End of Main Container-->

        <script>
        $(document).ready(function() {
    $('#fullpage').fullpage({
                    normalScrollElements: '.container',
                    anchors: ['info', 'review'],
                    responsiveWidth: 1200,
                    navigation: true,
                    // autoScrolling: false,
                    animateAnchor: true,
                    //recordHistory: false,
                    // lockAnchors: true,
                    navigationPosition: 'right',
                    navigationTooltips: ['Info', 'Review'],
                    keyboardScrolling: false,
                    // bigSectionsDestination: 'NULL',
                    scrollBar: true,
                    showActiveTooltip: true,
                    responsiveHeight: 900,
                     fitToSection: true
    });
});
        </script>

        <script type='text/javascript'>


      $(window).keydown(function(event){
    if((event.which== 13) && ($(event.target)[0]!=$('textarea')[0])) {
      event.preventDefault();
      return false;
    }
  });

</script>

        <script>

//  $('input.ratings[type=checkbox]').click(function() {
//    var total = 100;
//    $('input.ratings[type=checkbox]:checked').each(function() {
//        if (total > 0) { total += parseFloat($(this).val()); } else { total = 0; }
//    });
//
//    if ($('#closedcaseonly').is(':visible'))
//    {
//        console.log('Closed Case only is visible.');
//    $('#shovehere').html(total);
//  //  $('#meanie').val(total/5);
//    //console.log($('#meanie').val());
//    }
//    }
//
//else {
//    console.log('Closed Case only is NOT visible.');
//    $('#shovehere').html(total);
//    //$('#meanie').val(total/4);
//    }
//
//});

//    lol

  // if ($('#closedcaseonly').is(':visible')) {
  //   $('#chepura').show();
  // }
  // else {
  //       $('#chepura').hide();
  // }

//    $('input[type=radio]').click(function() {
//    var total = 100;
//    $('input[type=radio]:checked').each(function() {
//        total -= parseFloat($(this).val());
//    });


//    if ($('.closedcaseonly').is(':visible'))
//    {
//    console.log('Closed Case only is visible.');
//
//    //$('#meanie').val(total);
//    //console.log($('#meanie').val());
//    }
//
//else {
//    console.log('Closed Case only is NOT visible.');
//    $('#shovehere').html(total);
//    //$('#meanie').val(total);
//    }

//   if ($('#closedcaseonly').is(':visible')) {
//     $('#chepura').show();
//   }
//   else {
//         $('#chepura').hide();
//   }
        </script>

        <script>

        $('#checkpaninga').click(function() {
  if ($(this).is(':checked')) {
    $('#chesta').html('Review an <span style=\'font-weight:normal\'>open</span> case');
  } else {
    $('#chesta').html('Review a <span style=\'font-weight:normal\'>closed</span> case');
  }
});
        </script>

               <script>
        $('#checkpaninga').change(function() {
            if($(this).is(':checked')) {
              $('.closedcaseonly').hide();
              console.log('Imma checked');
                $.ajax({
                    url: 'insert.php?status=Open&checked=1',
                    type: 'GET',
                    //data: 'Closed',
                    success: function(data){
                      // var val = '<?php echo $status = data ?>;';
                      //$('#chepura').html = val;
                      console.log(data);
                      //var str_json = JSON.stringify(data);


                    }
                });
            } else {
              $('.closedcaseonly').show();
              console.log('Imma unchecked');
                $.ajax({
                    url: 'insert.php?status=Closed&checked=1',
                    type: 'GET',
                     //data: 'Open',
                     success: function(data){
                      //var val = '<?php echo $status = data ?>';
                      console.log(data);
                    }
                });
            }
        });
        </script>





 </body>
 </html>
";

}
else{
  header("Location:forbidden.html");
}

ob_end_flush();
?>

<script>
function checkGDC() {
  var tickowner = $("#tickowner").val();
  console.log(tickowner);

  $.ajax({
    type: "GET",
    url: "test.php?enggdc=1&eng="+tickowner,
    success: function(data) {
      $("#gdc").val(data);
      console.log(data);
    }
  });
}
</script>

<script>


    var obj = <?php echo json_encode($engarr); ?>;
    // console.log(obj);


// var test = [ {"html": "<span style='color:green;text-shadow: 0 0 3px green;font-size:small;'>&#11044;</span>", "name": "svenkatt"}, {"html": "<span style='color:green;text-shadow: 0 0 3px crimson;font-size:small;'>&#11044;</span>", "name": "gkotapal"} ];

// var parseddata = JSON.parse(test);
// console.log(obj);

$("#tickowner").autocomplete({
  // serviceUrl: 'test.php',
    lookup: obj
    // lookup: test
    // onSelect: function (suggestion) {
    //     console.log('You selected: ' + suggestion.value + ', ' + suggestion.data);
    // }
});

</script>

<script>

    var dcrs = 20;
    var dcps = 20;

    var trs = 20;
    var tps = 20;

    var ccrs = 25;
    var ccps = 25;

    var evrs = 10;
    var evps = 10;

    var cdrs = 25;
    var cdps = 25;


    var ttrs;
    var ttps;


    //DCRS & DCPS

    $('input.group_dc').click(function() {
        dcrs = 20;
        dcps = 20;
//        ttrs = dcrs + trs + ccrs + evrs + cdrs;
//    ttps = dcps + tps + ccps + evps + cdps;
    //console.log('clicked dc');
    //if ($(this).is(':checked'))
    $('input.group_dc:checked').each(function() {
        {
            dcrs += parseFloat($(this).val());

            if(dcrs < 0)
            {
                dcps = 0;
            }
             else {
                dcps = dcrs;
             }




        }


    });

    console.log('D & C: ' + dcrs, dcps);
    $('input#dcrs-hidden').val(dcrs);
            //console.log($('input#dcrs-hidden').val(dcrs));
    $('input#dcps-hidden').val(dcps);

    ttrs = dcrs + trs + ccrs + evrs + cdrs;
    ttps = dcps + tps + ccps + evps + cdps;
//     if (ttrs > 0) { ttps = ttrs; } else { ttps = 0; };
    console.log('Total: ' + ttrs, ttps);
    $('input#ttrs-hidden').val(ttrs);
    $('input#ttps-hidden').val(ttps);
    $('#shovehere').html(ttps);
});


    //TRS & TPS

    $('input.group_trouble').click(function() {
        trs = 20;
        tps = 20;

    //console.log('clicked dc');
    $('input.group_trouble:checked').each(function() {
        {
            trs += parseFloat($(this).val());

            if(trs < 0)
            {
                tps = 0;
            }
             else {
                tps = trs;
             }



        }

    });

         console.log('Trouble: ' + trs, tps);
    $('input#trs-hidden').val(trs);
    $('input#tps-hidden').val(tps);

    ttrs = dcrs + trs + ccrs + evrs + cdrs;
            ttps = dcps + tps + ccps + evps + cdps;
//    if (ttrs > 0) { ttps = ttrs; } else { ttps = 0; };
    console.log('Total: ' + ttrs, ttps);
    $('input#ttrs-hidden').val(ttrs);
    $('input#ttps-hidden').val(ttps);
    $('#shovehere').html(ttps);
        });


    //CCRS & CCPS

    $('input.group_cc').click(function() {
        ccrs = 25;
        ccps = 25;

    //console.log('clicked dc');
    $('input.group_cc:checked').each(function() {
        {
            ccrs += parseFloat($(this).val());

            if(ccrs < 0)
            {
                ccps = 0;
            }
             else {
                ccps = ccrs;
             }



        }

    });

            console.log('CC: ' + ccrs, ccps);
    $('input#ccrs-hidden').val(ccrs);
    $('input#ccps-hidden').val(ccps);

    ttrs = dcrs + trs + ccrs + evrs + cdrs;
            ttps = dcps + tps + ccps + evps + cdps;
//    if (ttrs > 0) { ttps = ttrs; } else { ttps = 0; };
    console.log('Total: ' + ttrs, ttps);
    $('input#ttrs-hidden').val(ttrs);
    $('input#ttps-hidden').val(ttps);
    $('#shovehere').html(ttps);
        });


    //EVERS & EVEPS

    $('input.group_evs').click(function() {
        evrs = 10;
        evps = 10;

    //console.log('clicked dc');
    $('input.group_evs:checked').each(function() {
        {
            evrs += parseFloat($(this).val());

            if(evrs < 0)
            {
                evps = 0;
            }
             else {
                evps = evrs;
             }



        }
    });

         console.log('Esc & Vendor: ' + evrs, evps);
    $('input#evrs-hidden').val(evrs);
    $('input#evps-hidden').val(evps);

    ttrs = dcrs + trs + ccrs + evrs + cdrs;
            ttps = dcps + tps + ccps + evps + cdps;
//     if (ttrs > 0) { ttps = ttrs; } else { ttps = 0; };
    console.log('Total: ' + ttrs, ttps);
    $('input#ttrs-hidden').val(ttrs);
    $('input#ttps-hidden').val(ttps);
    $('#shovehere').html(ttps);
        });

    //CDRS & CDPS

    $('input.group_cd').click(function() {
    cdrs = 25;
        cdps = 25;
    //console.log('clicked dc');
    $('input.group_cd:checked').each(function() {
        {
            cdrs += parseFloat($(this).val());

            if(cdrs < 0)
            {
                cdps = 0;
            }
             else {
                cdps = cdrs;
             }



        }

    });

        console.log('Closing Details: ' + cdrs, cdps);
    $('input#cdrs-hidden').val(cdrs);
    $('input#cdps-hidden').val(cdps);

    ttrs = dcrs + trs + ccrs + evrs + cdrs;
            ttps = dcps + tps + ccps + evps + cdps;
//     if (ttrs > 0) { ttps = ttrs; } else { ttps = 0; };
    console.log('Total: ' + ttrs, ttps);
    $('input#ttrs-hidden').val(ttrs);
    $('input#ttps-hidden').val(ttps);
    $('#shovehere').html(ttps);
});

</script>
