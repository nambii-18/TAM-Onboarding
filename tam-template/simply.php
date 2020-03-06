<?php
require("finesse.php");
$apac='http://fin-bgl-p01.cisco.com';
$result_array = finesseGetUser($apac,"shreyrao");
$res = $result_array;
echo
var_dump( $res);

$res = (string)$result_array;
$data = $result_array[key($result_array)];
if($data["reasonCode"])
{
$reasoncode = (array)$data["reasonCode"];
echo $reasoncode['label'];
}


 ?>
