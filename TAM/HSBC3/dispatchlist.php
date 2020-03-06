<?php
ob_start();
//var_dump($_POST);
require('connect-hsbc.php');
session_start();
if(!isset($_SESSION["qm"]) && !isset($_SESSION["eng"])){
  header("Location:forbidden.html");
}

else{

    $sqlshift="SELECT * FROM shift";
$res=$conn->query($sqlshift);
$rowsh=mysqli_fetch_assoc($res);
$shift=$rowsh["SHIFT"];
    $qmcec="";
    $eng="";
     if(isset($_SESSION["qm"])){
         $qmcec=$_SESSION["qm"];
     }

     if(isset($_SESSION["eng"])){
         $eng=$_SESSION["eng"];
     }
    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
	else {
    if(isset($_POST["reject"])){
            $pk=$_POST["pk"];
            $sql="DELETE FROM dispatch WHERE PKID=$pk; ";
            if($conn->query($sql)){
            echo "<div style='text-align:center;margin-top:10px; padding-bottom:10px; border-bottom:2px solid #8EC343;'>
          <div class='svg' style='display:inline-block;'>
            <svg xmlns='http://www.w3.org/2000/svg' width='26' height='26' viewBox='-263.5 236.5 26 26'>
              <g class='svg-success'>
                <circle cx='-250.5' cy='249.5' r='12'/>
                <path d='M-256.46 249.65l3.9 3.74 8.02-7.8'/>
              </g>
            </svg>
          </div>
            <span style='display:inline-block; vertical-align: super;margin-left: 10px;'>Case Deleted!</span>
        </div>";
        }
        }
		date_default_timezone_set('Asia/Kolkata');

		$dispatchdata = "SELECT * FROM dispatch ORDER BY PKID DESC";
		$res=$conn->query($dispatchdata);


		echo "
		<!DOCTYPE html>
<html lang='en'>

    <head>


        <meta charset='utf-8'>
        <title>View Dispatched Cases - TAM Tool &middot; Cisco CMS</title>
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
          <span><a href='about.html' target='_blank' class='button' style='float:right;border: 0; border-bottom: 1px solid #212121;padding: 0;margin-left:40px; margin-top: 23px;'>Developers &nbsp;  👨‍💻</a></span>
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
                    <h5 style='font-weight:lighter;float:right;'>Server Time: ".gmdate('h:i')." UTC <span style='font-style:italic;'>Shift:".$shift." </span></h5>

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
                <div class='seven columns'>
                    <h4 style='display:inline-block;font-weight:bolder;'>Dispatched Cases</h4>
                    </div>
                    <div class='five columns'>
                    <!--input id='chepurasecond' style='display:inline-block;float:right;margin-left:15px;padding: 7px;border:0; border-bottom: 1px solid #1EAEDB; margin-top: 3px;' type='text' placeholder='Filter By 2nd Owner CEC'-->
                    <input id='chepurafirst' style='display:inline-block;float:right;margin-left:15px;padding: 7px;border:0; border-bottom: 1px solid #1EAEDB; margin-top: 3px;' type='text' placeholder='Filter By 1st Owner CEC'/>

                    </div>

                   </div>
                    <hr />

                    <table id='maintable' class='u-full-width'>
                        <thead>
                            <tr>
                                <th>PKID</th>
                                <th>Case #/Email Subject</th>
								<th>First Owner</th>
                                <!--th>Current Owner</th-->
                                <th>Customer</th>
								<th>Date of Submit</th>
                                <th>Dispatched to Shift</th>
								<th>Date of Dispatch</th>
                                <th>Delete Handoff</th>
                            </tr>
                       </thead>
						";

			while ($rowsh=mysqli_fetch_assoc($res))
			{
				$pkid=$rowsh["PKID"];
				$casenum=$rowsh["CASE_NUM"];
				$engcec=$rowsh["ENG_CEC"];
				$customer=$rowsh["CUSTOMER"];
				$dt_submit=$rowsh["DT_SUBMIT"];
				$shift=$rowsh["SHIFT"];
				$dt_dispatch=$rowsh["DT_DISPATCH"];
				echo "
				<tbody>
							<tr>
                                <td>$pkid</td>
                                <td>$casenum</td>
                                <td id='first_id'>$engcec</td>
                                <!-- td id='second_id'>amasarda</td -->
                                <td>$customer</td>
                                <td>$dt_submit</td>
                                <td>$shift</td>
								<td>$dt_dispatch</td>
                                ";
                if($engcec==$eng){
                    echo "<td><form action='dispatchlist.php' method='POST' style='margin: 0; padding: 0;'>
                                   <input class='button-primary removecolor open-modal' style='margin:20px 5px 1.5rem 0 !important;' type='submit' name='reject' value='Delete'>
                                   <input type='hidden' name='pk' value='$pkid'>
                                   </form>
                                   </td>";
                }
                else{
                    echo "<td><form action='dispatchlist.php' method='POST' style='margin: 0; padding: 0;'>
                                   <input class='button-primary open-modal' style='background-color:grey; border-color:grey' type='submit' name='reject' value='Delete' disabled>

                                   <input type='hidden' name='pk' value='$pkid'>
                                   </form>
                                   </td>";
                }
                                echo "
                            </tr>";
			}

			echo "
                        <tfoot class='row u-max-full-width'></tfoot>
                        </tbody>

                    </table>
                </div>
				</div>
            </div>
        </div>

    </body>

</html>
";

	}
}
ob_end_flush();
?>

<script type="text/javascript">
$("#chepurafirst").on("keyup", function() {
    var value = $(this).val();

    $("#maintable tr").each(function(index) {
        if (index !== 0) {

            $row = $(this);

            var id = $row.find("td#first_id").text();

            if (id.indexOf(value) !== 0) {
                $row.hide();
            }
            else {
                $row.show();
            }
        }
    });
});

//    $("#chepurasecond").on("keyup", function() {
//    var value = $(this).val();
//
//    $("#maintable tr").each(function(index) {
//        if (index !== 0) {
//
//            $row = $(this);
//
//            var id = $row.find("td#second_id").text();
//
//            if (id.indexOf(value) !== 0) {
//                $row.hide();
//            }
//            else {
//                $row.show();
//            }
//        }
//    });
//});
</script>
