<?php
ob_start();
require('connect-hsbc.php');
date_default_timezone_set('Asia/Kolkata');
error_reporting(0);
//echo "sdhjshdsjhsjhdsjhsjhsdjhsjdhjshdjsd";
$login_time='';
$dif='';
$day='';$hour='';$min='';
$prev_state='';
if(isset($_COOKIE['logintime']))
{
  if(isset($_POST['prev_state']))
 $prev_state = $_POST['prev_state'];
$curr_time=date("Y-m-d H:i:s");
$login_time=$_COOKIE["logintime"];
//echo $login_time;
 $diff=date_diff(date_create_from_format('Y-m-d H:i:s', $login_time),date_create_from_format('Y-m-d H:i:s',$curr_time ));
  //ive put it in the beginning
  $dif=$diff->format('%d days %h:%i:%s');
  $day=$diff->d;
  $hour=$diff->h;
  $min=$diff->i;
  $min=($hour*60)+$min;

}

//function timelogic($state,$cec){
//    $string ='qm';
//    $sc=0;
//    $today=date("Y-m-d");
//    $dir = new DirectoryIterator('C:\wamp64\tmp');
//    foreach ($dir as $file) {
//        $content = file_get_contents($file->getPathname());
//        if (strpos($content, $string) !== false) {
//            $sc++;
//        }
//    }
//    if($sc<=10){
//        if($state="Available"){
//            $sqlt="UPDATE T_ENG SET S1_TIME=S1_TIME+1 WHERE CEC=$cec AND DATES=$today;";
//            $sqlc="UPDATE C_ENG SET S1_TIME=S1_TIME+1 WHERE CEC=$cec;";
//        }
//        else if($state="Except Manual P1/P2"){
//            $sqlt="UPDATE T_ENG SET S2_TIME=S2_TIME+1 WHERE CEC=$cec AND DATES=$today;";
//            $sqlc="UPDATE C_ENG SET S2_TIME=S2_TIME+1 WHERE CEC=$cec;";
//        }
//        else{
//            $sqlt="UPDATE T_ENG SET S3_TIME=S3_TIME+1 WHERE CEC=$cec AND DATES=$today;";
//            $sqlc="UPDATE C_ENG SET S3_TIME=S3_TIME+1 WHERE CEC=$cec;";
//        }
//        if($conn->query($sqlt)){
//            if($conn->query($sqlc)){
//                echo "Time Updated for $cec";
//            }
//            else{
//                echo "C-ENG  is not getting updated";
//            }
//        }
//        else{
//            "T_ENG is not getting updated";
//        }
//    }
//}
//
// if($_GET["enggdc"]==1){
//   $eng=$_GET["eng"];
//   $sql="SELECT * FROM ENGINEER WHERE CEC='$eng';";
//   $servername = "localhost";
//   $username = "root";
//   $password = "krithu";
//   $conn = mysqli_connect($servername, $username, $password,"crttester");

//   if (!$conn)
//   {
//       die("Connection failed: " . mysqli_connect_error());
//   }
//   $result=mysqli_query($conn,$sql);
//   $row=mysqli_fetch_assoc($result);
//   echo $row["GDC"];
// }
if(isset($_GET["handoff"])){

  if($conn->connect_error){
     die($connect->error);
  }
  $now=date("Y-m-d H:i:s");
    $sqldis="SELECT MIN(DT_DISPATCH) as DIS FROM DISPATCH WHERE DT_DISPATCH<='$now' AND ASSIGNED!=1 ";
    $resultdis=$conn->query($sqldis);
    $row2=mysqli_fetch_assoc($resultdis);
    $dis=$row2["DIS"];
    echo $dis;
}


if($conn->connect_error){
    die($connect->error);
}
if(isset($_GET["click"])){
  //echo '<script>console.log("You clicked the engineer");</script>';
  $engassname=$_GET["eng"];
  //echo $engassname;
   $sqlstate="SELECT * FROM ENGINEER where CEC='".$engassname."';";
  $resultset=mysqli_query($conn,$sqlstate);
  $row=mysqli_fetch_assoc($resultset);
    $state=$row["STATE"];
    if($state=="Unavailable"){
        echo '<script>alert("Warning: This Engineer is currently Unavailable. You can still assign them this case or pick another engineer for this case.");</script>';
    }
    else if($state=="Except Manual P1/P2"){
        echo '<script>alert("Warning: This Engineer is currently not available to accept P1/P2 cases. You can still assign them this case or pick another engineer for this case.");</script>';
    }
}
if(isset($_GET["refresh"])){
  $sqlreject="SELECT COUNT(PKID) AS NUM FROM REJECT;";
    $result3=$conn->query($sqlreject);
    $row=mysqli_fetch_assoc($result3);
    $value=$row["NUM"];
    $now=date("Y-m-d H:i:s");
    $sqldis="SELECT COUNT(CASE_NUM) as DIS FROM DISPATCH WHERE DT_DISPATCH<='$now' AND ASSIGNED!=1 ";
    $resultdis=$conn->query($sqldis);
    $row2=mysqli_fetch_assoc($resultdis);
    $dis=$row2["DIS"];
    setcookie("discount",$dis);
    $_COOKIE["discount"]=$dis;


        //echo "<a id='auto_load_div' href='reject.php' target='_blank' style='text-decoration: none; border-bottom: 1px solid #000;' title='Reassign all Rejected Cases'>$value</a>";
    echo "<h5 style='font-size: 15px;font-weight: 600;letter-spacing: .1rem;text-transform: uppercase;'>Rejected Cases: <a href='reject.php' target='_blank' style='text-decoration: none; border-bottom: 1px solid #000;' title='Reassign all Rejected Cases'>$value</a></h5>
    <h5 style='font-size: 15px;font-weight: 600;letter-spacing: .1rem;text-transform: uppercase;'>Handoff/Scheduled Dispatch Cases: <a href='reassign.php' id='counter' target='_blank' style='text-decoration: none; border-bottom: 1px solid #000;' title='Reassign all Handoff Cases'>$dis</a></h5>

                        <div class='accordion'>

                        <ul>
                        <li>


                        <input type='checkbox' checked=''>
                        <!-- <i></i> -->

                        <h5 title='Click to Expand' style='font-size: 15px;font-weight: 600;letter-spacing: .1rem;text-transform: uppercase;'>View Number of Assigned Cases &nbsp; &nbsp; &#x25bc;</h5>


                            <table id='ass_cases'>
                              <thead>
                                <tr>
                                  <th>Engg. CEC</th>
                                  <th style='cursor:ns-resize;' onclick='sort_table(sortthis, 1, asc2); asc2 *= -1; asc3 = 1; asc1 = 1; asc4 = 1; asc5 = 1; asc6 = 1;'>Auto/ESR &#x21D5;</th>
                                  <th style='cursor:ns-resize;' onclick='sort_table(sortthis, 2, asc3); asc3 *= -1; asc1 = 1; asc2 = 1; asc4 = 1; asc5 = 1; asc6 = 1;'>MP1/P2 &#x21D5;</th>
                                  <th style='cursor:ns-resize;' onclick='sort_table(sortthis, 3, asc4); asc4 *= -1; asc1 = 1; asc2 = 1; asc3 = 1; asc5 = 1; asc6 = 1;'>MP3/P4 &#x21D5;</th>
                                  <th onclick='sort_table(sortthis, 4, asc5); asc5 *= -1; asc1 = 1; asc2 = 1; asc3 = 1; asc4 = 1; asc6 = 1;'>Current State</th>
                                  <th style='cursor:ns-resize;' onclick='sort_table(sortthis, 5, asc6); asc6 *= -1; asc1 = 1; asc2 = 1; asc3 = 1; asc4 = 1; asc5 = 1;'>Weight &#x21D5;</th>
                                </tr>
                              </thead>
                              <tbody id='sortthis'>
                              ";
                            $sql_sum="SELECT SUM(EA) AS SUM1,SUM(P1P2) AS SUM2,SUM(P3P4) AS SUM3 FROM ENGINEER;";
                            $resultsum=mysqli_query($conn,$sql_sum);
                            $rowsum=mysqli_fetch_assoc($resultsum);
                            $easum=$rowsum["SUM1"];
                            $p1sum=$rowsum["SUM2"];
                            $p3sum=$rowsum["SUM3"];
                            $all=$easum+$p1sum+$p3sum;
                            $sql_number="SELECT * FROM ENGINEER ORDER BY SEQ";
                            $resultset=mysqli_query($conn,$sql_number);
                            while($row=mysqli_fetch_assoc($resultset)){
                               echo "
                                <tr>
                                 <td onclick='insintofield(this);' name='engrow' style='cursor:pointer!important;'>".$row["CEC"]."</td>

                                  <td>".$row["EA"]."</td>
                                  <td>".$row["P1P2"]."</td>
                                  <td>".$row["P3P4"]."</td>
                                  ";
                                  if($row["STATE"]=="Available"){
                                        echo "
                                  <td>
                                    <div style='display:inline-block;' title='Available'>
                                    <!-- <svg viewBox='0 0 10 10' width='15%' style='margin-top:10px;display:inline-block;'>
                                      <circle cx='5' cy='5' r='2' stroke-width='0.3' stroke='green' fill='#fff'/>
                                      <circle cx='5' cy='5' r='1.6' fill='green'/>
                                    </svg> -->
                                    <span style='color:green;text-shadow: 0 0 3px green;font-size:small;'>&#11044;</span>
                                    <!-- Available -->
                                    <p style='margin:0; margin-left:7px;display:inline-block;'>Available</p>
                                    </div>
                                  </td>
                                ";
                                      //addtime


                                  }
                                  else if($row["STATE"]=="Except Manual P1/P2"){
                                     echo "
                                  <td><div style='display:inline-block;' title='Except Manual P1/P2'>
                                  <span style='color:goldenrod;text-shadow: 0 0 3px yellow;font-size:small;'>&#11044;</span>
                                  <p style='margin:0; margin-left:7px;display:inline-block;'>Except P1/P2</p></div></td>
                                ";




                                  }
                                  else if($row["STATE"]=="Unavailable"){
                                    $reason=$row["REASON"];
                                     echo "
                                  <td><div style='display:inline-block;' title='$reason'>
                                  <span style='color:crimson;text-shadow: 0 0 3px #FF0000;font-size:small;'>&#11044;</span>
                                  <p style='margin:0; margin-left:7px;display:inline-block;'>Unavailable</p></div></td>
                                ";



                                  }
                                $w=$row["EA"]+($row["P1P2"]*6)+($row["P3P4"]*3);
                                echo "<td>".$w."</td></tr>";

                            }
                            echo "
                            <tr style='border-top:2px solid #000;'>
                              <td style='font-weight:bolder;'>Total</td>
                              <td id='autocount'>$easum</td>
                              <td id='mp1count'>$p1sum</td>
                              <td id='mp3count'>$p3sum</td>
                              <td style='font-weight:bolder;'>=&nbsp; $all <span id='allcount'></span></td>
                              <td></td>
                            </tr>
                              </tbody> </table>
                            </li>
                            </ul>


                        </div>";
    //echo $value;
}

if(isset($_POST["menu_group2"])){

  session_start();
  if(isset($_SESSION["eng"]))
  {
    $engid=$_SESSION["eng"];
    echo "session name=".$engid;
    //update the clicked time in db
    $sql="update engineer set Time_Added='".date("Y-m-d H:i:s")."' where CEC = '$engid';";
    echo $sql;
    $res=$conn->query($sql);
    echo $res;


  }
  else
  {
    die("session has expired. Please logout and login again!");
  }
  $shift=$_POST['shift'];
  echo "shift is".$shift;
  echo $engid;
  if($_POST["menu_group2"]==1){

    $sql="UPDATE ENGINEER SET STATE='Available', REASON='' WHERE CEC='".$engid."';";
    if($conn->query($sql)){
      echo "Success";
    }
    else
    {
      echo "unsuccessful";
      echo $sql;
    }
  }
  else if($_POST["menu_group2"]==2){

    $sql="UPDATE ENGINEER SET STATE='Except Manual P1/P2', REASON='' WHERE CEC='".$engid."';";
    if($conn->query($sql)){
      echo "Success";
    }
    else
    {
      echo "unsuccessful";
    }


  }
  else if($_POST["menu_group2"]==3){
    $reason=$_POST["reason"];
    echo $reason;


    $sql="UPDATE ENGINEER SET STATE='Unavailable', REASON='$reason' WHERE CEC='".$engid."';";
    if($conn->query($sql)){
      echo "Success";
    }
    else
    {
      echo "unsuccessful";
    }

  }




}


if(isset($_GET["gethandoff"])){
  $pkid=$_GET["gethandoff"];
  $sqlget="SELECT * FROM HANDOFF WHERE PKID='$pkid' ORDER BY DT_SUBMIT DESC LIMIT 1";
  $resultget=$conn->query($sqlget);
  $data=mysqli_fetch_assoc($resultget);
  echo json_encode($data);



}

ob_end_flush();

?>
