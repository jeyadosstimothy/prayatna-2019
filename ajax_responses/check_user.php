<?php
    header("Content-Type: application/json; charset=UTF-8");
    $input = json_decode($_POST["x"], false);

    $obj->user = "True";
    $obj->email = "True";
    $obj->contact = "True";

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
    $email_id = $input->email;
    $name = $input->name;
    $contact = $input->contact;
    // for checking
    // $email_id = 'akshayred@gmail.com';
    // $name = 'seri';
    // $contact = 'thanks';


    // preventing injection attack using prepared statement
    $sql = 'select * from user_details where email_id = ?';

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email_id);

    $result = $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0) {
        $obj->email = "False";
    }

    // preventing injection attack using prepared statement
    $sql = 'select * from user_details where name = ?';

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $name);

    $result = $stmt->execute();
    $result = $stmt->get_result();


    if($result->num_rows > 0) {
        $obj->user = "False";
    }


    // preventing injection attack using prepared statement
    $sql = 'select * from user_details where phone_number = ?';

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $contact);

    $result = $stmt->execute();
    $result = $stmt->get_result();


    if($result->num_rows > 0) {
        $obj->contact = "False";
    }
    $json_obj = json_encode($obj);
    echo $json_obj;
?>
