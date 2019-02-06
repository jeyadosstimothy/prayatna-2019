<?php
    require '../constants.php';

    if(!isset($_POST['submit'])) {
        header('Location: '.$domain.'/dashboard.php');
    }

    // Create connection
    $conn = new mysqli($db_server, $db_username, $db_password, $db_name);

    // check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $user_id = $_COOKIE['user_id'];
    $check_in = $_POST['check_in'];
    $check_out = $_POST['check_out'];

    // preventing injection attack using prepared statement
    $sql = 'UPDATE user_details set check_in = ?, check_out = ? WHERE user_id = ?';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $check_in, $check_out, $user_id);
    $result = $stmt->execute();

    $conn->close();

    header('Location: '.$domain.'/dashboard.php');
?>
