<?php
    if(!isset($_POST['submit'])) {
        header('Location: http://localhost/prayatna-2019/ajax_responses/invalid_request.php');
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

    $name = $_POST['name'];
    $password = $_POST['password'];
    $phone_number = $_POST['phone'];
    $email_id = $_POST['email'];
    $college = $_POST['college'];
    $year_of_study = $_POST['year'];

    // preventing injection attack using prepared statement
    $sql = 'INSERT INTO user_details (name, email_id, phone_number, password, college, year_of_study) VALUES (?, ?, ?, ?, ?, ?)';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $name, $email_id, $phone_number, $password, $college, $year_of_study);
    $result = $stmt->execute();

    // make the user login
    $sql = 'select user_id, name, email_id, phone_number from user_details where email_id = ? and password = ?';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email_id, $password);
    $result = $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        setcookie('user_id', $row['user_id'], time() + (86400 * 30), "/"); // 86400 = 1 day
        setcookie('name', $row['name'], time() + (86400 * 30), "/"); // 86400 = 1 day
        setcookie('email', $row['email_id'], time() + (86400 * 30), "/"); // 86400 = 1 day
        setcookie('phone', $row['phone_number'], time() + (86400 * 30), "/"); // 86400 = 1 day
        header('Location: http://localhost/prayatna-2019/dashboard.php');}
    else {
        echo 'failure';
    }
?>
