<?php
	require 'constants.php';
	$input = json_decode($_POST["x"], false);
	$sql = '';
    // Create connection
    $conn = new mysqli($db_server, $db_username, $db_password, $db_name);

    // check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $value = $input->value;
    $total = 0;
    switch ($value) {
    	case '1':
    		$sql = 'select workshop_id, count(*) as cnt from register_details group by workshop_id;';			
			$result = $conn->query($sql);

			if($result->num_rows > 0) {
				echo  "<table border='1' id=\"tblData\"><tr><td>workshop_id</td><td>count</td></tr>";
				while($row = $result->fetch_assoc()) {
					echo  "<tr><td> " . $row["workshop_id"] ."</td><td>" .$row["cnt"] . "</td></tr>";
					$total =  $total + $row['cnt'];
				}
				echo "<tr><td> TOTAL </td><td>" . $total . "</td>";
				echo "</table>";
			}
    		# code...
    		break;
    	case '2':
    		$sql = 'select workshop_id, college, count(*) as cnt from user_details,register_details where user_details.user_id = register_details.user_id group by workshop_id, college';
    		$result = $conn->query($sql);

			if($result->num_rows > 0) {
				echo  "<table border='1' id=\"tblData\"><tr><td>workshop_id</td><td>College name</td><td>count</td></tr>";				
				while($row = $result->fetch_assoc()) {
					echo  "<tr><td> " . $row["workshop_id"] ."</td><td>" . $row['college']  . "</td><td>" .$row["cnt"] . "</td></tr>";
					$total =  $total + $row['cnt'];
				}
				echo "</table>";
			}
    		# code...
    		break;
    	// Not yet finished
    	case '3':
    		$sql = 'select workshop_id, email_id,name,phone_number,college  from user_details, register_details where register_details.user_id = user_details.user_id';
    		$result = $conn->query($sql);

			if($result->num_rows > 0) {
				echo  "<table border='1' id=\"tblData\"><tr><td>workshop_id</td><td>Email</td><td>name</td><td>Phone number</td><td>College</td></tr>";				
				while($row = $result->fetch_assoc()) {
					echo  "<tr><td> " . $row["workshop_id"] ."</td><td>" . $row['email_id']  . "</td><td>" .$row["name"] . "</td><td>" .$row["phone_number"] . "</td><td>" .$row["college"] . "</td></tr>";
					$total =  $total + $row['cnt'];
				}
				echo "</table>";
			}
    		# code...
    		break;
    	case '4':
    		$sql = 'select name, email_id, phone_number, college from user_details where bought_entry = 1';
    		$result = $conn->query($sql);
			if($result->num_rows > 0) {
				echo  "<table border='1' id=\"tblData\"><tr><td>name</td><td>Email</td></td><td>phone_number</td><td>college</td></tr>";				
				while($row = $result->fetch_assoc()) {
					echo  "<tr><td> " . $row["name"] ."</td><td>" . $row['email_id']  . "</td><td>" .$row["phone_number"] . "</td><td>" .$row["college"] . "</td></tr>";
					
				}
				echo "</table>";
			}
    		# code...
    		break;
    	case '5':
    		$sql = 'select name, check_in, check_out, phone_number, email_id from user_details where check_in is NOT NULL and check_out is NOT NULL';
    		$result = $conn->query($sql);
			if($result->num_rows > 0) {
				echo  "<table border='1' id=\"tblData\"><tr><td>name</td><td>check_in</td><td>check_out</td><td>phone_number</td><td>Email</td></tr>";				
				while($row = $result->fetch_assoc()) {
					echo  "<tr><td> " . $row["name"] ."</td><td>" . $row['check_in']  . "</td><td>" .$row["check_out"] . "</td><td>" .$row["phone_number"] . "</td><td>" .$row["email_id"] . "</td></tr>";
					
				}
				echo "</table>";
			}
    		# code...
    		break;
    	default:
    		# code...
    		break;
    }
    echo "<button onclick=\"download('tblData')\">DOWNLOAD</button>";
?>