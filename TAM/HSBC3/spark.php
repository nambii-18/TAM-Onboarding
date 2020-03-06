<?php
//TAM BOT to out room - change to the HO room
error_reporting(0);
function sparkMessage($text,$room)
{
    $url = 'https://api.ciscospark.com/v1/messages';
//Initiate cURL.
    $ch = curl_init($url);

//The JSON data.
    $jsonData = array(
        'roomId' => 'Y2lzY29zcGFyazovL3VzL1JPT00vODU5NjU5ODAtZTI3YS0xMWU3LTk4YWUtODE0YTFlOTE1OWIx',
        'text' => "$text"
    );

//Encode the array into JSON.
    $jsonDataEncoded = json_encode($jsonData);

    $authorization = "Authorization: Bearer ZDQ4Nzg0NjUtNTM3Zi00YjhlLWIwNTEtOTMwMmZmYjlkOGUzNWIxYmM5NzYtYTY5";


    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', $authorization));
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
    $result = curl_exec($ch);
    //echo $result;
    curl_close($ch);
    return json_decode($result);

    echo "asd";
}
?>
