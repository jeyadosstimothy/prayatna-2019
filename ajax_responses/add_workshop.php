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
// preventing injection attack using prepared statement
$sql = 'INSERT INTO register_details (workshop_id, user_id) VALUES (?, ?)';
$stmt = $conn->prepare($sql);
foreach($_POST['selectedWorkshop'] as $value)
{
    echo $value . ' ' . $_COOKIE['user_id'];
    $stmt->bind_param("si", $value, $_COOKIE['user_id']);
    $result = $stmt->execute();
}
header('Location: http://localhost/prayatna-2019/dashboard.php');
?>
