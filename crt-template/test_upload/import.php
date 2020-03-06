<?php
require("../connect.php");
if(isset($_POST["Import"])){

$filename=$_FILES["file"]["tmp_name"];

if($_FILES["file"]["size"] > 0)
{

$file = fopen($filename, "r");
$i=0;
while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE)
{
    
if($i<>0){
$sql = "INSERT into hsbc_cognos_temp values('HSBC','$emapData[0]','$emapData[1]','$emapData[2]','$emapData[12]','$emapData[11]','$emapData[5]')";

//echo $sql;  

$result = mysqli_query($conn, $sql);
}
if(! $result )
{
echo "<script type=\"text/javascript\">
alert(\"Invalid File:Please Upload CSV File.\");
window.location = \"upload.php\"
</script>";
}
    $i++;
}
fclose($file);


echo "<script type=\"text/javascript\">
alert(\"CSV File has been successfully Imported.\");
window.location = \"upload.php\"
</script>";

mysqli_close($conn); 
}
} 
?> 