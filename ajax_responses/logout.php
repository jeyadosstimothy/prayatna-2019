<?php
    //session_start();
    // set the expiration date to one hour ago
    //unset($_COOKIE["user"]);
    echo $_COOKIE['user'];
    setcookie("user", "", time() - 3600, '/');
    header('Location: http://localhost/prayatna-2019/home.php');
?>
