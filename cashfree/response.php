<?php
    if(strcasecmp($_SERVER['REQUEST_METHOD'], 'POST') != 0){
        header('Location: http://localhost/prayatna-2019/ajax_responses/invalid_request.php');
    }

    $secretkey = ""; // get from cashfree
    $orderId = $_POST["orderId"];
    $orderAmount = $_POST["orderAmount"];
    $referenceId = $_POST["referenceId"];
    $txStatus = $_POST["txStatus"];
    $paymentMode = $_POST["paymentMode"];
    $txMsg = $_POST["txMsg"];
    $txTime = $_POST["txTime"];
    $signature = $_POST["signature"];
    $data = $orderId.$orderAmount.$referenceId.$txStatus.$paymentMode.$txMsg.$txTime;
    $hash_hmac = hash_hmac('sha256', $data, $secretkey, true) ;
    $computedSignature = base64_encode($hash_hmac);

	function loadWorkshops($conn) {
        $sql = 'select workshop_id, price from workshop_details';
        $result = $conn->query($sql);
        $workshops = array();
        while ($row = $result->fetch_assoc()) {
        	$workshops[$row['workshop_id']] = $row['price'];
        }
        ksort($workshops);
        return $workshops;
    }

    if ($signature == $computedSignature) {
        if($txStatus == 'SUCCESS') {
            require '../constants.php';

            // Create connection
            $conn = new mysqli($db_server, $db_username, $db_password, $db_name);

            // check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $workshops = loadWorkshops($conn);

            $order = explode('_', $orderId);
            $user_id = $order[0];
            $purchases = $order[1];

            if($purchases == 1) {
                // Entry Ticket
                $sql = 'UPDATE user_details SET bought_entry = 1 WHERE user_id = ?';
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $user_id);
                $result = $stmt->execute();
            }
            else {
                // Workshops
                $index = 1;
                $sql_values = array();
                foreach($workshops as $key => $value)
                {
                    if(($purchases & (1 << $index)) != 0) {
                        array_push($sql_values, $key);
                        array_push($sql_values, $user_id);
                    }
                    $index = $index + 1;
                }
                $sql = 'INSERT INTO register_details (workshop_id, user_id) VALUES ';
                $placeholder = array_fill(0, count($sql_values) / 2, '(?, ?)');
                $placeholder = implode(', ', $placeholder);
                $stmt = $conn->prepare($sql . $placeholder);
                $stmt->bind_param(str_repeat('si', count($sql_values) / 2), ...$sql_values);
                $result = $stmt->execute();
            }
            $conn->close();
        }
        header('Location: http://localhost/prayatna-2019/dashboard.php');
    }
    else {
        header('Location: http://localhost/prayatna-2019/ajax_responses/invalid_request.php');
    }
?>
