<?php

getToken();

function getToken() {
    $curl = curl_init();
    $auth_data = array(
        'client_id' => '4549727835d1c86eca99b38.15497558',
        'client_secret' => '203bfb377f957277c1d779a133519462f865b375',
        'grant_type' => 'client_credentials'
    );

    $url = 'https://api.f6s.com/oauth/token';
//HTTP username.
    $username = '!TaLEnt_wOrkS!';
//HTTP password.
    $password = '#geNiuS_#cReAteS@1';
    $headers = array('Content-Type: application/json',
        'Authorization: Basic ' . base64_encode("$username:$password")
    );
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $auth_data);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
//    curl_setopt($curl, CURLOPT_USERPWD, "!TaLEnt_wOrkS!:#geNiuS_#cReAteS@1");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    $result = curl_exec($curl);
    if (!$result) {
        die("Connection Failure");
    }
    curl_close($curl);
//    getDetails($result);
    echo $result;
//$ch = curl_init();
}

?>