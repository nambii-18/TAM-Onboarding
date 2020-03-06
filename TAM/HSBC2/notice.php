<?php
ob_start();
require('connect-hsbc.php');
session_start();
if(isset($_SESSION["qm"]))
{
$qm_cec=$_SESSION["qm"];
}
else
{
  echo '
  <script>
  alert("Session timed out. Please login again!");
  window.location.href = "index.php";
  </script>
  ';
}


if(isset($_POST['notice']))
{

$content = $_POST['content'];
//echo $content;

//echo $_POST['date_added'];
$sql="INSERT INTO notice (`QM_CEC`, `MESSAGE`,`MESSAGE_READ`, `DATE_ADDED`) VALUES ('svenkatt','".trim(addslashes($content))."', '' ,'".$_POST["date_added"]."');";
$result=mysqli_query($conn,$sql);
$sqlinc="UPDATE C_ENG SET NOTICE_COUNT=NOTICE_COUNT+1;";
if(mysqli_query($conn,$sqlinc)){

}
else{
  echo "Error increamenting";
}
 if(!$result)
 {
  die("error in insertion!");
 }

echo "
 <div id='goutham' style='text-align:center;margin-top:10px; padding-bottom:10px; border-bottom:2px solid #8EC343;'>
          <div class='svg' style='display:inline-block;'>
            <svg xmlns='http://www.w3.org/2000/svg' width='26' height='26' viewBox='-263.5 236.5 26 26'>
              <g class='svg-success'>
                <circle cx='-250.5' cy='249.5' r='12'/>
                <path d='M-256.46 249.65l3.9 3.74 8.02-7.8'/>
              </g>
            </svg>
          </div>
            <span style='display:inline-block; vertical-align: super;margin-left: 10px;'>Notice Created!</span>
        </div>";

}





?>

<!DOCTYPE html>
<html lang='en'>

    <head>

        <meta charset='utf-8'>
        <title>Notices - TAM Tool &middot; Cisco CMS</title>
        <!-- <meta name='description' content='Quality Management Tool'>
  <meta name='author' content='Cisco CMS'> -->


        <meta name='viewport' content='width=device-width, initial-scale=1'>


        <link rel='stylesheet' href='css/normalize.css'>
        <link rel='stylesheet' href='css/skeleton.css'>

<link rel='icon' type='image/png' href='favicon.png'>

<style>

ul.tab-nav {
    list-style: none;
    border-bottom: 1px solid #bbb;
    padding-left: 5px;
}

ul.tab-nav li {
    display: inline;
}

ul.tab-nav li a.button {
    border-bottom-left-radius: 0;
    border-bottom-right-radius: 0;
    margin-bottom: -1px;
    border-bottom: none;
}

ul.tab-nav li a.active.button {
    border-bottom: 1px solid #fff;
}

.tab-content .tab-pane {
    display: none;
}

.tab-content .tab-pane.active {
    display: block;
}
</style>




</head>

<body>

<div class="container u-max-full-width">
<div class="row">
<div class="three columns">
<a href="javascript:;" class="button" style="display:inline-block;border: 0; border-bottom: 1px solid #212121; padding: 0;" onclick="window.close();">&#x2716; &nbsp; Close this tab</a>
</div>
<!--
<div class="nine columns" style="margin-top:10px; margin-bottom:1rem;float:right;">
<div style="float:right;"><img src="images/td1.png" style="max-width:70px;"><span style="float:right; vertical-align: middle;margin-top:30px;margin-left:5px;font-weight:bolder;">tdominic</span></div>
<div style="float:right;"><img src="images/ogi.png" style="max-width:70px;"><span style="float:right; vertical-align: middle;margin-top:30px;margin-left:5px;margin-right:40px;font-weight:bolder;">ojosipov</span></div>
<div style="float:right;"><img src="images/jo.png" style="max-width:70px;"><span style="float:right; vertical-align: middle;margin-top:30px;margin-left:5px;margin-right:40px;font-weight:bolder;">johagenb</span></div>
</div>
-->
</div>
    <div class="row">
      <div class="twelve columns" style="margin-top: 5%">

<ul class="tab-nav">
  <li>
  <a class="button active" id="tone" href="#one">Create New Notice</a>

  </li>
  <li>
    <a class="button" id="ttwo" href="#two">View &amp; Delete Notices</a>
  </li>
<!--   <li>
    <a class="button" href="#three">Tab 3</a>
  </li> -->
</ul>

<div class="tab-content">
  <div class="tab-pane active" id="one">

  <?php
  $dat=date("Y-m-d");
  echo '
  	<form action="notice.php" method="POST">


                        <div class="field tb">
                            <label for="content">Enter Notice Content</label>
                            <textarea style="resize:none;" placeholder="Please enter content for notice here. This will be displayed to all engineers." name="content"></textarea>
                            <input type="hidden" name="date_added" value="'.$dat.'" />

                        </div>

                        <button type="submit" class="button button-primary" name="notice">Submit</button>
                        <button type="button" class="button" onclick="window.location.reload(true);">Reload Page</button>


     </form>
     ';
     ob_end_flush();
     ?>


  </div>


  <div class="tab-pane" id="two">

  <?php


    if($conn->connect_error){
      die($conn->error);
    }

    $sql="select * from notice";
    $result=mysqli_query($conn,$sql);
     if(!$result)
     {
      die("error in insertion!");
     }
     else
     {
     while($row=mysqli_fetch_assoc($result))
     {
         // var_dump($row);
       $qm=$row['QM_CEC'];
       $cont=$row['MESSAGE'];
       $date=$row['DATE_ADDED'];
       $pk=$row['PKID'];
         echo '

          <div style="margin-bottom: 15px; padding: 0px 0px 0px 15px; border-left: 5px solid #1EAEDB;">

                    <h5 style="font-weight: normal;">'.stripslashes($cont).'</h5>

                    <span style="display: block; font-size: 1.2rem;  padding: 0 1rem 0 0; text-transform: uppercase; color: #999; font-weight: 700;letter-spacing: 1px;">'.$date.' &nbsp; ｜ &nbsp; &nbsp;
                    <a href="javascript:;" class="button" style="margin-top:-1px;border:0; padding:0;display:inline-block;font-size: 11px;font-weight: 600;line-height: 38px;" onclick="goaway(this);">❌&nbsp; Delete Notice &nbsp;</a><input type="hidden" value="'.$pk.'"> &nbsp; &nbsp;<span style="display:inline-block;text-transform: lowercase;font-weight:normal;">

                  </div>
      ';
      }
    }

   ?>

  </div>
  <!-- <div class="tab-pane" id="three">...</div> -->
</div>

</div>
    </div>
  </div>

  <script src='js/jquery-min.js'></script>

<script type='text/javascript'>

$(function() {
    $('ul.tab-nav li a.button').click(function() {
        var href = $(this).attr('href');
        console.log("ji"+$(this).attr('id'));
        if(!($(this).attr('id')=='tone'))
        {
        $("#goutham").hide();
        }

        $('li a.active.button', $(this).parent().parent()).removeClass('active');
        $(this).addClass('active');

        $('.tab-pane.active', $(href).parent()).removeClass('active');
        $(href).addClass('active');

        return false;
    });
});
</script>

<script type="text/javascript">



	function goaway(element){
		console.log(element);
		$(element).closest("div").slideUp("slow").fadeOut("slow").hide("slow");
    //$(element).closest("h5").html();
    // var lalala = $(element).closest("span").prev("h5").text();
    var lalala = $(element).closest("div").find("input").val();
    console.log(lalala);

    $.ajax({
                type: "POST",
                url: "delete.php",
                data: {"content":lalala},
                 success: function (data) {
                    console.log(data);
                }
            });

	};
</script>

</body>
</html>
