<?php

error_reporting(0);
function finesse($url,$teamid,$user)
{
$arr = array();
$url = $url.'/finesse/api/Team/'.$teamid;
$ch = curl_init($url);

$authorization = "Authorization: Basic ".$user;

curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/plain', $authorization)); //type
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
//curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);//data is nothing. GET without payload in the
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
$result = curl_exec($ch);
$xml=simplexml_load_string($result) or die("Error: Cannot create object");
curl_close($ch);
//return json_encode($xml);//xml or plain text

$result = (array)($xml);
$users= ((array)$result["users"]);
$User = $users["User"];
 return var_dump( $User);


// for($i=0;$i<count($User);$i++)
// {
//   $usr=(array)$User[$i];
//   array_push($arr,$usr["firstName"]);
// }


for($i=0;$i<count($User);$i++)
{
  $usr=(array)$User[$i];//this is the array we need
  $cec= getCEC($usr["loginId"]);
  $single_user[$cec]=$usc;//assoc
  array_push($arr,$single_user);
}



return $arr;
}


function finesseGetUser($url,$cec)
{

$empid = getEmpId($cec);
$arr = array();
$url = $url.'/finesse/api/User/'.$empid;
$ch = curl_init($url);

$authorization = "Authorization: Basic ".base64_encode($empid.":12345");
// /return $empid;
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/plain', $authorization)); //type
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
//curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);//data is nothing. GET without payload in the
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
$result = curl_exec($ch);
$xml=simplexml_load_string($result) or die("Error: Cannot create object");
curl_close($ch);
//return json_encode($xml);//xml or plain text

$result = (array)($xml);
$arr[(string)($empid)]=$result;

return $arr;
}



function getEmpId($cec)
{
//DB call to get the CEC
$conn= new mysqli('localhost','root','krithu','tam-hsbc');
if($conn->connect_error){
  die($conn->error);
}
$sql =  'select empid from cecempid where cec="'.$cec.'";';
$res=$conn->query($sql);
$row=mysqli_fetch_assoc($res);
  return $row["empid"];
}

?>
