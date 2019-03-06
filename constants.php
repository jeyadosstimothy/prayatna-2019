<?php
    $domain = 'http://'.$_SERVER['SERVER_NAME'].'/prayatna-2019';
    $db_server = "localhost";
    $db_username = "student";
    $db_password = "student";
    $db_name = 'prayatna';

    $seats = array(
        'artificial-intelligence' => 60,
        'cracking-the-coding-interview' => 100,
        'cyber-security' => 100,
        'flutter' => 60,
        'react-js' => 60,
        'system-design' => 60,
    );

    function calculate_hash($user_id, $name, $email, $phone_number) {
        $secret_key = "";
        $signatureData = $user_id.$name.$email.$phone_number;
        $signature = hash_hmac('sha256', $signatureData, $secret_key,true);
        $signature = base64_encode($signature);
        return $signature;
    }

    $connexionsStartTime = strtotime('2019-02-25 20:40');
    $connexionsEndTime = strtotime('2019-02-26 21:50');

    $onlinePaymentEndTime = strtotime('2019-02-26 21:20');

    $olpcStartTime = strtotime('2019-03-04 08:00');
    $olpcEndTime = strtotime('2019-03-04 11:00');
?>
