<?php
require('finesse.php');
$engarr= ((json_decode($_POST["engarr"],true)));
//var_dump($engarr);
$map= json_decode($_POST["map"],true);
//var_dump($map);
//echo json_last_error();
$rtp='http://fin-rtp-p01.cisco.com';
$emea='http://fin-ams-p01.cisco.com';
$apac='http://fin-bgl-p01.cisco.com';

$arr[0]=$rtp;
$arr[1]=$emea;
$arr[2]=$apac;

// $rtp_array= finesse($rtp,"5503","NDc1NjA0OjEyMzQ1");
// $emea_array= finesse($emea,"5504","Mzk5ODM2OjEyMzQ1");
// $apac_array =finesse($apac,"5499","NDYyMjIzOjEyMzQ1");
//   $apac2_array =finesse($apac,"5512","NDg4NzU4OjEyMzQ1");
//  var_dump($rtp_array);
//  var_dump($emea_array);
//var_dump($apac_array);

// $result_array =  array_merge($rtp_array,$emea_array,$apac_array);
//
// foreach ($result_array as $key => $value) {
// //  echo $key;
//   echo $value;//crros  check this array with the current engineers in queue
// }

foreach($engarr as $eng)
{

//  echo $eng;
//  echo $overengarr[$eng];
$each=[];
if($map[$eng])
{
 if($map[$eng]=="Bangalore")
 $result_array = finesseGetUser($apac,$eng);
 else if($map[$eng]=="Krakow")
 $result_array = finesseGetUser($emea,$eng);
 else {
   $result_array = finesseGetUser($rtp,$eng);
 }
 $res = (string)$result_array;
 $data = $result_array[key($result_array)];
   if(!strpos($res,"border" !== false) &&  $data["state"]!="")
   {
     //echo $eng;
     $time =  ((array)$data["stateChangeTime"])[0];

     if($time=="")

     {
       $each["extn"] =$data["extension"];
       $each["state"] = $data["state"];
         $each["time"] = "-- Time out --";
         $each["team"] = $data["teamName"];
         $each["sg"] = $eng;
     }
     else
     {
       //echo $time;
       $each["extn"] =$data["extension"];
       $each["state"] = $data["state"];
       $d = strtotime($time);
       $d = date('d/M/Y H:i:s', $d);
       $format = 'd/M/Y H:i:s';
       $date = DateTime::createFromFormat($format,$d);
       $now = new DateTime();
       $interval = $date->diff($now);
         $each["time"] = $interval->format("%d days %h hours %i min %s seconds");
         $each["team"] = $data["teamName"];
         $each["sg"] = $eng;
     }
     if($data["reasonCode"])
     {
     $reasoncode = (array)$data["reasonCode"];
      $each["state"]= $each["state"]." - ".$reasoncode['label'];
     }

 }

}
//  var_dump($each);
if($each['state']!='')
{
echo "

<tr>
 <td>".$each['extn']."</td>";
 if(strcmp($each['state'],"READY"))
 {
 echo "<td><strong style='color:red'>".$each['state']."</strong></td>";
 }
else {
 echo "<td><strong style='color:green'>".$each['state']."</strong></td>";
}
 echo"
 <td>".$each['time']."</td>
 <td>".$each['team']."</td>
 <td>".$each['sg']."</td>
</tr>

";
}

}











 ?>
