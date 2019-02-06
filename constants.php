<?php
    $domain = 'http://'.$_SERVER['SERVER_NAME'].'/prayatna-2019';
    $db_server = "localhost";
    $db_username = "student";
    $db_password = "student";
    $db_name = 'prayatna';

    function calculate_hash($user_id, $name, $email, $phone_number) {
        $secret_key = "";
        $signatureData = $user_id.$name.$email.$phone_number;
        $signature = hash_hmac('sha256', $signatureData, $secret_key,true);
        $signature = base64_encode($signature);
        return $signature;
    }
?>
