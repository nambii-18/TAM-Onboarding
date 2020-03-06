<?php
error_reporting(0);

ob_start();
$mysqlserver="localhost";
$mysqlusername="root";
$mysqlpassword="krithu";
$link=mysqli_connect('localhost', $mysqlusername, $mysqlpassword, 'qmtester') or die ("Error connecting to mysql server: ".mysqli_error($link));

$dbname = 'qmtester';


//$cdquery="SELECT avg(DIFF_MIN) as S FROM cases ORDER BY ENG_CEC ";
//$cdquery1="SELECT DT_ACCEPT as R FROM c_eng where (EA_COUNT+P3P4_COUNT+P1P2_COUNT)<>0 order BY CEC ";
$cdquery2a="SELECT ENG_CEC FROM cases order BY ENG_CEC";
//$cdresult=mysqli_query($link,$cdquery) or die ("Query to get data from review failed: ".mysqli_error($link));
//$cdresult1=mysqli_query($link,$cdquery1) or die ("Query to get data from review failed: ".mysqli_error($link));
$cdresult2a=mysqli_query($link,$cdquery2a) or die ("Query to get data from review failed: ".mysqli_error($link));


$ceca=array();

$tota=array();
$una=array();
/*while ($cdrow=mysqli_fetch_assoc($cdresult)) {
  array_push($tot,$cdrow["S"]);

}*/

while ($cdrow=mysqli_fetch_assoc($cdresult2a)) {
  array_push($ceca,$cdrow["ENG_CEC"]);
}
/*
while ($cdrow=mysqli_fetch_assoc($cdresult1)) {
 array_push($una,$cdrow["R"]); }
$pu=array();
for($i=0;$i<sizeof($una);$i++) {
$pu[$i]=$una[$i]/$tot[$i];
}*/
$result = array_unique($ceca);
foreach ($result as $k => $v) {
    echo " $v.\n";
    $cdquerya="SELECT avg(DIFF_MIN) as S FROM cases where ENG_CEC='".$v."' ORDER BY ENG_CEC ";
    $cdresulta=mysqli_query($link,$cdquerya) or die ("Query to get data from review failed: ".mysqli_error($link));
    while ($cdrow=mysqli_fetch_assoc($cdresulta)) {
 		 array_push($tota,$cdrow["S"]);

}

}
echo '
<script src="js/jquery-min.js"></script>
    <script src="js/jquery.notify-better.min.js"></script>

';
ob_end_flush();
?>
<script type="text/javascript">

  //old code
  var unava=[];
  var unava = new Array(<?php echo implode(',', $tota); ?>);
  var xa=[];

   var xa = <?php echo json_encode($ceca); ?>;
   var unique = xa.filter(function(elem, index, self) {
    return index == self.indexOf(elem);
})
   console.log(unique);//enginner names inside x
   console.log(unava);



</script>
