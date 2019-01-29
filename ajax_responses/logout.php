<?php
    //session_start();
    // set the expiration date to one hour ago
    //unset($_COOKIE["user_id"]);
    setcookie('user_id', '', time() - 3600, '/'); // 86400 = 1 day
    setcookie('name', '', time() - 3600, '/'); // 86400 = 1 day
    setcookie('email', '', time() - 3600, '/'); // 86400 = 1 day
    setcookie('phone', '', time() - 3600, '/'); // 86400 = 1 day
    header('Location: http://localhost/prayatna-2019/home.php');
?>
