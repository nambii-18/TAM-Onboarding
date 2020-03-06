<?php
ob_start();
session_start();
require('connect-hsbc.php');

if($_SESSION["qm"]!=NULL){
ob_start();
//if(!isset($_COOKIE['Eng_queue']))
//{

//}


if($conn->connect_error){
  die($conn->error);
}

 $dummy=array();
    setcookie("Eng_queue","bro");
   $_COOKIE['Eng_queue']="bro";

$qmid=$_SESSION["qm"];
$pkid=0;
date_default_timezone_set('Asia/Kolkata');
$engarr=array();
$shift="";
$sqlshift="SELECT * FROM shift";
$res=$conn->query($sqlshift);
$rowsh=mysqli_fetch_assoc($res);
$shift=$rowsh["SHIFT"];

if(isset($_POST["logout"])){
  session_destroy();
  header("Location:index.php");
}
$sqleng="SELECT * FROM c_eng;";
$resulteng=mysqli_query($conn,$sqleng);
$overengarr=array();
while($row=mysqli_fetch_assoc($resulteng)){
  array_push($overengarr, $row["CEC"]);
}
$d=date('Y-m-d');
$t=date('Y-m-d H:i:s');
if(isset($_POST["removeall"])){
  $sqlmax="SELECT MAX(DATES) as NUM  FROM t_eng";
  $resultmax=mysqli_query($conn,$sqlmax);
  $row=mysqli_fetch_assoc($resultmax);
  $max=$row["NUM"];
  $sqlremove="DELETE FROM engineer;";
  $sql_number="SELECT * FROM engineer";
  $resultset=mysqli_query($conn,$sql_number);
  while($row=mysqli_fetch_assoc($resultset)){
    $engcec=$row["CEC"];
    $recent=$row["Time_Added"];
    $state=$row["STATE"];

    if($state=='Available'){
      $sql_time="UPDATE t_eng SET S1_TIME=S1_TIME+TIMESTAMPDIFF(MINUTE,'$recent',NOW()) WHERE CEC='$engcec' AND DATES='$max' AND SHIFT='$shift'";
      $sqlc="UPDATE c_eng SET S1_TIME=S1_TIME+TIMESTAMPDIFF(MINUTE,'$recent',NOW()) WHERE CEC='$engcec'";
    }
    else if($state=='Except Manual P1/P2'){
      $sql_time="UPDATE t_eng SET S2_TIME=S2_TIME+TIMESTAMPDIFF(MINUTE,'$recent',NOW()) WHERE CEC='$engcec' AND DATES='$max' AND SHIFT='$shift'";
      $sqlc="UPDATE c_eng SET S2_TIME=S2_TIME+TIMESTAMPDIFF(MINUTE,'$recent',NOW()) WHERE CEC='$engcec'";
    }
    else{
      $sql_time="UPDATE t_eng SET S3_TIME=S3_TIME+TIMESTAMPDIFF(MINUTE,'$recent',NOW()) WHERE CEC='$engcec' AND DATES='$max' AND SHIFT='$shift'";
      $sqlc="UPDATE c_eng SET S3_TIME=S3_TIME+TIMESTAMPDIFF(MINUTE,'$recent',NOW()) WHERE CEC='$engcec'";
    }
    if($conn->query($sql_time)){
      if($conn->query($sqlc)){

      }
      else{
        echo "problem updating C_ENG".$conn->error;

      }
    }
    else{
      echo "problem uploading the time".$conn->error;
          }
  }
  if($conn->query($sqlremove)){
    echo "<div style='text-align:center;margin-top:10px; padding-bottom:10px; border-bottom:2px solid #8EC343;'>
          <div class='svg' style='display:inline-block;'>
            <svg xmlns='http://www.w3.org/2000/svg' width='26' height='26' viewBox='-263.5 236.5 26 26'>
              <g class='svg-success'>
                <circle cx='-250.5' cy='249.5' r='12'/>
                <path d='M-256.46 249.65l3.9 3.74 8.02-7.8'/>
              </g>
            </svg>
          </div>
            <span style='display:inline-block; vertical-align: super;margin-left: 10px;'>Done!</span>
        </div>
        ";
  }
  else{
    echo "Nothing to remove";
  }
}
$sql="SELECT MAX(PKID) as pkid FROM CASES";
$result=mysqli_query($conn,$sql);
 if ($result->num_rows > 0) {
$row=mysqli_fetch_assoc($result);
$pkid=$row["pkid"];
$pkid=$pkid+1;
 }
 else{
   $pkid=1000000;
 }



 if(isset($_POST["save"])){
  setcookie("Eng_queue","bro");
   $_COOKIE['Eng_queue']="bro";
   $a=array();
   foreach ($_POST as $key => $value) {
    if($key!='save')
     array_push($a,$value);
   }
     //var_dump($_POST);
   $rem=json_decode($_COOKIE["remove"]);
   $arr=json_decode($_COOKIE["append"]);
   $max=sizeof($arr);
   $max_rem=sizeof($rem);
   //var_dump($arr);
   //var_dump($a);
      for ($i=1; $i<$max; $i=$i+2)
    {
      $value=$arr[$i];
    $arr1=explode(" ",$value);
          //var_dump($arr1);
          $engid=trim($arr1[0]);
          $shift=trim($arr1[1]);
          $seq=(int)$arr1[2];
          $sql="UPDATE shift SET shift='$shift';";
		if($conn->query($sql)){}
			//echo "successfully updated";
		else
			echo  "shift problems";

      $sqlinsert="INSERT INTO ENGINEER VALUES('". date('Y/m/d')."','$seq','".$engid."','Unavailable',0,0,0,'','$t','$shift');";

      $sql="update c_eng set days=days+1 where cec='".$engid."';";
      $conn->query($sql);
      if($conn->query($sqlinsert)){
        //echo "Success";
        $sqlcheck="SELECT * FROM t_eng WHERE CEC='$engid' AND DATES='$d'";
        $result=$conn->query($sqlcheck);
        $num=$result->num_rows;
        if($num>=1){}
          else{
        $sqltime="INSERT INTO t_eng VALUES('$d','$shift','$engid',0,0,0,0,0,0,0,0,0);";
        if(mysqli_query($conn,$sqltime)){

        }
        else{
          echo "Error recording the time for $engid ".mysqli_error($conn);
        }
      }
      //header('Location: case.php');
    }
    else {
      echo $conn->error;
//      echo "<script>alert('Error occurred while adding engineers to the Queue.');
//    window.location.href='case.php'; </script>";
    //header("Locaiton: case.php");
    }
  }
  for($i=1;$i<$max_rem;$i=$i+2){
    $value=$rem[$i];
    $sqlmax="SELECT MAX(DATES) as NUM  FROM t_eng";
  $resultmax=mysqli_query($conn,$sqlmax);
  $row=mysqli_fetch_assoc($resultmax);
  $max=$row["NUM"];
      $sqldelete="DELETE FROM ENGINEER WHERE CEC='".$value."'";
      $sql_number="SELECT * FROM ENGINEER WHERE CEC='$value'";
      $resultset=mysqli_query($conn,$sql_number);
      $row=mysqli_fetch_assoc($resultset);
        $recent=$row["Time_Added"];
        $state=$row["STATE"];
        if($state=='Available'){
      $sql_time="UPDATE t_eng SET S1_TIME=S1_TIME+TIMESTAMPDIFF(MINUTE,'$recent',NOW()) WHERE CEC='$value' AND DATES='$max' AND shift='$shift'";
      $sqlc="UPDATE c_eng SET S1_TIME=S1_TIME+TIMESTAMPDIFF(MINUTE,'$recent',NOW()) WHERE CEC='$value'";

    }
    else if($state=='Except Manual P1/P2'){
      $sql_time="UPDATE t_eng SET S2_TIME=S2_TIME+TIMESTAMPDIFF(MINUTE,'$recent',NOW()) WHERE CEC='$value' AND DATES='$max' AND shift='$shift'";
      $sqlc="UPDATE c_eng SET S2_TIME=S2_TIME+TIMESTAMPDIFF(MINUTE,'$recent',NOW()) WHERE CEC='$value'";
      }
    else{
      $sql_time="UPDATE t_eng SET S3_TIME=S3_TIME+TIMESTAMPDIFF(MINUTE,'$recent',NOW()) WHERE CEC='$value' AND DATES='$max' AND shift='$shift'";
      $sqlc="UPDATE c_eng SET S3_TIME=S3_TIME+TIMESTAMPDIFF(MINUTE,'$recent',NOW()) WHERE CEC='$value'";
      }
        if($conn->query($sql_time)){
          if($conn->query($sqlc)){

          }

      }
      if($conn->query($sqldelete)){
        //echo "Success";

      //header('Location: case.php');
    }
    else {
      echo $conn->error;
    }
  }

   //end of for
   $str = json_encode($a);
   setcookie("Eng_queue",$str);
   $_COOKIE['Eng_queue']=$str;
   //var_dump(json_decode($_COOKIE['Eng_queue']));
  }
 $sqlreject="SELECT COUNT(PKID) AS NUM FROM REJECT;";
    $result3=$conn->query($sqlreject);
    $row3=mysqli_fetch_assoc($result3);
    $num_reject=$row3["NUM"];
   setcookie("append",json_encode($dummy));
   $_COOKIE["append"]=json_encode($dummy);
   setcookie("remove",json_encode($dummy));
   $_COOKIE["remove"]=json_encode($dummy);

echo "
<!DOCTYPE html>
<html lang='en'>

    <head>

        <meta charset='utf-8'>
        <title>QM Dashboard - TAM Tool &middot; Cisco CMS</title>
        <!-- <meta name='description' content='Quality Management Tool'>
  <meta name='author' content='Cisco CMS'> -->


        <meta name='viewport' content='width=device-width, initial-scale=1'>


        <link rel='stylesheet' href='css/normalize.css'>
        <link rel='stylesheet' href='css/skeleton.css'>


    <script src='js/jquery-min.js'></script>
    <script src='js/jquery.notify-better.min.js'></script>


    <link href='css/select2.min.css' rel='stylesheet'/>
    <script src='js/select2.min.js'></script>
    <script src='js/autocomplete.js'></script>


        <link rel='shortcut icon' id='favicon' href='favicon.png'>

<script type='text/javascript'>
$(document).ready(function() {
  $('.js-basic-single1').select2({
  placeholder: 'Select a Customer'
});

// $('.js-data-example-ajax').select2({
//   ajax: {
//     url: 'https://api.github.com/search/repositories',
//     dataType: 'json',
//     delay: 100,
//     data: function (params) {
//       return {
//         q: params.term, // search term
//         page: params.page
//       };
//     },
//     processResults: function (data, params) {
//       // parse the results into the format expected by Select2
//       // since we are using custom formatting functions we do not need to
//       // alter the remote JSON data, except to indicate that infinite
//       // scrolling can be used
//       params.page = params.page || 1;

//       return {
//         results: data.items,
//         pagination: {
//           more: (params.page * 30) < data.total_count
//         }
//       };
//     },
//     cache: true
//   }

// });
});

</script>



    </head>

    <body>

            <style>

            .autocomplete-suggestions { border: 1px solid #999; background: #FFF; overflow: auto; }
.autocomplete-suggestion { padding: 2px 5px; white-space: nowrap; overflow: hidden; }
.autocomplete-selected { background: #F0F0F0; }
.autocomplete-suggestions strong { font-weight: normal; color: #3399FF; }
.autocomplete-group { padding: 2px 5px; }
.autocomplete-group strong { display: block; border-bottom: 1px solid #000; }

          /*For Switch & MODAL*/

                .switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
  margin-top: 10px;
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
/*  -webkit-transition: .4s;
  transition: .4s;*/
}

.slider:before {
  position: absolute;
  content: '';
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
/*  -webkit-transition: .4s;
  transition: .4s;*/
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
                .slider.round {
  border-radius: 34px;
}
.slider.round:before {
  border-radius: 50%;
}


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
  z-index: 2;
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

<!-- <div class='container u-max-full-width'>
        <div class='row' style='padding-top:15px;'>
          div style='display:inline-block;'>
            <span style='margin-top:5px;color:grey;'>Made by folks just like you. ;)</span>
          </div
          <div style='float:right;display:inline-block;'>

          </div>
        </div>
      </div> -->
";

echo "
<div class='container u-max-full-width'>
  <div class='row' style='padding-top:15px;'>
    <div class='five columns'>
      <div style='display:table; border:1px solid #333; background:#333; margin-top:10px;padding:15px;text-align: center;vertical-align: middle;'>
      <span style='font-size: 1.2rem;padding-right: 2rem; text-transform: uppercase;color: #fff;font-weight: bolder;letter-spacing: 1px;'>Next Handoff: </span><span style='color:#fff;'><a href='reassign.php' id='timehandoff' target='_blank' style='color:#fff; text-decoration: none; border-bottom: 1px solid #fff; font-weight:bolder;' title='Reassign all Handoff Cases'></a> ↗</span>
      </div>
    </div>
    <div class='seven columns' style='float:right;'>
    <div style='float:right;'>
      <span>Welcome, ".$qmid."</span>
              <span>
                  <form method='POST' action='case.php' style='margin: 0; padding-left: 20px; display:inline-block;'>
                    <input type='submit' value='Logout &#x21b7;' name='logout' style='border: 0; border-bottom: 1px solid #212121;padding: 0;'/>
                  </form>
              </span>
              <span><a href='about.html' target='_blank' class='button' style='border: 0; border-bottom: 1px solid #212121;padding: 0;margin-left:40px;'>Developers &nbsp; 👨‍💻</a></span>
              <span><a href='mailto:amasarda@cisco.com;%20svenkatt@cisco.com;%20gkotapal@cisco.com&cc=tdominic@cisco.com;%20sribabu@cisco.com?subject=QM%20Feedback%20on%20the%20TAM%20Tool' class='button' style='border: 0; border-bottom: 1px solid #212121;padding: 0;margin-left:40px;'>Give Feedback <span style='font-size:large;'>&#x263a;</span></a></span>
              ";
                  if(mysqli_num_rows(mysqli_query($conn,"SELECT * FROM MANAGER WHERE CEC ='".$qmid."';"))>0)
                  {
                    echo "
              <span><a href='notice.php' target='_blank' class='button' style='vertical-align: bottom;margin-top:30px;color:#fff; background-color: #33C3F0;border-color: #33C3F0;margin-left:40px;'>Notices &nbsp;➦</a></span>

                  ";
                }

            echo "
            </div>
  </div>
</div>
</div>

        <div class='container u-max-full-width'>
            <div class='row' style='margin-top: 1%;'>
                <div class='twelve columns bg-this'>
                    <a href=''><svg class='img-responsive logo' style='max-width: 185px;' x='0px' y='0px' width='200.1px' height='105.4px' viewBox='-305 291.9 200.1 105.4'>
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
                    <h5 style='font-weight:lighter;float:right;'>Server Time: ".gmdate('h:i')." UTC  <span style='font-style:italic;'>Shift: ".$shift." </span></h5>
        </div>
      </div>
    </div>
      <div class='row' style='margin-top:2%'>
        <div class='five columns'>

                        <form method='POST' action='edit.php' style='margin-top:0;'>
                            <div class='field half tb' style='width: 60%;position:relative;'>
                                <label for='Search'>Search PKID to Edit</label>
                                <input type='text' id='search' name ='pkid' required style='padding: .5rem 2rem 0.1rem;' />
                                <button class='' type='submit' name='search' value='&#x2794;' style='position:absolute;right:10px;top:7px;padding:0;border:0;font-size:x-large;'>&#x2794;</button>
                            </div>
              <!-- <input class='button-primary' type='submit' name='search' value='Search'> -->
                            <!-- Submit on Return press - if entry doesn't exist in DB, redirect to case.php & alert('PKID Not Found') -->
                        </form>


                        <a href='javascript:;' id='refresh' class='button' name='refresh' onclick='awyeah();' style='margin-bottom: 2rem;display:inline-block;margin-top: -1px;border: 0; border-bottom: 1px solid #212121; padding: 0; margin-right:20px;'><object data='images/load.svg' type='image/svg+xml' style='max-width: 15px; margin-bottom: -4px; margin-right: 5px;'></object>Refresh This Panel</a>
                        <a href='#' id='export' class='button' style='margin-bottom: 2rem;display:inline-block;margin-top: -1px;border: 0; border-bottom: 1px solid #212121; padding: 0; margin-right:20px;' role='button'>Export Panel to CSV</a>

                        <!-- <h5 style='font-size: 15px;font-weight: 600;letter-spacing: .1rem;text-transform: uppercase;'>Rejected Cases: <a id='#auto_load_div' href='reject.php' target='_blank' style='text-decoration: none; border-bottom: 1px solid #000;' title='Reassign all Rejected Cases'>";
                        $sqlreject="SELECT COUNT(PKID) AS NUM FROM REJECT;";
                        $result3=$conn->query($sqlreject);
                        $row=mysqli_fetch_assoc($result3);
                        $value=$row["NUM"];
                        echo $value."</a></h5> -->

                        <div id='shovehere'>

                        <h5 style='font-size: 15px;font-weight: 600;letter-spacing: .1rem;text-transform: uppercase;'>Rejected Cases: <a href='reject.php' target='_blank' style='text-decoration: none; border-bottom: 1px solid #000;' title='Reassign all Rejected Cases'>$num_reject</a></h5>
                        <h5 style='font-size: 15px;font-weight: 600;letter-spacing: .1rem;text-transform: uppercase;'>Handoff/Scheduled Dispatch Cases: <a href='reassign.php' id='counter' target='_blank' style='text-decoration: none; border-bottom: 1px solid #000;' title='Reassign all Handoff Cases'>$num_reject</a></h5>

                        <div class='accordion'>

                        <ul>
                        <li>


                        <input type='checkbox' checked=''>
                        <!-- <i></i> -->

                        <h5 title='Click to Expand' style='font-size: 15px;font-weight: 600;letter-spacing: .1rem;text-transform: uppercase;'>View Number of Assigned Cases &nbsp; &nbsp; &#x25bc;</h5>


                            <table id='ass_cases'>
                              <thead>
                                 <tr>
                                  <th>Engg. CEC</th>
                                  <th style='cursor:ns-resize;' onclick='sort_table(sortthis, 1, asc2); asc2 *= -1; asc3 = 1; asc1 = 1; asc4 = 1; asc5 = 1; asc6 = 1;'>Auto/ESR &#x21D5;</th>
                                  <th style='cursor:ns-resize;' onclick='sort_table(sortthis, 2, asc3); asc3 *= -1; asc1 = 1; asc2 = 1; asc4 = 1; asc5 = 1; asc6 = 1;'>MP1/P2 &#x21D5;</th>
                                  <th style='cursor:ns-resize;' onclick='sort_table(sortthis, 3, asc4); asc4 *= -1; asc1 = 1; asc2 = 1; asc3 = 1; asc5 = 1; asc6 = 1;'>MP3/P4 &#x21D5;</th>
                                  <th onclick='sort_table(sortthis, 4, asc5); asc5 *= -1; asc1 = 1; asc2 = 1; asc3 = 1; asc4 = 1; asc6 = 1;'>Current State</th>
                                  <th style='cursor:ns-resize;' onclick='sort_table(sortthis, 5, asc6); asc6 *= -1; asc1 = 1; asc2 = 1; asc3 = 1; asc4 = 1; asc5 = 1;'>Weight &#x21D5;</th>
                                </tr>
                              </thead>
                              <tbody id='sortthis'>
                              ";
                              $engarr=array();
                            $sql_number="SELECT * FROM ENGINEER ORDER BY CEC";
                            $resultset=mysqli_query($conn,$sql_number);

                            while($row=mysqli_fetch_assoc($resultset)){

                                array_push($engarr,$row["CEC"]);
                                 echo "
                                <tr>
                                  <!-- <td onclick='insintofield(this);' name='engrow' style='cursor:pointer!important;'>".$row["CEC"]."</td> -->
                                  <td onclick='insintofield(this);' name='engrow' style='cursor:pointer!important;'>".$row["CEC"]."</td>
                                  <td>".$row["EA"]."</td>
                                  <td>".$row["P1P2"]."</td>
                                  <td>".$row["P3P4"]."</td>
                                  <td>".$row["STATE"]."</td>
                                  <td></td>
                                </tr>";
                            }

                            json_encode($engarr);
                            echo "
                            <tr style='border-top:2px solid #000;'>
                              <td style='font-weight:bolder;'>Total</td>
                              <td id='autocount'></td>
                              <td id='mp1count'></td>
                              <td id='mp3count'></td>
                              <td style='font-weight:bolder;'>= <span id='allcount'></span></td>
                              <td></td>
                            </tr>

                              </tbody>
                            </table>
                            </li>
                            </ul>


                        </div>
                      </div>


                </div>
                <div class='seven columns'>
                <div class='row'>
                <div class='four columns'>
                    <h4 style='font-weight:bolder;'>Assign a Case</h4>
                    </div>
                    <div class='eight columns' style='float:right;'>

                    <a href='caseview.php' target='_blank' class='button' style='float:right;margin-top:-1px;border:0;border-bottom:1px solid #212121; padding:0;display:inline-block;font-size: 11px;font-weight: 600;line-height: 38px;'>View Cases</a>
                    <a href='reporter.php' target='_blank' class='button' style='float:right;margin-top:-1px;border:0;border-bottom:1px solid #212121; padding:0;display:inline-block;font-size: 11px;font-weight: 600;margin-right:30px;line-height: 38px;'>Reporting</a>
                    <a href='dispatchlist.php' target='_blank' class='button' style='float:right;margin-top:-1px;border:0;border-bottom:1px solid #212121; padding:0;display:inline-block;font-size: 11px;font-weight: 600;margin-right:30px;line-height: 38px;'>Dispatched Cases</a>

              <button style='border:0;border-bottom:1px solid #212121; padding:0;display: inline-block;font-size: 11px;font-weight: 600;margin-right:30px;line-height: 38px;float:right;margin-top:-1px;' class='button' id='open-modal-active'>Active Engineers</button>
              <button style='border:0;border-bottom:1px solid #212121; padding:0;display: inline-block;font-size: 11px;font-weight: 600;margin-right:30px;line-height: 38px;float:right;margin-top:-1px;' class='button' id='open-modal-time'>Time Spent</button>
              <a href='admin.php' target='_blank' class='button' style='float:right;margin-right:30px;margin-top:-1px;border:0;border-bottom:1px solid #212121; padding:0;display:inline-block;font-size: 11px;font-weight: 600;line-height: 38px;'>Admin</a>
              </div>
              </div>
                    <hr style='margin-top:0;'>
                    <form method='POST' action='insert.php'>

                    <div class='half'>
                    <label for='' style='font-size: 1.2rem;padding: 1.5rem 2rem 0;text-transform: uppercase;color: #999;font-weight: 700;letter-spacing: 1px;'>Select a Case Type</label>
                    <input type='radio' id='auto' name='case_type' value='Auto'><span style='padding:0 20px 0 7px;'>Auto/ESR</span>
                    <input type='radio' id='man1' name='case_type' value='Manual P1/P2'><span style='padding:0 20px 0 7px;'>Manual P1/P2</span>
                    <input type='radio' id='man2' name='case_type' value='Manual P3/P4'><span style='padding:0 20px 0 7px;'>Manual P3/P4</span>
                    <span title='Select A Case Type to enable other fields' style='font-weight:bolder;font-size:1.5em;margin-right:20px;line-height: 1em;cursor: help;color:red;float:right;'>&#9432;</span>
                    </div>

                        <div class='half'>
                            <label for='' style='font-size: 1.2rem;padding: 1.5rem 2rem 0;text-transform: uppercase;color: #999;font-weight: 700;letter-spacing: 1px;'>Select a Map/Customer</label>
                            <select class='js-basic-single1' id='customers' name='customer' style='border-radius:0px!important; width:60%;' disabled>
                                                    ";
                                                    $sqlcust="SELECT * FROM customer;";
                                                    $resultcust=mysqli_query($conn,$sqlcust);
                                                    $rowc=mysqli_fetch_assoc($resultcust);
                                                    if(mysqli_num_rows($resultcust)==1){
                                                        echo "<option value='".$rowc["CUSTOMER"]."' selected>".$rowc["CUSTOMER"]."</option> ";
                                                    }
                                                    else{
                                                    while($rowc=mysqli_fetch_assoc($resultcust)){
                                                      echo "<option value='".$rowc["CUSTOMER"]."'>".$rowc["CUSTOMER"]."</option> ";
                                                   }
                                                    }
                                                    echo "
                                                  </select>
                        </div>

                        <div class='field tb' style='margin-top:3rem'>
                            <label for='Case Number/Email Subject'>Case Number/Email Subject</label>
                            <input type='text' id='cNum' name='caseNum' readonly required/>
                            <input type='hidden' name='shift' value=$shift required/>
                        </div>
                        <div class='field half tnb'>
                            <label for='name'>QM CEC ID</label>
                            <input type='text' id='qID' name='qmid' value=".$qmid." readonly required/>
                            <!-- To be Autofilled for a user's session -->
                        </div>
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

            /*#modaltable th, td {
              padding: 5px 60px !important;
            }*/
            </style>
                        <div class='field half tnb last'>
                            <label for='eID'>Engineer CEC ID</label>";

              //if(isset($_COOKIE['Eng_queue']) && $_COOKIE['Eng_queue'] !="bro" )
              //{
              //$arr=json_decode($_COOKIE['Eng_queue']);
              //$first=array_shift($arr);
              //no setting here
              //}
              //else
                //$first="";

              echo"
                            <input readonly='readonly' required='required' type='text' id='eID' name='engcecid'>
              <!-- <select class='js-data-example-ajax' id='engineers' name='engineers' style='width:93.3%'>
              <option value='Engg A'>Engg A</option>
              <option value='Engg B'>Engg B</option>
              <option value='Engg C' selected>Engg C</option>
              <option value='Engg D'>Engg D</option>
               <option value='3620194' selected='selected'>select2/select2</option>
              </select> -->
                        </div>
                        <div class='field half tnb'>
                            <label for='datetime'>Date &amp; Time</label>
                            <input type='text' id='datetime' value='".date( 'Y-m-d H:i:s')."' required readonly/>
                            <!-- To be Autofilled from the server -->
                        </div>
                        <div class='field half last tnb'>
                            <label for='pkid'>PKID</label>
                            <input type='text' id='pkID' name='pk' value='$pkid' required readonly >
                        </div>



                        <input class='button-primary' type='submit' name='assign' value='Assign'>
                        <input class='button' type='button' value='Reload Page' onclick='window.location.reload();'>


                    </form>

                </div>
        </div>
            </div>
        </div>
        <div id='mama'></div>";?>

          <!-- Code for  Time Spent MODAL -->

          <div class='modal modal-close' id='modal-time'>
  <div class='modal-inner' id='modal-inner-time'>
    <div class='modal-content' id='modal-content-time' style='overflow:auto'>
      <div class='modal-close-icon'>
        <a href='javascript:void(0)' class='close-modal-time'><i class='fa fa-times' aria-hidden='true'></i></a>
      </div>
      <div class='modal-content-inner'>
        <h5 style='font-weight:bolder;'>Time Spent in Each State for Current Shift</h5>
        <hr>

        <table id='laale'>
                        <thead>
                            <tr>
                                <th>Engineer CEC</th>
                                <th>Time Spent in Available (mins)</th>
                                <th>Time Spent in Except P1/P2 (mins)</th>
                                <th>Time Spent in Unavailable (mins)</th>
                                <th>Current State</th>

                            </tr>
                        </thead>
                            <?php

                            if($conn->connect_error){
                              die($conn->error);
                            }

                                  $sqlmodal="SELECT * FROM ENGINEER e inner join t_eng t on e.dates=t.dates and t.cec=e.cec where t.DATES='".date("Y-m-d")."' ;";
                                  //echo $sqlmodal;
                                  $result2=mysqli_query($conn,$sqlmodal);
                                  while($row=mysqli_fetch_assoc($result2))
                                  {


                            echo"
                            <tr>
                                <td>".$row["CEC"]."</td>
                                <td>".$row["S1_TIME"]."</td>
                                <td>".$row["S2_TIME"]."</td>
                                <td>".$row["S3_TIME"]."</td>
                                <td>".$row["STATE"]."</td>

                            </tr>";
                          }
                            ?>


                    </table>
      </div>
      <div class='modal-buttons'>
        <button class='button button-primary close-modal' id='close-modal-time'>Close</button>
      </div>
    </div>
  </div>
</div>

<?php
    $sqlmodal="SELECT * FROM ENGINEER ORDER BY SEQ;";
            $result2=mysqli_query($conn,$sqlmodal);
            $rowseq =mysqli_num_rows($result2)+1;

 echo"
    <!-- Code for MODAL -->

          <div class='modal modal-close' id='modal-active'>
            <div class='modal-inner' id='modal-inner-active'>
            <div class='modal-content' id='modal-content-active' style='overflow:auto'>
              <div class='modal-close-icon'>
              <a href='javascript:void(0)' class='close-modal'><i class='fa fa-times' aria-hidden='true'></i></a>
              </div>
              <div class='modal-content-inner'>
                <!-- <p>This table shows all Active Engineers on this shift. The toggle switch shows if an Engineer is Available for the current shift.<br><br>Please click <span style='font-weight:bolder'>Save</span> to preserve changes.</p> -->
                <p>Please click <span style='font-weight:bolder'>Save</span> to preserve changes.</p>
                <form>
                  <div class='field'>
                    <label>Append an Engineer to the queue</label>
                    <input placeholder='Enter Engineer CEC Here' id='addByCEC' type='text' required />
                  </div>

                  <div class='field tnb half'>
                  <label>Shift</label>
                  <select name='shift' id='shiftByCEC' style='border:0; margin-left:15px; margin-top: 7px;margin-bottom: 20px;border-radius:0px!important;' required='required'>
                  <option value='' selected>Select a Shift</option>
                  <option value='A'>Shift A</option>
                  <option value='B'>Shift B</option>
                  <option value='C'>Shift C</option>
                  <option value='D'>Shift D</option>
                  </select>
                  </div>

                  <div class='field tnb half last'>
                  <label>Sequence Number (in Queue)</label>
                    <input type='number' id='seq_numform' min='$rowseq' value='$rowseq' style='margin-left: 19px;margin-top: 7px;margin-bottom: 15px;width: 30%;text-align: center;border: 0.5px solid #ddd;height: 27px;' required='required'>
                  </div>


                  <div class='row'>
                  <input type='button' class='button-primary' onclick='insRow()' value='Add'>

                  </form>

                  <form action='case.php' method='POST' style='margin: 0; padding: 0; display: inline-block;'><input type='submit' class='button' value='Remove All' name='removeall'></form>

                <form method='POST' action='case.php'>
                <table id='modaltable' class='u-max-full-width'>

                <thead>
                  <tr>
                    <th style='padding: 5px 100px; white-space: nowrap; padding-left: 0px;'>Seq. #</th>
                    <th style='padding: 5px 100px; white-space: nowrap; padding-left: 0px;'>Engineer CEC</th>
                    <th>Shift</th>
                    <!-- <th>Active/Inactive</th> -->
                    <th>Remove</th>
                  </tr>
                </thead>


            <tbody>
                            ";//if cookie is set, fetch the values from the cookie. if not from the database



              $a=array();

              while ($row2=mysqli_fetch_assoc($result2)){
                //var_dump($row2);
                array_push($a,$row2["CEC"]);
              if($row2["STATE"]=="Available"){
                $check="checked";
                array_push($a, $row2["CEC"]);
              }
              else{
                $check="";
              }
              echo "
              <tr>
                                <td>".$row2['SEQ']."</td>
                                <td class='remove_engg' style='padding: 5px 0px;'>".$row2["CEC"]."</td>
                                <td>".$row2["SHIFT"]."</td>
                                <!-- <td><label class='switch'><input type='checkbox' ".$check." value='".$row2["CEC"]."' name='".$row2["CEC"]."' disabled/><div class='slider round'></div></label></td> -->
                <td><input type='button' class='button removecolor' value='Remove' onclick='deleteRow(this);'></td>
                            </tr>
              ";

              }

              //$str = json_encode($a);
              //setcookie("Eng_queue",$str);
              //$_COOKIE['Eng_queue']=$str;



              echo "

              </tbody>
              </table>
              </div>
            <div class='modal-buttons'>
            <button type='submit' class='button button-primary close-modal' id='close-modal-active' name='save'>Save</button>
            <!-- button type='button' class='button button close-modal'>Close</button -->
            </div>

            </form>
          </div>
          </div>
        </div>





           <script>
 //Modal for Active Engineers
 var modal = document.querySelector('#modal-active');
var closeButtons = document.querySelectorAll('#close-modal-active');
// set open modal behaviour
document.querySelector('#open-modal-active').addEventListener('click', function() {
  modal.classList.toggle('modal-open');
});
// set close modal behaviour
for (i = 0; i < closeButtons.length; ++i) {
  closeButtons[i].addEventListener('click', function() {
    modal.classList.toggle('modal-open');
  });
}
// close modal if clicked outside content area
document.querySelector('#modal-inner-active').addEventListener('click', function() {
  modal.classList.toggle('modal-open');
});
// prevent modal inner from closing parent when clicked
document.querySelector('#modal-content-active').addEventListener('click', function(e) {
  e.stopPropagation();
});


//Modal for Time Spent
 var modal0 = document.querySelector('#modal-time');
var closeButtons0 = document.querySelectorAll('#close-modal-time');
// set open modal behaviour
document.querySelector('#open-modal-time').addEventListener('click', function() {
  modal0.classList.toggle('modal-open');
});
// set close modal behaviour
for (i = 0; i < closeButtons0.length; ++i) {
  closeButtons0[i].addEventListener('click', function() {
    modal0.classList.toggle('modal-open');
  });
}
// close modal if clicked outside content area
document.querySelector('#modal-inner-time').addEventListener('click', function() {
  modal0.classList.toggle('modal-open');
});
// prevent modal inner from closing parent when clicked
document.querySelector('#modal-content-time').addEventListener('click', function(e) {
  e.stopPropagation();
});

 </script>


";
}
 else{
  echo "
  <script>alert('Authentication Failed, Redirecting to Login now.');</script>
  ";
  header("Location:forbidden.html");
}

echo "
    </body>

</html>";

ob_end_flush();

?>





<script>

var addedEngArr = [];

function insRow()
{

  var engName = $('#addByCEC').val();
    var seqNum = $('#seq_numform').val();

    console.log('sequence number: '+seqNum);


  var engShift = $('#shiftByCEC').find('option:selected').val();
    console.log(engShift);




if(engName === '')
{

}
    else if(addedEngArr.includes(engName)) //Compare incoming engineer name with Engineer Array
            {
                console.log('thisvaluemust: '+addedEngArr.includes(engName))
                alert('Engineer already in the queue. Please remove the old entry and add them again.');
                $('#addByCEC').val('');
                $('#addByCEC').focus();
            }

    else {
//        "<input type='text' value='seqNum' style='margin-bottom:0;width: 30%;text-align: center;border: 0.5px solid #ddd;height: 30px;'>"


  $('#modaltable').append("<tr>" + "<td>" + seqNum + "</td>" + "<td>" + engName + "</td>" + "<td>" + engShift + "</td>" + "<td>" + "<input type='button' class='button removecolor' value='Remove' onclick='deleteRow(this)'/>" + "</td>" + "</tr>");
  $('#addByCEC').val('');
//  $('#shiftByCEC').val('');
seqNumNew = parseInt(seqNum) + 1;
  $('#seq_numform').val(seqNumNew);
  $('#addByCEC').focus();

        addedEngArr.push(engName);
        console.log(addedEngArr);

//   addedEngArr = $('#modaltable td:nth-child(2)').map(function(){
//       console.log('All my boys: '+$(this).text());
//   }).get();

    console.log('Look at this: '+addedEngArr);
     //Populate this Engineer Array with all of the engineers in #modaltable; this would happen everytime the Add button is clicked




    var shift_eng = engName + " " + engShift + " " + seqNum;

  //Add to Cookie
  var decoded = readCookie('append');
  var decoded2 = decodeURIComponent(decoded);//string encoded

  console.log(decoded2);

  var jsobj = JSON.parse(decoded2);
  console.log(jsobj.length);
  jsobj[jsobj.length+1]=shift_eng;

  var str = JSON.stringify(jsobj);

  var encoded = encodeURIComponent(str);//string encoded

  console.log(encoded);
   //set the new cookie with the new guy
     createCookie ('append', encoded);
   //read a new cookie
   var cookie = readCookie('append');

  console.log(cookie);

 }

}

function deleteRow(row)
{
  var i = row.parentNode.parentNode.rowIndex;
  var modaltable = document.getElementById('modaltable');

  var engName = $('#modaltable tr').eq(i).find('td').eq(1).text();

  //var engName = $('.remove_engg')[i];
  console.log('You: ' + engName);

  //console.log(rem_cookie);

  //Remove Cookie for that guy
  var removing = readCookie('remove');
  var removing2 = decodeURIComponent(removing);

  // console.log(removing2);
  var jsobj_remove = JSON.parse(removing2);

  // console.log(jsobj_remove.length);
  jsobj_remove[jsobj_remove.length+1]=engName;

  var str_remove = JSON.stringify(jsobj_remove);
  var encoded_remove = encodeURIComponent(str_remove);

  // console.log(encoded_remove);
  createCookie ('remove', encoded_remove);
  var cookie_remove = readCookie('remove');

  console.log(cookie_remove);



  document.getElementById('modaltable').deleteRow(i);

}

// function deleteAll()
// {
//  var table = document.getElementById('modaltable');
//  var rowCount = table.rows.length;
//  for (var i=0; i< rowCount; i++){
//    table.deleteRow(1);
//  }
// }

//Expire existing cookie & append bro



//Read a cookie

function readCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1,c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
    }
    return null;
}

var createCookie = function(name, value, days) {
    var expires;
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toGMTString();
    }
    else {
        expires = "";
    }
    console.log(name);
    console.log(value);
    document.cookie = name + "=" + value;
}



</script>

<script>
function tick()
{
  //alert('Hello');
    //get the mins & hours of the current time
    var now = new Date();
    hours = now.getUTCHours();
    mins = now.getUTCMinutes();

  //console.log(hours);
  //console.log(mins);

  if(hours == 07 && mins == 30) {

    document.cookie = 'Eng_queue =; expires=Thu, 01 Jan 1970 00:00:01 GMT;';
    setTimeout(function() { window.location.reload(); }, 60000);

     }

   else if(hours == 01 && mins == 30) {
    //alert("Enter 2");
    document.cookie = 'Eng_queue =; expires=Thu, 01 Jan 1970 00:00:01 GMT;';
    setTimeout(function() { window.location.reload(); }, 60000);
     }
     else if(hours == 13 && mins == 30) {
     //alert("Enter 3");
     document.cookie = 'Eng_queue =; expires=Thu, 01 Jan 1970 00:00:01 GMT;';
    setTimeout(function() { window.location.reload(); }, 60000);
     }
     else if(hours == 19 && mins == 30) {
       //alert("Enter 4");
     document.cookie = 'Eng_queue =; expires=Thu, 01 Jan 1970 00:00:01 GMT;';
    setTimeout(function() { window.location.reload(); }, 60000);
     }

}

setInterval(function() { tick(); }, 1000);
</script>

<script>
$(function(){
    $('#auto, #man1, #man2').change(function(){

      $('#customers').attr('disabled',true);
        if($('#auto, #man1, #man2').is(':checked')){
          console.log('Alive2');
            $('#customers').removeAttr('disabled');
        }

        $('#cNum, #eID').attr('readonly',true);
        if($('#auto, #man1, #man2').is(':checked')){
          console.log('Alive');
            $('#cNum').removeAttr('readonly');
            $('#eID').removeAttr('readonly');
            $('#cNum').focus();
        }

    });
});

// $(function(){
//     $('#auto, #man1, #man2').change(function(){

//         $('#customers').attr('disabled',true);
//         if($('#auto, #man1, #man2').is(':checked')){
//           console.log('Alive2');
//             $('#customers').removeAttr('readonly');
//         }
//     });
// });
</script>

<script type='text/javascript'>
        $(document).ready(function () {

            //console.log("HELLO")
            function exportTableToCSV($table, filename) {
                var $headers = $table.find('tr:has(th)')
                    ,$rows = $table.find('tr:has(td)')

                    // Temporary delimiter characters unlikely to be typed by keyboard
                    // This is to avoid accidentally splitting the actual contents
                    ,tmpColDelim = String.fromCharCode(11) // vertical tab character
                    ,tmpRowDelim = String.fromCharCode(0) // null character

                    // actual delimiter characters for CSV format
                    ,colDelim = '","'
                    ,rowDelim = '"\r\n"';

                    // Grab text from table into CSV formatted string
                    var csv = '"';
                    csv += formatRows($headers.map(grabRow));
                    csv += rowDelim;
                    csv += formatRows($rows.map(grabRow)) + '"';

                    // Data URI
                    var csvData = 'data:application/csv;charset=utf-8,' + encodeURIComponent(csv);

                // For IE (tested 10+)
                if (window.navigator.msSaveOrOpenBlob) {
                    var blob = new Blob([decodeURIComponent(encodeURI(csv))], {
                        type: "text/csv;charset=utf-8;"
                    });
                    navigator.msSaveBlob(blob, filename);
                } else {
                    $(this)
                        .attr({
                            'download': filename
                            ,'href': csvData
                            //,'target' : '_blank' //if you want it to open in a new window
                    });
                }

                //------------------------------------------------------------
                // Helper Functions
                //------------------------------------------------------------
                // Format the output so it has the appropriate delimiters
                function formatRows(rows){
                    return rows.get().join(tmpRowDelim)
                        .split(tmpRowDelim).join(rowDelim)
                        .split(tmpColDelim).join(colDelim);
                }
                // Grab and format a row from the table
                function grabRow(i,row){

                    var $row = $(row);
                    //for some reason $cols = $row.find('td') || $row.find('th') won't work...
                    var $cols = $row.find('td');
                    if(!$cols.length) $cols = $row.find('th');

                    return $cols.map(grabCol)
                                .get().join(tmpColDelim);
                }
                // Grab and format a column from the table
                function grabCol(j,col){
                    var $col = $(col),
                        $text = $col.text();

                    return $text.replace('"', '""'); // escape double quotes

                }
            }


            // This must be a hyperlink
            $("#export").click(function (event) {
                // var outputFile = 'export'
                var outputFile = window.prompt("What do you want to name your output file? (Note: This won't have any effect on Safari)") || 'export';
                outputFile = outputFile.replace('.csv','') + '.csv'

                // CSV
                exportTableToCSV.apply(this, [$('#ass_cases'), outputFile]);

                // IF CSV, don't do event.preventDefault() or return false
                // We actually need this to be a typical hyperlink
            });
        });
    </script>

 <script type="text/javascript">
var awyeah;
    $(function () {
      //$("#refresh").click(function awyeah() {

        $(document).ready(

          awyeah = function () {

//function awyeah() {
        console.log("hello");

        $.ajax({
          method: "GET",
          url: "test.php?refresh=1",
          cache: false,
          success: function(data){
            //console.log(data);
             $("#shovehere").html(data);

              var count = $("#counter").text();
              console.log(count);

            if(count > 0) {
              console.log("I'm in.");
              // alert("You have a pending handoff reassignment.");
              // var audio = new Audio('bell_ring.mp3');
              // audio.play();

            }

          }
        });
        setTimeout (awyeah, 30000);
        //setInterval(awyeah, 30000 );
      });

    });

//setInterval(awyeah, 30000 );



    </script>



    <script type="text/javascript">
      function insintofield (row) {
        console.log(row);
        var engassname = row.innerHTML;
        console.log(engassname);

            $.ajax({
                type: "GET",
                url: "test.php?click=1&eng="+engassname,
                //data: {engassname},
                success: function (data) {
                    console.log(data);
                     $('#mama').html(data);
                    //f (data == 1) {
                      //alert("Warning: This Engineer is Unavailable at the moment. You can still assign them this case or pick another engineer.");
                    //}
                }
            });

//In case.php, check for the engineer CEC, compare to STATE from DB. If the engineer is unavailable, return a 1.

        document.getElementById("eID").value = engassname;
      }

    </script>

    <script>
    var people, asc5 = 1, asc4 = 1, asc1 = 1, asc2 = 1, asc3 = 1;

window.onload = function () {
    people = document.getElementById("sortthis");
}

function sort_table(tbody, col, asc) {
    var rows = tbody.rows,
        rlen = rows.length,
        arr = new Array(),
        i, j, cells, clen;
    // fill the array with values from the table
    for (i = 0; i < rlen; i++) {
        cells = rows[i].cells;
        clen = cells.length;
        arr[i] = new Array();
        for (j = 0; j < clen; j++) {
            arr[i][j] = cells[j].innerHTML;
        }
    }
    // sort the array by the specified column number (col) and order (asc)
    arr.sort(function (a, b) {
        return (a[col] == b[col]) ? 0 : ((a[col] > b[col]) ? asc : -1 * asc);
    });
    // replace existing rows with new rows created from the sorted array
    for (i = 0; i < rlen; i++) {
        rows[i].innerHTML = "<td>" + arr[i].join("</td><td>") + "</td>";
    }
}
    </script>

    <script>


    var obj = <?php echo json_encode($engarr); ?>;
    console.log(obj);


// var test = [ {"html": "<span style='color:green;text-shadow: 0 0 3px green;font-size:small;'>&#11044;</span>", "name": "svenkatt"}, {"html": "<span style='color:green;text-shadow: 0 0 3px crimson;font-size:small;'>&#11044;</span>", "name": "gkotapal"} ];

// var parseddata = JSON.parse(test);
// console.log(obj);

$('#eID').autocomplete({
  // serviceUrl: 'test.php',
    lookup: obj
    // lookup: test
    // onSelect: function (suggestion) {
    //     console.log('You selected: ' + suggestion.value + ', ' + suggestion.data);
    // }
});

</script>

<script type="text/javascript">
  var obj2 = <?php echo json_encode($overengarr); ?>;
    console.log(obj);

    $("#addByCEC").autocomplete({
      lookup: obj2
    })

</script>

 <script>

 $("#notification").notify_better({
  interval: 0, // Interval between each polling in milliseconds. If you want notification to update faster, lower the number or vice versa. Set to 0/false to execute only once on page load. Default is 5000 (5 seconds)
  url: "ho_count.html", // The URL to retrieve the notification count.
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

<!-- <script type="text/javascript">
  window.onblur= function() {window.onfocus= function () {location.reload(true)}};
</script> -->
<script>


var noob;
    $(function () {
      //$("#refresh").click(function awyeah() {

        $(document).ready(

          noob = function () {

//function awyeah() {
        console.log("hellofromtheotherside");

        $.ajax({
          method: "GET",
          url: "test.php?handoff=1",
          cache: false,
          success: function(data){
            //console.log(data);
             $("#timehandoff").text(data);
              // var count = $("#counter").text();
              console.log(data);
              console.log('Heelloooooo');

            }

          });
        setTimeout (noob, 30000);
        //setInterval(awyeah, 30000 );
      });

    });

//setInterval(awyeah, 30000 );




</script>
