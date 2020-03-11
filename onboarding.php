<?php
    echo "        
        <form action='' enctype='multipart/form-data' method='post'> 
            <input type='text' name='dirname' placeholder='Enter one word teamname here : '>
            <input type='file' name='xls' value='Upload file'><br><br>
            <input type='checkbox' value='crt' name='crt'> Insert to CRT?<br><br>
            <input type='submit' value='Onboard' name='submit'>
        </form>

    ";

    if(isset($_POST['submit'])){
        $target_dir = "/app//upload/";
        $target_file = $target_dir . 'OnboardExcel.'.pathinfo($_FILES["xls"]["name"],PATHINFO_EXTENSION);
        $uploadOk = 1;
        move_uploaded_file($_FILES["xls"]["tmp_name"],$target_file) or die ("Failure to upload content");
        // $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        // Check if image file is a actual image or fake image
        if(isset($_POST['crt']) && $_POST['crt'] == 'crt'){
            $my_command = escapeshellcmd('python3 /app/script.py '.$_POST['dirname'].' crt');

        }
        else{
            $my_command = escapeshellcmd('python3 /app/script.py '.$_POST['dirname']);
        }
        $command_output = shell_exec($my_command);
        // echo "<script>console.log('".$_FILES['xls']."');</script>";
        echo "Customer has been onboarded";
        // print_r($_FILES);
        unset($_POST);
    }
 ?>