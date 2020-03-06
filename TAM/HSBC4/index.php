
<?php
error_reporting(0);
ob_start();

if(isset($_SESSION['auth']))
{

echo "

<div style='text-align:center;margin-top:10px; padding-bottom:10px; border-bottom:2px solid crimson;'><span style='font-weight:bolder;'>Incorrect Password!</span> Try Again. Get in touch with the System Administrator in case you need to reset your password.</div>

";
session_destroy();

}
if(isset($_COOKIE["auth"])){
if($_COOKIE["auth"]=="failed"){
    echo "


<div style='text-align:center;margin-top:10px; padding-bottom:10px; border-bottom:2px solid crimson;'><span style='font-weight:bolder;'>You do not have access to the tool. Please contact the developers!</div>

";
    setcookie("auth","");
    $_COOKIE["auth"]="";
}
}


?>

<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <title>TAM Tool &middot; Cisco CMS</title>
        <!-- <meta name="description" content="Quality Management Tool">
  <meta name="author" content="Cisco CMS"> -->

        <meta name="viewport" content="width=device-width, initial-scale=1">


        <link rel="stylesheet" href="css/normalize.css">
        <link rel="stylesheet" href="css/skeleton.css">


        <link rel="icon" type="image/png" href="favicon.png">

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
                width: 180px;
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
            /*BLAH*/

            .svg-wrapper {
                height: 60px;
                margin: 0 auto;
                position: relative;
                top: 50%;
                transform: translateY(-50%);
                width: 320px;
                margin-bottom: 30px;
                margin-top: 30px;
            }

            .shape {
                fill: transparent;
                stroke-dasharray: 140 540;
                stroke-dashoffset: -474;
                stroke-width: 8px;
                stroke: #049fd9;
            }

            .text {
                /*letter-spacing: 8px;
                line-height: 32px;*/
                position: relative;
                top: -48px;
                text-transform: uppercase;
                font-size: 1.6rem;
            }

            @keyframes draw {
                0% {
                    stroke-dasharray: 140 540;
                    stroke-dashoffset: -474;
                    stroke-width: 8px;
                }
                100% {
                    stroke-dasharray: 760;
                    stroke-dashoffset: 0;
                    stroke-width: 2px;
                }
            }

            .svg-wrapper:hover .shape {
                -webkit-animation: 0.5s draw linear forwards;
                animation: 0.5s draw linear forwards;
            }

        </style>

<div class="container u-max-full-width">
<div class="row" style="margin-top: 5%;text-align:center;">
                <div class="twelve columns">
                    <!-- <img class="img-responsive" src="images/cisco.png "> -->



                    <a href="index.php"><svg class="img-responsive logo" style="max-width: 185px;" x="0px" y="0px" width="200.1px" height="105.4px" viewBox="-305 291.9 200.1 105.4">
  <g class="logo__mark">
    <path d="M-296.2,324.6c0-2.4-2-4.3-4.4-4.3s-4.4,1.9-4.4,4.3v9.1c0,2.4,2,4.4,4.4,4.4s4.4-1.9,4.4-4.4V324.6z"/>
    <path transform="translate(97.7633,748.5409)" d="M-370.1-435.9c0-2.4-2-4.3-4.4-4.3c-2.4,0-4.4,1.9-4.4,4.3v21.1c0,2.4,2,4.3,4.4,4.3c2.4,0,4.4-1.9,4.4-4.3V-435.9z"/>
    <path transform="translate(106.3727,754.4384)" d="M-354.8-458.2c0-2.4-2-4.3-4.4-4.3s-4.4,1.9-4.4,4.3v46.1c0,2.4,2,4.4,4.4,4.4s4.4-1.9,4.4-4.4V-458.2z"/>
    <path transform="translate(114.9821,748.5409)" d="M-339.5-435.9c0-2.4-2-4.3-4.4-4.3c-2.4,0-4.4,1.9-4.4,4.3v21.1c0,2.4,2,4.3,4.4,4.3c2.4,0,4.4-1.9,4.4-4.3V-435.9z"/>
    <path transform="translate(123.5817,744.2304)" d="M-324.2-419.6c0-2.4-1.9-4.3-4.3-4.3c-2.4,0-4.4,1.9-4.4,4.3v9.1c0,2.4,2,4.4,4.4,4.4c2.4,0,4.3-1.9,4.3-4.4V-419.6z"/>
    <path transform="translate(132.195,748.5409)" d="M-308.9-435.9c0-2.4-1.9-4.3-4.3-4.3s-4.3,1.9-4.3,4.3v21.1c0,2.4,1.9,4.3,4.3,4.3s4.3-1.9,4.3-4.3 C-308.9-414.8-308.9-435.9-308.9-435.9z"/>
    <path transform="translate(140.8102,754.4384)" d="M-293.6-458.2c0-2.4-1.9-4.3-4.3-4.3s-4.3,1.9-4.3,4.3v46.1c0,2.4,1.9,4.4,4.3,4.4s4.3-1.9,4.3-4.4V-458.2z"/>
    <path transform="translate(149.4235,748.5409)" d="M-278.3-435.9c0-2.4-1.9-4.3-4.4-4.3c-2.4,0-4.3,1.9-4.3,4.3v21.1c0,2.4,1.9,4.3,4.3,4.3c2.5,0,4.4-1.9,4.4-4.3 C-278.3-414.8-278.3-435.9-278.3-435.9z"/>
    <path transform="translate(158.0192,744.2304)" d="M-263-419.6c0-2.4-1.9-4.3-4.3-4.3s-4.3,1.9-4.3,4.3v9.1c0,2.4,1.9,4.4,4.3,4.4s4.3-1.9,4.3-4.4V-419.6z"/>
  </g>
  <g class="logo__type">
    <path transform="translate(102.0426,727.2001)" d="M-362.5-355.3c-0.4-0.2-3.2-1.9-7.4-1.9c-5.7,0-9.6,3.9-9.6,9.3c0,5.2,3.8,9.3,9.6,9.3c4.1,0,7-1.6,7.4-1.8v9.3 c-1.1,0.3-4.1,1.2-8,1.2c-9.9,0-18.5-6.8-18.5-18c0-10.4,7.8-18,18.5-18c4.1,0,7.2,1,8,1.2V-355.3z"/>
    <path d="M-239.7,396.7h-8.8v-34.8h8.8V396.7z"/>
    <path transform="translate(121.5124,727.9413)" d="M-327.9-358.1c-0.1,0-3.8-1.1-6.9-1.1c-3.5,0-5.4,1.2-5.4,2.8c0,2.1,2.6,2.9,4,3.3l2.4,0.8c5.7,1.8,8.3,5.7,8.3,9.9 c0,8.7-7.7,11.7-14.4,11.7c-4.7,0-9-0.9-9.5-1v-8c0.8,0.2,4.4,1.3,8.3,1.3c4.4,0,6.4-1.3,6.4-3.2c0-1.8-1.7-2.8-3.9-3.5 c-0.5-0.2-1.3-0.4-1.9-0.6c-4.9-1.5-9-4.4-9-10.2c0-6.5,4.9-10.9,12.9-10.9c4.3,0,8.3,1,8.5,1.1v7.6H-327.9z"/>
    <path transform="translate(134.9958,727.2001)" d="M-303.9-355.3c-0.4-0.2-3.2-1.9-7.4-1.9c-5.7,0-9.6,3.9-9.6,9.3c0,5.2,3.8,9.3,9.6,9.3c4.1,0,7-1.6,7.4-1.8v9.3 c-1.1,0.3-4.1,1.2-8,1.2c-9.9,0-18.5-6.8-18.5-18c0-10.4,7.8-18,18.5-18c4.1,0,7.2,1,8,1.2V-355.3z"/>
    <path transform="translate(144.9274,727.8212)" d="M-286.3-357.7c-5.2,0-9.1,4.1-9.1,9.1c0,5.1,3.9,9.1,9.1,9.1s9.1-4.1,9.1-9.1S-281.1-357.7-286.3-357.7 M-267.9-348.5 c0,9.9-7.7,18-18.4,18s-18.4-8.1-18.4-18s7.7-18,18.4-18S-267.9-358.4-267.9-348.5"/>
  </g>
</svg></a>





                    <h4 style="font-weight:normal; margin-bottom: 0px;">Cisco Managed Services</h4>
                    <h5 style="font-weight:light;">Ticket Assignment &amp; Management Tool <span style='font-weight:bolder;'>v9.9</span></h5>
                </div>

            </div>
            <hr />

 <div class="row" style="margin-top: 2%;">
                <div class="six columns">
                    <h4>Login as QM Manager</h4>

                    <form method="POST" action="authenticate.php">


                        <div class="field half tb">
                            <label for="adCEC">QM CEC</label>
                            <input type="text" id="admin" name="qmcec" required/>
                        </div>
                        <div class="field half tb last">
                            <label for="pass">Password</label>
                            <input type="password" id="adpass" name="qmpass" required/>
                        </div>
                        <!-- <input type="radio"> -->
                        <input class="button-primary" type="submit" value="Login" name="qm" >
                    </form>
                </div>

                <div class="six columns">
                    <h4>Login as an Engineer</h4>
                    <form method="POST" action="authenticate.php">
                        <div class="field half tb">
                            <label for="name">Engineer CEC</label>
                            <input type="text" id="engID" name="engcec" required/>
                        </div>
                        <div class="field half tb last">
                            <label for="pass">Password</label>
                            <input type="password" id="engpass" name="engpass" required/>

                        </div>

                        <input class="button-primary" type="submit" value="Login" name="engineer">
                    </form>
                </div>
            </div>


            </div>

<footer style="width:100%;position:fixed;bottom:0px;text-align:center;">
<p style="color:#555; font-size:11px; font-weight:600;line-height: 38px;letter-spacing:.1rem;text-transform:uppercase;margin-bottom:0;">Works With <strong>Google Chrome</strong> Only. Zoom Out to 80% for best viewing experience.</p>
            <p style="color:#555; font-size:11px; font-weight:600;line-height: 38px;letter-spacing:.1rem;text-transform:uppercase;">2017 &middot; Cisco Managed Services &middot; <a target="_blank" href="about.html" class="button" style="margin:0;border:0;border-bottom:1px solid #333;padding:0;">About The Tool&nbsp; 👨‍💻</a></p>
            </footer>
     </body>
</html>

<?php

ob_end_flush();

?>

