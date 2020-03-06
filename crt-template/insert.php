
<?php
ob_start();
require("connect.php");
session_start();
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

		$sql="INSERT INTO REVIEW2 VALUES($pkid,'$customer','$reviewer','$reviewdate','$tnum','$status','$createdate',$priority,'$towner','$gdc',$dc1,$dc2,$dc3,$t1,$t2,$t3,$t4,$cc1,$cc2,$cc3,$cc4,$eve1,$eve2,$eve3,$eve4,$cd1,$cd2,$cd3,$cd4,'$comment',$dcrs,$dcps,$trs,$tps,$ccrs,$ccps,$evrs,$evps,$cdrs,$cdps,$frs,$fps);";
	$sqldelete="DELETE FROM backlog where pkid=".$pkid.";";
	if(mysqli_query($conn,$sql) && mysqli_query($conn,$sqldelete)){

		//setcookie("bro",1);
		//$_COOKIE["bro"]=1;
		$comment=str_replace(" ", "+", $comment);
		$customer=str_replace(" ", '+', $customer);

echo file_get_contents ("http://cmstools.cisco.com/CRT/HSBC-BC/send.php?customer=$customer&tnum=$tnum&priority=$priority&towner=$towner&reviewer=$reviewer&status=$status&dc1=$dc1&dc2=$dc2&dc3=$dc3&t1=$t1&t2=$t2&t3=$t3&t4=$t4&cc1=$cc1&cc2=$cc2&cc3=$cc3&cc4=$cc4&eve1=$eve1&eve2=$eve2&eve3=$eve3&eve4=$eve4&cd1=$cd1&cd2=$cd2&cd3=$cd3&cd4=$cd4&dcps=$dcps&tps=$tps&ccps=$ccps&evps=$evps&cdps=$cdps&fps=$fps&comment=$comment");
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

		$sql="INSERT INTO REVIEW2 VALUES($pkid,'$customer','$reviewer','$reviewdate',$tnum,'$status','$createdate',$priority,'$towner','$gdc',$dc1,$dc2,$dc3,$t1,$t2,$t3,$t4,$cc1,$cc2,$cc3,$cc4,$eve1,$eve2,$eve3,$eve4,$cd1,$cd2,$cd3,$cd4,'$comment',$dcrs,$dcps,$trs,$tps,$ccrs,$ccps,$evrs,$evps,$cdrs,$cdps,$frs,$fps);";

	 if(mysqli_query($conn,$sql)){
//		echo "Sucess";
//		setcookie("bro",1);
//		$_COOKIE["bro"]=1;
		$comment=str_replace(" ", "+", $comment);
		$customer=str_replace(" ", '+', $customer);
    echo file_get_contents ("http://cmstools.cisco.com/testmail/send.php?customer=$customer&tnum=$tnum&priority=$priority&towner=$towner&reviewer=$reviewer&status=$status&dc1=$dc1&dc2=$dc2&dc3=$dc3&t1=$t1&t2=$t2&t3=$t3&t4=$t4&cc1=$cc1&cc2=$cc2&cc3=$cc3&cc4=$cc4&eve1=$eve1&eve2=$eve2&eve3=$eve3&eve4=$eve4&cd1=$cd1&cd2=$cd2&cd3=$cd3&cd4=$cd4&dcps=$dcps&tps=$tps&ccps=$ccps&evps=$evps&cdps=$cdps&fps=$fps&comment=$comment");
//		echo "Redirecting";
//header("Location:backlog.php");
	 }
	else{
	 	echo $conn->error;
	}
}
ob_end_flush();
?>
