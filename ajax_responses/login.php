<?php
    if(!isset($_POST['submit'])) {
        header('Location: http://localhost/prayatna-2019/home.php');
    }
    $servername = "localhost";
    $s_username = "student";
    $s_password = "student";
    $db_name = 'prayatna';

    // Create connection
    $conn = new mysqli($servername, $s_username, $s_password, $db_name);

    // check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $name = $_POST['email'];
    $password = $_POST['password'];
    // preventing injection attack using prepared statement
    $sql = 'select name, password from user_details where (name = ? or email_id = ?)and password = ?';


    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $name, $name, $password);
    $result = $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0) {
        $cookie_name = "user";
        $cookie_value = $name;
        setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
        header('Location: http://localhost/prayatna-2019/home.php');}
    else {
        echo 'failure';
    }
?>
