<?php
error_reporting(0);
ob_start();
$output="";
$output = exec("C:/Python27/python.exe C:/wamp64/cgi-bin/HSBC/htmlprint.py",$output,$return);
?>
<?php

$output="";
$output = exec("C:/Python27/python.exe C:/wamp64/cgi-bin/HSBC/wp.py",$output,$return);
?>

<?php

$output="";
$output = exec("C:/Python27/python.exe C:/wamp64/cgi-bin/HSBC/count.py",$output,$return);
?>

<?php
$mysqlserver1="localhost";
$mysqlusername1="root";
$mysqlpassword1="krithu";
$link1=mysqli_connect('localhost', $mysqlusername1, $mysqlpassword1, 'tam-hsbc') or die ("Error connecting to mysql server: ".mysqli_error($link1));

$cdquery1="SELECT COUNT(CEC) AS B FROM c_eng WHERE GDC='Bangalore'";
$cdresult1=mysqli_query($link1,$cdquery1) or die ("Query to get data from cases failed: ".mysqli_error($link1));
$cdrow=mysqli_fetch_assoc($cdresult1);
 $GDCB=$cdrow["B"];

$cdquery2="SELECT COUNT(CEC) AS K FROM c_eng WHERE GDC='Krakow'";
$cdresult2=mysqli_query($link1,$cdquery2) or die ("Query to get data from cases failed: ".mysqli_error($link1));
$cdrow2=mysqli_fetch_assoc($cdresult2);
 $GDCK=$cdrow2["K"];

$cdquery3="SELECT COUNT(CEC) AS R FROM c_eng WHERE GDC='RTP'";
$cdresult3=mysqli_query($link1,$cdquery3) or die ("Query to get data from cases failed: ".mysqli_error($link1));
$cdrow3=mysqli_fetch_assoc($cdresult3);
 $GDCR=$cdrow3["R"];

$GDCT=$GDCB+$GDCK+$GDCR;
?>



<?php


$mysqlserver="localhost";
$mysqlusername="root";
$mysqlpassword="krithu";
$link=mysqli_connect('localhost', $mysqlusername, $mysqlpassword, 'tam-hsbc') or die ("Error connecting to mysql server: ".mysqli_error($link));

$dbname = 'tam-hsbc';


$cdquery="SELECT AVG(S1_TIME) as S1_TIME FROM c_eng";
$cdquery1="SELECT AVG(S2_TIME) as S2_TIME FROM c_eng ";
$cdquery2="SELECT AVG(S3_TIME) as S3_TIME FROM c_eng ";
$cdresult=mysqli_query($link,$cdquery) or die ("Query to get data from review failed: ".mysqli_error($link));
$cdresult1=mysqli_query($link,$cdquery1) or die ("Query to get data from review failed: ".mysqli_error($link));
$cdresult2=mysqli_query($link,$cdquery2) or die ("Query to get data from review failed: ".mysqli_error($link));

$s1=array();
$s2=array();
$s3=array();

json_encode($s1);
json_encode($s2);
json_encode($s3);
$cdrow=mysqli_fetch_assoc($cdresult);
  $s1=$cdrow["S1_TIME"];

//array_push($rej,$cdrow["REJECTED"]);
$cdrow=mysqli_fetch_assoc($cdresult1);
 $s2=$cdrow["S2_TIME"];
$cdrow=mysqli_fetch_assoc($cdresult2);
  $s3=$cdrow["S3_TIME"];

$d=$s1+$s2+$s3;
$t1=($s1*100)/$d;
$t2=$s2*100/$d;
$t3=$s3*100/$d;

$cdqueryb="SELECT AVG(S1_TIME) as S1_TIME FROM c_eng where GDC='Bangalore'";
$cdqueryb1="SELECT AVG(S2_TIME) as S2_TIME FROM c_eng where GDC='Bangalore'";
$cdqueryb2="SELECT AVG(S3_TIME) as S3_TIME FROM c_eng where GDC='Bangalore'";
$cdresultb=mysqli_query($link,$cdqueryb) or die ("Query to get data from review failed: ".mysqli_error($link));
$cdresultb1=mysqli_query($link,$cdqueryb1) or die ("Query to get data from review failed: ".mysqli_error($link));
$cdresultb2=mysqli_query($link,$cdqueryb2) or die ("Query to get data from review failed: ".mysqli_error($link));

$sb1=array();
$sb2=array();
$sb3=array();

json_encode($sb1);
json_encode($sb2);
json_encode($sb3);
$cdrow=mysqli_fetch_assoc($cdresultb);
  $sb1=$cdrow["S1_TIME"];

//array_push($rej,$cdrow["REJECTED"]);
$cdrow=mysqli_fetch_assoc($cdresultb1);
 $sb2=$cdrow["S2_TIME"];
$cdrow=mysqli_fetch_assoc($cdresultb2);
  $sb3=$cdrow["S3_TIME"];

$db=$sb1+$sb2+$sb3;
$tb1=($sb1*100)/$db;
$tb2=$sb2*100/$db;
$tb3=$sb3*100/$db;


$cdqueryk="SELECT AVG(S1_TIME) as S1_TIME FROM c_eng where GDC='Krakow'";
$cdqueryk1="SELECT AVG(S2_TIME) as S2_TIME FROM c_eng where GDC='Krakow'";
$cdqueryk2="SELECT AVG(S3_TIME) as S3_TIME FROM c_eng where GDC='Krakow'";
$cdresultk=mysqli_query($link,$cdqueryk) or die ("Query to get data from review failed: ".mysqli_error($link));
$cdresultk1=mysqli_query($link,$cdqueryk1) or die ("Query to get data from review failed: ".mysqli_error($link));
$cdresultk2=mysqli_query($link,$cdqueryk2) or die ("Query to get data from review failed: ".mysqli_error($link));

$sk1=array();
$sk2=array();
$sk3=array();

json_encode($sk1);
json_encode($sk2);
json_encode($sk3);
$cdrow=mysqli_fetch_assoc($cdresultk);
  $sk1=$cdrow["S1_TIME"];

//array_push($rej,$cdrow["REJECTED"]);
$cdrow=mysqli_fetch_assoc($cdresultk1);
 $sk2=$cdrow["S2_TIME"];
$cdrow=mysqli_fetch_assoc($cdresultk2);
  $sk3=$cdrow["S3_TIME"];

$dk=$sk1+$sk2+$sk3;
$tk1=($sk1*100)/$dk;
$tk2=$sk2*100/$dk;
$tk3=$sk3*100/$dk;

$cdqueryr="SELECT AVG(S1_TIME) as S1_TIME FROM c_eng where GDC='RTP'";
$cdqueryr1="SELECT AVG(S2_TIME) as S2_TIME FROM c_eng where GDC='RTP'";
$cdqueryr2="SELECT AVG(S3_TIME) as S3_TIME FROM c_eng where GDC='RTP'";
$cdresultr=mysqli_query($link,$cdqueryr) or die ("Query to get data from review failed: ".mysqli_error($link));
$cdresultr1=mysqli_query($link,$cdqueryr1) or die ("Query to get data from review failed: ".mysqli_error($link));
$cdresultr2=mysqli_query($link,$cdqueryr2) or die ("Query to get data from review failed: ".mysqli_error($link));

$sr1=array();
$sr2=array();
$sr3=array();

json_encode($sr1);
json_encode($sr2);
json_encode($sr3);
$cdrow=mysqli_fetch_assoc($cdresultr);
  $sr1=$cdrow["S1_TIME"];

//array_push($rej,$cdrow["REJECTED"]);
$cdrow=mysqli_fetch_assoc($cdresultr1);
 $sr2=$cdrow["S2_TIME"];
$cdrow=mysqli_fetch_assoc($cdresultr2);
  $sr3=$cdrow["S3_TIME"];

$dr=$sr1+$sr2+$sr3;
$tr1=($sr1*100)/$dr;
$tr2=$sr2*100/$dr;
$tr3=$sr3*100/$dr;

?>

<?php



$mysqlserver="localhost";
$mysqlusername="root";
$mysqlpassword="krithu";
$link=mysqli_connect('localhost', $mysqlusername, $mysqlpassword, 'tam-hsbc') or die ("Error connecting to mysql server: ".mysqli_error($link));

$dbname = 'tam-hsbc';
$cdquery="SELECT (S1_TIME+S2_TIME+S3_TIME) as S FROM c_eng where (S1_TIME+S2_TIME+S3_TIME)<>0 ORDER BY CEC ";
$cdquery1="SELECT (S3_TIME*100) as asa FROM c_eng where (S1_TIME+S2_TIME+S3_TIME)<>0 order BY CEC ";
$cdquery2="SELECT CEC FROM c_eng where (S1_TIME+S2_TIME+S3_TIME)<>0 order BY CEC";
$cdresult=mysqli_query($link,$cdquery) or die ("Query to get data from review failed: ".mysqli_error($link));
$cdresult1=mysqli_query($link,$cdquery1) or die ("Query to get data from review failed: ".mysqli_error($link));
$cdresult2=mysqli_query($link,$cdquery2) or die ("Query to get data from review failed: ".mysqli_error($link));

$rej=array();
$cec=array();
$ea=array();
json_encode($ea);
$tot=array();
$una=array();
while ($cdrow=mysqli_fetch_assoc($cdresult)) {
  array_push($tot,$cdrow["S"]);

}

while ($cdrow=mysqli_fetch_assoc($cdresult2)) {
  array_push($cec,$cdrow["CEC"]);
}
while ($cdrow=mysqli_fetch_assoc($cdresult1)) {
 array_push($una,$cdrow["asa"]); }
/*
$pu=array();
foreach(array_combine($una, $tot) as $u => $t){
  array_push($pu, ($u/$t));

}*/

$pu=array();
for ($i = 0; $i < sizeof($una); $i++) {
    $pu[$i]=$una[$i]/$tot[$i];
}

$cdqueryr="SELECT (EA_COUNT+P3P4_COUNT+P1P2_COUNT) as S FROM c_eng where (EA_COUNT+P3P4_COUNT+P1P2_COUNT)<>0 ORDER BY CEC ";
$cdquery1r="SELECT (REJECTED*100) as R FROM c_eng where (EA_COUNT+P3P4_COUNT+P1P2_COUNT)<>0 order BY CEC ";
$cdquery2r="SELECT CEC FROM c_eng where (EA_COUNT+P3P4_COUNT+P1P2_COUNT)<>0 order BY CEC";
$cdresultr=mysqli_query($link,$cdqueryr) or die ("Query to get data from review failed: ".mysqli_error($link));
$cdresult1r=mysqli_query($link,$cdquery1r) or die ("Query to get data from review failed: ".mysqli_error($link));
$cdresult2r=mysqli_query($link,$cdquery2r) or die ("Query to get data from review failed: ".mysqli_error($link));


$rejr=array();
$cecr=array();
$ear=array();
json_encode($ear);
$totr=array();
$unar=array();
while ($cdrow=mysqli_fetch_assoc($cdresultr)) {
  array_push($totr,$cdrow["S"]);

}

while ($cdrow=mysqli_fetch_assoc($cdresult2r)) {
  array_push($cecr,$cdrow["CEC"]);
}
while ($cdrow=mysqli_fetch_assoc($cdresult1r)) {
 array_push($unar,$cdrow["R"]); }
$pur=array();
for($i=0;$i<sizeof($unar);$i++) {
$pur[$i]=$unar[$i]/$totr[$i];
}

$cdquery2a="SELECT ENG_CEC FROM cases group by ENG_CEC order BY ENG_CEC";
$cdresult2a=mysqli_query($link,$cdquery2a) or die ("Query to get data from review failed: ".mysqli_error($link));
$ceca=array();

$tota=array();
$una=array();
while ($cdrow=mysqli_fetch_assoc($cdresult2a)) {
  array_push($ceca,$cdrow["ENG_CEC"]);
}
$result = array_unique($ceca);

foreach ($result as $k => $v) {
    if ($v=="REJECTED"){
      unset($result[$k]);

    }
    else{
    $cdquerya="SELECT avg(DIFF_MIN) as S FROM cases where ENG_CEC='".$v."' ORDER BY ENG_CEC ";
    $cdresulta=mysqli_query($link,$cdquerya) or die ("Query to get data from review failed: ".mysqli_error($link));
    while ($cdrow=mysqli_fetch_assoc($cdresulta)) {
     array_push($tota,$cdrow["S"]);

}
}

}

?>

<!DOCTYPE html>
<html lang='en'>

    <head>

        <meta charset='utf-8'>
        <title>Reporting Dashboard - TAM Tool &middot; Cisco CMS</title>
        <!-- <meta name='description' content='Quality Management Tool'>
  <meta name='author' content='Cisco CMS'> -->


        <meta name='viewport' content='width=device-width, initial-scale=1'>


        <link rel='stylesheet' href='css/normalize.css'>
        <link rel='stylesheet' href='css/skeleton.css'>

        <!-- Plotly.js -->
  <script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
  <!-- Numeric JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/numeric/1.2.6/numeric.min.js"></script>

<link rel='icon' type='image/png' href='favicon.png'>

<script src="js/jquery-min.js"></script>

<link href='css/select2.min.css' rel='stylesheet'/>
    <script src='js/select2.min.js'></script>
 <script type='text/javascript'>

$(document).ready(function() {
  $('.js-example-basic-multiple').select2({
  placeholder: 'Click or Type Here to Select Customer'
});
});
</script>

<style>

.select2-container--default .select2-selection--multiple {
  border-radius: 0 !important;
      min-height: 40px !important;
      max-height: auto !important;
}
.select2-search__field {
  width:300px !important;
}
li {
  margin-bottom: 0 !important;
}

  .amcharts-chart-div a {
    width:700px;
    height:700px;
    display:none!important;
  }
  .amcharts-axis-title {
    display: none!important;
  }

.gtitle {
  /*z-index: 99999999999 !important;*/
  font-weight: bolder !important;
  text-transform: uppercase !important;
  font-size: medium !important;
  /*letter-spacing:0.1rem !important;*/
  fill: #999 !important;
  /*border-bottom: 1px solid #333 !important;*/
  /*text-decoration: underline;*/
}
.gtitle, .legend, .plotly-notifier{
font-family: "Segoe UI", "SanFrancisco", "HelveticaNeue", "Helvetica Neue", Helvetica, Arial, sans-serif !important;
}
.slicetext {
  fill:#fff !important;
 font-family: "Segoe UI", "SanFrancisco", "HelveticaNeue", "Helvetica Neue", Helvetica, Arial, sans-serif !important;
 font-weight:bold;
}

ul.tab-nav {
    list-style: none;
    border-bottom: 1px solid #bbb;
    padding-left: 5px;
}

ul.tab-nav li {
    display: inline;
}

ul.tab-nav li a.button {
    border-bottom-left-radius: 0;
    border-bottom-right-radius: 0;
    margin-bottom: -1px;
    border-bottom: none;
}

ul.tab-nav li a.active.button {
    border-bottom: 1px solid #fff;
}

.tab-content .tab-pane {
    display: none;
}

.tab-content .tab-pane.active {
    display: block;
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


</head>

<div class='container u-max-full-width'>
            <div class='row' style='margin-top:3%;z-index:99999;'>
                <div class='twelve columns bg-this'>
                    <a href='casestatistics.php'><svg class='img-responsive logo' style='max-width: 185px;width:120px;' x='0px' y='0px' width='200.1px' height='105.4px' viewBox='-305 291.9 200.1 105.4'>
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
                    <h4 style='font-weight:normal; margin-bottom: 0px;text-align:right;'>Cisco Managed Services</h4>
                    <h5 style='font-weight:lighter;float:right;'>Ticket Assignment &amp; Management Tool <span style='font-weight:bolder;'>v9.8</span></h5>
                </div>
            </div>
        </div>

        </div>

        <div class='container u-max-full-width'>
        <div class="row">
      <div class="twelve columns" style="">

<ul class="tab-nav">

  <li>
  <a class="button active" id="tone" href="#one">Work Presented - Trending</a>

  </li>
  <li>
    <a class="button" id="ttwo" href="#two">Work Presented - Total</a>
  </li>
  <li>
    <a class="button" href="#three">GDC Productivity</a>
  </li>
  <li>
    <a class="button" href="#four">GDC Availability</a>
  </li>
  <li>
    <a class="button" href="#fourdotfive">Engineer Availability</a>
  </li>
  <li>
    <a class="button" href="#five">Engineer Behavior</a>
  </li>
  <li>
    <a class="button" href="#six">Time to Accept</a>
  </li>
</ul>

<div class="tab-content">

<div class="tab-pane" id="zero">
<div class="row"> <!-- KRICHA -->
<div class="five columns">
<?php
$mysqlserver1="localhost";
$mysqlusername1="root";
$mysqlpassword1="krithu";
$link1=mysqli_connect('localhost', $mysqlusername1, $mysqlpassword1, 'tam-hsbc') or die ("Error connecting to mysql server: ".mysqli_error($link1));

$cdquery1="SELECT CUSTOMER FROM cases WHERE TYPE != 'NULL' GROUP BY CUSTOMER";
$cdresult1=mysqli_query($link1,$cdquery1) or die ("Query to get data from cases failed: ".mysqli_error($link1));
$custarr=array();
while ($cdrow1=mysqli_fetch_array($cdresult1)){
  array_push($custarr, trim($cdrow1["CUSTOMER"]));
}

?>
<ul>
<div style='display: block;
    font-size: 1.3rem;
    /*padding: 2rem 0;*/
    text-transform: uppercase;
    color: #999;
    font-weight: 700;
    letter-spacing: 1px;'><strong></strong>Click on the field below &amp; add Customers to compare.</div>

<form name="form1" method="post" id="myForm">
<div class='half'>

<select name='CUSTOMER[]' required class='js-example-basic-multiple' id='badass' multiple='multiple' style='padding:0!important;width:100%;border-radius:0px!important;'>

<?php
$custarr=array_unique($custarr);
foreach ($custarr as $key => $value) {
if(isset($_POST['submit'])){
  extract($_POST);
  if(array_search($value, $CUSTOMER)!==FALSE){
     echo '<option  name="'.trim($value).'" value="'.trim($value).'" selected>'.trim($value).'</option>';
  }
  else{
    echo '<option  name="'.trim($value).'" value="'.trim($value).'">'.trim($value).'</option>';
  }


}
else{
  echo "testing";
  echo '<option  name="'.trim($value).'" value="'.trim($value).'">'.trim($value).'</option>';


}
}
?>


</select>
</div> <!-- Half -->

<input type="button" class="button-primary" name="submit" value="Submit" onclick="runthis();"/>
<!-- <input type="button" class="button" value="Clear Fields" onclick="myFunction()"> -->
<hr style='margin-bottom:0;'>


<div style='display: block;
    font-size: 1.3rem;
    padding: 2rem 0 1rem 0;
    text-transform: uppercase;
    color: #999;
    font-weight: 700;
    letter-spacing: 1px;'>Export Options - After Generating Graph</div>

<a href='https://cmstools.cisco.com/ccount.png' target='_blank' class='button' style='border: 0; border-bottom: 1px solid #212121;padding: 0;margin:0;margin-right:20px;'>Export Graph to Image &nbsp;📈 ↗</a>

</form>
</ul>

</div> <!-- Five -->

<div class="seven columns" id="shovehere" style="text-align:center;">

<img id="theimg">

<?php

// $args="";
// $output="";
// if(isset ($_POST['submit']))
// {

// $cust=$_POST["CUSTOMER"];
// $args="";
// //var_dump($cust);
// foreach($cust as $list1){
// $list1=str_replace(' ','*',$list1);
// //echo $list1;
// $args=$args." ".$list1;
// //echo $args;

// }
// //echo "C:/Python27/python.exe C:/wamp64/cgi-bin/ccount.py $args";
// $output = exec("C:/Python27/python.exe C:/wamp64/cgi-bin/ccount.py $args",$output,$return);
// //echo $output;
// //echo $return;
// echo '
// <div id="shovehere"></div>
// ';
// }

?>
<!-- <div id="shovehere"></div> -->
</div> <!-- Seven -->


</div> <!-- Row -->

</div>



  <div class="tab-pane active" id="one">
<div class='row'>
<center>
<img   src="https://cmstools.cisco.com/hsbc-count.png" >
<br><br>
<a href='https://cmstools.cisco.com/hsbc-count.png' target='_blank' class='button' style='border: 0; border-bottom: 1px solid #212121;padding: 0;margin:0;margin-right:20px;'>Export Graph to Image &nbsp;📈 ↗</a>
</center>
</div>

  </div>




  <div class="tab-pane" id="two">
<div class='row'>
<div class="three columns">


      <div style="display: block;
    font-size: 1.3rem;
    /*padding: 2rem 0;*/
    text-transform: uppercase;
    color: #999;
    font-weight: 700;
    letter-spacing: 1px; margin-bottom:10px;"><span style="font-size:larger;color:crimson;text-transform: lowercase;">ⓘ</span>&nbsp; Count of Engineers by GDC</div>
    <!-- <hr> -->


    <style>

    th, td {
      padding: 12px 70px;
    }
    </style>

    <table class="u-max-full-width">


      <tr>
      <td>Bangalore</td>

      <td><?PHP echo ' '.$GDCB.''; ?></td>
      </tr>
      <tr>
      <td>Krakow</td>
      <td><?PHP echo ' '.$GDCK.''; ?></td>
      </tr>
      <tr>
      <td>RTP</td>
      <td><?PHP echo ' '.$GDCR.''; ?></td>
      </tr>
      <tr style="font-weight: bolder;">
      <td>Overall</td>
      <td><?PHP echo ' '.$GDCT.''; ?></td>
      </tr>
    </table>
      </div>
      <div class="nine columns">
<center>
<img   src="https://cmstools.cisco.com/hsbc-bar1.png" ><br><br>
<a href='https://cmstools.cisco.com/hsbc-bar1.png' target='_blank' class='button' style='border: 0; border-bottom: 1px solid #212121;padding: 0;margin:0;margin-right:20px;'>Export Graph to Image &nbsp;📊 ↗</a>
</center>
</div>
</div>


  </div>
  <div class="tab-pane" id="three">
      <div class='row'>
      <div class="three columns">
      <div style="display: block;
    font-size: 1.3rem;
    /*padding: 2rem 0;*/
    text-transform: uppercase;
    color: #999;
    font-weight: 700;
    letter-spacing: 1px; margin-bottom:10px;"><span style="font-size:larger;color:crimson;text-transform: lowercase;">ⓘ</span>&nbsp; Count of Engineers by GDC</div>
    <!-- <hr> -->
    <style>
    th, td {
      padding: 12px 70px;
    }
    </style>
    <table class="u-max-full-width">
     <tr>
      <td>Bangalore</td>

      <td><?PHP echo ' '.$GDCB.''; ?></td>
      </tr>
      <tr>
      <td>Krakow</td>
      <td><?PHP echo ' '.$GDCK.''; ?></td>
      </tr>
      <tr>
      <td>RTP</td>
      <td><?PHP echo ' '.$GDCR.''; ?></td>
      </tr>
      <tr style="font-weight: bolder;">
      <td>Overall</td>
      <td><?PHP echo ' '.$GDCT.''; ?></td>
      </tr>
    </table>
      </div>
      <div class="nine columns">
<center>
<img   src="https://cmstools.cisco.com/hsbc-bar.png" ><br><br>
<a href='https://cmstools.cisco.com/hsbc-bar.png' target='_blank' class='button' style='border: 0; border-bottom: 1px solid #212121;padding: 0;margin:0;margin-right:20px;'>Export Graph to Image &nbsp;📊 ↗</a>
</center>
</div>
</div>

  </div>

  <div class="tab-pane" id="four">

      <div id="q1" class="five columns"  style="margin-top: 100px;">
 <?php
echo '

<script>

    var data = [{
  values: ['.$t1.','.$t2.','.$t3.'],
  labels: ["Available", "Except Manual P1/P2", "Unavailable"],
  hoverinfo: "label+percent",
marker: {colors: ["#259e25","#EDC951","#CC333F"]},

  type: "pie"
}];

var layout = {
  height: 550,
  width: 650,
  title:"Overall",
  showlegend: true,
  legend: {
    x: 0,
    y: 100
  },
      margin: {
    l: 50,
    r: 50,
    b: 50,
    t: 50,
    pad: 4
  }


};

Plotly.newPlot("q1", data, layout,{displayModeBar: false});
  </script>
';
?>
</div>

<div class="seven columns">
<div class="row">
<div id="q3" style = "margin-left:200px;" class="six columns">
<?php
echo '

<script>

    var data = [{
  values: ['.$tb1.','.$tb2.','.$tb3.'],

  hoverinfo: "none",
 marker: {colors: ["#259e25","#EDC951","#CC333F"]},
  type: "pie"
}];

var layout = {

  height: 350,
  width: 450,
  title:"Bangalore",
  showlegend: false,
      margin: {
    l: 50,
    r: 50,
    b: 50,
    t: 50,
    pad: 4
  }

};

Plotly.newPlot("q3", data, layout,{displayModeBar: false});
  </script>
';

?>
</div>
</div>

<div class="row">
<div id="q4" class="six columns">
<?php
echo '


<script>

    var data = [{

  values: ['.$tk1.','.$tk2.','.$tk3.'],

  hoverinfo: "none",
  marker: {colors: ["#259e25","#EDC951","#CC333F"]},

  type: "pie"
}];

var layout = {
  height: 350,
  width: 450,
  title:"Krakow",
  showlegend: false,
      margin: {
    l: 50,
    r: 50,
    b: 50,
    t: 50,
    pad: 4
  }

};

Plotly.newPlot("q4", data, layout,{displayModeBar: false});
  </script>
'
;
?>
</div>
<div id="q5" class="six columns">
<?php
echo '



<script>

    var data = [{
  values: ['.$tr1.','.$tr2.','.$tr3.'],

  hoverinfo: "none",
  marker: {colors: ["#259e25","#EDC951","#CC333F"]},

  type: "pie"
}];

var layout = {
  height: 350,
  width: 450,
  title:"RTP",
  showlegend: false,
      margin: {
    l: 50,
    r: 50,
    b: 50,
    t: 50,
    pad: 4
  }


};

Plotly.newPlot("q5", data, layout,{displayModeBar: false});
  </script>
';
?>
</div>
</div>
</div>
  </div>


<div class="tab-pane" id="fourdotfive">
<div class="row">
<div class='five columns'>

<ul>
<div style='display: block;
    font-size: 1.3rem;
    /*padding: 2rem 0;*/
    text-transform: uppercase;
    color: #999;
    font-weight: 700;
    letter-spacing: 1px;'>Click on the field below &amp; Select an Engineer.</div>


<form name="form1" method="post">
<div class='half'>


<select name='CC' id='engcec' required class='js-example-basic-multiple' style='padding:0!important;width:100%;border-radius:0px!important;'>

<?php
$mysqlserver="localhost";
$mysqlusername="root";
$mysqlpassword="krithu";
$link=mysqli_connect('localhost', $mysqlusername, $mysqlpassword, 'tam-hsbc') or die ("Error connecting to mysql server: ".mysqli_error($link));

$dbname = 'tam-hsbc';


$cdquery="SELECT CEC FROM c_eng GROUP BY CEC";
$cdresult=mysqli_query($link,$cdquery) or die ("Query to get data from c_eng failed: ".mysqli_error($link));

while ($cdrow=mysqli_fetch_array($cdresult)) {
$en=$cdrow["CEC"];
if(isset($_POST['submit'])){
  $CEC1=$_POST["CEC"];
  if($T==$CEC1){
     echo '<option  name="'.$cdrow['CEC'].'" value="'.$cdrow['CEC'].'" selected>'.$cdrow['CEC'].'</option>';
  }
  else{
    echo '<option  name="'.$cdrow['CEC'].'" value="'.$cdrow['CEC'].'">'.$cdrow['CEC'].'</option>';
  }


}
else{
  echo '<option  name="'.$cdrow['CEC'].'" value="'.$cdrow['CEC'].'">'.$cdrow['CEC'].'</option>';

}

}
?>



</select>
</div>



<input type="button" class="button-primary" name="submit" value="Submit" onclick="engav();"/>
<hr style='margin-bottom:0;'>
<div style='display: block;
    font-size: 1.3rem;
    padding: 2rem 0 1rem 0;
    text-transform: uppercase;
    color: #999;
    font-weight: 700;
    letter-spacing: 1px;'></div>

<a href='../ggheat.png' target='_blank' class='button' style='border: 0; border-bottom: 1px solid #212121;padding: 0;margin:0;margin-right:20px;'></a>
<!-- <a href='' class='button' style='border: 0; border-bottom: 1px solid #212121;padding: 0;margin:0;'>Open Graph as Attached Image in Outlook &#x279a;</a> -->


</form>
</ul>
</div>



ob_end_flush();
<?php

//$args="";



echo '

<div id="second" class="six columns" style="text-align: -webkit-right">


<script>


  </script>
  </div>
';







?>
</div>


</div>
  <div class="tab-pane" id="five">
      <div class="row">
      <div class="six columns">
      <h5 style="text-align:center; margin-bottom: 0px">Engineer Unavailability Percentage</h5>
      <div id="chartdiv" style="width: 680px; height: 600px;"><!-- Plotly chart will be drawn inside this DIV --></div>
      </div>

      <div class="six columns">
      <h5 style="text-align:center;  margin-bottom: 0px">Engineer Rejected Cases Percentage</h5>
      <div id="chartdivr" style="width: 680px; height: 600px;"><!-- Plotly chart will be drawn inside this DIV --></div>
      </div>
      </div>

  </div>

  <div class="tab-pane" id="six"> <!--LOOK HERE KRIC & JADE-->
      <div class="row">
      <div class="twelve columns">
      <h5 style="text-align:center; margin-bottom: 0px">Engineer - Time Taken to Accept Cases</h5>
      <center><div id="chartdiva" style="width: 680px; height: 600px;"><!-- Plotly chart will be drawn inside this DIV --></div></center>
      </div>



  </div>



</div> <!--End Tab Content-->

</div>
    </div>
  </div>



<script type='text/javascript'>

$(function() {
    $('ul.tab-nav li a.button').click(function() {
        var href = $(this).attr('href');
        console.log("ji"+$(this).attr('id'));
        if(!($(this).attr('id')=='tone'))
        {
        $("#goutham").hide();
        }

        $('li a.active.button', $(this).parent().parent()).removeClass('active');
        $(this).addClass('active');

        $('.tab-pane.active', $(href).parent()).removeClass('active');
        $(href).addClass('active');

        return false;
    });
});
</script>

  <script>
  //old code
  var unav=[];
  var x=[];
  var unav = new Array(<?php echo implode(',', $pu); ?>);
   var x = <?php echo json_encode($cec); ?>;
   console.log(x);//enginner names inside x
   console.log(unav);
   </script>


 <!--imports -->
<script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
<script src="https://www.amcharts.com/lib/3/radar.js"></script>
<script src="https://www.amcharts.com/lib/3/plugins/tools/polarScatter/polarScatter.min.js"></script>
<script src="https://www.amcharts.com/lib/3/plugins/export/export.min.js"></script>
<link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
<script src="https://www.amcharts.com/lib/3/themes/light.js"></script>

<script>
//this is the new code with amchart
function getangle(engg)
   {
    //console.log(engg);
    var angles=[];
    len=engg.length;
    inc=360/len;
    ang=0;
    angles[0]=engg[0];
    for(i=1;i<len;i++)
    {
      ang=ang+inc;
      angles[Math.round(ang)]=engg[i];
    }
    return angles;
   }

 function getseries(series)
 {
    var dum=[];
    var angles=[];
    len=series.length;
    inc=360/len;
    ang=0;
    dum.push(0);
    dum.push(series[0]);
    console.log(dum);
    angles.push(dum);
    for(i=1;i<len;i++)
    {
      ang=ang+inc;
      dum=[];
      dum.push(Math.round(ang));
      dum.push(series[i]);
      angles.push(dum);
      console.log(dum);
    }
    console.log(angles);
    return angles;
 }

   var hashmap = getangle(x);



var ser = getseries(unav);
console.log("ser="+JSON.stringify(ser));


var chart = AmCharts.makeChart("chartdiv", {
  "type": "radar",
   "rotate":true,
  "theme": "light",
  "dataProvider": [],
  "valueAxes": [{
    "gridType": "circles",
    "minimum": 0,
    "maximum":100,
   // "labelsEnabled": false,
  }],
  "startDuration": 1,
  "polarScatter": {
    "minimum": 0,
    "maximum": 359,
    "step": 1,
  },

  "graphs": [{
    "title": "Engineers",
    "balloonText": "[[category]]: [[value]] m/s",
    "bullet": "round",
    "lineAlpha": 0,
    "series": ser,//place ser array here
    "balloonFunction": function(graphDataItem, graph) {
      var value = graphDataItem.category;
       console.log(graphDataItem);
      var cas = graphDataItem.values.value;
      value = hashmap[value];//make a hash map which has unique keys are u sure?
      console.log(value);
      return "CEC: "+value+", Percentage Rejected: "+cas;

    }
  }],
  "export": {
    "enabled": true
  }
});
chart.clearLabels();
</script>
<script>
  //old code
  var unav=[];
  var x=[];
  var unav = new Array(<?php echo implode(',', $pu); ?>);
   var x = <?php echo json_encode($cec); ?>;
   console.log(x);//enginner names inside x
   console.log(unav);
   //old code
  var unavr=[];
  var xr=[];
  var unavr = new Array(<?php echo implode(',', $pur); ?>);
   var xr = <?php echo json_encode($cecr); ?>;
   var unava=[];
  var unava = new Array(<?php echo implode(',', $tota); ?>);
  var xa=[];

   var xa = <?php echo json_encode($ceca); ?>;
   var unique = xa.filter(function(elem, index, self) {
    return index == self.indexOf(elem);
});
   unique.splice( unique.indexOf('REJECTED'), 1 );

   </script>

<script>

function runthis(){

  var opts = $("#badass").val();
  console.log(opts);

  $.ajax ({
    type: "POST",
    url: "dummy.php",
    cache: false,
    //async: false,
    data: {"content":opts},
    success: function(data) {
      console.log(data);
      // $("#shovehere")
      // if($("#theimg").is(":visible")) {

      //   // $("#theimg").remove();
      //   $("#shovehere").replaceWith(data);
      //   console.log("Removed The Image");

      // }
      $("#theimg").attr('src', data + '?' + new Date().getTime());
    }
  });
}

function engav(){

  var opts = $("#engcec").val();
  console.log(opts);

  $.ajax ({
    type: "POST",
    url: "dummy.php",
    cache: false,
    //async: false,
    data: {"content1":opts},
    success: function(data) {
      console.log(data);
    var hello=data.split(" ");
        console.log(hello);
          var data = [{
  values: [hello[0],hello[1],hello[2]],
  labels: ["Available", "Except Manual P1/P2", "Unavailable"],
  hoverinfo: "label+percent",

  marker: {colors: ["green","#EDC951","#CC333F"]},
  type: "pie"
}];

var layout = {
  height: 600,
  width: 600,
  title:opts+" Availability Status",
  showlegend: true


};

Plotly.newPlot("second",data, layout,{displayModeBar: false});
      // $("#shovehere")
      // if($("#theimg").is(":visible")) {

      //   // $("#theimg").remove();
      //   $("#shovehere").replaceWith(data);
      //   console.log("Removed The Image");

      // }
      //$("#theimg").attr('src', data + '?' + new Date().getTime());
    }
  });
}

</script>

 <!--imports -->
<script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
<script src="https://www.amcharts.com/lib/3/radar.js"></script>
<script src="https://www.amcharts.com/lib/3/plugins/tools/polarScatter/polarScatter.min.js"></script>
<script src="https://www.amcharts.com/lib/3/plugins/export/export.min.js"></script>
<link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
<script src="https://www.amcharts.com/lib/3/themes/light.js"></script>

<script>
//this is the new code with amchart
function getangle(engg)
   {
    //console.log(engg);
    var angles=[];
    len=engg.length;
    inc=360/len;
    ang=0;
    angles[0]=engg[0];
    for(i=1;i<len;i++)
    {
      ang=ang+inc;
      angles[Math.round(ang)]=engg[i];
    }
    return angles;
   }

 function getseries(series)
 {
    var dum=[];
    var angles=[];
    len=series.length;
    inc=360/len;
    ang=0;
    dum.push(0);
    dum.push(series[0]);
    console.log(dum);
    angles.push(dum);
    for(i=1;i<len;i++)
    {
      ang=ang+inc;
      dum=[];
      dum.push(Math.round(ang));
      dum.push(series[i]);
      angles.push(dum);
      console.log(dum);
    }
    console.log(angles);
    return angles;
 }

   var hashmap = getangle(x);



var ser = getseries(unav);
console.log("ser="+JSON.stringify(ser));


var chart = AmCharts.makeChart("chartdiv", {
  "type": "radar",
  "theme": "light",
  "dataProvider": [],
  "valueAxes": [{
    "gridType": "circles",
    "minimum": 0,
    "maximum":100

  }],

  "startDuration": 1,
  "polarScatter": {
    "minimum": 0,
    "maximum": 359,
    "step": 1

  },

  "graphs": [{
    "title": "Engineers",
    "balloonText": "[[category]]: [[value]] m/s",
    "bullet": "round",
    "lineAlpha": 0,
    "series": ser,//place ser array here
    "balloonFunction": function(graphDataItem, graph) {
      var value = graphDataItem.category;
       console.log(graphDataItem);
      var cas = graphDataItem.values.value;
      value = hashmap[value];//make a hash map which has unique keys are u sure?
      console.log(value);
      return "CEC: "+value+"<br> Percentage Unavailable: "+cas.toFixed(2);

    }
  }],
  "export": {
    "enabled": true
  }
});

 var hashmapa = getangle(unique);



var sera = getseries(unava);
console.log("ser="+JSON.stringify(sera));


var chart = AmCharts.makeChart("chartdiva", {
  "type": "radar",
  "theme": "light",
  "dataProvider": [],
  "valueAxes": [{
    "gridType": "circles",
    "minimum": 0,
    "maximum":250

  }],

  "startDuration": 1,
  "polarScatter": {
    "minimum": 0,
    "maximum": 359,
    "step": 1

  },

  "graphs": [{
    "title": "Engineers",
    "balloonText": "[[category]]: [[value]] m/s",
    "bullet": "round",
    "lineAlpha": 0,
    "series": sera,//place ser array here
    "balloonFunction": function(graphDataItem, graph) {
      var value = graphDataItem.category;
      // console.log(graphDataItem);
      var cas = graphDataItem.values.value;
      value = hashmapa[value];//make a hash map which has unique keys are u sure?
      console.log("cec"+value);
      return "CEC: "+value+"<br>Avg Time To Accept: "+cas.toFixed(2)+" mins";

    }
  }],
  "export": {
    "enabled": true
  }
});


   var hashmapr = getangle(xr);



var serr = getseries(unavr);



var chartr = AmCharts.makeChart("chartdivr", {
  "type": "radar",
   "rotate":true,
  "theme": "light",
  "dataProvider": [],
  "valueAxes": [{
    "gridType": "circles",
    "minimum": 0,
    "maximum":40,
   // "labelsEnabled": false,
  }],
  "startDuration": 1,
  "polarScatter": {
    "minimum": 0,
    "maximum": 359,
    "step": 1,
  },

  "graphs": [{
    "title": "Engineers",
    "balloonText": "[[category]]: [[value]] m/s",
    "bullet": "round",
    "lineAlpha": 0,
    "series": serr,//place ser array here
    "balloonFunction": function(graphDataItem, graph) {
      var value = graphDataItem.category;
       console.log(graphDataItem);
      var cas = graphDataItem.values.value;
      value = hashmapr[value];//make a hash map which has unique keys are u sure?
      console.log(value);
      return "CEC: "+value+"<br> Percentage Rejected: "+cas.toFixed(2);

    }
  }],
  "export": {
    "enabled": true
  }
});
chartr.clearLabels();
</script>



<script>
// function myFunction() {
//     document.getElementById("myForm").reset();
//     $(".js-example-basic-multiple").val(null).trigger("change");
// var checkboxes = document.getElementsByTagName('input');
//     for (var i = 0; i < checkboxes.length; i++) {
//              if ((checkboxes[i].type == 'checkbox') && (checkboxes[i].checked == true)) {
//                  checkboxes[i].checked = false;
//              }
//            }
//          }

</script>
        </body>
        </html>
