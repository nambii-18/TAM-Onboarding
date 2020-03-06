<?php
ob_start();
require('connect-hsbc.php');
//var_dump($_POST);
session_start();
if(!isset($_SESSION["eng"]) && !isset($_SESSION["qm"])){
    header("Location: forbidden.html");
}
date_default_timezone_set('Asia/Kolkata');

if($conn->connect_error){
	die($connect->error);
}

// if(isset($_POST["accept"])){
// $sql="UPDATE CASES SET ACCEPT=1, DT_ACCEPT='".date( 'Y-m-d H:i:s')."' WHERE PKID=".$_POST["pk"].";";
// 	if($conn->query($sql)){
// 		echo "Success";
// 	}
// 	else{
// 		echo mysqli_error($conn);
// 	}
// }
//
// if(isset($_POST["reject"])){
// $sql="DELETE FROM CASES WHERE PKID=".$_POST["pk"].";";
// 	if($conn->query($sql)){
// 		echo "Success";
// 	}
// 	else{
// 		echo mysqli_error($conn);
// 	}
// }
$resultdis="";
$flag=0;
if(isset($_POST["page"])){
  $num=round($_POST["page"]);
  $up=$num*500;
  $low=($num-1)*500;
  $sqldis="SELECT * FROM cases WHERE PKID<=$up AND PKID>$low ORDER BY PKID DESC;";
  $resultdis=$conn->query($sqldis);
  // echo "$up $low";
}
else{
  if(isset($_POST["sub"])){
    $val=$_POST["s1"];
    $sqldis="SELECT * FROM cases WHERE CASE_NUM LIKE '%$val%' order by PKID desc;";
    $resultdis=$conn->query($sqldis);
    $flag=1;
  }
  else{
  $sqldis="SELECT * FROM cases ORDER BY DT_SUBMIT DESC LIMIT 500;";
  $resultdis=$conn->query($sqldis);
}
}

$shift= "";
$shift="";
$sqlshift="SELECT * FROM shift";
$res=$conn->query($sqlshift);
$rowsh=mysqli_fetch_assoc($res);
$shift=$rowsh["SHIFT"];
echo "
<!DOCTYPE html>
<html lang='en'>

    <head>


        <meta charset='utf-8'>
        <title>View Cases - TAM Tool &middot; Cisco CMS</title>
        <!-- <meta name='description' content='Quality Management Tool'>
  <meta name='author' content='Cisco CMS'> -->


        <meta name='viewport' content='width=device-width, initial-scale=1'>


        <link rel='stylesheet' href='css/normalize.css'>
        <link rel='stylesheet' href='css/skeleton.css'>

        <script src='js/jquery-min.js'></script>
        <script type='text/javascript' src='js/paging.js'></script>

        <!--link type='text/css' rel='stylesheet' href='css/.css'/-->

        <link rel='icon' type='image/png' href='favicon.png'>

    </head>


    <body>

	        <style>
            @-webkit-keyframes loading {
                25% {
                    fill: #c6c7ca;
                }
                50% {
                    fill: #049fd9;
                }
                75% {
                    fill: #c6c7ca;
                }
            }

            @keyframes loading {
                25% {
                    fill: #c6c7ca;
                }
                50% {
                    fill: #049fd9;
                }
                75% {
                    fill: #c6c7ca;
                }
            }

            .logo {
                width: 120px;
                fill: #c6c7ca;
            }

            .logo__mark>path {
                -webkit-animation: loading 1.25s ease-in-out infinite reverse;
                animation: loading 1.25s ease-in-out infinite reverse;
            }

            .logo__mark>path:nth-child(1) {
                -webkit-animation-delay: 0.1s;
                animation-delay: 0.1s;
            }

            .logo__mark>path:nth-child(2) {
                -webkit-animation-delay: 0.2s;
                animation-delay: 0.2s;
            }

            .logo__mark>path:nth-child(3) {
                -webkit-animation-delay: 0.3s;
                animation-delay: 0.3s;
            }

            .logo__mark>path:nth-child(4) {
                -webkit-animation-delay: 0.4s;
                animation-delay: 0.4s;
            }

            .logo__mark>path:nth-child(5) {
                -webkit-animation-delay: 0.5s;
                animation-delay: 0.5s;
            }

            .logo__mark>path:nth-child(6) {
                -webkit-animation-delay: 0.6s;
                animation-delay: 0.6s;
            }

            .logo__mark>path:nth-child(7) {
                -webkit-animation-delay: 0.7s;
                animation-delay: 0.7s;
            }

            .logo__mark>path:nth-child(8) {
                -webkit-animation-delay: 0.8s;
                animation-delay: 0.8s;
            }

            .logo__mark>path:nth-child(9) {
                -webkit-animation-delay: 0.9s;
                animation-delay: 0.9s;
            }

			</style>


        <div class='container u-max-full-width'>
        <div class='row'>
        <div class='four columns'>
          <a class='button' style='display:inline-block;border: 0; border-bottom: 1px solid #212121; padding: 0;' onclick='window.close();'>&#x2716; &nbsp; Close this tab</a>
          </div>
          <div class='eight columns' style='float:right;display:inline-block;'>
          <span><a href='about.html' target='_blank' class='button' style='float:right;border: 0; border-bottom: 1px solid #212121;padding: 0;margin-left:40px; margin-top: 23px;'>Developers &nbsp; 👨‍💻</a></span>
              <span><a href='mailto:amasarda@cisco.com;%20svenkatt@cisco.com;%20gkotapal@cisco.com&cc=tdominic@cisco.com;%20sribabu@cisco.com?subject=Feedback%20on%20the%20TAM%20Tool' class='button' style='border: 0; border-bottom: 1px solid #212121;float:right;padding: 0;margin-left:40px;'>Give Feedback <span style='font-size:large;'>&#x263a;</span></a></span>
          </div>
          </div>

            <div class='row' style='margin-top: 2%;'>
                <div class='twelve columns bg-this'>
                    <!-- img class='img-responsive' src='images/cisco.png ' -->

					<a href=''><svg class='img-responsive logo' style='max-width: 185px;' x='0px' y='0px' width='200.1px' height='105.4px' viewBox='-305 291.9 200.1 105.4'>
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

                     <h5 style='font-weight:lighter;float:right;'>Server Time: ".gmdate('h:i')." UTC  <span style='font-style:italic;'>Shift: ".$shift." </span></h5>
                </div>
					<p>
                        <form>
                            <!-- <div class='field half tb' style='width: 60%;'>
                                <label for='Search'>Search</label>
                                <input type='text' id='search' required style='padding: .5rem 2rem 0.1rem;' />
                            </div> -->
                            <!-- <input class='button' type='submit' value='Search'> -->
                        </form>
                        <!-- <hr /> -->
                        <div class='nav'>

                            <!-- <a href='case.html' style='padding-left:0px;'>Open a New Case</a> -->
                            <!-- <br /><br /> Server Time: <span id='servertime'></span> -->
                        </div>
                    </p>
                </div>
				</div>
				<div class='row'>
                <div class='twelve columns'>
                <div class='row'>
                <div class='two columns'>
                    <h4 style='display:inline-block;font-weight:bolder;'>View Cases</h4>
                    </div>
                    <div class='ten columns'>
                    <a href='#' id ='export' class='button' style='float:right;margin-top: 0;border: 0; border-bottom: 1px solid #212121; padding: 0; margin-left:30px;' role='button'>Export to CSV</a>
                    <form method='POST' action='caseview.php' style='margin:0;display:inline-block;float:right;'>

                    <!-- <select style='padding: 6px; margin-left: 10px; margin-top: 3px;'>
                        <option value='None'>None</option>
                        <option value='Shift A'>Shift A</option>
                        <option value='Shift B'>Shift B</option>
                        <option value='Shift C'>Shift C</option>


                    </select> -->
              <!--  <div style='display: inline-block; margin-top: 10px; margin-right: 40px;'>
                    <input type='checkbox' name='sa' value='A' style='margin-top: 5px;'/><span style='padding:0 20px 0 7px;'>Shift A</span>
                    <input type='checkbox' name='sb' value='B' style='margin-top: 5px;'/><span style='padding:0 20px 0 7px;'>Shift B</span>
                    <input type='checkbox' name='sc' value='C' style='margin-top: 5px;'/><span style='padding:0 20px 0 7px;'>Shift C</span>
                    <input type='checkbox' name='sd' value='D' style='margin-top: 5px;'/><span style='padding:0 20px 0 7px;'>Shift D</span>
                </div>-->

                            <!-- <div style='width: 28%;position:relative;display:inline-block;float:right;'>
                                <input id='chesta' name='s2' style='display:inline-block;float:right;margin-left:15px;padding: 8px;border:0; border-bottom: 1px solid #1EAEDB;margin-top:1px;' type='text' placeholder='Filter By QM CEC'/>
                                <button class='' type='submit' name='sub' value='&#x2794;' style='position:absolute;right:10px;padding:0;border:0;font-size:medium;bottom:4px;'>&#x2794;</button>
                            </div> -->



                            <div style='width: 20%;position:relative;display:inline-block;float:right;'>
                                <input id='chepura' name='s1' style='width: 210px;display:inline-block;float:right;margin-left:15px;padding: 8px;border:0; border-bottom: 1px solid #1EAEDB;margin-top:1px;' type='text' placeholder='Filter By Ticket Number'/>
                                <button class='' type='submit' name='sub' value='&#x2794;' style='position:absolute;right:10px;padding:0;border:0;font-size:medium;bottom:4px;'>&#x2794;</button>
                            </div>




                    </form>

</div>

                    <!-- <a href='#' id ='export' class='button' style='float:right;margin-top: 0;border: 0; border-bottom: 1px solid #212121; padding: 0; margin-right:30px;' role='button'>Export to CSV</a> -->
                   </div>
                    <hr />

                    <table id='maintable' class='u-full-width'>
                        <thead>
                            <tr>
                                <th>PKID</th>
                                <th>Case #/Email Subject</th>
                                <th>Customer</th>
                                <th>Case Type</th>
                                <th>QM CEC</th>
                                <th>Engineer CEC</th>
                                <th>Shift</th>
                                <th style='white-space:nowrap;'>Time of Submit</th>
                                <th style='white-space:nowrap;'>Time of Accept</th>
								<th style='white-space:nowrap;'>Time Taken to Accept</th>

                                  </tr>
                       </thead>
						";
                        $e='';$q='';

if(isset($_POST['sa']))
{
    $shifta='A';
}
else
$shifta='';
if(isset($_POST['sb']))
{
    $shiftb='B';
}
else
$shiftb='';
if(isset($_POST['sc']))
{
    $shiftc='C';
}
else
$shiftc='';
if(isset($_POST['sd']))
{
    $shiftd='D';
}
else
$shiftd='';
if(isset($_POST['s1']))
{
if($_POST['s1']=='')
{
    $e='%%';
}
else
$e=$_POST['s1'];
}
else
$e='%%';
if(isset($_POST['s1']))
{
if($_POST['s2']=='')
{
    $q='%%';
}
else
$q=$_POST['s2'];
}
else
$q='%%';
            //             if(isset($_POST['sa'])||isset($_POST['sb'])||isset($_POST['sc'])||isset($_POST['sd']))
            //                         {
						// $sql="SELECT * FROM CASES  where (SHIFT like '".$shifta."' or SHIFT like '".$shiftb."' or SHIFT like '".$shiftc."' or SHIFT like '".$shiftd."') and (ENG_CEC like '".$e."'"." and QM_CEC like '".$q."') ORDER BY DT_SUBMIT DESC LIMIT 500;";
            //             //echo $sql;
            //                 }
                            // else
                            // {
            //                    $sql="SELECT * FROM CASES ORDER BY DT_SUBMIT DESC LIMIT 500;";
            //                 //}
						// $result=mysqli_query($conn,$sql);
						// $num=mysqli_num_rows($result);
                       // var_dump($num);
                        //var_dump($_POST);
						while ($row=mysqli_fetch_assoc($resultdis)){


							$case=$row["CASE_NUM"];
							$engid=$row["ENG_CEC"];
							$pkid=$row["PKID"];
							$customer=$row["CUSTOMER"];
                            $qmcec=$row["QM_CEC"];
                            $date_sub=$row["DT_SUBMIT"];
                            $date_accept=$row["DT_ACCEPT"];
							$accept=$row["ACCEPT"];
							$diff=$row["DIFF_MIN"];
                            $type=$row["TYPE"];
                            $shift=$row["SHIFT"];
							$hours=(int)($diff/60);
							$mins=(int)($diff%60);
							$days=(int)($hours/24);




							echo "
							<tbody>
							<tr>
                                <td>$pkid</td>
                                <td>$case</td>
                                <td>$customer</td>
                                <td>$type</td>
                                <td id='qm_id'>$qmcec</td>
                                <td id='eng_id'>$engid</td>
                                <td>$shift</td>
                                <td>$date_sub</td>
                                <td>$date_accept</td>
								<td>$days days $hours:$mins</td>
                            </tr>
						";
                      }





						echo "
                        <tfoot class='row u-max-full-width'></tfoot>
                        </tbody>

                    </table>

                </div>
                ";
if($flag!==1){
        $sql="SELECT * FROM cases ORDER BY DT_SUBMIT DESC";
        $result=$conn->query($sql);
        $num=$result->num_rows;
        $pages=$num/500+1;
        $value=$pages;
        echo "<form method='POST' action='caseview.php' style='margin:0;display:inline-block;float:right;'>";
        for($i=1;$i<=$pages;$i++){
        echo "<button class='' type='submit' name='page' value='$value' style='position:relative;right:10px;padding:0;border:0;font-size:medium;bottom:4px;'>$i</button>";
        $value=$pages-$i;
        }
}
        echo"</form>

				</div>
            </div>
        </div>

    </body>

</html>
";
ob_end_flush();
?>
<script>
// $('#chepura').on('keyup', function() {
//     var value = $(this).val();

//     $('#maintable tr').each(function(index) {
//         if (index !== 0) {

//             $row = $(this);

//             var id = $row.find('td#eng_id').text();

//             if (id.indexOf(value) !== 0) {
//                 $row.hide();
//             }
//             else {
//                 $row.show();
//             }
//         }
//     });
// });

// $('#chesta').on('keyup', function() {
//     var value = $(this).val();

//     $('#maintable tr').each(function(index) {
//         if (index !== 0) {

//             $row = $(this);

//             var id = $row.find('td#qm_id').text();

//             if (id.indexOf(value) !== 0) {
//                 $row.hide();
//             }
//             else {
//                 $row.show();
//             }
//         }
//     });
// });
</script>

    <script type='text/javascript'>
        $(document).ready(function () {

            console.log("HELLO")
            function exportTableToCSV($table, filename) {
                var $headers = $table.find('tr:has(th)')
                    ,$rows = $table.find('tr:has(td)')

                    // Temporary delimiter characters unlikely to be typed by keyboard
                    // This is to avoid accidentally splitting the actual contents
                    ,tmpColDelim = String.fromCharCode(11) // vertical tab character
                    ,tmpRowDelim = String.fromCharCode(0) // null character

                    // actual delimiter characters for CSV format
                    ,colDelim = '","'
                    ,rowDelim = '"\r\n"';

                    // Grab text from table into CSV formatted string
                    var csv = '"';
                    csv += formatRows($headers.map(grabRow));
                    csv += rowDelim;
                    csv += formatRows($rows.map(grabRow)) + '"';

                    // Data URI
                    var csvData = 'data:application/csv;charset=utf-8,' + encodeURIComponent(csv);

                // For IE (tested 10+)
                if (window.navigator.msSaveOrOpenBlob) {
                    var blob = new Blob([decodeURIComponent(encodeURI(csv))], {
                        type: "text/csv;charset=utf-8;"
                    });
                    navigator.msSaveBlob(blob, filename);
                } else {
                    $(this)
                        .attr({
                            'download': filename
                            ,'href': csvData
                            //,'target' : '_blank' //if you want it to open in a new window
                    });
                }

                //------------------------------------------------------------
                // Helper Functions
                //------------------------------------------------------------
                // Format the output so it has the appropriate delimiters
                function formatRows(rows){
                    return rows.get().join(tmpRowDelim)
                        .split(tmpRowDelim).join(rowDelim)
                        .split(tmpColDelim).join(colDelim);
                }
                // Grab and format a row from the table
                function grabRow(i,row){

                    var $row = $(row);
                    //for some reason $cols = $row.find('td') || $row.find('th') won't work...
                    var $cols = $row.find('td');
                    if(!$cols.length) $cols = $row.find('th');

                    return $cols.map(grabCol)
                                .get().join(tmpColDelim);
                }
                // Grab and format a column from the table
                function grabCol(j,col){
                    var $col = $(col),
                        $text = $col.text();

                    return $text.replace('"', '""'); // escape double quotes

                }
            }


            // This must be a hyperlink
            $("#export").click(function (event) {
                // var outputFile = 'export'
                var outputFile = window.prompt("What do you want to name your output file (Note: This won't have any effect on Safari)") || 'export';
                outputFile = outputFile.replace('.csv','') + '.csv'

                // CSV
                exportTableToCSV.apply(this, [$('#maintable'), outputFile]);

                // IF CSV, don't do event.preventDefault() or return false
                // We actually need this to be a typical hyperlink
            });
        });
    </script>

        <script>

// $("#maintable").paginate({
//
//   // number of items per page
//   pageLength: 200,
//
//   // how many pages you want to cut off
//   nbPages: 0,
//
//   // table header selector
//   headerSelector: "thead",
//
//   // body selector
//   bodySelector: "tbody",
//
//   // table row selector
//   rowSelector: "tr",
//
//   // table footer selector
//   footerSelector: "tfoot",
//
//   // CSS class(es) for pagination buttons
//   paginationButtonsClass: "pagebutt",
//
//   // html tag for pagination buttons
//   paginationButtonsTagName: "button",
//
//   // CSS class(es) for pagination container
//   paginationButtonsContainerClass: "",
//
//   // content for previous button
//   previousButtonContent: "Prev",
//
//   // content for next button
//   nextButtonContent: "Next",
//
//   // // custom button id
//    previousButtonId: "prev",
//    nextButtonId: "next"
//
// });




    </script>
