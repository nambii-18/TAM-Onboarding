<?php
//var_dump($_GET);
//echo  $status;
//session_id($sid);
ob_start();
require("connect.php");
require '/var/www/html/newmail/PHPMailerAutoload.php';
require '/var/www/html/newmail/class.phpmailer.php';
session_start();
ob_start();
extract($_POST);
//var_dump($_POST);


require("connect.php");


if(isset($_GET["checked"])){
  $status=$_GET["status"];
  echo $status;
}

if(isset($_POST["assign"])){
	//var_dump($_POST);
	//echo "Entering adhoc";
	$customer=$_POST["customer"];
	$pkid=$_POST["pkid"];
	$reviewer=$_POST["reviewer"];
	$reviewdate=$_POST["reviewdate"];
	$tnum=$_POST["tnum"];
	$createdate=$_POST["createdate"];
    $status=$_POST["status"];
	$priority=$_POST["priority"];
	$towner=$_POST["towner"];
	$gdc=$_POST["gdc"];
	$comment=addslashes($_POST["comment"]);
    $dcrs=$_POST["dcrs"];
    $dcps=$_POST["dcps"];
    $trs=$_POST["trs"];
    $tps=$_POST["tps"];
    $ccrs=$_POST["ccrs"];
    $ccps=$_POST["ccps"];
    $evrs=$_POST["evrs"];
    $evps=$_POST["evps"];
    $cdrs=$_POST["cdrs"];
    $cdps=$_POST["cdps"];
    $frs=$_POST["frs"];
    $fps=$_POST["fps"];

    if(isset($_POST["cd1"])){
        $cd1=$_POST["cd1"];
    }
    else{
        $cd1=0;
    }
    if(isset($_POST["cd2"])){
        $cd2=$_POST["cd2"];
    }
    else{
        $cd2=0;
    }
    if(isset($_POST["cd3"])){
        $cd3=$_POST["cd3"];
    }
    else{
        $cd3=0;
    }
    if(isset($_POST["cd4"])){
        $cd4=$_POST["cd4"];
    }
    else{
        $cd4=0;
    }


    if(isset($_POST["dc1"])){
        $dc1=$_POST["dc1"];
    }
    else{
        $dc1=0;
    }
    if(isset($_POST["dc2"])){
        $dc2=$_POST["dc2"];
    }
    else{
        $dc2=0;
    }
    if(isset($_POST["dc3"])){
        $dc3=$_POST["dc3"];
    }
    else{
        $dc3=0;
    }


    if(isset($_POST["cc1"])){
        $cc1=$_POST["cc1"];
    }
    else{
        $cc1=0;
    }
    if(isset($_POST["cc2"])){
        $cc2=$_POST["cc2"];
    }
    else{
        $cc2=0;
    }
    if(isset($_POST["cc3"])){
        $cc3=$_POST["cc3"];
    }
    else{
        $cc3=0;
    }
    if(isset($_POST["cc4"])){
        $cc4=$_POST["cc4"];
    }
    else{
        $cc4=0;
    }


    if(isset($_POST["eve1"])){
        $eve1=$_POST["eve1"];
    }
    else{
         $eve1=0;
    }
    if(isset($_POST["eve2"])){
        $eve2=$_POST["eve2"];
    }
    else{
         $eve2=0;
    }
    if(isset($_POST["eve4"])){
        $eve4=$_POST["eve4"];
    }
    else{
         $eve4=0;
    }
    if(isset($_POST["eve3"])){
        $eve3=$_POST["eve3"];
    }
    else{
         $eve3=0;
    }


    if(isset($_POST["t1"])){
        $t1=$_POST["t1"];
    }
    else{
        $t1=0;
    }
    if(isset($_POST["t2"])){
        $t2=$_POST["t2"];
    }
    else{
        $t2=0;
    }
    if(isset($_POST["t3"])){
        $t3=$_POST["t3"];
    }
    else{
        $t3=0;
    }
    if(isset($_POST["t4"])){
        $t4=$_POST["t4"];
    }
    else{
        $t4=0;
    }

		$sql="INSERT INTO REVIEW2(`PKID`, `CUSTOMER`, `REVIEWER`, `REVIEW_DATE`, `TNUM`, `STATUS`, `CREATE_DATE`, `PRIORITY`, `TOWNER`, `GDC`, `DC1`, `DC2`, `DC3`, `T1`, `T2`, `T3`, `T4`, `CC1`, `CC2`, `CC3`, `CC4`, `EVE1`, `EVE2`, `EVE3`, `EVE4`, `CD1`, `CD2`, `CD3`, `CD4`, `COMMENTS`,`DCRS`, `DCPS`, `TRS`, `TPS`, `CCRS`, `CCPS`, `EVERS`, `EVEPS`, `CDRS`, `CDPS`, `FRS`, `FPS`) VALUES($pkid,'$customer','$reviewer','$reviewdate','$tnum','$status','$createdate',$priority,'$towner','$gdc',$dc1,$dc2,$dc3,$t1,$t2,$t3,$t4,$cc1,$cc2,$cc3,$cc4,$eve1,$eve2,$eve3,$eve4,$cd1,$cd2,$cd3,$cd4,'$comment',$dcrs,$dcps,$trs,$tps,$ccrs,$ccps,$evrs,$evps,$cdrs,$cdps,$frs,$fps);";
	$sqldelete="DELETE FROM backlog where pkid=".$pkid.";";
	if(mysqli_query($conn,$sql) && mysqli_query($conn,$sqldelete)){

		//setcookie("bro",1);
		//$_COOKIE["bro"]=1;
//		$comment=str_replace(" ", "+", $comment);
//		$customer=str_replace(" ", '+', $customer);
        sendmail($_POST);

//echo file_get_contents ("http://cmstools.cisco.com/testmail/send.php?customer=$customer&tnum=$tnum&priority=$priority&towner=$towner&reviewer=$reviewer&status=$status&dc1=$dc1&dc2=$dc2&dc3=$dc3&t1=$t1&t2=$t2&t3=$t3&t4=$t4&cc1=$cc1&cc2=$cc2&cc3=$cc3&cc4=$cc4&eve1=$eve1&eve2=$eve2&eve3=$eve3&eve4=$eve4&cd1=$cd1&cd2=$cd2&cd3=$cd3&cd4=$cd4&dcps=$dcps&tps=$tps&ccps=$ccps&evps=$evps&cdps=$cdps&fps=$fps&comment=$comment");
//header("Location:backlog.php");

	}
	else{
		echo $conn->error;
	}
}

if(isset($_POST["assignadhoc"])){
	//var_dump($_POST);
	//echo "Entering adhoc";
	$customer=$_POST["customer"];
	$pkid=$_POST["pkid"];
	$reviewer=$_POST["reviewer"];
	$reviewdate=$_POST["reviewdate"];
	$tnum=$_POST["tnum"];
	$createdate=$_POST["createdate"];
	if(isset($_POST["status"])){
		$status="Open";
	}
	else{
		$status="Closed";
	}
	$priority=$_POST["priority"];
	$towner=$_POST["towner"];
	$gdc=$_POST["gdc"];
	$comment=addslashes($_POST["comment"]);
    $dcrs=$_POST["dcrs"];
    $dcps=$_POST["dcps"];
    $trs=$_POST["trs"];
    $tps=$_POST["tps"];
    $ccrs=$_POST["ccrs"];
    $ccps=$_POST["ccps"];
    $evrs=$_POST["evrs"];
    $evps=$_POST["evps"];
    $cdrs=$_POST["cdrs"];
    $cdps=$_POST["cdps"];
    $frs=$_POST["frs"];
    $fps=$_POST["fps"];

    if(isset($_POST["cd1"])){
        $cd1=$_POST["cd1"];
    }
    else{
        $cd1=0;
    }
    if(isset($_POST["cd2"])){
        $cd2=$_POST["cd2"];
    }
    else{
        $cd2=0;
    }
    if(isset($_POST["cd3"])){
        $cd3=$_POST["cd3"];
    }
    else{
        $cd3=0;
    }
    if(isset($_POST["cd4"])){
        $cd4=$_POST["cd4"];
    }
    else{
        $cd4=0;
    }


    if(isset($_POST["dc1"])){
        $dc1=$_POST["dc1"];
    }
    else{
        $dc1=0;
    }
    if(isset($_POST["dc2"])){
        $dc2=$_POST["dc2"];
    }
    else{
        $dc2=0;
    }
    if(isset($_POST["dc3"])){
        $dc3=$_POST["dc3"];
    }
    else{
        $dc3=0;
    }


    if(isset($_POST["cc1"])){
        $cc1=$_POST["cc1"];
    }
    else{
        $cc1=0;
    }
    if(isset($_POST["cc2"])){
        $cc2=$_POST["cc2"];
    }
    else{
        $cc2=0;
    }
    if(isset($_POST["cc3"])){
        $cc3=$_POST["cc3"];
    }
    else{
        $cc3=0;
    }
    if(isset($_POST["cc4"])){
        $cc4=$_POST["cc4"];
    }
    else{
        $cc4=0;
    }


    if(isset($_POST["eve1"])){
        $eve1=$_POST["eve1"];
    }
    else{
         $eve1=0;
    }
    if(isset($_POST["eve2"])){
        $eve2=$_POST["eve2"];
    }
    else{
         $eve2=0;
    }
    if(isset($_POST["eve4"])){
        $eve4=$_POST["eve4"];
    }
    else{
         $eve4=0;
    }
    if(isset($_POST["eve3"])){
        $eve3=$_POST["eve3"];
    }
    else{
         $eve3=0;
    }


    if(isset($_POST["t1"])){
        $t1=$_POST["t1"];
    }
    else{
        $t1=0;
    }
    if(isset($_POST["t2"])){
        $t2=$_POST["t2"];
    }
    else{
        $t2=0;
    }
    if(isset($_POST["t3"])){
        $t3=$_POST["t3"];
    }
    else{
        $t3=0;
    }
    if(isset($_POST["t4"])){
        $t4=$_POST["t4"];
    }
    else{
        $t4=0;
    }

		$sql="INSERT INTO REVIEW2(`PKID`, `CUSTOMER`, `REVIEWER`, `REVIEW_DATE`, `TNUM`, `STATUS`, `CREATE_DATE`, `PRIORITY`, `TOWNER`, `GDC`, `DC1`, `DC2`, `DC3`, `T1`, `T2`, `T3`, `T4`, `CC1`, `CC2`, `CC3`, `CC4`, `EVE1`, `EVE2`, `EVE3`, `EVE4`, `CD1`, `CD2`, `CD3`, `CD4`, `COMMENTS`,`DCRS`, `DCPS`, `TRS`, `TPS`, `CCRS`, `CCPS`, `EVERS`, `EVEPS`, `CDRS`, `CDPS`, `FRS`, `FPS`) VALUES($pkid,'$customer','$reviewer','$reviewdate','$tnum','$status','$createdate',$priority,'$towner','$gdc',$dc1,$dc2,$dc3,$t1,$t2,$t3,$t4,$cc1,$cc2,$cc3,$cc4,$eve1,$eve2,$eve3,$eve4,$cd1,$cd2,$cd3,$cd4,'$comment',$dcrs,$dcps,$trs,$tps,$ccrs,$ccps,$evrs,$evps,$cdrs,$cdps,$frs,$fps);";
    echo $sql;

	 if(mysqli_query($conn,$sql)){
//		echo "Sucess";
//		setcookie("bro",1);
//		$_COOKIE["bro"]=1;
//		$comment=str_replace(" ", "+", $comment);
//		$customer=str_replace(" ", '+', $customer);
//    echo file_get_contents ("http://cmstools.cisco.com/testmail/send.php?customer=$customer&tnum=$tnum&priority=$priority&towner=$towner&reviewer=$reviewer&status=$status&dc1=$dc1&dc2=$dc2&dc3=$dc3&t1=$t1&t2=$t2&t3=$t3&t4=$t4&cc1=$cc1&cc2=$cc2&cc3=$cc3&cc4=$cc4&eve1=$eve1&eve2=$eve2&eve3=$eve3&eve4=$eve4&cd1=$cd1&cd2=$cd2&cd3=$cd3&cd4=$cd4&dcps=$dcps&tps=$tps&ccps=$ccps&evps=$evps&cdps=$cdps&fps=$fps&comment=$comment");
//		echo "Redirecting";
//header("Location:backlog.php");
         sendmail($_POST);
	 }
	else{
	 	echo $conn->error;
        echo "error here";
	}
}


function color($score,$total){
    if($score<(0.4*$total)){
        $color='crimson';
    }
    else if($score>=(0.4*$total) && $score<(0.75*$total)){
        $color='goldenrod';
    }
    else{
        $color='green';
    }
    return $color;
}

function arrayToObject(array $array, $PHPMailer) {
    return unserialize(sprintf(
        'O:%d:"%s"%s',
        strlen($PHPMailer),
        $PHPMailer,
        strstr(serialize($array), ':')
    ));
}

function sendmail($post){
    require("connect.php");
   extract($post);
    $mail=json_decode($mail,TRUE);
    $PHPMailer="PHPMailer";
    $mail=arrayToObject($mail,$PHPMailer);
   // var_dump($mail);
if(isset($_POST["cd1"])){
        $cd1=$_POST["cd1"];
    }
    else{
        $cd1=0;
    }
    if(isset($_POST["cd2"])){
        $cd2=$_POST["cd2"];
    }
    else{
        $cd2=0;
    }
    if(isset($_POST["cd3"])){
        $cd3=$_POST["cd3"];
    }
    else{
        $cd3=0;
    }
    if(isset($_POST["cd4"])){
        $cd4=$_POST["cd4"];
    }
    else{
        $cd4=0;
    }


    if(isset($_POST["dc1"])){
        $dc1=$_POST["dc1"];
    }
    else{
        $dc1=0;
    }
    if(isset($_POST["dc2"])){
        $dc2=$_POST["dc2"];
    }
    else{
        $dc2=0;
    }
    if(isset($_POST["dc3"])){
        $dc3=$_POST["dc3"];
    }
    else{
        $dc3=0;
    }


    if(isset($_POST["cc1"])){
        $cc1=$_POST["cc1"];
    }
    else{
        $cc1=0;
    }
    if(isset($_POST["cc2"])){
        $cc2=$_POST["cc2"];
    }
    else{
        $cc2=0;
    }
    if(isset($_POST["cc3"])){
        $cc3=$_POST["cc3"];
    }
    else{
        $cc3=0;
    }
    if(isset($_POST["cc4"])){
        $cc4=$_POST["cc4"];
    }
    else{
        $cc4=0;
    }


    if(isset($_POST["eve1"])){
        $eve1=$_POST["eve1"];
    }
    else{
         $eve1=0;
    }
    if(isset($_POST["eve2"])){
        $eve2=$_POST["eve2"];
    }
    else{
         $eve2=0;
    }
    if(isset($_POST["eve4"])){
        $eve4=$_POST["eve4"];
    }
    else{
         $eve4=0;
    }
    if(isset($_POST["eve3"])){
        $eve3=$_POST["eve3"];
    }
    else{
         $eve3=0;
    }


    if(isset($_POST["t1"])){
        $t1=$_POST["t1"];
    }
    else{
        $t1=0;
    }
    if(isset($_POST["t2"])){
        $t2=$_POST["t2"];
    }
    else{
        $t2=0;
    }
    if(isset($_POST["t3"])){
        $t3=$_POST["t3"];
    }
    else{
        $t3=0;
    }
    if(isset($_POST["t4"])){
        $t4=$_POST["t4"];
    }
    else{
        $t4=0;
    }

$sql="SELECT * FROM ENGINEER WHERE CEC='".$towner."';";
$result=$conn->query($sql);
$row=mysqli_fetch_assoc($result);
$gdc=$row["GDC"];

$sqlman="SELECT * FROM MANAGER WHERE GDC='$gdc'";
$result=$conn->query($sqlman);


//$status='';
$comment=stripslashes($comment);


$dc="";
if($dc1<0){
    $dc=$dc."<br>Case update template missing";
}
if($dc2<0){
    $dc=$dc."<br>Poor Customer Communication";
}
if($dc3<0){
    $dc=$dc."<br>Ticket Not Updated";
}

$t="";
if($t1<0){
    $t=$t."<br>Initial Triage/Troubleshooting Approach Inadequate ";
}
if($t2<0){
    $t=$t."<br>Initial Triage/Troubleshooting Approach Incorrect ";
}
if($t3<0){
    $t=$t."<br>Quality of Troubleshooting Inadequate ";
}
if($t4<0){
    $t=$t."<br>Quality of Troubleshooting Incorrect ";
}


$cc="";
if($cc1<0){
    $cc=$cc."<br>Timers (Pending/States/Status) Not Used Correctly";
}
 if($cc2<0){
    $cc=$cc."<br>Priority Incorrect";
}
if($cc3<0){
    $cc=$cc."<br>Customer Impact Incorrect or Unclear";
}
if($cc4<0){
    $cc=$cc."<br>Customer Impact Not Stated";
}


$eve="";
if($eve1<0){
    $eve=$eve."<br>Case Not Escalated in a Timely Manner";
}
if($eve2<0){
    $eve=$eve."<br>Escalation Details Inadequate";
}
if($eve3<0){
    $eve=$eve."<br>Escalation Details Missing";
}
if($eve4<0){
    $eve=$eve."<br>3rd Party Documentation Missing";
}

$cd="";
if($cd1<0){
    $cd=$cd."<br>Resolution/Cause Code Incorrect";
}
if($cd2<0){
    $cd=$cd."<br>Responsible Party Incorrect ";
}
if($cd3<0){
    $cd=$cd."<br>Resolution Summary Inadequate";
}
if($cd4<0){
    $cd=$cd."<br>Resolution Summary Missing";
}


//$mail->AddAddress("svenkatt@cisco.com");//Engineer
//$mail->AddAddress("amasarda@cisco.com");//Engineer
$mail->AddAddress($towner."@cisco.com");//Engineer
$mail->AddAddress($reviewer."@cisco.com");//Reviewer
$mail->AddBCC("trdavid@cisco.com", "draphel@cisco.com");
while($rowman=mysqli_fetch_assoc($result)){
    $mail->AddCC($rowman["MANAGER"]."@cisco.com");//Manager
}

///$mail->AddCC("svenkatt@cisco.com");
$mail->Subject = "Case Review by ".strtoupper($reviewer)." for ".$customer." $tnum";
// $mail->Body = "LeadCEC:$LeadCEC\nEmail:$Email\nReciewDate:$ReviewDate\nEngineerCEC:$EngineerCEC\nMAPNumber:$MAPNumber\nCustomer:$Customer\nCreateDate:$CreateDate\nIICaptureS:$IICaptureS\nIICaptureC:$IICaptureC\nIIUpdateS:$IIUpdateS\nIIUpdateC:$IIUpdateC\nDCDocumentationS:$DCDocumentationS\nDCDocumentationC:$DCDocumentationC\nDCCommunicationS:$DCCommunicationS\nDCCommunicationC:$DCCommunicationC\nTIsolationS:$TIsolationS\nTIsolationC:$TIsolationC\nTTshootingS:$TTshootingS\nTTshootingC:$TTshootingC\nTLeadRequestS:$TLeadRequestS\nTLeadRequestC:$TLeadRequestC\n$TRFCS,TRFCC:$TRFCC\nRTimelineS:$RTimelineS\nRTimelineC:$RTimelineC\nRCategorizationS:$RCategorizationS\nRCategorizationC:$RCategorizationC\nRCodesS:$RCodesS\nRCodesC:$RCodesC\nRCauseS:$RCauseS\nRCauseC:$RCauseC\nRDocumentationS:$RDocumentationS\nRDocumentationC:$RDocumentationC\nIIScore:$IIScore\nDCScore:$DCScore\nTscore:$Tscore\nRscore:$Rscore\nFinalScore:$FinalScore\nCaseS:$CaseS\n";

if($status=="Closed")
 {
$mail->Body='

<html>
  <head>
    <meta name="viewport" content="width=device-width">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>CMS Case Review Tool</title>
    <style type="text/css">

    /* -------------------------------------
        RESPONSIVE AND MOBILE FRIENDLY STYLES
    ------------------------------------- */
    @media only screen and (max-width: 620px) {
      table[class=body] h1 {
        font-size: 28px !important;
        margin-bottom: 10px !important; }
      table[class=body] p,
      table[class=body] ul,
      table[class=body] ol,
      table[class=body] td,
      table[class=body] span,
      table[class=body] a {
        font-size: 16px !important; }
      table[class=body] .wrapper,
      table[class=body] .article {
        padding: 10px !important; }
      table[class=body] .content {
        padding: 0 !important; }
      table[class=body] .container {
        padding: 0 !important;
        width: 100% !important; }
      table[class=body] .main {
        border-left-width: 0 !important;
        border-radius: 0 !important;
        border-right-width: 0 !important; }
      table[class=body] .btn table {
        width: 100% !important; }
      table[class=body] .btn a {
        width: 100% !important; }
      table[class=body] .img-responsive {
        height: auto !important;
        max-width: 100% !important;
        width: auto !important; }}
    /* -------------------------------------
        PRESERVE THESE STYLES IN THE HEAD
    ------------------------------------- */
    @media all {
      .ExternalClass {
        width: 100%; }
      .ExternalClass,
      .ExternalClass p,
      .ExternalClass span,
      .ExternalClass font,
      .ExternalClass td,
      .ExternalClass div {
        line-height: 100%; }
      .apple-link a {
        color: inherit !important;
        font-family: "Segoe UI", "SanFrancisco", "HelveticaNeue", "Helvetica Neue", Helvetica, Arial, sans-serif !important;
        font-size: inherit !important;
        font-weight: inherit !important;
        line-height: inherit !important;
        text-decoration: none !important; }
      .btn-primary table td:hover {
        background-color: #34495e !important; }
      .btn-primary a:hover {
        background-color: #34495e !important;
        border-color: #34495e !important; } }
    </style>
  </head>
  <body class="" style="background-color:#f6f6f6;font-family: Segoe UI, SanFrancisco, HelveticaNeue, Helvetica Neue, Helvetica, Arial, sans-serif;-webkit-font-smoothing:antialiased;font-size:14px;line-height:1.4;margin:0;padding:0;-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;">
    <table border="0" cellpadding="0" cellspacing="0" class="body" style="border-collapse:separate;mso-table-lspace:0pt;mso-table-rspace:0pt;background-color:#f6f6f6;width:100%;">
      <tr>
        <td style="font-family:sans-serif;font-size:14px;vertical-align:top;">&nbsp;</td>
        <td class="container" style="font-family: Segoe UI, SanFrancisco, HelveticaNeue, Helvetica Neue, Helvetica, Arial, sans-serif;font-size:14px;vertical-align:top;display:block;max-width:580px;padding:10px;width:580px;Margin:0 auto !important;">
          <div class="content" style="box-sizing:border-box;display:block;Margin:0 auto;max-width:580px;padding:10px;">
            <!-- START CENTERED WHITE CONTAINER -->
            <!-- <span class="preheader" style="color:transparent;display:none;height:0;max-height:0;max-width:0;opacity:0;overflow:hidden;mso-hide:all;visibility:hidden;width:0;">New Case Review from '.$towner.'.</span> -->
            <table class="main" style="border-collapse:separate;mso-table-lspace:0pt;mso-table-rspace:0pt;background:#fff;border-radius:3px;width:100%;">
              <!-- START MAIN CONTENT AREA -->
              <tr>
                <td class="wrapper" style="font-family: Segoe UI, SanFrancisco, HelveticaNeue, Helvetica Neue, Helvetica, Arial, sans-serif;font-size:14px;vertical-align:top;box-sizing:border-box;padding:20px;">
                  <table border="0" cellpadding="0" cellspacing="0" style="border-collapse:separate;mso-table-lspace:0pt;mso-table-rspace:0pt;width:100%;">
                    <tr>
                      <td style="font-family: Segoe UI, SanFrancisco, HelveticaNeue, Helvetica Neue, Helvetica, Arial, sans-serif;font-size:14px;vertical-align:top;">
                        <p style="font-family: Segoe UI, SanFrancisco, HelveticaNeue, Helvetica Neue, Helvetica, Arial, sans-serif;font-size:14px;font-weight:normal;margin:0;Margin-bottom:15px;">Hi '.$towner.',</p>
                        <p style="font-family: Segoe UI, SanFrancisco, HelveticaNeue, Helvetica Neue, Helvetica, Arial, sans-serif;font-size:14px;font-weight:normal;margin:0;Margin-bottom:15px;"><span style="font-weight:bolder;">'.strtoupper($reviewer).'</span> reviewed '.$customer.' '.$tnum.', please find their observation below.</p>
                        <p><span style="font-weight:bolder;">Priority: </span>'.$priority.'</p>
                        <p><span style="font-weight:bolder;">Status: </span>'.$status.'</p>
                        <table border="0" cellpadding="0" cellspacing="0" class="btn btn-primary" style="border-collapse:separate;mso-table-lspace:0pt;mso-table-rspace:0pt;box-sizing:border-box;width:100%;">

                          <tbody>
                            <tr>
                              <td align="left" style="font-family: Segoe UI, SanFrancisco, HelveticaNeue, Helvetica Neue, Helvetica, Arial, sans-serif;font-size:14px;vertical-align:top;padding-bottom:15px;">
                              <table style="font-family: Segoe UI, SanFrancisco, HelveticaNeue, Helvetica Neue, Helvetica, Arial, sans-serif;font-size:14px;vertical-align:top;box-sizing:border-box;">
	                              <thead>
		                              <tr >
		                              	<th style="text-align:left;">Section</th>
		                              	<th style="text-align:left;padding-left:20px;">Score</th>
		                              </tr>
	                              </thead>
	                              <tbody>
                                      <tr>
                                          <td> <span style="font-weight:bold; color:'.color($dcps,20).';">Documentation &amp; Communication</span>
                                          '.$dc.'</td>
		                                  <td style="padding-left:20px; color:'.color($dcps,20).';">'.$dcps.'</td>
		                               </tr>
		                              <tr>
                                          <td><span style="font-weight:bold; color:'.color($tps,20).';">Initial Triage/Troubleshooting</span>
                                          '.$t.'<td style="padding-left:20px; color:'.color($tps,20).';">'.$tps.'</td>
		                              </tr>
		                               <tr>
		                                  <td><span style="font-weight:bold; color:'.color($ccps,25).';">Case Classification</span>
                                           '.$cc.'</td>
		                                  <td style="padding-left:20px; color:'.color($ccps,25).';">'.$ccps.'</td>
		                               </tr>

		                               <tr>
		                               		<td><span style="font-weight:bold; color:'.color($evps,10).';">Escalations &amp; Vendor Engagements</span>
                                           '.$eve.'</td>
		                               		<td style="padding-left:20px; color:'.color($evps,10).';">'.$evps.'</td>
		                               </tr>

		                               <tr>
		                               		<td><span style="font-weight:bold; color:'.color($cdps,25).';">Closing Details</span>
                                           '.$cd.'</td>
		                               		<td style="padding-left:20px; color:'.color($cdps,25).';">'.$cdps.'</td>
		                               		</tr>
                                      <tr>

                                      <td><span style="font-weight:bold;">Total Presented Score</span></td>
                                          <td style="padding-left:20px;color:'.color($fps,100).'; ">'.$fps.'</td>
                                      </tr>




	                              </tbody>
                              </table>
                              <p><span style="font-weight:bolder";>Overall Comments: </span>'.stripslashes($comment).' </p><br>
                              <p>Please <span style="font-weight:bolder";>"reply all"</span> to this email if you have any questions or need any clarification.</p><br>
                              <p>Thanks &amp; Regards,</p>
								<p>CMS Case Review Tool</p>
                                <!-- <table border="0" cellpadding="0" cellspacing="0" style="border-collapse:separate;mso-table-lspace:0pt;mso-table-rspace:0pt;width:100%;width:auto;">
                                  <tbody>

                                    <tr>
                                      <td style="font-family: Segoe UI, SanFrancisco, HelveticaNeue, Helvetica Neue, Helvetica, Arial, sans-serif;font-size:14px;vertical-align:top;background-color:#ffffff;border-radius:5px;text-align:center;background-color:#3498db;"> <a href="http://10.105.0.230/CRTTester/" target="_blank" style="background-color:#ffffff;border:solid 1px #3498db;border-radius:5px;box-sizing:border-box;color:#3498db;cursor:pointer;display:inline-block;font-size:14px;font-weight:bold;margin:0;padding:12px 25px;text-decoration:none;text-transform:capitalize;background-color:#3498db;border-color:#3498db;color:#ffffff;text-decoration:none;">Open Case Review Tool&nbsp; &#x2794;</a> </td>
                                    </tr>
                                  </tbody>
                                </table> -->
                              </td>
                            </tr>
                          </tbody>
                        </table>
                        <!-- <p style="font-family: Segoe UI, SanFrancisco, HelveticaNeue, Helvetica Neue, Helvetica, Arial, sans-serif;font-size:14px;font-weight:normal;margin:0;Margin-bottom:15px;">This is a really simple email template. Its sole purpose is to get the recipient to click the button with no distractions.</p>
                        <p style="font-family: Segoe UI, SanFrancisco, HelveticaNeue, Helvetica Neue, Helvetica, Arial, sans-serif;font-size:14px;font-weight:normal;margin:0;Margin-bottom:15px;">Good luck! Hope it works.</p> -->
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
              <!-- END MAIN CONTENT AREA -->
            </table>
            <!-- START FOOTER -->
            <div class="footer" style="clear:both;padding-top:30px;text-align:center;width:100%;text-transform:uppercase;letter-spacing:.1rem;">
              <table border="0" cellpadding="0" cellspacing="0" style="text-transform:uppercase;letter-spacing:.1rem;border-collapse:separate;mso-table-lspace:0pt;mso-table-rspace:0pt;width:100%;">
                <tr>
                  <td class="content-block" style="font-family: Segoe UI, SanFrancisco, HelveticaNeue, Helvetica Neue, Helvetica, Arial, sans-serif;font-size:14px;vertical-align:top;color:#999999;font-size:12px;text-align:center;">
                    <br>
                    <span class="apple-link" style="color:#999999;font-size:12px;text-align:center;text-transform:uppercase;letter-spacing:.1rem">CMS &middot; Case Review Tool</span>
                    <br>
                  </td>
                </tr>
                <!-- <tr>
                  <td class="content-block powered-by" style="font-family: Segoe UI, SanFrancisco, HelveticaNeue, Helvetica Neue, Helvetica, Arial, sans-serif;font-size:14px;vertical-align:top;color:#999999;font-size:12px;text-align:center;">
                    Powered by <a href="http://htmlemail.io" style="color:#3498db;text-decoration:underline;color:#999999;font-size:12px;text-align:center;text-decoration:none;">HTMLemail</a>.
                  </td>
                </tr> -->
              </table>
            </div>
            <!-- END FOOTER -->
            <!-- END CENTERED WHITE CONTAINER -->
          </div>
        </td>
        <td style="font-family: sans-serif;font-size:14px;vertical-align:top;">&nbsp;</td>
      </tr>
    </table>
  </body>
</html>







';
}


else
{

$mail->Body='
<html>
  <head>
    <meta name="viewport" content="width=device-width">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>CMS Case Review Tool</title>
    <style type="text/css">

    /* -------------------------------------
        RESPONSIVE AND MOBILE FRIENDLY STYLES
    ------------------------------------- */
    @media only screen and (max-width: 620px) {
      table[class=body] h1 {
        font-size: 28px !important;
        margin-bottom: 10px !important; }
      table[class=body] p,
      table[class=body] ul,
      table[class=body] ol,
      table[class=body] td,
      table[class=body] span,
      table[class=body] a {
        font-size: 16px !important; }
      table[class=body] .wrapper,
      table[class=body] .article {
        padding: 10px !important; }
      table[class=body] .content {
        padding: 0 !important; }
      table[class=body] .container {
        padding: 0 !important;
        width: 100% !important; }
      table[class=body] .main {
        border-left-width: 0 !important;
        border-radius: 0 !important;
        border-right-width: 0 !important; }
      table[class=body] .btn table {
        width: 100% !important; }
      table[class=body] .btn a {
        width: 100% !important; }
      table[class=body] .img-responsive {
        height: auto !important;
        max-width: 100% !important;
        width: auto !important; }}
    /* -------------------------------------
        PRESERVE THESE STYLES IN THE HEAD
    ------------------------------------- */
    @media all {
      .ExternalClass {
        width: 100%; }
      .ExternalClass,
      .ExternalClass p,
      .ExternalClass span,
      .ExternalClass font,
      .ExternalClass td,
      .ExternalClass div {
        line-height: 100%; }
      .apple-link a {
        color: inherit !important;
        font-family: "Segoe UI", "SanFrancisco", "HelveticaNeue", "Helvetica Neue", Helvetica, Arial, sans-serif !important;
        font-size: inherit !important;
        font-weight: inherit !important;
        line-height: inherit !important;
        text-decoration: none !important; }
      .btn-primary table td:hover {
        background-color: #34495e !important; }
      .btn-primary a:hover {
        background-color: #34495e !important;
        border-color: #34495e !important; } }
    </style>
  </head>
  <body class="" style="background-color:#f6f6f6;font-family: Segoe UI, SanFrancisco, HelveticaNeue, Helvetica Neue, Helvetica, Arial, sans-serif;-webkit-font-smoothing:antialiased;font-size:14px;line-height:1.4;margin:0;padding:0;-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;">
    <table border="0" cellpadding="0" cellspacing="0" class="body" style="border-collapse:separate;mso-table-lspace:0pt;mso-table-rspace:0pt;background-color:#f6f6f6;width:100%;">
      <tr>
        <td style="font-family:sans-serif;font-size:14px;vertical-align:top;">&nbsp;</td>
        <td class="container" style="font-family: Segoe UI, SanFrancisco, HelveticaNeue, Helvetica Neue, Helvetica, Arial, sans-serif;font-size:14px;vertical-align:top;display:block;max-width:580px;padding:10px;width:580px;Margin:0 auto !important;">
          <div class="content" style="box-sizing:border-box;display:block;Margin:0 auto;max-width:580px;padding:10px;">
            <!-- START CENTERED WHITE CONTAINER -->
            <!-- <span class="preheader" style="color:transparent;display:none;height:0;max-height:0;max-width:0;opacity:0;overflow:hidden;mso-hide:all;visibility:hidden;width:0;">New Case Review from '.$towner.'.</span> -->
            <table class="main" style="border-collapse:separate;mso-table-lspace:0pt;mso-table-rspace:0pt;background:#fff;border-radius:3px;width:100%;">
              <!-- START MAIN CONTENT AREA -->
              <tr>
                <td class="wrapper" style="font-family: Segoe UI, SanFrancisco, HelveticaNeue, Helvetica Neue, Helvetica, Arial, sans-serif;font-size:14px;vertical-align:top;box-sizing:border-box;padding:20px;">
                  <table border="0" cellpadding="0" cellspacing="0" style="border-collapse:separate;mso-table-lspace:0pt;mso-table-rspace:0pt;width:100%;">
                    <tr>
                      <td style="font-family: Segoe UI, SanFrancisco, HelveticaNeue, Helvetica Neue, Helvetica, Arial, sans-serif;font-size:14px;vertical-align:top;">
                        <p style="font-family: Segoe UI, SanFrancisco, HelveticaNeue, Helvetica Neue, Helvetica, Arial, sans-serif;font-size:14px;font-weight:normal;margin:0;Margin-bottom:15px;">Hi '.$towner.',</p>
                        <p style="font-family: Segoe UI, SanFrancisco, HelveticaNeue, Helvetica Neue, Helvetica, Arial, sans-serif;font-size:14px;font-weight:normal;margin:0;Margin-bottom:15px;"><span style="font-weight:bolder;">'.strtoupper($reviewer).'</span> reviewed '.$customer.' '.$tnum.', please find their observation below.</p>
                        <p><span style="font-weight:bolder;">Priority: </span>'.$priority.'</p>
                        <p><span style="font-weight:bolder;">Status: </span>'.$status.'</p>
                        <table border="0" cellpadding="0" cellspacing="0" class="btn btn-primary" style="border-collapse:separate;mso-table-lspace:0pt;mso-table-rspace:0pt;box-sizing:border-box;width:100%;">

                          <tbody>
                            <tr>
                              <td align="left" style="font-family: Segoe UI, SanFrancisco, HelveticaNeue, Helvetica Neue, Helvetica, Arial, sans-serif;font-size:14px;vertical-align:top;padding-bottom:15px;">
                              <table style="font-family: Segoe UI, SanFrancisco, HelveticaNeue, Helvetica Neue, Helvetica, Arial, sans-serif;font-size:14px;vertical-align:top;box-sizing:border-box;">
	                              <thead>
		                              <tr >
		                              	<th style="text-align:left;">Section</th>
		                              	<th style="text-align:left;padding-left:20px;">Score</th>
		                              </tr>
	                              </thead>
	                              <tbody>
                                      <tr>
                                          <td> <span style="font-weight:bold; color:'.color($dcps,20).';">Documentation &amp; Communication</span>
                                          '.$dc.'</td>
		                                  <td style="padding-left:20px; color:'.color($dcps,20).';">'.$dcps.'</td>
		                               </tr>
		                              <tr>
                                          <td><span style="font-weight:bold; color:'.color($tps,20).';">Initial Triage/Troubleshooting</span>
                                          '.$t.'<td style="padding-left:20px; color:'.color($tps,20).';">'.$tps.'</td>
		                              </tr>
		                               <tr>
		                                  <td><span style="font-weight:bold; color:'.color($ccps,25).';">Case Classification</span>
                                           '.$cc.'</td>
		                                  <td style="padding-left:20px; color:'.color($ccps,25).';">'.$ccps.'</td>
		                               </tr>

		                               <tr>
		                               		<td><span style="font-weight:bold; color:'.color($evps,10).';">Escalations &amp; Vendor Engagements</span>
                                           '.$eve.'</td>
		                               		<td style="padding-left:20px; color:'.color($evps,10).';">'.$evps.'</td>
		                               </tr>



                                      <td><span style="font-weight:bold;">Total Presented Score</span></td>
                                          <td style="padding-left:20px;color:'.color($fps,25).'; ">'.$fps.'</td>
                                      </tr>




	                              </tbody>
                              </table>
                              <p><span style="font-weight:bolder";>Overall Comments: </span>'.stripslashes($comment).' </p><br>
                              <p>Please <span style="font-weight:bolder";>"reply all"</span> to this email if you have any questions or need any clarification.</p><br>
                              <p>Thanks &amp; Regards,</p>
								<p>CMS Case Review Tool</p>
                                <!-- <table border="0" cellpadding="0" cellspacing="0" style="border-collapse:separate;mso-table-lspace:0pt;mso-table-rspace:0pt;width:100%;width:auto;">
                                  <tbody>

                                    <tr>
                                      <td style="font-family: Segoe UI, SanFrancisco, HelveticaNeue, Helvetica Neue, Helvetica, Arial, sans-serif;font-size:14px;vertical-align:top;background-color:#ffffff;border-radius:5px;text-align:center;background-color:#3498db;"> <a href="http://10.105.0.230/CRTTester/" target="_blank" style="background-color:#ffffff;border:solid 1px #3498db;border-radius:5px;box-sizing:border-box;color:#3498db;cursor:pointer;display:inline-block;font-size:14px;font-weight:bold;margin:0;padding:12px 25px;text-decoration:none;text-transform:capitalize;background-color:#3498db;border-color:#3498db;color:#ffffff;text-decoration:none;">Open Case Review Tool&nbsp; &#x2794;</a> </td>
                                    </tr>
                                  </tbody>
                                </table> -->
                              </td>
                            </tr>
                          </tbody>
                        </table>
                        <!-- <p style="font-family: Segoe UI, SanFrancisco, HelveticaNeue, Helvetica Neue, Helvetica, Arial, sans-serif;font-size:14px;font-weight:normal;margin:0;Margin-bottom:15px;">This is a really simple email template. Its sole purpose is to get the recipient to click the button with no distractions.</p>
                        <p style="font-family: Segoe UI, SanFrancisco, HelveticaNeue, Helvetica Neue, Helvetica, Arial, sans-serif;font-size:14px;font-weight:normal;margin:0;Margin-bottom:15px;">Good luck! Hope it works.</p> -->
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
              <!-- END MAIN CONTENT AREA -->
            </table>
            <!-- START FOOTER -->
            <div class="footer" style="clear:both;padding-top:30px;text-align:center;width:100%;text-transform:uppercase;letter-spacing:.1rem;">
              <table border="0" cellpadding="0" cellspacing="0" style="text-transform:uppercase;letter-spacing:.1rem;border-collapse:separate;mso-table-lspace:0pt;mso-table-rspace:0pt;width:100%;">
                <tr>
                  <td class="content-block" style="font-family: Segoe UI, SanFrancisco, HelveticaNeue, Helvetica Neue, Helvetica, Arial, sans-serif;font-size:14px;vertical-align:top;color:#999999;font-size:12px;text-align:center;">
                    <br>
                    <span class="apple-link" style="color:#999999;font-size:12px;text-align:center;text-transform:uppercase;letter-spacing:.1rem">CMS &middot; Case Review Tool</span>
                    <br>
                  </td>
                </tr>
                <!-- <tr>
                  <td class="content-block powered-by" style="font-family: Segoe UI, SanFrancisco, HelveticaNeue, Helvetica Neue, Helvetica, Arial, sans-serif;font-size:14px;vertical-align:top;color:#999999;font-size:12px;text-align:center;">
                    Powered by <a href="http://htmlemail.io" style="color:#3498db;text-decoration:underline;color:#999999;font-size:12px;text-align:center;text-decoration:none;">HTMLemail</a>.
                  </td>
                </tr> -->
              </table>
            </div>
            <!-- END FOOTER -->
            <!-- END CENTERED WHITE CONTAINER -->
          </div>
        </td>
        <td style="font-family: sans-serif;font-size:14px;vertical-align:top;">&nbsp;</td>
      </tr>
    </table>
  </body>
</html>







';


}



if(!$mail->Send())
{
   echo "Error sending: " . $mail->ErrorInfo;;
}
else
{
   echo "Email sent successfully";
   header("Location: backlog.php");
}
}
ob_end_flush();

?>
