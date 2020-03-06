<?php
ob_start();
require('connect-hsbc.php');
$pkid=0;
$case='';
$engid='';
$customer='';
$type="";
$reason="";
$shift='';
$qmid='';
$shift="";

//echo $shift;
date_default_timezone_set('Asia/Kolkata');
session_start();
 if(!isset($_SESSION["eng"])){
    header("Location: forbidden.html");
}
else{
    $eng_cec=$_SESSION["eng"];
}
$sqlshift="SELECT SHIFT FROM ENGINEER WHERE CEC='$eng_cec'";
$res=$conn->query($sqlshift);
$rowsh=mysqli_fetch_assoc($res);
$shift=$rowsh["SHIFT"];
if($conn->connect_error){
    die($conn->error);
}
$today=date("Y-m-d");
if(isset($_POST["rejected"])){
    //echo "Debugging Please ignore.";
    //var_dump($_POST);
    $sqlget="SELECT * FROM cases where PKID=".$_POST['pkid'].";";
    $result=$conn->query($sqlget);
    $row=mysqli_fetch_assoc($result);
    $case=$row["CASE_NUM"];
    $type=$row["TYPE"];
    $engid=$row["ENG_CEC"];
    $customer=$row["CUSTOMER"];
    $shift=$row["SHIFT"];
    $qmid=$row["QM_CEC"];
    $reason=$_POST["reason"];
    if($type=="Auto"){
            $sqlc="UPDATE C_ENG SET EA_COUNT=EA_COUNT-1 WHERE CEC='".$engid."';";
            $sqlt="UPDATE T_ENG SET EA_COUNT=EA_COUNT-1 WHERE CEC='".$engid."' AND DATES='$today';"  ;

        }
        else if($type=="Manual P1/P2"){
            $sqlc="UPDATE C_ENG SET P1P2_COUNT=P1P2_COUNT-1 WHERE CEC='".$engid."';";
            $sqlt="UPDATE T_ENG SET P1P2_COUNT=P1P2_COUNT-1 WHERE CEC='".$engid."' AND DATES='$today';";

        }
        else if($type=="Manual P3/P4"){
            $sqlc="UPDATE C_ENG SET P3P4_COUNT=P3P4_COUNT-1 WHERE CEC='".$engid."';";
            $sqlt="UPDATE T_ENG SET P3P4_COUNT=P3P4_COUNT-1 WHERE CEC='".$engid."' AND DATES='$today';";
        }
        if(mysqli_query($conn,$sqlc)){
            echo "Updated C_ENG";
        }
        else{
            echo mysqli_error($conn);
        }
    if($type=="Auto"){
        $sqldec="UPDATE ENGINEER SET EA=EA-1 WHERE CEC='$engid'";
    }
    else if($type=="Manual P1/P2"){
        $sqldec="UPDATE ENGINEER SET P1P2=P1P2-1 WHERE CEC='$engid'";
    }
    else{
        $sqldec="UPDATE ENGINEER SET P3P4=P3P4-1 WHERE CEC='$engid'";
    }
    $sqlupdate="UPDATE CASES SET ENG_CEC='REJECTED', ACCEPT=0 WHERE PKID=".$_POST['pkid'].";";
    $sqlcheck="SELECT * FROM engineer;";
    $resultcheck=$conn->query($sqlcheck);
    $a=array();
    while($row=mysqli_fetch_assoc($resultcheck)){
        array_push($a,$row["CEC"]);
    }
    //echo array_search($engid, $a);
    $sqlc="UPDATE C_ENG SET REJECTED=REJECTED+1 WHERE CEC='".$engid."';";
    $sqltdel="UPDATE T_ENG SET REJECTED=REJECTED+1 WHERE CEC='".$engid."' AND DATES='$today' AND SHIFT='$shift';";
    if(array_search($engid,$a)!==FALSE){
    $sql="INSERT INTO reject VALUES(".$_POST['pkid'].",'".$customer."','$case','$qmid','$engid','".date('Y-m-d H:i:s')."','$shift','$type','".addslashes($reason)."');";
    if($conn->query($sql) && $conn->query($sqlupdate) && $conn->query($sqldec) ){
        if($conn->query($sqlc)){
            if($conn->query($sqltdel)){
                if($conn->query($sqlt)){
        echo "<script>
        window.onunload = refreshParent;
        function refreshParent() {
            window.opener.location.reload();
        }
        window.close();
        </script>";
     }
 }
 }
}
    else{

     echo mysqli_error($conn);

    }
}
}

if(isset($_POST["reject"])){
    $pkid=$_POST["pk"];
     $sqlget="SELECT * FROM cases where PKID=".$pkid.";";
    $result=$conn->query($sqlget);
    $row=mysqli_fetch_assoc($result);
    $case=$row["CASE_NUM"];
    $type=$row["TYPE"];
    $engid=$row["ENG_CEC"];
    $customer=$row["CUSTOMER"];
    $shift=$row["SHIFT"];
    $qmid=$row["QM_CEC"];

}
echo '<html>
<head>
<title>Rejected Case - TAM Tool &middot; Cisco CMS</title>
        <!-- <meta name="description" content="Quality Management Tool">
  <meta name="author" content="Cisco CMS"> -->


        <meta name="viewport" content="width=device-width, initial-scale=1">


        <link rel="stylesheet" href="css/normalize.css">
        <link rel="stylesheet" href="css/skeleton.css">
        <link rel="shortcut icon" href="favicon.png">
        </head>
<body style="margin:10%;">
<form action="rejected.php" method="POST" >

        <!-- Case Number D, Engineer CEC D, Time Rejected D, Type of Case (Auto/Manual - P1-2/3-4) D, Reason for Rejection Textarea  -->


                        <div class="field half tb">
                            <label for="name">Case Number</label>
                            <input type="text" id="" value="'.$case.'" readonly required/>

                        </div>

                        <div class="field half tb last">
                            <label for="eID">Engineer CEC ID</label>
                            <input readonly="readonly" required="required" type="text" id="eID" value="'.$engid.'" name="engcecid">
                        </div>
                        <div class="field half tnb">
                            <label for="datetime">Date &amp; Time Of Rejection</label>
                            <input type="text" id="datetime" value="'.date( 'Y-m-d H:i:s').'" required readonly/>

                        </div>
                        <div class="field half last tnb">
                            <label for="pkid">Type of Case</label>
                            <input type="text" id="" name="" value="'.$type.'" required readonly >
                        </div>
                        <input type="hidden" value="'.$pkid.'" name="pkid"/>
                        <div class="field tnb">
                            <label for="Case Number/Email Subject">Reason for Rejection</label>
                            <!-- <input type="text" id="cNum" name="caseNum" readonly required/> -->
                            <textarea style="resize:none;" placeholder="Please enter a valid reason for rejecting this case & remarks if any." name="reason"></textarea>
                        </div>




      </div>
      <div class="modal-buttons">
        <button type="submit" class="button button-primary close-modal" id="close-modal-rej" name="rejected">Submit</button>
        <!-- <button class="button button-primary close-modal" id="close-modal-rej2">Close</button> -->
      </div>
      </form>
      </body>
</html>';
ob_end_flush();
?>
