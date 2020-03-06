<?php
error_reporting(0);
ob_start();
if(isset($_POST["content"])){


$cust=$_POST["content"];
$args="";

foreach($cust as $list1){
$list1=str_replace(' ','*',$list1);
//echo $list1;
$args=$args." ".$list1;
//echo $args;

}
//echo "C:/Python27/python.exe C:/wamp64/cgi-bin/ccount.py $args";
$output = exec("C:/Python27/python.exe C:/wamp64/cgi-bin/ccount.py $args",$output,$return);
//echo $output;
//echo $return;
 echo 'http://cmstools.cisco.com/ccount.png';
}


if(isset($_POST["content1"])){
    $output="";


$name=$_POST["content1"];

$mysqlserver="localhost";
$mysqlusername="root";
$mysqlpassword="krithu";
$link=mysqli_connect('localhost', $mysqlusername, $mysqlpassword, 'tam-hsbc') or die ("Error connecting to mysql server: ".mysqli_error($link));

$dbname = 'tam-hsbc';


$cdqueryn="SELECT AVG(S1_TIME) as S1_TIME FROM c_eng WHERE CEC='$name'";
$cdqueryn1="SELECT AVG(S2_TIME) as S2_TIME FROM c_eng WHERE CEC='$name'";
$cdqueryn2="SELECT AVG(S3_TIME) as S3_TIME FROM c_eng WHERE CEC='$name'";
$cdresultn=mysqli_query($link,$cdqueryn) or die ("Query to get data from review failed: ".mysqli_error($link));
$cdresultn1=mysqli_query($link,$cdqueryn1) or die ("Query to get data from review failed: ".mysqli_error($link));
$cdresultn2=mysqli_query($link,$cdqueryn2) or die ("Query to get data from review failed: ".mysqli_error($link));

$n1=array();
$n2=array();
$n3=array();

json_encode($n1);
json_encode($n2);
json_encode($n3);
$cdrow=mysqli_fetch_assoc($cdresultn);
  $n1=$cdrow["S1_TIME"];

//array_push($rej,$cdrow["REJECTED"]);
$cdrow=mysqli_fetch_assoc($cdresultn1);
 $n2=$cdrow["S2_TIME"];
$cdrow=mysqli_fetch_assoc($cdresultn2);
  $n3=$cdrow["S3_TIME"];

$sm=$n1+$n2+$n3;

$total1=$n1*100/$sm;
$total2=$n2*100/$sm;
$total3=$n3*100/$sm;

echo "$total1 $total2 $total3";
ob_end_flush();
}
?>
