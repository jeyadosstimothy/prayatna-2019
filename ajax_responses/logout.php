<?php
    //session_start();
    // set the expiration date to one hour ago
    //unset($_COOKIE["user_id"]);
    require '../https_redirect.php';
    require '../constants.php';

    setcookie('user_id', '', time() - 3600, '/');
    setcookie('name', '', time() - 3600, '/');
    setcookie('email', '', time() - 3600, '/');
    setcookie('phone', '', time() - 3600, '/');
    setcookie('signature', '', time() - 3600, '/');
    header('Location: '.$domain);
?>
