<?php
ob_start();
session_start();
$mcec=$_SESSION["manager"];

require("connect.php");



//$my_file = '/var/lib/mysql-files/new.csv';
//$handle = fopen($my_file, 'w');


$sql="SELECT *
INTO OUTFILE '/var/lib/mysql-files/newindia.csv'
FIELDS TERMINATED BY ','
ENCLOSED BY '\"'
LINES TERMINATED BY '\n'
FROM review2;";

if(mysqli_query($conn,$sql)){
  //echo "success";
 copy("/var/lib/mysql-files/newindia.csv","/var/www/html/report.csv");
unlink("/var/lib/mysql-files/newindia.csv");
//exec('cp /var/lib/mysql-files/new.csv  /var/www/html/report.csv');
}
else{
  echo $conn->error;
}


echo "

<!DOCTYPE html>
<html lang='en'>

    <head>

        <meta charset='utf-8'>
        <title>Statistics - CRT &middot; Cisco CMS</title>
        <!-- <meta name='description' content='Quality Management Tool'>
  <meta name='author' content='Cisco CMS'> -->


        <meta name='viewport' content='width=device-width, initial-scale=1'>


        <link rel='stylesheet' href='css/normalize.css'>
        <link rel='stylesheet' href='css/skeleton.css'>
        <!-- <link rel='stylesheet' href='css/fullpage.css'> -->

    <script src='js/jquery-min.js'></script>
        <!-- <script src='js/jquery.fullPage.min.js'></script> -->

    <!-- <link href='css/select2.min.css' rel='stylesheet'/>
    <script src='js/select2.min.js'></script> -->


        <link rel='icon' type='image/png' href='favicon.png'>

</head>


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
             if(mysqli_num_rows(mysqli_query($conn,"SELECT * FROM REVIEWERS WHERE CEC ='".$mcec."';"))>0 || mysqli_num_rows(mysqli_query($conn,"SELECT * FROM MANAGER WHERE manager ='".$mcec."';"))>0){
              echo "<span><a href='upload.php' target='_blank' class='button' style='border: 0; border-bottom: 1px solid #212121;padding: 0;margin-left:20px;'>Upload Cases For Review</a></span>";

              }
              echo "

              <span><a href='mailto:cms-crt@cisco.com?subject=Feedback%20on%20the%20CRT%20Tool' class='button' style='border: 0; border-bottom: 1px solid #212121;padding: 0;margin-left:20px;'>Give Feedback <span style='font-size:large;'>&#x263a;</span></a></span>

          </div>
        </div>
      </div>
      </div>

      <div class='container u-max-full-width'>
            <div class='row' style='margin-top:1%;z-index:99999;'>
                <div class='twelve columns bg-this'>
                    <a href='statistics.php'><svg class='img-responsive logo' style='max-width: 185px;width:120px;' x='0px' y='0px' width='200.1px' height='105.4px' viewBox='-305 291.9 200.1 105.4'>
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

<div class='row' style='margin-top:1%;'>
                <div class='eight columns'>

                    <h4 style='display: inline-block; font-weight:bolder;'>Pending Backlogs</h4>

                    </div>
                    <div class='four columns' style='float:right'>
                    	<a href='http://cmstools.cisco.com/report.csv' class='button' style='display: inline-block;float:right;margin-top: 3px;margin-bottom: 0;'>Export DB to *.CSV</a>
                    </div>

</div>
<hr>

<div class='row'>

<table class='u-full-width'>
<thead>
<tr>
<th>Reviewer CEC</th>
<th># of Pending Backlogs</th>
<th># of Reviewed Cases</th>

</tr>
</thead>
<tbody>
";
$b=array();
$r=array();
$sqlr="SELECT CEC FROM REVIEWERS ;";
$result=mysqli_query($conn,$sqlr);
  while($row=mysqli_fetch_assoc($result)){
    $b[$row["CEC"]]=0;
    $r[$row["CEC"]]=0;
  }
  $sqlr="SELECT CEC FROM REVIEWERS2 ;";
$result=mysqli_query($conn,$sqlr);
  while($row=mysqli_fetch_assoc($result)){
    $b[$row["CEC"]]=0;
    $r[$row["CEC"]]=0;
  }
  $sum1=0;
  $sum2=0;

//var_dump($b);
$sqleng="SELECT REVIEWER,COUNT(PKID) AS NUM FROM BACKLOG GROUP BY REVIEWER ;";
$result=mysqli_query($conn,$sqleng);
  while($row=mysqli_fetch_assoc($result)){
    $b[$row['REVIEWER']]=(int)$row['NUM'];
  }
$sqleng="SELECT REVIEWER,COUNT(REVIEWER) AS NUM FROM review2 GROUP BY REVIEWER ;";
$result=mysqli_query($conn,$sqleng);
  while($row=mysqli_fetch_assoc($result)){
    $r[$row['REVIEWER']]=(int)$row['NUM'];
  }
  //var_dump($b);
  //var_dump($r);  //$b[]
  foreach ($b as $key => $value){
    $sum1=$sum1+$value;
    $sum2=$sum2+$r[$key];

echo "
<tr>
<td>".$key."</td>
<td>".$value."</td>
<td>".$r[$key]."</td>
</tr>
";
}
echo "<td style='font-weight:bolder;'>Grand Total</td>
<td style='font-weight:bolder;'>$sum1</td>
<td style='font-weight:bolder;'>$sum2</td>";
echo "

</tbody>
</table>
</div>

     </div>



";

ob_end_flush();
?>
