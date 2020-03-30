<?php
    echo "        
        <form action='' enctype='multipart/form-data' method='post'> 
            <input type='text' name='dirname' placeholder='Enter one word teamname here : '>
            <input type='file' name='xls' value='Upload file'><br><br>
            <input type='checkbox' value='crt' name='crt'> Insert to CRT?<br><br>
            <input type='submit' value='Onboard' name='submit'>
        </form>

        <a href='http://localhost:9000/Onboarding%20Requirements%20-%20CMS%20Tools%20&%20Automation%20Suite%20Template.xlsx'>Download the template from here</a>

        <br>

    ";


    if(isset($_POST['submit'])){
        $target_dir = "/app//upload/";
        $target_file = $target_dir . 'OnboardExcel.'.pathinfo($_FILES["xls"]["name"],PATHINFO_EXTENSION);
        
        //Checking if file is an xlsx file
        if(pathinfo($_FILES["xls"]["name"],PATHINFO_EXTENSION) !== 'xlsx'){
            die('Invalid filetype');
        }
        
        //Checking if filesize is less than 2MB
        if ($_FILES['upfile']['size'] > 2000000) {
            die('Exceeded filesize limit.');
        }
        if (strpos($_POST['dirname'], ';') !== false) {
            die('Invalid teamname');
        }
        move_uploaded_file($_FILES["xls"]["tmp_name"],$target_file) or die ("Failure to upload content");
        $test_command = escapeshellcmd('python3 /app/test_file.py');
        $test_output = shell_exec($test_command);
        
        if($test_output) {
            echo "<pre>";
        echo $test_output;
        echo "</pre>";
        die();
        }
        else {
            echo "All good";
        }
        
        // If needed to add in CRT, pass that argument to the Python script
        if(isset($_POST['crt']) && $_POST['crt'] == 'crt'){
            $my_command = escapeshellcmd('python3 /app/script.py '.$_POST['dirname'].' crt');
        }
        else{
            $my_command = escapeshellcmd('python3 /app/script.py '.$_POST['dirname']);
        }

        $command_output = shell_exec($my_command);
        echo "Customer has been onboarded";
        unset($_POST);
    }

    ?>