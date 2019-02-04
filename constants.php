<?php
    $db_server = "localhost";
    $db_username = "root";
    $db_password = "algorithm";
    $db_name = 'prayatna';

    function calculate_hash($user_id, $name, $email, $phone_number) {
        $secret_key = "";
        $signatureData = $user_id.$name.$email.$phone_number;
        $signature = hash_hmac('sha256', $signatureData, $secret_key,true);
        $signature = base64_encode($signature);
        return $signature;
    }
?>
