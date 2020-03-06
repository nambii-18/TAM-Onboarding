<?php
ob_start();
require('connect-hsbc.php');
var_dump($_POST);
if(isset($_POST["assign"])){
    $qmcec=$_POST["qmcec"];
    $datesub=$_POST["datesub"];
    $case=$_POST["case"];
    $customer=$_POST["customer"];
    $sql="INSERT INTO optimizes(CASE_NUM,QM_CEC,CUSTOMER,DT_SUBMIT) VALUES('$case','$qmcec','$customer','$datesub');";
    echo $sql;
    if($conn->query($sql)){
        setcookie("op","op");
        $_COOKIE["op"]="op";
        header("Location: optimize.php");
    }
    else{
        echo $conn->error;
    }
}
ob_end_flush();
?>
