<?php
ob_start();
require('connect-hsbc.php');
session_start();
if(!isset($_SESSION["eng"])){
    header("Location: forbidden.html");
}
$engcec=$_SESSION["eng"];


    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    } else {
    }
  $engcec=$_SESSION["eng"];
date_default_timezone_set('Asia/Kolkata');
//var_dump($_POST);
$shift="";
$sqlshift="SELECT * FROM SHIFT";
$res=$conn->query($sqlshift);
$rowsh=mysqli_fetch_assoc($res);
$shift=$rowsh["SHIFT"];

$sqleng="SELECT * FROM Engineer";
$result=mysqli_query($conn1,$sqleng);
$engarr=array();
while($row=mysqli_fetch_assoc($result)){
  array_push($engarr,$row["CEC"]);
}
$sqleng="SELECT * FROM Engineer where cec = '$engcec'";
$result=mysqli_query($conn1,$sqleng);
$row=mysqli_fetch_assoc($result);
$gdc=$row["GDC"];

if(isset($_POST["backlog"])){
    $customer=$_POST["customer"];
    $reviewer="tdominic";
    $towner=$_POST["towner"];
    $tnum=$_POST["tnum"];
    $createdate=$_POST["createdate"];
    //$reviewdate=$_POST["reviewdate"];
    $gdc=$_POST["gdc"];
    $priority=$_POST["priority"];
    $shift=$rowsh["SHIFT"];
    $reason=$_POST["reason"];
    if(isset($_POST["status"])){
        $status="Open";
    }
    else{
        $status="Closed";
    }
    $sqlpk="SELECT MAX(PKID) as PKID FROM BACKLOG";
    $resultpk=$conn2->query($sqlpk);
    $row=mysqli_fetch_assoc($resultpk);
    $pkid=$row["PKID"]+1;
    $sqlinsert="INSERT INTO BACKLOG VALUES ($pkid,'$customer',$tnum,'$status',$priority,'$createdate','$towner','$gdc','$reviewer','$reason');";
    mysqli_query($conn2,$sqlinsert);

}
echo "<!DOCTYPE html>
<html lang='en'>

    <head>


        <meta charset='utf-8'>
        <title>Submit a Case for Review - TAM Tool &middot; Cisco CMS</title>
        <!-- <meta name='description' content='Quality Management Tool'>
  <meta name='author' content='Cisco CMS'> -->


        <meta name='viewport' content='width=device-width, initial-scale=1'>


        <link rel='stylesheet' href='css/normalize.css'>
        <link rel='stylesheet' href='css/skeleton.css'>

        <script src='js/jquery-min.js'></script>
        <script type='text/javascript' src='js/autocomplete.js'></script>

        <!--link type='text/css' rel='stylesheet' href='css/.css'/-->

        <link rel='icon' type='image/png' href='favicon.png'>

    </head>


    <body>

            <style>

            .autocomplete-suggestions { border: 1px solid #999; background: #FFF; overflow: auto; }
.autocomplete-suggestion { padding: 2px 5px; white-space: nowrap; overflow: hidden; }
.autocomplete-selected { background: #F0F0F0; }
.autocomplete-suggestions strong { font-weight: normal; color: #3399FF; }
.autocomplete-group { padding: 2px 5px; }
.autocomplete-group strong { display: block; border-bottom: 1px solid #000; }


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

            .switch {
  position: relative;
  display: block;
  width: 60px;
  height: 34px;
  float:left;
  margin-bottom:40px;
}

.switch input {display:none;}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: '';
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
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

                </div>
                </div>


                        <div class='row' style='margin-top:2%'>
        <h4 style='font-weight:bold;display:inline-block;'>Submit a Case for Review</h4>
        <!-- <span style='float:right;margin-top: 9px;margin-right: 20px;'>Mean Score (out of 2): <span id='shovehere' style='font-weight:bolder;'>0</span></span> -->
        <!-- <p style='margin-bottom:0; border-left: goldenrod 5px solid; padding-left: 15px;'>Please be aware that this review will be shared with the Engineer and their Ops Manager.</p> -->

        </div>
        <hr style='margin-top:0;'>

<form method='POST' action='review.php'>

         <div id='chepura' class='row u-max-full-width' style='display:inline-block;'>
                        <h5 style='display: block;'>
                        <span id='chesta'>Submit a <span style='font-weight:normal'>closed</span> case for review.</span>
                        <label class='switch' style='margin-right: 25px; margin-top: 3px;'>

                          <input id='checkpaninga' name='status' type='checkbox'>
                          <div class='slider round'></div>

                        </label>

                        </h5>



          </div>

    <div class='field tb'>
    <label for=''>Reason for Requesting a Review</label>
    <input type='text' name='reason' required>
    </div>
                        <div class='field half tnb'>
                        <label for='name'>Customer</label>
                            <!-- <input required='required' type='text' id='' name='customer' > -->
                            <select class='js-basic-single1' id='' name='customer' style='border:0; margin-left:15px; margin-top: 7px;margin-bottom: 20px;border-radius:0px!important;' required>
                                                    <Option value=''>Select a Customer</option>
";
                                                   $sqlcust="SELECT * FROM CUSTOMER;";
                                                    $resultcust=mysqli_query($conn,$sqlcust);
                                                    if(mysqli_num_rows($resultcust)==1){
                                                        echo "<option value='".$rowc["CUSTOMER"]."' selected>".$rowc["CUSTOMER"]."</option> ";
                                                    }
                                                    else{
                                                    while($rowc=mysqli_fetch_assoc($resultcust)){
                                                      echo "<option value='".$rowc["CUSTOMER"]."'>".$rowc["CUSTOMER"]."</option> ";
                                                   }
                                                    }
                                                    echo "


                                                  </select>
                        </div>

                        <div class='field half tnb last'>
                            <label for='name'>Ticket Owner</label>
                            <input required='required' type='text' id='tickowner' name='towner' onblur='checkGDC();' value='$engcec'>
                            <!-- To be Autofilled for a user's session -->
                        </div>
                        <div class='field half tnb'>
                            <label for='name'>Ticket Number</label>
                            <input required='required' type='text' id='' name='tnum' >
                            <!-- To be Autofilled for a user's session -->
                        </div>
                        <div class='field half tnb last'>
                        <label for='name'>Ticket Create Date</label>
                            <input required='required' type='date' id='' name='createdate' style='padding-bottom: 2px;'>
                        </div>

                        <div class='field half tnb'>
                        <label for='name'>Global Delivery Center</label>
                            <!--input required='required' type='text' id='gdc' name='gdc' value='$gdc' -->
                            <select class='js-basic-single1' id='gdc' name='gdc' value='$gdc' style='border:0; margin-left:15px; margin-top: 7px;margin-bottom: 20px;border-radius:0px!important;' required>
                                                    <Option value=''>Select GDC</option>
<Option value='Bangalore'>Bangalore</option>
<Option value='RTP'>RTP</option>
<Option value='Krakow'>Krakow</option>
<Option value='Noida'>Noida</option>
</select>

                    </div>
                        <div class='field half tnb last'>
                        <label for='name'>Ticket Priority</label>
                            <!-- <input required='required' type='text' id='' name='priority'> -->
                            <select class='js-basic-single1' id='' name='priority' style='border:0; margin-left:15px; margin-top: 7px;margin-bottom: 20px;border-radius:0px!important;' required>
                                                    <Option value=''>Select Priority</option>
<Option value='1'>1</option>
<Option value='2'>2</option>
<Option value='3'>3</option>
<Option value='4'>4</option>
</select>
                        </div>

                        <div>
                        <input type='submit' class='button' style='margin-top:30px;color:#fff; background-color: #33C3F0;border-color: #33C3F0;' value='Submit' name='backlog'>

                        <input class='button' type='button' value='Reload Page' onclick='window.location.reload();'>
                        </div>

        </form>
        </div>

         </body>
 </html>
";
ob_end_flush();
?>


<script>
function checkGDC() {
  var tickowner = $("#tickowner").val();
  console.log(tickowner);

  $.ajax({
    type: "GET",
    url: "test.php?enggdc=1&eng="+tickowner,
    success: function(data) {
      $("#gdc").val(data);
      console.log(data);
    }
  });
}
</script>

<script>


    var obj = <?php echo json_encode($engarr); ?>;
    // console.log(obj);


// var test = [ {"html": "<span style='color:green;text-shadow: 0 0 3px green;font-size:small;'>&#11044;</span>", "name": "svenkatt"}, {"html": "<span style='color:green;text-shadow: 0 0 3px crimson;font-size:small;'>&#11044;</span>", "name": "gkotapal"} ];

// var parseddata = JSON.parse(test);
// console.log(obj);

$("#tickowner").autocomplete({
  // serviceUrl: 'test.php',
    lookup: obj
    // lookup: test
    // onSelect: function (suggestion) {
    //     console.log('You selected: ' + suggestion.value + ', ' + suggestion.data);
    // }
});

</script>

        <script>

        $('#checkpaninga').click(function() {
  if ($(this).is(':checked')) {
    $('#chesta').html('Submit an <span style=\'font-weight:normal\'>open</span> case for review');
  } else {
    $('#chesta').html('Submit a <span style=\'font-weight:normal\'>closed</span> case');
  }
});
        </script>
