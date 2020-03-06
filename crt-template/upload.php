<?php
ob_start();
require("connect.php");
session_start();

//var_dump($_FILES);

$mcec=$_SESSION["manager"];
//echo addslashes("Hello world");
$pubtnum=0;
setcookie("bro",0);
$_COOKIE["bro"]=0;
if($_SESSION["manager"]){
  $mcec=$_SESSION["manager"];

if(isset($_POST["upload"])){
// var_dump($_POST);
// var_dump($_FILES);
if (!$conn)
{
    die("Connection failed: " . mysqli_connect_error());
}

if($_FILES[fileToUploadGSD]["name"]!==""){
  if(substr($_FILES["fileToUploadGSD"]["name"],-4)=="xlsx"){

  $target_dir = "/var/www/html/CRT/HSBC/py/";
  $target_file = $target_dir . basename($_FILES["fileToUploadGSD"]["name"]);
      //echo $target_file;
    //  var_dump($_FILES);
  $filename= (string)basename($_FILES["fileToUploadGSD"]["name"]);

    if (move_uploaded_file($_FILES['fileToUploadGSD']['tmp_name'], $target_file)) {
      //echo "file save successful";
      //$command = escapeshellcmd('/var/www/html/CRT/HSBC/py/22.py');// pass the file name here and delete teh changed
          $output = exec("python /var/www/html/CRT/HSBC/py/22.py $filename");
          //echo $filename;
          //echo "hi".$output;
          $uploadOk = 1;
          $FileType = pathinfo($target_file,PATHINFO_EXTENSION);


          $file = fopen('/var/www/html/CRT/HSBC/py/your_csv.csv', "r") or die("Unable to open file!");

          }
          else {
            die ("file save failed to target directory");
          }


        //echo $target_file;

    }

    else{

        $file = fopen($_FILES["fileToUploadGSD"]["tmp_name"], "r") or die("Unable to open file!");
    }


  $countflag=0;
  $status="";
  $pkid=0;


  $id=1;

      $sqlr="SELECT COUNT(ID) AS NUM FROM REVIEWERS;";
      $resultr=mysqli_query($conn,$sqlr);
      $rowr=mysqli_fetch_assoc($resultr);
      $count=$rowr["NUM"];
      $count=$count+1;
      $failed=0;
      $tid=0;
      $tflag=0;
      $i=0;
      $j=0;

  while(!feof($file))
    {
      $i++;
      $j++;
     $sqlpk="SELECT MAX(PKID) AS NUM FROM BACKLOG";
    $result=mysqli_query($conn,$sqlpk);
    $row=mysqli_fetch_assoc($result);
    $a=$row["NUM"];
    $pkid=$a+1;
    $data = fgets($file);
    $out=explode(",", $data);



      if(strcmp($out[0],"HSBC") !=0 || strpos($out[5],",") === true || count($out)==1)
      {
          //print "Hi";
          continue;
      }

          //echo "hi".$i."\n";
      //echo $j;
    if($out[0]=='')
      {
        //echo 'Ctn';
        continue;
      }
      if(count($out)!=6)
      {
          //echo "num fault";
        continue;
      }
      if($out[0]=='' || $out[1]=='' || $out[2]=='' || $out[3]=='' || $out[4]=='' || $out[5]==''){
          //echo "empty";
        continue;
      }
    $time=trim(strtotime($out[4]));
    $newdate=date("Y-m-d",$time);
    $sqlgdc="SELECT GDC FROM ENGINEER WHERE CEC='".trim($out[5])."';";
    //echo $sqlgdc;
  $resultgdc=mysqli_query($conn,$sqlgdc);
  if(mysqli_num_rows($resultgdc)>0){
    $rowgdc=mysqli_fetch_assoc($resultgdc);
    $gdc=$rowgdc["GDC"];
  }
  else{
    //echo "cONTINUE";
    continue;

  }
    //echo $gdc;
    if(count($out)==6){
      if($out[2]=="Closed" || $out[2]=="Complete" || $out[2]=="Completed"){
        $status="Closed";
      }
      else if($out[2]=="Acknowledged" || $out[2]=="Suspended" || $out[2]=="Working" || $out[2]=="Pending"){
          $status=$out[2];
      }
      else if($out[2]=="Resolved"){
          continue;
      }
      else{
        $status="Open";
      }



      if(substr($out[3], 0)==1){
          $priority=1;
      }
      else if(substr($out[3], 0)==2){
          $priority=2;
      }

      else if(substr($out[3], 0)==3){
          $priority=3;
      }

      else if(substr($out[3], 0)==4){
          $priority=4;
      }
      //echo $out[1];
      //echo $priority
//echo $id;

      if($id==$count){
        // if($tflag==1){

          $sqlcount="SELECT COUNT(ID) AS NUM FROM REVIEWERS2;";
          $resultc=mysqli_query($conn,$sqlcount);
          $row=mysqli_fetch_assoc($resultc);
          $count2=$row["NUM"];
          if($count2==0){
              $id=1;
              goto a;
          }
          $sqlt="SELECT * FROM REVIEWERS2 WHERE ID=$tid;";
          $resultt=mysqli_query($conn,$sqlt);
          $row=mysqli_fetch_assoc($resultt);
          $rcec=$row["CEC"];
          $rgdc=$row["GDC"];
          if ($rgdc==$gdc) {
            $tid++;
            if($tid>=$count2){
              $id=1;
              goto a;
            }
            $sqlt="SELECT * FROM REVIEWERS2 WHERE ID=$tid;";
            $resultt=mysqli_query($conn,$sqlt);
            $row=mysqli_fetch_assoc($resultt);
            $rcec=$row["CEC"];

        }
          $tid++;

          if($count2==$tid){

            $id=1;
          }

        // }


      }
      else{
        a:
      $sqlreview="SELECT CEC FROM REVIEWERS WHERE ID=".$id;
      $resultreview=mysqli_query($conn,$sqlreview);
      $row=mysqli_fetch_assoc($resultreview);
      $rcec=$row["CEC"];
      $id++;
      $tid=0;
    }

        //echo $out[5];
        //echo $rcec;
        //echo "\n";
    	$sql="INSERT INTO BACKLOG VALUES ($pkid,'$out[0]','$out[1]','$status',$priority,'$newdate','".trim($out[5])."','$gdc','$rcec','None');";
        //echo $sql;
  		if (mysqli_query($conn, $sql))
  			{
  				//echo "New record created successfully";

  			}
        else {
          echo "<script>alert('Your upload failed at Ticket Number $out[1]. The rows preceding this ticket number were recorded successfully. Please make sure the rows preceding are removed from the new CSV to avoid redunancy.');</script>";
          break;
        }

    }

    else{
      $countflag=1;
      $failed=1;
        echo "sad";
    }
    }
    if($countflag==1){
      $failed=1;
      echo "<script>alert('Please upload a proper CSV.');</script>";
    }
    fclose($file);
    if($failed!=1){
    echo "<div style='text-align:center;margin-top:10px; padding-bottom:10px; border-bottom:2px solid #8EC343;'>
            <div class='svg' style='display:inline-block;'>
              <svg xmlns='http://www.w3.org/2000/svg' width='26' height='26' viewBox='-263.5 236.5 26 26'>
                <g class='svg-success'>
                  <circle cx='-250.5' cy='249.5' r='12'/>
                  <path d='M-256.46 249.65l3.9 3.74 8.02-7.8'/>
                </g>
              </svg>
            </div>
              <span style='display:inline-block; vertical-align: super;margin-left: 10px;'>Your CSV file has been uploaded successfully!</span>
          </div>";
        }
        else{
           echo "<script>alert('Your upload failed at Ticket Number $pubtnum. The rows preceding this ticket number were recorded successfully. Please make sure the rows preceding are removed from the new CSV to avoid redunancy.');</script>";
        }
  }

if($_FILES[fileToUploadCMSP]["name"]!==""){
  if(substr($_FILES["fileToUploadCMSP"]["name"],-4)=="xlsx"){

  $target_dir = "/var/www/html/CRT/HSBC/py/";
  $target_file = $target_dir . basename($_FILES["fileToUploadCMSP"]["name"]);
      //echo $target_file;
    //  var_dump($_FILES);
  $filename= (string)basename($_FILES["fileToUploadCMSP"]["name"]);

    if (move_uploaded_file($_FILES['fileToUploadCMSP']['tmp_name'], $target_file)) {
      //echo "file save successful";
      //$command = escapeshellcmd('/var/www/html/CRT/HSBC/py/22.py');// pass the file name here and delete teh changed
          $output = exec("python /var/www/html/CRT/HSBC/py/cmsp_crt-final.py $filename");
          //echo $filename;
          //echo "hi".$output;
          $uploadOk = 1;
          $FileType = pathinfo($target_file,PATHINFO_EXTENSION);


          $file = fopen('/var/www/html/CRT/HSBC/py/cmsp_csv.csv', "r") or die("Unable to open file!");

          }
          else {
            die ("file save failed to target directory");
          }


        //echo $target_file;

    }

    else{

        $file = fopen($_FILES["fileToUploadCMSP"]["tmp_name"], "r") or die("Unable to open file!");
    }


  $countflag=0;
  $status="";
  $pkid=0;


  $id=1;

      $sqlr="SELECT COUNT(ID) AS NUM FROM REVIEWERS;";
      $resultr=mysqli_query($conn,$sqlr);
      $rowr=mysqli_fetch_assoc($resultr);
      $count=$rowr["NUM"];
      $count=$count+1;
      $failed=0;
      $tid=0;
      $tflag=0;
      $i=0;
      $j=0;

  while(!feof($file))
    {
      $i++;
      $j++;
     $sqlpk="SELECT MAX(PKID) AS NUM FROM BACKLOG";
    $result=mysqli_query($conn,$sqlpk);
    $row=mysqli_fetch_assoc($result);
    $a=$row["NUM"];
    $pkid=$a+1;
    $data = fgets($file);
    $out=explode(",", $data);



      if(strcmp($out[0],"HSBC") !=0 || strpos($out[5],",") === true || count($out)==1)
      {
          //print "Hi";
          continue;
      }

          //echo "hi".$i."\n";
      //echo $j;
    if($out[0]=='')
      {
        //echo 'Ctn';
        continue;
      }
      if(count($out)!=6)
      {
          //echo "num fault";
        continue;
      }
      if($out[0]=='' || $out[1]=='' || $out[2]=='' || $out[3]=='' || $out[4]=='' || $out[5]==''){
          //echo "empty";
        continue;
      }
       echo $out[4];
      // echo "\n";
    $time=strtotime(str_replace('-','/',$out[4]));
    //echo   $time;
    // echo "\n";
    $newdate=date("Y-m-d",$time);
	//echo $newdate;
    $sqlgdc="SELECT GDC FROM ENGINEER WHERE CEC='".trim($out[5])."';";
    //echo $sqlgdc;
  $resultgdc=mysqli_query($conn,$sqlgdc);
  if(mysqli_num_rows($resultgdc)>0){
    $rowgdc=mysqli_fetch_assoc($resultgdc);
    $gdc=$rowgdc["GDC"];
  }
  else{
    //echo "cONTINUE";
    continue;

  }
    //echo $gdc;
    if(count($out)==6){
      if($out[2]=="Closed" || $out[2]=="Complete" || $out[2]=="Completed"){
        $status="Closed";
      }
      else if($out[2]=="Acknowledged" || $out[2]=="Suspended"){
          $status=$out[2];
      }
      else if($out[2]=="Resolved"){
          continue;
      }
      else{
        $status="Open";
      }
      if(substr($out[3], 0)==1){
          $priority=1;
      }
      else if(substr($out[3], 0)==2){
          $priority=2;
      }

      else if(substr($out[3], 0)==3){
          $priority=3;
      }

      else if(substr($out[3], 0)==4){
          $priority=4;
      }
      //echo $out[1];
      //echo $priority

      if($id==$count){
        // if($tflag==1){

          $sqlcount="SELECT COUNT(ID) AS NUM FROM REVIEWERS2;";
          $resultc=mysqli_query($conn,$sqlcount);
          $row=mysqli_fetch_assoc($resultc);
          $count2=$row["NUM"];
          if($count2==0){
              $id=1;
              goto b;
          }
          $sqlt="SELECT * FROM REVIEWERS2 WHERE ID=$tid;";
          $resultt=mysqli_query($conn,$sqlt);
          $row=mysqli_fetch_assoc($resultt);
          $rcec=$row["CEC"];
          $rgdc=$row["GDC"];
          if ($rgdc==$gdc) {
            $tid++;
            if($tid>=$count2){
              $id=1;
              goto b;
            }
            $sqlt="SELECT * FROM REVIEWERS2 WHERE ID=$tid;";
            $resultt=mysqli_query($conn,$sqlt);
            $row=mysqli_fetch_assoc($resultt);
            $rcec=$row["CEC"];
        }
          $tid++;

          if($count2==$tid){

            $id=1;
          }

        // }


      }
      else{
        b:
      $sqlreview="SELECT CEC FROM REVIEWERS WHERE ID=".$id;
      $resultreview=mysqli_query($conn,$sqlreview);
      $row=mysqli_fetch_assoc($resultreview);
      $rcec=$row["CEC"];
      $id++;
      $tid=0;
    }

        //echo $out[5];
    	$sql="INSERT INTO BACKLOG VALUES ($pkid,'$out[0]','$out[1]','$status',$priority,'$newdate','".trim($out[5])."','$gdc','$rcec','None');";
        //echo $sql;
  		if (mysqli_query($conn, $sql))
  			{
  				//echo "New record created successfully";

  			}
        else {
        //   echo $out[4];
        //   echo "\n";
        // echo   $time;
        // echo "\n";
        //   echo $sql;
        //   var_dump($out);
        //   echo "failing here";
        //   echo $conn->error;
        //   echo "   ";
        //   echo $out[1];
          echo "<script>alert('Your upload failed at Ticket Number $out[1]. The rows preceding this ticket number were recorded successfully. Please make sure the rows preceding are removed from the new CSV to avoid redunancy.');</script>";
          break;
        }

    }

    else{
      $countflag=1;
      $failed=1;
        echo "sad";
    }
    }
    if($countflag==1){
      $failed=1;
      echo "<script>alert('Please upload a proper CSV.');</script>";
    }
    fclose($file);
    if($failed!=1){
    echo "<div style='text-align:center;margin-top:10px; padding-bottom:10px; border-bottom:2px solid #8EC343;'>
            <div class='svg' style='display:inline-block;'>
              <svg xmlns='http://www.w3.org/2000/svg' width='26' height='26' viewBox='-263.5 236.5 26 26'>
                <g class='svg-success'>
                  <circle cx='-250.5' cy='249.5' r='12'/>
                  <path d='M-256.46 249.65l3.9 3.74 8.02-7.8'/>
                </g>
              </svg>
            </div>
              <span style='display:inline-block; vertical-align: super;margin-left: 10px;'>Your CSV file has been uploaded successfully!</span>
          </div>";
        }
        else{
           echo "<script>alert('Your upload failed at Ticket Number $pubtnum. The rows preceding this ticket number were recorded successfully. Please make sure the rows preceding are removed from the new CSV to avoid redunancy.');</script>";
        }
  }
}



  echo "<!DOCTYPE html>
<html lang='en'>

    <head>

        <meta charset='utf-8'>
        <title>Upload - CRT &middot; Cisco CMS</title>
        <!-- <meta name='description' content='Quality Management Tool'>
  <meta name='author' content='Cisco CMS'> -->


        <meta name='viewport' content='width=device-width, initial-scale=1'>


        <link rel='stylesheet' href='css/normalize.css'>
        <link rel='stylesheet' href='css/skeleton.css'>
        <!-- <link rel='stylesheet' href='css/fullpage.css'> -->

<!--    <script src='js/jquery-min.js'></script>
        <script src='js/jquery.fullPage.min.js'></script> -->

    <!-- <link href='css/select2.min.css' rel='stylesheet'/>
    <script src='js/select2.min.js'></script> -->


        <link rel='icon' type='image/png' href='favicon.png'>

</head>
<style>

/*::-webkit-file-upload-button {
      color: #FFF;
    background-color: #33C3F0;
    border-color: #33C3F0;

    display: inline-block;*/
    /*height: 38px;*/
/*    padding: 0 20px;
    color: #555;
    text-align: center;
    font-size: 11px;
    font-weight: 600;
    line-height: 38px;
    letter-spacing: .1rem;
    text-transform: uppercase;
    text-decoration: none;
    white-space: nowrap;
    background-color: transparent;
    border-radius: 0px;
    border: 1px solid #bbb;
    cursor: pointer;
    box-sizing: border-box;
    margin-top: 20px;
    margin-right: 10px;
}*/

.js .inputfile {
    width: 0.1px;
    height: 0.1px;
    opacity: 0;
    overflow: hidden;
    position: absolute;
    z-index: -1;
}

.inputfile + label {
    max-width: 35%;
    font-size: 1.25rem;
    /* 20px */
    font-weight: 700;
    text-overflow: ellipsis;
    white-space: nowrap;
    cursor: pointer;
    display: inline-block;
    overflow: hidden;
    padding: 0.625rem 1.25rem;
    /* 10px 20px */
}

.no-js .inputfile + label {
    display: none;
}

.inputfile:focus + label,
.inputfile.has-focus + label {
    outline: 1px dotted #000;
    outline: -webkit-focus-ring-color auto 5px;
}

.inputfile + label * {
    /* pointer-events: none; */
    /* in case of FastClick lib use */
}

.inputfile + label svg {
    width: 1em;
    height: 1em;
    vertical-align: middle;
    fill: currentColor;
    margin-top: -0.25em;
    /* 4px */
    margin-right: 0.25em;
    /* 4px */
}

.inputfile-2 + label {
    /*color: #d3394c;*/
    border: 1px solid #999;
}

.inputfile-2:focus + label,
.inputfile-2.has-focus + label,
.inputfile-2 + label:hover {
    color: #888;
}
</style>

    <body>

    <div class='container u-max-full-width'>
        <div class='row' style='padding-top:15px;'>
          <!--div style='display:inline-block;'>
            <span style='margin-top:5px;color:grey;'>Made by folks just like you. ;)</span>
          </div-->

           <div class='two columns'>
          <a class='button' style='display:inline-block;border: 0; border-bottom: 1px solid #212121; padding: 0;' onclick='window.close();'>&#x2716; &nbsp; Close this tab</a>
          </div>

          <div class='ten columns' style='float:right;'>
          <div style='display:inline-block;float: right;'>
              <span>Welcome, ".$mcec."</span>
              <span>
                  <form method='POST' action='backlog.php' style='margin: 0; padding-left: 20px; display:inline-block;'>
                    <input type='submit' value='Logout &#x21b7;' name='logout' style='border: 0; border-bottom: 1px solid #212121;padding: 0;'/>
                  </form>
              </span>
              <span><a href='backlog.php' class='button' style='border: 0; border-bottom: 1px solid #212121;padding: 0;margin-left:20px;'>Backlog</a></span>

              <span><a href='adhoc.php' class='button' style='border: 0; border-bottom: 1px solid #212121;padding: 0;margin-left:20px;'>New Adhoc Review</a></span>
              <span><a href='reporter.php' target='_blank' class='button' style='border: 0; border-bottom: 1px solid #212121;padding: 0;margin-left:20px;'>Reporting</a></span>
               <span><form method='POST' action='statistics.php' target='_blank' style='margin:0;padding:0;display: inline-block;'><input type='submit' class='button' name='report' value='Statistics' style='border: 0; border-bottom: 1px solid #212121;padding: 0;margin-left:20px;'></form></span>
               ";
              echo "


              <span><a href='mailto:cms-crt@cisco.com?subject=Feedback%20on%20the%20CRT%20Tool' class='button' style='border: 0; border-bottom: 1px solid #212121;padding: 0;margin-left:20px;'>Give Feedback <span style='font-size:large;'>&#x263a;</span></a></span>

          </div>
        </div>
      </div>
      </div>

        <div class='container u-max-full-width'>
            <div class='row' style='margin-top:1%;'>
                <div class='twelve columns bg-this'>
                    <a href='upload.php'><svg class='img-responsive logo' style='max-width: 185px;width:120px;' x='0px' y='0px' width='200.1px' height='105.4px' viewBox='-305 291.9 200.1 105.4'>
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
                    <h5 style='font-weight:lighter;float:right;'>Case Review Tool <span style='font-weight:bolder;'>v6.0</span></h5>
                </div>
            </div>
        </div>


<div class='row'>
<form method='POST' action='upload.php' enctype='multipart/form-data'>
<div class='field half'>
<label for='name'>Upload a *.CSV file here with a list of all cases in the prescribed format as below.</label>
<!-- <input type='file' name='fileToUpload' id='fileToUpload'/> -->

        <div class='box'>
          <input  type='file' name='fileToUploadGSD' id='file-2' class='inputfile inputfile-2' style='display:none;' />
          <label for='file-2' style='margin: 2rem 2rem 2rem;padding:1.5rem 2rem 1.5rem;max-width:50%;'><svg xmlns='http://www.w3.org/2000/svg' width='20' height='17' viewBox='0 0 20 17'><path d='M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z'/></svg> <span>Upload GSD/Cognos/MAP Export Here</span></label>
        </div>
";

$sql_cust="SELECT * FROM CUSTOMER;";
$result=$conn->query($sql_cust);
$cust=mysqli_fetch_assoc($result);
// var_dump($cust);
if($cust["CUSTOMER"]=="HSBC"){



echo "
        <div class='box'>
          <input  type='file' name='fileToUploadCMSP' id='file-3' class='inputfile inputfile-2' style='display:none;' />
          <label for='file-3' style='margin: 2rem 2rem 2rem;padding:1.5rem 2rem 1.5rem;max-width:50%;'><svg xmlns='http://www.w3.org/2000/svg' width='20' height='17' viewBox='0 0 20 17'><path d='M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z'/></svg> <span>Upload CMSP/EM7 Export Here</span></label>
        </div>


";

}
echo "
<input style='display: inline-block;padding: 0 30px;color: #fff;text-align: center;font-size: 11px;font-weight: 600;line-height: 38px;letter-spacing: .1rem;text-transform: uppercase;text-decoration: none;white-space: nowrap;background-color: #33C3F0;border-radius: 0px;border: 1px solid #33C3F0; cursor: pointer; box-sizing: border-box; margin-top: 6px;margin-left: 20px;width:auto;' type='submit' name='upload' class='button-primary' value='Upload'>

</div>

</form>
<hr>
</div>

<div class='row'>
<h4 style='line-height:inherit;'>Get a Sample *.CSV file <a href='sample.csv' style='text-decoration:none;border-bottom:1px solid #333;font-weight:normal;'>here.</a></h4>
<h5>Or if you're in a rush, here's what your *.CSV file should look like:</h5>
<p>Please note that the following headings are for your reference only. These headings <span style='font-weight:bold'>should not</span> be a part of your *.csv file.</p>

<table class='u-full-width'>
<thead>
<tr>
    <th>Customer</th>
    <th>Ticket Number</th>
    <th>Status</th>
    <th>Ticket Priority</th>
    <th>Ticket Create Date (MM/DD/YYYY)</th>
    <th>Ticket Assigned To</th>
</tr>
</thead>
<!-- <tbody>
<tr>
    <td></td>
    <td></td>
</tr>
</tbody> -->
</table>

</div>


<script src='js/custom-file-input.js'></script>
</body>
</html>";
}

else{
  header("Location:forbidden.html");
}

ob_end_flush();

?>
