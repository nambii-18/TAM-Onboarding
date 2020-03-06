<?php
ob_start();
session_start();
require('connect-hsbc.php');
date_default_timezone_set('Asia/Kolkata');
if(!isset($_SESSION["qm"])){
    header("Location: forbidden.html");
}
else{
$qmid=$_SESSION["qm"];
    $sqlshift="SELECT * FROM SHIFT";
$res=$conn->query($sqlshift);
$rowsh=mysqli_fetch_assoc($res);
$shift=$rowsh["SHIFT"];
    echo "

<html>
<head>
<title>Optimize Dashboard - TAM Tool &middot; Cisco CMS</title>


        <meta name='viewport' content='width=device-width, initial-scale=1'>


        <link rel='stylesheet' href='css/normalize.css'>
        <link rel='stylesheet' href='css/skeleton.css'>

    <script src='js/jquery-min.js'></script>
<link href='css/select2.min.css' rel='stylesheet'/>
    <script src='js/select2.min.js'></script>


        <link rel='shortcut icon' href='favicon.png'>

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
</head>
<body style=''>


        <script type='text/javascript'>
$(document).ready(function() {
  $('.js-basic-single1').select2({
  placeholder: 'Select a Customer'
});
});
    </script>


    <div class='container u-max-full-width'>
  <div class='row' style='padding-top:15px;'>
<!--
    <div class='five columns'>
      <div style='display:table; border:1px solid #333; background:#333; margin-top:10px;padding:15px;text-align: center;vertical-align: middle;'>
      <span style='font-size: 1.2rem;padding-right: 2rem; text-transform: uppercase;color: #fff;font-weight: bolder;letter-spacing: 1px;'>Next Handoff: </span><span style='color:#fff;'><a href='reassign.php' id='timehandoff' target='_blank' style='color:#fff; text-decoration: none; border-bottom: 1px solid #fff; font-weight:bolder;' title='Reassign all Handoff Cases'></a> ↗</span>
      </div>
    </div>
-->

    <div class='twelve columns' style='float:right;'>
    <div style='float:right;'>
      <span>Welcome, $qmid</span>
              <span>
                  <form method='POST' action='case.php' style='margin: 0; padding-left: 20px; display:inline-block;'>
                    <input type='submit' value='Logout &#x21b7;' name='logout' style='border: 0; border-bottom: 1px solid #212121;padding: 0;'/>
                  </form>
              </span>
              <span><a href='about.html' target='_blank' class='button' style='border: 0; border-bottom: 1px solid #212121;padding: 0;margin-left:40px;'>Developers</a></span>
              <span><a href='mailto:amasarda@cisco.com;%20svenkatt@cisco.com;%20gkotapal@cisco.com&cc=tdominic@cisco.com;%20sribabu@cisco.com?subject=QM%20Feedback%20on%20the%20TAM%20Tool' class='button' style='border: 0; border-bottom: 1px solid #212121;padding: 0;margin-left:40px;'>Give Feedback <span style='font-size:large;'>&#x263a;</span></a></span>
            </div>
  </div>
</div>

            <div class='row' style='margin-top: 1%;'>
                <div class='twelve columns bg-this'>
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
                    <h4 style='font-weight:normal; margin-bottom: 0px;text-align: right;'>Cisco Managed Services</h4>
                    <h5 style='font-weight:lighter;float:right;'>Server Time: ".gmdate('h:i')." UTC  <span style='font-style:italic;'>Shift: $shift </span></h5>
        </div>
      </div>
    </div>

    <div class='row'>

        <div class='six columns'>

        <h4 style='font-weight:bolder;margin-top:30px;'>Managed Voice - Optimize/Engineering: Assign a Case</h4>

        </div>

        <div class='six columns' style='float:right;'>
         <a href='optimize-cases.php' target='blank' class='button' style='float:right;margin-top: 30px;border: 0; border-bottom: 1px solid #212121; padding: 0; margin-right:15px;'>View Historical Optimize Cases</a>
        </div>

        </div>
        </div>



    <div class='container u-max-full-width'>
    <hr>
<form action='opinsert.php' method='POST' >

                <div class='half' style='margin-bottom:30px;'>
                            <label for='' style='font-size: 1.2rem;padding: 1.5rem 2rem 0;text-transform: uppercase;color: #999;font-weight: 700;letter-spacing: 1px;'>Select a Map/Customer</label>
                            <select class='js-basic-single1' id='customers' name='customer' style='border-radius:0px!important; width:30%;'>
                                ";



                                                    $sqlcust='SELECT * FROM CUSTOMER;';
                                                    $resultcust=mysqli_query($conn,$sqlcust);
                                                    $rowc=mysqli_fetch_assoc($resultcust);
                                                    if(mysqli_num_rows($resultcust)==1){
                                                        echo '<option value="'.$rowc['CUSTOMER'].'" selected>'.$rowc['CUSTOMER'].'</option> ';
                                                    }
                                                    else{
                                                    while($rowc=mysqli_fetch_assoc($resultcust)){
                                                      echo '<option value="'.$rowc['CUSTOMER'].'">'.$rowc['CUSTOMER'].'</option> ';
                                                   }
                                                    }
                                                    echo "
                            </select>
                </div>

                        <div class='field tb'>
                            <label for='name'>Case/Task Description</label>
                            <input type='text' id='' name='case' value='$case' required/>

                        </div>

                        <div class='field half tnb'>
                            <label for='qmID'>QM CEC ID</label>
                            <input required='required' type='text' id='eID' value='$qmid' name='qmcec'>
                        </div>
                        <div class='field half tnb last'>
                            <label for='datetime'>Date &amp; Time</label>
                            <input type='text' id='datetime' name='datesub' value='".date( 'Y-m-d H:i:s')."' required readonly/>

                        </div>






      <div class='modal-buttons'>
                                <input class='button-primary' type='submit' name='assign' value='Assign'>
                        <input class='button' type='button' value='Reload Page' onclick='window.location.reload();'>
      </div>
      </form>
      </div>
        </div>
      </body>
</html>
";
}
ob_end_flush();
?>
