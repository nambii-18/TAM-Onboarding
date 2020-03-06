<!DOCTYPE html>
<?php 
 require("../connect.php");
?> 
<html lang="en">
 <head>
  <meta charset="utf-8">
  <title>Upload Excel to PHP</title>
 </head>
 <body>    
    <form class="well" action="import.php" method="post" name="upload_excel" enctype="multipart/form-data">
    <h2>Import CSV/Excel file</h2>
    CSV/Excel File:   <input type="file" name="file" id="file">
    <button type="submit" id="submit" name="Import">Upload</button>
    </form>          
    
    <table border="1">
		<?php
			$SQLSELECT = "SELECT * FROM hsbc_cognos_temp ";
			$result_set = mysqli_query($conn,$SQLSELECT);
			while($row = mysqli_fetch_assoc($result_set))
			{
			?>
				<tr>
					<td><?php echo $row['Client_Name']; ?></td>
					<td><?php echo $row['Incident_ID']; ?></td>
					<td><?php echo $row['Assignee_First_Name']; ?></td>
					<td><?php echo $row['Assignee_Last_Name']; ?></td>
					<td><?php echo $row['Priority']; ?></td>
					<td><?php echo $row['Status']; ?></td>
					<td><?php echo $row['Last_Updated']; ?></td>
				</tr>
			<?php
			}
		?>
	</table>

 </body>
</html>